<?php
if (!defined('CLAIM_META_INCLUDED')) {
    define('CLAIM_META_INCLUDED', true);
?>
<meta>
<head>
    <meta charset="UTF-8">
    <style>
        #mode-transition {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            pointer-events: none;
            z-index: 9999;
            opacity: 0;
            transition: opacity 0.5s ease;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.9.0/p5.js"></script>

    <script>
     window.JINSEI_BG = {
          dark:  '#0d0b0c',   // NOT #0a0108 — dodge/burn have no headroom at the extremes
          light: '#f4f2ef',   // brighter than #e8e6e2; keeps ~92% of the texture

          // null = a new texture on every page load. Put a string here to pin one.
          // Resolved once per load, so mode toggles and resizes keep the same
          // texture — it only changes when the page is loaded again.
          seed: null,

          /* --- Texture B: the dense burn speckle. This is the layer you see. --- */
          texB:      true,
          texBHue:   200,
          texBSat:   20,   // saturation, NOT hue, is what tints it. At the spec
                           // sat of 30, burn clamps every channel to the same
                           // floor on a dark base and hues 0/320/335/350 render
                           // byte-identical. R-B by sat: 30->2.4, 50->5.1,
                           // 70->8.5, 90->12.7. Drop to ~70 for a dusty rose.
          texBLight: 70,

          /* --- Texture A: the fine dodge speckle. Off; it is a whisper. --- */
          // Its dots are 0-1.8px across at 9.4px spacing, mostly sub-pixel, so
          // by construction it barely registers over a page background: on this
          // base, turning it on moves mean luminance 20.9 -> 21.1. texALight is
          // the only real strength lever and it stays flat until ~95
          // (sd: off 15.14, l40 15.06, l70 15.08, l85 15.44, l95 17.67).
          texA:      false,
          texAHue:   50,
          texASat:   20,
          texALight: 95,

          /* --- Broad water stains --- */
          // stainOpacity scales the spec's 1-6% rings. At full strength on a base
          // this dark, dodge blows them out and mean luminance nearly doubles.
          // 0.3 reads as staining, not as a light source. Dark mode only —
          // dodge does nothing on the light base, so they vanish there.
          stains:       3,
          stainOpacity: 0.05
      };
    </script>
 <!--   <script>
        /**
         * JINSEI background texture — grain + texture A + texture B, as a drop-in
         * background canvas. Self-contained: no p5, no modules, no dependencies.
         *
         * Load it with a script tag, or paste it inline. Configure it by defining
         * window.JINSEI_BG BEFORE this runs:
         *
         *     window.JINSEI_BG = {
         *       dark:  '#1e1a1c',      // base tone when the page is in dark mode
         *       light: '#e8e6e2',      // base tone when the page is in light mode
         *       seed:  null,           // null = new texture each load; a string pins it
         *
         *       texA: true,            // dodge speckle: fine, sparse   (off by default)
         *       texAHue: 210, texASat: 100, texALight: 40,
         *
         *       texB: true,            // burn speckle: coarse, dense   (on by default)
         *       texBHue: 335, texBSat: 90, texBLight: 80,
         *
         *       stains: 3,             // broad water stains; true = the spec's 1-5
         *       stainOpacity: 0.3
         *     };
         *
         * NOTE: this comment deliberately contains no closing script tag. An HTML
         * parser does not know what a JS comment is — it scans for that string and
         * ends the block there, so one inside a comment silently truncates the file
         * when this is pasted inline.
         *
         * WHY THOSE BASE TONES AND NOT #0a0108 / #ffffff: the texture layers are
         * color-dodge and color-burn, which have no headroom at the ends of the range.
         * Measured over a flat base, the texture's luminance spread is:
         *
         *     #0a0108   sd  5.93   (and it only darkens — mean drops 7.0 -> 3.8)
         *     #ffffff   sd  7.47   (essentially nothing; texB moves 0.79/255)
         *     #1e1a1c   sd 13.48
         *     #333333   sd 21.33
         *     #808080   sd 21.71
         *     #e0e0e0   sd 13.99
         *
         * There is no blend-mode trick around this — overlay and soft-light composite
         * to sd 0.47 on #0a0108 and sd 0.00 on #ffffff. Texture is variation, and pure
         * black and pure white have nothing to vary. Move the base off the extreme.
         */
        (function () {
          'use strict';

          var CFG = window.JINSEI_BG || {};

          var DEFAULTS = {
            dark: '#1e1a1c',
            light: '#e8e6e2',
            seed: null,         // null = a fresh random texture each page load
            zIndex: -11,        // below .image-div (-10) so hero images still win
            id: 'jinsei-bg',
            grain: 20,          // amplitude, 0-255 scale; 0 disables
            texA: false,        // see note below — off by default
            texB: true,
            // Colour overrides per layer. null = drawn from the seed.
            // Hue is free. Explicit sat/light are passed through UNCLAMPED: the bands
            // in LAYERS are what the blend survives over JINSEI's drawn scene, but over
            // a flat page background there is more room, so art-direct if you want.
            texAHue: null, texASat: null, texALight: null,
            texBHue: null, texBSat: null, texBLight: null,
            // Broad water stains (JINSEI's drawWaterStainsFinishBroad). false = off,
            // true = the original's random 1-5 per render, or give an exact count.
            stains: false,
            // Multiplier on stain ring opacity. 1 = the spec, which is calibrated for
            // JINSEI's mid-tone scene. On a near-black page base the same numbers are
            // far too strong: color-dodge is backdrop/(1-source), so a light source
            // over a dark backdrop multiplies enormously, and 6-30 rings compound it.
            // Measured on #1e1a1c with 3 stains, mean luminance goes 17.2 -> 33.5 at
            // full strength — the stains stop reading as stains and take over the page.
            stainOpacity: 1,
            maxDpr: 2,
            debounceMs: 250
          };

          // Colouring the burn layer: on a dark base, HUE ALONE DOES NOTHING. At the
          // spec saturation of 30 the source is pale enough that burn clamps every
          // channel to the same floor — measured over #1e1a1c, hues 0 / 320 / 335 / 350
          // all produce byte-identical output. Saturation is the lever that actually
          // tints it (R-B separation on that base): s30 -> 2.4, s50 -> 5.1, s70 -> 8.5,
          // s90 -> 12.7. Texture strength drops slightly as it rises (sd 13.4 -> 12.1).

          // texA is off by default on purpose. In the original it sits over drawn line
          // work, where color-dodge blows out the bright strokes. Over a flat page
          // background it moves the image by 0.5/255 on average — invisible — while
          // costing ~40% of the render time. Set texA: true if you want spec fidelity.

          function opt(k) { return CFG[k] !== undefined ? CFG[k] : DEFAULTS[k]; }

          // Resolved ONCE per page load, not per render. Every repaint (mode toggle,
          // resize) reuses it, so the texture stays put while you are on the page and
          // only changes when you come back — reseeding per render would make the whole
          // background visibly reshuffle every time you hit the dark/light switch.
          var SEED = (function () {
            var s = opt('seed');
            if (s !== null && s !== undefined) return String(s);
            var c = window.crypto || window.msCrypto;
            if (c && c.randomUUID) return c.randomUUID();
            if (c && c.getRandomValues) {
              var a = new Uint32Array(4);
              c.getRandomValues(a);
              return Array.prototype.map.call(a, function (n) { return n.toString(16); }).join('');
            }
            return String(Math.random()).slice(2) + Date.now().toString(16);
          })();

          /* ---------------- spec constants (see export/jinsei-grain-texture.js) ------ */

          // The original renders at 2268x1057 with scaleFactor = min(W/1440, H/900).
          // Held constant so the speckle is the same physical size on every screen.
          var SCALE = Math.min(2268 / 1440, 1057 / 900); // 1.17444...

          var LAYERS = {
            texA: {
              blend: 'color-dodge', spacing: 8, jitter: 0.3,
              size: { base: 1, lo: -1, hi: 0.5 },   // (1 + rand(-1, 0.5)) * scale
              sBand: [90, 100], lBand: [30, 50]
            },
            texB: {
              blend: 'color-burn', spacing: 4, jitter: 0.3,
              size: { base: 3, lo: 0, hi: 0.15 },   // (3 + rand(0, 0.15)) * scale
              sBand: [20, 40], lBand: [70, 90]
            }
          };

          /* ---------------- deterministic RNG (same one JINSEI uses) ---------------- */

          function Rng(hash) {
            var clean = String(hash).indexOf('0x') === 0 ? String(hash).slice(2) : String(hash);
            var h1 = 0xdeadbeef, h2 = 0x41c6ce57;
            for (var i = 0; i < clean.length; i++) {
              var ch = clean.charCodeAt(i);
              h1 = Math.imul(h1 ^ ch, 2654435761);
              h2 = Math.imul(h2 ^ ch, 1597334677);
            }
            h1 = Math.imul(h1 ^ (h1 >>> 16), 2246822507);
            h1 = Math.imul(h1 ^ (h1 >>> 13), 3266489909);
            h2 = Math.imul(h2 ^ (h2 >>> 16), 2246822507);
            h2 = Math.imul(h2 ^ (h2 >>> 13), 3266489909);
            this.seed = (h1 ^ h2) >>> 0;
          }
          Rng.prototype.next = function () {
            this.seed += 0x6d2b79f5;
            var t = this.seed;
            t = Math.imul(t ^ (t >>> 15), t | 1);
            t ^= t + Math.imul(t ^ (t >>> 7), t | 61);
            return ((t ^ (t >>> 14)) >>> 0) / 4294967296;
          };
          Rng.prototype.decimal = function (min, max) {
            if (min === undefined) min = 0;
            if (max === undefined) max = 1;
            return min + this.next() * (max - min);
          };
          Rng.prototype.int = function (min, max) {
            return Math.floor(this.decimal(min, max + 1));
          };

          /* ---------------- passes ---------------- */

          function applyGrain(ctx, rng, amount) {
            var w = ctx.canvas.width, h = ctx.canvas.height;
            var img = ctx.getImageData(0, 0, w, h);
            var d = img.data;
            for (var i = 0; i < d.length; i += 4) {
              // One draw shared by R/G/B, so it reads as luminance noise, not colour noise.
              var g = rng.decimal(-amount, amount);
              d[i] += g;          // Uint8ClampedArray rounds and clamps on assignment
              d[i + 1] += g;
              d[i + 2] += g;
            }
            ctx.putImageData(img, 0, 0);
          }

          // p5 1.x does not draw circles with ctx.arc — it uses four cubic Beziers with
          // this kappa. On 1-4px dots the whole difference lands in the antialiased edge
          // and color-dodge amplifies it (measured: up to 35/255 on 2.4% of pixels).
          // Matching the Bezier path is what makes this bit-exact against the original.
          var KAPPA = 0.5522847498;

          function p5Circle(ctx, cx, cy, d) {
            var x = cx - d * 0.5, y = cy - d * 0.5;
            var a = (d / 2) * KAPPA, l = a;
            var right = x + d, bottom = y + d;
            var mx = x + d / 2, my = y + d / 2;
            ctx.moveTo(x, my);
            ctx.bezierCurveTo(x, my - l, mx - a, y, mx, y);
            ctx.bezierCurveTo(mx + a, y, right, my - l, right, my);
            ctx.bezierCurveTo(right, my + l, mx + a, bottom, mx, bottom);
            ctx.bezierCurveTo(mx - a, bottom, x, my + l, x, my);
          }

          function drawSpeckle(ctx, rng, w, h, layer, key) {
            var spacing = layer.spacing * SCALE;
            var jit = layer.jitter;
            var sz = layer.size;

            // The rng draws happen either way, so overriding a colour does not
            // reshuffle the dot positions that come after it.
            var rh = rng.decimal(0, 360);
            var rs = rng.decimal(layer.sBand[0], layer.sBand[1]);
            var rl = rng.decimal(layer.lBand[0], layer.lBand[1]);
            var pick = function (name, fallback) {
              var v = opt(key + name);
              return v === null || v === undefined ? fallback : v;
            };
            var hh = pick('Hue', rh);
            var ss = pick('Sat', rs);
            var ll = pick('Light', rl);

            ctx.save();
            ctx.globalCompositeOperation = layer.blend;
            ctx.fillStyle = 'hsl(' + (((hh % 360) + 360) % 360) + ', ' + ss + '%, ' + ll + '%)';

            for (var y = 0; y < h; y += spacing) {
              for (var x = 0; x < w; x += spacing) {
                // Scale is applied after the draw, not folded into the range — equal in
                // real arithmetic, not in float, and enough to move a sub-pixel edge.
                var ox = rng.decimal(-jit, jit) * SCALE;
                var oy = rng.decimal(-jit, jit) * SCALE;
                var size = (sz.base + rng.decimal(sz.lo, sz.hi)) * SCALE;
                if (size <= 0) continue;
                ctx.beginPath();
                p5Circle(ctx, x + ox, y + oy, size);
                ctx.fill();
              }
            }
            ctx.restore();
          }

          /* ---------------- broad water stains ---------------- */

          // Ported from drawWaterStainsFinishBroad in src/jinsei_texture.js. Big soft
          // oblong blotches built from 6-30 overlapping wobbly rings, each drawn at
          // 1-6% opacity so they only ever accumulate into a stain, never a hard edge.
          var STAIN = {
            baseRadius:   [150, 300],   // base units, before SCALE
            stretchRatio: [1.8, 10.5],   // how oblong; the high end is a long smear
            hue: [0, 50], sat: [0, 30], light: [50, 100],   // warm, washed out
            rings:      [6, 30],
            ringRadius: [0.4, 1.2],     // multiple of baseRadius
            thickness:  [10, 30],       // base units
            verts:      [2, 8],
            opacity:    [0.01, 0.06],
            dodgeChance: 0.35           // else overlay — tints more than it lifts
          };

          function hsla(h, s, l, a) {
            h = ((h % 360) + 360) % 360;
            return 'hsla(' + h + ',' + Math.max(0, Math.min(100, s)) + '%,' +
                   Math.max(0, Math.min(100, l)) + '%,' + a + ')';
          }

          // p5's curveVertex() is a Catmull-Rom spline, which Canvas 2D has no
          // primitive for. This is p5's own conversion to cubic Beziers at the default
          // curveTightness of 0 — the control points are the neighbour delta over 6.
          // The caller duplicates the first and last point, which is the standard
          // phantom-endpoint trick that makes the curve reach its endpoints.
          function curvePath(ctx, pts) {
            if (pts.length < 4) return false;
            ctx.beginPath();
            ctx.moveTo(pts[1][0], pts[1][1]);
            for (var i = 1; i + 2 < pts.length; i++) {
              var p0 = pts[i - 1], p1 = pts[i], p2 = pts[i + 1], p3 = pts[i + 2];
              ctx.bezierCurveTo(
                p1[0] + (p2[0] - p0[0]) / 6, p1[1] + (p2[1] - p0[1]) / 6,
                p2[0] + (p1[0] - p3[0]) / 6, p2[1] + (p1[1] - p3[1]) / 6,
                p2[0], p2[1]
              );
            }
            return true;
          }

          function drawWaterStains(ctx, rng, w, h, count, strength) {
            var TAU = Math.PI * 2;

            for (var s = 0; s < count; s++) {
              var cx = rng.decimal(w * 0.1, w * 0.9);
              var cy = rng.decimal(h * 0.1, h * 0.9);
              var baseRadius = rng.decimal(STAIN.baseRadius[0], STAIN.baseRadius[1]) * SCALE;
              var stretchAngle = rng.decimal(0, TAU);
              var stretchRatio = rng.decimal(STAIN.stretchRatio[0], STAIN.stretchRatio[1]);
              var ca = Math.cos(stretchAngle), sa = Math.sin(stretchAngle);

              var stainH = rng.decimal(STAIN.hue[0], STAIN.hue[1]);
              var stainS = rng.decimal(STAIN.sat[0], STAIN.sat[1]);
              var stainL = rng.decimal(STAIN.light[0], STAIN.light[1]);

              var rings = rng.int(STAIN.rings[0], STAIN.rings[1]);

              for (var r = 0; r < rings; r++) {
                var ringRadius = baseRadius * rng.decimal(STAIN.ringRadius[0], STAIN.ringRadius[1]);
                var thickness  = rng.decimal(STAIN.thickness[0], STAIN.thickness[1]) * SCALE;
                var verts      = rng.int(STAIN.verts[0], STAIN.verts[1]);
                var opacity    = rng.decimal(STAIN.opacity[0], STAIN.opacity[1]) * strength;

                ctx.globalCompositeOperation =
                  rng.next() < STAIN.dodgeChance ? 'color-dodge' : 'overlay';
                ctx.lineCap = 'round';
                ctx.lineWidth = thickness;
                ctx.strokeStyle = hsla(stainH + rng.decimal(-5, 5), stainS, stainL + rng.decimal(-8, 8), opacity);
                ctx.fillStyle   = hsla(stainH + rng.decimal(-5, 5), stainS, stainL + rng.decimal(-8, 8), opacity / 2);

                var pts = [];
                for (var v = 0; v <= verts; v++) {
                  var angle = (v / verts) * TAU;
                  var wobble = ringRadius + rng.decimal(-baseRadius * 0.5, baseRadius * 0.5);
                  var rawX = Math.cos(angle) * wobble;
                  var rawY = Math.sin(angle) * wobble;
                  var along = rawX * ca + rawY * sa;
                  var perp  = -rawX * sa + rawY * ca;
                  var stretched = along * stretchRatio;
                  var px = cx + stretched * ca - perp * sa + rng.decimal(-10, 10) * SCALE;
                  var py = cy + stretched * sa + perp * ca + rng.decimal(-10, 10) * SCALE;
                  if (v === 0 || v === verts) { pts.push([px, py]); pts.push([px, py]); }
                  else pts.push([px, py]);
                }

                // p5's endShape() without CLOSE fills the implicitly-closed path, then
                // strokes the open one.
                if (curvePath(ctx, pts)) { ctx.fill(); ctx.stroke(); }
              }
            }
            ctx.globalCompositeOperation = 'source-over';
          }

          /* ---------------- render ---------------- */

          function render(canvas, baseColor) {
            var dpr = Math.min(opt('maxDpr'), window.devicePixelRatio || 1);
            var cssW = Math.max(1, window.innerWidth);
            var cssH = Math.max(1, window.innerHeight);

            canvas.width = Math.round(cssW * dpr);
            canvas.height = Math.round(cssH * dpr);

            var ctx = canvas.getContext('2d');
            ctx.setTransform(dpr, 0, 0, dpr, 0, 0);

            // The texture passes blend against what is already on the canvas, so the
            // base has to be painted first and has to be opaque.
            ctx.globalCompositeOperation = 'source-over';
            ctx.fillStyle = baseColor;
            ctx.fillRect(0, 0, cssW, cssH);

            var rng = new Rng(SEED);

            var grain = opt('grain');
            if (grain > 0) {
              ctx.save();
              ctx.setTransform(1, 0, 0, 1, 0, 0);   // grain runs over the raw buffer
              applyGrain(ctx, rng, grain);
              ctx.restore();
            }

            // Stains sit after the grain and under both speckle layers, same as the
            // original pipeline. They run off their own rng stream so that turning them
            // on or off does not reshuffle the weave underneath.
            var stains = opt('stains');
            if (stains) {
              var sRng = new Rng(SEED + '_stainBroad');
              drawWaterStains(ctx, sRng, cssW, cssH,
                stains === true ? sRng.int(1, 5) : stains, opt('stainOpacity'));
            }

            if (opt('texA')) drawSpeckle(ctx, rng, cssW, cssH, LAYERS.texA, 'texA');
            if (opt('texB')) drawSpeckle(ctx, rng, cssW, cssH, LAYERS.texB, 'texB');
          }

          /* ---------------- mount ---------------- */

          function isDark() {
            // Read the DOM, not the page's isDarkMode variable — setLightMode(true)
            // applies the *light* palette, so that flag reads backwards.
            var b = document.body;
            if (b.classList.contains('light-bg')) return false;
            if (b.classList.contains('dark-bg')) return true;
            // Fall back to the actual painted colour.
            var m = getComputedStyle(b).backgroundColor.match(/\d+/g);
            if (!m) return true;
            return (0.2126 * +m[0] + 0.7152 * +m[1] + 0.0722 * +m[2]) < 128;
          }

          function mount() {
            if (document.getElementById(opt('id'))) return;

            var canvas = document.createElement('canvas');
            canvas.id = opt('id');
            canvas.setAttribute('aria-hidden', 'true');
            canvas.style.cssText =
              'position:fixed;top:0;left:0;width:100vw;height:100vh;' +
              'z-index:' + opt('zIndex') + ';pointer-events:none;display:block;';
            document.body.appendChild(canvas);

            var lastW = -1, lastH = -1, lastTone = null, timer = null;

            function draw(force) {
              var tone = isDark() ? opt('dark') : opt('light');
              var w = window.innerWidth, h = window.innerHeight;
              // Height-only changes are the mobile URL bar sliding away. Re-rendering
              // there makes the whole background visibly reshuffle for no reason.
              var sizeChanged = w !== lastW || Math.abs(h - lastH) > 120;
              if (!force && !sizeChanged && tone === lastTone) return;
              lastW = w; lastH = h; lastTone = tone;
              render(canvas, tone);
            }

            draw(true);

            window.addEventListener('resize', function () {
              clearTimeout(timer);
              timer = setTimeout(draw, opt('debounceMs'));
            });

            // The dark/light toggle swaps classes on <body>; repaint to match.
            if (window.MutationObserver) {
              new MutationObserver(function () {
                clearTimeout(timer);
                timer = setTimeout(draw, 30);
              }).observe(document.body, { attributes: true, attributeFilter: ['class'] });
            }

            window.jinseiBgRedraw = function () { draw(true); };
          }

          if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', mount);
          } else {
            mount();
          }
        })();

    </script>-->

    <title>Andrew Mitchell</title>
    <meta name="description" content="Linktree of Mitchell's portfolio">
    <meta name="author" content="Andrew Mitchell">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inconsolata&family=Roboto+Condensed:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/font/Mono/css/JetBrainsMono.css">

