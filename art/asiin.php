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

    <div class="slideshow" id="slideshow"></div>
    <div class="slideshow-dots" id="slideshowDots"></div>

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

    // Shuffle and pick a subset for the hero carousel
    var shuffled = imageUrls.slice().sort(function() { return 0.5 - Math.random(); });
    var slides = shuffled.slice(0, 6);
    var currentSlide = 0;

    // Build hero carousel
    var slideshow = document.getElementById('slideshow');
    var dotsContainer = document.getElementById('slideshowDots');
    var dots = [];

    slides.forEach(function(url, i) {
      var img = document.createElement('img');
      img.src = url;
      img.alt = 'A Sudden Interest in Nature ' + i;
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

    // Swipe support
    var touchStartX = 0;
    slideshow.addEventListener('touchstart', function(e) { touchStartX = e.changedTouches[0].screenX; });
    slideshow.addEventListener('touchend', function(e) {
      var diff = e.changedTouches[0].screenX - touchStartX;
      if (diff < -50) goToSlide(currentSlide + 1);
      if (diff > 50) goToSlide(currentSlide - 1);
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
