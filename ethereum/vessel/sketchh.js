//Angels by Andrew Mitchell
const SVG_NS = 'http://www.w3.org/2000/svg';
const WIDTH = 1500;
const HEIGHT = 2000;

class Random {
  constructor(hash) {
    this.seed = this.hashToSeed(hash);
  }

  hashToSeed(hash) {
    const clean = hash.startsWith('0x') ? hash.slice(2) : hash;
    let seed = 0;
    for (let i = 0; i < clean.length; i++) {
      seed = ((seed << 5) - seed) + clean.charCodeAt(i);
      seed = seed >>> 0;
    }
    return seed;
  }

  next() {
    this.seed += 0x6D2B79F5;
    let t = this.seed;
    t = Math.imul(t ^ (t >>> 15), t | 1);
    t ^= t + Math.imul(t ^ (t >>> 7), t | 61);
    return ((t ^ (t >>> 14)) >>> 0) / 4294967296;
  }

  decimal(min = 0, max = 1) {
    return min + this.next() * (max - min);
  }

  int(min, max) {
    return Math.floor(this.decimal(min, max + 1));
  }

  bool(probability = 0.5) {
    return this.next() < probability;
  }
}

function generateHash() {
  const bytes = new Uint8Array(32);
  crypto.getRandomValues(bytes);
  return '0x' + Array.from(bytes).map(b => b.toString(16).padStart(2, '0')).join('');
}

function getSeedOverride() {
  if (typeof location !== 'undefined' && location.search) {
    const q = new URLSearchParams(location.search).get('seed');
    if (q) return q;
  }
  return null;
}

let HASH = getSeedOverride() || window.__ANGEL_HASH__ || generateHash();
let rng, IS_LIGHT, OUTER_BG, STROKE_SCALE, OPACITY_SCALE, STROKE_MIN_SCALE,
  STEP_LENGTH, DEPTH_OPACITY_MIN, TEXTURE2_SATURATION, ANGLE_MULTIPLIER,
  FLOW_SCALE, Z_MIN, REVEAL_WINDOW_MS, REVEAL_PATH_MS;

function getTheme(hash) {
  let override = window.__MUGEN_THEME__;
  if (typeof location !== 'undefined' && location.search) {
    const q = new URLSearchParams(location.search).get('theme');
    if (q) override = q;
  }
  if (override === 'light' || override === 'dark') return override;
  const clean = hash.startsWith('0x') ? hash.slice(2) : hash;
  const b = parseInt(clean.slice(2, 4), 16);
  return b < 77 ? 'light' : 'dark';
}

function getFlatMode() {
  if (window.__ANGEL_FLAT__) return true;
  if (typeof location !== 'undefined' && location.search) {
    return new URLSearchParams(location.search).get('flat') === '1';
  }
  return false;
}

const IS_FLAT = getFlatMode();
const IS_DESKTOP = typeof window.matchMedia === 'function' &&
  window.matchMedia('(hover: hover) and (pointer: fine)').matches;

function getAngleMultiplier(hash) {
  const clean = hash.startsWith('0x') ? hash.slice(2) : hash;
  const index = parseInt(clean.slice(0, 2), 16) % 4;
  return [2, 3, 4, 5][index];
}

// Derives every seed-dependent constant from `hash`, in the exact draw
// order the original top-level initialization used (Random is a seeded
// PRNG, so reordering these draws changes the output). Called once at
// load, and again by loadSeed() to reseed in place without navigating —
// location.href navigation is unavailable when this script runs from a
// data: URI (e.g. embedded via AnimationRenderer's animation_url).
function deriveState(hash) {
  rng = new Random(hash);
  IS_LIGHT = getTheme(hash) === 'light';
  OUTER_BG = IS_LIGHT ? '#fff' : '#000';
  STROKE_SCALE = IS_LIGHT ? (rng.bool(0.5) ? 1.2 : 1.5) : (rng.bool(0.5) ? 1 : 1.3);
  OPACITY_SCALE = IS_LIGHT ? 1.5 : 1;
  STROKE_MIN_SCALE = rng.decimal(0.1, 0.8);
  STEP_LENGTH = rng.bool(0.5) ? 20 : 30;
  DEPTH_OPACITY_MIN = rng.bool(0.5) ? 0.3 : 0.4;
  TEXTURE2_SATURATION = rng.decimal(10, 70);
  ANGLE_MULTIPLIER = getAngleMultiplier(hash);
  FLOW_SCALE = (() => {
    const min = 0.001;
    const max = 0.005;
    const mode = 0.00314;
    const u = rng.next();
    const m = (mode - min) / (max - min);
    const t = u < m
      ? Math.sqrt(u * m)
      : 1 - Math.sqrt((1 - u) * (1 - m));
    return min + t * (max - min);
  })();
  Z_MIN = rng.decimal(0.01, 0.62);
  REVEAL_WINDOW_MS = STEP_LENGTH === 20 ? 2400 : 1800;
  REVEAL_PATH_MS = STEP_LENGTH === 20 ? 400 : 200;
}

deriveState(HASH);

// Persistent UI chrome (seed-control widget, context menu, refresh dot) is
// created once and reused across in-place reseeds (see loadSeed()), unlike
// the artwork's own <svg>, which regenerate() rebuilds from scratch every
// time. Anything whose styling depends on IS_LIGHT registers a refresh
// callback here so loadSeed() can re-apply it after a theme-changing reseed
// — otherwise a seed with a different light/dark theme than the one the
// page first loaded with leaves stale colors on the buttons and seed list.
const themeListeners = [];
function onThemeChange(fn) {
  themeListeners.push(fn);
}
function applyTheme() {
  themeListeners.forEach(fn => fn());
}

let noiseSeed = 0;

function noise(x, y) {
  const xi = Math.floor(x);
  const yi = Math.floor(y);
  const xf = x - xi;
  const yf = y - yi;

  const u = xf * xf * (3 - 2 * xf);
  const v = yf * yf * (3 - 2 * yf);

  const hash = (px, py) => {
    const n = Math.sin(px * 127.1 + py * 311.7 + noiseSeed) * 43758.5453;
    return n - Math.floor(n);
  };

  const a = hash(xi, yi);
  const b = hash(xi + 1, yi);
  const c = hash(xi, yi + 1);
  const d = hash(xi + 1, yi + 1);

  return a + u * (b - a) + v * (c - a) + u * v * (a - b - c + d);
}