<style>

    body {    .hero-image.blurred {
            filter: blur(5px);
            transition: filter 1s ease-in-out;
                       image-rendering: pixelated;
            image-rendering: -moz-crisp-edges;
            image-rendering: crisp-edges;
        }
    font-family: 'JetBrainsMono-Light' !important;
        margin-top: 0;
        box-sizing: border-box;
        color: antiquewhite;
        overflow-x: hidden;
    }

    header {
        display: none;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .text-fixed {
        position: fixed;
        left: 50vw;
        transform: translate(-50%, -50%);
        font-family: Arial, sans-serif;
        font-size: 0.75rem; /* Default font size */
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
        z-index: 2;
        box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.1);
        width: max-content;
    }
        .hero-image {
            transition: filter 1s ease-in-out;
                       image-rendering: pixelated;
            image-rendering: -moz-crisp-edges;
            image-rendering: crisp-edges;
        }
    .hero-image.blurred {
            filter: blur(50px);
            transition: filter 1s ease-in-out;
                       image-rendering: pixelated;
            image-rendering: -moz-crisp-edges;
            image-rendering: crisp-edges;
        }
    
     .scroll-indicator {
            position: absolute;
            bottom: 50px;
            left: 50%;
            transform: translateX(-50%);
            color: black;
 
            font-size: 3rem;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateX(-50%) translateY(0);
            }
            40% {
                transform: translateX(-50%) translateY(-10px);
            }
            60% {
                transform: translateX(-50%) translateY(-5px);
            }
        }

    .art-square-light {
        z-index: 1;
        box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.1);
    }
    
        .art-square-dark {
        z-index: 1;
        box-shadow: 4px 4px 8px rgba(255, 255, 255, 0.1);
    }
