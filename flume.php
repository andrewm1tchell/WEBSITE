<!DOCTYPE html>
<html lang="en">
<head>
   <?php include '../meta.php'; ?>
   <script>
          document.title = "Andrew Mitchell - Flume";

       document.addEventListener('DOMContentLoaded', function() {
           document.querySelectorAll('a.nav-item.nav-link').forEach(function(el) {
               if (el.textContent.includes('ART')) el.style.textDecoration = 'underline';
           });
       });
   </script>
       <style>
.carousel {
    position: relative;
    width: 100%;
    overflow: hidden;
}
#carousel-iframe {
    min-height: 500px;
    height: 500px;
}
@media (max-width: 1200px) {
    #carousel-iframe {
        min-height: 0px;
        height: 250px;
    }
}
    </style>

</head>
<body>
 <div class="art-page">
    <h1 class="light-text"><em>Flume</em></h1>
    <p class="date light-text">2022</p>

    <div class="btn-row">
        <a href="/collections/flume/" target="_blank" class="view-tokens-btn light-text" onclick="event.preventDefault(); var mode = new URLSearchParams(window.location.search).get('mode') || '0'; window.open('/collections/flume/?mode=' + mode, '_blank');">
          View All Tokens →
        </a>
    </div>

    <div class="description light-text">
                Created with JavaScript and <a href="https://p5js.org/" target="_blank">p5.js</a>, and minted on Ethereum.

                These are all on-chain generative 1/1 artworks. These pieces are future-proof, and can always be pulled from an Ethereum smart contract. 
                
                <br><br>
                Read more about what it means to be on-chain, and find out how you can retrieve the code for these pieces <a target="_blank" href="https://medium.com/@mitchel1/the-rise-of-on-chain-1-1-generative-art-on-eth-7f663aa52736" title="Medium">here</a>.
    </div>

    <div class="contract-details light-text">
            <p class="text-center light-text">
                The main Flume contract is a Manifold <a href="https://manifold.xyz/" title="Manifold" target="_blank">contract</a>. The TokenUri of the Flume contract <a href="https://etherscan.io/address/0x1fa23513825f952afca07a603ac3f312ebee4ca9" target="_blank" title="Flume Contract">here</a> is overridden by these two extension contracts: <a target="_blank" href="https://etherscan.io/address/0x534514948a28bc76B8F2f2f6B6C1745329375710" title="Extension Contract">0x534514948a28bc76B8F2f2f6B6C1745329375710</a> and <a target="_blank" href="https://etherscan.io/address/0x9489bdad5e36d16051c93ab2200172083eeba057" title="Extension Contract">0x9489bdad5e36d16051c93ab2200172083eeba057</a>. 
                Additionally, the mint function for these tokens was called via the custom extension contracts. These two custom contracts are thus permanently connected to the Flume Manifold contract.
                <br>

                <br>
                  Secondary market on <a target="_blank" href="https://opensea.io/collection/flume-by-andrew-mitchell" title="Opensea">Opensea</a>.
                                  <br>
                                  <br>

                <em>The pieces you see below are all live  Javascript code running in your browser. They are not videos.</em>
            </p>
    </div>
    
    <div id="carousel" class="carousel">
        <div class="light-text" style="margin-bottom: 10px;">
            <button id="prev" class="mx-2"><<<</button>
            <button id="next" class="mx-2">>>></button>
        </div>
        <iframe id="carousel-iframe" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" frameborder="0" height="100%" sandbox="allow-scripts allow-same-origin" width="100%"></iframe>
        <div id="loader" class="loader"></div>
        <div class="light-text">
            <a id="carousel-link" href="#" target="_blank"><em id="carousel-title"></em></a>
        </div>
    </div>
</div>


 
 <div class="footer mt-5">
    <?php include '../footer.php'; ?>
 </div>
 <script>
   document.addEventListener('DOMContentLoaded', function() {
    const urls = [
         {
            src: "../live/flume/thingskeepfallingdown.php",
            title: "Things Keep Falling Down",
            link: "https://opensea.io/assets/ethereum/0x1fa23513825f952afca07a603ac3f312ebee4ca9/7"
        },
        {
            src: "../live/flume/locomotive.php",
            title: "Locomotive",
            link: "https://opensea.io/assets/ethereum/0x1fa23513825f952afca07a603ac3f312ebee4ca9/6"
        },
        {
            src: "../live/flume/reconnaissance.php",
            title: "Reconnaissance",
            link: "https://opensea.io/assets/ethereum/0x1fa23513825f952afca07a603ac3f312ebee4ca9/3"
        },
        {
            src: "../live/flume/weirdfishes.php",
            title: "Weird Fishes",
            link: "https://opensea.io/assets/ethereum/0x1fa23513825f952afca07a603ac3f312ebee4ca9/4"
        },
        {
            src: "../live/flume/whitewater.php",
            title: "Whitewater",
            link: "https://opensea.io/assets/ethereum/0x1fa23513825f952afca07a603ac3f312ebee4ca9/1"
        },
        {
            src: "../live/flume/acrosstheuniverse.php",
            title: "Across the Universe",
            link: "https://opensea.io/assets/ethereum/0x1fa23513825f952afca07a603ac3f312ebee4ca9/5"
        },
        {
            src: "../live/flume/platetectonics.php",
            title: "Plate Tectonics",
            link: "https://opensea.io/assets/ethereum/0x1fa23513825f952afca07a603ac3f312ebee4ca9/2"
        }
    ];

    let currentItem = 0;
    const totalItems = urls.length;

    // Function to update the iframe and link
    function updateCarousel() {
        document.getElementById('carousel-iframe').src = urls[currentItem].src;
        document.getElementById('carousel-title').textContent = urls[currentItem].title;
        document.getElementById('carousel-link').href = urls[currentItem].link;
    }

    // Initialize the carousel
    updateCarousel();

    // Next button event
    document.getElementById('next').addEventListener('click', function() {
        currentItem = (currentItem + 1) % totalItems;
        updateCarousel();
    });

    // Previous button event
    document.getElementById('prev').addEventListener('click', function() {
        currentItem = (currentItem - 1 + totalItems) % totalItems;
        updateCarousel();
    });
});


 </script>
</body>
</html>
