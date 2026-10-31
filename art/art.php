<!DOCTYPE html>
<html lang="en">
<?php include 'meta.php'; ?>
<script>
  // Disable JINSEI background texture on art.php
  window.JINSEI_BG = { dark: '#0a0108', light: '#ffffff', seed: null, grain: 0, texA: false, texB: false, stains: false };
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/matter-js/0.19.0/matter.min.js"></script>
<script>
    document.title = "Andrew Mitchell - Art";

    $(document).ready(function () {
        $("a.nav-item.nav-link:contains('ART')").css("text-decoration", "underline");
        $("#eye").removeClass("d-none");
    });
</script>
<style>

    #canvas-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100%;
        height: 100dvh; /* Dynamic viewport height for mobile */
        z-index: 10;
        pointer-events: none;
        overflow: hidden;
    }

    #canvas-container canvas {
        display: block;
        position: relative;
        z-index: 10;
        pointer-events: none;
    }

    /* Overlay for artwork labels */
    .blob-label {
        position: absolute;
        pointer-events: auto;
        text-align: center;
        z-index: 20;
        cursor: grab;
        transition: transform 0.2s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        text-decoration: none;
    }

    .blob-label:hover {
        transform: scale(1.05);
    }

    .blob-label .title {
        text-decoration: none;
        font-size: 1rem;
        font-weight: 500;
        display: block;
        text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        line-height: 1.2;
        max-width: 90%;
        overflow: hidden;
        text-overflow: ellipsis;
        transition: transform 0.2s ease;
    }

    .blob-label .year {
        font-size: 0.5rem;
        opacity: 0.6;
        margin-bottom: 2px;
        transition: transform 0.2s ease;
    }

    .blob-label .collab {
        transition: transform 0.2s ease;
    }

    /* The shapes invert against the page — off-white on the dark page, near-black
       on the light one — so the label text sitting on top has to invert with
       them. #canvas-container gets .on-dark from draw() whenever the mode flips.
       The accent blob keeps its colour in both modes, so it always wants white. */
    #canvas-container.on-dark .blob-label:not(.accent) .title,
    #canvas-container.on-dark .blob-label:not(.accent) .year,
    #canvas-container.on-dark .blob-label:not(.accent) .collab,
    #canvas-container.on-dark .blob-label:not(.accent) .collab a,
    #canvas-container.on-dark .blob-label:not(.accent) .click-hint {
        color: #1e1a1c !important;
    }

    #canvas-container:not(.on-dark) .blob-label:not(.accent) .title,
    #canvas-container:not(.on-dark) .blob-label:not(.accent) .year,
    #canvas-container:not(.on-dark) .blob-label:not(.accent) .collab,
    #canvas-container:not(.on-dark) .blob-label:not(.accent) .collab a,
    #canvas-container:not(.on-dark) .blob-label:not(.accent) .click-hint {
        color: #f4f2ef !important;
    }

    .blob-label.accent .title,
    .blob-label.accent .year,
    .blob-label.accent .collab,
    .blob-label.accent .collab a,
    .blob-label.accent .click-hint {
        color: var(--white) !important;
    }

    /* The drop shadow is tuned for light text; on the off-white shapes it just
       muddies the dark type. */
    #canvas-container.on-dark .blob-label:not(.accent) .title {
        text-shadow: none;
    }

    /* Hover used to lighten the text, which is invisible on a white shape.
       The scale alone is enough feedback. */
    .blob-label:hover .title {
        transform: scale(1.15);
    }

    .blob-label:hover .year {
        transform: scale(1.1);
    }

    .blob-label:hover .collab {
        transform: scale(1.1);
    }

    .blob-label .collab {
        font-size: 0.5rem;
        opacity: 0.7;
        margin-top: 2px;
        max-width: 85%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .blob-label .collab a {
        font-size: 0.5rem;
        text-decoration: underline;
    }

    .click-hint {
        position: absolute;
        bottom: 18%;
        left: 50%;
        transform: translateX(-50%);
        font-size: 0.5rem;
        opacity: 0;
        transition: opacity 0.3s ease;
        white-space: nowrap;
        pointer-events: none;
    }

    .new-badge {
        display: inline-block;
        font-size: 0.4em;
        background: linear-gradient(135deg, #ff6b6b, #feca57);
        color: #fff;
        padding: 2px 6px;
        border-radius: 10px;
        margin-left: 5px;
        vertical-align: middle;
        font-weight: 600;
    }

    .minting-badge {
        background: #fff;
        color: #111;
        border: 1px solid #fff;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .view-collections-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
        background: rgba(255,255,255,0.95);
        color: #333;
        text-decoration: none;
        padding: 10px 16px;
        border-radius: 4px;
        font-size: 0.85em;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        transition: all 0.2s ease;
    }

    .view-collections-btn:hover {
        background: #333;
        color: #fff;
    }

    @media (max-width: 768px) {
        .blob-label .title {
            font-size: 0.65rem;
        }
        .blob-label .year {
            font-size: 0.45rem;
        }
        .blob-label .collab,
        .blob-label .collab a {
            font-size: 0.4rem;
        }
        .new-badge {
            font-size: 0.4em;
            padding: 2px 5px;
            margin-left: 4px;
        }
        .view-collections-btn {
            bottom: 50px;
            right: 15px;
            padding: 4px 6px;
            font-size: 0.8em;
        }
    }
</style>

<div id="canvas-container"></div>

<script>
// Artwork data
const artworks = [
    { title: "NOKORI", year: "2026", href: "art/nokori.php", isNew: true },
    { title: "Angels", year: "2026", href: "art/angels.php", minting: true },
    { title: "Popup", year: "2024", href: "art/popup.php" },
    { title: "Prozac Youth", year: "2024", href: "art/prozacyouth.php", collab: "Created with <a href='https://tjo.art/' target='_blank'>Tjo</a>" },
    { title: "Modulo", year: "2024", href: "art/modulo.php", collab: "with <a href='https://x.com/cafromthesky' target='_blank'>Rich Caldwell</a>" },
    { title: "Flowers of Alfiren", year: "2023", href: "art/flowersofalfiren.php" },
    { title: "Butterfly Pact", year: "2023", href: "art/butterflypact.php" },
    { title: "Memory Loss", year: "2023", href: "art/memoryloss.php" },
    { title: "Necromancer", year: "2023", href: "art/necromancer.php" },
    { title: "Nature Studies", year: "2022-2023", href: "art/naturestudies.php" },
    { title: "Sky Meadow", year: "2022", href: "/art/skymeadow.php" },
    { title: "Flume", year: "2022", href: "art/flume.php" },
    { title: "The Moon", year: "2022", href: "art/moon.php", collab: "with <a href='https://twitter.com/omentejovem' target='_blank'>omentejovem</a>" },
    { title: "Primera", year: "2021", href: "art/primera.php", collab: "with <a href='https://www.ribbonriven.com/' target='_blank'>Grant Yun</a>" }
];

// Matter.js setup
const Engine = Matter.Engine;
const World = Matter.World;
const Bodies = Matter.Bodies;
const Body = Matter.Body;

let engine;
let world;
let blobs = [];
let labels = [];
let ground, leftWall, rightWall;
let footerHeight = 60; // Default fallback
let initialWidth, initialHeight; // Track initial dimensions
let initialPixelRatio; // Track pixel ratio to detect zoom

// Track mouse position manually since canvas has pointer-events: none
let cursorX = -9999, cursorY = -9999;
document.addEventListener('mousemove', (e) => { cursorX = e.clientX; cursorY = e.clientY; });
document.addEventListener('touchmove', (e) => { cursorX = e.touches[0].clientX; cursorY = e.touches[0].clientY; });
document.addEventListener('touchend', () => { cursorX = -9999; cursorY = -9999; });
document.addEventListener('touchcancel', () => { cursorX = -9999; cursorY = -9999; });

// Pretext - dynamic text reflow
let pretextPrepared = null; // prepareWithSegments result
let pretextLayoutNextLine = null; // layoutNextLine function ref
let pretextReady = false;
let pretextFontSize = 9;
let pretextLineHeight = 13;
let pretextColumns = []; // { left, right } for each column
const pretextColumnGap = 14;
let lastLabelMode = null; // tracks the mode the label colours are currently set for

// Blob colour — taken from the background config so the two stay in sync.
// The shapes are the *other* mode's base tone: off-white on the dark page,
// near-black on the light one. They read as cut-outs from the same paper rather
// than as coloured objects sitting on top of it. Only the newest work is
// coloured, on the texture's own hue, so it is the single accent on the page.
const BG_CFG = window.JINSEI_BG || {};
const BLOB_DARK_TONE = '#000000';
const BLOB_LIGHT_TONE = '#ffffff';
const BLOB_ACCENT_HUE = BG_CFG.texBHue === undefined ? 335 : BG_CFG.texBHue;

// Slight transparency so the page's weave reads through the shapes. The stroke
// stays fully opaque so the edges stay crisp — a translucent fill with a solid
// rim looks deliberate, whereas fading both just looks washed out.
let BLOB_FILL_ALPHA = 0.2;
let BLOB_STROKE_ALPHA = 1;

// p5's colour parser wants integer channels in rgba(), so round on the way in.
function withAlpha(hex, alpha) {
    let h = hex.replace('#', '');
    if (h.length === 3) h = h[0] + h[0] + h[1] + h[1] + h[2] + h[2];
    const r = parseInt(h.slice(0, 2), 16);
    const g = parseInt(h.slice(2, 4), 16);
    const b = parseInt(h.slice(4, 6), 16);
    return `rgba(${r}, ${g}, ${b}, ${alpha})`;
}

// Read the DOM, not isDarkMode: setLightMode(true) applies the *light* palette
// while setting that flag true, so the flag reads backwards.
function pageIsDark() {
    const b = document.body;
    if (b.classList.contains('light-bg')) return false;
    if (b.classList.contains('dark-bg')) return true;
    const m = (getComputedStyle(b).backgroundColor || '').match(/\d+/g);
    return m ? (0.2126 * +m[0] + 0.7152 * +m[1] + 0.0722 * +m[2]) < 128 : true;
}

// Resolved per frame so the shapes flip when the dark/light toggle is hit.
function blobPalette(isNew, isDark) {
    if (isNew) {
        // New artworks use grayscale instead of colored
        return isDark
            ? { fill: withAlpha('#e0e0e0', BLOB_FILL_ALPHA), stroke: withAlpha('#ffffff', BLOB_STROKE_ALPHA) }
            : { fill: withAlpha('#333333', BLOB_FILL_ALPHA), stroke: withAlpha('#000000', BLOB_STROKE_ALPHA) };
    }
    return isDark
        ? { fill: withAlpha(BLOB_LIGHT_TONE, BLOB_FILL_ALPHA), stroke: withAlpha('#ffffff', BLOB_STROKE_ALPHA) }
        : { fill: withAlpha(BLOB_DARK_TONE,  BLOB_FILL_ALPHA), stroke: withAlpha('#000000', BLOB_STROKE_ALPHA) };
}

// Function to update ground position based on footer
function updateGroundPosition() {
    const viewportHeight = window.visualViewport ? window.visualViewport.height : window.innerHeight;
    const viewportWidth = window.innerWidth;

    const footer = document.getElementById('footer');
    if (footer && footer.offsetHeight > 0) {
        footerHeight = footer.offsetHeight;
    }

    const thickness = 100;
    const groundY = viewportHeight - footerHeight + thickness / 2;

    if (ground) {
        Body.setPosition(ground, { x: viewportWidth / 2, y: groundY });
        Body.setVertices(ground, Bodies.rectangle(viewportWidth / 2, groundY, viewportWidth * 2, thickness).vertices);
    }
}

function setup() {
    // Get actual viewport height for mobile (accounts for browser UI)
    const viewportHeight = window.visualViewport ? window.visualViewport.height : window.innerHeight;
    const viewportWidth = window.innerWidth;

    // Store initial dimensions and pixel ratio
    initialWidth = viewportWidth;
    initialHeight = viewportHeight;
    initialPixelRatio = window.devicePixelRatio || 1;

    // Calculate footer height - try to get it now, but will recalculate later
    const footer = document.getElementById('footer');
    if (footer && footer.offsetHeight > 0) {
        footerHeight = footer.offsetHeight;
    }

    const canvas = createCanvas(viewportWidth, viewportHeight);
    canvas.parent('canvas-container');

    // Detect mobile early so physics can be tuned
    const isMobile = viewportWidth < 768;

    // Create physics engine with improved collision settings
    engine = Engine.create();
    world = engine.world;
    engine.world.gravity.y = isMobile ? 0.5 : 0.9;

    // Improve collision detection to prevent overlap
    engine.positionIterations = 20;   // High iteration count for tighter position solving
    engine.velocityIterations = 16;   // High velocity iterations for cleaner separation

    // Create boundaries - ground at the bottom of visible viewport
    const thickness = 100;
    const groundY = viewportHeight - footerHeight + thickness / 2;
    ground = Bodies.rectangle(viewportWidth / 2, groundY, viewportWidth * 2, thickness, { isStatic: true });
    leftWall = Bodies.rectangle(-thickness / 2, viewportHeight / 2, thickness, viewportHeight * 3, { isStatic: true });
    rightWall = Bodies.rectangle(viewportWidth + thickness / 2, viewportHeight / 2, thickness, viewportHeight * 3, { isStatic: true });

    World.add(world, [ground, leftWall, rightWall]);

    // Create blobs for each artwork - responsive sizing
    const minRadius = isMobile ? min(width, height) * 0.15 : min(width, height) * 0.12;
    const maxRadius = isMobile ? min(width, height) * 0.20 : min(width, height) * 0.18;

    // Shape types cycle: circle, hexagon, square
    const shapeTypes = ['circle', 'square'];

    artworks.forEach((artwork, index) => {
        const radius = artwork.isNew ? maxRadius : random(minRadius, maxRadius);
        const x = random(radius, width - radius);
        // On mobile, space blobs further apart above the viewport so they trickle in slowly
        const y = isMobile
            ? -radius - (index * radius * 3.5) - random(80, 200)
            : -radius - (index * radius * 2.5) - random(50, 150);

        const physicsOpts = {
            restitution: isMobile ? 0.95 : 0.8,
            friction: isMobile ? 0.02 : 0.05,
            frictionAir: isMobile ? 0.006 : 0.008,
            density: 0.004,
            slop: 0.001   // Near-zero overlap tolerance
        };

        // Pick shape — new items always get circle, others cycle
        const shape = artwork.isNew ? 'circle' : shapeTypes[index % shapeTypes.length];

        let body;
        if (shape === 'hexagon') {
            body = Bodies.polygon(x, y, 6, radius, physicsOpts);
        } else if (shape === 'square') {
            const side = radius * 1.6;
            body = Bodies.rectangle(x, y, side, side, {
                ...physicsOpts,
                chamfer: { radius: 4 }  // Rounded corners in physics to prevent corner penetration
            });
        } else {
            body = Bodies.circle(x, y, radius, physicsOpts);
        }

        // Add slight random initial velocity – gentler on mobile
        Body.setVelocity(body, {
            x: random(-1, 1),
            y: isMobile ? random(0, 0.5) : random(0, 2)
        });

        World.add(world, body);

        blobs.push({
            body: body,
            radius: radius,
            artwork: artwork,
            shape: shape
        });

        // Create HTML label for this blob
        createLabel(artwork, index, radius, shape);
    });

    // Prepare text with Pretext (one-time measurement, reflow happens per-frame)
    prepareText();

    // Enable click-and-drag / throw interaction
    initDragHandlers();
}

function createLabel(artwork, index, radius, shape) {
    const label = document.createElement('a');
    // .accent opts out of the invert-with-the-page text rules: that shape stays
    // coloured in both modes, so its label always wants white text.
    label.className = artwork.isNew ? 'blob-label accent' : 'blob-label';
    label.id = `label-${index}`;
    label.href = artwork.href;
    label.title = 'Double-click to open';

    // Set size to match the blob
    const size = radius * 2;
    if (shape === 'square') {
        const side = radius * 1.6;
        label.style.width = `${side}px`;
        label.style.height = `${side}px`;
        label.style.borderRadius = '4px';
    } else if (shape === 'hexagon') {
        label.style.width = `${size}px`;
        label.style.height = `${size}px`;
        label.style.borderRadius = '0';
        label.style.clipPath = 'polygon(50% 0%, 93% 25%, 93% 75%, 50% 100%, 7% 75%, 7% 25%)';
        label.style.webkitClipPath = 'polygon(50% 0%, 93% 25%, 93% 75%, 50% 100%, 7% 75%, 7% 25%)';
    } else {
        label.style.width = `${size}px`;
        label.style.height = `${size}px`;
    }

    let titleHtml = artwork.title;
    if (artwork.minting) {
        titleHtml += ' <span class="new-badge minting-badge">MINTING</span>';
    }
    label.innerHTML = `
        <div class="year">${artwork.year}</div>
        <div class="title">${titleHtml}</div>
        ${artwork.collab ? `<div class="collab">${artwork.collab}</div>` : ''}
    `;

    document.getElementById('canvas-container').appendChild(label);
    labels.push({ element: label, radius: radius });
}

async function prepareText() {
    await document.fonts.ready;

    try {
        const pretext = await import('https://esm.sh/@chenglou/pretext');
        pretextLayoutNextLine = pretext.layoutNextLine;

        const baseText = "Dear Andrew: 1. Do not stop making art. 2. Lose control. 3. Play. 4. Work with your axioms. 5. See art. 6. Meet people. 7. Make friends. 8. Daydream. 9. Make mistakes. 10. Make more art. ";
        // Repeat the text many times so it fills the whole screen
        const aboutText = baseText.repeat(40);

        const isMobile = width < 768;
        pretextFontSize = isMobile ? 7 : 9;
        pretextLineHeight = pretextFontSize * 1.45;

        // Build columns edge-to-edge
        const numCols = isMobile ? 3 : 5;
        const margin = 20;
        const totalGap = pretextColumnGap * (numCols - 1);
        const colWidth = (width - margin * 2 - totalGap) / numCols;
        pretextColumns = [];
        for (let i = 0; i < numCols; i++) {
            const left = margin + i * (colWidth + pretextColumnGap);
            pretextColumns.push({ left: left, right: left + colWidth });
        }

        const font = `${pretextFontSize}px Satoshi-Regular`;
        pretextPrepared = pretext.prepareWithSegments(aboutText, font);
        pretextReady = true;
    } catch (e) {
        console.warn('Pretext failed to load:', e);
    }
}

// Each frame: reflow text around current ball positions using layoutNextLine
// Runs per-column, each column gets its own independent text stream
function reflowTextAroundBalls() {
    if (!pretextReady || !pretextPrepared || !pretextLayoutNextLine) return [];

    const startY = 80;
    const lh = pretextLineHeight;
    const padding = 6;
    const allLines = [];

    for (const col of pretextColumns) {
        let cursor = { segmentIndex: 0, graphemeIndex: 0 };
        let y = startY;

        while (y < height - footerHeight - lh) {
            let lineLeft = col.left;
            let lineRight = col.right;

            // Shrink this line around any overlapping blobs
            for (const blob of blobs) {
                const pos = blob.body.position;
                const angle = blob.body.angle;
                let blobLeft, blobRight, blobTop, blobBottom;

                if (blob.shape === 'square') {
                    // Compute exact left/right edges of the rotated square at this scanline
                    const halfSide = blob.radius * 1.6 / 2;
                    const cos_a = Math.cos(angle);
                    const sin_a = Math.sin(angle);

                    // Four corners of the square in world space
                    const corners = [
                        { x: pos.x + (-halfSide) * cos_a - (-halfSide) * sin_a, y: pos.y + (-halfSide) * sin_a + (-halfSide) * cos_a },
                        { x: pos.x + ( halfSide) * cos_a - (-halfSide) * sin_a, y: pos.y + ( halfSide) * sin_a + (-halfSide) * cos_a },
                        { x: pos.x + ( halfSide) * cos_a - ( halfSide) * sin_a, y: pos.y + ( halfSide) * sin_a + ( halfSide) * cos_a },
                        { x: pos.x + (-halfSide) * cos_a - ( halfSide) * sin_a, y: pos.y + (-halfSide) * sin_a + ( halfSide) * cos_a }
                    ];

                    // Scanline-edge intersection: find where the horizontal band [y, y+lh] crosses the rotated rect
                    const scanY = y + lh / 2; // use midpoint of line
                    let xIntersections = [];
                    for (let i = 0; i < 4; i++) {
                        const c1 = corners[i];
                        const c2 = corners[(i + 1) % 4];
                        const yMin = Math.min(c1.y, c2.y);
                        const yMax = Math.max(c1.y, c2.y);
                        if (scanY >= yMin && scanY <= yMax && yMax - yMin > 0.001) {
                            const t = (scanY - c1.y) / (c2.y - c1.y);
                            xIntersections.push(c1.x + t * (c2.x - c1.x));
                        }
                    }

                    if (xIntersections.length >= 2) {
                        blobLeft = Math.min(...xIntersections) - padding;
                        blobRight = Math.max(...xIntersections) + padding;
                        blobTop = Math.min(corners[0].y, corners[1].y, corners[2].y, corners[3].y) - padding;
                        blobBottom = Math.max(corners[0].y, corners[1].y, corners[2].y, corners[3].y) + padding;
                    } else {
                        continue; // scanline doesn't cross the square
                    }
                } else if (blob.shape === 'hexagon') {
                    const r = blob.radius + padding;
                    blobLeft = pos.x - r;
                    blobRight = pos.x + r;
                    blobTop = pos.y - r;
                    blobBottom = pos.y + r;
                } else {
                    // Circle — use chord math for smooth curving
                    const r = blob.radius + padding;
                    if (pos.y + r > y && pos.y - r < y + lh) {
                        const dy = Math.min(Math.abs(y + lh / 2 - pos.y), r);
                        const halfChord = Math.sqrt(Math.max(r * r - dy * dy, 0));
                        blobLeft = pos.x - halfChord;
                        blobRight = pos.x + halfChord;
                    } else {
                        continue;
                    }
                    blobTop = pos.y - r;
                    blobBottom = pos.y + r;
                }

                // Does this blob overlap the line's y range?
                if (blobBottom > y && blobTop < y + lh) {
                    if (blobRight > lineLeft && blobLeft < lineRight) {
                        const spaceRight = lineRight - blobRight;
                        const spaceLeft = blobLeft - lineLeft;

                        if (spaceRight >= spaceLeft) {
                            lineLeft = Math.max(lineLeft, blobRight);
                        } else {
                            lineRight = Math.min(lineRight, blobLeft);
                        }
                    }
                }
            }

            const availWidth = lineRight - lineLeft;
            if (availWidth < pretextFontSize * 3) {
                y += lh;
                continue;
            }

            const line = pretextLayoutNextLine(pretextPrepared, cursor, availWidth);
            if (!line) {
                // Text exhausted — wrap around and start repeating
                cursor = { segmentIndex: 0, graphemeIndex: 0 };
                const line2 = pretextLayoutNextLine(pretextPrepared, cursor, availWidth);
                if (!line2) break;
                allLines.push({ text: line2.text, x: lineLeft, y: y, width: line2.width });
                cursor = line2.end;
            } else {
                allLines.push({ text: line.text, x: lineLeft, y: y, width: line.width });
                cursor = line.end;
            }
            y += lh;
        }
    }

    return allLines;
}

function draw() {
    clear();

    // Update physics
    Engine.update(engine);

    // Reflow text around balls every frame, then draw
    if (pretextReady) {
        const reflowed = reflowTextAroundBalls();
        push();
        textFont('Satoshi-Regular');
        textSize(pretextFontSize);
        textAlign(LEFT, TOP);
        noStroke();
        fill(isDarkMode ? 0 : 255);
        for (const line of reflowed) {
            text(line.text, line.x, line.y);
        }
        pop();
    }

    // Draw and update blobs
    const isDark = pageIsDark();

    // Flip the label text colours with the shapes, but only when the mode
    // actually changes — this runs every frame.
    if (isDark !== lastLabelMode) {
        lastLabelMode = isDark;
        document.getElementById('canvas-container').classList.toggle('on-dark', isDark);
    }

    blobs.forEach((blob, index) => {
        const pos = blob.body.position;
        const angle = blob.body.angle;
        const palette = blobPalette(blob.artwork.isNew, isDark);

        push();
        translate(pos.x, pos.y);
        rotate(angle);

        // Minimal stroke for clean edges
        stroke(color(palette.stroke));
        strokeWeight(2);
        fill("#FFF");

        if (blob.shape === 'hexagon') {
            const r = blob.radius;
            // Regular hexagon centered at origin
            beginShape();
            for (let a = 0; a < 6; a++) {
                const angle_h = (TWO_PI / 6) * a - HALF_PI;
                vertex(cos(angle_h) * r, sin(angle_h) * r);
            }
            endShape(CLOSE);
        } else if (blob.shape === 'square') {
            const side = blob.radius * 1.6;
            rectMode(CENTER);
            rect(0, 0, side, side, 4); // 4px corner rounding
        } else {
            ellipse(0, 0, blob.radius * 2, blob.radius * 2);
        }

        pop();

        // Update label position
        const labelObj = labels[index];
        if (labelObj && labelObj.element) {
            labelObj.element.style.left = `${pos.x}px`;
            labelObj.element.style.top = `${pos.y}px`;
            labelObj.element.style.transform = `translate(-50%, -50%) rotate(${angle}rad)`;
        }
    });
}

function windowResized() {
    // Detect zoom by checking if devicePixelRatio changed
    const currentPixelRatio = window.devicePixelRatio || 1;
    if (Math.abs(currentPixelRatio - initialPixelRatio) > 0.01) {
        // This is a zoom event, not a resize - ignore it
        initialPixelRatio = currentPixelRatio;
        return;
    }

    // Get actual viewport dimensions
    const viewportHeight = window.visualViewport ? window.visualViewport.height : window.innerHeight;
    const viewportWidth = window.innerWidth;

    // Only resize if it's a significant change (actual resize, not zoom)
    const widthDiff = Math.abs(viewportWidth - initialWidth);
    const heightDiff = Math.abs(viewportHeight - initialHeight);

    // Threshold: only resize if dimensions changed by more than 100px (actual resize/rotation)
    if (widthDiff < 100 && heightDiff < 100) {
        return; // Ignore small changes
    }

    // Update stored dimensions
    initialWidth = viewportWidth;
    initialHeight = viewportHeight;

    resizeCanvas(viewportWidth, viewportHeight);

    // Update ground and walls position
    updateGroundPosition();

    // Update walls
    const thickness = 100;
    Body.setPosition(leftWall, { x: -thickness / 2, y: viewportHeight / 2 });
    Body.setPosition(rightWall, { x: viewportWidth + thickness / 2, y: viewportHeight / 2 });
}

// Mouse / touch drag interaction
let dragBlob = null;
let dragOffset = { x: 0, y: 0 };
let dragStart = { x: 0, y: 0 };
let isDragging = false;
let lastDragPos = { x: 0, y: 0 };
let prevDragPos = { x: 0, y: 0 };
let dragIndex = -1;
let touchLastTapTime = 0;

function initDragHandlers() {
    const container = document.getElementById('canvas-container');

    labels.forEach((labelObj, index) => {
        const el = labelObj.element;

        // Prevent default link behavior on mousedown/touchstart so we can detect drag
        const onStart = (e) => {
            const clientX = e.touches ? e.touches[0].clientX : e.clientX;
            const clientY = e.touches ? e.touches[0].clientY : e.clientY;
            const blob = blobs[index];
            const pos = blob.body.position;

            dragBlob = blob;
            dragIndex = index;
            dragOffset.x = pos.x - clientX;
            dragOffset.y = pos.y - clientY;
            dragStart.x = clientX;
            dragStart.y = clientY;
            lastDragPos.x = clientX;
            lastDragPos.y = clientY;
            prevDragPos.x = clientX;
            prevDragPos.y = clientY;
            isDragging = false;

            // Make body static while dragging so it doesn't fight gravity
            Body.setStatic(blob.body, true);
            document.body.style.cursor = 'grabbing';

            e.preventDefault();
        };

        el.addEventListener('mousedown', onStart);
        el.addEventListener('touchstart', onStart, { passive: false });

        // Block all clicks — navigation only via double-click/double-tap
        let lastTapTime = 0;
        el.addEventListener('click', (e) => {
            e.preventDefault();
            const now = Date.now();
            if (now - lastTapTime < 400) {
                // Double-tap/double-click
                if (blobs[index].artwork.href) {
                    window.location.href = blobs[index].artwork.href;
                }
                lastTapTime = 0;
                return;
            }
            lastTapTime = now;
            if (!isDragging) {
                // Show a brief hint
                let hint = el.querySelector('.click-hint');
                if (!hint) {
                    hint = document.createElement('div');
                    hint.className = 'click-hint';
                    hint.textContent = 'double-tap to open';
                    el.appendChild(hint);
                }
                hint.style.opacity = '1';
                clearTimeout(hint._timer);
                hint._timer = setTimeout(() => { hint.style.opacity = '0'; }, 1200);
            }
        });
        el.addEventListener('dblclick', (e) => {
            e.preventDefault();
            if (blobs[index].artwork.href) {
                window.location.href = blobs[index].artwork.href;
            }
        });
    });

    const onMove = (e) => {
        if (!dragBlob) return;
        const clientX = e.touches ? e.touches[0].clientX : e.clientX;
        const clientY = e.touches ? e.touches[0].clientY : e.clientY;

        const dx = clientX - dragStart.x;
        const dy = clientY - dragStart.y;

        if (!isDragging && (dx * dx + dy * dy) > 25) {
            isDragging = true;
        }

        if (isDragging) {
            // Clamp position within bounds (above footer, within walls)
            const viewportHeight = window.visualViewport ? window.visualViewport.height : window.innerHeight;
            const maxY = viewportHeight - footerHeight - dragBlob.radius;
            const clampedX = Math.max(dragBlob.radius, Math.min(window.innerWidth - dragBlob.radius, clientX + dragOffset.x));
            const clampedY = Math.max(dragBlob.radius, Math.min(maxY, clientY + dragOffset.y));
            Body.setPosition(dragBlob.body, {
                x: clampedX,
                y: clampedY
            });
            Body.setVelocity(dragBlob.body, { x: 0, y: 0 });
            prevDragPos.x = lastDragPos.x;
            prevDragPos.y = lastDragPos.y;
            lastDragPos.x = clientX;
            lastDragPos.y = clientY;
        }
    };

    const onEnd = (e) => {
        if (!dragBlob) return;

        const wasTouchEvent = e.type === 'touchend';

        // Release body back to dynamic
        Body.setStatic(dragBlob.body, false);

        // Throw it based on recent drag velocity
        if (isDragging) {
            const throwScale = 0.4;
            Body.setVelocity(dragBlob.body, {
                x: (lastDragPos.x - prevDragPos.x) * throwScale,
                y: (lastDragPos.y - prevDragPos.y) * throwScale
            });
        } else if (wasTouchEvent && dragIndex >= 0) {
            // Touch tap (not a drag) — detect double-tap
            const now = Date.now();
            if (now - touchLastTapTime < 400) {
                if (blobs[dragIndex].artwork.href) {
                    window.location.href = blobs[dragIndex].artwork.href;
                }
                touchLastTapTime = 0;
            } else {
                touchLastTapTime = now;
                // Show hint on single tap
                const el = labels[dragIndex].element;
                let hint = el.querySelector('.click-hint');
                if (!hint) {
                    hint = document.createElement('div');
                    hint.className = 'click-hint';
                    hint.textContent = 'double-tap to open';
                    el.appendChild(hint);
                }
                hint.style.opacity = '1';
                clearTimeout(hint._timer);
                hint._timer = setTimeout(() => { hint.style.opacity = '0'; }, 1200);
            }
        }

        document.body.style.cursor = '';
        dragBlob = null;
        dragIndex = -1;
        isDragging = false;
    };

    document.addEventListener('mousemove', onMove);
    document.addEventListener('touchmove', onMove, { passive: false });
    document.addEventListener('mouseup', onEnd);
    document.addEventListener('touchend', onEnd);
}

// Fix race condition: recalculate ground position after footer loads
window.addEventListener('load', function() {
    // Immediate update
    updateGroundPosition();

    // Also update after short delays to catch late-loading footer
    setTimeout(updateGroundPosition, 100);
    setTimeout(updateGroundPosition, 500);
    setTimeout(updateGroundPosition, 1000);
});
</script>

</body>
<?php include 'footer.php'; ?>
</html>

