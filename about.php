<!DOCTYPE html>
<html lang="en">
   <?php include 'meta.php'; ?>
   <script>
          document.title = "Andrew Mitchell - About";

       $(document).ready(function() {
        $("a.nav-item.nav-link:contains('ABOUT')").css("text-decoration", "underline");
    });
   </script>
<style>
    #about-wrapper {
        width: 100%;
        min-height: 100vh;
        opacity: 0;
        animation: aboutFadeIn 1s ease forwards;
    }
    @keyframes aboutFadeIn {
        to { opacity: 1; }
    }
    #about-canvas {
        display: block;
        width: 100%;
    }
    #about-images {
        columns: 2;
        column-gap: 20px;
        padding: 0 40px 80px;
    }
    @media (max-width: 767px) {
        #about-images {
            columns: 1;
            padding: 0 20px 60px;
        }
    }
    .about-image {
        box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        overflow: hidden;
        break-inside: avoid;
        margin-bottom: 20px;
    }
    .about-image img {
        display: block;
        width: 100%;
        height: auto;
    }
    .about-image .caption {
        font-style: italic;
        font-size: 0.75rem;
        opacity: 0.7;
        padding: 4px 2px;
    }
</style>

<div id="about-wrapper">
    <canvas id="about-canvas"></canvas>

    <div style="padding: 0 40px 20px;">
        <div class="about-image" style="max-width: 600px;">
            <img src="images/personal/process (1).png" alt="Process">
            <div class="caption">Process</div>
        </div>
    </div>

    <div id="about-images">
    <div class="about-image" data-img="ide">
        <img src="https://images.squarespace-cdn.com/content/637d087cfeae7764854916c4/af692504-3f1a-4a62-9ec7-ef68b967d68b/Screenshot+2024-06-19+at+10.59.52%E2%80%AFPM.png?content-type=image%2Fpng" alt="Webstorm IDE">
        <div class="caption">A partnership with Grant Yun.</div>
    </div>
    <div class="about-image" data-img="me">
        <img src="images/personal/me.jpeg" alt="Profile Photo">
    </div>
    <div class="about-image" data-img="studio">
        <img src="images/personal/studio.jpeg" alt="Studio">
    </div>
    <div class="about-image" data-img="hongkong">
        <img src="https://images.squarespace-cdn.com/content/637d087cfeae7764854916c4/b092e04e-75f1-4c34-809f-91634ca692ae/IMG_6218.JPG?content-type=image%2Fjpeg" alt="Hong Kong">
        <div class="caption">Royal Palace on display in Hong Kong</div>
    </div>
    <div class="about-image" data-img="durango">
        <img src="https://images.squarespace-cdn.com/content/637d087cfeae7764854916c4/79776134-233b-4b79-aa0e-64f5568ae82a/F8B-aIQWYAAcIzz.jpeg?content-type=image%2Fjpeg" alt="Durango at Art on Paper">
        <div class="caption">Showing Durango at Art on Paper 2023</div>
    </div>
    </div>
</div>

