<?php
/**
 * Clear Owner Cache
 *
 * Usage:
 *   CLI: php clear-cache.php [collection]
 *   Web: clear-cache.php?collection=nokori&key=YOUR_SECRET_KEY
 *
 * If no collection specified, clears all caches.
 */

// Simple security key for web access (change this!)
$secretKey = '5yth@s3cr3t';

$cachePath = __DIR__ . '/cache';

// Determine if running from CLI or web
$isCli = php_sapi_name() === 'cli';

if (!$isCli) {
    header('Content-Type: application/json');

    // Require secret key for web access
    $providedKey = $_GET['key'] ?? '';
    if ($providedKey !== $secretKey) {
        http_response_code(403);
        echo json_encode(['error' => 'Invalid or missing key']);
        exit;
    }

    $collection = $_GET['collection'] ?? null;
} else {
    $collection = $argv[1] ?? null;
}

// Check if cache directory exists
if (!is_dir($cachePath)) {
    $msg = "Cache directory does not exist.";
    if ($isCli) {
        echo $msg . "\n";
    } else {
        echo json_encode(['message' => $msg, 'cleared' => []]);
    }
    exit;
}

$cleared = [];

if ($collection) {
    // Clear specific collection cache
    $cacheFile = $cachePath . '/owners_' . $collection . '.json';
    if (file_exists($cacheFile)) {
        unlink($cacheFile);
        $cleared[] = $collection;
    }
} else {
    // Clear all owner caches
    $files = glob($cachePath . '/owners_*.json');
    foreach ($files as $file) {
        if (preg_match('/owners_(.+)\.json$/', basename($file), $matches)) {
            unlink($file);
            $cleared[] = $matches[1];
        }
    }
}

// Output results
if ($isCli) {
    if (count($cleared) > 0) {
        echo "Cleared cache for: " . implode(', ', $cleared) . "\n";
    } else {
        echo "No cache files found" . ($collection ? " for collection: $collection" : "") . "\n";
    }
} else {
    echo json_encode([
        'success' => true,
        'cleared' => $cleared,
        'message' => count($cleared) > 0
            ? 'Cleared ' . count($cleared) . ' cache file(s)'
            : 'No cache files found'
    ]);
}

