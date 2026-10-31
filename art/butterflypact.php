<!DOCTYPE html>
<html lang="en">
<head>
   <?php include '../meta.php'; ?>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
       document.title = "Andrew Mitchell - Butterfly Pact";
       $(document).ready(function() {
           $("a.nav-item.nav-link:contains('ART')").css("text-decoration", "underline");
       });
   </script>
     <style>
      .preview-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        margin-bottom: 20px;
      }
      .preview-grid img {
        display: block;
        width: 100%;
        height: auto;
        border: 1px solid currentColor;
      }
      @media (max-width: 768px) {
        .preview-grid {
          grid-template-columns: 1fr;
        }
      }
     </style>
</head>
<body>
  <div class="art-page">
    <h1 class="light-text"><em>Butterfly Pact</em></h1>
    <p class="date light-text"><em>2023</em></p>

    <div class="btn-row">
      <a href="/collections/butterfly-pact/" target="_blank" class="view-tokens-btn light-text" onclick="event.preventDefault(); var mode = new URLSearchParams(window.location.search).get('mode') || '0'; window.open('/collections/butterfly-pact/?mode=' + mode, '_blank');">
        View All Tokens →
      </a>
    </div>

    <div class="preview-grid" id="slideshow"></div>

    <p class="description light-text">
      95 unique pieces, created with Javascript and <a href="https://p5js.org/" target="_blank">p5.js</a>, and minted on Arbitrum, an Ethereum L2. Presented by <a href="https://www.prohibition.art" target="_blank">Prohibition</a> and deployed on <a href="https://www.artblocks.io/" target="_blank">Art Blocks Engine</a>.
      <br><br>
      Secondary market on <a href="https://opensea.io/collection/butterfly-pact-by-andrew-mitchell" target="_blank" title="Opensea">Opensea</a>.
    </p>

    <div class="contract-details light-text">
      The code, which is 10,298 characters long, is stored on an Arbitrum smart contract <a target="_blank" href="https://arbiscan.io/address/0x47A91457a3a1f700097199Fd63c039c4784384aB#readContract#F38" title="Etherscan">here</a>.
      Querying "projectScriptByIndex" with 60 as the "_projectId" and 0 as the "index" will return the script.
      <br><br>
      <img src="https://images.squarespace-cdn.com/content/637d087cfeae7764854916c4/835fdcc0-9be8-41d4-8ab1-fd761ddf8bdd/Screenshot+2024-06-30+at+10.46.55%E2%80%AFPM.png?content-type=image%2Fpng" alt="Butterfly Pact Contract Details">
    </div>

    <div class="art-gallery" id="imageContainer"></div>
  </div>

  <script>
    const imageUrls = [];
    for (var i = 0; i < 95; i++) {
      imageUrls.push("/images/collections/butterfly-pact/" + i + ".png");
    }

    // Shuffle and pick a subset for the preview grid
    var shuffled = imageUrls.slice().sort(function() { return 0.5 - Math.random(); });
    var slides = shuffled.slice(0, 6);

    // Build preview grid
    var slideshow = document.getElementById('slideshow');

    slides.forEach(function(url, i) {
      var img = document.createElement('img');
      img.src = url;
      img.alt = 'Butterfly Pact ' + i;
      slideshow.appendChild(img);
    });

    // Full gallery
    var container = document.getElementById('imageContainer');
    imageUrls.forEach(function(url, i) {
      var img = document.createElement('img');
      img.setAttribute('data-src', url);
      img.className = 'lazy';
      img.alt = 'Butterfly Pact ' + i;
      container.appendChild(img);
    });
  </script>

  <div class="footer mt-5">
    <?php include '../footer.php'; ?>
  </div>
</body>
</html>
