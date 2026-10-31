<?php
/**
 * Browser-facing single source of truth for RPC endpoints and IPFS gateways.
 *
 * Emits `window.RPC_URLS`, `window.IPFS_GATEWAYS` and `window.IPFS_HTML_GATEWAY`
 * as JavaScript, derived from collections/config.json
 * (via rpc.php). Client pages load this with:
 *     <script src="/collections/rpc-config.php"></script>
 * and then reference those globals, so no page hardcodes an RPC URL or gateway.
 */

require_once __DIR__ . '/rpc.php';

header('Content-Type: application/javascript; charset=utf-8');
header('Cache-Control: public, max-age=300');

$rpc = get_rpc_urls();
echo 'window.RPC_URLS = ' . json_encode($rpc, JSON_UNESCAPED_SLASHES) . ';';

$ipfs = get_ipfs_config();
echo 'window.IPFS_GATEWAYS = ' . json_encode($ipfs['gateways'] ?? [], JSON_UNESCAPED_SLASHES) . ';';
echo 'window.IPFS_HTML_GATEWAY = ' . json_encode($ipfs['htmlGateway'] ?? null, JSON_UNESCAPED_SLASHES) . ';';
