<?php
/**
 * Simple CORS Proxy for fetching NFT metadata
 * Usage: proxy.php?url=https://token.arbitrum.artblocks.io/...
 */

// Allow CORS from your domain
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

// Only allow GET requests
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Get the URL to fetch
$url = $_GET['url'] ?? '';

if (empty($url)) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing url parameter']);
    exit;
}

// Only allow specific domains for security
$allowedDomains = [
    'token.artblocks.io',
    'token.arbitrum.artblocks.io',
    'api.artblocks.io',
    'ipfs.io',
    'gateway.ipfs.io',
    'cloudflare-ipfs.com',
    'arweave.net'
];

$parsedUrl = parse_url($url);
$host = $parsedUrl['host'] ?? '';

$isAllowed = false;
foreach ($allowedDomains as $domain) {
    if ($host === $domain || str_ends_with($host, '.' . $domain)) {
        $isAllowed = true;
        break;
    }
}

if (!$isAllowed) {
    http_response_code(403);
    echo json_encode(['error' => 'Domain not allowed: ' . $host]);
    exit;
}

// Fetch the URL
$context = stream_context_create([
    'http' => [
        'method' => 'GET',
        'header' => [
            'Accept: application/json',
            'User-Agent: Mozilla/5.0 (compatible; NFTProxy/1.0)'
        ],
        'timeout' => 30,
        'ignore_errors' => true
    ],
    'ssl' => [
        'verify_peer' => true,
        'verify_peer_name' => true
    ]
]);

$response = @file_get_contents($url, false, $context);

if ($response === false) {
    http_response_code(502);
    echo json_encode(['error' => 'Failed to fetch URL']);
    exit;
}

// Get HTTP response code from headers
$httpCode = 200;
if (isset($http_response_header)) {
    foreach ($http_response_header as $header) {
        if (preg_match('/^HTTP\/\d+\.?\d* (\d+)/', $header, $matches)) {
            $httpCode = intval($matches[1]);
        }
    }
}

http_response_code($httpCode);
echo $response;