let angleOffset = 0;

function getAngle(x, y) {
  return noise(x * FLOW_SCALE, y * FLOW_SCALE) * Math.PI * ANGLE_MULTIPLIER + angleOffset;
}

const VANISHING_POINT = { x: WIDTH / 2, y: HEIGHT / 2 };
const Z_MAX = 0.98;

function applyPerspective(points, z) {
  return points.map(p => {
    const dx = p.x - VANISHING_POINT.x;
    const dy = p.y - VANISHING_POINT.y;
    return {
      x: VANISHING_POINT.x + dx * z,
      y: VANISHING_POINT.y + dy * z
    };
  });
}

function createPath(points, strokeWidth, opacity) {
  const path = document.createElementNS(SVG_NS, 'path');
  let d = `M ${points[0].x} ${points[0].y}`;
  for (let i = 1; i < points.length; i++) {
    d += ` L ${points[i].x} ${points[i].y}`;
  }
  path.setAttribute('d', d);
  path.setAttribute('fill', 'none');
  path.setAttribute('stroke', `rgba(255,255,255,${opacity})`);
  path.setAttribute('stroke-width', strokeWidth);
  path.setAttribute('stroke-linecap', 'round');
  return path;
}

function flowLine(startX, startY, steps, depth = 3, branchPaths = []) {
  const points = [];
  let x = startX;
  let y = startY;

  for (let i = 0; i < steps; i++) {
    points.push({ x, y });
    let angle = getAngle(x, y);
    angle += rng.decimal(-0.65, 0.65);
    x += Math.cos(angle) * STEP_LENGTH;
    y += Math.sin(angle) * STEP_LENGTH;

    if (x < 0 || x > WIDTH || y < 0 || y > HEIGHT) break;

    if (depth > 0 && i > 5 && rng.bool(0.03)) {
      const branchAngle = angle + rng.decimal(-0.5, 0.5);
      const branchSteps = Math.floor(steps * rng.decimal(0.4, 0.7));
      const bx = x + Math.cos(branchAngle) * STEP_LENGTH;
      const by = y + Math.sin(branchAngle) * STEP_LENGTH;
      flowLine(bx, by, branchSteps, depth - 1, branchPaths);
    }
  }

  if (points.length > 1) {
    branchPaths.push(points);
  }

  return branchPaths;
}

function createSVG() {
  const svg = document.createElementNS(SVG_NS, 'svg');
  svg.setAttribute('width', '100%');
  svg.setAttribute('height', '100%');
  svg.setAttribute('viewBox', `0 0 ${WIDTH} ${HEIGHT}`);
  svg.setAttribute('preserveAspectRatio', 'xMidYMid meet');
  svg.style.background = OUTER_BG;

  return svg;
}

function buildDensityMap(allPaths, cellSize = 100) {
  const cols = Math.ceil(WIDTH / cellSize);
  const rows = Math.ceil(HEIGHT / cellSize);
  const density = Array(cols * rows).fill(0);

  for (const points of allPaths) {
    for (const p of points) {
      const col = Math.floor(p.x / cellSize);
      const row = Math.floor(p.y / cellSize);
      if (col >= 0 && col < cols && row >= 0 && row < rows) {
        density[row * cols + col]++;
      }
    }
  }

  return { density, cols, rows, cellSize };
}

function pathInDenseArea(points, densityMap, threshold) {
  const { density, cols, rows, cellSize } = densityMap;
  let denseCount = 0;

  for (const p of points) {
    const col = Math.floor(p.x / cellSize);
    const row = Math.floor(p.y / cellSize);
    if (col >= 0 && col < cols && row >= 0 && row < rows) {
      if (density[row * cols + col] > threshold) {
        denseCount++;
      }
    }
  }

  return denseCount > points.length * 0.8;
}

const FRAME_MARGIN = HEIGHT * 0.015;
const BACK_INSET_X = WIDTH * 0.30;
const BACK_INSET_Y = HEIGHT * 0.30;

function handDrawnEdge(p1, p2, segments = 24, jitter = 1.2) {
  const points = [];
  for (let i = 0; i <= segments; i++) {
    const t = i / segments;
    const x = p1.x + (p2.x - p1.x) * t + rng.decimal(-jitter, jitter);
    const y = p1.y + (p2.y - p1.y) * t + rng.decimal(-jitter, jitter);
    points.push({ x, y });
  }
  return points;
}

function addRoom(svg) {
  const fTL = { x: FRAME_MARGIN, y: FRAME_MARGIN };
  const fTR = { x: WIDTH - FRAME_MARGIN, y: FRAME_MARGIN };
  const fBR = { x: WIDTH - FRAME_MARGIN, y: HEIGHT - FRAME_MARGIN };
  const fBL = { x: FRAME_MARGIN, y: HEIGHT - FRAME_MARGIN };

  const bTL = { x: BACK_INSET_X, y: BACK_INSET_Y };
  const bTR = { x: WIDTH - BACK_INSET_X, y: BACK_INSET_Y };
  const bBR = { x: WIDTH - BACK_INSET_X, y: HEIGHT - BACK_INSET_Y };
  const bBL = { x: BACK_INSET_X, y: HEIGHT - BACK_INSET_Y };

  const edges = [
    [fTL, fTR], [fTR, fBR], [fBR, fBL], [fBL, fTL],
    [bTL, bTR], [bTR, bBR], [bBR, bBL], [bBL, bTL],
    [fTL, bTL], [fTR, bTR], [fBR, bBR], [fBL, bBL]
  ];

  for (const [a, b] of edges) {
    const points = handDrawnEdge(a, b);
    const strokeWidth = rng.decimal(0.4, 1.2);
    const opacity = rng.decimal(0.6, 1.0);
    svg.appendChild(createPath(points, strokeWidth, opacity));
  }
}

