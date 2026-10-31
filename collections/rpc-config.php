<?php
/**
 * Browser-facing single source of truth for RPC endpoints.
 *
 * Emits `window.RPC_URLS` as JavaScript, derived from collections/config.json
 * (via rpc.php). Client pages load this with:
 *     <script src="/collections/rpc-config.php"></script>
 * and then reference `window.RPC_URLS`, so no page hardcodes an RPC URL.
 */

require_once __DIR__ . '/rpc.php';

header('Content-Type: application/javascript; charset=utf-8');
header('Cache-Control: public, max-age=300');

$rpc = get_rpc_urls();
echo 'window.RPC_URLS = ' . json_encode($rpc, JSON_UNESCAPED_SLASHES) . ';';
