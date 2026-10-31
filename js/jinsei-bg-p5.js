/* ==========================================================================
   JINSEI background texture — grain + texture B (+ optional texture A).

   Uses the p5 1.9.0 already loaded on every page, in INSTANCE mode so it
   cannot collide with setup()/draw() on any art page that has its own sketch.

   Base tones are deliberately NOT #0a0108 / #ffffff. The texture layers are
   color-dodge and color-burn, which have no headroom at the ends of the
   range — measured luminance spread of the finished texture over a flat base:

       #0a0108   sd  5.93   (and it only darkens: mean 7.0 -> 3.8)
       #ffffff   sd  7.47   (texB moves the image 0.79/255)
       #1e1a1c   sd 13.48
       #333333   sd 21.33
       #e0e0e0   sd 13.99

   Override with window.JINSEI_BG = { dark, light, seed, texA, grain } before
   this script runs.
   ========================================================================== */
(function () {
    'use strict';

    var CFG     = window.JINSEI_BG || {};
    var DARK    = CFG.dark  || '#1e1a1c';
    var LIGHT   = CFG.light || '#e8e6e2';
    var SEED    = CFG.seed  || 'andrewmitchell';
    var GRAIN   = CFG.grain === undefined ? 20 : CFG.grain;
    var MAX_DPR = CFG.maxDpr || 2;
    var Z_INDEX = CFG.zIndex === undefined ? -11 : CFG.zIndex;

    // Texture A is off by default: over a flat page background it moves the
    // image 0.5/255 on average — invisible — while costing ~40% of the render.
    // It earns its keep in JINSEI only because it sits over drawn line work,
    // where dodge blows out the bright strokes. Set texA:true for spec fidelity.
    var USE_TEX_A = CFG.texA === true;

    // JINSEI renders at 2268x1057 with scaleFactor = min(W/1440, H/900).
    // Held constant so the speckle stays the same physical size on every screen.
    var SCALE = Math.min(2268 / 1440, 1057 / 900);   // 1.17444...

    // Layer specs, straight out of applyTexture / applyTexture2.
    var TEX_A = { spacing: 8, jitter: 0.3, base: 1, lo: -1, hi: 0.5,  s: [90, 100], l: [30, 50] };
    var TEX_B = { spacing: 4, jitter: 0.3, base: 3, lo: 0,  hi: 0.15, s: [20, 40],  l: [70, 90] };

    /* ---- deterministic RNG, same one JINSEI uses (src/jinsei.js) ---- */
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

    /* ---- which base tone the page is currently showing ---- */
    // Reads the DOM, not the page's isDarkMode flag — setLightMode(true) applies
    // the *light* palette while setting isDarkMode = true, so that flag is
    // backwards relative to what is actually painted.
    function toneNow() {
        var b = document.body;
        if (b.classList.contains('light-bg')) return LIGHT;
        if (b.classList.contains('dark-bg'))  return DARK;
        var m = (getComputedStyle(b).backgroundColor || '').match(/\d+/g);
        if (!m) return DARK;
        return (0.2126 * +m[0] + 0.7152 * +m[1] + 0.0722 * +m[2]) < 128 ? DARK : LIGHT;
    }

    var instance = null, ready = false, currentTone = null;

    function sketch(sk) {

        // One jittered grid of dots in one blend mode. Both texture layers are
        // this routine with different numbers.
        function speckle(rng, mode, spec) {
            var spacing = spec.spacing * SCALE;
            var hue = rng.decimal(0, 360);
            var sat = rng.decimal(spec.s[0], spec.s[1]);
            var lit = rng.decimal(spec.l[0], spec.l[1]);

            sk.blendMode(mode);
            sk.noStroke();
            sk.fill(hue, sat, lit);

            for (var y = 0; y < sk.height; y += spacing) {
                for (var x = 0; x < sk.width; x += spacing) {
                    // Scale is applied after the draw, not folded into the range:
                    // equal in real arithmetic, not in float, and enough to shift
                    // a sub-pixel dot's antialiased edge.
                    var ox = rng.decimal(-spec.jitter, spec.jitter) * SCALE;
                    var oy = rng.decimal(-spec.jitter, spec.jitter) * SCALE;
                    var d  = (spec.base + rng.decimal(spec.lo, spec.hi)) * SCALE;
                    if (d <= 0) continue;
                    sk.ellipse(x + ox, y + oy, d, d);
                }
            }
            sk.blendMode(sk.BLEND);
        }

        function paint() {
            var rng = new Rng(SEED);

            // Base first, and opaque: dodge and burn blend against whatever is
            // already on the canvas, so there has to be something there.
            sk.blendMode(sk.BLEND);
            sk.colorMode(sk.RGB);
            sk.background(currentTone);
            sk.colorMode(sk.HSL);

            // Pass 1 — monochrome grain. One draw shared by R/G/B so it reads as
            // luminance noise, not colour noise. Runs over the whole backing
            // store, so its cost scales with pixel density.
            if (GRAIN > 0) {
                sk.loadPixels();
                var px = sk.pixels;
                for (var i = 0; i < px.length; i += 4) {
                    var g = rng.decimal(-GRAIN, GRAIN);
                    px[i]     = px[i]     + g;   // clamps + rounds on assignment
                    px[i + 1] = px[i + 1] + g;
                    px[i + 2] = px[i + 2] + g;
                }
                sk.updatePixels();
            }

            // Pass 2 — fine dodge speckle. Pass 3 — dense burn speckle.
            if (USE_TEX_A) speckle(rng, sk.DODGE, TEX_A);
            speckle(rng, sk.BURN, TEX_B);
        }

        sk.setup = function () {
            sk.pixelDensity(Math.min(MAX_DPR, window.devicePixelRatio || 1));
            var c = sk.createCanvas(window.innerWidth, window.innerHeight);
            c.elt.id = 'jinsei-bg';
            c.elt.setAttribute('aria-hidden', 'true');
            // z-index -11 keeps it under .image-div (-10) so hero images still win.
            c.elt.style.cssText =
                'position:fixed;top:0;left:0;width:100vw;height:100vh;' +
                'z-index:' + Z_INDEX + ';pointer-events:none;display:block;';
            currentTone = toneNow();
            paint();
            ready = true;
            sk.noLoop();
        };

        sk.jinseiRepaint = function (w, h) {
            if (w) sk.resizeCanvas(w, h);
            currentTone = toneNow();
            paint();
        };
    }

    function mount() {
        if (document.getElementById('jinsei-bg')) return;
        if (typeof p5 !== 'function') return;   // p5 failed to load; skip silently

        instance = new p5(sketch);

        var lastW = window.innerWidth, lastH = window.innerHeight, timer = null;

        function update(force) {
            if (!ready) return;
            var w = window.innerWidth, h = window.innerHeight;
            // Height-only changes are the mobile URL bar sliding away; repainting
            // there reshuffles the whole background for nothing.
            var sizeChanged = w !== lastW || Math.abs(h - lastH) > 120;
            if (force !== true && !sizeChanged && toneNow() === currentTone) return;
            lastW = w; lastH = h;
            instance.jinseiRepaint(sizeChanged ? w : null, sizeChanged ? h : null);
        }

        window.addEventListener('resize', function () {
            clearTimeout(timer);
            timer = setTimeout(update, 250);
        });

        // The dark/light toggle swaps classes on <body>; repaint to match.
        if (window.MutationObserver) {
            new MutationObserver(function () {
                clearTimeout(timer);
                timer = setTimeout(update, 30);
            }).observe(document.body, { attributes: true, attributeFilter: ['class'] });
        }

        window.jinseiBgRedraw = function () { update(true); };
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', mount);
    } else {
        mount();
    }
})();
