<?php
/**
 * Universal Metadata API
 * Serves cached metadata JSON for any collection.
 *
 * Usage: metadata-api.php?collection={collectionId}
 * Returns: cached JSON from cache/{collectionId}_metadata.json or 404
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

if (!file_exists($cacheFile)) {
    http_response_code(404);
    echo json_encode(['error' => 'No cached metadata for collection: ' . $collectionId]);
    exit;
}

// Serve the cached file directly
echo file_get_contents($cacheFile);