.rounded{
border-radius:0px;
}
    #eye {
        width: 14px;
        display: inline-block;
        position: absolute;
        top: 3px;
        right: 12px;
        cursor: pointer;
    }

    .art-title {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .art-description {
        margin-top: 10px;
        font-size: 1rem;
    }

    .art-images {
        width: fit-content;
    }

    .art-images img {
        max-width: 100%;
        height: auto;
    }

    .item-count {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: .5rem;
        background: rgba(0, 0, 0, 0.5);
        color: white;
        padding: 1.5px  3px;
        border-radius: 5px;
    }
    
      .myContainer {
          position: absolute;
            padding:1%;
            opacity: 0;
            visibility: hidden;

            /* Smooth transition */
            transition: opacity 0.4s ease-in-out, visibility 0.4s ease-in-out;
        }
        
        .myContainer.position-absolute {
            position: absolute;
        }

       
     .myContainer.fade-in-scroll {
            opacity: 1;
            visibility: visible;
        }

    @media (max-width: 1200px) {
        .text-fixed {
            font-size: 0.5rem;
        }

        #eye {
            right: 12px;
        }

        .item-count {
            font-size: 0.5rem;
        }

        .art-description {
            font-size: 0.5rem;
        }
    }

    .text-fixed1 {
        bottom: 25px;
    }

    .navbar {
        color: antiquewhite;
        font-family: 'JetBrainsMono-Regular' !important;
        list-style: none;
        display: flex;
        align-items: center; /* <-- ensure navbar children are vertically centered */
        margin: 0;
        padding: 10px 20px;
        position: fixed;
        top: 10px;
        left: 50%;
        transform: translateX(-50%);
        width: auto;
        z-index: 1;
        background: transparent !important;
        border: none !important;
        backdrop-filter: none;
        -webkit-backdrop-filter: none;
    }

    #home-link.active-page {
        text-decoration: underline;
        text-underline-offset: 4px;
    }

    .footer {
        color: antiquewhite;
    font-family: 'JetBrainsMono-Regular' !important;
        position: fixed;
        bottom: 0;
    }

    pre, p, .container {
        color: antiquewhite;
    }
    
    .container {
                    width:100%;
    }

    .links a {
        color: limegreen !important;
        font-size: large;
    }

    canvas {
        overflow-x: hidden;
    }

    li {
        color: blueviolet;
    }

    ul {
        list-style-type: none;
        margin: auto;
        padding: 0;
        position: relative;
        width: 100%;
    }

    .fade-in {
        opacity: 0;
        transition: opacity 1s ease-in;
    }

    .fade-in.show {
        opacity: 1;
    }

    .fade-in-fast {
        opacity: 0;
        transition: opacity 1s ease-in;
    }

    .fade-in-fast.show {
        opacity: 1;
    }

    #header {
        color: ghostwhite;
    }

    .navbar-transparent {
        background-color: transparent !important;
    }

    /* Force navbar text to be light/white (for dark backgrounds) */
    .navbar-dark-text .nav-link,
    .navbar-dark-text .nav-item,
    .navbar-dark-text .light-text,
    .navbar-dark-text .dark-text,
    .navbar-dark-text a {
        color: #ffffff !important;
    }
    
    .navbar-dark-text svg {
        fill: #ffffff !important;
        color: #ffffff !important;
    }

    .navbar-dark-text #toggleDarkLight img {
        filter: invert(1) !important;
    }

    .dark-bg {
        background-color: #0a0108 !important;
    }
    
             .image-container .col-12, .image-container .col-md-6, .image-container .col-6, .image-container .col-md-4, .image-container .col-4, .image-container .col-md-3, .image-container .col-3, .image-container .col-md-2{
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            align-items:center;
        }
  .image-div {
          z-index: -10;
            position: absolute;
            width: 100vw;
            height: calc(100vh - 10px);
            top: 0;
            left: 0;
        }
        .cursor-pointer{
            cursor:pointer;
        }
        .image-div img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    .light-bg {
        background-color: var(--white) !important;
    }

    .dark-border, .dark-border-top {
        border-bottom: 1px solid transparent;
        transition: border-bottom-color 1s ease-in;
    }

    .dark-border-top {
        border-top: 1px solid transparent;
        transition: border-top-color 1s ease-in;
    }

    .dark-border.fade-in {
        border-bottom-color: var(--dark) !important;
    }

    .dark-border-top.fade-in {
        border-top-color: var(--dark) !important;
    }
    
    .dark-border-full{
        border: 1px solid transparent;
        border-color: var(--dark) !important;
    }
    
    .light-border-full{
        border: 1px solid transparent;
        border-color: var(--white) !important;
    }


    .light-border, .light-border-top {
        border-bottom: 1px solid transparent;
        transition: border-bottom-color 1s ease-in;
    }

    .light-border-top {
        border-top: 1px solid transparent;
        transition: border-top-color 1s ease-in;
    }

    .light-border.fade-in {
        border-bottom-color: var(--white) !important;
    }

    .light-border-top.fade-in {
        border-top-color: var(--white) !important;
    }

    .light-border2 {
        border-bottom-color: var(--white) !important;
        border-bottom: 1px solid;
    }

    .dark-border2 {
        border-bottom-color: var(--dark) !important;
        border-bottom: 1px solid;
    }

    .light-text {
        color: var(--white);
    }

    .dark-text {
        color: #0a0108;
    }

    .view-tokens-btn {
        display: inline-block;
        padding: 12px 28px;
        background: transparent;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        letter-spacing: 1px;
        text-transform: uppercase;
        border-width: 1px;
        border-style: solid;
        border-color: currentColor;
        transition: all 0.2s ease;
    }

    .view-tokens-btn:hover {
        opacity: 0.7;
        text-decoration: none;
        color: inherit;
    }

    .claim-nav-link {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.45rem 0.8rem;
        border: 2px solid #111;
        border-radius: 999px;
        color: #111 !important;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        background: #fff;
        transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease, color 0.2s ease;
    }

    @media (max-width: 768px) {
        .claim-nav-link,
        .claim-pill,
        a[href="/claim/"],
        a[href*="andrewmitchell-art.xyz/claim/"] {
            display: none !important;
            visibility: hidden !important;
        }
    }

    .claim-nav-link:hover,
    .claim-nav-link:focus {
        transform: translateY(-1px);
        color: #111 !important;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.16);
    }

    .claim-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.14rem 0.45rem;
        border-radius: 999px;
        background: #111;
        border: 1px solid #111;
        font-size: 0.7rem;
        font-weight: 800;
        vertical-align: top;
        letter-spacing: 0.08em;
        color: #fff;
    }

    @media (max-width: 768px) {
        .claim-pill {
            display: none;
        }
    }

    .dark-text .claim-nav-link {
        border-color: #111;
        background: #fff;
        color: #111 !important;
    }

    .dark-text .claim-pill {
        background: #111;
        color: #fff;
    }

    .light-text .claim-nav-link {
        border-color: #111;
        background: #fff;
        color: #111 !important;
    }

    .light-text .claim-pill {
        background: #111;
        color: #fff;
    }

    /* Shared art page styles */
    .art-page {
        padding: 40px 30px;
    }

    .art-page li {
        color: inherit;
    }

    .art-page h1 {
        margin-bottom: 4px;
    }

    .art-page .date {
        margin-bottom: 20px;
        font-size: 14px;
        letter-spacing: 1px;
    }

    .art-page .btn-row {
        margin-bottom: 30px;
    }

    @media (max-width: 768px) {
        .art-page {
            padding: 20px 16px;
        }
    }

    .art-page .description {
        margin-bottom: 30px;
        line-height: 1.7;
    }

    .art-page .contract-details {
        margin-bottom: 30px;
        line-height: 1.7;
    }

    .art-page .contract-details img {
        max-width: 100%;
        height: auto;
        margin-top: 10px;
    }

    .art-page .featured-img {
        text-align: center;
        margin: 30px 0;
    }

    .art-page .featured-img img {
        max-width: 100%;
        height: auto;
        border: 1px solid currentColor;
    }

    .art-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(500px, 1fr));
        gap: 16px;
        padding: 20px 0;
    }

    .art-gallery img {
        width: 100%;
        height: auto;
        display: block;
        opacity: 0;
        transition: opacity 0.8s ease;
    }

    .art-gallery img.lazyloaded {
        opacity: 1;
    }

    .art-gallery .wide {
        grid-column: 1 / -1;
    }

    @media (max-width: 768px) {
        .art-gallery {
            grid-template-columns: 1fr;
        }
    }

    /* Slideshow */
    .slideshow {
        position: relative;
        margin: 0 0 0 0;
        max-height: 90vh;
        display: inline-block;
        border: 1px solid currentColor;
        overflow: hidden;
    }

    .slideshow img {
        max-width: 100%;
        max-height: 90vh;
        height: auto;
        width: auto;
        display: block;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.6s ease;
        object-fit: contain;
        position: absolute;
        top: 0;
        left: 0;
    }

    .slideshow img.active {
        opacity: 1;
        visibility: visible;
        position: relative;
    }

    .slideshow-dots {
        display: flex;
        gap: 6px;
        justify-content: flex-start;
        margin-top: 8px;
        margin-bottom: 16px;
    }

    .slideshow-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        border: none;
        padding: 0;
        cursor: pointer;
        background: currentColor;
        opacity: 0.3;
        transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .slideshow-dot.active {
        opacity: 0.9;
        transform: scale(1.25);
    }

    .slideshow-dot:hover {
        opacity: 0.7;
    }

    .dark-bg-transparent {
        background-color: rgba(10, 1, 8, 0.9);
    }

    .light-bg-transparent {
        background-color: rgba(255, 255, 255, 0.9);
    }

    .dark-bg-transparent2 {
        background-color: rgba(10, 1, 8, 0.85);
    }

    .light-bg-transparent2 {
        background-color: rgba(255, 255, 255, 0.85);
    }

    .border-dotted {
        border-bottom: 0.3px dotted !important;
    }

    /* Ensure the dark/light toggle button and its icon are vertically centered */
    #toggleDarkLight {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 6px; /* small padding to give a consistent click area */
        margin-top: 0; /* override any accidental top offset */
        background: none !important;
        border: none !important;
    }

    /* Vertical-rl navbar option: writing vertical text from right to left.
       Apply by adding the 'vertical-rl' class to the #nav element, or use
       the URL parameter ?layout=vertical to enable it automatically.
    */
    .navbar.vertical-rl {
        writing-mode: vertical-rl;
        -webkit-writing-mode: vertical-rl;
        flex-direction: column;
        position: fixed;
        right: 10px; /* pin to the right side */
        left: auto;
        top: 50%;
        transform: translateY(-50%);
        padding: 8px 6px;
        background: transparent !important;
    }

    .navbar.vertical-rl .navbar-nav {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .navbar.vertical-rl .nav-item,
    .navbar.vertical-rl .nav-link {
        margin: 6px 0;
        padding: 2px 4px;
        writing-mode: vertical-rl;
        transform: none; /* ensure no extra transform interferes */
    }

    .navbar.vertical-rl #toggleDarkLight {
        margin: 6px 0 0 0;
        align-self: center;
    }

    </style>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.9.0/p5.js"></script>

    
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>