<div style="padding: 0 40px 80px; text-align: left;">
    <style>
        #about-links li { color: inherit; }
        #about-links a { color: #4a90d9; text-decoration: underline; }
        #about-links a:visited { color: #7b68ae; }
    </style>
    <div id="about-links" class="light-text">
    <div style="margin-bottom: 8px;"><a href="/art/gentleskies.php">Gentle Skies</a>, a digital gallery</div>
    <ul class="list-unstyled">
        <li><a href="https://opensea.io/collection/nokori-by-andrew-mitchell">NOKORI (残り)</a> [2026]</li>
        <li><a href="https://superrare.com/andrew_mitchell">SuperRare</a></li>
        <li><a href="https://foundation.app/collection/durango" target="_blank">Durango</a> [2023]</li>
        <li><a href="https://foundation.app/mint/eth/0xa20D68492A8F74D69270f7D376AC93c26F9C8979/1" target="_blank">No Diving</a> [2023]</li>
        <li><h5 class="mb-0 mt-3">Collections</h5></li>
        <li><a href="https://foundation.app/collection/flowersofalfiren">Flowers of Alfiren</a> [2023] (Published by <a href="https://www.vertufineart.com">Vertu Fine Art</a>)</li>
        <li><a href="https://opensea.io/collection/sky-meadow-by-andrew-mitchell">Sky Meadow</a> [2022]</li>
        <li><a href="https://opensea.io/collection/primera-by-mitchell-and-yun" target="_blank">Primera</a> [2021] with <a href="https://www.ribbonriven.com/" target="_blank">Grant Yun</a></li>
        <li><a href="https://opensea.io/collection/memory-loss-by-andrew-mitchell" target="_blank">Memory Loss</a> [2023] (Published in Proof's <a href="https://www.proof.xyz/exhibitions/diamond/memory-loss" target="_blank">Diamond Exhibition</a>)</li>
        <li><a href="https://opensea.io/collection/flume-by-andrew-mitchell">Flume</a> [2022]</li>
        <li><a href="https://opensea.io/collection/decal-by-andrew-mitchell" target="_blank">Decal</a> [2023] (Kicked off SZN 3 with <a href="https://deca.art/decals">Deca</a>)</li>
        <li><a href="https://foundation.app/collection/tcu" target="_blank">The Creation of the Universe</a> [2021]</li>
        <li><h5 class="mb-0 mt-3">Arbitrum Layer 2 NFTs</h5></li>
        <li><a href="https://prohibition.art/project/butterfly-pact">Butterfly Pact</a> [2023]</li>
        <li><a href="https://prohibition.art/project/necromancer" target="_blank">Necromancer</a> [2023] (Featured as one of the first 11 releases on Prohibition.art)</li>
        <li><h5 class="mb-0 mt-3">Collaborations</h5></li>
        <li><a href="https://foundation.app/collection/modulo" target="_blank">Modulo</a> [2024] with Rich Caldwell</li>
        <li><a href="https://superrare.com/0x7e5029837a43c547cdcea2107a1e07e30d68c6d6/prozac-youth-3" target="_blank">Prozac Youth</a> [2022] with Tjo</li>
        <li><a href="https://opensea.io/collection/up-in-smoke-3">Up in Smoke</a> [2023] with Mannay and A. Marrast</li>
        <li><h5 class="mb-0 mt-3">Optimism Layer 2 NFTs</h5></li>
        <li><a href="https://highlight.xyz/mint/659b2a2363f21afad40913ca" target="_blank">Storybook</a> [2024]</li>
        <li><h6 class="mb-0 mt-2">Editions</h6></li>
        <li><a href="https://1155.tech/market/55" target="_blank">Bee POV</a> [2023]</li>
        <li><a href="https://1155.tech/market/61" target="_blank">Flowers for Your Desktop Background</a> [2023]</li>
        <li><h5 class="mb-0 mt-3">XTZ NFTs</h5></li>
        <li><a href="https://objkt.com/collection/KT1MUpTQZNCXAZkp69ZcKS6T3hVPeRn1vPqg" target="_blank">Planes</a> [2022]</li>
        <li><a href="https://objkt.com/tokens/versum_items/20636" target="_blank">Triptych</a> [2022]</li>
        <li><a href="https://objkt.com/tokens/versum_items/21880" target="_blank">Triptych</a> [2022]</li>
        <li><h6 class="mb-0 mt-2">Collections</h6></li>
        <li><a href="https://www.fxhash.xyz/generative/slug/as-the-wind-blows">As the Wind Blows</a> with <a href="https://x.com/freeimpeth" target="_blank">freeimp</a> [2023]</li>
        <li><a href="https://www.fxhash.xyz/generative/11806" target="_blank">Kinetics</a> [2022]</li>
        <li><a href="https://www.fxhash.xyz/generative/22520">Oscillators</a> [2022]</li>
        <li><a href="https://www.fxhash.xyz/generative/21361">Scoops</a> [2023]</li>
        <li><a href="https://www.fxhash.xyz/generative/24940">Flumes</a> [2022]</li>
        <li><h5 class="mb-0 mt-3">Writing</h5></li>
        <li><a href="https://medium.com/@mitchel1/the-rise-of-on-chain-1-1-generative-art-on-eth-7f663aa52736">The Rise of On-Chain 1/1 Generative Art on ETH</a></li>
        <li><a href="https://www.fxhash.xyz/article/kinetics-by-andrew-mitchell">Kinetics (an fxText)</a></li>
        <li><a href="https://medium.com/@mitchel1/necromancer-1dd9199acd91">Necromancer</a></li>
    </ul>
    </div>
</div>

<script type="module">
let prepareWithSegments, layoutNextLine;

const canvas = document.getElementById('about-canvas');
const ctx = canvas.getContext('2d');

const aboutSegments = [
    { text: "About", size: 'header' },
    { text: "I make art with code. I am also bad at coding. Skill is relative. Making art actually has nothing to do with coding skill. A computer could optimize every line I write but it cannot make the same mistakes I do. I write code, hit run, and the computer shows me what I commanded. My logic is filtered through a machine that doesn\u2019t even know what it is looking at (for now). Sometimes what comes back is better than what I had in my head. It feels magical at times. ", size: 'body' },
    { text: "This may sound unorthodox to some, so let me explain. Imagine you want to create a portrait. At a basic level, there is a body and a head. You cannot just code \u201Cdraw face\u201D, that does not make any sense to the computer. You need to break it down into lines, rectangles, circles\u2026 These have x, y, z coordinates and properties (color, stroke size, etc) that the computer can understand. Every piece, from the perspective of the computer, is perfect. Iteration through human interaction is then what creates generative art. ", size: 'body' },
    { text: "Computer Programming is based on a set of rules, however, you hear artists say art is about breaking rules. I find this kind of ironic. ", size: 'body' },
    { text: "What does it mean to create generative art? ", size: 'question' },
    { text: "It is created by a human with a computer. Programming languages allow the artist to command the computer to work. It is not created via passing prompts to an AI created by someone else. Algorithmic artists are no different than painters, we just exist in a different form. ", size: 'body' },
    { text: "It is impossible for me to know what a computer will do until it does something. I can make predictions, but until I hit run, the outcome is undecidable. ", size: 'body' },
    { text: "Code based art does not need to be something that technically wows someone or is a \u201CI do not understand how this was made\u201D. A lot of code based art probably will never be fully understood. I want to make art that is recognizable for what it is. Does that mean I will not make technically focused works? No, not at all. It just means that I am human and I want to work in a way that feels human. Live, experience things, open my mind. Do not get boxed into thinking that art made with code needs to be 1 + 2 = 3, it can be 1 + 2 = 4. The work would be creating a program that takes 1 + 2 and spits out 4 instead of 3. ", size: 'body' },
    { text: "It is easy to draw straight lines, but it is hard to paint. To paint with code is not to just draw straight lines, but to emulate the human process and re-invent it. ", size: 'body' },
    { text: "You ultimately run into a case where you have to balance program performance with your choices as an artist. I do not have an answer for that. ", size: 'body' },
    { text: "CV", size: 'question' },
    { text: "• BS in Computer Science, University of Virginia ", size: 'cv' },
    { text: "• Co-founder, Mitchell and Yun Studios (with Grant Yun), 2021–present ", size: 'cv' },
    { text: "Selected Exhibitions ", size: 'cv-question' },
    { text: "• Art on Paper, New York, 2023 ", size: 'cv' },
    { text: "• Royal Palace, Hong Kong ", size: 'cv' },
    { text: "• Proof Diamond Exhibition (Memory Loss), 2023 ", size: 'cv' },
    { text: "• Gentle Skies, OnCyber Virtual Gallery, 2022–2024 ", size: 'cv' },
    { text: "• 12 Days of Art (Rich Caldwell), 2022 ", size: 'cv' },
    { text: "• Play Action Pass, Benchetler Fasani Foundation (group charity show) ", size: 'cv' },
    { text: "Selected Works ", size: 'cv-question' },
    { text: "• Nokori — 401 editions, Ethereum, 2026 ", size: 'cv' },
    { text: "• Popup — 114 editions, Ethereum, 2024 ", size: 'cv' },
    { text: "• Prozac Youth (with Tjo) — 1/1, Ethereum, 2024 ", size: 'cv' },
    { text: "• Modulo (with Rich Caldwell) — 128 editions, Ethereum/Foundation, 2024 ", size: 'cv' },
    { text: "• Flowers of Alfiren — 86 editions, Ethereum, presented by Vertu Fine Art, 2023 ", size: 'cv' },
    { text: "• Butterfly Pact — 95 editions, Arbitrum, presented by Prohibition / Art Blocks Engine, 2023 ", size: 'cv' },
    { text: "• Memory Loss — 256 editions, Ethereum, presented by Proof / Art Blocks Engine, 2023 ", size: 'cv' },
    { text: "• Necromancer — 128 editions, Arbitrum, presented by Prohibition / Art Blocks Engine, 2023 ", size: 'cv' },
    { text: "• A Sudden Interest in Nature — 10 editions, Ethereum/SuperRare, 2022–2023 ", size: 'cv' },
    { text: "• April Showers — 9 editions, Ethereum, 2023 ", size: 'cv' },
    { text: "• Touch Grass — 9 editions, Ethereum, 2022 ", size: 'cv' },
    { text: "• Sky Meadow — 555 editions, Ethereum, 2022 ", size: 'cv' },
    { text: "• Flume — 7 on-chain 1/1s, Ethereum, 2022 ", size: 'cv' },
    { text: "• The Moon (with omentejovem) — 1/1, Ethereum, 2022 ", size: 'cv' },
    { text: "• Primera (with Grant Yun) — 400 editions, Ethereum, CC0, 2021 ", size: 'cv' },
    { text: "Collaborations ", size: 'cv-question' },
    { text: "• Grant Yun — Primera, Mitchell and Yun Studios ", size: 'cv' },
    { text: "• Rich Caldwell — Modulo, No Diving (Recursive Reflection) ", size: 'cv' },
    { text: "• Tjo — Prozac Youth ", size: 'cv' },
    { text: "• omentejovem — The Moon ", size: 'cv' },
    { text: "Platforms ", size: 'cv-question' },
    { text: "• Art Blocks Engine, Prohibition, Proof, SuperRare, Foundation, Manifold, OpenSea, Deca ", size: 'cv' },
    { text: "Writing ", size: 'cv-question' },
    { text: "• The Rise of On-Chain 1/1 Generative Art on ETH — Medium ", size: 'cv' },
];

async function init() {
    try {
        const pretext = await import('https://esm.sh/@chenglou/pretext');
        prepareWithSegments = pretext.prepareWithSegments;
        layoutNextLine = pretext.layoutNextLine;
    } catch(e) {
        console.error('Pretext import failed:', e);
        return;
    }

    await document.fonts.ready;

    render();
    window.addEventListener('resize', render);

    const toggleBtn = document.getElementById('toggleDarkLight');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => setTimeout(render, 50));
    }
}

