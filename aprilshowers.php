<!DOCTYPE html>
<html lang="en">
<head>
   <?php include '../meta.php'; ?>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
       $(document).ready(function() {
           $("a.nav-item.nav-link:contains('ART')").css("text-decoration", "underline");
       });
       document.title = "Andrew Mitchell - April Showers & Touch Grass";
   </script>
</head>
<body>
<div class="art-page">
    <h1 class="light-text"><em>April Showers &amp; Touch Grass</em></h1>
    <p class="date light-text"><em>2022-2023</em></p>

    <div class="btn-row">
        <a href="/collections/april-showers/" target="_blank" class="view-tokens-btn light-text" onclick="event.preventDefault(); var mode = new URLSearchParams(window.location.search).get('mode') || '0'; window.open('/collections/april-showers/?mode=' + mode, '_blank');">
          View April Showers Tokens →
        </a>
        <a href="/collections/touch-grass/" target="_blank" class="view-tokens-btn light-text" style="margin-top: 8px;" onclick="event.preventDefault(); var mode = new URLSearchParams(window.location.search).get('mode') || '0'; window.open('/collections/touch-grass/?mode=' + mode, '_blank');">
          View Touch Grass Tokens →
        </a>
    </div>

    <div class="slideshow" id="slideshow"></div>
    <div class="slideshow-dots" id="slideshowDots"></div>

    <div class="description light-text">
        April Showers (2023) and Touch Grass (2022) both make up a set of 9 generative surreal landscapes created with JavaScript and <a href="https://p5js.org/" target="_blank">p5.js</a>, and minted on Ethereum. Each piece attempts to encapsulate the viewer into a world overgrown. If I was shrunk down and placed into a thicket—one square inch of this thicket would look like an entire universe to me.
        <br><br>
        April Showers - Secondary market on <a href="https://opensea.io/collection/april-showers-by-andrew-mitchell" target="_blank" title="OpenSea">OpenSea</a>.<br>
        Touch Grass - Secondary market on <a href="https://opensea.io/collection/touch-grass-by-andrew-mitchell" target="_blank" title="OpenSea">OpenSea</a>.
    </div>

    <div class="art-gallery" id="gallery"></div>

    <div class="featured-img">
        <img data-src="https://raw2.seadn.io/ethereum/0x3f505d613218f1cb30341b5a1dd9656855811e29/ddfc3decee28131bf24478df1c7099cf.png" class="lazy" alt="Play Action Pass">
        <p class="light-text" style="margin-top: 10px;"><strong><em>Play Action Pass</em><br>Created between the times of these two series, this work was part of a group charity show for the <a href="https://bf-foundation.org" target="_blank">Benchetler Fasani Foundation</a></strong>.</p>
    </div>
</div>

<script>
    const imageUrls = [
        "https://raw2.seadn.io/ethereum/0x223cfa03094d7169bd0c9345c11745cfea064005/a604cb5d6e8ec9b05f07fa870d6dddce.png",
        "https://i2c.seadn.io/ethereum/0x223cfa03094d7169bd0c9345c11745cfea064005/a696a981a4ae6201d4006f7f045a12e0.png?w=1000",
        "https://images.squarespace-cdn.com/content/637d087cfeae7764854916c4/08dbba99-cb93-44e0-b58f-4b3d67ba14df/Snooze-12Raffle.png?content-type=image%2Fpng",
        "https://images.squarespace-cdn.com/content/637d087cfeae7764854916c4/1682560202700-04I1GOHV0SGV9DN73MIH/Charm_1.jpg?content-type=image%2Fjpeg",
        "https://i2c.seadn.io/ethereum/0x223cfa03094d7169bd0c9345c11745cfea064005/20707b2c79f921e895aa4231f5709367.png?w=1000",
        "https://images.squarespace-cdn.com/content/637d087cfeae7764854916c4/1686337574133-WWPGUHER40OPT86SIGXX/TouchGrass_1copy.png?content-type=image%2Fpng",
        "https://images.squarespace-cdn.com/content/637d087cfeae7764854916c4/1682560278808-X7C0NMVTILC98H915ZWW/Sleep_4.jpg?content-type=image%2Fjpeg",
        "https://images.squarespace-cdn.com/content/637d087cfeae7764854916c4/1682560292231-GXE0ZSEI7UFMNXEJBHSQ/Mother_2.jpg?content-type=image%2Fjpeg",
        "https://images.squarespace-cdn.com/content/637d087cfeae7764854916c4/1682560250459-T446CKVO3B3KBOQ1RAOM/Hiding%2BPlace_3.jpg?content-type=image%2Fjpeg",
        "https://images.squarespace-cdn.com/content/637d087cfeae7764854916c4/9a60e1ac-fdd2-4129-a75b-6d1a5c32cad6/Fortress_2.png?content-type=image%2Fpng"
    ];

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
      img.alt = 'April Showers ' + i;
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
        img.alt = 'April Showers ' + (i + 1);
        gallery.appendChild(img);
    });
</script>

<div class="footer mt-5">
    <?php include '../footer.php'; ?>
</div>
</body>
</html>