function scribblePoints(x, y) {
  const numSegments = rng.int(2, 5);
  let px = x;
  let py = y;
  const points = [{ x: px, y: py }];
  for (let s = 0; s < numSegments; s++) {
    const segLen = rng.decimal(3, 8);
    const segAngle = rng.decimal(0, Math.PI * 2);
    px += Math.cos(segAngle) * segLen;
    py += Math.sin(segAngle) * segLen;
    points.push({ x: px, y: py });
  }
  return points;
}

function bezierScratchPoints(x, y) {
  const len = rng.decimal(5, 20);
  const angle = rng.decimal(0, Math.PI * 2);
  const x2 = x + Math.cos(angle) * len;
  const y2 = y + Math.sin(angle) * len;
  const c1 = { x: x + rng.decimal(-8, 8), y: y + rng.decimal(-8, 8) };
  const c2 = { x: x2 + rng.decimal(-8, 8), y: y2 + rng.decimal(-8, 8) };

  const points = [];
  const steps = 10;
  for (let i = 0; i <= steps; i++) {
    const t = i / steps;
    const mt = 1 - t;
    points.push({
      x: mt * mt * mt * x + 3 * mt * mt * t * c1.x + 3 * mt * t * t * c2.x + t * t * t * x2,
      y: mt * mt * mt * y + 3 * mt * mt * t * c1.y + 3 * mt * t * t * c2.y + t * t * t * y2
    });
  }
  return points;
}

function loopScribblePoints(x, y) {
  const loopSize = rng.decimal(2, 6);
  const numPoints = rng.int(4, 8);
  const points = [];
  for (let p = 0; p <= numPoints; p++) {
    const t = p / numPoints;
    points.push({
      x: x + Math.cos(t * Math.PI * 4) * loopSize + rng.decimal(-1, 1),
      y: y + Math.sin(t * Math.PI * 4) * loopSize * 0.5 + t * loopSize * 2 + rng.decimal(-1, 1)
    });
  }
  return points;
}

function addScratches(svg) {
  const count = 140;
  for (let i = 0; i < count; i++) {
    const x = rng.decimal(0, WIDTH);
    const y = rng.decimal(0, HEIGHT);
    const opacity = rng.decimal(0.05, 0.35);
    const strokeWidth = rng.decimal(0.15, 0.5);

    const type = rng.int(0, 2);
    let points;
    if (type === 0) points = scribblePoints(x, y);
    else if (type === 1) points = bezierScratchPoints(x, y);
    else points = loopScribblePoints(x, y);

    svg.appendChild(createPath(points, strokeWidth, opacity));
  }
}

function getDefs(svg) {
  let defs = svg.querySelector('defs');
  if (!defs) {
    defs = document.createElementNS(SVG_NS, 'defs');
    svg.insertBefore(defs, svg.firstChild);
  }
  return defs;
}

function addGrain(svg, container) {
  const defs = getDefs(svg);

  const filter = document.createElementNS(SVG_NS, 'filter');
  filter.setAttribute('id', 'grain');
  filter.setAttribute('x', '0%');
  filter.setAttribute('y', '0%');
  filter.setAttribute('width', '100%');
  filter.setAttribute('height', '100%');

  const turbulence = document.createElementNS(SVG_NS, 'feTurbulence');
  turbulence.setAttribute('type', 'fractalNoise');
  turbulence.setAttribute('baseFrequency', '0.95');
  turbulence.setAttribute('numOctaves', '10');
  turbulence.setAttribute('seed', String(rng.int(1, 1000)));
  turbulence.setAttribute('result', 'noise');
  filter.appendChild(turbulence);

  const colorMatrix = document.createElementNS(SVG_NS, 'feColorMatrix');
  colorMatrix.setAttribute('in', 'noise');
  colorMatrix.setAttribute('type', 'saturate');
  colorMatrix.setAttribute('values', '0');
  filter.appendChild(colorMatrix);

  defs.appendChild(filter);

  const rect = document.createElementNS(SVG_NS, 'rect');
  rect.setAttribute('x', 0);
  rect.setAttribute('y', 0);
  rect.setAttribute('width', WIDTH);
  rect.setAttribute('height', HEIGHT);
  rect.setAttribute('filter', 'url(#grain)');
  rect.setAttribute('opacity', '0.3');
  rect.style.mixBlendMode = 'screen';
  rect.style.pointerEvents = 'none';
  rect.classList.add('s-overlay');
  container.appendChild(rect);
}

function addLightFlipFilter(svg) {
  const defs = getDefs(svg);

  const filter = document.createElementNS(SVG_NS, 'filter');
  filter.setAttribute('id', 'lightFlip');
  filter.setAttribute('x', '0%');
  filter.setAttribute('y', '0%');
  filter.setAttribute('width', '100%');
  filter.setAttribute('height', '100%');
  filter.setAttribute('color-interpolation-filters', 'sRGB');

  const invert = document.createElementNS(SVG_NS, 'feComponentTransfer');
  for (const tag of ['feFuncR', 'feFuncG', 'feFuncB']) {
    const f = document.createElementNS(SVG_NS, tag);
    f.setAttribute('type', 'table');
    f.setAttribute('tableValues', '1 0');
    invert.appendChild(f);
  }
  filter.appendChild(invert);

  const hueRotate = document.createElementNS(SVG_NS, 'feColorMatrix');
  hueRotate.setAttribute('type', 'hueRotate');
  hueRotate.setAttribute('values', '180');
  filter.appendChild(hueRotate);

  const BLACK_POINT = 0.20;
  const WHITE_POINT = 0.90;
  const range = WHITE_POINT - BLACK_POINT;
  const slope = (1 / range).toFixed(3);
  const intercept = (-BLACK_POINT / range).toFixed(3);
  const brighten = document.createElementNS(SVG_NS, 'feComponentTransfer');
  for (const tag of ['feFuncR', 'feFuncG', 'feFuncB']) {
    const f = document.createElementNS(SVG_NS, tag);
    f.setAttribute('type', 'linear');
    f.setAttribute('slope', slope);
    f.setAttribute('intercept', intercept);
    brighten.appendChild(f);
  }
  filter.appendChild(brighten);

  defs.appendChild(filter);
}

const SCALE_FACTOR = WIDTH / 1000;

