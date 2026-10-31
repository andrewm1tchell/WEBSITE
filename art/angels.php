<!DOCTYPE html>
<html lang="en">
<head>
   <?php include '../meta.php'; ?>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/ethers@6.13.4/dist/ethers.umd.min.js"></script>
   <script src="/collections/rpc-config.php"></script>
   <script>
       document.title = "Andrew Mitchell - Angels";
       $(document).ready(function() {
           $("a.nav-item.nav-link:contains('ART')").css("text-decoration", "underline");
       });
   </script>
   <style>
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

       .live-render {
           text-align: left;
           margin: 30px 0;
       }
       .live-render iframe {
           display: block;
           margin: 0;
           width: min(100%, 80vh, 800px);
           aspect-ratio: 1 / 1;
           height: auto;
           max-height: 80vh;
           border: 1px solid currentColor;
           background: transparent;
       }
       .live-render .live-render-status {
           font-size: 12px;
           opacity: 0.7;
           margin-top: 8px;
       }
   </style>
</head>
<body class="fade-in-fast dark-bg show">
  <div class="art-page">
    <h1 class="light-text"><em>Angels</em></h1>
    <p class="date light-text"><em>2026</em></p>

    <div class="btn-row">
        <a href="https://www.thevessel.fun/view" target="_blank" class="view-tokens-btn light-text" style='color:chartreuse'>
        Click to Mint 
      </a><br><br>
      <a href="https://andrewmitchell-art.xyz/collections/angels/1.html" target="_blank" class="view-tokens-btn light-text" onclick="event.preventDefault(); var mode = new URLSearchParams(window.location.search).get('mode') || '0'; window.open('/collections/angels/1.html?mode=' + mode, '_blank');">
        View Token →
      </a><br><br>
      <a href="https://andrewmitchell-art.xyz/ethereum/vessel/" target="_blank" class="view-tokens-btn light-text">
        Play →
      </a>
    </div>

    <div class="live-render">
      <iframe id="angels-live-render" title="Angels Live Artwork"></iframe>
      <p class="light-text live-render-status" id="angels-live-render-status">Loading live artwork from chain…</p>
    </div>

    <script>
      (async function () {
        var RPC_URL = (window.RPC_URLS || {}).ethereum;
        var CONTRACT_ADDRESS = '0x1b64CF0d027f22D3aD76De00EA2fdC0aE7e53e8e';
        var TOKEN_ID = 10;
        var ABI = ['function getHtml(uint256 tokenId) view returns (string)'];

        var iframe = document.getElementById('angels-live-render');
        var status = document.getElementById('angels-live-render-status');

        try {
          var provider = new ethers.JsonRpcProvider(RPC_URL);
          var contract = new ethers.Contract(CONTRACT_ADDRESS, ABI, provider);
          var htmlBase64 = await contract.getHtml(TOKEN_ID);

          iframe.src = htmlBase64.indexOf('data:') === 0
            ? htmlBase64
            : 'data:text/html;base64,' + htmlBase64;
          status.style.display = 'none';
        } catch (err) {
          console.error('Failed to load live Angels render:', err);
          status.textContent = 'Live render unavailable right now.';
        }
      })();
    </script>

    <p class="description light-text">
      A fully onchain work written in vanilla Javascript. No external libraries. Sequence 010 of <a href="https://www.thevessel.fun/home" target="_blank">The Vessel</a>, an onchain ecosystem and living artwork created by <a href="https://x.com/stephensantoro_" target="_blank">Stephen Santoro</a> and <a href="https://x.com/producedbydav" target="_blank">Dav</a> <3<3<3<3<3.
      <br><br>
      Secondary market on <a href="https://opensea.io/item/ethereum/0x9423548a957284ed17e55c37c4b6d96e5e63065f/10" target="_blank" title="Opensea">Opensea</a>.
    </p>

