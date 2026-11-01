<?php
/**
 * Universal Metadata Cron Job
 * Fetches and caches token metadata + downloads thumbnail images for ALL collections.
 *
 * Usage:
 *   php cron-metadata.php                  — process all collections
 *   php cron-metadata.php nokori           — process single collection
 *   php cron-metadata.php --force nokori   — force re-fetch even if cache is fresh
 *
 * For each collection:
 *   1. Fetches token metadata (tokenURI for EVM, TzKT/fxhash for Tezos)
 *   2. Downloads images and creates compressed 400px JPEG thumbnails
 *   3. Saves cache/{collectionId}_metadata.json
 *
 * Thumbnails: /images/grid-thumbs/{collectionId}/{displayNum}.jpg
 */

error_reporting(E_ALL);
ini_set('display_errors', '1');
set_time_limit(3600); // 1 hour max
ini_set('max_execution_time', 3600);
ini_set('memory_limit', '512M');

$baseDir = dirname(__DIR__);
$cachePath = __DIR__ . '/cache';
$thumbBaseDir = $baseDir . '/images/grid-thumbs';
$configPath = __DIR__ . '/config.json';

require_once __DIR__ . '/collectors.php';
require_once __DIR__ . '/rpc.php';

$config = json_decode(file_get_contents($configPath), true);
if (!$config) {
    die("Error: Could not load config.json\n");
}

if (!is_dir($cachePath)) {
    mkdir($cachePath, 0755, true);
}

// Parse arguments
$args = array_slice($argv ?? [], 1);
$forceRefresh = false;
$targetCollection = null;

foreach ($args as $arg) {
    if ($arg === '--force') {
        $forceRefresh = true;
    } else {
        $targetCollection = $arg;
    }
}

$cacheExpiry = 604800; // 7 days
$minGridSupply = 5; // Skip collections with supply < 5

// Collections to skip for grid (popup excluded per requirements)
$skipGrid = ['popup'];

// RPC URLs from config + fallbacks
$rpcUrls = [
    'ethereum' => [
        $config['rpc']['ethereum'] ?? 'https://eth.llamarpc.com',
        'https://eth.llamarpc.com',
        'https://rpc.ankr.com/eth',
        'https://ethereum.publicnode.com',
    ],
    'arbitrum' => [
        $config['rpc']['arbitrum'] ?? 'https://arb-mainnet.g.alchemy.com/v2/demo',
        'https://arb1.arbitrum.io/rpc',
        'https://arbitrum.publicnode.com',
    ],
];

// Local image source map (folder name => collection config ID)
// Used when local images exist but metadata still needs to be fetched
$localImageMap = [
    'nokori' => ['path' => '/images/collections/nokori', 'ext' => 'jpg', 'naming' => 'numeric', 'start' => 1],
    'sky-meadow' => ['path' => '/images/collections/skymeadow', 'ext' => 'png', 'naming' => 'numeric', 'start' => 1],
    'primera' => ['path' => '/images/collections/primera', 'ext' => 'png', 'naming' => 'numeric', 'start' => 0],
    'memory-loss' => ['path' => '/images/collections/memoryloss', 'ext' => 'png', 'naming' => 'zero-padded-3', 'start' => 0],
    'flowers-of-alfiren' => ['path' => '/images/collections/flowersofalfiren', 'ext' => 'png', 'naming' => 'numeric', 'start' => 1],
    'butterfly-pact' => ['path' => '/images/collections/butterfly-pact', 'ext' => 'png', 'naming' => 'numeric', 'start' => 0],
];

// ============ Helper Functions ============

function logMsg($msg) {
    $time = date('H:i:s');
    echo "[{$time}] {$msg}\n";
    flush();
}

function decodeABIString($hex) {
    if (strlen($hex) < 130) return null;
    $hex = substr($hex, 2); // remove 0x
    $strLenHex = substr($hex, 64, 64);
    $strLen = hexdec($strLenHex);
    if ($strLen <= 0 || $strLen > 1000000) return null; // 1MB max for on-chain art
    $strHex = substr($hex, 128, $strLen * 2);
    $uri = '';
    for ($i = 0; $i < strlen($strHex); $i += 2) {
        $uri .= chr(hexdec(substr($strHex, $i, 2)));
    }
    return $uri;
}