let isDarkMode = true;

function setInitialLightDarkMode() {
    const urlParams = new URLSearchParams(window.location.search);
    let mode = urlParams.get('mode');

    if (mode === null) {
        const cookieMode = getCookie('mode');
        console.log(cookieMode);
        if (cookieMode !== "") {
            mode = cookieMode;
             if (mode === "0") {
                setLightMode(true);  // Use dark mode if mode is 0
                isDarkMode = true;   // Update the local variable
            } else {
                setLightMode(false); // Use light mode if mode is 1
                isDarkMode = false;  // Update the local variable
            }
    } else {
            const now = new Date();
            const currentHour = now.getHours();

            // Default to dark mode and switch to light mode based on time
            if (currentHour >= 3 && currentHour < 22) {
                setLightMode(true); // Set to light mode during the day
                isDarkMode = true;  // Update the local variable
                mode = '1'; // Update mode
            } else {
                setLightMode(false);  // Set to dark mode during the night
                isDarkMode = false;   // Update the local variable
                mode = '0'; // Update mode
            }
        }
    } else {
        if (mode === "0") {
            setLightMode(true);  // Use dark mode if mode is 0
            isDarkMode = true;   // Update the local variable
        } else {
            setLightMode(false); // Use light mode if mode is 1
            isDarkMode = false;  // Update the local variable
        }
    }
    updateNavigationLinks(!isDarkMode);
}

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}