function render() {
    const wrapper = document.getElementById('about-wrapper');
    const totalWidth = wrapper.offsetWidth;
    const isMobile = totalWidth < 768;
    const margin = isMobile ? 20 : 40;
    const contentWidth = totalWidth - margin * 2;
    const dpr = window.devicePixelRatio || 1;

    // Prepare segments
    const prepared = aboutSegments.map(seg => {
        let fs, lh;
        if (seg.size === 'header') {
            fs = isMobile ? 48 : 72;
            lh = fs * 1.2;
        } else if (seg.size === 'question') {
            fs = isMobile ? 28 : 42;
            lh = fs * 1.3;
        } else if (seg.size === 'cv-question') {
            fs = isMobile ? 18 : 26;
            lh = fs * 1.3;
        } else if (seg.size === 'cv') {
            fs = isMobile ? 12 : 16;
            lh = fs * 1.5;
        } else {
            fs = isMobile ? 16 : 22;
            lh = fs * 1.6;
        }
        return {
            prepared: prepareWithSegments(seg.text, `${fs}px Satoshi-Regular`),
            fontSize: fs,
            lineHeight: lh,
            sizeType: seg.size
        };
    });

    // Measure text height
    let measuredH = 60;
    for (const seg of prepared) {
        if (seg.sizeType === 'question' || seg.sizeType === 'cv-question') measuredH += seg.lineHeight;
        let cursor = { segmentIndex: 0, graphemeIndex: 0 };
        while (true) {
            const line = layoutNextLine(seg.prepared, cursor, contentWidth);
            if (!line) break;
            cursor = line.end;
            measuredH += seg.lineHeight;
        }
        if (seg.sizeType === 'header' || seg.sizeType === 'question' || seg.sizeType === 'cv-question') measuredH += seg.lineHeight * 0.5;
    }
    measuredH += 40;

    // Set canvas to exact size, then draw
    canvas.width = totalWidth * dpr;
    canvas.height = measuredH * dpr;
    canvas.style.width = totalWidth + 'px';
    canvas.style.height = measuredH + 'px';
    ctx.setTransform(1, 0, 0, 1, 0, 0);
    ctx.scale(dpr, dpr);
    ctx.clearRect(0, 0, totalWidth, measuredH);
    ctx.textBaseline = 'top';

    const fillColor = isDarkMode ? 'rgba(0, 0, 0, 0.95)' : 'rgba(255, 255, 255, 0.95)';

    let y = 60;
    for (const seg of prepared) {
        if (seg.sizeType === 'question' || seg.sizeType === 'cv-question') y += seg.lineHeight;
        ctx.font = `${seg.fontSize}px Satoshi-Regular`;
        ctx.fillStyle = fillColor;
        let cursor = { segmentIndex: 0, graphemeIndex: 0 };
        while (true) {
            const line = layoutNextLine(seg.prepared, cursor, contentWidth);
            if (!line) break;
            ctx.fillText(line.text, margin, y);
            cursor = line.end;
            y += seg.lineHeight;
        }
        if (seg.sizeType === 'header' || seg.sizeType === 'question' || seg.sizeType === 'cv-question') y += seg.lineHeight * 0.5;
    }
}

init();
</script>

</body>
   <?php include 'footer.php'; ?>

</html>