// Fetch a single tokenURI (fallback for large on-chain data that fails in batch)
function singleFetchTokenURI($rpcUrl, $contract, $tokenId) {
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
    curl_setopt($ch, CURLOPT_TIMEOUT, 120); // 2 min timeout for large on-chain data
    $response = curl_exec($ch);

    if (!$response) return null;
    $result = json_decode($response, true);
    if (!isset($result['result'])) return null;

    return decodeABIString($result['result']);
}

// Fetch multiple tokenURIs in a single batched JSON-RPC request
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
    curl_setopt($ch, CURLOPT_TIMEOUT, 120); // 2 min timeout for large on-chain data
    $response = curl_exec($ch);
    curl_close($ch);

    if (!$response) return [];
    $results = json_decode($response, true);
    if (!is_array($results)) return [];

    $uris = [];
    foreach ($results as $result) {
        if (!isset($result['id']) || !isset($result['result'])) continue;
        $decoded = decodeABIString($result['result']);
        if ($decoded) {
            $uris[$result['id']] = $decoded;
        }
    }
    return $uris;
}

function fetchMetadataFromURI($uri) {
    // Handle base64 encoded JSON
    if (strpos($uri, 'data:application/json;base64,') === 0) {
        $base64 = str_replace('data:application/json;base64,', '', $uri);
        return json_decode(base64_decode($base64), true);
    }
    if (strpos($uri, 'data:application/json,') === 0) {
        $json = urldecode(str_replace('data:application/json,', '', $uri));
        return json_decode($json, true);
    }

    $fetchUri = $uri;
    if (strpos($uri, 'ipfs://') === 0) {
        $fetchUri = str_replace('ipfs://', get_ipfs_gateway(), $uri);
    }
    if (strpos($uri, 'ar://') === 0) {
        $fetchUri = str_replace('ar://', 'https://arweave.net/', $uri);
    }

    $ch = curl_init($fetchUri);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'User-Agent: collection-metadata-fetcher'
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($response === false || $httpCode >= 400) return null;
    return json_decode($response, true);
}

function resolveImageUrl($url) {
    if (!$url) return null;
    if (strpos($url, 'ipfs://') === 0) {
        return str_replace('ipfs://', get_ipfs_gateway(), $url);
    }
    if (strpos($url, 'ar://') === 0) {
        return str_replace('ar://', 'https://arweave.net/', $url);
    }
    return $url;
}

function downloadAndCreateThumb($imageUrl, $outputFile) {
    if (file_exists($outputFile)) return true; // Already exists

    $resolvedUrl = resolveImageUrl($imageUrl);
    if (!$resolvedUrl) return false;

    // Download image
    $ch = curl_init($resolvedUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'User-Agent: collection-thumbnail-fetcher'
    ]);
    $imageData = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($imageData === false || $httpCode >= 400 || strlen($imageData) < 100) return false;

    return createThumbFromData($imageData, $outputFile);
}

function createThumbFromFile($sourceFile, $outputFile) {
    if (file_exists($outputFile)) return true;
    if (!file_exists($sourceFile)) return false;

    $imageData = file_get_contents($sourceFile);
    if ($imageData === false) return false;

    return createThumbFromData($imageData, $outputFile);
}

function createThumbFromData($imageData, $outputFile) {
    $srcImage = @imagecreatefromstring($imageData);
    if (!$srcImage) return false;

    $origW = imagesx($srcImage);
    $origH = imagesy($srcImage);
    $maxDim = 400;

    if ($origW > $maxDim || $origH > $maxDim) {
        if ($origW >= $origH) {
            $newW = $maxDim;
            $newH = max(1, (int)round($origH * ($maxDim / $origW)));
        } else {
            $newH = $maxDim;
            $newW = max(1, (int)round($origW * ($maxDim / $origH)));
        }
    } else {
        $newW = $origW;
        $newH = $origH;
    }

    $thumbImage = imagecreatetruecolor($newW, $newH);
    $white = imagecolorallocate($thumbImage, 255, 255, 255);
    imagefill($thumbImage, 0, 0, $white);
    imagecopyresampled($thumbImage, $srcImage, 0, 0, 0, 0, $newW, $newH, $origW, $origH);
    imagejpeg($thumbImage, $outputFile, 85);
    imagedestroy($srcImage);
    imagedestroy($thumbImage);

    return true;
}