function setLightMode(isDark) {
    if (isDark) {
            $(".light-text").removeClass("light-text").addClass("dark-text");
            $(".dark-bg").removeClass("dark-bg").addClass("light-bg");
            $(".dark-bg-transparent").removeClass("dark-bg-transparent").addClass("light-bg-transparent");
            $(".dark-bg-transparent2").removeClass("dark-bg-transparent2").addClass("light-bg-transparent2");
            $(".dark-bg-transparent3").removeClass("dark-bg-transparent3").addClass("light-bg-transparent3");

            $(".light-border-top").removeClass("light-border-top").addClass("dark-border-top");
                    $(".art-square-dark").removeClass("art-square-dark").addClass("art-square-light");

            $(".light-border").removeClass("light-border").addClass("dark-border2");
            $(".light-border2").removeClass("light-border2").addClass("dark-border2");
            $(".light-border-full").removeClass("light-border-full").addClass("dark-border-full");

            $("#darkMode").css("filter", "invert(0)");
        } else {
            $(".dark-text").removeClass("dark-text").addClass("light-text");
            $(".light-bg").removeClass("light-bg").addClass("dark-bg");
            $(".light-bg-transparent").removeClass("light-bg-transparent").addClass("dark-bg-transparent");
            $(".light-bg-transparent2").removeClass("light-bg-transparent2").addClass("dark-bg-transparent2");
                    $(".art-square-light").removeClass("art-square-light").addClass("art-square-dark");
        $(".light-bg-transparent3").removeClass("light-bg-transparent3").addClass("dark-bg-transparent3");

            $(".dark-border").removeClass("dark-border").addClass("light-border2");
            $(".dark-border2").removeClass("dark-border2").addClass("light-border2");
            $(".dark-border-top").removeClass("dark-border-top").addClass("light-border-top");
            $("dark-border-full").removeClass("dark-border-full").addClass("light-border-full");

            $("#darkMode").css("filter", "invert(1)");
        }
        $("#toggleDarkLight").blur();
}