function bakeTexture(fill, spacing, sizeFn) {
  const canvas = document.createElement('canvas');
  canvas.width = WIDTH;
  canvas.height = HEIGHT;
  const ctx = canvas.getContext('2d');
  ctx.fillStyle = fill;

  for (let y = 0; y < HEIGHT; y += spacing) {
    for (let x = 0; x < WIDTH; x += spacing) {
      const offsetX = rng.decimal(-0.3, 0.3) * SCALE_FACTOR;
      const offsetY = rng.decimal(-0.3, 0.3) * SCALE_FACTOR;
      const diameter = Math.max(0, sizeFn());
      ctx.beginPath();
      ctx.ellipse(x + offsetX, y + offsetY, diameter / 2, diameter / 2, 0, 0, Math.PI * 2);
      ctx.fill();
    }
  }

  return canvas.toDataURL('image/png');
}

function addTextureLayer(svg, dataURL, blendMode) {
  const image = document.createElementNS(SVG_NS, 'image');
  image.setAttributeNS('http://www.w3.org/1999/xlink', 'href', dataURL);
  image.setAttribute('href', dataURL);
  image.setAttribute('x', 0);
  image.setAttribute('y', 0);
  image.setAttribute('width', WIDTH);
  image.setAttribute('height', HEIGHT);
  image.style.mixBlendMode = blendMode;
  image.style.pointerEvents = 'none';
  image.classList.add('s-overlay');
  svg.appendChild(image);
}

function applyTexture(svg) {
  const dataURL = bakeTexture(
    'hsl(30, 100%, 40%)',
    8 * SCALE_FACTOR,
    () => (1 + rng.decimal(-1, 0.5)) * SCALE_FACTOR
  );
  addTextureLayer(svg, dataURL, 'color-dodge');
}

function applyTexture2(svg) {
  const dataURL = bakeTexture(
    `hsl(30, ${TEXTURE2_SATURATION}%, 80%)`,
    4 * SCALE_FACTOR,
    () => (3 + rng.decimal() * 0.15) * SCALE_FACTOR
  );
  addTextureLayer(svg, dataURL, 'color-burn');
}

// REVEAL_WINDOW_MS / REVEAL_PATH_MS are derived from STEP_LENGTH inside
// deriveState() above (smaller STEP_LENGTH packs more strokes into the
// same canvas before hitting the bounds check, so the reveal is slowed
// down to give it time to load).
const REVEAL_OVERLAY_MS = 0;
const REVEAL_EASE = 'cubic-bezier(0.33, 1, 0.68, 1)';

function revealDrawing(svg) {
  const paths = svg.querySelectorAll('path');
  const overlays = svg.querySelectorAll('.s-overlay');

  paths.forEach((path) => {
    const len = path.getTotalLength();
    path.style.transition = 'none';
    path.style.strokeDasharray = `${len}`;
    path.style.strokeDashoffset = `${len}`;
    path.style.opacity = '0';
  });

  const overlayTargets = [];
  overlays.forEach((el) => {
    overlayTargets.push(el.getAttribute('opacity') || '1');
    el.style.transition = 'none';
    el.style.opacity = '0';
  });

  requestAnimationFrame(() => {
    requestAnimationFrame(() => {
      const n = paths.length || 1;
      paths.forEach((path, i) => {
        const delay = (REVEAL_WINDOW_MS * i) / n;
        path.style.transition = `stroke-dashoffset ${REVEAL_PATH_MS}ms ${REVEAL_EASE} ${delay}ms, opacity ${REVEAL_PATH_MS}ms ${REVEAL_EASE} ${delay}ms`;
        path.style.strokeDashoffset = '0';
        path.style.opacity = '1';
      });
      overlays.forEach((el, i) => {
        el.style.transition = `opacity ${REVEAL_OVERLAY_MS}ms ease ${REVEAL_WINDOW_MS}ms`;
        el.style.opacity = overlayTargets[i];
      });
    });
  });
}

function addBackground(svg) {
  const rect = document.createElementNS(SVG_NS, 'rect');
  rect.setAttribute('x', 0);
  rect.setAttribute('y', 0);
  rect.setAttribute('width', WIDTH);
  rect.setAttribute('height', HEIGHT);
  rect.setAttribute('fill', '#000');
  svg.appendChild(rect);
}

function init() {
  const svg = createSVG();
  document.body.appendChild(svg);

  const group = document.createElementNS(SVG_NS, 'g');
  if (IS_LIGHT) {
    addLightFlipFilter(svg);
    group.setAttribute('filter', 'url(#lightFlip)');
  }
  svg.appendChild(group);

  addBackground(group);
  addRoom(group);

  const numLayers = 4;
  const spacing = 100;
  const padding = spacing * 2;
  const allStrokes = [];

  for (let layer = 0; layer < numLayers; layer++) {
    noiseSeed = rng.decimal(0, 10000);
    angleOffset = rng.decimal(0, Math.PI * 2);

    const allPaths = [];

    for (let x = padding; x < WIDTH - padding; x += spacing) {
      for (let y = padding; y < HEIGHT - padding; y += spacing) {
        const jx = x + rng.decimal(-5, 5);
        const jy = y + rng.decimal(-5, 5);
        const steps = rng.int(40, 120);
        const paths = flowLine(jx, jy, steps);
        allPaths.push(...paths);
      }
    }

    const densityMap = buildDensityMap(allPaths);
    const sortedDensity = [...densityMap.density].sort((a, b) => a - b);
    const threshold = sortedDensity[Math.floor(sortedDensity.length * 0.75)];

    for (const points of allPaths) {
      if (points.length > 1 && pathInDenseArea(points, densityMap, threshold)) {
        const strokeWidth = rng.decimal(STROKE_MIN_SCALE, 1) * STROKE_SCALE;
        const opacity = rng.decimal(.4, 1.0) * OPACITY_SCALE;
        const z = rng.decimal(Z_MIN, Z_MAX);
        allStrokes.push({ points, strokeWidth, opacity, z });
      }
    }
  }

  allStrokes.sort((a, b) => a.z - b.z);

  for (const stroke of allStrokes) {
    const perspectivePoints = applyPerspective(stroke.points, stroke.z);
    const scaledWidth = stroke.strokeWidth * stroke.z;
    const depthOpacity = stroke.opacity * (DEPTH_OPACITY_MIN + (1 - DEPTH_OPACITY_MIN) * ((stroke.z - Z_MIN) / (Z_MAX - Z_MIN)));
    group.appendChild(createPath(perspectivePoints, scaledWidth, depthOpacity));
  }

  addScratches(group);

  if (!IS_FLAT) {
    addGrain(svg, group);
     applyTexture(group);
     applyTexture2(group);
  }

  revealDrawing(svg);
}

