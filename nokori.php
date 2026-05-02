<!DOCTYPE html>
<html lang="en">
<head>
   <?php include '../meta.php'; ?>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
          document.title = "Andrew Mitchell - Nokori (残り)";

       $(document).ready(function() {
           $("a.nav-item.nav-link:contains('ART')").css("text-decoration", "underline");
       });
   </script>
       <style>
    .offcanvas-custom {
        position: fixed;
        top: 0;
        right: -700px; /* Initially offscreen */
        width: 700px;
        height: 100vh;
        background-color: #fff;
        box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
        transition: right 0.3s ease-in-out;
        z-index: 1045; /* Above other elements */
    }

    h1 {
        font-size:3rem;
    }
.placeholder {
    min-height: 450px; /* Adjust this to approximate image height */
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}
.placeholder img,
.image-container img {
    max-width: 100%;
    height: auto;
}.cropped-image {
    clip-path: inset(.5px);
}

.placeholder img {
    opacity: 0; /* Hide image until loaded */
    transition: opacity 0.3s ease-in-out; /* Smooth transition for the image load */
}

img:not(.lazy) {
    opacity: 1; /* Show fully loaded image */
}
    .offcanvas-custom.active {
        right: 0; /* Slide in from the right */
    }

    .offcanvas-header {
        display: flex;
        justify-content: space-between;
        padding: 1rem;
        border-bottom: 1px solid #ddd;
        background-color: #f8f9fa;
    }

    .offcanvas-body {
        padding: 1rem;
        overflow-y: auto;
    }

    .wrapped-svg-markup {
        white-space: pre-wrap;
        word-wrap: break-word;
        max-width: 100%;
        background-color: #f8f9fa;
        padding: 10px;
        border: 1px solid #ddd;
        overflow: auto;
        max-height: 97vh;
    }

    .border2 {
            border-color: #f8f9fa !important;
    }
       .dark-bg-transparent3 {
    }

    .light-bg-transparent3 {
    }

    @media (max-width: 768px) {

        .dark-bg-transparent3 {
    }

    .light-bg-transparent3 {
        background-color: rgba(255, 255, 255, 0.45);
    }
    }

    .contract-link {
        text-decoration:underline;
    }

    .btn-close {
        background: none;
        border: none;
        font-size: 1.5rem;
    }

    .dark-bg-transparent {
        background-color: rgba(10, 1, 8, 0.4);
    }

    .light-bg-transparent {
        background-color: rgba(255, 255, 255, 0.4);
    }


    /* Timeline styles */
    .timeline-container {
        position: fixed;
        right: 20px;
    top: 80%;
        transform: translateY(-50%);
        z-index: 1000;
        background: rgba(0, 0, 0, 0.7);
        padding: 5px;
        color: #f8f9fa;
        font-size: 1em;
        max-width: 200px;
        text-align: center;
        transition: all 0.3s ease;
        opacity: 0;
        visibility: hidden;
    }

    .timeline-container.active {
        opacity: 1;
        visibility: visible;
    }

    .timeline-date {
        margin: 5px 0;
        padding: 5px;
        transition: all 0.3s ease;
        opacity: 0;
        transform: translateY(20px);
    }

    .timeline-date.active {
        opacity: 1;
        transform: translateY(0);
        background-color: rgba(255, 255, 255, 0.2);
    }

    /* Palette styles */
    .palettes-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 25px;
        padding: 20px;
    }

    .palette {
        background: rgba(255, 255, 255, 0.05);
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 15px;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(5px);
    }

    .palette:hover {
        background: rgba(255, 255, 255, 0.08);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .palette-name {
        text-align: center;
        font-size: 1.2em;
        font-weight: 500;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        padding-bottom: 5px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .palette-colors {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        justify-content: center;
        padding: 5;
    }

    .palette-color {
        width: 20px;
        height: 20px;
        border: 2px solid rgba(255, 255, 255, 0.2);
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .palette-color:hover {
        transform: scale(1.2);
        z-index: 1;
        border-color: #ffd700;
    }

    .palette-color::after {
        content: attr(title);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.8em;
        white-space: nowrap;
        opacity: 0;
        transition: opacity 0.2s ease;
        pointer-events: none;
    }

    .palette-color:hover::after {
        opacity: 1;
    }
    details {

  padding: 1em;
    margin-top: 1em;
  color: white;
  transition: all 0.3s ease;
}

details[open] {
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
}

summary {
  font-size: 1.25em;
  font-weight: 600;
  cursor: pointer;
  list-style: none;
  position: relative;
  padding-left: 1.2em;
}

summary::before {
  content: "▶";
  position: absolute;
  left: 0;
  transition: transform 0.3s ease;
}

details[open] summary::before {
  transform: rotate(90deg);
}

.art-page {
    max-width: 960px;
}

#pixelBg {
    position: absolute;
    top: 80px;
    right: 30px;
    width: 400px;
    height: 400px;
    z-index: -10;
}

@media (max-width: 1100px) {
    #pixelBg {
        display: none;
    }
}

        img.lazyloaded {
            opacity: 1;
        }

.palettes-list {
  margin-top: 1em;
}
    </style>
</head>
<body>
                <canvas id="pixelBg" aria-hidden="true"></canvas>

  <div class="art-page">
    <h1 class="light-text"><em class='dark-bg-transparent3'style='padding: 5px;'>Nokori (残り)</em></h1>
    <p class="date light-text"><em>2026</em></p>

    <div class="btn-row">
      <a target="_blank" href="/collections/nokori/" class="view-tokens-btn light-text" onclick="event.preventDefault(); var mode = new URLSearchParams(window.location.search).get('mode') || '0'; window.open('/collections/nokori/?mode=' + mode, '_blank');">
        View Collection →
      </a>
    </div>

    <div class="slideshow" id="slideshow"></div>
    <div class="slideshow-dots" id="slideshowDots"></div>

    <p class="description light-text dark-bg-transparent3" style="line-height: 1.7;">
      <em style="display: block; margin-bottom: 16px; opacity: 0.8;">All artworks are constructed purely with string concatenation. No 3rd party libraries or HTML &lt;canvas&gt; elements are used at any point.</em>
      Nokori is a collection of 401 fully on-chain, EVM-generated artworks rendered with SVG and CSS. Each piece includes two components: an SVG image and an HTML animation, both built entirely in Solidity. The animation includes embedded vanilla JavaScript to dynamically append additional textures to the SVG.
    </p>

    <div class="light-text dark-bg-transparent3">

        <p class="light-text text-left dark-bg-transparent3">
Nokori means remnants, what remains after everything else is gone. I've now spent two years on this project, building it up, scraping it down. Nothing's left but the work itself. I will probably still look back and see things I wish I could change. That's okay. Nokori can also mean regret. Oftentimes I avoid this feeling. What was I doing freshman year of college? I can hardly remember why I was the way I was. It is hard not to feel further and further from myself as the days pass. Is that a form of regret? Maybe? Sometimes I catch myself moving too fast, heart racing, almost manic, scrubbing dishes, showering, walking. It's unhealthy to live on what feels like borrowed time, rushing between states of working, sleeping, relaxing, etc. It's better to move slowly, because at least I am then living on my own terms.<br> <br>

Working on Nokori has helped me navigate the highs and lows of the last few years.
The cracks and threads carry something unspoken. I've tried to give the impression that the pieces were always meant to be worn down as if time itself has left its mark on them.

<br>
<br>
<span style='font-size: 1em'>Rather than narrating the story myself, I want the images to tell it for me.</span>

</p>    </div>

  </div><!-- end .art-page -->

  <div style="padding: 0 30px;">

<details class="light-bg-transparent dark-border-full">
    <summary class="light-text">Implementation Details</summary>
    <br/>
    <div class="row">
        <div class="col-1"></div>
        <div class="col-10 p-0">
            <p class="light-text text-left">
                The Nokori project consists of several smart contracts working together.
                <img src='../images/collections/nokori/TechnicalDiagram.png' style='width:100%;height:auto;'>

            <h3 class="light-text"><span class="contract-name"><a target="_blank" class="contract-link light-text" href="https://etherscan.io/address/0xA8C1fc111d554C291c495a2bE71Ba58edEa208D0#code">Nokori.sol</a></span></h3>
            <p class="light-text">The main contract that handles minting and metadata generation. Integrates with a Manifold creator contract and manages token hashes and caching settings.</p>

            <h3 class="light-text"><span class="contract-name"><a target="_blank" class="contract-link light-text" href="https://etherscan.io/address/0x9042E31F6Eb77C82Fae2d1B22C73Aef2C0db0953#code">NokoriEngine.sol</a></span></h3>
            <p class="light-text">Entry point for art generation that converts animations and SVGs to data URIs. Delegates orchestration to the NokoriOrchestrator.</p>

            <h3 class="light-text"><span class="contract-name"><a target="_blank" class="contract-link light-text" href="https://etherscan.io/address/0x5B7512c42c772a0CD1a46982424DDCcac83e3dD4#code">NokoriOrchestrator.sol</a></span></h3>
            <p class="light-text">Coordinates the art generation pipeline across multiple service contracts.</p>

            <h3 class="light-text"><span class="contract-name"><a target="_blank" class="contract-link light-text" href="https://etherscan.io/address/0xe6bF3b1c65f287B3CEB4E2Df6921a05726DFa1d8#code">ColorEngine.sol</a></span></h3>
            <p class="light-text">Manages color palettes and color-related functionality throughout the system. The color engine currently contains 114 color palettes created during the mint of my collection <em>Popup</em>. These palettes will exist permanently on the Ethereum blockchain and be utilizable by any other contracts.</p>

            <h3 class="light-text"><span class="contract-name"><a target="_blank" class="contract-link light-text" href="https://etherscan.io/address/0x82995e79Cbd97C14Da3d607fB17102c38F8C00A8#code">RandomGenerator.sol</a></span></h3>
            <p class="light-text">Provides deterministic random number generation based on token hashes.</p>

            <h3 class="light-text"><span class="contract-name"><a target="_blank" class="contract-link light-text" href="https://etherscan.io/address/0x82f73c65694096d4a5d96439f850Cd0c37dd674d#code">Utils.sol</a></span></h3>
            <p class="light-text">Provides generic helper functions for string manipulation and formatting.</p>

            <h3 class="light-text"><span class="contract-name"><a target="_blank" class="contract-link light-text" href="https://etherscan.io/address/0xe6bF3b1c65f287B3CEB4E2Df6921a05726DFa1d8#code">ColorUtils.sol</a></span></h3>
            <p class="light-text">Provides helper functions for manipulating colors.</p>

            <h3 class="light-text"><span class="contract-name"><a target="_blank" class="contract-link light-text" href="https://etherscan.io/address/0x82995e79Cbd97C14Da3d607fB17102c38F8C00A8#code">AccessControl.sol</a></span></h3>
            <p class="light-text">Authorization management for contract interactions.</p>

            <h3 class="light-text"><span class="contract-name"><a target="_blank" class="contract-link light-text" href="https://etherscan.io/address/0x8aC08FEFA19EE282D9E60abba2Abb968C47d2E7E#code">Base64.sol</a></span></h3>
            <p class="light-text">Base64 encoding for data URIs.</p>

            <h3 class="light-text">Service Architecture</h3>
            <p class="light-text">The project uses 14 service contracts (NokoriService_1 through NokoriService_15, skipping number 13) to handle different aspects of art generation:</p>

<ul class="light-text">
    <li class="light-text"><span class="contract-name"><a target="_blank" class="contract-link light-text" href="https://etherscan.io/address/0x40ec3eE30046755628c993BBcdF0227E1Ac2b838#code">NokoriService_1</a></span> - Curve generation</li>
    <li class="light-text"><span class="contract-name"><a target="_blank" class="contract-link light-text" href="https://etherscan.io/address/0xc84664535bb1948b01d1e67a386160a493cc6608#code">NokoriService_2</a></span> - JavaScript setup generation</li>
    <li class="light-text"><span class="contract-name"><a target="_blank" class="contract-link light-text" href="https://etherscan.io/address/0xEEFfC31a9F3A92FeF141759Ff48EBAf7a420EAe7#code">NokoriService_3</a></span> - Texture and mask generation</li>
    <li class="light-text"><span class="contract-name"><a target="_blank" class="contract-link light-text" href="https://etherscan.io/address/0x114bAABD8E7614121b8cB272491B26F0e18702dc#code">NokoriService_4</a></span> - Cracks and ellipse mask generation</li>
    <li class="light-text"><span class="contract-name"><a target="_blank" class="contract-link light-text" href="https://etherscan.io/address/0xD98b1A26E77B240a4BF39a2Bda800AEDB82E55D7#code">NokoriService_5</a></span> - Scribble mask generation</li>
    <li class="light-text"><span class="contract-name"><a target="_blank" class="contract-link light-text" href="https://etherscan.io/address/0x7485D95F33a4431931b27Cdd734B6b7e236b4ed6#code">NokoriService_6</a></span> - Displacement mask generation</li>
    <li class="light-text"><span class="contract-name"><a target="_blank" class="contract-link light-text" href="https://etherscan.io/address/0x826e6f95add1ce40740dee23ca4af927bcae84a0#code">NokoriService_7</a></span> - HTML output generation</li>
    <li class="light-text"><span class="contract-name"><a target="_blank" class="contract-link light-text" href="https://etherscan.io/address/0x352Ea4CaA1f2d727B7De4670c5cA3b6D369BED16#code">NokoriService_8</a></span> - Color processing</li>
    <li class="light-text"><span class="contract-name"><a target="_blank" class="contract-link light-text" href="https://etherscan.io/address/0x3E4C51f2AC8B76b22937b7e44FF8435df5be0f91#code">NokoriService_9</a></span> - Core setup and transform generation</li>
    <li class="light-text"><span class="contract-name"><a target="_blank" class="contract-link light-text" href="https://etherscan.io/address/0xf33427bf1e16d40ff7C74F4086B1CFBE54c9BB39#code">NokoriService_10</a></span> - Filters, colors, and attributes generation</li>
    <li class="light-text"><span class="contract-name"><a target="_blank" class="contract-link light-text" href="https://etherscan.io/address/0xAB32E3652681e9aA1Dae48e3E62228aF8FaDe30e#code">NokoriService_11</a></span> - Orchestration and displacement masks</li>
    <li class="light-text"><span class="contract-name"><a target="_blank" class="contract-link light-text" href="https://etherscan.io/address/0x745F5c72F81db4A339D62D660Adee4e204C60871#code">NokoriService_12</a></span> - Curve color adjustment</li>
    <li class="light-text"><span class="contract-name"><a target="_blank" class="contract-link light-text" href="https://etherscan.io/address/0x1E80098EF53E0Bb6C3A79c631AaF97AB26c2d3eA#code">NokoriService_14</a></span> - Clip path setup generation</li>
    <li class="light-text"><span class="contract-name"><a target="_blank" class="contract-link light-text" href="https://etherscan.io/address/0xD757E3F3C2Ddb418d2c016a06997Ae6d906e2456#code">NokoriService_15</a></span> - Ellipse masks and cracks/masks coordination</li>
</ul>



            <p class="light-text"><em>Note: Service 13 is intentionally skipped in the numbering sequence.</em></p>

            <br><br>
            </p>
        </div>
        <div class="col-1"></div>
    </div>
</details>


<!--<details class="light-bg-transparent dark-border-full">-->
<!--  <summary class="light-text">Inspo</summary>-->
<!--  <br/>-->


<!--    <div class="row">-->
<!--            <div class="col-1"></div>-->

<!--    <div class="col-10 p-0">-->
<!--       <p class="light-text text-left">-->
<!--               Some photos I took that inspired this project:-->
<!--           <img src='../images/collections/nokori/inspo1.jpeg' style='width:100%;height:auto;'>-->
<!--           <br>-->
<!--             <img src='../images/collections/nokori/inspo2.jpeg' style='width:100%;height:auto;'>-->

<!--    <br><br>-->
<!--</p>    </div>-->



<!--    <div class="col-1"></div>-->
<!--</div>-->
<!--</details>-->
<div class="row">

    <div class="col-12">
<!-- Color Palettes Section -->
<!--<details class="light-bg-transparent dark-border-full">-->
<!--  <summary class="light-text">Color Palettes (114)</summary>-->
<!--                <div class="palettes-list" id="palettesContainer" style="max-height: 600px; overflow-y: auto;">-->
            <!-- Palettes will be dynamically added here -->
<!--        </div>-->

<!--</details>-->

</div>
</div>
<div class="row">

    <div class="col-12">
    <details open="true" class="light-bg-transparent dark-border-full">
          <summary class="light-text">Timeline</summary><br/>
          <div id='scrollableParent' style="max-height: 1200px; overflow-y: auto;">
   <div class="row">
            <div class="col-1"></div>

    <div class="col-10 p-0">
       <p class="light-text text-left">
Below is a reverse-chronological timeline from February 2024 to now, pairing pieces with their matching GitHub commits when applicable. This is not a 'best of' or anything like that.    </p>
    </div>
                <div class="col-1"></div>
</div>
  <div class="row image-container" id="imageContainer4">

      <!-- Images will be dynamically added here -->
    </div>
<div class="row mt-1">


    <div class="col-12">
        <p class="light-text text-left" style="font-size:1em">
            I started the refactor from Javascript to Solidity here.
        </p>
        <p class="light-text text-left">
            Solidity is a programming language for smart contract development on Ethereum. It is not a front-end language, so you cannot just refresh the browser to view the results. When an NFT's data is requested, a Solidity function is called that returns metadata for the NFT.
            If you do not understand what that means, please read up on the NFT <a href="https://docs.opensea.io/docs/metadata-standards" target="_blank">metadata standards</a>. Instead of using external links in the metadata, I am building an SVG dynamically, <a target="_blank" href="https://en.wikipedia.org/wiki/Base64">encoding</a> it, and returning it directly in the metadata.
            Browsers are able to read the encoded SVG and display it.
            Thank you to my friend Yungwknd who helped me set up a process for testing this effeciently using <a href="https://book.getfoundry.sh/" target="_blank">Foundry</a>.
            <br>
            <br>
            The trickiest thing I have found with using Solidity instead of Javascript is that decimals do not work in Solidity. For example: <br> In Javascript - 3/4 = .75. <br> In Solodity - 3/4 = 0. <br>
            Since the piece heavily requires decimals to function, I had to scale all my calculations up, and then manually convert the integer to a <a href="https://en.wikipedia.org/wiki/String_(computer_science)" target="_blank">string</a> and then append/prepend the decimal point. <br> 300/4 = 75. As a string: "."+75 = ".75". <br>
            Since the end result of the solidity script is that is returns an SVG string, I can just encode the decimal as a string into it.
            This is a simple explanation, in reality, some of these needs to be scaled up by 1000000 to get the level of precision necessary.
        </p>
    </div>
</div>
              <hr class="light-border fade-in" style="width:100%">

<div style="margin-top: 2rem;">
        <div class="row mt-5 image-container" id="imageContainer3">
      <!-- Images will be dynamically added here -->
    </div>
        <div class="row mt-5">
    <div class="col-12">
        <p class="light-text text-left" style="font-size:1em">
            I started over and created a new repository here.
        </p>
    </div>
</div>
              <hr class="light-border fade-in" style="width:100%">

    <div class="row mt-5 image-container" id="imageContainer2">
      <!-- Images will be dynamically added here -->
    </div>
  </div>
    <hr/>
<div id='bottom' class="row light-border-top">

    <div class="col-1"></div>
    <div class="col-11">
        <p class="light-text text-left" style="font-size: 1.5em;">
            A sampling of lost outputs created prior to any github repo.
            The square ones were all created via PHP.
        </p>
    </div>
    <div class="col-1"></div>
</div>

<div style="margin-top: 2rem;">
    <div class="row mt-5 image-container" id="imageContainer">
      <!-- Images will be dynamically added here -->
    </div>
  </div>
  </details>
  </summary>
</div>
</div>

  <script>
    // Hero carousel for Nokori
    (function() {
      var imageUrls = [];
      for (var i = 0; i < 401; i++) {
        imageUrls.push('/images/Nokori_Images/' + i + '.jpg');
      }

      var shuffled = imageUrls.slice().sort(function() { return 0.5 - Math.random(); });
      var slides = shuffled.slice(0, 6);
      var currentSlide = 0;

      var slideshow = document.getElementById('slideshow');
      var dotsContainer = document.getElementById('slideshowDots');
      var dots = [];

      slides.forEach(function(url, i) {
        var img = document.createElement('img');
        img.src = url;
        img.alt = 'Nokori ' + i;
        if (i === 0) img.className = 'active';
        slideshow.appendChild(img);

        var dot = document.createElement('button');
        dot.className = 'slideshow-dot light-text' + (i === 0 ? ' active' : '');
        dot.setAttribute('aria-label', 'Go to image ' + (i + 1));
        dot.addEventListener('click', function() { goToSlide(i); });
        dotsContainer.appendChild(dot);
        dots.push(dot);
      });

      function goToSlide(n) {
        var imgs = slideshow.querySelectorAll('img');
        imgs[currentSlide].classList.remove('active');
        dots[currentSlide].classList.remove('active');
        currentSlide = (n + imgs.length) % imgs.length;
        imgs[currentSlide].classList.add('active');
        dots[currentSlide].classList.add('active');
        resetAutoPlay();
      }

      var autoPlay = setInterval(function() { goToSlide(currentSlide + 1); }, 8000);
      function resetAutoPlay() {
        clearInterval(autoPlay);
        autoPlay = setInterval(function() { goToSlide(currentSlide + 1); }, 8000);
      }

      var touchStartX = 0;
      slideshow.addEventListener('touchstart', function(e) { touchStartX = e.changedTouches[0].screenX; });
      slideshow.addEventListener('touchend', function(e) {
        var diff = e.changedTouches[0].screenX - touchStartX;
        if (diff < -50) goToSlide(currentSlide + 1);
        if (diff > 50) goToSlide(currentSlide - 1);
      });
    })();
  </script>

  <script>

        const imageUrls = [
        "../images/collections/nokori/nokori_timeline/Phantasm/PreGithub/File00003.jpg",

        "../images/collections/nokori/nokori_timeline/Phantasm/PreGithub/File00002.jpg",
                            "../images/collections/nokori/nokori_timeline/Phantasm/PreGithub/File00006.jpg",

        "../images/collections/nokori/nokori_timeline/Phantasm/PreGithub/File00010.png",
        "../images/collections/nokori/nokori_timeline/Phantasm/PreGithub/File00005.jpg",

            "../images/collections/nokori/nokori_timeline/Phantasm/PreGithub/File00009.jpg",
                "../images/collections/nokori/nokori_timeline/Phantasm/PreGithub/File00007.jpg",
                                "../images/collections/nokori/nokori_timeline/Phantasm/PreGithub/File00000.jpg",
                                            "../images/collections/nokori/nokori_timeline/Phantasm/PreGithub/File00004.jpg",


        ];
      const container = $('#imageContainer');

      for (let i = 0; i < imageUrls.length; i++) {
        const imageUrl = `${imageUrls[i]}`;
        let imageHtml = `<div class="col-md-6 col-12 placeholder" style="min-height: 400px">
                             <img data-src="${imageUrl}" class="lazy" alt="Nokori Image ${i}">
                                                 <div class="text-date" style="display:none">Jan 2024</div>

                           </div>`;
                           if(i > 7) {
                               imageHtml = `<div class="col-12 placeholder">
                             <img data-src="${imageUrl}" class="lazy" alt="Nokori Image ${i}">
                           </div>`;
                           }

        container.append(imageHtml);
      }

         const imageUrls4=[

    {
        "imageUrl": "A18.jpg",
        "date": "Jan 2026"
    },
               {
        "imageUrl": "A17.jpg",
        "date": "Jan 2026"
    },
               {
        "imageUrl": "A16.jpg",
        "date": "Jan 2026"
    },
               {
        "imageUrl": "A15.jpg",
        "date": "Jan 2026"
    },
               {
        "imageUrl": "A14.jpg",
        "date": "Jan 2026"
    },
               {
        "imageUrl": "A13.jpg",
        "date": "Jan 2026"
    },
              {
        "imageUrl": "A12.jpg",
        "date": "Jan 2026"
    },
              {
        "imageUrl": "A11.jpg",
        "date": "Jan 2026"
    },
                     {
        "imageUrl": "A10.jpg",
        "date": "Jan 2026"
    },
            {
        "imageUrl": "A9.jpg",
        "date": "Dec 2025"
    },
            {
        "imageUrl": "A8.jpg",
        "date": "Dec 2025"
    },
                 {
        "imageUrl": "A7.jpg",
        "date": "Dec 2025"
    },
        {
        "imageUrl": "A6.jpg",
        "date": "Dec 2025"
    },
                 {
        "imageUrl": "A5.jpg",
        "date": "Dec 2025"
    },
        {
        "imageUrl": "A4.jpg",
        "date": "Dec 2025"
    },
        {
        "imageUrl": "A3.jpg",
        "date": "Dec 2025"
    },
        {
        "imageUrl": "A2.jpg",
        "date": "Dec 2025"
    },
        {
        "imageUrl": "A1.jpg",
        "date": "Dec 2025"
    },
                          {
        "imageUrl": "103.jpg",
        "date": "Nov 2025"
    },
            {
        "imageUrl": "106.jpg",
        "date": "Nov 2025"
    },
               {
        "imageUrl": "107.jpg",
        "date": "Nov 2025"
    },

               {
        "imageUrl": "105.jpg",
        "date": "Nov 2025"
    },
    {
        "imageUrl": "104.jpg",
        "date": "Nov 2025"
    },
               {
        "imageUrl": "109.jpg",
        "date": "Nov 2025"
    },
               {
        "imageUrl": "108.jpg",
        "date": "Nov 2025"
    },
               {
        "imageUrl": "102.jpg",
        "date": "Nov 2025"
    },
               {
        "imageUrl": "101.jpg",
        "date": "Nov 2025"
    },
               {
        "imageUrl": "100.jpg",
        "date": "Nov 2025"
    },
              {
                  "svg":true,
        "imageUrl": "99.jpg",
        "date": "Sun Oct 15, 2025"
    },
              {
                  "svg":true,
        "imageUrl": "98.jpg",
        "date": "Sun Oct 15, 2025"
    },
                     {
        "imageUrl": "97.jpg",
        "date": "Sun Oct 15, 2025"
    },
            {
        "imageUrl": "96.jpg",
        "date": "Sun Oct 15, 2025"
    },
            {
        "imageUrl": "95.jpg",
        "date": "Sun Oct 14, 2025"
    },
                 {
        "imageUrl": "94.jpg",
        "date": "Sun Oct 12, 2025"
    },
        {
        "imageUrl": "93.jpg",
        "date": "Sun Oct 12, 2025"
    },
                 {
        "imageUrl": "92.jpg",
        "date": "Sun Oct 12, 2025"
    },
        {
        "imageUrl": "91.jpg",
        "date": "Sun Oct 12, 2025"
    },
        {
        "imageUrl": "90.jpg",
        "date": "Sun Oct 12, 2025"
    },
        {
        "imageUrl": "89.jpg",
        "date": "Sun Oct 12, 2025"
    },
        {
        "imageUrl": "88.jpg",
        "date": "Sun Oct 12, 2025"
    },
        {
        "imageUrl": "87.jpg",
        "date": "Sun Oct 12, 2025"
    },
        {
        "imageUrl": "86.jpg",
        "date": "Sun Oct 12, 2025"
    },
        {
        "imageUrl": "85.jpg",
        "date": "Sat, Oct 11, 2025"
    },

              {
        "imageUrl": "84.jpg",
        "date": "Sat, Oct 11, 2025"
    },
     {
        "imageUrl": "83.jpeg","date": "Oct 2025"
    },
       {
        "imageUrl": "82.jpeg","date": "Sep 2025"
    }, {
        "imageUrl": "81.jpeg","date": "Oct"
    }, {
        "imageUrl": "80.jpeg","date": "Sep 2025"
    }, {
        "imageUrl": "79.jpeg","date": "Sep 2025"
    },
    {
        "imageUrl": "78.jpg","date": "Sep 2025"
    },{
        "imageUrl": "76.jpg","date": "Sep 2025"
    },
    {
        "imageUrl": "75.jpg","date": "Sep 2025"
    },
    {
        "imageUrl": "74.jpg","date": "Sep 2025"
    },
    {
        "imageUrl": "73.jpg","date": "Sep 2025"
    },
    {
        "imageUrl": "72.jpg","date": "Sep 2025"
    },
    {
        "imageUrl": "71.jpg","date": "Sep 2025"
    },
    {
        "imageUrl": "70.jpg","date": "Sep 2025"
    },
    {
        "imageUrl": "69.jpg","date": "Sep 2025"
    },
    {
        "imageUrl": "68.jpg","date": "Sep 2025"
    },
    {
        "imageUrl": "67.jpg","date": "Sep 2025"
    },
    {
        "imageUrl": "66.jpg","date": "Sep 2025"
    },
    {
        "imageUrl": "65.jpg","date": "Sep 2025"
    },
    {
        "imageUrl": "63.jpg","date": "Sep 2025"
    },
    {
        "imageUrl": "62.jpg",
        "date": "Sep 2025"
    },
    {
        "imageUrl": "61.jpg",
        "date": "Sept 2025"
    },
    {
        "imageUrl": "60.jpg",
        "gitUrl": "https://github.com/andrewm1tchell/Patina/tree/d13307e6631fbe09641e5bd5ae255317f0ef91e1",
        "date": "Fri, Aug 29, 2025, 0:35"
    },
    {
        "imageUrl": "59.jpg",
        "gitUrl": "https://github.com/andrewm1tchell/Patina/tree/b88999e7d6b058c2c36292841bf85818e63aea25"
    },
    {
        "imageUrl": "58.jpg",
        "gitUrl":"https://github.com/andrewm1tchell/Patina/tree/ae1efa66e6ed3509231d291d654604b842cc02b6",
        "date": "Sun, Aug 24, 2025, 23:51"
    },
    {
        "imageUrl": "57.jpg",
        "gitUrl": "https://github.com/andrewm1tchell/Patina/tree/4f97f2c2b621088177855c0fb60682f6e63e3acd",
        "date": "Sun, Aug 24, 2025, 23:41"
    },
    {
        "imageUrl": "56.jpg",
        "gitUrl":"https://github.com/andrewm1tchell/Patina/tree/f93c0bd122397802e872b59efeb3ed4f0dfbd522",
        "date": "Wed, Aug 20, 2025, 0:27"
    },
    {
        "imageUrl": "55.jpg",
        "gitUrl": "https://github.com/andrewm1tchell/Patina/tree/d5f96de76e6410f080d6110c8c3a930ef3cc7982",
        "date": "Mon, Aug 18, 2025, 23:30"
    },
    {
        "imageUrl": "54.jpg",
        "gitUrl": "https://github.com/andrewm1tchell/Patina/tree/094a56a46786df6cfe5fc1485743220a622f4aae",
        "date": "Thu, Jun 26, 2025, 1:03"
    },
    {
        "imageUrl": "53.jpg",
        "gitUrl": "https://github.com/andrewm1tchell/Patina/tree/841616fc22f712f65a987a7812e5756062562b9b",
        "date": "Thu, Jun 26, 2025, 0:13"
    },
    {
        "imageUrl": "51.jpg",                "date":"June 2025"

    },
    {
        "imageUrl": "50.jpg",                "date":"June 2025"

    },
    {
        "imageUrl": "49.jpg",                "date":"June 2025"

    },
    {
        "imageUrl": "48.jpg",                "date":"June 2025"

    },
    {
        "imageUrl": "47.jpg",                "date":"June 2025"

    },
     {
        "imageUrl": "46.jpg",                "date":"June 2025"

    },
    {
        "imageUrl": "45.jpg",                "date":"June 2025"

    },
    {
        "imageUrl": "44.jpg",
                        "date":"June 2025"

    },
    {
        "imageUrl": "43.jpg",
                        "date":"June 2025"

    },
    {
        "imageUrl": "42.jpg",
        "gitUrl": "https://github.com/andrewm1tchell/Patina/tree/da0995875c08e32228645546831c36c5ed2e82cd",
        "date": "Fri, Jun 20, 2025, 0:56"
    },
    {
        "imageUrl": "41.jpg",
                "date":"June 2025"
    },
    {
        "imageUrl": "40.jpg",
                "date":"June 2025"
    },
    {
        "imageUrl": "39.jpg",
                "date":"June 2025"
    },
    {
        "imageUrl": "37.jpg",
                "date":"June 2025"
    },
    {
        "imageUrl": "36.jpg",
                "date":"June 2025"
    },
    {
        "imageUrl": "35.jpg",
                "date":"June 2025"
    },
    {
        "imageUrl": "34.jpg",
        "gitUrl":"https://github.com/andrewm1tchell/Patina/tree/a9878623d305480170cc361843adcbfb06b7d282",
        "date": "Mon, Jun 9, 2025, 0:08"
    },
    {
        "imageUrl": "33.jpg",
                "date":"June 2025"
    },
    {
        "imageUrl": "32.jpg",
                "date":"June 2025"
    },
    {
        "imageUrl": "31.jpg",
                "date":"June 2025"
    },
    {
        "imageUrl": "30.jpg",
                "date":"June 2025"
    },
    {
        "imageUrl": "29.jpg",
        "gitUrl": "https://github.com/andrewm1tchell/Patina/tree/3e3a1469a6751beed9562b9c92ec1f90a2622d7c",
        "date": "Thu, Jun 5, 2025, 17:41"
    },
    {
        "imageUrl": "28.jpg",
        "gitUrl":"https://github.com/andrewm1tchell/Patina/tree/2d957e298edfdcee2ca46e29858088761bb86854",
        "date": "Mon, Jun 2, 2025, 16:36"
    },
    {
        "imageUrl": "27.jpg",

        "gitUrl": "https://github.com/andrewm1tchell/Patina/tree/a8663f8f9053a2b0f00d321af8e1f17e6e6108b0",
        "date": "Fri, May 30, 2025, 17:51"
    },
    {
        "imageUrl": "26.jpg",
        "date":"May 2025"
    },
    {
        "imageUrl": "25.jpg",
        "gitUrl": "https://github.com/andrewm1tchell/Patina/tree/5fd07ad5e62af0e18433806ae5e91a9228e8030d",
        "date": "Fri, May 23, 2025, 0:00"
    },
    {
        "imageUrl": "24.jpg",
        "date": "May 2025"
    },
    {
        "imageUrl": "23.jpg", "gitUrl": "https://github.com/andrewm1tchell/Patina/tree/5b12f40e46d791a58aa2e8004ee0ee8f5fba850a", "date": "Wed, May 7, 2025, 6:39"
    },
    {
        "imageUrl": "22.jpg", "gitUrl":"https://github.com/andrewm1tchell/Patina/tree/37ca3dad4bd95d14f93d60e8ea383f999ba428b0", "date": "Mon, May 5, 2025, 22:49"
    },
    {
        "imageUrl": "21.jpg",
        "date": "May 2025"
    }
       ];
   const imageUrls3=[

{imageUrl:"19.jpg",gitUrl:"https://github.com/andrewm1tchell/Patina/tree/6370b9e56f4bcd097c283fc9f21e3662dff0b4df",date:"Mon, Apr 21, 2025, 0:54"},

{imageUrl:"18.jpg",gitUrl:"https://github.com/andrewm1tchell/Patina/tree/5f253a99c73a5679ce841c2180e0da2553435b51",date:"Mon, Apr 21, 2025, 0:35"},
{imageUrl:"17.jpg",gitUrl:"https://github.com/andrewm1tchell/Patina/tree/cf6df1e87795ba0f5b42127d62ba635958afea0e",date:"Mon, Apr 21, 2025, 0:18"},
{imageUrl:"16.jpg",gitUrl:"https://github.com/andrewm1tchell/Patina/tree/20c2b4cb9cabe9700867c7523873d9155feeab9f",date:"Mon, Apr 21, 2025, 0:17"},
{imageUrl:"15.jpg",gitUrl:"https://github.com/andrewm1tchell/Patina/tree/3ad85d0c341acba050573714ee93e060941c5e19",date:"Sun, Apr 6, 2025, 15:37"},
{imageUrl:"14.jpg",gitUrl:"https://github.com/andrewm1tchell/Patina/tree/05cd41dc952f2c02776b49242c1ca51524b3db7f",date:"Sat, Apr 5, 2025, 15:27"},
{imageUrl:"13.jpg",gitUrl:"https://github.com/andrewm1tchell/Patina/tree/411f9354fbfe666924e0eb8de7bcad94a4bf5306",date:"Sun, Mar 30, 2025, 23:16"},
{imageUrl:"12.jpg",gitUrl:"https://github.com/andrewm1tchell/Patina/tree/6c4711e897a2195c7cf3d4ace742fc7726323e7d",date:"Sun, Mar 30, 2025, 14:52"},
{imageUrl:"11.jpg",gitUrl:"https://github.com/andrewm1tchell/Patina/tree/460c9378abc083c14f0d7506a2346b1aa8567af7",date:"Mon, Mar 24, 2025, 23:33"},
{imageUrl:"10.jpg",gitUrl:"https://github.com/andrewm1tchell/Patina/tree/49dc6b310139ab16dfb7f26a618916b65b579108",date:"Sun, Mar 23, 2025, 15:35"},
{imageUrl:"9.jpg",gitUrl:"https://github.com/andrewm1tchell/Patina/tree/99ad4f1e4666514db41519c524fdcae08fbd1942",date:"Sun, Mar 23, 2025, 0:37"},
{imageUrl:"8.jpg",gitUrl:"https://github.com/andrewm1tchell/Patina/tree/fe6654f2329e5837c0e031c143d93169ed8ed039",date:"Sun, Mar 23, 2025, 0:12"},
{imageUrl:"7.jpg",gitUrl:"https://github.com/andrewm1tchell/Patina/tree/8cffd8fd86616ffefaf9fa804d2d42cfbf2601ea",date:"Thu, Mar 20, 2025, 21:12"},
{imageUrl:"6.jpg",gitUrl:"https://github.com/andrewm1tchell/Patina/tree/2114895b0d07c0bb60902885008cf37d9787473b",date:"Tue, Mar 18, 2025, 23:43"},
{imageUrl:"5.jpg",gitUrl:"https://github.com/andrewm1tchell/Patina/tree/f295c8cd9569beefe3c634cc9cb0f73c25d69e28",date:"Tue, Mar 18, 2025, 0:44"},
{imageUrl:"4.jpg",gitUrl:"https://github.com/andrewm1tchell/Patina/tree/41164bf3723b65d6e0bf8a7b1d9ccb1ccd6cbd5b",date:"Thu, Mar 13, 2025, 21:11"},
{imageUrl:"3.jpg",gitUrl:"https://github.com/andrewm1tchell/Patina/tree/10177941780476f673887e02520563bedf540c2f",date:"Wed, Mar 12, 2025, 23:32"},
{imageUrl:"2.jpg",gitUrl:"https://github.com/andrewm1tchell/Patina/tree/3aaf70ad135f8d7a71e183c4ce3475eb94644e30",date:"Tue, Mar 11, 2025, 22:50"},
{imageUrl:"1.jpg",gitUrl:"https://github.com/andrewm1tchell/Patina/tree/228bb5cf84b9a6cbb3c3dfcefe6754ba97067300",date:"Mon, Mar 10, 2025, 14:40"},
{imageUrl:"0.jpg",gitUrl:"https://github.com/andrewm1tchell/Patina/tree/b31e0ece2b4cd581ac04b231f5aedf7aa2049ed1",date:"Mon, Mar 10, 2025, 14:33"}
       ];

 const imageUrls2=[
      {imageUrl:"225.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/a1570233f8660de4159335585b5e050e11b34193",date:"2025-02-04 22:05:51"},
             {imageUrl:"223.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/25b34760d86dde8bd611252c2fc986bbabc93b19",date:"2025-02-01 15:09:31"},
 {imageUrl:"222.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/b431c4dae09304ed3cddb97ab818e41892b1d56c",date:"2025-01-30 00:56:47"},
             {imageUrl:"221.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/98c8450947ad710e3103a569c3a5078e62dce434",date:"2025-01-30 00:40:47"},

        {imageUrl:"220.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/41087030fa6743982377f9cad97296f9de7fb874",date:"2025-01-30 00:31:53"},
{imageUrl:"219.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/490b5c3eeaef1cf5e3614ad9af4720ec252d04f7",date:"2025-01-30 00:14:52"},
{imageUrl:"218.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/d2dff403b74e7f0c11ba397bc8d04246bcca109d",date:"2025-01-29 23:56:38"},
          {imageUrl:"217.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/88466e45b948e86a1e6fbd1423d762b86312cb48",date:"2025-01-29 09:20:57"},
{imageUrl:"216.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/ebd469797cec3df489e0317d11c348a0be75b972",date:"2025-01-28 01:08:11"},
{imageUrl:"215.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/4f4cd5550054be6eb9557e1e9ac5f98eb9d8a8a4",date:"2025-01-28 01:01:03"},
{imageUrl:"214.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/9aece120a85be7b3a2e4e3d172c3e757c3fcc130",date:"2025-01-28 00:22:44"},
       {imageUrl:"213.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/533a073f3338b046097dbf4a545fe7785bedd836",date:"2025-01-26 23:59:02"},
{imageUrl:"212.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/d8e579d0e82de6e3798cdf64538ab1c36b0ed3da",date:"2025-01-26 13:27:33"},
{imageUrl:"211.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/353947a479f19b4ddc88cf716c310c2575d56e3b",date:"2025-01-25 12:06:15"},
{imageUrl:"210.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/4bf780a0f2dc79ecca7c55bbb57d76dfb7531d36",date:"2025-01-25 00:30:36"},
     {imageUrl:"209.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/db40efc1564799e32f3998a94d2a1a0293a384a0",date:"2025-01-25 00:13:48"},
{imageUrl:"208.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/16a24110fc3248e8d78896ecade5f9c5c74dac1c",date:"2025-01-25 00:11:26"},
{imageUrl:"207.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/9b23acea431ecf3b124b52c4fcabb874fcc3adf9",date:"2025-01-24 23:05:52"},
{imageUrl:"206.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/99b0dbcf6d37e425e5f256cdb11af243a76ce63d",date:"2025-01-24 22:50:58"},
     {imageUrl:"205.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/bd3162bf1cb418ed8da46759a5a32ba745a1b968",date:"2025-01-24 21:56:17"},
{imageUrl:"204.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/368dd92241ae14128ac0d923db2d4a0297ac0385",date:"2025-01-19 23:29:09"},
{imageUrl:"203.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/af10db4443eef2fe2036954f712fa666ceaf346a",date:"2025-01-19 23:25:15"},
{imageUrl:"202.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/b9b349d165ec7742f812bb1ec94e947fcb7b11ab",date:"2025-01-19 19:06:32"},
     {imageUrl:"201.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/bc30f10dfff811738f1387e3c9212661528a979a",date:"2025-01-17 22:58:17"},
{imageUrl:"200.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/6fda13b1e42c095c9fce14395aa0de09b9cdcf01",date:"2025-01-17 22:24:13"},
{imageUrl:"199.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/106bad1951de89523905776ec158c55267a427bf",date:"2025-01-17 12:05:02"},
{imageUrl:"198.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/2a47dfec63be45b4ee40f5e3648ef28a4e2352de",date:"2025-01-16 23:01:49"},
     {imageUrl:"197.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/0ac13d8ee5e728d8224ed08bc41862265e72447f",date:"2025-01-16 22:08:24"},
{imageUrl:"196.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/843459eb0fae6739b95b381fe49d065838b8c02a",date:"2025-01-16 10:19:58"},
{imageUrl:"195.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/de0646258b4b9ffe95620948ad7a5b956ff754f2",date:"2025-01-14 22:33:20"},
{imageUrl:"194.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/947c9f1e0d73997da25edc6bdd08eed6ba281015",date:"2025-01-14 20:29:19"},
     {imageUrl:"193.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/ca4ed465cc2e6b6c6dbe84257c528bafedb72f83",date:"2025-01-14 00:25:03"},
{imageUrl:"192.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/c0af2fcac44ca371d8a6f69458231d4826201ea7",date:"2025-01-13 23:38:32"},
{imageUrl:"191.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/59786a7529a7145d497a1a3a7d7b955ae0a43cae",date:"2025-01-13 10:36:19"},
{imageUrl:"190.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/fc1f0e2d84441b1328c0de3a638b9480f60bdf8b",date:"2025-01-13 10:30:49"},
{imageUrl:"189.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/ab58e055e41e659bddffcf267da45029a6736287",date:"2025-01-12 17:54:39"},
{imageUrl:"188.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/89b3e4d4a6ed34ebf80d2f7d7bc16394bbd9d9ba",date:"2025-01-10 22:45:17"},
{imageUrl:"187.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/c61b6dc73050904f17fc9da3761491557fb04ee1",date:"2025-01-10 22:41:37"},
{imageUrl:"186.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/3de40e439c972bd7f17e5d40c99b79b465a11e6c",date:"2025-01-10 01:29:40"},
{imageUrl:"185_5.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/fba0ed792c565c7fc7e9e6883e7feac78dfc76e8",date:"2025-01-10 01:19:12"},

{imageUrl:"184.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/33f41c264a83c38d2ac35d64b64356e22f69ad06",date:"2024-12-25 23:29:42"},
{imageUrl:"185.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/39c9d4a8576a045d6f5353a8f978ba9a8f2a2d99",date:"2024-12-17 00:05:05"},
{imageUrl:"183.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/698251235fd4bccb1c27982fb6812701c75747ed",date:"2024-12-13 17:47:58"},
{imageUrl:"182.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/c116294e7c10c9e13f47f75920bf01a3de62e84f",date:"2024-12-11 15:09:17"},
{imageUrl:"181.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/40675292356425e45b7ff451c4be4116d7d717b1",date:"2024-12-11 14:29:21"},
{imageUrl:"180.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/c007472be95e13009e2ddb187d744727422ebebb",date:"2024-12-11 01:16:36"},
{imageUrl:"179.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/490fcdaf574c309e2260817d1b1f26f7584f4cf4",date:"2024-12-08 13:31:55"},
{imageUrl:"178.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/ee0641177172a24bdd7e461e0f3a5cc863eefe5a",date:"2024-12-05 00:12:03"},
{imageUrl:"177.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/ca3d24923049a332f208d9f0d95b631b523352ce",date:"2024-12-05 00:02:11"},
{imageUrl:"176_2.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/ca3d24923049a332f208d9f0d95b631b523352ce",date:"2024-11-26 00:39:17"},
 {imageUrl:"176.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/ccec710117a02606226ef00e4ca32e9f9998a457",date:"2024-11-26 00:26:07"},
 {imageUrl:"175.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/77e60a2b6ad3bba67e9f352063973ee91bc917cd",date:"2024-11-23 13:17:57"},
 {imageUrl:"174.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/2ce060db8e4305519138a610b9524d989efa46fa",date:"2024-11-20 23:59:04"},
 {imageUrl:"173.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/5a12cf663c77e4f2776560fb10261cfb88bf6a7e",date:"2024-11-20 00:13:3"},
 {imageUrl:"172.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/24ce99a5d2caca82664eb2233e9e3970bbc854bb",date:"2024-11-19 23:13:34"},
 {imageUrl:"171.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/398f01d951c22da3204d1f719a17d2c0f8fb7968",date:"2024-11-19 222:00:29"},
 {imageUrl:"170.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/32b1418d8232a64eb7599f4ee3a3d3a242d8611b",date:"2024-11-19 01:01:43"},
 {imageUrl:"169.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/b3129581e86d52cd093e7567ed0af7899162d105",date:"2024-11-18 23:51:35"},
 {imageUrl:"168.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/380304d3c40c5a10f41ed98c71325a4995da8404",date:"2024-11-17 23:09:10"},
 {imageUrl:"167.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/0da9e7f2a2ffbd6cc17cb23ef618ba0ef5161e15",date:"2024-11-17 22:31:09"},
 {imageUrl:"166.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/92bbb12d5cb35dc8f6d108ac6db34f55112fbac4",date:"2024-11-17 21:48:24"},
 {imageUrl:"165.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/a371aa25ff7dec141d08bdbbb57cc32eaa61afd3",date:"2024-11-16 01:00:22"},
 {imageUrl:"164.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/3dc908fb33cdf1e65ee4c016be947616d5eda3bc",date:"2024-11-14 21:57:50"},
 {imageUrl:"163.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/6dc0c4b77aca56861e7dcbb5121be6b183198fcf",date:"2024-11-13 23:15:23"},
 {imageUrl:"162.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/5817d566b8d87f44a69239792bc4b9d8d47aecb9",date:"2024-11-12 16:24:27"},
 {imageUrl:"161.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/ec45a7f2866452e23c321d6fb87037a169fd5e23",date:"2024-11-11 23:17:02"},
 {imageUrl:"160.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/6c0fd58905060024f08671ccf7bba5d93f6c8e9c",date:"2024-11-11 00:34:42"},
 {imageUrl:"159.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/6b37cbbe6d96a7164fca00e90ca31118a8a1df64",date:"2024-11-06 00:07:57"},
 {imageUrl:"158.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/4f0324ec21cbdd68c59e431223f8784415ff46b4",date:"2024-11-03 22:34:54"},
 {imageUrl:"157.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/b49c3484c1e9ae18534d99b25239db05f8cc827e",date:"2024-11-03 19:46:42"},
  {imageUrl:"156_2.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/5b2bff60a6db5ab68880f24adb2ec1896225dc5d",date:"2024-10-29 00:38:14"},
 {imageUrl:"156.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/c407b2406ee1b4b12fa613060c5d715cbdfd40cf",date:"2024-10-23 21:20:27"},
 {imageUrl:"155.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/9a62bd67b8789bcfdbbb06585d1df83e84d04f5a",date:"2024-10-22 21:42:10"},{imageUrl:"154.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/64f2f106d952fc99e5dc3575e14195d23a27cb35",date:"2024-10-21 22:35:16"},{imageUrl:"153.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/cb88a7eb06e31688c40449cdfcb827c92ab18413",date:"2024-10-21 22:32:43"},{imageUrl:"152.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/e3193953faa2b2407b0e61090ff45c70506c98af",date:"2024-10-21 19:23:17"},{imageUrl:"151.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/81a38decc186de600df1880a0090850d22fd4f44",date:"2024-10-20 15:06:42"},{imageUrl:"150.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/42c6457b3f2c8fa370095e9fc71dec7699d0dc6f",date:"2024-10-20 14:27:13"},{imageUrl:"149.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/c1600d9b4a72b9efc1226f2a6aacb7adcbf4856c",date:"2024-10-18 21:20:55"},{imageUrl:"148.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/65a5e49f41d5d777f718a8fdd3da91c76df8ac12",date:"2024-10-17 19:18:35"},{imageUrl:"147.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/6a7a102bcfb92980a38b4e6e1f588c9ed6666238",date:"2024-10-15 00:36:57"},{imageUrl:"146.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/64909cd3c76e5d8b01ab4ba6661b79fede598fb9",date:"2024-10-13 23:40:20"},{imageUrl:"145.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/06c598bcd44b2f5a93a28b5ab2be8b307cb17eec",date:"2024-09-28 00:59:48"},{imageUrl:"144.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/6adf7c70de8ff3ccef9a8977f5dad3e3d3e659c9",date:"2024-10-01 00:17:51"},{imageUrl:"143.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/1e2aa0132d4fdcca06924ba10f3362589cd66ea3",date:"2024-10-10 22:29:46"},{imageUrl:"142.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/7341055001dd19ee8185373724bea54adde5141a",date:"2024-10-01 00:17:51"},{imageUrl:"141.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/5f325e600122d80ef862c38259d7cbed9cee39bf",date:"2024-09-28 00:59:48"},{imageUrl:"140.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/365949bb97fa8e33761c04fdefd6a38739c2d587",date:"2024-09-22 21:52:06"},{imageUrl:"139.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/cbf057deab40ef5630495f9494b4d74246ec9d33",date:"2024-09-17 01:04:47"},{imageUrl:"138.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/73725c21c43aa3395d5716d5a1538e2f5f61236c",date:"2024-09-17 00:15:04"},{imageUrl:"137.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/b98ee475505ad0b395da3a1fa2a367fa2a92c75d",date:"2024-09-16 00:10:55"},{imageUrl:"136.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/a54694b5d709c388df11b3789932a5149757aa11",date:"2024-09-13 10:56:33"},{imageUrl:"135.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/7f653a6abfd105add5e60f45502446eca39240ad",date:"2024-09-13 00:55:59"},{imageUrl:"134.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/08ab6c077d59355862ba61c87dd1430b56d57626",date:"2024-09-12 18:05:03"},{imageUrl:"133.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/6c09850a5857b1f4734d9dbbc6459778b1e73294",date:"2024-09-09 11:05:51"},{imageUrl:"132.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/35eb9d88b4253ddd7bb3e9766ec3befd656189c6",date:"2024-09-04 23:09:37"},{imageUrl:"131.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/12c7c6dd1cd2116002ae658597bbf2356bf147d1",date:"2024-09-04 20:03:08"},{imageUrl:"130.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/9da8251f54eefba148f508ba95177fe4f05cf9e4",date:"2024-09-03 21:53:38"},{imageUrl:"129.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/da9e4bc8bc1136a8304b72dec8ac804cead8e879",date:"2024-09-02 18:22:42"},{imageUrl:"128.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/be27595f55e99c143208d5f0685a37ed3033cbea",date:"2024-09-01 13:01:30"},{imageUrl:"127.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/74af3a67f35d5a9769366b4b2c7ca4922e565714",date:"2024-09-01 12:32:19"},{imageUrl:"126.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/dba0bf5e911c9feedb872a9aa0c64235e3bec95d",date:"2024-08-23 22:44:17"},{imageUrl:"0.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/256848fd89481ea10250743e1f92bd1e75a15572",date:"2024-08-21 07:11:12"},{imageUrl:"1.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/41d4606bcdb89e7ebffe6383da3fe10cf76c91a9",date:"2024-08-17 23:45:43"},{imageUrl:"2.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/07f5bc976824b79e688253ee172a605a1e6d5ba1",date:"2024-08-11 18:54:13"},{imageUrl:"3.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/f9b6c6485960a6b5143a13eb1ded1431491b291b",date:"2024-08-11 18:37:40"},{imageUrl:"4.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/77e860177b4cc795112b1c5674f70a04dde8e730",date:"2024-08-11 18:18:27"},{imageUrl:"5.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/daeb62d099baac20bb125173081e9fda14232563",date:"2024-08-11 17:56:02"},{imageUrl:"6.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/9297f1e712aab972d8d2318404fd49e3b703d8fd",date:"2024-08-11 17:26:19"},{imageUrl:"7.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/075482845bf86a6520261f1ac11d93fe58470530",date:"2024-08-11 17:22:19"},{imageUrl:"8.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/f1d35c1c9fded2d403c7c980d47270d70dfc3710",date:"2024-08-11 17:15:09"},{imageUrl:"9.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/a1524f6f492635f240506d648a366c2b627148f8",date:"2024-08-10 16:20:08"},{imageUrl:"10.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/11aacae584a8695b7f1d1f6722ceba6303e811c2",date:"2024-08-10 15:37:44"},{imageUrl:"11.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/45821e65707ee66cf5a35ba0e13100a95aad7653",date:"2024-08-09 13:46:54"},{imageUrl:"12.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/e15d337af10f2e835c4f5c4c92d43d7362234e5e",date:"2024-08-08 21:04:53"},{imageUrl:"13.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/0c43a902cef2d01aabf62ba67d0fcfd3b719412a",date:"2024-08-06 23:21:23"},{imageUrl:"14.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/e44375f5d1ff4bfb4578f940ae6b4c236190e207",date:"2024-08-05 13:57:35"},{imageUrl:"15.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/a712396089a7c1def6aa91eff9d085e45fdc0161",date:"2024-08-04 23:30:38"},{imageUrl:"16.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/5e7d2ca3aec043eb83753fdf852a925a4d405ba4",date:"2024-08-04 23:15:29"},{imageUrl:"17.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/2567fceea5a612274107433e10a4f7f094aa7156",date:"2024-08-03 00:10:40"},{imageUrl:"18.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/0319bcef4a045aab15e2b6422c7ba31ec73f420f",date:"2024-08-02 23:47:41"},{imageUrl:"19.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/f6fb7ccaa519578a585fd0a774ff0e61d354ce68",date:"2024-07-31 23:43:43"},{imageUrl:"20.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/8faeefe9a613afabaf7d98cb4bafa752970f1594",date:"2024-07-31 23:24:33"},{imageUrl:"21.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/ef4971f35e97d58801e4861cdc607f69d4ef8146",date:"2024-07-31 00:15:01"},{imageUrl:"22.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/8b16748dda42e801665fd368450536c0e562d7df",date:"2024-07-30 15:49:45"},{imageUrl:"23.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/b8453aa4ad360bb49c7407bd6cde47eeab9b30e8",date:"2024-07-29 21:21:12"},{imageUrl:"24.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/35da7ee318ab541f51bcadf60462a2f70e441ddd",date:"2024-07-25 00:56:51"},{imageUrl:"25.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/72afb1d1c0c743c143979ccf11636ed486513132",date:"2024-07-22 20:24:16"},{imageUrl:"26.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/b9246fa16e98604025dace0fca42a12886bfb7dd",date:"2024-07-20 00:59:35"},{imageUrl:"27.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/8efc9da65e9fe971eb4bbc0678ffd09a72d4e9ce",date:"2024-07-19 00:07:11"},{imageUrl:"28.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/7752752c919d9f7e0d7e29c37f338d659ac217a7",date:"2024-07-18 00:44:36"},{imageUrl:"29.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/88145930a4944e8d4457c8f932590181ca4a470f",date:"2024-07-17 23:37:46"},{imageUrl:"30.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/da0635977dee2c6cfe2836e124c73a102b68c531",date:"2024-07-17 22:08:25"},{imageUrl:"31.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/163caf7683ca99d862f3b409f7ebb15503c611fa",date:"2024-07-17 01:09:33"},{imageUrl:"32.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/571ef03040abc7e4180cd9d95047d96afa0af145",date:"2024-07-17 00:04:34"},{imageUrl:"33.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/e3fb0e0c0ee8c206f2ff3528a5dc270fa0742227",date:"2024-07-13 15:49:07"},{imageUrl:"34.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/f91a44475fafd1a57346f17b87538c952bb3eb3e",date:"2024-07-13 15:24:10"},{imageUrl:"35.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/ebf244423b77c5211f5daaf29340d6daed5c42ac",date:"2024-07-10 01:14:16"},{imageUrl:"36.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/9b556061b3ad0d3f01856f79b7f8ce9517edc8a2",date:"2024-07-10 01:09:09"},{imageUrl:"37.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/d055c533ca53d2c80d787e393daff3f8d2727076",date:"2024-07-09 23:19:16"},{imageUrl:"38.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/464ad2a163ede59d1e110f4f8ea88c84792ffe70",date:"2024-07-09 16:26:00"},{imageUrl:"39.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/6ac5855283b8ccbf6ef5da6bf00683d464112cc2",date:"2024-07-07 22:27:33"},{imageUrl:"40.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/0e0ada2c030a625891a897bfcd882bbbe793ebaf",date:"2024-07-06 17:40:28"},{imageUrl:"41.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/d5e5be249c3449b8b122556185000e52bdd31396",date:"2024-07-05 17:08:49"},{imageUrl:"42.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/b74fe18d4bcc0fef101e4fba5952465b52ff5892",date:"2024-07-04 14:51:21"},{imageUrl:"43.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/fbfcea076a7bd2f6f1084f061984453dc6e7f646",date:"2024-06-25 23:32:19"},{imageUrl:"44.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/f5ea86b5b5bdfd2ac8d34c8bc42b84358021fc56",date:"2024-06-12 01:00:13"},{imageUrl:"45.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/f9e431395153a6538aa1acca0d93ba7cdc228b60",date:"2024-06-12 00:57:54"},{imageUrl:"46.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/a86406a471bb3b391b9a9a2b648fa1324c3d3e17",date:"2024-06-12 00:33:07"},{imageUrl:"47.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/8fcd8d5f30275d7accf6ede7b7dcdf0a9b401760",date:"2024-06-11 13:50:14"},{imageUrl:"48.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/db8f680240edccaf59ea4c475a2e04a5615689bd",date:"2024-06-10 22:13:33"},{imageUrl:"49.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/4edbbac982ba4c89caceded592d383b1b60c8ef4",date:"2024-06-09 11:42:29"},{imageUrl:"50.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/8a8158937193b44948f881ac66356d807e3f9aac",date:"2024-06-08 16:46:56"},{imageUrl:"51.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/0f1d8c164846397091c51d2e6aab3be542456303",date:"2024-06-07 20:17:56"},{imageUrl:"52.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/2b41442c8be26077bed051f04fd9b9a6f4462980",date:"2024-06-06 09:27:12"},{imageUrl:"53.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/cac05b760954a68f58f86fdf3438e00a00fa6367",date:"2024-06-04 21:17:53"},{imageUrl:"54.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/fe6b1027e4501d624c3103d6075a881200ad98f6",date:"2024-06-03 23:23:51"},{imageUrl:"55.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/b1e9f128e99aca109d627f4ba973f36dc16badbd",date:"2024-06-03 21:25:01"},{imageUrl:"56.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/e383c6821659c5c89c977ee88babef4af61745dd",date:"2024-05-31 00:56:45"},{imageUrl:"57.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/3f894212a762a209854a14aaf7b57031d853faba",date:"2024-05-30 22:42:28"},{imageUrl:"58.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/807ed5c61704ce1ffb86518fa8d344e6f53f6dc5",date:"2024-05-28 00:32:01"},{imageUrl:"59.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/2a4056806074e3706332c2c1e915dc712ad14f0f",date:"2024-05-27 23:30:34"},{imageUrl:"60.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/e611b5b0aa8ae379ee247e5dba51b936eeba237c",date:"2024-05-27 22:48:51"},{imageUrl:"61.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/c4899dca837e944590003b9e6cd35559fa6bf7f6",date:"2024-05-24 17:30:28"},{imageUrl:"62.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/85e18577aa6e88e84a0a3dabf61da6824d8e73fa",date:"2024-05-23 01:34:46"},{imageUrl:"63.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/988cacb879209850b37e0eace2d34af422b5d3a8",date:"2024-05-23 00:46:28"},{imageUrl:"64.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/12d5215066f1db3eedee3564fe9dacfcec682c09",date:"2024-05-21 23:31:01"},{imageUrl:"65.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/515754d338e8ec25b3117fb7c22d564edf822aa7",date:"2024-05-18 16:00:14"},{imageUrl:"66.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/57cd85795041f6543c90a75fac0a43a32f79551c",date:"2024-05-18 15:55:03"},{imageUrl:"67.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/038631b7b1472408b7faf9b05592bda558aa69e4",date:"2024-05-18 15:12:32"},{imageUrl:"68.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/0d6d85575191d4bfbccfe034549709fda6882a0b",date:"2024-05-17 15:45:34"},{imageUrl:"69.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/7c70f7a41ec65dfdac82eacab905fb1c8d4d4042",date:"2024-05-16 15:10:31"},{imageUrl:"70.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/6b7dc0e80603786b3af7ba50064e39bea7329e4d",date:"2024-05-16 00:37:50"},{imageUrl:"71.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/30d26f0a1688f529185af0dd8101bd3271ed11e7",date:"2024-05-14 12:21:22"},{imageUrl:"72.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/80edc0c76c8c9c0bd033b4018fdd63d617d9c711",date:"2024-05-11 15:22:31"},{imageUrl:"73.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/065d46d240657d9d44ef9c3c8727f20b34fa5beb",date:"2024-05-11 00:12:11"},{imageUrl:"74.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/419b7085cbf63d9f772ee7baadbdaee4d36eb6d7",date:"2024-05-09 13:23:24"},{imageUrl:"75.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/d68e627ccbaa6979feb7f7268fc8e361955ee5c5",date:"2024-05-06 00:27:45"},{imageUrl:"76.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/ba25347804ac3cdbbd06d4cacca196d4771a462a",date:"2024-05-04 17:52:19"},{imageUrl:"77.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/9caeeeb611324b9e0f3ad53d7a6decf25499dbe2",date:"2024-05-04 15:28:40"},{imageUrl:"78.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/2696e70a3d5e2699e87379f2616f60614a648d48",date:"2024-05-04 12:44:04"},{imageUrl:"79.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/27f5504b4406d6634c666c53d3dc9426e62f92a6",date:"2024-05-04 00:04:35"},{imageUrl:"80.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/44cfe7037f502371ee170ad07316f54ce035466c",date:"2024-05-01 00:07:32"},{imageUrl:"81.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/b3bab5cbbf44a2bd5ce4aa82b1a8aaba5ae1e1aa",date:"2024-04-28 15:09:29"},{imageUrl:"82.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/c4528498afb7f23e666169e566d007cdf17728ee",date:"2024-04-28 14:38:53"},{imageUrl:"83.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/6c0eed4114fb81a17d4c18d9554d4091f32be64f",date:"2024-04-27 01:10:02"},{imageUrl:"84.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/d737c0da29f643fef983167a43a65c451597578b",date:"2024-04-25 22:59:23"},{imageUrl:"85.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/866bdc5da7d033017a194a81a37a31e508f86435",date:"2024-04-25 15:48:17"},{imageUrl:"86.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/567e86ed0584f0a88656e562e783a7455bdb453b",date:"2024-04-24 22:23:29"},{imageUrl:"87.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/da3364c8d0b10d45c8e42bc1134305445643cae1",date:"2024-04-22 23:54:21"},{imageUrl:"88.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/fc7332e482e7a9ae805729237067b74534f24f75",date:"2024-04-22 23:35:19"},{imageUrl:"89.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/a4f8d633f7d6145642f353786913a0ce1250856a",date:"2024-04-21 14:56:22"},{imageUrl:"90.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/9030f6913c017f1646733c6e08ffa88057e2b21e",date:"2024-04-21 14:56:07"},{imageUrl:"91.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/e798afc44946d9dd91371218fae00a761dadf051",date:"2024-04-21 14:18:09"},{imageUrl:"92.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/c3bf6eedae5a6ebe31108daa4d9794228279fdcd",date:"2024-04-21 13:37:04"},{imageUrl:"93.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/9cba567f8748b9ad82f8f35d3142786ce5b15a17",date:"2024-04-14 00:22:36"},{imageUrl:"94.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/8e7d37142e0643db40cb37a858287596b2f1cb61",date:"2024-04-13 14:47:11"},{imageUrl:"95.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/2c872ab56ea87cc5ad80dc80b1732b9dd0677e09",date:"2024-04-13 00:14:06"},{imageUrl:"96.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/01374580da08bfc5e121cf64995ac3429780d5e0",date:"2024-04-12 22:35:09"},{imageUrl:"97.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/53dc844b2a96823419ba085cb71c7573e618dd12",date:"2024-04-12 22:26:10"},{imageUrl:"98.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/1516fbbe4883caa60f867277782b31b293476534",date:"2024-04-08 22:27:00"},{imageUrl:"99.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/7c94a71dcb6b0f093152de323caeee7adca65546",date:"2024-04-08 21:02:40"},{imageUrl:"100.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/e653f110fdcaa58aa72a0b73483cbe14784b5e36",date:"2024-04-08 15:48:57"},{imageUrl:"101.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/e83c6f010df61202b453b13cacf837f765a290a2",date:"2024-04-07 15:48:32"},{imageUrl:"102.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/38424bb6fc866ef6cea9a50a34d7c258dbcc5e81",date:"2024-04-06 16:06:28"},{imageUrl:"103.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/fc64282aa31db2defc4a2eb5332ebb40a648036f",date:"2024-04-06 15:17:54"},{imageUrl:"104.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/5168727eae78c554ee16bc54bdd01d9cc59849aa",date:"2024-04-01 20:40:42"},{imageUrl:"105.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/c9557475192f50427d397ec6bbea6af62252c982",date:"2024-03-30 13:39:51"},{imageUrl:"106.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/3ad78866286e1418aa2dec0920bc11f0f80923bc",date:"2024-03-21 22:02:12"},{imageUrl:"107.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/3284d2e7efe7376dcfd8e3fec946444c8d154423",date:"2024-03-17 06:03:36"},{imageUrl:"108.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/dea7a66cdc32f1ef3b0f94569a73e1656c097556",date:"2024-03-16 00:39:07"},{imageUrl:"109.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/1a36c9233e5941097d17806474abb6fffed79e52",date:"2024-03-09 19:00:15"},{imageUrl:"110.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/2d6f03385796726811371a0b2a112ab883f292ca",date:"2024-03-08 21:14:32"},{imageUrl:"111.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/ff13ef8737a21330344708c4cc52d45bd7f10993",date:"2024-03-08 11:50:37"},{imageUrl:"112.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/53bb47a7f08b3fec3cb02947b088aa69f2c1b6c4",date:"2024-03-08 11:35:29"},{imageUrl:"113.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/e740d7a9b1e0b313a717d037e0a8624fd69a1af7",date:"2024-03-06 01:09:02"},{imageUrl:"114.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/616fb5446e3c660406ad76131702cc4341eb2284",date:"2024-03-06 00:59:22"},{imageUrl:"115.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/8c7161bbd9e8edec0589d6df9cd2aa7624ff73d4",date:"2024-02-29 21:22:47"},{imageUrl:"116.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/869ecaf9097cca485b81ec7cba3d53cbf70a0d3c",date:"2024-02-29 20:26:55"},{imageUrl:"117.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/d4590a529035c7995be7fad6c7edb3d35b5a9868",date:"2024-02-29 20:07:54"},{imageUrl:"118.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/a10aaaf42466e8a39c3a2844e78ed98c61dc5b62",date:"2024-02-29 19:57:24"},{imageUrl:"119.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/1b39ee84c1138e803c073cc64e5a375d207fefa8",date:"2024-02-29 17:44:57"},{imageUrl:"120.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/ce3bab7a77f5e47c299b8cb0a8cbd7f50abe01c7",date:"2024-02-28 23:31:44"},{imageUrl:"121.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/ebec5f4e641418b7a3f479e3872fe55cc495502f",date:"2024-02-27 23:21:46"},{imageUrl:"122.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/e085ec53d6c0a1c95c5042b12b5ab746e348f87b",date:"2024-02-27 01:29:02"},{imageUrl:"123.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/ce085fedb648f57ce8f5c5c6a6b29b8f171d1c8a",date:"2024-02-27 01:01:50"},{imageUrl:"124.jpg",gitUrl:"https://github.com/andrewm1tchell/Phantasm/tree/adb7f3bd60dc9e99078cb1cd22ea8f8a4e8aabc3",date:"2024-02-25 00:14:38"}];
const container2 = $('#imageContainer2');
const container3 = $('#imageContainer3');
const container4 = $('#imageContainer4');

const navbar = document.querySelector('.navbar');
const navbarHeight = navbar.offsetHeight;

// Slideout panel markup
let slideoutPanel = `
<div id="slideout-panel" class="offcanvas-custom light-text dark-bg">
    <div class="offcanvas-body">
        <pre id="slideout-content" class="wrapped-svg-markup dark-bg light-text"></pre>
    </div>
</div>
`;

$('body').append(slideoutPanel); // Append the slideout panel to the body

    function setSlideoutWidth() {
        const slideoutPanel = document.getElementById('slideout-panel');
        const screenWidth = window.innerWidth;

        // Set the maximum width based on screen width (e.g., 90% of the viewport width)
        slideoutPanel.style.maxWidth = `${screenWidth * 0.9}px`; // Adjust as needed (e.g., 90% of viewport)
    }

    // Set width on page load
    setSlideoutWidth();

    // Update width on window resize
    window.addEventListener('resize', setSlideoutWidth);
for (let i = 0; i < imageUrls2.length; i++) {
    let { imageUrl, gitUrl, date } = imageUrls2[i];
    let fileNumber = imageUrl.slice(0,-4).padStart(5, '0'); // Pads to 5 digits, e.g., 00001, 00002, etc.
    let fileName = `File ${fileNumber}.svg`;

    let imageHtml = `
        <div class="col-12 col-md-4 mb-4 placeholder"> <!-- Use col-12 for mobile and col-4 for larger screens -->
            <img data-src="../images/collections/nokori/nokori_timeline/Phantasm/Compress/${imageUrl}" class="lazy cropped-image" alt="Nokori Image ${i+1}">
            <div class="dark-border-full w-100">
                <div style="width: 100%; text-align: center;">
                    <div class="text-date light-text">${date}</div>
                    <!-- Commit link with onclick action -->
                    <a href="#" onclick="window.open('${gitUrl}', '_blank'); return false;" class="text-primary text-decoration-none mt-2">View Commit</a>
                </div>
                <div style="width: 100%; text-align: center;">
                    <!-- Link to view raw SVG markup -->
                    <a href="#" class="view-raw-svg mt-2" data-file="../images/collections/nokori/nokori_timeline/Phantasm/SVGs/${fileName}">View SVG Markup</a>
                </div>
            </div>
        </div>
    `;

    container2.append(imageHtml);
}
for (let i = 0; i < imageUrls4.length; i++) {
    let { imageUrl, gitUrl, date, svg } = imageUrls4[i];
    let fileNumber = imageUrl.slice(0,-4);
    let fileName = `${fileNumber}.svg`;

    // Build conditional link sections
    let gitLinkHtml = gitUrl ? `
        <a href="#" onclick="window.open('${gitUrl}', '_blank'); return false;" class="text-primary text-decoration-none mt-2">View Commit</a>
    ` : '';
    svg = !!svg;
    let svgLinkHtml = svg ? `
        <a href="#" class="view-raw-svg mt-2" data-file="../images/collections/nokori/nokori_timeline/BMTN/SVG/${fileName}">View SVG Markup</a>
    ` : '';

    let imageHtml = `
        <div class="col-12 col-md-4 mb-4 placeholder">
            <img data-src="../images/collections/nokori/nokori_timeline/BMTN/${imageUrl}" class="lazy cropped-image" alt="Nokori Image ${i+1}">
            <div class="dark-border-full w-100">
                <div style="width: 100%; text-align: center;">
                    <div class="text-date light-text">${date}</div>
                    ${gitLinkHtml}
                    ${svgLinkHtml}
                </div>
            </div>
        </div>
    `;
    container4.append(imageHtml);
}
for (let i = 0; i < imageUrls3.length; i++) {
    let { imageUrl, gitUrl, date } = imageUrls3[i];
    let fileNumber = imageUrl.slice(0,-4);
    let fileName = `${fileNumber}.svg`;

    let imageHtml = `
        <div class="col-12 col-md-4 mb-4 placeholder"> <!-- Use col-12 for mobile and col-4 for larger screens -->
            <img data-src="../images/collections/nokori/nokori_timeline/Patina/${imageUrl}" class="lazy cropped-image" alt="Nokori Image ${i+1}">
            <div class="dark-border-full w-100">
                <div style="width: 100%; text-align: center;">
                    <div class="text-date light-text">${date}</div>
                    <!-- Commit link with onclick action -->
                    <a href="#" onclick="window.open('${gitUrl}', '_blank'); return false;" class="text-primary text-decoration-none mt-2">View Commit</a>
                </div>
                <div style="width: 100%; text-align: center;">
                    <!-- Link to view raw SVG markup -->
                    <a href="#" class="view-raw-svg mt-2" data-file="../images/collections/nokori/nokori_timeline/Patina/SVGs/${fileName}">View SVG Markup</a>
                </div>
            </div>
        </div>
    `;

    container3.append(imageHtml);
}

// JavaScript to fetch and display the raw SVG markup in the slideout panel
document.querySelectorAll('.view-raw-svg').forEach(anchor => {
    anchor.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default anchor behavior
        const filePath = this.getAttribute('data-file');
        const slideoutContent = document.getElementById('slideout-content');

        // Fetch the raw SVG file content
        fetch(filePath)
            .then(response => response.text())
            .then(svgMarkup => {
                slideoutContent.textContent = svgMarkup; // Display the raw SVG content
                document.getElementById('slideout-panel').classList.add('active'); // Show the slideout panel
            })
            .catch(error => console.error('Error fetching the SVG file:', error));
    });
});