<!--<details class="light-bg-transparent dark-border-full">-->
<!--    <summary class="light-text">Contract Details 🥱 (yawn)</summary>-->
<!--    <br/>-->
<!--    <div class="row">-->
<!--        <div class="col-1"></div>-->
<!--        <div class="col-10 p-0">-->
<!--            <p class="light-text text-left">-->
<!--                <img src='/images/angels/Diagram.jpg' style='width:100%;height:auto;'>-->

<!--            <h3 class="light-text"><span class="contract-name"><a target="_blank" class="contract-link light-text" href="https://etherscan.io/address/0x9423548a957284ed17e55c37c4b6d96e5e63065f#code">Vessel (THE_VESSEL_sequences)</a></span></h3>-->
<!--            <p class="light-text">The main ERC-1155 contract that handles minting and orchestrates metadata and rendering.</p>-->

<!--            <h3 class="light-text"><span class="contract-name"><a target="_blank" class="contract-link light-text" href="https://etherscan.io/address/0x3e39962390ac7721c4593abe52806bf98e9e4ab0#code">ScriptStorage.sol</a></span></h3>-->
<!--            <p class="light-text">Stores the fully onchain JavaScript source that renders the artwork.</p>-->

<!--            <h3 class="light-text"><span class="contract-name"><a target="_blank" class="contract-link light-text" href="https://etherscan.io/address/0x6a2db974444eb4181e324c50821a07acf9bfb7c9#code">MetadataRenderer.sol</a></span></h3>-->
<!--            <p class="light-text">Builds the token's metadata JSON, including its name, description, and attributes.</p>-->

<!--            <h3 class="light-text"><span class="contract-name"><a target="_blank" class="contract-link light-text" href="https://etherscan.io/address/0x7608748FabA7E925C64Fd8879F0DE88fa63846f4#code">AnimationRenderer.sol</a></span></h3>-->
<!--            <p class="light-text">Assembles the animation_url page that runs the onchain script for the live render.</p>-->

<!--            <h3 class="light-text"><span class="contract-name"><a target="_blank" class="contract-link light-text" href="https://etherscan.io/address/0x6017a31f9790e5d3acbe634630ab00f47fea1b40#code">MinuteSeedProvider.sol</a></span></h3>-->
<!--            <p class="light-text">Derives a new deterministic seed every 60 seconds, driving the artwork's evolving appearance.</p>-->

<!--            <h3 class="light-text"><span class="contract-name"><a target="_blank" class="contract-link light-text" href="https://etherscan.io/address/0x744e75a3d254172269944a2e3bb89b663aa89683#code">SvgImageRenderer.sol</a></span></h3>-->
<!--            <p class="light-text">Renders a static SVG preview of the artwork's current onchain state.</p>-->

<!--            <h3 class="light-text"><span class="contract-name"><a target="_blank" class="contract-link light-text" href="https://etherscan.io/address/0x1b64cf0d027f22d3ad76de00ea2fdc0ae7e53e8e#code">VesselRenderer.sol</a></span></h3>-->
<!--            <p class="light-text">Main rendering entry point that coordinates the other renderer contracts.</p>-->

<!--            <h3 class="light-text"><span class="contract-name"><a target="_blank" class="contract-link light-text" href="https://etherscan.io/address/0xb22af95fceeb5e3f96944042f687684e02504bd7#code">StaticImageRenderer.sol</a></span></h3>-->
<!--            <p class="light-text">Generates a static raster preview image for the token.</p>-->

<!--            <h3 class="light-text"><span class="contract-name"><a target="_blank" class="contract-link light-text" href="https://etherscan.io/address/0xFf91EDfBD3eC3867DD9a68B8bBfde09F002Daceb#code">SeedRegistry.sol</a></span></h3>-->
<!--            <p class="light-text">Stores seeds submitted and saved onchain by collectors for others to enjoy.</p>-->

<!--            <br><br>-->
<!--            </p>-->
<!--        </div>-->
<!--        <div class="col-1"></div>-->
<!--    </div>-->
<!--</details>-->
<br><br>
  </div>


  <div class="footer mt-5">
    <?php include '../footer.php'; ?>
  </div>
</body>
</html>
