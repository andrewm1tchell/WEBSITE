<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../meta.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("a.nav-item.nav-link:contains('ART')").css("text-decoration", "underline");
        });
        document.title = "Andrew Mitchell - A Sudden Interest in Nature";
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
    <h1 class="light-text"><em>A Sudden Interest in Nature</em></h1>

    <div class="btn-row">
        <a href="/collections/a-sudden-interest-in-nature/" target="_blank" class="view-tokens-btn light-text" onclick="event.preventDefault(); var mode = new URLSearchParams(window.location.search).get('mode') || '0'; window.open('/collections/a-sudden-interest-in-nature/?mode=' + mode, '_blank');">
          View All Tokens →
        </a>
    </div>

    <div class="preview-grid" id="slideshow"></div>

    <div class="description light-text">
        Created with JavaScript and <a href="https://p5js.org/" target="_blank">p5.js</a>, and minted on Ethereum.
        <br><br>
        Secondary market on <a href="https://superrare.com/andrew_mitchell" target="_blank" title="SuperRare">SuperRare</a>.
    </div>

    <div class="art-gallery" id="gallery"></div>

    <hr style="border-color: rgba(248,249,250,0.2); margin: 40px 0;">

    <div class="featured-img">
        <img data-src="https://media.1155.tech/art-market/657911c3f920df2e21c9d14a-1702435595376.jpeg" class="lazy" alt="Flowers for Your Desktop Background">
        <p class="light-text" style="margin-top: 10px;"><strong><em>Flowers for Your Desktop Background</em></strong></p>
    </div>
</div>

<script>
    const imageFiles = [
        "Shadowbox.png",
        "Ambien.png",
        "Kaleidoscope.png",
        "Atlantis.png",
        "Emeralds.png",
        "Royal.png",
        "VineIntervention.png",
        "OrangeCrush.png",
        "FleshAndBones.png",
        "Palisade.png"
    ];

    var imageUrls = imageFiles.map(function(f) { return '/images/asiin/' + f; });

        // Shuffle and pick a subset for the preview grid
    var shuffled = imageUrls.slice().sort(function() { return 0.5 - Math.random(); });
    var slides = shuffled.slice(0, 6);

        // Build preview grid
    var slideshow = document.getElementById('slideshow');

    slides.forEach(function(url, i) {
      var img = document.createElement('img');
      img.src = url;
      img.alt = 'A Sudden Interest in Nature ' + i;
      slideshow.appendChild(img);
    });

    // Full gallery
    const gallery = document.getElementById('gallery');
    imageUrls.forEach(function(url, i) {
        const img = document.createElement('img');
        img.setAttribute('data-src', url);
        img.className = 'lazy';
        img.alt = imageFiles[i].replace('.png', '');
        gallery.appendChild(img);
    });
</script>

<div class="footer mt-5">
    <?php include '../footer.php'; ?>
</div>
</body>
</html>
