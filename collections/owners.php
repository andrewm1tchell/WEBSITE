<?php
/**
 * Owner Cache API
 * Fetches and caches token owner data server-side
 *
 * Usage: owners.php?collection=nokori
 * Returns JSON with owner data for all tokens
 */

// Suppress ALL PHP errors/warnings from appearing in output (they break JSON)
error_reporting(0);
ini_set('display_errors', '0');
ini_set('html_errors', '0');

// Start output buffering to catch any stray output
ob_start();

// Clean any previous output and set headers
ob_end_clean();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$configPath = __DIR__ . '/config.json';
$cachePath = __DIR__ . '/cache';
$cacheExpiry = 172800; // 48 hours — cron refreshes daily, this is a generous fallback

// Ensure cache directory exists
if (!is_dir($cachePath)) {
    mkdir($cachePath, 0755, true);
}

// Load config
$config = json_decode(file_get_contents($configPath), true);
if (!$config) {
    http_response_code(500);
    echo json_encode(['error' => 'Could not load config']);
    exit;
}

// Get collection ID from query
$collectionId = $_GET['collection'] ?? null;
if (!$collectionId) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing collection parameter']);
    exit;
}

// Allow cron to force a fresh fetch by passing &refresh=1
$forceRefresh = isset($_GET['refresh']) && $_GET['refresh'] === '1';

// Find collection in config
$collection = null;
foreach ($config['collections'] as $c) {
    if ($c['id'] === $collectionId) {
        $collection = $c;
        break;
    }
}

if (!$collection) {
    http_response_code(404);
    echo json_encode(['error' => 'Collection not found']);
    exit;
}

// ERC-1155 contracts don't support ownerOf — return empty owners
if (!empty($collection['erc1155'])) {
    echo json_encode(['owners' => (object)[], 'erc1155' => true]);
    exit;
}

$cacheFile = $cachePath . '/owners_' . $collectionId . '.json';

// Check if we have ANY cache (even if expired)
if (file_exists($cacheFile) && !$forceRefresh) {
    $cacheData = json_decode(file_get_contents($cacheFile), true);
    if ($cacheData && isset($cacheData['timestamp']) && !empty($cacheData['owners'])) {
        $age = time() - $cacheData['timestamp'];
        // Always serve existing cache to avoid making users wait.
        // The cron job refreshes this daily in the background.
        // Only truly refuse cache if it's older than the expiry AND has no data.
        $cacheData['cached'] = true;
        $cacheData['age'] = $age;
        $cacheData['stale'] = ($age >= $cacheExpiry);
        echo json_encode($cacheData);
        exit;
    }
}

// Need to fetch fresh data
$chain = $collection['chain'];
$contract = $collection['contract'] ?? '';
$supply = $collection['supply'];
$tokenIdStart = $collection['tokenIdStart'] ?? 0;
$tokenIds = $collection['tokenIds'] ?? null;

