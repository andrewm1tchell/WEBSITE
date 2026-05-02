<?php
/**
 * Owner Cache Refresh (cPanel Cron)
 *
 * Runs once per invocation — checks every collection's cache and refreshes
 * any that are missing or stale (older than 24 hours). Designed to be called
 * by cPanel's cron scheduler (e.g. every 5 minutes).
 *
 * cPanel cron command:
 *   /usr/local/bin/php /home/mitchel/public_html/collections/cron-refresh-owners.php
 */

$scriptDir = __DIR__;
$configPath = $scriptDir . '/config.json';
$cachePath = $scriptDir . '/cache';
$maxCacheAge = 86400; // 24 hours — refresh if older than this
$delayBetween = 60;   // 60 seconds between individual collection refreshes

if (!is_dir($cachePath)) {
    mkdir($cachePath, 0755, true);
}

$logFile = $cachePath . '/cron.log';

// Immediately log that script was invoked (helps debug cPanel issues)
file_put_contents($logFile, "[" . date('Y-m-d H:i:s') . "] Script invoked.\n", FILE_APPEND | LOCK_EX);

function logMsg($msg) {
    global $logFile;
    $line = "[" . date('Y-m-d H:i:s') . "] " . $msg . "\n";
    file_put_contents($logFile, $line, FILE_APPEND | LOCK_EX);
}

// Prevent overlapping runs — if another instance is already refreshing, exit
$lockFile = $cachePath . '/cron.lock';
$lockFp = fopen($lockFile, 'w');
if (!flock($lockFp, LOCK_EX | LOCK_NB)) {
    logMsg("Another instance is already running. Exiting.");
    exit(0);
}

$cycleStart = microtime(true);
logMsg("Cron started.");

// Load config
$config = json_decode(file_get_contents($configPath), true);
if (!$config || !isset($config['collections'])) {
    logMsg("ERROR: Could not load config.json.");
    flock($lockFp, LOCK_UN);
    fclose($lockFp);
    exit(1);
}

$needsRefresh = [];

foreach ($config['collections'] as $collection) {
    $id = $collection['id'];

    // Skip multiContract collections — owners.php doesn't handle them
    if (!empty($collection['multiContract'])) {
        continue;
    }

    $cacheFile = $cachePath . '/owners_' . $id . '.json';

    if (!file_exists($cacheFile)) {
        $needsRefresh[] = $collection;
        continue;
    }

    $cacheData = json_decode(file_get_contents($cacheFile), true);
    if (!$cacheData || !isset($cacheData['timestamp']) || empty($cacheData['owners'])) {
        $needsRefresh[] = $collection;
        continue;
    }

    $age = time() - $cacheData['timestamp'];
    if ($age >= $maxCacheAge) {
        $needsRefresh[] = $collection;
    }
}

if (count($needsRefresh) === 0) {
    logMsg("All caches fresh. Nothing to do.");
    flock($lockFp, LOCK_UN);
    fclose($lockFp);
    exit(0);
}

logMsg(count($needsRefresh) . " collection(s) need refresh.");

// ============================================================================
// OWNER FETCHING FUNCTIONS (copied from owners.php to avoid HTTP 403 issues)
// ============================================================================

function fetchFxhashTokenIds($issuerId, $contract) {
    // Strategy 1: fxhash GraphQL API
    $fxhashUrl = "https://api.fxhash.xyz/graphql";
    $query = '{"query":"query { generativeToken(id: ' . intval($issuerId) . ') { entireCollection { onChainId } }}"}';
    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/json\r\nAccept: application/json\r\nUser-Agent: cron-refresh\r\n",
            'content' => $query,
            'timeout' => 30
        ]
    ]);
    $response = @file_get_contents($fxhashUrl, false, $context);
    if ($response !== false) {
        $data = json_decode($response, true);
        if (isset($data['data']['generativeToken']['entireCollection'])) {
            $tokenIds = [];
            foreach ($data['data']['generativeToken']['entireCollection'] as $item) {
                $tid = $item['onChainId'] ?? null;
                if ($tid !== null && intval($tid) > 0) {
                    $tokenIds[] = intval($tid);
                }
            }
            sort($tokenIds);
            if (count($tokenIds) > 0) {
                return $tokenIds;
            }
        }
    }

    // Strategy 2: TzKT metadata filter
    $filteredUrl = "https://api.tzkt.io/v1/tokens?contract={$contract}&metadata.issuer_id={$issuerId}&select.fields=tokenId&limit=10000";
    $context = stream_context_create([
        'http' => [
            'timeout' => 30,
            'header' => "Accept: application/json\r\nUser-Agent: cron-refresh\r\n"
        ]
    ]);
    $response = @file_get_contents($filteredUrl, false, $context);
    if ($response !== false) {
        $data = json_decode($response, true);
        if ($data && is_array($data) && count($data) > 0) {
            $tokenIdsFound = [];
            foreach ($data as $token) {
                if (is_array($token) && isset($token['tokenId'])) {
                    $tokenIdsFound[] = intval($token['tokenId']);
                } elseif (is_numeric($token)) {
                    $tokenIdsFound[] = intval($token);
                }
            }
            if (count($tokenIdsFound) > 0) {
                sort($tokenIdsFound);
                return $tokenIdsFound;
            }
        }
    }

    return null;
}

