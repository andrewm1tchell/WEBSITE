<?php
/**
 * Collectors in the metadata cache
 *
 * Collections flagged collectorsFromMetadata in config.json are searched by wallet through
 * metadata-api.php instead of owners.php. Each token in cache/{id}_metadata.json then holds
 * a "collectors" list: the owner for ERC-721, or every holder of the edition for ERC-1155.
 *
 * cron-metadata.php adds collectors when it rewrites a cache, and cron-refresh-owners.php
 * keeps them current between those runs.
 */

// ERC-1155 contracts can't list a token's holders, so read them from the Blockscout indexer
function fetchTokenHolders($contract, $tokenId) {
    $holders = [];
    $query = '';

    do {
        $ch = curl_init("https://eth.blockscout.com/api/v2/tokens/{$contract}/instances/{$tokenId}/holders{$query}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'User-Agent: collection-metadata-fetcher'
        ]);
        $data = json_decode(curl_exec($ch), true);

        if (!isset($data['items'])) return null;

        foreach ($data['items'] as $item) {
            $holders[] = strtolower($item['address']['hash']);
        }

        $nextPage = $data['next_page_params'] ?? null;
        $query = $nextPage ? '?' . http_build_query($nextPage) : '';
    } while ($nextPage);

    return $holders;
}

// Set each token's collectors. Returns false, leaving tokens unchanged, if they can't be fetched.
function addCollectors($collection, &$tokens, $cachePath) {
    $collectors = [];

    if (!empty($collection['erc1155'])) {
        foreach ($tokens as $token) {
            $holders = fetchTokenHolders($collection['contract'], $token['tokenId']);
            if ($holders === null) return false;
            $collectors[$token['displayNum']] = $holders;
        }
    } else {
        // ERC-721 owners are already cached by cron-refresh-owners.php
        $ownersFile = $cachePath . '/owners_' . $collection['id'] . '.json';
        $ownersData = file_exists($ownersFile) ? json_decode(file_get_contents($ownersFile), true) : null;
        if (empty($ownersData['owners'])) return false;

        foreach ($ownersData['owners'] as $displayNum => $owner) {
            $collectors[$displayNum] = [$owner];
        }
    }

    foreach ($tokens as $index => $token) {
        $tokens[$index]['collectors'] = $collectors[$token['displayNum']] ?? [];
    }

    return true;
}

// Checks file times so the cron doesn't have to decode the whole metadata cache every cycle
function collectorsAreStale($collection, $cachePath, $maxAge) {
    $id = $collection['id'];
    $metadataFile = $cachePath . '/' . $id . '_metadata.json';
    if (!file_exists($metadataFile)) return true;

    if (!empty($collection['erc1155'])) {
        return time() - filemtime($metadataFile) >= $maxAge;
    }

    // ERC-721 collectors are copied from the owner cache, so follow its refreshes
    $ownersFile = $cachePath . '/owners_' . $id . '.json';
    return file_exists($ownersFile) && filemtime($ownersFile) >= filemtime($metadataFile);
}

// Update the collectors in a collection's metadata cache, creating the cache if needed
function refreshMetadataCollectors($collection, $cachePath) {
    $cacheFile = $cachePath . '/' . $collection['id'] . '_metadata.json';
    $cacheData = file_exists($cacheFile) ? json_decode(file_get_contents($cacheFile), true) : null;

    // Timestamp 0 leaves the token metadata itself due for cron-metadata.php
    if (empty($cacheData['tokens'])) {
        $tokenIdStart = $collection['tokenIdStart'] ?? 0;
        $tokenIds = $collection['tokenIds'] ?? range($tokenIdStart, $tokenIdStart + $collection['supply'] - 1);

        $tokens = [];
        foreach ($tokenIds as $index => $tokenId) {
            $tokens[] = [
                'tokenId' => $tokenId,
                'displayNum' => $index + 1,
                'attributes' => [],
                'image' => null,
            ];
        }

        $cacheData = [
            'timestamp' => 0,
            'collection' => $collection['id'],
            'name' => $collection['name'],
            'supply' => count($tokens),
            'tokens' => $tokens,
        ];
    }

    if (!addCollectors($collection, $cacheData['tokens'], $cachePath)) {
        return false;
    }

    // Rename into place so metadata-api.php never serves a half-written file
    $tempFile = $cacheFile . '.tmp';
    file_put_contents($tempFile, json_encode($cacheData));
    return rename($tempFile, $cacheFile);
}
