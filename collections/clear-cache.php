<?php
/**
 * Clear Owner Cache
 *
 * Usage: php clear-cache.php [collection]
 *
 * If no collection specified, clears all caches.
 */

if (php_sapi_name() !== 'cli') {
    http_response_code(404);
    exit;
}

$cachePath = __DIR__ . '/cache';
$collection = $argv[1] ?? null;

// Check if cache directory exists
if (!is_dir($cachePath)) {
    echo "Cache directory does not exist.\n";
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
if (count($cleared) > 0) {
    echo "Cleared cache for: " . implode(', ', $cleared) . "\n";
} else {
    echo "No cache files found" . ($collection ? " for collection: $collection" : "") . "\n";
}
