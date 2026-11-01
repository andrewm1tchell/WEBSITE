<?php
/**
 * Universal Metadata API
 * Serves cached metadata JSON for any collection.
 *
 * Usage: metadata-api.php?collection={collectionId}
 * Returns: cached JSON from cache/{collectionId}_metadata.json or 404
 *
 * Add &collectors=1 for just the wallet search data, keyed by display number
 * in the same shape as owners.php: { owners: { "1": ["0x..."] } }
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$collectionId = $_GET['collection'] ?? '';

if (!$collectionId || !preg_match('/^[a-z0-9\-]+$/', $collectionId)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid or missing collection parameter']);
    exit;
}

$cacheFile = __DIR__ . '/cache/' . $collectionId . '_metadata.json';

if (isset($_GET['collectors'])) {
    $cacheData = file_exists($cacheFile) ? json_decode(file_get_contents($cacheFile), true) : [];

    $owners = [];
    foreach ($cacheData['tokens'] ?? [] as $token) {
        if (!empty($token['collectors'])) {
            $owners[$token['displayNum']] = $token['collectors'];
        }
    }

    echo json_encode(['owners' => (object)$owners]);
    exit;
}

if (!file_exists($cacheFile)) {
    http_response_code(404);
    echo json_encode(['error' => 'No cached metadata for collection: ' . $collectionId]);
    exit;
}

// Serve the cached file directly
echo file_get_contents($cacheFile);

