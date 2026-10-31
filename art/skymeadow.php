<!DOCTYPE html>
<html lang="en">
<head>
   <?php include '../meta.php'; ?>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
          document.title = "Andrew Mitchell - Sky Meadow";

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
    <h1 class="light-text"><em>Sky Meadow</em></h1>
    <p class="date light-text"><em>2022</em></p>

    <div class="btn-row">
      <a href="/collections/sky-meadow/" target="_blank" class="view-tokens-btn light-text" onclick="event.preventDefault(); var mode = new URLSearchParams(window.location.search).get('mode') || '0'; window.open('/collections/sky-meadow/?mode=' + mode, '_blank');">
        View All Tokens →
      </a>
    </div>

    <?php
    $carouselImages = range(1, 555);
    shuffle($carouselImages);
    $carouselImages = array_slice($carouselImages, 0, 6);
    ?>
    <div class="preview-grid" id="slideshow">
    <?php foreach ($carouselImages as $num): ?>
      <img src="/images/skymeadow/<?php echo $num; ?>.png" alt="Sky Meadow #<?php echo $num; ?>">
    <?php endforeach; ?>
    </div>

    <p class="description light-text">
      Sky Meadow is an on-chain generative artwork built using JavaScript and <a href="https://p5js.org/" target="_blank">p5.js</a>, and minted on Ethereum.
      Named after a place of lush beauty nested deep in the heart of Virginia.
      Each piece is unique and uses its own individual seed value, generated at the time of creation.
      <br><br>
      Secondary market on <a target="_blank" href="https://opensea.io/collection/sky-meadow-by-andrew-mitchell" title="OpenSea">OpenSea</a>.
      <!--Explore the entire 555 piece collection on <a target="_blank" href="https://deca.art/collection/sky-meadow-by-andrew-mitchell" title="Deca">Deca</a>.-->
    </p>

    <div class="contract-details light-text">
      The code, which is ~50,000 characters long, is stored on an Ethereum smart contract called <a target="_blank" href="https://etherscan.io/address/0x534514948a28bc76B8F2f2f6B6C1745329375710#readContract#F8" title="Etherscan">MitchellsExtension.sol</a>.
    </div>
    
    <p class="light-text">
      The live render of any Sky Meadow is easily available to explore <a href="https://wcm7rmmdt7zzvxyheo7mjtwgjwqt5mkwq6scro32xre6th3pbfta.arweave.net/sJn4sYOf85rfByO-xM7GTaE-sVaHpCi7erxJ6Z9vCWY?hash=0xce93b1d6451893bb86c6fd394869badd4863104cc72dad51f5c43e65b6c887fe&number=81" target="_blank" title="Live Render">here</a>. You just need to change the parameters hash and number in the URL to the values of your desired Sky Meadow.
    </p>

    <div class="art-gallery" id="imageContainer">
    <?php
    $galleryImages = range(1, 555);
    shuffle($galleryImages);
    foreach ($galleryImages as $num):
    ?>
      <img data-src="/images/skymeadow/<?php echo $num; ?>.png" class="lazy" alt="Sky Meadow #<?php echo $num; ?>">
    <?php endforeach; ?>
    </div>

    <div>
        Additionally, the name, unique hash, and attributes for each piece are stored on that same contract. 
      Querying "GetScriptChunk" with the Sky Meadow contract address as the "creator" (0x8452ee9a2fc4e80c53b33a2b38824c7976744521), 1 as the "series", and 0 as the "index", will return a guide for how to view this data:
      <br><br>
      <img src="https://images.squarespace-cdn.com/content/637d087cfeae7764854916c4/f6947373-c668-4ad1-b068-3efd180bfdae/Screenshot+2024-06-25+at+11.56.21%E2%80%AFPM.png?content-type=image%2Fpng" alt="Sky Meadow Contract Details">
      <br><br>
      The main Sky Meadow contract is a Manifold <a href="https://manifold.xyz/" title="Manifold" target="_blank">contract</a>. The TokenUri of the SkyMeadow.sol contract <a href="https://etherscan.io/address/0x8452ee9a2fc4e80c53b33a2b38824c7976744521" target="_blank" title="Sky Meadow Contract">here</a> is overridden by the extension contract <a target="_blank" href="https://etherscan.io/address/0x534514948a28bc76B8F2f2f6B6C1745329375710" title="Extension Contract">here</a>. 
      Additionally, the mint function for these tokens was called via the custom extension contract. This allowed me to generate a unique hash at mint-time before calling the overriden mint function. This permanently connects the custom extension contract to the Sky Meadow Manifold contract.
      <br><br>
      Finally, there is a <a target="_blank" href="https://etherscan.io/address/0xB666C3F49A462C2DDBC2bdc5A99d3828704Daa7C#readContract#F8" title="Etherscan">SkyMeadowWrapper.sol</a> contract which is a wrapper for the MitchellsExtension.sol contract and an onchain p5.js library contract. SkyMeadowWrapper.sol allows you to get the HTML for a Sky Meadow NFT onchain for as long as Ethereum exists. This utilizes the p5js code on the MitchellsExtension.sol and an onchain version of <a target="_blank" href="https://etherscan.io/address/0x16cc845d144A283D1b0687FBAC8B0601cC47A6C3#readContract#F8" title="Etherscan">p5js</a> to create html.
      <br><br>
      <img src="../images/SkyMeadowWrapper.sol.png" alt="Sky Meadow Contract Details">
    </div>
 </div>
 
 <div class="footer mt-5">
    <?php include '../footer.php'; ?>
 </div>
</body>
</html>
