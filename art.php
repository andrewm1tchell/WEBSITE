<!DOCTYPE html>
<html lang="en">
<?php include 'meta.php'; ?>
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
        height: 100dvh;
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

    .blob-label .title,
    .blob-label .year,
    .blob-label .collab,
    .blob-label .collab a {
        color: var(--white) !important;
    }

    .blob-label:hover .title {
        color: rgba(255, 255, 255, 0.9) !important;
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
        color: var(--white);
        opacity: 0;
        transition: opacity 0.3s ease;
        white-space: nowrap;
        pointer-events: none;
        text-shadow: 0 1px 3px rgba(0,0,0,0.5);
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
        .blob-label .title { font-size: 0.65rem; }
        .blob-label .year { font-size: 0.45rem; }
        .blob-label .collab,
        .blob-label .collab a { font-size: 0.4rem; }
        .new-badge { font-size: 0.4em; padding: 2px 5px; margin-left: 4px; }
        .view-collections-btn { bottom: 50px; right: 15px; padding: 4px 6px; font-size: 0.8em; }
    }
</style>

<div id="canvas-container"></div>

<script>
const artworks = [
    { title: "NOKORI", year: "2026", href: "art/nokori.php", isNew: true },
    { title: "???", year: "", href: "art/untitled.php" },
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

const { Engine, World, Bodies, Body } = Matter;

let engine, world, blobs = [], labels = [];
let ground, leftWall, rightWall;
let footerHeight = 60;
let initialWidth, initialHeight, initialPixelRatio;

let cursorX = -9999, cursorY = -9999;
document.addEventListener('mousemove', e => { cursorX = e.clientX; cursorY = e.clientY; });
document.addEventListener('touchmove', e => { cursorX = e.touches[0].clientX; cursorY = e.touches[0].clientY; });
document.addEventListener('touchend', () => { cursorX = -9999; cursorY = -9999; });
document.addEventListener('touchcancel', () => { cursorX = -9999; cursorY = -9999; });

let hasGyro = false;
let baseGravityY = 0.9;

function handleOrientation(e) {
    if (!engine || e.gamma === null || e.beta === null) return;
    hasGyro = true;
    const gamma = Math.max(-90, Math.min(90, e.gamma));
    const beta = Math.max(-90, Math.min(90, e.beta));
    engine.world.gravity.x = gamma / 90;
    engine.world.gravity.y = Math.max(0.15, beta / 90);
}

function enableGyro() {
    if (typeof DeviceOrientationEvent !== 'undefined' &&
        typeof DeviceOrientationEvent.requestPermission === 'function') {
        DeviceOrientationEvent.requestPermission().then(function(state) {
            if (state === 'granted') window.addEventListener('deviceorientation', handleOrientation);
        }).catch(function() {});
    } else {
        window.addEventListener('deviceorientation', handleOrientation);
    }
}

document.addEventListener('touchstart', function gyroInit() {
    enableGyro();
    document.removeEventListener('touchstart', gyroInit);
}, { once: true });

let pretextPrepared = null;
let pretextLayoutNextLine = null;
let pretextReady = false;
let pretextFontSize = 9;
let pretextLineHeight = 13;
let pretextColumns = [];
const pretextColumnGap = 14;

const blobColor = { fill: 'hsl(220, 85%, 15%)', stroke: 'hsl(220, 85%, 25%)' };
const newHue = [0, 25, 45, 145, 330][Math.floor(Math.random() * 5)];
const blobColorNew = { fill: `hsl(${newHue}, 85%, 32%)`, stroke: `hsl(${newHue}, 85%, 44%)` };

function updateGroundPosition() {
    const vh = window.visualViewport ? window.visualViewport.height : window.innerHeight;
    const vw = window.innerWidth;
    const footer = document.getElementById('footer');
    if (footer && footer.offsetHeight > 0) footerHeight = footer.offsetHeight;

    const thickness = 100;
    const groundY = vh - footerHeight + thickness / 2;
    if (ground) {
        Body.setPosition(ground, { x: vw / 2, y: groundY });
        Body.setVertices(ground, Bodies.rectangle(vw / 2, groundY, vw * 2, thickness).vertices);
    }
}

function setup() {
    const vh = window.visualViewport ? window.visualViewport.height : window.innerHeight;
    const vw = window.innerWidth;
    initialWidth = vw;
    initialHeight = vh;
    initialPixelRatio = window.devicePixelRatio || 1;

    const footer = document.getElementById('footer');
    if (footer && footer.offsetHeight > 0) footerHeight = footer.offsetHeight;

    const canvas = createCanvas(vw, vh);
    canvas.parent('canvas-container');

    const isMobile = vw < 768;
    baseGravityY = isMobile ? 0.5 : 0.9;

    engine = Engine.create();
    world = engine.world;
    engine.world.gravity.y = baseGravityY;
    engine.positionIterations = 20;
    engine.velocityIterations = 16;

    const thickness = 100;
    const groundY = vh - footerHeight + thickness / 2;
    ground = Bodies.rectangle(vw / 2, groundY, vw * 2, thickness, { isStatic: true });
    leftWall = Bodies.rectangle(-thickness / 2, vh / 2, thickness, vh * 3, { isStatic: true });
    rightWall = Bodies.rectangle(vw + thickness / 2, vh / 2, thickness, vh * 3, { isStatic: true });
    World.add(world, [ground, leftWall, rightWall]);

    const minR = isMobile ? min(width, height) * 0.15 : min(width, height) * 0.12;
    const maxR = isMobile ? min(width, height) * 0.20 : min(width, height) * 0.18;
    const shapeTypes = ['circle', 'square'];

    artworks.forEach((art, i) => {
        const r = art.isNew ? maxR : random(minR, maxR);
        const x = random(r, width - r);
        const y = isMobile
            ? -r - (i * r * 3.5) - random(100, 250)
            : -r - (i * r * 2.5) - random(50, 150);

        const opts = {
            restitution: isMobile ? 0.95 : 0.8,
            friction: isMobile ? 0.02 : 0.05,
            frictionAir: isMobile ? 0.006 : 0.008,
            density: 0.004,
            slop: 0.001
        };

        const shape = art.isNew ? 'circle' : shapeTypes[i % shapeTypes.length];
        let body;
        if (shape === 'hexagon') {
            body = Bodies.polygon(x, y, 6, r, opts);
        } else if (shape === 'square') {
            body = Bodies.rectangle(x, y, r * 1.6, r * 1.6, { ...opts, chamfer: { radius: 4 } });
        } else {
            body = Bodies.circle(x, y, r, opts);
        }

        Body.setVelocity(body, { x: random(-1, 1), y: isMobile ? random(0, 0.5) : random(0, 2) });
        World.add(world, body);

        blobs.push({
            body, radius: r,
            color: art.isNew ? blobColorNew : blobColor,
            artwork: art, shape
        });
        createLabel(art, i, r, shape);
    });

    prepareText();
    initDragHandlers();

    try {
        var saved = sessionStorage.getItem('artBlobState');
        if (saved) {
            var state = JSON.parse(saved);
            if (state.count === blobs.length
                && Math.abs(state.viewportWidth - vw) < 100
                && Math.abs(state.viewportHeight - vh) < 100) {
                blobs.forEach(function(blob, i) {
                    if (state.positions[i]) {
                        Body.setPosition(blob.body, { x: state.positions[i].x, y: state.positions[i].y });
                        Body.setAngle(blob.body, state.positions[i].angle);
                        Body.setVelocity(blob.body, { x: 0, y: 0 });
                        Body.setAngularVelocity(blob.body, 0);
                    }
                });
            }
        }
    } catch (e) {}
}

function createLabel(artwork, index, radius, shape) {
    const el = document.createElement('a');
    el.className = 'blob-label';
    el.id = `label-${index}`;
    el.href = artwork.href;
    el.title = 'Double-click to open';

    const size = radius * 2;
    if (shape === 'square') {
        const side = radius * 1.6;
        el.style.width = `${side}px`;
        el.style.height = `${side}px`;
        el.style.borderRadius = '4px';
    } else if (shape === 'hexagon') {
        el.style.width = `${size}px`;
        el.style.height = `${size}px`;
        el.style.borderRadius = '0';
        el.style.clipPath = 'polygon(50% 0%, 93% 25%, 93% 75%, 50% 100%, 7% 75%, 7% 25%)';
        el.style.webkitClipPath = 'polygon(50% 0%, 93% 25%, 93% 75%, 50% 100%, 7% 75%, 7% 25%)';
    } else {
        el.style.width = `${size}px`;
        el.style.height = `${size}px`;
    }

    el.innerHTML = `
        <div class="year">${artwork.year}</div>
        <div class="title">${artwork.title}</div>
        ${artwork.collab ? `<div class="collab">${artwork.collab}</div>` : ''}
    `;

    document.getElementById('canvas-container').appendChild(el);
    labels.push({ element: el, radius });
}

async function prepareText() {
    await document.fonts.ready;
    try {
        const pretext = await import('https://esm.sh/@chenglou/pretext');
        pretextLayoutNextLine = pretext.layoutNextLine;

        const jp = "絵を作る。世界の広さに身を任せる。遊ぶ。自分の公理で作る。絵を見に行く。新しい人に会う。友達を見つける。白昼夢を見る。失敗する。もっと絵を作る。";
        const en = "Never stop creating. Lose yourself in the vastness of the world. Play. Work with your axioms. Seek art. Meet new people. Make friends. Daydream. Embrace mistakes. Create more.";

        const isMobile = width < 768;
        pretextFontSize = isMobile ? 8 : 16;
        pretextLineHeight = pretextFontSize * 1.45;

        const numCols = isMobile ? 3 : 5;
        const margin = 20;
        const totalGap = pretextColumnGap * (numCols - 1);
        const colW = (width - margin * 2 - totalGap) / numCols;
        pretextColumns = [];
        const colTexts = [];

        for (let i = 0; i < numCols; i++) {
            const left = margin + i * (colW + pretextColumnGap);
            pretextColumns.push({ left, right: left + colW });
            colTexts.push((i % 2 === 0) ? jp.repeat(40) : en.repeat(40));
        }

        const font = `${pretextFontSize}px Satoshi-Regular`;
        pretextPrepared = colTexts.map(t => pretext.prepareWithSegments(t, font));
        pretextReady = true;
    } catch (e) {
        console.warn('Pretext load failed:', e);
    }
}

function reflowTextAroundBalls() {
    if (!pretextReady || !pretextPrepared || !pretextLayoutNextLine) return [];

    const startY = 80;
    const lh = pretextLineHeight;
    const pad = 6;
    const out = [];

    pretextColumns.forEach((col, ci) => {
        let cursor = { segmentIndex: 0, graphemeIndex: 0 };
        let y = startY;
        const prepared = pretextPrepared[ci];

        while (y < height - footerHeight - lh) {
            let lineL = col.left, lineR = col.right;

            for (const blob of blobs) {
                const pos = blob.body.position;
                const ang = blob.body.angle;
                let bL, bR, bT, bB;

                if (blob.shape === 'square') {
                    const hs = blob.radius * 1.6 / 2;
                    const ca = Math.cos(ang), sa = Math.sin(ang);
                    const corners = [
                        { x: pos.x - hs * ca + hs * sa, y: pos.y - hs * sa - hs * ca },
                        { x: pos.x + hs * ca + hs * sa, y: pos.y + hs * sa - hs * ca },
                        { x: pos.x + hs * ca - hs * sa, y: pos.y + hs * sa + hs * ca },
                        { x: pos.x - hs * ca - hs * sa, y: pos.y - hs * sa + hs * ca }
                    ];
                    const scanY = y + lh / 2;
                    let xs = [];
                    for (let i = 0; i < 4; i++) {
                        const c1 = corners[i], c2 = corners[(i + 1) % 4];
                        const yMin = Math.min(c1.y, c2.y), yMax = Math.max(c1.y, c2.y);
                        if (scanY >= yMin && scanY <= yMax && yMax - yMin > 0.001) {
                            const t = (scanY - c1.y) / (c2.y - c1.y);
                            xs.push(c1.x + t * (c2.x - c1.x));
                        }
                    }
                    if (xs.length >= 2) {
                        bL = Math.min(...xs) - pad;
                        bR = Math.max(...xs) + pad;
                        bT = Math.min(...corners.map(c => c.y)) - pad;
                        bB = Math.max(...corners.map(c => c.y)) + pad;
                    } else continue;
                } else if (blob.shape === 'hexagon') {
                    const r = blob.radius + pad;
                    bL = pos.x - r; bR = pos.x + r;
                    bT = pos.y - r; bB = pos.y + r;
                } else {
                    const r = blob.radius + pad;
                    if (pos.y + r > y && pos.y - r < y + lh) {
                        const dy = Math.min(Math.abs(y + lh / 2 - pos.y), r);
                        const halfChord = Math.sqrt(Math.max(r * r - dy * dy, 0));
                        bL = pos.x - halfChord;
                        bR = pos.x + halfChord;
                    } else continue;
                    bT = pos.y - r; bB = pos.y + r;
                }

                if (bB > y && bT < y + lh && bR > lineL && bL < lineR) {
                    if (lineR - bR >= bL - lineL) lineL = Math.max(lineL, bR);
                    else lineR = Math.min(lineR, bL);
                }
            }

            const avail = lineR - lineL;
            if (avail < pretextFontSize * 3) { y += lh; continue; }

            const line = pretextLayoutNextLine(prepared, cursor, avail);
            if (!line) {
                cursor = { segmentIndex: 0, graphemeIndex: 0 };
                const line2 = pretextLayoutNextLine(prepared, cursor, avail);
                if (!line2) break;
                out.push({ text: line2.text, x: lineL, y, width: line2.width });
                cursor = line2.end;
            } else {
                out.push({ text: line.text, x: lineL, y, width: line.width });
                cursor = line.end;
            }
            y += lh;
        }
    });

    return out;
}

function draw() {
    clear();
    Engine.update(engine);

    const vh = window.visualViewport ? window.visualViewport.height : window.innerHeight;
    const vw = window.innerWidth;
    const margin = 300;
    blobs.forEach(blob => {
        const p = blob.body.position;
        if (p.x < -margin || p.x > vw + margin || p.y < -margin * 4 || p.y > vh + margin) {
            Body.setPosition(blob.body, { x: vw / 2 + (Math.random() - 0.5) * vw * 0.5, y: -blob.radius * 2 });
            Body.setVelocity(blob.body, { x: 0, y: 0 });
            Body.setAngularVelocity(blob.body, 0);
        }
    });

    if (pretextReady) {
        const lines = reflowTextAroundBalls();
        push();
        textFont('Satoshi-Regular');
        textSize(pretextFontSize);
        textAlign(LEFT, TOP);
        noStroke();
        fill(isDarkMode ? 0 : 255);
        for (const ln of lines) text(ln.text, ln.x, ln.y);
        pop();
    }

    blobs.forEach((blob, i) => {
        const pos = blob.body.position;
        const ang = blob.body.angle;

        push();
        translate(pos.x, pos.y);
        rotate(ang);
        stroke(blob.color.stroke);
        strokeWeight(2);
        fill(blob.color.fill);

        if (blob.shape === 'hexagon') {
            beginShape();
            for (let a = 0; a < 6; a++) {
                const th = (TWO_PI / 6) * a - HALF_PI;
                vertex(cos(th) * blob.radius, sin(th) * blob.radius);
            }
            endShape(CLOSE);
        } else if (blob.shape === 'square') {
            const s = blob.radius * 1.6;
            rectMode(CENTER);
            rect(0, 0, s, s, 4);
        } else {
            ellipse(0, 0, blob.radius * 2, blob.radius * 2);
        }
        pop();

        const lbl = labels[i];
        if (lbl && lbl.element) {
            lbl.element.style.left = `${pos.x}px`;
            lbl.element.style.top = `${pos.y}px`;
            lbl.element.style.transform = `translate(-50%, -50%) rotate(${ang}rad)`;
        }
    });
}

function windowResized() {
    const dpr = window.devicePixelRatio || 1;
    if (Math.abs(dpr - initialPixelRatio) > 0.01) {
        initialPixelRatio = dpr;
        return;
    }

    const vh = window.visualViewport ? window.visualViewport.height : window.innerHeight;
    const vw = window.innerWidth;
    if (Math.abs(vw - initialWidth) < 100 && Math.abs(vh - initialHeight) < 100) return;

    initialWidth = vw;
    initialHeight = vh;
    resizeCanvas(vw, vh);
    updateGroundPosition();

    const thickness = 100;
    Body.setPosition(leftWall, { x: -thickness / 2, y: vh / 2 });
    Body.setPosition(rightWall, { x: vw + thickness / 2, y: vh / 2 });
}

let dragBlob = null;
let dragOffset = { x: 0, y: 0 };
let dragStart = { x: 0, y: 0 };
let isDragging = false;
let lastDragPos = { x: 0, y: 0 };
let prevDragPos = { x: 0, y: 0 };
let dragIndex = -1;
let touchLastTapTime = 0;

function initDragHandlers() {
    labels.forEach((lbl, index) => {
        const el = lbl.element;

        const onStart = (e) => {
            const cx = e.touches ? e.touches[0].clientX : e.clientX;
            const cy = e.touches ? e.touches[0].clientY : e.clientY;
            const pos = blobs[index].body.position;

            dragBlob = blobs[index];
            dragIndex = index;
            dragOffset.x = pos.x - cx;
            dragOffset.y = pos.y - cy;
            dragStart.x = cx;
            dragStart.y = cy;
            lastDragPos.x = cx;
            lastDragPos.y = cy;
            prevDragPos.x = cx;
            prevDragPos.y = cy;
            isDragging = false;

            Body.setStatic(dragBlob.body, true);
            document.body.style.cursor = 'grabbing';
            e.preventDefault();
        };

        el.addEventListener('mousedown', onStart);
        el.addEventListener('touchstart', onStart, { passive: false });

        let lastTapTime = 0;
        el.addEventListener('click', (e) => {
            e.preventDefault();
            const now = Date.now();
            if (now - lastTapTime < 400) {
                if (blobs[index].artwork.href) window.location.href = blobs[index].artwork.href;
                lastTapTime = 0;
                return;
            }
            lastTapTime = now;
            if (!isDragging) showHint(el);
        });
        el.addEventListener('dblclick', (e) => {
            e.preventDefault();
            if (blobs[index].artwork.href) window.location.href = blobs[index].artwork.href;
        });
    });

    const onMove = (e) => {
        if (!dragBlob) return;
        const cx = e.touches ? e.touches[0].clientX : e.clientX;
        const cy = e.touches ? e.touches[0].clientY : e.clientY;
        const dx = cx - dragStart.x, dy = cy - dragStart.y;

        if (!isDragging && dx * dx + dy * dy > 25) isDragging = true;

        if (isDragging) {
            const vh = window.visualViewport ? window.visualViewport.height : window.innerHeight;
            const maxY = vh - footerHeight - dragBlob.radius;
            Body.setPosition(dragBlob.body, {
                x: Math.max(dragBlob.radius, Math.min(window.innerWidth - dragBlob.radius, cx + dragOffset.x)),
                y: Math.max(dragBlob.radius, Math.min(maxY, cy + dragOffset.y))
            });
            Body.setVelocity(dragBlob.body, { x: 0, y: 0 });
            prevDragPos.x = lastDragPos.x;
            prevDragPos.y = lastDragPos.y;
            lastDragPos.x = cx;
            lastDragPos.y = cy;
        }
    };

    const onEnd = (e) => {
        if (!dragBlob) return;
        Body.setStatic(dragBlob.body, false);

        if (isDragging) {
            Body.setVelocity(dragBlob.body, {
                x: (lastDragPos.x - prevDragPos.x) * 0.4,
                y: (lastDragPos.y - prevDragPos.y) * 0.4
            });
        } else if (e.type === 'touchend' && dragIndex >= 0) {
            const now = Date.now();
            if (now - touchLastTapTime < 400) {
                if (blobs[dragIndex].artwork.href) window.location.href = blobs[dragIndex].artwork.href;
                touchLastTapTime = 0;
            } else {
                touchLastTapTime = now;
                showHint(labels[dragIndex].element);
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

function showHint(el) {
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

window.addEventListener('load', function() {
    updateGroundPosition();
    setTimeout(updateGroundPosition, 100);
    setTimeout(updateGroundPosition, 500);
    setTimeout(updateGroundPosition, 1000);
});

window.addEventListener('beforeunload', function() {
    if (!blobs.length) return;
    sessionStorage.setItem('artBlobState', JSON.stringify({
        viewportWidth: window.innerWidth,
        viewportHeight: window.visualViewport ? window.visualViewport.height : window.innerHeight,
        count: blobs.length,
        positions: blobs.map(b => ({ x: b.body.position.x, y: b.body.position.y, angle: b.body.angle }))
    }));
});
</script>

</body>
<?php include 'footer.php'; ?>
</html>