function fetchSingleOwnerEvm($rpcUrl, $contract, $tokenId, $maxRetries = 2) {
    $tokenIdHex = str_pad(dechex($tokenId), 64, '0', STR_PAD_LEFT);
    $call = [
        'jsonrpc' => '2.0',
        'id' => 1,
        'method' => 'eth_call',
        'params' => [
            ['to' => $contract, 'data' => '0x6352211e' . $tokenIdHex],
            'latest'
        ]
    ];

    for ($attempt = 0; $attempt < $maxRetries; $attempt++) {
        $ch = curl_init($rpcUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($call));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $response = curl_exec($ch);
        curl_close($ch);

        if ($response) {
            $result = json_decode($response, true);
            if (isset($result['result']) && strlen($result['result']) >= 66) {
                return '0x' . substr($result['result'], -40);
            }
        }
        usleep(500000);
    }
    return null;
}

function makeBatchRpcCall($rpcUrl, $calls, $maxRetries = 3) {
    $delay = 500000;
    for ($attempt = 0; $attempt < $maxRetries; $attempt++) {
        $ch = curl_init($rpcUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($calls));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($response) {
            $results = json_decode($response, true);
            if (is_array($results) && count($results) > 0) {
                $firstResult = $results[0];
                if (isset($firstResult['code']) && $firstResult['code'] === -32005) {
                    usleep($delay);
                    $delay *= 2;
                    continue;
                }
                if (isset($firstResult['id'])) {
                    return $results;
                }
            }
        }

        if ($httpCode === 429 || $httpCode >= 500) {
            usleep($delay);
            $delay *= 2;
            continue;
        }

        return null;
    }
    return null;
}