// If this is an fxhash collection on Tezos and we don't have tokenIds in config,
// attempt to fetch the token IDs using the issuer field (same logic as generate.php)
if ($chain === 'tezos' && empty($tokenIds) && !empty($collection['issuer'])) {
    // Helper to fetch fxhash token IDs via fxhash GraphQL or TzKT
    function fetchFxhashTokenIdsLocal($issuerId, $contract) {
        // Strategy 1: fxhash GraphQL API — most reliable for fxhash collections
        // Uses onChainId which is the actual Tezos token ID
        $fxhashUrl = "https://api.fxhash.xyz/graphql";
        $query = '{"query":"query { generativeToken(id: ' . intval($issuerId) . ') { entireCollection { onChainId } }}"}';
        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => "Content-Type: application/json\r\nAccept: application/json\r\nUser-Agent: owners.php\r\n",
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

        // Strategy 2: TzKT metadata filter (for contracts that store issuer_id)
        $filteredUrl = "https://api.tzkt.io/v1/tokens?contract={$contract}&metadata.issuer_id={$issuerId}&select.fields=tokenId&limit=10000";
        $context = stream_context_create([
            'http' => [
                'timeout' => 30,
                'header' => "Accept: application/json\r\nUser-Agent: owners.php\r\n"
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

    $fetchedIds = fetchFxhashTokenIdsLocal($collection['issuer'], $contract);
    if ($fetchedIds && count($fetchedIds) > 0) {
        $tokenIds = $fetchedIds;
        // Keep supply consistent with fetched token count
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

        // Rate limiting - be nice to the API
        if ($index % 10 === 9) {
            usleep(100000); // 100ms pause every 10 requests
        }
    }
} else {
    // Use multiple RPC endpoints with fallbacks
    $rpcEndpoints = [
        'ethereum' => [
            'https://eth.llamarpc.com',
            'https://rpc.ankr.com/eth',
            'https://ethereum.publicnode.com',
            'https://mainnet.infura.io/v3/7c722c5d30fb4872879a308ddecf01cd'
        ],
        'arbitrum' => [
            'https://arb1.arbitrum.io/rpc',
            'https://rpc.ankr.com/arbitrum'
        ]
    ];

    $rpcUrls = $rpcEndpoints[$chain] ?? null;
    if (!$rpcUrls) {
        http_response_code(500);
        echo json_encode(['error' => 'No RPC URLs for chain: ' . $chain]);
        exit;
    }

    // Helper function to make a single ownerOf call
    function fetchSingleOwner($rpcUrl, $contract, $tokenId, $maxRetries = 2) {
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

            if ($response) {
                $result = json_decode($response, true);
                if (isset($result['result']) && strlen($result['result']) >= 66) {
                    return '0x' . substr($result['result'], -40);
                }
            }
            usleep(500000); // 500ms between retries
        }
        return null;
    }

    // Helper function to make batch RPC call with retry logic
    function makeBatchRpcCall($rpcUrl, $calls, $maxRetries = 3) {
        $delay = 500000; // Start with 500ms delay
        for ($attempt = 0; $attempt < $maxRetries; $attempt++) {
            $ch = curl_init($rpcUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($calls));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if ($response) {
                $results = json_decode($response, true);
                // Check if rate limited (no 'id' field or error code)
                if (is_array($results) && count($results) > 0) {
                    $firstResult = $results[0];
                    if (isset($firstResult['code']) && $firstResult['code'] === -32005) {
                        // Rate limited, retry with backoff
                        usleep($delay);
                        $delay *= 2;
                        continue;
                    }
                    // Check if all results have 'id' (not error responses)
                    if (isset($firstResult['id'])) {
                        return $results;
                    }
                }
            }

            // HTTP error or invalid response, retry
            if ($httpCode === 429 || $httpCode >= 500) {
                usleep($delay);
                $delay *= 2;
                continue;
            }

            // Other error, return null to try next endpoint
            return null;
        }
        return null;
    }

    // Build token lookup: tokenId => displayNum
    $tokenLookup = [];
    foreach ($tokens as $index => $tokenId) {
        $displayNum = $index + 1;
        $tokenLookup[$tokenId] = $displayNum;
    }

    // Batch RPC calls for efficiency (smaller batches)
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

        // Try each RPC endpoint
        $results = null;
        for ($i = 0; $i < count($rpcUrls); $i++) {
            $currentRpcIndex = ($rpcIndex + $i) % count($rpcUrls);
            $rpcUrl = $rpcUrls[$currentRpcIndex];
            $results = makeBatchRpcCall($rpcUrl, $calls);
            if ($results) {
                $rpcIndex = $currentRpcIndex; // Stick with working endpoint
                break;
            }
            usleep(300000); // 300ms between endpoint attempts
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

        // Delay between batches
        if ($batchIndex < count($batches) - 1) {
            usleep(400000); // 400ms between batches
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
        // Only do individual fetches if we have a reasonable number missing
        // and we already got some tokens (meaning the RPC is working)
        $maxIndividualFetches = min(count($missingTokens), 100);
        $fetched = 0;

        foreach ($missingTokens as $displayNum => $tokenId) {
            if ($fetched >= $maxIndividualFetches) break;

            // Try each RPC endpoint for individual fetch
            for ($i = 0; $i < count($rpcUrls); $i++) {
                $rpcUrl = $rpcUrls[$i];
                $owner = fetchSingleOwner($rpcUrl, $contract, $tokenId);
                if ($owner) {
                    $owners[$displayNum] = $owner;
                    break;
                }
            }
            $fetched++;
            usleep(200000); // 200ms between individual calls
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

file_put_contents($cacheFile, json_encode($cacheData));

$cacheData['cached'] = false;
$cacheData['age'] = 0;
echo json_encode($cacheData);

