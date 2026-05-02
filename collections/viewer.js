/**
 * Universal Collection Viewer - Shared JavaScript
 * Handles token metadata fetching and owner lookups across multiple chains
 */

const RPC_URLS = {
    ethereum: 'https://mainnet.infura.io/v3/7c722c5d30fb4872879a308ddecf01cd',
    arbitrum: 'https://arb-mainnet.g.alchemy.com/v2/demo'
};

const ERC721_ABI = [
    'function tokenURI(uint256 tokenId) view returns (string)',
    'function ownerOf(uint256 tokenId) view returns (address)'
];

// Get provider for a chain
function getProvider(chain) {
    const rpcUrl = RPC_URLS[chain];
    if (!rpcUrl) {
        console.warn(`No RPC URL for chain: ${chain}`);
        return null;
    }
    return new ethers.JsonRpcProvider(rpcUrl);
}

// Get contract instance
function getContract(contractAddress, chain) {
    const provider = getProvider(chain);
    if (!provider) return null;
    return new ethers.Contract(contractAddress, ERC721_ABI, provider);
}

// Fetch token metadata from tokenURI
async function fetchTokenMetadata(tokenURI) {
    try {
        // Handle different URI formats
        let uri = tokenURI;

        // Handle base64 encoded JSON
        if (uri.startsWith('data:application/json;base64,')) {
            const base64 = uri.replace('data:application/json;base64,', '');
            const json = atob(base64);
            return JSON.parse(json);
        }

        // Handle data URI JSON
        if (uri.startsWith('data:application/json,')) {
            const json = decodeURIComponent(uri.replace('data:application/json,', ''));
            return JSON.parse(json);
        }

        // Handle IPFS
        if (uri.startsWith('ipfs://')) {
            uri = uri.replace('ipfs://', 'https://ipfs.io/ipfs/');
        }

        // Handle Arweave with multiple gateway fallbacks
        if (uri.startsWith('ar://')) {
            const arweaveGateways = [
                'https://arweave.net/',
                'https://ar-io.dev/',
                'https://g8way.io/'
            ];

            const arPath = uri.replace('ar://', '');

            // Try each gateway sequentially
            for (const gateway of arweaveGateways) {
                try {
                    const gatewayUrl = gateway + arPath;
                    console.log('Trying Arweave gateway:', gatewayUrl);

                    const controller = new AbortController();
                    const timeoutId = setTimeout(() => controller.abort(), 30000);

                    const response = await fetch(gatewayUrl, { signal: controller.signal });
                    clearTimeout(timeoutId);

                    if (response.ok) {
                        return await response.json();
                    }
                    console.log('Gateway failed with status:', response.status);
                } catch (e) {
                    console.log('Gateway error:', e.message);
                    // Continue to next gateway
                }
            }

            throw new Error('All Arweave gateways failed for: ' + uri);
        }

        // Fetch from URL
        const response = await fetch(uri);
        return await response.json();
    } catch (error) {
        console.error('Error fetching metadata:', error);
        return null;
    }
}

// Get image URL from metadata, handling various formats
function getImageUrl(metadata) {
    if (!metadata) return null;

    let imageUrl = metadata.image || metadata.image_url || metadata.imageUrl;

    if (!imageUrl) return null;

    // Handle IPFS
    if (imageUrl.startsWith('ipfs://')) {
        imageUrl = imageUrl.replace('ipfs://', 'https://ipfs.io/ipfs/');
    }

    // Handle Arweave
    if (imageUrl.startsWith('ar://')) {
        imageUrl = imageUrl.replace('ar://', 'https://arweave.net/');
    }

    return imageUrl;
}

// Shorten address for display
function shortenAddress(address) {
    if (!address) return 'Unknown';
    return `${address.slice(0, 6)}...${address.slice(-4)}`;
}

// Get block explorer URL
function getExplorerUrl(chain, contractAddress, tokenId) {
    const explorers = {
        ethereum: `https://etherscan.io/nft/${contractAddress}/${tokenId}`,
        arbitrum: `https://arbiscan.io/nft/${contractAddress}/${tokenId}`
    };
    return explorers[chain] || '#';
}

// Get OpenSea URL
function getOpenSeaUrl(chain, contractAddress, tokenId) {
    const chainMap = {
        ethereum: 'ethereum',
        arbitrum: 'arbitrum'
    };
    const osChain = chainMap[chain];
    if (!osChain) return '#';
    return `https://opensea.io/assets/${osChain}/${contractAddress}/${tokenId}`;
}

// Generate token IDs for a collection
function getTokenIds(collection) {
    // If specific tokenIds are provided, use those
    if (collection.tokenIds && Array.isArray(collection.tokenIds)) {
        return collection.tokenIds;
    }

    // Otherwise generate sequential IDs
    const ids = [];
    const start = collection.tokenIdStart || 0;
    for (let i = 0; i < collection.supply; i++) {
        ids.push(start + i);
    }
    return ids;
}

// Load collection config
async function loadConfig() {
    const response = await fetch('/collections/config.json');
    return await response.json();
}

// Find collection by ID
async function getCollection(collectionId) {
    const config = await loadConfig();
    return config.collections.find(c => c.id === collectionId);
}

