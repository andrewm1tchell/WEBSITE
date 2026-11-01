<?php
/**
 * NFT Metadata Router
 * Place this in the ethereum folder and use URLs like:
 * /ethereum/skymeadow/1 or /ethereum/primera/0
 *
 * Requires .htaccess with:
 * RewriteEngine On
 * RewriteRule ^(skymeadow|primera)/([0-9]+)$ metadata.php?collection=$1&token=$2 [L,QSA]
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$collection = $_GET['collection'] ?? '';
$tokenId = $_GET['token'] ?? '';

if (empty($collection) || $tokenId === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Missing collection or token ID']);
    exit;
}

// Token IDs are plain numbers. Anything else could walk out of the collection folder.
if (!ctype_digit($tokenId)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid token ID']);
    exit;
}

// Map collection names to directories
$collections = [
    'skymeadow' => 'skymeadow',
    'primera' => 'primera'
];

if (!isset($collections[$collection])) {
    http_response_code(404);
    echo json_encode(['error' => 'Collection not found']);
    exit;
}

$dir = $collections[$collection];
$filePath = __DIR__ . '/' . $dir . '/' . $tokenId;

if (!file_exists($filePath)) {
    http_response_code(404);
    echo json_encode(['error' => 'Token not found']);
    exit;
}

echo file_get_contents($filePath);

