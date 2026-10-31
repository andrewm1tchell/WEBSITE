<?php
/**
 * Single source of truth for blockchain RPC endpoints (server-side accessor).
 *
 * The endpoints themselves are authored only in collections/config.json
 * ("rpc" section). Every PHP consumer should read them through this helper
 * instead of hardcoding an RPC URL.
 */

if (!function_exists('get_rpc_urls')) {
    /**
     * Return the full map of chain => RPC URL from config.json.
     *
     * @return array<string,string>
     */
    function get_rpc_urls()
    {
        static $rpc = null;
        if ($rpc === null) {
            $rpc = [];
            $path = __DIR__ . '/config.json';
            if (is_readable($path)) {
                $config = json_decode(file_get_contents($path), true);
                if (is_array($config) && isset($config['rpc']) && is_array($config['rpc'])) {
                    $rpc = $config['rpc'];
                }
            }
        }
        return $rpc;
    }
}

if (!function_exists('get_rpc_url')) {
    /**
     * Return the RPC URL for a single chain (defaults to Ethereum mainnet).
     *
     * @param string $chain
     * @return string|null
     */
    function get_rpc_url($chain = 'ethereum')
    {
        $rpc = get_rpc_urls();
        return isset($rpc[$chain]) ? $rpc[$chain] : null;
    }
}