// JavaScript to fetch and display the raw SVG markup in the slideout panel
document.querySelectorAll('.view-raw-svg').forEach(anchor => {
    anchor.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default anchor behavior
        const filePath = this.getAttribute('data-file');
        const slideoutContent = document.getElementById('slideout-content');
        const slideoutPanel = document.getElementById('slideout-panel');

        // Show the slideout panel and display loading text
        slideoutContent.textContent = 'Loading...'; // Set loading text
        slideoutPanel.classList.add('active'); // Make the slideout panel visible

        // Fetch the raw SVG file content
        fetch(filePath)
            .then(response => response.text())
            .then(svgMarkup => {
                slideoutContent.textContent = svgMarkup; // Display the raw SVG content
            })
            .catch(error => {
                console.error('Error fetching the SVG file:', error);
                slideoutContent.textContent = 'Error loading SVG file. Please try again.';
            });
    });
});

// Function to hide the slideout panel
function hideSlideoutPanel() {
    document.getElementById('slideout-panel').classList.remove('active');
}

// Close the panel when clicking outside of it
document.addEventListener('click', function(event) {
    const slideoutPanel = document.getElementById('slideout-panel');
    if (!slideoutPanel.contains(event.target) && !event.target.classList.contains('view-raw-svg')) {
        hideSlideoutPanel();
    }
});