function toggleLightDark() {
    if (isDarkMode) {
        setLightMode(false);
        updateNavigationLinks(isDarkMode);
    } else {
        setLightMode(true);
        updateNavigationLinks(isDarkMode);
    }
    isDarkMode = !isDarkMode; // Toggle the local variable
}

$(document).ready(function() {
    window.name = 'artsite';
    setInitialLightDarkMode();
    // Apply vertical layout if requested via URL or cookie
    applyLayoutFromParam();
    $("#toggleDarkLight").on("click", function() {
        toggleLightDark();
    });
});

function applyLayoutFromParam() {
    const urlParams = new URLSearchParams(window.location.search);
    let layout = urlParams.get('layout');
    if (!layout) {
        // fallback to cookie
        const layoutCookie = getCookie('layout');
        if (layoutCookie) layout = layoutCookie;
    }
    if (layout && (layout === 'vertical' || layout === 'vertical-rl')) {
        const nav = document.getElementById('nav');
        if (nav) {
            nav.classList.add('vertical-rl');
        }
        // persist preference in a cookie so reloads keep it
        document.cookie = `layout=vertical; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/`;
    }
}

function updateNavigationLinks(isDark) {
    const mode = isDark ? '1' : '0'; // 0 for dark mode, 1 for light mode
    document.querySelectorAll('.nav-link-2').forEach(function(link) {
        const href = link.getAttribute('href').split('?')[0]; // Get the base URL without any existing query parameters
        const newHref = `${href}?mode=${mode}`; // Create the new href with the mode query parameter
        link.setAttribute('href', newHref); // Update the href attribute with the mode query parameter
    });
  // Get the current URL and query parameters
const url = new URL(window.location.href);
const searchParams = new URLSearchParams(url.search);

// Update or add the 'mode' parameter
searchParams.set('mode', mode);

// Reconstruct the URL with the updated query parameters
url.search = searchParams.toString();

// Replace the URL in the browser without reloading the page
history.replaceState({}, document.title, url.toString());

    // Update the cookies with the mode
    document.cookie = `mode=${mode}; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/`;
}

