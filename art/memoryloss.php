<!DOCTYPE html>
<html lang="en">
<head>
   <?php include '../meta.php'; ?>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
          document.title = "Andrew Mitchell - Memory Loss";

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
    <h1 class="light-text"><em>Memory Loss</em></h1>
    <p class="date light-text"><em>2023</em></p>

    <div class="btn-row">
      <a href="/collections/memory-loss/" target="_blank" class="view-tokens-btn light-text" onclick="event.preventDefault(); var mode = new URLSearchParams(window.location.search).get('mode') || '0'; window.open('/collections/memory-loss/?mode=' + mode, '_blank');">
        View All Tokens →
      </a>
    </div>

    <?php
      // Shuffle images 0-255
      $images = range(0, 255);
      shuffle($images);
      $slideImages = array_slice($images, 0, 6);
      $displayImages = array_slice($images, 0, 60);
    ?>

    <div class="preview-grid" id="slideshow">
      <?php foreach ($slideImages as $i => $num):
        $filename = sprintf("%03d.png", $num);
      ?>
        <img src="/images/collections/memoryloss/<?php echo $filename; ?>" alt="Memory Loss #<?php echo $num; ?>">
      <?php endforeach; ?>
    </div>

    <p class="description light-text">
      256 unique pieces, created with with Javascript and <a href="https://p5js.org/" target="_blank">p5.js</a>, and minted on Ethereum.
With Memory Loss I wanted to create something that would be simple and open to the interpretation and imagination of the viewer. Like an old memory, a place only in dreams. Presented by <a href="https://www.proof.xyz/exhibitions/diamond/memory-loss" target="_blank">Proof</a> and deployed on <a href="https://www.artblocks.io/" target="_blank">Art Blocks Engine</a>.
      <br><br>
      Secondary market on <a href="https://opensea.io/collection/memory-loss-by-andrew-mitchell" target="_blank" title="Opensea">Opensea</a>.
    </p>

    <div class="contract-details light-text">
      The code, which is 7,666 characters long, is stored on an Ethereum smart contract <a target="_blank" href="https://etherscan.io/address/0x1353fd9d3dc70d1a18149c8fb2adb4fb906de4e8#readContract#F38" title="Etherscan">here</a>.
      Querying "projectScriptByIndex" with 13 as the "_projectId" and 0 as the "index" will return the script.
      <br><br>
      <img src="https://images.squarespace-cdn.com/content/637d087cfeae7764854916c4/8dbdc803-2324-4731-a948-81f780bfbccf/Screenshot%2B2024-06-30%2Bat%2B4.58.24%E2%80%AFPM.png?content-type=image%2Fpng" alt="Memory Loss Contract Details">
    </div>

    <div class="art-gallery" id="imageContainer">
      <?php foreach ($displayImages as $num):
        $filename = sprintf("%03d.png", $num);
      ?>
        <img data-src="/images/collections/memoryloss/<?php echo $filename; ?>" class="lazy" alt="Memory Loss #<?php echo $num; ?>">
      <?php endforeach; ?>
    </div>
  </div>

  <div class="footer mt-5">
    <?php include '../footer.php'; ?>
  </div>
</body>
</html>

