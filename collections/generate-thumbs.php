<?php
/**
 * Generate Grid Thumbnails from Local Images
 *
 * Creates compressed 400px JPEG thumbnails for the grid view.
 * Processes collections that have local images on disk.
 *
 * Usage: php generate-thumbs.php [collectionId]
 *   - No argument: processes all collections with local images
 *   - With argument: processes only the specified collection
 *
 * Destination: /images/grid-thumbs/{collectionId}/{displayNum}.jpg
 * Spec: max 400px longest side, JPEG quality 75
 */

set_time_limit(600);
ini_set('memory_limit', '512M');

$baseDir = dirname(__DIR__);
$thumbBaseDir = $baseDir . '/images/grid-thumbs';
$configPath = __DIR__ . '/config.json';

$config = json_decode(file_get_contents($configPath), true);
if (!$config) {
    die("Error: Could not load config.json\n");
}

// Map collection IDs to their local image sources
// Each entry: 'collectionId' => ['path' => ..., 'format' => ..., 'naming' => ..., 'start' => ...]
// naming: 'numeric' = {num}.ext, 'zero-padded' = {000}.ext, 'custom' = special handling
$localImageSources = [
    'nokori' => [
        'path' => $baseDir . '/images/collections/nokori',
        'ext' => 'jpg',
        'naming' => 'numeric',  // 1.jpg, 2.jpg, ...
        'start' => 1,
        'supply' => 401,
    ],
    'sky-meadow' => [
        'path' => $baseDir . '/images/collections/skymeadow',
        'ext' => 'png',
        'naming' => 'numeric',  // 1.png, 2.png, ...
        'start' => 1,
        'supply' => 555,
    ],
    'primera' => [
        'path' => $baseDir . '/images/collections/primera',
        'ext' => 'png',
        'naming' => 'numeric',  // 0.png, 1.png, ...
        'start' => 0,
        'supply' => 400,
    ],
    'memory-loss' => [
        'path' => $baseDir . '/images/collections/memoryloss',
        'ext' => 'png',
        'naming' => 'zero-padded-3',  // 000.png, 001.png, ...
        'start' => 0,
        'supply' => 256,
    ],
    'flowers-of-alfiren' => [
        'path' => $baseDir . '/images/collections/flowersofalfiren',
        'ext' => 'png',
        'naming' => 'numeric',  // 1.png, 2.png, ...
        'start' => 1,
        'supply' => 86,
    ],
    'butterfly-pact' => [
        'path' => $baseDir . '/images/collections/butterfly-pact',
        'ext' => 'png',
        'naming' => 'numeric',  // 0.png, 1.png, ...
        'start' => 0,
        'supply' => 95,
    ],
];

// Filter to specific collection if argument provided
$targetCollection = $argv[1] ?? null;
if ($targetCollection) {
    if (!isset($localImageSources[$targetCollection])) {
        die("Error: No local image source configured for '{$targetCollection}'\n" .
            "Available: " . implode(', ', array_keys($localImageSources)) . "\n");
    }
    $localImageSources = [$targetCollection => $localImageSources[$targetCollection]];
}

// Check for GD library
if (!extension_loaded('gd')) {
    die("Error: PHP GD extension is required. Install with: brew install php-gd (macOS) or apt-get install php-gd (Linux)\n");
}

echo "Grid Thumbnail Generator\n";
echo "========================\n\n";

$totalGenerated = 0;
$totalSkipped = 0;