function rasterizeSVG() {
  return new Promise((resolve, reject) => {
    const svg = document.querySelector('svg');
    if (!svg) return reject(new Error('No SVG to rasterize'));

    const clone = svg.cloneNode(true);
    clone.setAttribute('width', WIDTH);
    clone.setAttribute('height', HEIGHT);

    const svgData = new XMLSerializer().serializeToString(clone);
    const svgBlob = new Blob(
      ['<?xml version="1.0" encoding="UTF-8"?>\n', svgData],
      { type: 'image/svg+xml;charset=utf-8' }
    );
    const url = URL.createObjectURL(svgBlob);

    const img = new Image();
    img.onload = () => {
      const canvas = document.createElement('canvas');
      canvas.width = WIDTH;
      canvas.height = HEIGHT;
      const ctx = canvas.getContext('2d');
      ctx.fillStyle = OUTER_BG;
      ctx.fillRect(0, 0, WIDTH, HEIGHT);
      ctx.drawImage(img, 0, 0, WIDTH, HEIGHT);

      canvas.toBlob((blob) => {
        URL.revokeObjectURL(url);
        if (!blob) return reject(new Error('Canvas toBlob returned null'));
        resolve(blob);
      }, 'image/png');
    };
    img.onerror = (e) => {
      URL.revokeObjectURL(url);
      reject(e);
    };
    img.src = url;
  });
}

function saveScreenshot() {
  rasterizeSVG().then((blob) => {
    const link = document.createElement('a');
    link.download = `mugen-${HASH.slice(2, 10)}.png`;
    link.href = URL.createObjectURL(blob);
    link.click();
    URL.revokeObjectURL(link.href);
  }).catch((e) => console.error('Failed to save screenshot', e));
}

function createCopyIndicator() {
  const el = document.createElement('div');
  el.style.position = 'fixed';
  el.style.left = '50%';
  el.style.top = '50%';
  el.style.transform = 'translate(-50%, -50%)';
  el.style.padding = '8px 16px';
  el.style.borderRadius = '3px';
  el.style.fontFamily = 'system-ui, sans-serif';
  el.style.fontSize = '12px';
  el.style.letterSpacing = '0.08em';
  el.style.textTransform = 'uppercase';
  el.style.pointerEvents = 'none';
  el.style.opacity = '0';
  el.style.transition = 'opacity 200ms ease';
  el.style.zIndex = '9999';
  document.body.appendChild(el);
  return el;
}

const copyIndicator = createCopyIndicator();
let copyIndicatorTimeout = null;

function showCopyIndicator(message, isError) {
  clearTimeout(copyIndicatorTimeout);
  copyIndicator.textContent = message;
  copyIndicator.style.color = isError ? '#f66' : (IS_LIGHT ? '#000' : '#fff');
  copyIndicator.style.background = isError
    ? 'rgba(255,0,0,0.12)'
    : (IS_LIGHT ? 'rgba(0,0,0,0.08)' : 'rgba(255,255,255,0.12)');
  copyIndicator.style.opacity = '1';
  copyIndicatorTimeout = setTimeout(() => {
    copyIndicator.style.opacity = '0';
  }, 900);
}

function copyScreenshot() {
  if (!navigator.clipboard || !navigator.clipboard.write) {
    showCopyIndicator('Copy unsupported', true);
    console.error('Clipboard write API unavailable (needs HTTPS or localhost)');
    return;
  }
  if (!document.hasFocus()) window.focus();
  // navigator.clipboard.write() must be invoked synchronously within the
  // triggering click's user-gesture handler; passing a pending blob Promise
  // lets the rasterization finish asynchronously without losing that gesture.
  navigator.clipboard.write([
    new ClipboardItem({ 'image/png': rasterizeSVG() })
  ]).then(() => {
    showCopyIndicator('Copied', false);
  }).catch((e) => {
    const notFocused = e.name === 'NotAllowedError' && /focus/i.test(e.message);
    showCopyIndicator(notFocused ? 'Click page, then retry' : 'Copy failed', true);
    console.error('Failed to copy image to clipboard', e);
  });
}

function createContextMenu() {
  const menu = document.createElement('div');
  menu.style.position = 'fixed';
  menu.style.display = 'none';
  menu.style.zIndex = '10000';
  menu.style.background = IS_LIGHT ? '#fff' : '#1a1a1a';
  menu.style.color = IS_LIGHT ? '#000' : '#fff';
  menu.style.border = `1px solid ${IS_LIGHT ? 'rgba(0,0,0,0.15)' : 'rgba(255,255,255,0.15)'}`;
  menu.style.borderRadius = '6px';
  menu.style.boxShadow = '0 4px 16px rgba(0,0,0,0.3)';
  menu.style.padding = '4px';
  menu.style.fontFamily = 'system-ui, sans-serif';
  menu.style.fontSize = '13px';
  menu.style.minWidth = '160px';
  menu.style.userSelect = 'none';
  menu.style.cursor = 'default';

  const items = [
    { label: 'Copy Image', action: copyScreenshot },
    { label: 'Save Image As…', action: saveScreenshot }
  ];

  for (const { label, action } of items) {
    const item = document.createElement('div');
    item.textContent = label;
    item.style.padding = '7px 12px';
    item.style.borderRadius = '4px';
    item.style.cursor = 'pointer';
    item.addEventListener('mouseenter', () => {
      item.style.background = IS_LIGHT ? 'rgba(0,0,0,0.08)' : 'rgba(255,255,255,0.14)';
    });
    item.addEventListener('mouseleave', () => {
      item.style.background = 'transparent';
    });
    item.addEventListener('click', (e) => {
      e.stopPropagation();
      hideContextMenu();
      action();
    });
    menu.appendChild(item);
  }

  document.body.appendChild(menu);
  onThemeChange(() => {
    menu.style.background = IS_LIGHT ? '#fff' : '#1a1a1a';
    menu.style.color = IS_LIGHT ? '#000' : '#fff';
    menu.style.border = `1px solid ${IS_LIGHT ? 'rgba(0,0,0,0.15)' : 'rgba(255,255,255,0.15)'}`;
  });
  return menu;
}

