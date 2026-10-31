<?php
/**
 * Nokori Metadata API
 * Fetches and caches all 401 token metadata (including traits) from the blockchain.
 *
 * Usage: nokori-metadata.php
 * Returns JSON: { timestamp, tokens: [ { tokenId, displayNum, name, description, attributes: [...], image } ] }
 */

error_reporting(0);
ini_set('display_errors', '0');
set_time_limit(600); // 10 minutes for initial fetch of all 401 tokens
ini_set('max_execution_time', 600);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/rpc.php';

$cachePath = __DIR__ . '/cache';
$cacheFile = $cachePath . '/nokori_metadata.json';
$cacheExpiry = 604800; // 7 days — metadata doesn't change

if (!is_dir($cachePath)) {
    mkdir($cachePath, 0755, true);
}

// Check cache
if (file_exists($cacheFile)) {
    $cacheData = json_decode(file_get_contents($cacheFile), true);
    if ($cacheData && isset($cacheData['timestamp'])) {
        $age = time() - $cacheData['timestamp'];
        if ($age < $cacheExpiry && !empty($cacheData['tokens']) && count($cacheData['tokens']) >= 400) {
            echo file_get_contents($cacheFile);
            exit;
        }
    }
}

// Need to fetch metadata from chain
$contract = '0xF12A9C99f73ca203ec3B956E479a9E8F615C8e5F';
$supply = 401;
$tokenIdStart = 1;

$rpcUrls = [
    'https://eth.llamarpc.com',
    'https://rpc.ankr.com/eth',
    'https://ethereum.publicnode.com',
    get_rpc_url('ethereum')
];

// tokenURI(uint256) selector = 0xc87b56dd
function fetchTokenURI($rpcUrl, $contract, $tokenId) {
    $tokenIdHex = str_pad(dechex($tokenId), 64, '0', STR_PAD_LEFT);
    $call = [
        'jsonrpc' => '2.0',
        'id' => $tokenId,
        'method' => 'eth_call',
        'params' => [
            ['to' => $contract, 'data' => '0xc87b56dd' . $tokenIdHex],
            'latest'
        ]
    ];

    $ch = curl_init($rpcUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($call));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $response = curl_exec($ch);
    curl_close($ch);

    if (!$response) return null;
    $result = json_decode($response, true);
    if (!isset($result['result'])) return null;

    // Decode the ABI-encoded string
    $hex = $result['result'];
    if (strlen($hex) < 130) return null; // Too short

    // Remove 0x prefix
    $hex = substr($hex, 2);
    // First 32 bytes = offset to string data
    // Next 32 bytes = string length
    $strLenHex = substr($hex, 64, 64);
    $strLen = hexdec($strLenHex);
    if ($strLen <= 0 || $strLen > 100000) return null;
    // String data starts at byte 96
    $strHex = substr($hex, 128, $strLen * 2);
    $uri = '';
    for ($i = 0; $i < strlen($strHex); $i += 2) {
        $uri .= chr(hexdec(substr($strHex, $i, 2)));
    }

    return $uri;
}

function fetchMetadataFromURI($uri) {
    // Handle base64 encoded JSON
    if (strpos($uri, 'data:application/json;base64,') === 0) {
        $base64 = str_replace('data:application/json;base64,', '', $uri);
        return json_decode(base64_decode($base64), true);
    }
    // Handle data URI JSON
    if (strpos($uri, 'data:application/json,') === 0) {
        $json = urldecode(str_replace('data:application/json,', '', $uri));
        return json_decode($json, true);
    }

    // Convert IPFS
    if (strpos($uri, 'ipfs://') === 0) {
        $uri = str_replace('ipfs://', get_ipfs_gateway(), $uri);
    }
    // Convert Arweave
    if (strpos($uri, 'ar://') === 0) {
        $uri = str_replace('ar://', 'https://arweave.net/', $uri);
    }

    $context = stream_context_create([
        'http' => [
            'timeout' => 30,
            'header' => "Accept: application/json\r\nUser-Agent: nokori-metadata-fetcher\r\n"
        ]
    ]);
    $response = @file_get_contents($uri, false, $context);
    if ($response === false) return null;
    return json_decode($response, true);
}

