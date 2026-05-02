<!DOCTYPE html>
<html lang="en">
<head>
   <?php include '../meta.php'; ?>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
   
       $(document).ready(function() {
           $("a.nav-item.nav-link:contains('ART')").css("text-decoration", "underline");
       });
       document.title = "Andrew Mitchell - Primera";

   </script>
</head>
<body>
 <div class="art-page">
    <h1 class="light-text"><em>Primera</em></h1>
    <p class="date light-text"><em>2021</em></p>

    <div class="btn-row">
      <a href="/collections/primera/" target="_blank" class="view-tokens-btn light-text" onclick="event.preventDefault(); var mode = new URLSearchParams(window.location.search).get('mode') || '0'; window.open('/collections/primera/?mode=' + mode, '_blank');">
        View All Tokens →
      </a>
    </div>

    <div class="slideshow" id="slideshow"></div>
    <div class="slideshow-dots" id="slideshowDots"></div>

    <p class="description light-text">
      Primera is the genesis project from <a target="_blank" href="https://x.com/Mystudios_io">Mitchell and Yun Studios</a> (founded by me and <a href="https://ribbonriven.com" target="_blank">Grant Yun</a>) created with JavaScript and <a href="https://p5js.org/" target="_blank">p5.js</a>, and minted on Ethereum. Capped at 400 individual pieces generated upon mint, it has been a project years in the making. It is a study and interpretation of the fundamentals of early 20th-century art utilizing 21st-century blockchain technology. Each piece is unique and uses its own individual seed value, generated at the time of creation.
      <br><br>
      Secondary market on <a href="https://opensea.io/collection/primera-by-mitchell-and-yun" target="_blank" title="OpenSea">OpenSea</a>.
      <br><br>
      Interact with the entire 400-piece collection on our website <a href="https://deca.art/collection/sky-meadow-by-andrew-mitchell" target="_blank" title="Deca">mystudios.xyz</a>.
    </p>

    <div class="contract-details light-text">
      The code, which is 24,212 characters long, is stored on an Ethereum smart contract <a target="_blank" href="https://etherscan.io/address/0x9bf53d8c65f03d895dacaa776cc960e462ecb599#readContract#F11" title="Etherscan">here</a>:
      <br>
      <img src="https://images.squarespace-cdn.com/content/637d087cfeae7764854916c4/e99639fd-33cf-4bfa-978c-73ad69ec55a0/Screenshot%2B2024-06-27%2Bat%2B12.21.35%E2%80%AFAM.png?content-type=image%2Fpng" alt="Primera Contract Details">
    </div> 
    <p class="light-text">
      <a rel="license" target="_blank" href="http://creativecommons.org/publicdomain/zero/1.0/">
        <img src="http://i.creativecommons.org/p/zero/1.0/88x31.png" style="border-style: none;" alt="CC0">
      </a>
      <br>
      To the extent possible under law, Andrew Mitchell and Grant Yun have waived all copyright and related or neighboring rights to Primera by Mitchell and Yun. This work is published from: United States.
    </p>

    <div class="art-gallery" id="imageContainer"></div>
  </div>

  <script>
    var imageUrls = [];
    for (var i = 0; i < 400; i++) {
      imageUrls.push('/images/collections/primera/' + i + '.png');
    }

    // Shuffle and pick a subset for the hero carousel
    var shuffled = imageUrls.slice().sort(function() { return 0.5 - Math.random(); });
    var slides = shuffled.slice(0, 6);
    var currentSlide = 0;

    var slideshow = document.getElementById('slideshow');
    var dotsContainer = document.getElementById('slideshowDots');
    var dots = [];

    slides.forEach(function(url, i) {
      var img = document.createElement('img');
      img.src = url;
      img.alt = 'Primera ' + i;
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

    // Full gallery
    var container = document.getElementById('imageContainer');
    imageUrls.forEach(function(url, i) {
      var img = document.createElement('img');
      img.setAttribute('data-src', url);
      img.className = 'lazy';
      img.alt = 'Primera ' + i;
      container.appendChild(img);
    });
  </script>
 
 <div class="footer mt-5">
    <?php include '../footer.php'; ?>
 </div>
</body>
</html>