function getLocalSourceFile($collectionId, $sourceIndex, $localImageMap, $baseDir) {
    $maxDim = 600;

    $source = $localImageMap[$collectionId];
    $sourcePath = $baseDir . $source['path'];
    $sourceNum = $source['start'] + $sourceIndex;

    switch ($source['naming']) {
        case 'zero-padded-3':
            $file = $sourcePath . '/' . str_pad($sourceNum, 3, '0', STR_PAD_LEFT) . '.' . $source['ext'];
            break;
        case 'numeric':
        default:
            $file = $sourcePath . '/' . $sourceNum . '.' . $source['ext'];
            break;
    }

    return file_exists($file) ? $file : null;
}

function fetchEVMMetadata($collection, $rpcUrls, $chain) {
    $contract = $collection['contract'];
    $supply = $collection['supply'];
    $tokenIdStart = $collection['tokenIdStart'] ?? 0;
    $tokenIds = $collection['tokenIds'] ?? null;
    $collectionName = $collection['name'];

    $ids = $tokenIds ?? range($tokenIdStart, $tokenIdStart + $supply - 1);
    $allTokens = [];

    $hasOnChainArt = isset($collection['features']['staticImage']) && $collection['features']['staticImage'];
    // Use smaller batches for collections with large on-chain data
    $batchSize = $hasOnChainArt ? 2 : 10;
    $batches = array_chunk($ids, $batchSize);
    $chainRpcs = $rpcUrls[$chain] ?? $rpcUrls['ethereum'];

    foreach ($batches as $batchIndex => $batch) {
        $uris = [];

        // Try batch fetch first
        foreach ($chainRpcs as $rpc) {
            $uris = batchFetchTokenURIs($rpc, $contract, $batch);
            if (!empty($uris)) break;
            usleep(500000);
        }

        // Fetch metadata for each URI, with single-fetch fallback
        foreach ($batch as $index => $tokenId) {
            $overallIndex = $batchIndex * $batchSize + $index;
            $displayNum = $overallIndex + 1;

            // If batch didn't get this token's URI, try single fetch
            if (!isset($uris[$tokenId])) {
                foreach ($chainRpcs as $rpc) {
                    $singleUri = singleFetchTokenURI($rpc, $contract, $tokenId);
                    if ($singleUri) {
                        $uris[$tokenId] = $singleUri;
                        break;
                    }
                    usleep(300000);
                }
            }

            if (!isset($uris[$tokenId])) {
                logMsg("  WARNING: Could not fetch tokenURI for token {$tokenId} (display #{$displayNum})");
                $allTokens[] = [
                    'tokenId' => $tokenId,
                    'displayNum' => $displayNum,
                    'attributes' => [],
                    'image' => null,
                ];
                continue;
            }

            $metadata = fetchMetadataFromURI($uris[$tokenId]);
            if (!$metadata) {
                logMsg("  WARNING: Could not parse metadata for token {$tokenId} (display #{$displayNum})");
                $allTokens[] = [
                    'tokenId' => $tokenId,
                    'displayNum' => $displayNum,
                    'attributes' => [],
                    'image' => null,
                ];
                continue;
            }

            $allTokens[] = [
                'tokenId' => $tokenId,
                'displayNum' => $displayNum,
                'name' => $metadata['name'] ?? ($collectionName . ' #' . $displayNum),
                'description' => $metadata['description'] ?? '',
                'attributes' => $metadata['attributes'] ?? [],
                'image' => $metadata['image'] ?? $metadata['image_url'] ?? null,
            ];
        }

        // Progress log
        $done = min(($batchIndex + 1) * $batchSize, count($ids));
        if ($done % 50 < $batchSize || $batchIndex == count($batches) - 1) {
            $withAttrs = count(array_filter($allTokens, fn($t) => !empty($t['attributes'])));
            logMsg("  Fetched metadata for {$done}/" . count($ids) . " tokens ({$withAttrs} with attributes)");
        }
    }

    return $allTokens;
}