// Batch fetch tokenURIs using JSON-RPC batch calls
function batchFetchTokenURIs($rpcUrl, $contract, $tokenIds) {
    $calls = [];
    foreach ($tokenIds as $tokenId) {
        $tokenIdHex = str_pad(dechex($tokenId), 64, '0', STR_PAD_LEFT);
        $calls[] = [
            'jsonrpc' => '2.0',
            'id' => $tokenId,
            'method' => 'eth_call',
            'params' => [
                ['to' => $contract, 'data' => '0xc87b56dd' . $tokenIdHex],
                'latest'
            ]
        ];
    }

    $ch = curl_init($rpcUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($calls));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    $response = curl_exec($ch);
    curl_close($ch);

    if (!$response) return [];
    $results = json_decode($response, true);
    if (!is_array($results)) return [];

    $uris = [];
    foreach ($results as $result) {
        if (!isset($result['id']) || !isset($result['result'])) continue;
        $hex = $result['result'];
        if (strlen($hex) < 130) continue;

        $hex = substr($hex, 2);
        $strLenHex = substr($hex, 64, 64);
        $strLen = hexdec($strLenHex);
        if ($strLen <= 0 || $strLen > 100000) continue;
        $strHex = substr($hex, 128, $strLen * 2);
        $uri = '';
        for ($i = 0; $i < strlen($strHex); $i += 2) {
            $uri .= chr(hexdec(substr($strHex, $i, 2)));
        }
        $uris[$result['id']] = $uri;
    }
    return $uris;
}

// Main: fetch all token metadata
$allTokens = [];
$tokenIds = range($tokenIdStart, $tokenIdStart + $supply - 1);
$batchSize = 10;
$batches = array_chunk($tokenIds, $batchSize);
$rpcIndex = 0;

foreach ($batches as $batchIndex => $batch) {
    $uris = [];

    // Try each RPC until one works
    for ($r = 0; $r < count($rpcUrls); $r++) {
        $rpc = $rpcUrls[($rpcIndex + $r) % count($rpcUrls)];
        $uris = batchFetchTokenURIs($rpc, $contract, $batch);
        if (!empty($uris)) {
            $rpcIndex = ($rpcIndex + $r) % count($rpcUrls);
            break;
        }
        usleep(500000);
    }

    // Fetch metadata for each URI
    foreach ($batch as $tokenId) {
        $displayNum = $tokenId - $tokenIdStart + 1;
        if (!isset($uris[$tokenId])) {
            $allTokens[] = [
                'tokenId' => $tokenId,
                'displayNum' => $displayNum,
                'name' => 'Nokori #' . $displayNum,
                'attributes' => []
            ];
            continue;
        }

        $metadata = fetchMetadataFromURI($uris[$tokenId]);
        if (!$metadata) {
            $allTokens[] = [
                'tokenId' => $tokenId,
                'displayNum' => $displayNum,
                'name' => 'Nokori #' . $displayNum,
                'attributes' => []
            ];
            continue;
        }

        $allTokens[] = [
            'tokenId' => $tokenId,
            'displayNum' => $displayNum,
            'name' => $metadata['name'] ?? ('Nokori #' . $displayNum),
            'description' => $metadata['description'] ?? '',
            'attributes' => $metadata['attributes'] ?? [],
            'image' => $metadata['image'] ?? null
        ];
    }

    // Pause between batches
    if ($batchIndex < count($batches) - 1) {
        usleep(300000); // 300ms
    }
}

// Save to cache
$cacheData = [
    'timestamp' => time(),
    'collection' => 'nokori',
    'supply' => $supply,
    'tokens' => $allTokens
];

file_put_contents($cacheFile, json_encode($cacheData));
echo json_encode($cacheData);