function refreshCollectionOwners($collection, $cachePath) {
    $chain = $collection['chain'];
    $contract = $collection['contract'] ?? '';
    $supply = $collection['supply'];
    $tokenIdStart = $collection['tokenIdStart'] ?? 0;
    $tokenIds = $collection['tokenIds'] ?? null;
    $collectionId = $collection['id'];

    // For fxhash Tezos collections, fetch token IDs dynamically
    if ($chain === 'tezos' && empty($tokenIds) && !empty($collection['issuer'])) {
        $fetchedIds = fetchFxhashTokenIds($collection['issuer'], $contract);
        if ($fetchedIds && count($fetchedIds) > 0) {
            $tokenIds = $fetchedIds;
            $supply = count($tokenIds);
        }
    }

    // Build token list
    if ($tokenIds) {
        $tokens = $tokenIds;
    } else {
        $tokens = range($tokenIdStart, $tokenIdStart + $supply - 1);
    }

    $owners = [];

    if ($chain === 'tezos') {
        // Fetch from TzKT API for Tezos
        foreach ($tokens as $index => $tokenId) {
            $displayNum = $index + 1;
            $url = "https://api.tzkt.io/v1/tokens/balances?token.contract={$contract}&token.tokenId={$tokenId}&balance.gt=0&limit=1";
            $response = @file_get_contents($url);
            if ($response !== false) {
                $holders = json_decode($response, true);
                if ($holders && count($holders) > 0) {
                    $owner = $holders[0]['account']['address'];
                    $owners[$displayNum] = $owner;
                }
            }
            if ($index % 5 === 4) {
                usleep(500000); // 500ms pause every 5 requests
            }
        }
    } else {
        // EVM chains (ethereum, arbitrum)
        $rpcEndpoints = [
            'ethereum' => [
                'https://eth.llamarpc.com',
                'https://rpc.ankr.com/eth',
                'https://ethereum.publicnode.com'
            ],
            'arbitrum' => [
                'https://arb1.arbitrum.io/rpc',
                'https://rpc.ankr.com/arbitrum'
            ]
        ];

        $rpcUrls = $rpcEndpoints[$chain] ?? null;
        if (!$rpcUrls) {
            return null;
        }

        $tokenLookup = [];
        foreach ($tokens as $index => $tokenId) {
            $displayNum = $index + 1;
            $tokenLookup[$tokenId] = $displayNum;
        }

        $batchSize = 15;
        $batches = array_chunk($tokens, $batchSize);
        $rpcIndex = 0;

        foreach ($batches as $batchIndex => $batch) {
            $calls = [];
            foreach ($batch as $tokenId) {
                $tokenIdHex = str_pad(dechex($tokenId), 64, '0', STR_PAD_LEFT);
                $calls[] = [
                    'jsonrpc' => '2.0',
                    'id' => $tokenId,
                    'method' => 'eth_call',
                    'params' => [
                        ['to' => $contract, 'data' => '0x6352211e' . $tokenIdHex],
                        'latest'
                    ]
                ];
            }

            $results = null;
            for ($i = 0; $i < count($rpcUrls); $i++) {
                $currentRpcIndex = ($rpcIndex + $i) % count($rpcUrls);
                $rpcUrl = $rpcUrls[$currentRpcIndex];
                $results = makeBatchRpcCall($rpcUrl, $calls);
                if ($results) {
                    $rpcIndex = $currentRpcIndex;
                    break;
                }
                usleep(300000);
            }

            if ($results && is_array($results)) {
                foreach ($results as $result) {
                    if (isset($result['id']) && isset($result['result']) && strlen($result['result']) >= 66) {
                        $tokenId = $result['id'];
                        $displayNum = $tokenLookup[$tokenId] ?? null;
                        if ($displayNum !== null) {
                            $ownerHex = '0x' . substr($result['result'], -40);
                            $owners[$displayNum] = $ownerHex;
                        }
                    }
                }
            }

            if ($batchIndex < count($batches) - 1) {
                sleep(1); // 1 second between batches
            }
        }

        // Fallback: fetch missing tokens individually
        $missingTokens = [];
        foreach ($tokens as $index => $tokenId) {
            $displayNum = $index + 1;
            if (!isset($owners[$displayNum])) {
                $missingTokens[$displayNum] = $tokenId;
            }
        }

        if (count($missingTokens) > 0 && count($missingTokens) < $supply) {
            $maxIndividualFetches = min(count($missingTokens), 100);
            $fetched = 0;
            foreach ($missingTokens as $displayNum => $tokenId) {
                if ($fetched >= $maxIndividualFetches) break;
                for ($i = 0; $i < count($rpcUrls); $i++) {
                    $rpcUrl = $rpcUrls[$i];
                    $owner = fetchSingleOwnerEvm($rpcUrl, $contract, $tokenId);
                    if ($owner) {
                        $owners[$displayNum] = $owner;
                        break;
                    }
                }
                $fetched++;
                usleep(500000); // 500ms between individual calls
            }
        }
    }

    // Save to cache
    $cacheData = [
        'timestamp' => time(),
        'collection' => $collectionId,
        'chain' => $chain,
        'contract' => $contract,
        'owners' => $owners
    ];

    $cacheFile = $cachePath . '/owners_' . $collectionId . '.json';
    file_put_contents($cacheFile, json_encode($cacheData));

    return $owners;
}

// ============================================================================
// MAIN LOOP
// ============================================================================

$success = 0;
$failed = 0;

foreach ($needsRefresh as $i => $collection) {
    $id = $collection['id'];
    $cacheFile = $cachePath . '/owners_' . $id . '.json';

    // Check age for logging
    $ageStr = 'missing';
    if (file_exists($cacheFile)) {
        $cacheData = json_decode(file_get_contents($cacheFile), true);
        if ($cacheData && isset($cacheData['timestamp'])) {
            $ageHours = round((time() - $cacheData['timestamp']) / 3600, 1);
            $ageStr = "{$ageHours}h old";
        }
    }

    logMsg("  " . ($i + 1) . "/" . count($needsRefresh) . " {$id} ({$ageStr}): refreshing...");

    try {
        $owners = refreshCollectionOwners($collection, $cachePath);
        if ($owners && count($owners) > 0) {
            $ownerCount = count($owners);
            logMsg("    {$id}: OK ({$ownerCount} owners)");
            $success++;
        } else {
            logMsg("    {$id}: FAILED - no owners returned");
            $failed++;
        }
    } catch (Exception $e) {
        logMsg("    {$id}: FAILED - " . $e->getMessage());
        $failed++;
    }

    // Delay between collections
    if ($i < count($needsRefresh) - 1) {
        sleep($delayBetween);
    }
}

$elapsed = round(microtime(true) - $cycleStart, 1);
logMsg("Done. {$success} refreshed, {$failed} failed. Took {$elapsed}s.");

// Release lock
flock($lockFp, LOCK_UN);
fclose($lockFp);