// ============ EVM Multi-Contract Metadata Fetcher ============

function fetchEVMMultiContractMetadata($collection, $rpcUrls) {
    $contracts = $collection['contracts'];
    $collectionName = $collection['name'];
    $chainRpcs = $rpcUrls['ethereum'];

    $allTokens = [];
    $displayNum = 0;

    foreach ($contracts as $contractInfo) {
        $contract = $contractInfo['contract'];
        $tokenIds = $contractInfo['tokenIds'];

        $batches = array_chunk($tokenIds, 10);

        foreach ($batches as $batch) {
            $uris = [];
            foreach ($chainRpcs as $rpc) {
                $uris = batchFetchTokenURIs($rpc, $contract, $batch);
                if (!empty($uris)) break;
                usleep(500000);
            }

            foreach ($batch as $tokenId) {
                $displayNum++;

                if (!isset($uris[$tokenId])) {
                    $allTokens[] = [
                        'tokenId' => $tokenId,
                        'contract' => $contract,
                        'displayNum' => $displayNum,
                        'name' => $collectionName . ' #' . $displayNum,
                        'attributes' => [],
                        'image' => null,
                    ];
                    continue;
                }

                $metadata = fetchMetadataFromURI($uris[$tokenId]);
                if (!$metadata) {
                    $allTokens[] = [
                        'tokenId' => $tokenId,
                        'contract' => $contract,
                        'displayNum' => $displayNum,
                        'name' => $collectionName . ' #' . $displayNum,
                        'attributes' => [],
                        'image' => null,
                    ];
                    continue;
                }

                $allTokens[] = [
                    'tokenId' => $tokenId,
                    'contract' => $contract,
                    'displayNum' => $displayNum,
                    'name' => $metadata['name'] ?? ($collectionName . ' #' . $displayNum),
                    'description' => $metadata['description'] ?? '',
                    'attributes' => $metadata['attributes'] ?? [],
                    'image' => $metadata['image'] ?? $metadata['image_url'] ?? null,
                ];

                usleep(500000);
            }

            usleep(300000);
        }
    }

    return $allTokens;
}

// ============ Tezos Metadata Fetcher ============

function fetchTezosMetadata($collection) {
    $contract = $collection['contract'];
    $supply = $collection['supply'];
    $tokenIdStart = $collection['tokenIdStart'] ?? 0;
    $tokenIds = $collection['tokenIds'] ?? null;
    $collectionName = $collection['name'];
    $platform = $collection['platform'] ?? null;
    $issuer = $collection['issuer'] ?? null;

    // For fxhash collections, we may need to discover token IDs
    if ($platform === 'fxhash' && $issuer && !$tokenIds) {
        $tokenIds = fetchFxhashTokenIds($issuer, $contract);
        if ($tokenIds) {
            $supply = count($tokenIds);
        }
    }

    $ids = $tokenIds ?? range($tokenIdStart, $tokenIdStart + $supply - 1);
    $allTokens = [];

    // Fetch tokens in batches from TzKT
    $batchSize = 50;
    $batches = array_chunk($ids, $batchSize);

    foreach ($batches as $batchIndex => $batch) {
        foreach ($batch as $index => $tokenId) {
            $overallIndex = $batchIndex * $batchSize + $index;
            $displayNum = $overallIndex + 1;

            $url = "https://api.tzkt.io/v1/tokens?contract={$contract}&tokenId={$tokenId}&limit=1";
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Accept: application/json',
                'User-Agent: collection-metadata-fetcher'
            ]);
            $response = curl_exec($ch);

            $tokens = json_decode($response, true);

            if (!$tokens || !is_array($tokens) || count($tokens) === 0) {
                $allTokens[] = [
                    'tokenId' => $tokenId,
                    'displayNum' => $displayNum,
                    'name' => $collectionName . ' #' . $displayNum,
                    'attributes' => [],
                    'image' => null,
                ];
                usleep(200000); // 200ms rate limit for TzKT
                continue;
            }

            $metadata = $tokens[0]['metadata'] ?? [];
            $imageUrl = $metadata['displayUri'] ?? $metadata['artifactUri'] ?? $metadata['thumbnailUri'] ?? null;

            $allTokens[] = [
                'tokenId' => $tokenId,
                'displayNum' => $displayNum,
                'name' => $metadata['name'] ?? ($collectionName . ' #' . $displayNum),
                'description' => $metadata['description'] ?? '',
                'attributes' => $metadata['attributes'] ?? [],
                'tags' => $metadata['tags'] ?? [],
                'image' => $imageUrl,
            ];

            usleep(200000); // 200ms between TzKT requests
        }

        $done = min(($batchIndex + 1) * $batchSize, count($ids));
        logMsg("  Fetched metadata for {$done}/" . count($ids) . " tokens (TzKT)");
    }

    return $allTokens;
}