foreach ($localImageSources as $collectionId => $source) {
    $sourcePath = $source['path'];
    $ext = $source['ext'];
    $naming = $source['naming'];
    $start = $source['start'];
    $supply = $source['supply'];

    echo "Processing: {$collectionId}\n";
    echo "  Source: {$sourcePath}\n";

    if (!is_dir($sourcePath)) {
        echo "  ERROR: Source directory not found, skipping.\n\n";
        continue;
    }

    // Create output directory
    $outputDir = $thumbBaseDir . '/' . $collectionId;
    if (!is_dir($outputDir)) {
        mkdir($outputDir, 0755, true);
        echo "  Created output dir: {$outputDir}\n";
    }

    $generated = 0;
    $skipped = 0;
    $errors = 0;

    for ($i = 0; $i < $supply; $i++) {
        $displayNum = $i + 1;
        $outputFile = $outputDir . '/' . $displayNum . '.jpg';

        // Skip if thumbnail already exists
        if (file_exists($outputFile)) {
            $skipped++;
            continue;
        }

        // Determine source filename
        $sourceNum = $start + $i;
        switch ($naming) {
            case 'zero-padded-3':
                $sourceFile = $sourcePath . '/' . str_pad($sourceNum, 3, '0', STR_PAD_LEFT) . '.' . $ext;
                break;
            case 'numeric':
            default:
                $sourceFile = $sourcePath . '/' . $sourceNum . '.' . $ext;
                break;
        }

        if (!file_exists($sourceFile)) {
            // Try alternate extensions
            $tried = [$sourceFile];
            $found = false;
            foreach (['png', 'jpg', 'jpeg', 'webp'] as $altExt) {
                if ($altExt === $ext) continue;
                $altFile = $sourcePath . '/' . $sourceNum . '.' . $altExt;
                if (file_exists($altFile)) {
                    $sourceFile = $altFile;
                    $found = true;
                    break;
                }
                $tried[] = $altFile;
            }
            if (!$found) {
                $errors++;
                if ($errors <= 5) {
                    echo "  WARNING: Source not found for displayNum {$displayNum} (tried: " . basename($sourceFile) . ")\n";
                }
                continue;
            }
        }

        // Load image
        $srcImage = null;
        $fileExt = strtolower(pathinfo($sourceFile, PATHINFO_EXTENSION));
        switch ($fileExt) {
            case 'jpg':
            case 'jpeg':
                $srcImage = @imagecreatefromjpeg($sourceFile);
                break;
            case 'png':
                $srcImage = @imagecreatefrompng($sourceFile);
                break;
            case 'webp':
                $srcImage = @imagecreatefromwebp($sourceFile);
                break;
            case 'gif':
                $srcImage = @imagecreatefromgif($sourceFile);
                break;
        }

        if (!$srcImage) {
            $errors++;
            if ($errors <= 5) {
                echo "  WARNING: Could not load image: {$sourceFile}\n";
            }
            continue;
        }

        // Get dimensions and calculate new size (max 400px on longest side)
        $origW = imagesx($srcImage);
        $origH = imagesy($srcImage);
        $maxDim = 600;

        if ($origW > $maxDim || $origH > $maxDim) {
            if ($origW >= $origH) {
                $newW = $maxDim;
                $newH = (int)round($origH * ($maxDim / $origW));
            } else {
                $newH = $maxDim;
                $newW = (int)round($origW * ($maxDim / $origH));
            }
        } else {
            // Image is already small enough, just re-encode as JPEG
            $newW = $origW;
            $newH = $origH;
        }

        // Create resized image
        $thumbImage = imagecreatetruecolor($newW, $newH);

        // Handle transparency for PNG sources — fill with white background
        if ($fileExt === 'png') {
            $white = imagecolorallocate($thumbImage, 255, 255, 255);
            imagefill($thumbImage, 0, 0, $white);
        }

        imagecopyresampled($thumbImage, $srcImage, 0, 0, 0, 0, $newW, $newH, $origW, $origH);

        // Save as JPEG quality 75
        imagejpeg($thumbImage, $outputFile, 85);

        $generated++;

        // Progress every 50
        if ($generated % 50 === 0) {
            echo "  Generated {$generated} thumbnails...\n";
        }
    }

    if ($errors > 5) {
        echo "  ... and " . ($errors - 5) . " more missing source files\n";
    }

    echo "  Done: {$generated} generated, {$skipped} skipped (existing), {$errors} errors\n\n";
    $totalGenerated += $generated;
    $totalSkipped += $skipped;
}

echo "========================\n";
echo "Total: {$totalGenerated} generated, {$totalSkipped} skipped\n";