function hideClaimLinkOnMobile() {
    if (!window.matchMedia('(max-width: 768px)').matches) {
        return;
    }

    document.querySelectorAll('a.claim-nav-link, a[href="/claim/"], a[href*="andrewmitchell-art.xyz/claim/"]').forEach(function(link) {
        link.remove();
    });
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.fade-in').forEach(function(element) {
        element.classList.add('show');
    });
    hideClaimLinkOnMobile();
});

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.fade-in-fast').forEach(function(element) {
        element.classList.add('show');
    });
});

document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            document.getElementById('nav').classList.add('fade-in');
        }, 100); // Add a slight delay to ensure transition is visible
        setTimeout(function() {
            document.getElementById('footer').classList.add('fade-in');
        }, 100); // 
        
    });
    $(document).ready(function() {
      // Function to check if the screen width is less than or equal to 768px (typically considered as mobile)
      function adjustFooterTextSize() {
        if ($(window).width() <= 1200) {
          $("#footer-text").css("font-size", "10px");
          $("#eye").css("top","-24px");
        } else {
        }
      }

      // Call the function on page load
      adjustFooterTextSize();

      // Call the function when the window is resized
      $(window).resize(function() {
        adjustFooterTextSize();
      });
    });

    // Shared lazy-load observer for all art pages
    document.addEventListener("DOMContentLoaded", function() {
        var lazyImages = [].slice.call(document.querySelectorAll("img.lazy"));
        if ("IntersectionObserver" in window) {
            var lazyImageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        var lazyImage = entry.target;
                        lazyImage.src = lazyImage.dataset.src;
                        lazyImage.classList.remove("lazy");
                        lazyImage.classList.add("lazyloaded");
                        lazyImageObserver.unobserve(lazyImage);
                    }
                });
            });
            lazyImages.forEach(function(lazyImage) {
                lazyImageObserver.observe(lazyImage);
            });
        }
    });

    // Sync slideshow-dots width with slideshow image width
    document.addEventListener("DOMContentLoaded", function() {
        var slideshow = document.getElementById('slideshow');
        var dots = document.getElementById('slideshowDots');
        if (!slideshow || !dots) return;
        function syncDotsWidth() {
            dots.style.width = '';
        }
        syncDotsWidth();
    });
    </script>
</head>

<body class="fade-in-fast dark-bg">
<div id="mode-transition"></div>
    

<nav id="nav" class="navbar navbar-expand navbar-custom navbar-transparent fade-in-fast">
  <div class="navbar-nav mr-auto ">
    <a id="home-link" class="nav-item nav-link nav-link-2 light-text font-16" style="margin-top:1.5px;" href="https://www.andrewmitchell.xyz"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
  <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"></path>
</svg></a>
    <a class="nav-item nav-link nav-link-2 underline light-text font-16" href="/art.php">ART</a>
    <a class="nav-item nav-link nav-link-2 underline light-text font-16" href="/collections/" target="catalog">CATALOG</a>
    <a class="nav-item nav-link nav-link-2 underline light-text font-16" href="/about.php">ABOUT</a>
  </div>
   <button id="toggleDarkLight" class="btn ml-auto"  style="background: none;"><img id="darkMode" height="16px" width="16px" style="filter:invert(1)" src="https://andrewmitchell-art.xyz/images/dark-icon.png" alt="Light Dark Toggle"/></button>
</nav>
<?php
}
?>