function fetchFxhashTokenIds($issuerId, $contract) {
    // Strategy 1: fxhash GraphQL API
    $fxhashUrl = "https://api.fxhash.xyz/graphql";
    $query = '{"query":"query { generativeToken(id: ' . intval($issuerId) . ') { entireCollection { onChainId } }}"}';

    $ch = curl_init($fxhashUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json',
        'User-Agent: fxhash-collection-viewer'
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $response = curl_exec($ch);

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
    $ch = curl_init($filteredUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'User-Agent: fxhash-collection-viewer'
    ]);
    $response = curl_exec($ch);

    if ($response !== false) {
        $data = json_decode($response, true);
        if ($data && is_array($data) && count($data) > 0) {
            $tokenIds = [];
            foreach ($data as $token) {
                if (is_array($token) && isset($token['tokenId'])) {
                    $tokenIds[] = intval($token['tokenId']);
                } elseif (is_numeric($token)) {
                    $tokenIds[] = intval($token);
                }
            }
            if (count($tokenIds) > 0) {
                sort($tokenIds);
                return $tokenIds;
            }
        }
    }

    return null;
}

// ============ Main Processing Loop ============

logMsg("Universal Metadata Cron Job Starting");
logMsg("====================================");

$collections = $config['collections'];

// Filter to target collection if specified
if ($targetCollection) {
    $found = false;
    foreach ($collections as $c) {
        if ($c['id'] === $targetCollection) {
            $collections = [$c];
            $found = true;
            break;
        }
    }
    if (!$found) {
        die("Error: Collection '{$targetCollection}' not found in config.json\n");
    }
}

$collectionCount = count($collections);
$processed = 0;