const contextMenu = createContextMenu();

function hideContextMenu() {
  contextMenu.style.display = 'none';
}

function showContextMenu(x, y) {
  contextMenu.style.left = '0px';
  contextMenu.style.top = '0px';
  contextMenu.style.display = 'block';
  const rect = contextMenu.getBoundingClientRect();
  const maxX = window.innerWidth - rect.width - 4;
  const maxY = window.innerHeight - rect.height - 4;
  contextMenu.style.left = `${Math.max(0, Math.min(x, maxX))}px`;
  contextMenu.style.top = `${Math.max(0, Math.min(y, maxY))}px`;
}

document.addEventListener('keydown', (e) => {
  if (e.target && (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA')) return;
  if (e.key === 's' || e.key === 'S') {
    e.preventDefault();
    saveScreenshot();
  }
  if (e.key === 'Escape') hideContextMenu();
});

document.addEventListener('contextmenu', (e) => {
  e.preventDefault();
  showContextMenu(e.clientX, e.clientY);
});

document.addEventListener('click', (e) => {
  if (contextMenu.style.display === 'block' && !contextMenu.contains(e.target)) {
    hideContextMenu();
  }
});

const REFRESH_INTERVAL_MS = 300000;

function regenerate() {
  const old = document.querySelector('svg');
  if (old) old.remove();
  init();
}

function createRefreshIndicator() {
  const dot = document.createElement('div');
  dot.style.position = 'fixed';
  dot.style.right = '14px';
  dot.style.bottom = '14px';
  dot.style.width = '5px';
  dot.style.height = '5px';
  dot.style.borderRadius = '50%';
  dot.style.background = IS_LIGHT ? '#000' : '#fff';
  dot.style.opacity = '0';
  dot.style.pointerEvents = 'none';
  document.body.appendChild(dot);
  onThemeChange(() => { dot.style.background = IS_LIGHT ? '#000' : '#fff'; });
  return dot;
}

const refreshDot = createRefreshIndicator();

function armRefreshIndicator() {
  refreshDot.style.transition = 'none';
  refreshDot.style.opacity = '0';
  requestAnimationFrame(() => {
    requestAnimationFrame(() => {
      refreshDot.style.transition = `opacity ${REFRESH_INTERVAL_MS}ms linear`;
      refreshDot.style.opacity = '0.2';
    });
  });
}

document.addEventListener('dblclick', () => {
  loadSeed(generateHash());
});

document.body.style.cursor = 'pointer';
armRefreshIndicator();
setInterval(() => {
  regenerate();
  armRefreshIndicator();
}, REFRESH_INTERVAL_MS);

function loadSeed(value) {
  const seed = value.trim();
  if (!seed) return;
  if (location.protocol === 'data:') {
    // The location.href navigation below crashes the frame when this
    // script runs from a data: URI — e.g. embedded via
    // AnimationRenderer's animation_url in an <iframe>. data: URLs have no
    // real query string, and re-navigating a frame to a modified data: URL
    // takes down the renderer process. Re-derive every seed-dependent
    // constant and regenerate in place instead.
    HASH = seed;
    deriveState(HASH);
    regenerate();
    armRefreshIndicator();
    applyTheme();
    const seedInputEl = document.getElementById('seed-input');
    if (seedInputEl) seedInputEl.value = HASH;
    return;
  }
  const url = new URL(location.href);
  url.searchParams.set('seed', seed);
  location.href = url.toString();
}

// Standalone SeedRegistry on mainnet (independent of VesselRenderer). This
// page only ever READS from it (browse saved seeds) — saving is done from
// the separate external-url page (vault.html), which is the only place a
// wallet connection/transaction happens. Reads use a public RPC endpoint
// directly, so browsing works even for visitors with no wallet extension.
const REGISTRY_ADDRESS = '0xff91edfbd3ec3867dd9a68b8bbfde09f002daceb';
const PUBLIC_RPC_URL = 'https://ethereum-rpc.publicnode.com';

function hexToBytes(hex) {
  const clean = hex.startsWith('0x') ? hex.slice(2) : hex;
  const bytes = new Uint8Array(clean.length / 2);
  for (let i = 0; i < bytes.length; i++) {
    bytes[i] = parseInt(clean.substr(i * 2, 2), 16);
  }
  return bytes;
}

function bytesToHex(bytes) {
  return Array.from(bytes).map((b) => b.toString(16).padStart(2, '0')).join('');
}

function padHexWord(hex) {
  return hex.padStart(64, '0');
}

function readUintAt(bytes, byteOffset) {
  return Number(BigInt('0x' + bytesToHex(bytes.slice(byteOffset, byteOffset + 32))));
}

function readAddressAt(bytes, byteOffset) {
  return '0x' + bytesToHex(bytes.slice(byteOffset + 12, byteOffset + 32));
}

// Selectors are fixed constants (first 4 bytes of keccak256(signature)),
// precomputed with `cast sig` — no Keccak implementation needed in-browser.
function encodeSavedSeedsCountCalldata() {
  return '0x' + 'd1fc0fc7';
}

function encodeGetSavedSeedsCalldata(start, count) {
  return '0x' + '7909fe9f' + padHexWord(start.toString(16)) + padHexWord(count.toString(16));
}

function decodeSavedSeeds(resultHex) {
  const bytes = hexToBytes(resultHex);
  if (bytes.length === 0) return [];

  const saversOffset = readUintAt(bytes, 0);
  const seedsOffset = readUintAt(bytes, 32);
  const timestampsOffset = readUintAt(bytes, 64);

  const saversLen = readUintAt(bytes, saversOffset);
  const savers = [];
  for (let i = 0; i < saversLen; i++) {
    savers.push(readAddressAt(bytes, saversOffset + 32 + i * 32));
  }

  const seedsArrayBase = seedsOffset + 32;
  const seedsLen = readUintAt(bytes, seedsOffset);
  const seeds = [];
  for (let i = 0; i < seedsLen; i++) {
    const strStart = seedsArrayBase + readUintAt(bytes, seedsArrayBase + i * 32);
    const strLen = readUintAt(bytes, strStart);
    seeds.push(new TextDecoder().decode(bytes.slice(strStart + 32, strStart + 32 + strLen)));
  }

  const timestampsLen = readUintAt(bytes, timestampsOffset);
  const timestamps = [];
  for (let i = 0; i < timestampsLen; i++) {
    timestamps.push(readUintAt(bytes, timestampsOffset + 32 + i * 32));
  }

  const entries = [];
  const len = Math.min(savers.length, seeds.length, timestamps.length);
  for (let i = 0; i < len; i++) {
    entries.push({ saver: savers[i], seed: seeds[i], timestamp: timestamps[i] });
  }
  return entries;
}

// Read-only JSON-RPC call against a public endpoint — no wallet extension
// needed, so browsing saved seeds works for every visitor regardless of
// whether they have (or want to connect) a wallet.
async function rpcCall(method, params) {
  const response = await fetch(PUBLIC_RPC_URL, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ jsonrpc: '2.0', id: 1, method, params })
  });
  const body = await response.json();
  if (body.error) throw new Error(body.error.message || 'RPC error');
  return body.result;
}