// Double-tap detection (for mobile)
let lastTap = 0;
document.addEventListener('touchend', function(event) {
    const currentTime = new Date().getTime();
    const tapLength = currentTime - lastTap;
    if (tapLength < 300 && tapLength > 0) {
        hideSlideoutPanel();
    }
    lastTap = currentTime;
});

// Swipe detection for mobile devices
let touchstartX = 0;
let touchendX = 0;

function checkSwipe() {
    if (Math.abs(touchendX - touchstartX) > 150) {
        hideSlideoutPanel(); // Detect left swipe (close slideout)
    }
}

document.addEventListener('touchstart', function(event) {
    touchstartX = event.changedTouches[0].screenX;
});

document.addEventListener('touchend', function(event) {
    touchendX = event.changedTouches[0].screenX;
    checkSwipe();
});
function initializeTimeline() {
    const timelineContainer = document.createElement('div');
    timelineContainer.className = 'timeline-container';
    document.body.appendChild(timelineContainer);

    // Create a single date element that will show the active date
    const dateElement = document.createElement('div');
    dateElement.className = 'timeline-date';
    timelineContainer.appendChild(dateElement);

    // Create chevron container
    const chevronContainer = document.createElement('div');
    chevronContainer.className = 'timeline-chevrons';
    chevronContainer.style.cssText = `
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-top: 12px;
    `;
    timelineContainer.appendChild(chevronContainer);

    // Create chevron up button
    const chevronUpBtn = document.createElement('button');
    chevronUpBtn.className = 'timeline-chevron timeline-chevron-up';
    chevronUpBtn.innerHTML = 'Top';
    chevronUpBtn.title = 'Jump to top';
    chevronUpBtn.style.cssText = `
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: rgba(255, 255, 255, 0.7);
        padding: 8px 12px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.2s ease;
        font-weight: 500;
    `;
    chevronContainer.appendChild(chevronUpBtn);

    // Create chevron down button
    const chevronDownBtn = document.createElement('button');
    chevronDownBtn.className = 'timeline-chevron timeline-chevron-down';
    chevronDownBtn.innerHTML = 'Bottom';
    chevronDownBtn.title = 'Jump to bottom';
    chevronDownBtn.style.cssText = `
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: rgba(255, 255, 255, 0.7);
        padding: 8px 12px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.2s ease;
        font-weight: 500;
    `;
    chevronContainer.appendChild(chevronDownBtn);

    // Add hover effects
    [chevronUpBtn, chevronDownBtn].forEach(btn => {
        btn.addEventListener('mouseenter', () => {
            btn.style.background = 'rgba(255, 255, 255, 0.2)';
            btn.style.borderColor = 'rgba(255, 255, 255, 0.5)';
            btn.style.color = 'rgba(255, 255, 255, 1)';
        });
        btn.addEventListener('mouseleave', () => {
            btn.style.background = 'rgba(255, 255, 255, 0.1)';
            btn.style.borderColor = 'rgba(255, 255, 255, 0.3)';
            btn.style.color = 'rgba(255, 255, 255, 0.7)';
        });
    });

    // Add click handler for chevron up
    chevronUpBtn.addEventListener('click', () => {
        scrollParent.scrollTop = 0;
    });

    // Add click handler for chevron down
    chevronDownBtn.addEventListener('click', () => {
        const bottomElement = document.getElementById('bottom');
        if (bottomElement) {
            scrollParent.scrollTop = bottomElement.offsetTop;
        }
    });

    // Get the parent scrollable container
    const scrollParent = document.getElementById('scrollableParent');
    if (!scrollParent) {
        console.warn('Scrollable parent container not found');
        return;
    }

    // Get all image containers
    const containers = [
        document.getElementById('imageContainer'),
        document.getElementById('imageContainer2'),
        document.getElementById('imageContainer3'),
        document.getElementById('imageContainer4'),
    ].filter(container => container !== null);

    // Function to check if scrollable parent is visible in viewport
    const isParentVisible = () => {
        const rect = scrollParent.getBoundingClientRect();
        return rect.top < window.innerHeight && rect.bottom > 0;
    };

    // Function to check which date is active
    const updateActiveDate = () => {
        // Don't update if parent isn't visible
        if (!isParentVisible()) {
            dateElement.classList.remove('active');
            timelineContainer.classList.remove('active');
            return;
        }

        const scrollPosition = scrollParent.scrollTop;
        const viewportHeight = scrollParent.clientHeight;
        let activeDate = null;

        containers.forEach(container => {
            const images = container.querySelectorAll('.placeholder');
            images.forEach(img => {
                const dateElement = img.querySelector('.text-date');
                if (!dateElement) return;

                // Get position relative to the scrollable parent
                const imgTop = img.offsetTop;
                const imgHeight = img.offsetHeight;

                if (scrollPosition >= imgTop - viewportHeight / 2 &&
                    scrollPosition < imgTop + imgHeight - viewportHeight / 2) {
                    const dateText = dateElement.textContent;
                    if (!dateText) return;

                    try {
                        const date = new Date(dateText);
                        if (isNaN(date.getTime())) return;

                        activeDate = `${date.toLocaleString('default', { month: 'long' })} ${date.getFullYear()}`;
                    } catch (e) {
                        console.warn('Invalid date format:', dateText);
                    }
                }
            });
        });

        // Update the timeline date element
        if (activeDate) {
            dateElement.textContent = activeDate;
            dateElement.classList.add('active');
            timelineContainer.classList.add('active');
        } else {
            dateElement.classList.remove('active');
            timelineContainer.classList.remove('active');
        }
    };

    // Add scroll event listener to the scrollable parent
    scrollParent.addEventListener('scroll', updateActiveDate);

    // Also listen to window scroll to check parent visibility
    window.addEventListener('scroll', updateActiveDate);

    // Initial update (now with visibility check)
    updateActiveDate();
}
document.addEventListener('DOMContentLoaded', function() {
    // Initialize timeline
    initializeTimeline();

    // Color Palettes
    let colorPalettes = [["Lion","#8e0d00","#7a0a00","#a30e00","#660900","#9da332","#979c30","#b5bb3a","#cbbd52","#c2b33a","#ab5f4e","#a15b4a","#566846","#73a7a9","#b7976b","#e1d9c2"],
["Elephant","#c8c699","#c4c292","#cbc895","#2c6d41","#2b693f","#2b6e40","#5fa595","#60a393","#8e3f1a","#8a3d19","#c22d3b","#9fb46d","#2a1616","#c08047"],
["Whale","#06142c","#071631","#06142d","#051229","#e2d2ac","#e3d4b1","#e3d5b5","#a6b15d","#a4af5a","#568047","#547e45","#e8ae77","#a77d4d","#b1443d","#276687"],
["Dolphin","#c7226c","#cd236f","#c7236d","#c5206a","#bbad26","#beaf27","#b9ab27","#457a11","#477e11","#2f5177","#31547c","#c24197","#d496be","#619ba7","#babc9f"],
["Tiger","#740000","#7a0000","#700101","#750101","#5d998a","#5f9b8c","#b68d07","#ba9007","#b58d08","#5c998a","#d9cfa9","#d9cfa6","#3e722a","#99792c"],
["Bear","#877b5d","#84795c","#897c5d","#e3c56a","#e2c265","#e3c66d","#c4baa6","#c9bfac","#262e12","#242c11","#6d8153","#814f06","#640613","#4e8093"],
["Wolf","#e8d2a9","#ead3a9","#ead5ae","#e7cfa2","#e8d1a6","#e8d3ab","#b6201e","#b3211e","#3f799f","#40779c","#a49228","#a08e27","#5e6d33","#596831"],
["Fox","#12151d","#101219","#0e1016","#ceb31b","#cbb11a","#c7ad1a","#7f0b25","#750a21","#be7113","#b46c13","#397748","#cb4b46","#408175","#d7d98b"],
["Rabbit","#c4bf95","#c8c49d","#ccc8a4","#5a780d","#526e0c","#56740b","#799341","#7e9a42","#a4885c","#a68c64","#adb279","#acaf83","#c8c148","#bc8f2d"],
["Squirrel","#d32587","#dd4099","#d02586","#da2f90","#e6c22b","#eac948","#6c7e27","#798c2b","#e6d274","#f5f5f5","#ab5d14"],
["Bat","#c5cab9","#cacfbf","#c0c6b3","#c6cdb7","#820030","#7a002d","#5b8a3c","#57833a","#c29f00","#4e1b1f","#2d4c30","#85b285"],
["Giraffe","#171b19","#262c29","#131614","#232926","#a91402","#a21101","#ca1602","#d09514","#cc9214","#e9a920","#3a621f","#7ba17d","#e6e1a4"],
["Zebra","#bc2c0e","#b2260a","#ad361f","#264e66","#2a5b79","#1d3e53","#f0e0b3","#c9a266","#c1934e","#cda770","#71831c","#7c8f1e","#f0e0b3","#f3e8c8"],
["Hippopotamus","#790213","#690211","#740617","#740213","#b18d36","#ac8835","#a48232","#dcd9b6","#d6d2a9","#dbd8b8","#342334","#3f0417","#87cdbe","#c0407b"],
["Rhinoceros","#132e2b","#0f2422","#173632","#c0b11d","#b6a61b","#27703d","#256a3a","#0e5687","#105f94","#c52c11","#b22810","#d98473","#a48232","#6aa81e","#7ecb99"],
["Chimpanzee","#952832","#81222c","#97212d","#909d55","#92a14f","#828f4d","#fffaf7","#ffffff","#b7975d","#bda06b","#609251","#786c78","#e68db8","#9acad9"],
["Gorilla","#eb6521","#ed763b","#e06324","#c74618","#bf4418","#cf400c","#a56a32","#a46932","#d7c314","#decb1b","#111d6f","#a6bcc1","#860f21","#2b3706"],
["Kangaroo","#e3d6c7","#eee6dd","#e0d3c2","#eadfd1","#c0022d","#b6022c","#ca0231","#721543","#5a1136","#7da29d","#85a8a3","#1d4260","#1b3e5a","#eb85c7","#854c8c"],
["Koala","#f7ebe3","#f9f1eb","#f7e8df","#f8ebe3","#010305","#040d15","#071d53","#061846","#240d12","#1a090d","#f7ebe3","#010305","#071d53","#240d12","#e3ac35","#e5b243","#6a2227","#b55e40","#384a34","#b5a01c"],
["Sloth","#000326","#000433","#05001f","#d0a622","#c79e23","#a50008","#aa030c","#cce3d9","#d4e7df","#63849f","#718fa8","#d98dc0","#0028dc","#5d7d67","#b3c478"],
["Armadillo","#ededde","#e8e8d4","#f1f1e5","#e6d26f","#e8d67d","#e7d374","#9f7e47","#977944","#ede8a8","#efeaaf","#ac7e9a","#edc4d6","#ba3f6f"],
["Pangolin","#d72a2f","#d9363b","#ce272d","#d2282e","#4891d2","#428ed1","#5390c6","#e3f2d6","#eaf5e0","#d8e9c8","#d78d54","#0f1d6d","#6fb46d","#d08298"],
["Platypus","#dcd7c7","#d8d2c0","#dedbce","#d6d0bd","#d0c9b4","#d4cdb5","#880418","#91041a","#47817a","#437a74","#b3bd72","#254345","#d787a5","#d59c81"],
["Hedgehog","#d7d9c5","#d5d7c1","#d9dbc7","#d9dbc7","#b32b44","#b62b44","#b92d46","#c58481","#c78885","#c68480"],
["Eagle","#936b00","#9e7400","#8f6900","#866303","#cb53a6","#ce5aa9","#c7439d","#ce55a7","#6a0340","#720446","#a71118","#b5121a","#192312","#d5ab00","#595112","#879d89"],
["Owl","#28762e","#27722d","#2e8535","#226d28","#2d7b34","#307e36","#ff1769","#ff1f6d","#ffdee6","#ffe5ec","#002b9d","#3e9e09","#f7ff6e","#842d5d"],
["Penguin","#0b151f","#101f2d","#050a0f","#04111f","#6b9744","#77a94c","#b7ad37","#ada334","#67552a","#c7e6f0","#d991f7","#3f0a2f"],
["Flamingo","#a9dc97","#bde4af","#b7e2a7","#a8d996","#b0df9f","#aedda6","#43d252","#38cc47","#b99da1","#ad3562","#c2deb6","#2e413b","#adb93a","#95ada6"],
["Peacock","#82a5a0","#6e9690","#7da19b","#80a39e","#8faea9","#84a49f","#959585","#9b9b8c","#d4d9cf","#cfd4c9","#9ea553","#709017","#2e4416"],
["Cardinal","#ae9a6c","#b3a075","#a6915e","#911d1a","#861b18","#a0211c","#254056","#1f3547","#656b50","#6b7156","#b15b5d","#b45f61","#4d2d34","#5a353d"],
["Robin","#ba666b","#be6f74","#b9646a","#be6066","#b3565c","#c1767b","#160c0f","#0d0709","#cbae9a","#d0b6a4","#840d2b","#4f3317","#be6300","#4f1c42"],
["Sparrow","#c59e0c","#b7920b","#d4a90c","#bc9815","#caa10c","#cba210","#9b1b18","#9b1b18","#303031","#383839","#006e2f","#005c28","#3e5961","#44616a"],
["Hummingbird","#2a3b2b","#263627","#2f4230","#bc0e02","#b60e02","#cc1400","#e39f44","#e29c40","#f5e3ff","#f8ebff","#3d82ff","#4284ff","#150618","#120515"],
["Pelican","#003283","#00378f","#0c2e64","#0b3474","#274c86","#033686","#0b2f6b","#0d3677","#b6a737","#a99b32","#c2d9c2","#cadeca","#0f344e","#0c2b40","#3088a5","#2e829e"],
["Ostrich","#d9cfa1","#d3c792","#ddd4ac","#2052d4","#1e4ec8","#265de8","#bf3d76","#b2386d","#cc9a42","#cb953a","#819339","#8ea23f","#dedede","#e6e6e6"],
["Toucan","#1f1912","#271f16","#1a150f","#1b150e","#17120d","#13100b","#498dc7","#4f90c9","#4f8ec4","#d9b208","#d4ae08","#cfaa07"],
["Parrot","#1E6AE8","#1763DE","#246fe0","#1764d9","#2a5314","#264a12","#785019","#6e4a17","#6350b6","#6856b8","#851a54","#77184c","#a48a15","#9e8410","#9f3a04","#953704"],
["Crow","#ccd1ad","#c8cda7","#d4d8ba","#d0d5b4","#c7ce9c","#cfd4b0","#52aaaa","#519e9e","#b80717","#ac0614","#b99855","#9ec2b5","#9c8b94","#2b1620"],
["Swan","#2d92b0","#2f97b6","#288faf","#9a7c32","#967931","#8e732e","#c91a00","#bd1900","#4b9209","#458609","#c94c27","#d4c726","#8a6a75","#160e10"],
["Duck","#1f2951","#192243","#222d59","#f5d157","#f6d465","#f6d56a","#804a0c","#75430b","#311f12","#2d1c11","#e86512","#ee6f20","#fff7c7","#fffad6"],
["Goose","#aa805c","#ae8765","#ae8d6f","#542840","#5a2b45","#482337","#b10726","#a60724","#417708","#52831e","#72a277","#002ad2","#776b9a","#c9d191"],
["Hawk","#131a13","#0f150f","#151e15","#1a231a","#dbb56b","#dcb86f","#debc78","#d3b069","#c4c47a","#caca86","#cdcd8e","#484140","#3e3837","#151e15","#bf7645","#f2e3c4"],
["Falcon","#a6e3a8","#aee5af","#b1e7b3","#b5e8b7","#a17961","#936e58","#99735c","#96715a","#ce0745","#c50743","#205a24","#1d5321","#fa42a1","#d2a400","#5591b9","#100e1f"],
["Vulture","#dbc7a6","#ddcaac","#e1cdad","#0d1228","#0a0e1f","#101632","#d70200","#e00400","#c30704","#48694c","#446448","#405e44","#d6b32b","#d7b52d","#122948","#102641"],
["Snake","#577968","#5e8270","#4e7361","#48705c","#547363","#9cd194","#a6d69f","#a9d7a2","#badfb4","#a3d49b","#e6c754","#e11400","#760000"],
["Lizard","#e3deb0","#e7e3bb","#e6e1b7","#e1dba8","#e5e1b8","#e9e4ba","#bfc47a","#c6ca86","#ded16e","#e0d376","#de7d7d","#c9ba66","#b17761","#bdb38c"],
["Turtle","#4f8465","#4d8062","#5c9975","#66a380","#99b8c9","#94b5c7","#afc7d5","#526860","#485b54","#bba488","#c3b097","#48262a","#5e3136","#ba2727","#2d49b0","#b085bd","#b0994a"],
["Tortoise","#4a5cff","#5c6cff","#707eff","#5161f0","#5263ff","#4a5cff","#f7db45","#f8e262","#f7db3b","#f5c4e8","#f3b9e4","#f9dcf1","#f7e6c4","#8aac30","#363639","#b99d64"],
["Crocodile","#dcdcc5","#d9d9bf","#e8e8d9","#d1d1b3","#be6d91","#c680a0","#b9648b","#498da3","#498da3","#3f601b","#345016","#760008","#bc8d17","#301f17","#b86017"],
["Alligator","#236264","#20595b","#2a7679","#308588","#ff66a1","#ff85b4","#ff99c0","#ff5c9a","#92b87c","#9cbf88","#f71424","#f72634","#4d2f2b","#de744c","#fce3ed"],
["Iguana","#021992","#0320b5","#02198d","#aa600e","#97560c","#d07711","#3e9d82","#46af91","#ebe8e6","#f5f2f0"],
["Gecko","#6fb157","#7bb865","#65a84d","#5d9a47","#b80000","#a30000","#cc0000","#022f7e","#012665","#0d0e16","#171927","#d4569d","#e32800","#e69a00","#5cc7c7"],
["Chameleon","#d1c294","#dacea9","#e0d6b8","#cebe8d","#5b7171","#647d7d","#6d8888","#c71100","#a30e00","#b80f00","#869c60","#778b55","#ca9544","#d2a460"],
["Komodo dragon","#87cfe0","#7dccde","#6dc6d9","#9ed9e6","#69928b","#719891","#89a9a4","#7da19b","#1e62d7","#286ce2","#1b59c5","#1649a2","#a39800","#8f8500"],
["Tuatara","#76a47f","#85ad8d","#91b698","#9dbea4","#030d57","#041276","#05148a","#06179d","#cfbd75","#d5c586","#a66602","#ca7d02","#26512e","#2e6137","#d4d9d6","#dfe2e0"],
["Frog","#021045","#031863","#041d77","#04218b","#107d4a","#0e6c40","#139056","#15a261","#27b384","#2cc995","#3ec65e","#52cb6e","#8c7412","#a28615","#769e13","#89b715"],
["Toad","#eddeb5","#f3e9ce","#ebd9ad","#e7d49c","#436e20","#4d7e25","#304f17","#e38c12","#ed961d","#f0a742","#b8a27c","#e13f44","#423725","#b05f05"],
["Salamander","#193573","#1d3e86","#214697","#254ea7","#5d8ca9","#79a0b9","#6c97b2","#bdbdb5","#cfcfc9","#b2b2a9","#b8868d","#c3989e","#7f8986","#767f7c"],
["Newt","#699bac","#7ba8b7","#89b1be","#7f5a04","#9e7005","#b17e06","#080b0d","#101519","#172026","#8d7e00","#a39300","#1a4790","#2056ac","#95833c","#a45200","#de6f5b","#9f1500"],
["Axolotl","#4f6d97","#5f7eab","#6c89b2","#7994b9","#375421","#30491d","#436728","#4d762e","#7e2b80","#973399","#1f1a21","#2b242e","#1f3a88","#b18341","#c46bba","#6c9163"],
["Shark","#112b73","#133081","#0f2562","#1e87c3","#1c7ab0","#1f89c7","#52a588","#5bae91","#4a967c","#484068","#4c446f","#443c62","#abcfad","#7d91ac","#36867f"],
["Tuna","#40535e","#4a606d","#3a4b55","#536b79","#82872f","#929735","#a1a63a","#afb540","#182e1a","#234326","#b8b172","#c1bb85","#966656","#c5b12b","#aa5730","#ba1c15"],
["Salmon","#8cd49e","#a6deb4","#b5e3c0","#79cd8e","#c3e9cd","#ccf0cc","#dff6df","#75c561","#8acd79","#dbbd57","#b67124","#e3f2d6","#e0d9db"],
["Goldfish","#357d76","#439d94","#3d8f87","#31726c","#235021","#2c6529","#33742f","#375d21","#47792a","#508830","#8f8420","#3c4479","#9e274c","#3f4746"],
["Angelfish","#dbd4c2","#f0ede5","#d2c9b2","#e9e4d8","#b1bd6f","#bbc581","#9aa84d","#b1bd6f","#94b39e","#a0bba8","#7ca288","#5b7966","#698c76","#dba85c","#e2b879"],
["Clownfish","#ad8129","#c6942f","#d09e39","#d4a649","#1f3446","#253f55","#2c4963","#325471","#bf5035","#ca5b3f","#6072d7","#7c8bde","#d1abba","#dbbdc9","#483e5e","#55496f"],
["Bass","#c4bd99","#bcb38a","#d2cdb1","#2b4c91","#345aad","#3862bc","#ab2328","#ba262b","#cb2a2f","#5d3875","#57356e","#784997","#500d15","#69111b","#af2f00","#cc3600"],
["Trout","#c73200","#e03800","#f53d00","#ff571f","#6ca16e","#5f9561","#83af84","#8fb790","#001f80","#001f7a","#001966","#1e1817","#2e2523","#d4d9c7","#e3e6db"],
["Cod","#47495f","#3d3f51","#585a74","#606380","#799751","#89a960","#93b06d","#987634","#a78339","#b68e3e","#deab17","#354b1f","#b8b394","#ce4e00"],
["Swordfish","#e6ebdb","#e4e9d8","#dbe2ca","#d1dbbd","#a8e3b0","#c1ebc7","#d1f0d5","#be9b00","#e0b700","#f5c800","#f29103","#fd9d0d","#19328a","#1c389b"],
["Manta ray","#dbd4e0","#d7d0dd","#cdc4d4","#c3b8cc","#1f1819","#2e2325","#3a2c2e","#453538","#7a5812","#8e6615","#4e4367","#5d517b","#374d38","#445f45","#2b2f72","#2b2f72"],
["Seahorse","#113e76","#144b8f","#1755a1","#195eb3","#c4ccb0","#d1d7c1","#dadfcd","#e3e7da","#7eb88d","#96c5a2","#625c3f","#706948","#2f2b22","#5492ad","#d06500"],
["Eel","#7c613e","#886a44","#95754b","#a38052","#f5d499","#f4cf90","#f2c77d","#facf29","#f9ca10","#efc006","#80272f","#232423","#5eba77"],
["Catfish","#090d15","#121b2b","#182339","#1f2c47","#082960","#092f71","#0b3784","#e30200","#ff0e0a","#f2d6de","#ebc1d1","#610b04","#61fa47","#0007d0","#eda675"],
["Piranha","#131e36","#1b2a4b","#20335a","#253b6a","#2a4379","#4569ff","#335cff","#64866d","#72977c","#a2b392","#adbc9f","#bb5c11","#cd6413"],
["Butterfly","#c09328","#ba8e26","#d5a534","#d9ac45","#dcb456","#43488f","#4e54a6","#8b4900","#7a4100","#d6cfc4","#ded8cf","#549292","#64a6a6"],
["Bee","#a8c2cc","#bfd2d9","#ccdbe1","#d8e4e8","#ededcc","#eaeac3","#e4e4b4","#dfdfa4","#1e2431","#272f3f","#dc3c39","#e05452","#9cbade","#ae6a42","#edcfb3"],
["Ant","#bd928b","#c39d97","#cba9a4","#786f6d","#8b817e","#948b89","#ca9756","#c48d45","#529859","#60a967","#1a5030","#236c40","#6a7a91","#be132d","#d2607e","#7f357f","#0013b3","#4d1d0b"],
["Beetle","#e8ebe0","#e4e7da","#dbdfcd","#d1d7c1","#2938ff","#4754ff","#5c67ff","#e84c00","#ff5c0a","#79a800","#92cc00","#cfae00","#f5cc00","#2d17ac","#b68505"],
["Grasshopper","#d6deb3","#e0e6c6","#e8ecd4","#d1daaa","#fafcd6","#fdfeec","#f8fbc6","#bac28f","#ced4b0","#c6cca3","#81b896","#97c4a8","#929269","#b8d694"],
["Cricket","#ebe6cc","#e8e2c4","#e2dbb6","#f4f1e2","#f9f8f0","#b5e382","#c4e89b","#ceecac","#306830","#3a7e3a","#993613","#ff1c00"],
["Dragonfly","#f2c7b0","#f1c1a7","#eeb596","#f6daca","#eba884","#75a242","#88b851","#5d637d","#686f8d","#d4a451","#cd6028","#0f0f1a","#c71d0a"],
["Mosquito","#ebe6d4","#ede9d9","#eae5d2","#f1eddf","#402d19","#422f1a","#46311b","#b5d626","#bbda2f","#c5e04d","#577900","#507000","#24210d","#f71924"],
["Fly","#988264","#a69377","#ae9d84","#b6a690","#9f3624","#b73f2a","#485b74","#566d8a","#3e1014","#51151a","#644c3a","#755843","#ad8926","#725000","#0a1f4c","#361f13"],
["Wasp","#0f1826","#06090f","#17253a","#1d2e49","#718683","#7a908c","#859995","#90a29f","#7eb565","#8cbd75","#a77213","#b87e14","#d94d32","#d1cfbf","#acc55b","#79000c"],
["Moth","#dbdebd","#dadcc1","#e9ead6","#d4d8b1","#c9b399","#c5ad91","#c1a88a","#94bdad","#9dc3b4","#ae5332","#9e4c2e","#c994b0","#cfa0ba","#d2b119","#c4a517"],
["Praying mantis","#cfa400","#f5c400","#cca300","#ffce0a","#c7cfc4","#d4dad2","#dfe3dd","#19191c","#26262b","#879589","#7e4e00"],
["Ladybug","#ab0000","#cc0000","#e00000","#7781cf","#5966c5","#6873ca","#de45b3","#e363bf","#b5b0db","#cbc7e5","#d90543","#ef064c","#d54a00","#f55600","#11239a","#142ab8","#748100","#0c0d0d"],
["Cockroach","#f2d6c4","#f0d0bc","#ecc5ac","#f8e8de","#c01523","#dc1829","#b81422","#4f6491","#576d9e","#6178a8","#2b292d","#fab845","#db8f85","#88a4c5"],
["Termite","#a1ded4","#97d8cf","#b4e4dc","#c3e9e3","#721003","#630e03","#8b1304","#f2c9ab","#f9e8dc","#e0c2eb","#d9b2e6","#addbff","#ebbd0a","#faadb0","#000e87"],
["Octopus","#7ea388","#85a88e","#94b39c","#6d9778","#82ab8d","#85a88e","#6d9778","#9fbd9f","#98b998","#a7c3a7","#863a15","#7c3613","#924017"],
["Jellyfish","#c6672f","#d07039","#d8885a","#d47c49","#fcfffa","#e7ffd6","#f3ffeb","#0d0f0f","#2f3737","#1c2121","#ff192e","#d9e8ff","#57ca61"],
["Starfish","#3a4e20","#36481e","#4b6529","#56742f","#42ff85","#5cff95","#33ff7a","#70ffa2","#aec75d","#bbd076","#c18d00","#e0a500","#1b401f","#101c17","#e8ff45","#f70357"],
["Sea urchin","#885838","#825435","#9f6741","#ae7047","#fcdb45","#fde05e","#fcd836","#09060d","#130d1c","#1d132a","#f7edf5","#f2e3ef","#e33f03","#fb4d0e"],
["Lobster","#8b8981","#9d9b95","#7f7d76","#a7a5a0","#2a2c31","#383b42","#42454d","#4b4f58","#e6e0db","#d5cbc3","#ded5cf","#8cb325","#a0cb2a","#d6b333","#dab944"],
["Crab","#e0e3d4","#dbdfce","#d2d7c1","#c9cfb4","#63986e","#84ae8b","#77a681","#587356","#638060","#6c8c69","#6ac5ac","#7bccb6","#6d1933","#191b1c"],
["Shrimp","#748a82","#859991","#90a29b","#9baba5","#d9a88f","#e0b8a4","#e5c5b3","#0f0d10","#201c22","#2a252d","#faf7ed","#f6f1df","#f2e812","#91c7fc"],
["Coral","#5c0300","#7a0400","#8f0500","#520300","#3d0200","#080a0a","#121717","#1b2222","#e8ad1c","#ebb733","#f7f7fc","#7de654"],
["Sea anemone","#d9c930","#cfbe26","#beae23","#ac9e20","#1b1c1d","#141415","#27292a","#6a722b","#7b8532","#d4d9c4","#e4e7da","#c5a400","#294836","#3a2d4e","#637977"],
["Cat","#e0e6f0","#d6deeb","#c8d2e4","#bac7de","#0b0f1d","#11172c","#161e3b","#75973c","#88af46","#93b950","#183024","#202435","#59945d"],
["Spider","#2b5b7a","#306588","#357097","#3a7ba6","#d6cfcc","#d2cac6","#edeae8","#b08179","#bb928b","#c39f98","#7da3c7","#8daece","#b8c23f","#c5ce64"],
["Scorpion","#747029","#6a6625","#5b5820","#888330","#979235","#a6a13a","#ff99d9","#ffade1","#ffc2e9","#f7573d","#f8654f","#f87662","#6e502d","#825e35"],
["Centipede","#faf0eb","#f7e7de","#f3dace","#efcebe","#063854","#084b72","#095886","#2dd96d","#26cf64","#23be5c","#1b3c19","#275624","#258400","#969100"],
["Millipede","#151f42","#1d2b5d","#22326d","#273a7c","#b11b09","#9b1708","#881407","#ae5bb6","#b972c0","#c080c6","#214d56","#275d68","#2d6a76"],
["Earthworm","#1f5cff","#0a4bff","#4778ff","#3369ff","#e0e6e8","#f3f6f6","#d0d9dc","#99ff33","#a3ff47","#9d0000","#b80000","#85f5c2","#a1f7d0","#1a7100","#186600"],
["Snail","#121418","#1a1d23","#23272f","#737e41","#87944c","#93a253","#275126","#2f612e","#2a121a","#ba8cb5","#6897c2","#7da4ca","#dec2a1","#abe3c2","#2d5967","#7d3c00","#4a2c61","#b29454"],
["Slug","#f5f0f5","#f3edf3","#f7f3f7","#f7f3f7","#242d2e","#222a2b","#e0f200","#e9f500","#6bff0f","#ff6103","#4abaff","#00d4a9"],
["Squid","#b6101b","#ce121f","#e11421","#0c52d7","#1864f2","#2b71f3","#18a594","#1cc4b1","#1fd6c1","#ffdb47","#ffde5c","#ffe785","#a40788","#c408a1","#ff5496","#8cc328"],
["Moose","#4a6d9b","#5a7faf","#688ab6","#7594bd","#839fb1","#7595a9","#688ba1","#5e8197","#abbaa8","#bdc9ba","#a90088","#cc00a3","#ce2400","#0324ff","#cfb300","#0e1216"],
["Deer","#f2f7c9","#edf4b8","#e9f2a6","#e5ef95","#ffe329","#ffe747","#325403","#477604","#eb6e91","#ee81a0","#11574c","#14665a","#bddb08","#d4f613","#0b2d75","#af4600"],
["Horse","#000a9b","#000cb8","#000ecc","#000fe0","#50bb8d","#5dc095","#6cc69f","#7bcca9","#55008f","#6200a3","#336a00","#458f00","#0b0c0d","#f082d9","#be3d00","#47cb00"],
["Cow","#b0baa6","#abb6a0","#a6b19a","#c7cec0","#b0b7a9","#e0e6e3","#e2e4e3","#e6ebe8","#e8edeb","#dee8e3","#ab071d","#a2071b","#9b081c","#31352b","#2c3027","#95a797","#98a99a"],
["Pig","#d9ded6","#d5dbd2","#cbd2c6","#c0c9bb","#b6bfb0","#e6d130","#e9d649","#ebda5c","#c58688","#d19fa0","#d7acae","#65707e","#68b830","#d95700","#793c5d"],
["Buffalo","#1d1921","#29232f","#141217","#332c3a","#3d3546","#c0b121","#d1c023","#dcca2e","#d23b00","#f54500","#c2cfbd","#d3ddd0"]];

    function createPaletteElement(palette) {
        const paletteDiv = document.createElement('div');
        paletteDiv.className = 'palette';

        const nameDiv = document.createElement('div');

        const colorsDiv = document.createElement('div');
        colorsDiv.className = 'palette-colors';
        palette.shift();
        palette.forEach(color => {
            const colorDiv = document.createElement('div');
            colorDiv.className = 'palette-color';
            colorDiv.style.backgroundColor = color;
            colorDiv.title = color; // Show hex code on hover
            colorsDiv.appendChild(colorDiv);
        });

        paletteDiv.appendChild(colorsDiv);
        return paletteDiv;
    }

    // Initialize palettes
    const palettesContainer = document.getElementById('palettesContainer');
    if (palettesContainer) {
        colorPalettes.forEach(palette => {
            palettesContainer.appendChild(createPaletteElement(palette));
        });
    }
});

  </script>
   <script>
        (function() {
            const canvas = document.getElementById('pixelBg');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            const img = new Image();
            img.src = '../images/collections/nokori/5.jpeg';

           function resizeCanvasToViewport() {
    canvas.width = 400;
    canvas.height = 400;
}

            function drawPixelatedBackground() {
                if (!img.complete || !img.naturalWidth) return;

                resizeCanvasToViewport();

                // Cover strategy: compute draw size to fill canvas while preserving image aspect
                const aspect = canvas.width / canvas.height;
                const imgAspect = img.width / img.height;
                let drawW, drawH;
                if (imgAspect > aspect) {
                    drawH = canvas.height;
                    drawW = Math.ceil(drawH * imgAspect);
                } else {
                    drawW = canvas.width;
                    drawH = Math.ceil(drawW / imgAspect);
                }
                const dx = Math.floor((canvas.width - drawW) / 2);
                const dy = Math.floor((canvas.height - drawH) / 2);

                ctx.imageSmoothingEnabled = true;
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.drawImage(img, dx, dy, drawW, drawH);
            }

            img.onload = drawPixelatedBackground;
            window.addEventListener('resize', drawPixelatedBackground);
        })();
    </script>
  </div><!-- end full-width wrapper -->
  <div class="footer mt-5">
    <?php include '../footer.php'; ?>
  </div>
</body>
</html>