foreach ($collections as $collectionIndex => $collection) {
    $id = $collection['id'];
    $name = $collection['name'];
    $supply = $collection['supply'];
    $chain = $collection['chain'];

    // Skip collections below minimum supply threshold, unless they need metadata for collector search
    if ($supply < $minGridSupply && empty($collection['collectorsFromMetadata'])) {
        logMsg("SKIP: {$name} (supply={$supply}, below minimum {$minGridSupply})");
        continue;
    }

    // Skip collections excluded from grid
    if (in_array($id, $skipGrid)) {
        logMsg("SKIP: {$name} (excluded from grid)");
        continue;
    }

    logMsg("Processing: {$name} ({$id}) — {$supply} tokens on {$chain}");

    $cacheFile = $cachePath . '/' . $id . '_metadata.json';

    // Check if cache is fresh
    if (!$forceRefresh && file_exists($cacheFile)) {
        $cacheData = json_decode(file_get_contents($cacheFile), true);
        if ($cacheData && isset($cacheData['timestamp'])) {
            $age = time() - $cacheData['timestamp'];
            if ($age < $cacheExpiry && !empty($cacheData['tokens'])) {
                $cachedCount = count($cacheData['tokens']);
                $daysAgo = round($age / 86400, 1);
                logMsg("  Cache is fresh ({$daysAgo} days old, {$cachedCount} tokens). Skipping metadata fetch.");

                // Still check thumbnails even if metadata is cached
                generateThumbnails($id, $cacheData['tokens'], $thumbBaseDir, $localImageMap, $baseDir);

                $processed++;
                continue;
            }
        }
    }

    // Fetch metadata based on chain type
    $tokens = [];

    if (isset($collection['multiContract']) && $collection['multiContract']) {
        logMsg("  Fetching EVM multi-contract metadata...");
        $tokens = fetchEVMMultiContractMetadata($collection, $rpcUrls);
    } elseif ($chain === 'ethereum' || $chain === 'arbitrum') {
        logMsg("  Fetching EVM metadata via JSON-RPC...");
        $tokens = fetchEVMMetadata($collection, $rpcUrls, $chain);
    } elseif ($chain === 'tezos') {
        logMsg("  Fetching Tezos metadata via TzKT...");
        $tokens = fetchTezosMetadata($collection);
    } else {
        logMsg("  WARNING: Unknown chain '{$chain}', skipping.");
        continue;
    }

    if (empty($tokens)) {
        logMsg("  WARNING: No tokens fetched, skipping cache write.");
        continue;
    }

    logMsg("  Fetched metadata for " . count($tokens) . " tokens");

    if (!empty($collection['collectorsFromMetadata']) && !addCollectors($collection, $tokens, $cachePath)) {
        logMsg("  WARNING: Could not fetch collectors.");
    }

    // Save metadata cache
    $cacheData = [
        'timestamp' => time(),
        'collection' => $id,
        'name' => $name,
        'supply' => count($tokens),
        'tokens' => $tokens,
    ];

    file_put_contents($cacheFile, json_encode($cacheData));
    logMsg("  Saved cache: {$cacheFile}");

    // Generate thumbnails
    generateThumbnails($id, $tokens, $thumbBaseDir, $localImageMap, $baseDir);

    $processed++;

    // Rate limit between collections (60s delay unless this is the last one or single-collection mode)
    if (!$targetCollection && $collectionIndex < $collectionCount - 1) {
        logMsg("  Waiting 60s before next collection...");
        sleep(60);
    }
}

logMsg("====================================");
logMsg("Done! Processed {$processed} collections.");

// ============ Thumbnail Generation ============

function generateThumbnails($collectionId, $tokens, $thumbBaseDir, $localImageMap, $baseDir) {
    $outputDir = $thumbBaseDir . '/' . $collectionId;
    if (!is_dir($outputDir)) {
        mkdir($outputDir, 0755, true);
    }

    $generated = 0;
    $skipped = 0;
    $errors = 0;
    $hasLocal = isset($localImageMap[$collectionId]);

    foreach ($tokens as $index => $token) {
        $displayNum = $token['displayNum'];
        $outputFile = $outputDir . '/' . $displayNum . '.jpg';

        // Skip if already exists
        if (file_exists($outputFile)) {
            $skipped++;
            continue;
        }

        $success = false;

        // Try local image first
        if ($hasLocal) {
            $localFile = getLocalSourceFile($collectionId, $index, $localImageMap, $baseDir);
            if ($localFile) {
                $success = createThumbFromFile($localFile, $outputFile);
            }
        }

        // Fall back to downloading from metadata image URL
        if (!$success && !empty($token['image'])) {
            $success = downloadAndCreateThumb($token['image'], $outputFile);
            if ($success) {
                usleep(500000); // 500ms delay between downloads
            }
        }

        if ($success) {
            $generated++;
        } else {
            $errors++;
        }

        // Progress every 50
        if (($generated + $skipped + $errors) % 50 === 0) {
            $total = $generated + $skipped + $errors;
            logMsg("  Thumbnails: {$total}/" . count($tokens) . " processed ({$generated} new, {$skipped} existing)");
        }
    }

    logMsg("  Thumbnails: {$generated} generated, {$skipped} existing, {$errors} failed");
}