async function fetchSavedSeedsTotal() {
  const countHex = await rpcCall('eth_call', [
    { to: REGISTRY_ADDRESS, data: encodeSavedSeedsCountCalldata() }, 'latest'
  ]);
  return Number(BigInt(countHex));
}

async function fetchSavedSeedsPage(start, count) {
  const resultHex = await rpcCall('eth_call', [
    { to: REGISTRY_ADDRESS, data: encodeGetSavedSeedsCalldata(start, count) }, 'latest'
  ]);
  return decodeSavedSeeds(resultHex);
}

function createSeedControls() {
  let color = IS_LIGHT ? '#000' : '#fff';
  let bg = IS_LIGHT ? 'rgba(0,0,0,0.06)' : 'rgba(255,255,255,0.08)';
  let border = IS_LIGHT ? 'rgba(0,0,0,0.18)' : 'rgba(255,255,255,0.18)';

  const wrap = document.createElement('div');
  wrap.style.position = 'fixed';
  wrap.style.left = '14px';
  wrap.style.bottom = '14px';
  wrap.style.zIndex = '9998';
  wrap.style.opacity = '0';
  wrap.style.transition = 'opacity 200ms ease';
  wrap.style.cursor = 'default';

  const stop = (e) => e.stopPropagation();
  ['click', 'dblclick', 'mousedown', 'contextmenu'].forEach((type) => {
    wrap.addEventListener(type, stop);
  });

  const buttonStyle = (el) => {
    el.style.fontFamily = 'system-ui, sans-serif';
    el.style.fontSize = '11px';
    el.style.color = color;
    el.style.background = bg;
    el.style.border = `1px solid ${border}`;
    el.style.borderRadius = '4px';
    el.style.padding = '5px 8px';
    el.style.cursor = 'pointer';
  };

  const row1 = document.createElement('div');
  row1.style.display = 'flex';
  row1.style.alignItems = 'center';
  row1.style.gap = '5px';

  const input = document.createElement('input');
  input.id = 'seed-input';
  input.type = 'text';
  input.value = HASH;
  input.placeholder = 'seed…';
  input.spellcheck = false;
  input.autocomplete = 'off';
  input.style.width = '104px';
  input.style.fontFamily = 'ui-monospace, monospace';
  input.style.fontSize = '11px';
  input.style.color = color;
  input.style.background = bg;
  input.style.border = `1px solid ${border}`;
  input.style.borderRadius = '4px';
  input.style.padding = '5px 8px';
  input.style.outline = 'none';

  const viewBtn = document.createElement('button');
  viewBtn.textContent = 'View';
  buttonStyle(viewBtn);

  const copyBtn = document.createElement('button');
  copyBtn.textContent = 'Copy seed';
  buttonStyle(copyBtn);

  const savedToggleBtn = document.createElement('button');
  savedToggleBtn.textContent = 'Saved ▾';
  buttonStyle(savedToggleBtn);

  const savedPanel = document.createElement('div');
  savedPanel.style.position = 'absolute';
  savedPanel.style.left = '0';
  savedPanel.style.bottom = '100%';
  savedPanel.style.marginBottom = '6px';
  savedPanel.style.display = 'none';
  savedPanel.style.flexDirection = 'column';
  savedPanel.style.gap = '2px';
  savedPanel.style.maxHeight = '180px';
  savedPanel.style.overflowY = 'auto';
  savedPanel.style.minWidth = '220px';
  savedPanel.style.padding = '6px';
  savedPanel.style.borderRadius = '6px';
  savedPanel.style.background = IS_LIGHT ? '#fff' : '#1a1a1a';
  savedPanel.style.border = `1px solid ${border}`;
  savedPanel.style.boxShadow = '0 4px 16px rgba(0,0,0,0.3)';
  savedPanel.style.fontFamily = 'ui-monospace, monospace';
  savedPanel.style.fontSize = '10.5px';

  const setPanelMessage = (text, isError) => {
    savedPanel.textContent = '';
    const row = document.createElement('div');
    row.textContent = text;
    row.style.padding = '4px 6px';
    row.style.color = isError ? '#f66' : color;
    if (!isError) row.style.opacity = '0.6';
    savedPanel.appendChild(row);
  };

  input.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
      e.preventDefault();
      loadSeed(input.value);
    }
  });
  viewBtn.addEventListener('click', () => loadSeed(input.value));

  copyBtn.addEventListener('click', async () => {
    try {
      await navigator.clipboard.writeText(HASH);
      showCopyIndicator('Seed copied', false);
    } catch (e) {
      showCopyIndicator('Copy failed', true);
      console.error('Failed to copy seed', e);
    }
  });

  const PAGE_SIZE = 25;
  let oldestLoaded = 0; // entries [oldestLoaded, total) have been fetched so far
  let loadMoreBtn = null;

  const renderSavedRow = (entry) => {
    const row = document.createElement('div');
    row.textContent = `${entry.saver.slice(0, 6)}…${entry.saver.slice(-4)}  ${entry.seed.slice(0, 12)}…`;
    row.style.padding = '4px 6px';
    row.style.borderRadius = '4px';
    row.style.cursor = 'pointer';
    row.style.color = color;
    row.style.whiteSpace = 'nowrap';
    row.addEventListener('mouseenter', () => {
      row.style.background = IS_LIGHT ? 'rgba(0,0,0,0.08)' : 'rgba(255,255,255,0.14)';
    });
    row.addEventListener('mouseleave', () => {
      row.style.background = 'transparent';
    });
    row.addEventListener('click', () => loadSeed(entry.seed));
    return row;
  };

  const removeLoadMoreButton = () => {
    if (loadMoreBtn) {
      loadMoreBtn.remove();
      loadMoreBtn = null;
    }
  };

  const addLoadMoreButton = () => {
    removeLoadMoreButton();
    loadMoreBtn = document.createElement('div');
    loadMoreBtn.textContent = 'Load more…';
    loadMoreBtn.style.padding = '4px 6px';
    loadMoreBtn.style.marginTop = '2px';
    loadMoreBtn.style.borderRadius = '4px';
    loadMoreBtn.style.cursor = 'pointer';
    loadMoreBtn.style.color = color;
    loadMoreBtn.style.opacity = '0.7';
    loadMoreBtn.style.textAlign = 'center';
    loadMoreBtn.addEventListener('mouseenter', () => {
      loadMoreBtn.style.background = IS_LIGHT ? 'rgba(0,0,0,0.08)' : 'rgba(255,255,255,0.14)';
    });
    loadMoreBtn.addEventListener('mouseleave', () => {
      loadMoreBtn.style.background = 'transparent';
    });
    loadMoreBtn.addEventListener('click', () => loadSavedPage(false));
    savedPanel.appendChild(loadMoreBtn);
  };

  async function loadSavedPage(isFirstLoad) {
    try {
      if (isFirstLoad) {
        const total = await fetchSavedSeedsTotal();
        savedPanel.textContent = '';
        loadMoreBtn = null;
        if (total === 0) {
          setPanelMessage('No saved seeds yet', false);
          return;
        }
        oldestLoaded = total;
      } else if (loadMoreBtn) {
        loadMoreBtn.textContent = 'Loading…';
      }

      const start = oldestLoaded > PAGE_SIZE ? oldestLoaded - PAGE_SIZE : 0;
      const count = oldestLoaded - start;
      const entries = await fetchSavedSeedsPage(start, count);
      oldestLoaded = start;

      removeLoadMoreButton();
      for (const entry of entries.slice().reverse()) {
        savedPanel.appendChild(renderSavedRow(entry));
      }
      if (oldestLoaded > 0) {
        addLoadMoreButton();
      }
    } catch (e) {
      setPanelMessage('Failed to load', true);
      console.error('Failed to fetch saved seeds', e);
    }
  }

  savedToggleBtn.addEventListener('click', () => {
    const opening = savedPanel.style.display === 'none';
    if (!opening) {
      savedPanel.style.display = 'none';
      dim();
      return;
    }

    savedPanel.style.display = 'flex';
    brighten();
    setPanelMessage('Loading…', false);
    loadSavedPage(true);
  });

  const hint = document.createElement('div');
  hint.textContent = 'Double click for new seed';
  hint.style.marginBottom = '6px';
  hint.style.opacity = '0.6';
  hint.style.pointerEvents = 'none';
  hint.style.fontFamily = 'system-ui, sans-serif';
  hint.style.fontSize = '11px';
  hint.style.letterSpacing = '0.02em';
  hint.style.color = color;

  const brighten = () => { wrap.style.opacity = '1'; };
  const dim = () => {
    if (document.activeElement === input) return;
    if (savedPanel.style.display !== 'none') return;
    wrap.style.opacity = '0';
  };
  document.addEventListener('mousemove', brighten);
  document.addEventListener('mouseleave', dim);
  input.addEventListener('focus', brighten);
  input.addEventListener('blur', dim);

  document.addEventListener('click', (e) => {
    if (savedPanel.style.display !== 'none' && !wrap.contains(e.target)) {
      savedPanel.style.display = 'none';
      dim();
    }
  });

  row1.appendChild(input);
  row1.appendChild(viewBtn);
  row1.appendChild(copyBtn);
  row1.appendChild(savedToggleBtn);
  wrap.appendChild(savedPanel);
  wrap.appendChild(hint);
  wrap.appendChild(row1);
  document.body.appendChild(wrap);

  onThemeChange(() => {
    color = IS_LIGHT ? '#000' : '#fff';
    bg = IS_LIGHT ? 'rgba(0,0,0,0.06)' : 'rgba(255,255,255,0.08)';
    border = IS_LIGHT ? 'rgba(0,0,0,0.18)' : 'rgba(255,255,255,0.18)';
    buttonStyle(viewBtn);
    buttonStyle(copyBtn);
    buttonStyle(savedToggleBtn);
    input.style.color = color;
    input.style.background = bg;
    input.style.border = `1px solid ${border}`;
    savedPanel.style.background = IS_LIGHT ? '#fff' : '#1a1a1a';
    savedPanel.style.border = `1px solid ${border}`;
    hint.style.color = color;
    // Rows already rendered from a previous "Saved" panel open (if any)
    // won't be recreated by renderSavedRow, so patch their color directly.
    Array.from(savedPanel.children).forEach((child) => {
      child.style.color = color;
    });
  });

  // Optional extension point: a page loading this same script (e.g. the
  // external_url "vault" page) can predefine window.__seedControlsExtend
  // before this script runs to add extra controls (like a Save button) to
  // the widget without this on-chain script itself carrying any wallet-write
  // code. No-op here on the standard page since the hook is left undefined.
  if (typeof window.__seedControlsExtend === 'function') {
    window.__seedControlsExtend({ row1, savedToggleBtn, buttonStyle, input });
  }
}

if (IS_DESKTOP) createSeedControls();

init();
