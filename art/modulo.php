<!DOCTYPE html>
<html lang="en">
<head>
   <?php include '../meta.php'; ?>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
          document.title = "Andrew Mitchell - Modulo";

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
    <h1 class="light-text"><em>Modulo</em></h1>
    <p class="date light-text"><em>2024</em></p>

    <div class="btn-row">
      <a href="/collections/modulo/" target="_blank" class="view-tokens-btn light-text" onclick="event.preventDefault(); var mode = new URLSearchParams(window.location.search).get('mode') || '0'; window.open('/collections/modulo/?mode=' + mode, '_blank');">
        View All Tokens →
      </a>
    </div>

    <div class="preview-grid" id="slideshow"></div>

    <p class="description light-text">
         128 pieces, minted on Ethereum.<br>
          Rich Caldwell <a href="https://x.com/cafromthesky" target="_blank">(@cafromthesky)</a> and I first connected in late 2021 on Twitter. I was always fascinated by Rich’s work. To me, they raised questions about nature, human society, and computing. Is humanity a part of nature? Is this earth just a procedural canvas?<br>
          Our collaborative journey officially began in 2022. I had the opportunity to contribute to Rich’s 12 Days of Art, an online showcase celebrating the work of digitally native artists.<br>
          While exhibiting Flowers of Alfiren at Art on Paper, I encountered a work by Didier Fournet that captured my attention. It opened my eyes to the endless possibilities of pixel manipulation as an art form. I realized I could do what Photoshop does but with code.<br>
          This led to Rich and I’s first truly collaborative piece, <a href="https://foundation.app/mint/eth/0xa20D68492A8F74D69270f7D376AC93c26F9C8979/1" target="_blank">No Diving</a>.<br>
          In creating No Diving, I took one of Rich’s aerial shots of a pool and, using p5js, wrote a script that recursively reflected the image onto itself.<br><br>
          Rich introduced me to some photos he captured of the roofs of local buildings. I manipulated them with JavaScript and <a href="https://p5js.org/" target="_blank">p5.js</a>. This process involved selecting segments of each image, shuffling them, and then strategically reapplying them to the original picture.<br><br>
          Secondary market on <a href="https://foundation.app/mint/eth/0xD82e522a62d1b466D66a2fec2eb52306652e7dF0/126" target="_blank" title="Foundation">Foundation</a>.
    </p>


    <div>
      <img class="lazy" data-src="https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/dbc6247e-f9f1-4712-8146-cecae15bb0c8/nft.png?format=1000w" alt="No Diving (Recursive Reflection)" style="max-width: 80%;">
      <p class="light-text" style="margin-top: 0.5rem;"><strong><a href="/collections/recursive-reflection/1.html" target="_blank" onclick="event.preventDefault(); var mode = new URLSearchParams(window.location.search).get('mode') || '0'; window.open('/collections/recursive-reflection/1.html?mode=' + mode, '_blank');">No Diving</a></strong> (from <a href="/collections/recursive-reflection/" target="_blank" onclick="event.preventDefault(); var mode = new URLSearchParams(window.location.search).get('mode') || '0'; window.open('/collections/recursive-reflection/?mode=' + mode, '_blank');">Recursive Reflection</a>)</p>
    </div>


    <div class="art-gallery" id="imageContainer"></div>

  <script>
    var baseUrl = 'https://highlight-creator-assets.highlight.xyz/main/base-dir/84b80207-b58f-480e-8870-74947150624c/previews/';
    var imageUrls = [];
    for (var i = 1; i <= 128; i++) {
      imageUrls.push(baseUrl + i + '.png');
    }

    // Shuffle and pick a subset for the preview grid
    var shuffled = imageUrls.slice().sort(function() { return 0.5 - Math.random(); });
    var slides = shuffled.slice(0, 6);

    // Build preview grid
    var slideshow = document.getElementById('slideshow');

    slides.forEach(function(url, i) {
      var img = document.createElement('img');
      img.src = url;
      img.alt = 'Modulo ' + i;
      slideshow.appendChild(img);
    });

    // Full gallery
    var container = document.getElementById('imageContainer');
    imageUrls.forEach(function(url, i) {
      var img = document.createElement('img');
      img.setAttribute('data-src', url);
      img.className = 'lazy';
      img.alt = 'Modulo ' + (i + 1);
      container.appendChild(img);
    });
  </script>
  </div>
 
  <div class="footer mt-5">
    <?php include '../footer.php'; ?>
  </div>
</body>
</html>
