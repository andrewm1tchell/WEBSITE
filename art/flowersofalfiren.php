<!DOCTYPE html>
<html lang="en">
<head>
   <?php include '../meta.php'; ?>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
          document.title = "Andrew Mitchell - Flowers of Alfiren";

       $(document).ready(function() {
           $("a.nav-item.nav-link:contains('ART')").css("text-decoration", "underline");
       });
   </script>
</head>
<body>
  <div class="art-page">
    <h1 class="light-text"><em>Flowers of Alfiren</em></h1>
    <p class="date light-text"><em>2023</em></p>

    <div class="btn-row">
      <a href="/collections/flowers-of-alfiren/" target="_blank" class="view-tokens-btn light-text" onclick="event.preventDefault(); var mode = new URLSearchParams(window.location.search).get('mode') || '0'; window.open('/collections/flowers-of-alfiren/?mode=' + mode, '_blank');">
        View All Tokens →
      </a>
    </div>

    <img class="light-text" src="https://images.squarespace-cdn.com/content/637d087cfeae7764854916c4/7141006c-7361-4016-8070-c20236444a12/Orange-FlowersofAlfiren2.jpg?content-type=image%2Fjpeg" alt="Durango" style="width: 50%; display: block; border: 1px solid currentColor;">
    <p class="light-text" style="margin-top: 0.5rem;"><a href="https://foundation.app/mint/eth/0x3a0401641cABDcD0E695918F6d21163C4BCBc117/2" target="_blank"><em>Durango</em></a></p>

    <p class="description light-text">
      86 surreal gardenscapes created via a generative algorithm written in JavaScript and <a href="https://p5js.org/" target="_blank">p5.js</a>, and minted on Ethereum. Presented by <a href="https://www.vertufineart.com/" target="_blank">Vertu Fine Art</a>.
      <br><br>
      Secondary market on <a href="https://opensea.io/collection/flowers-of-alfiren" target="_blank" title="Opensea">Opensea</a>.
    </p>

    <div>
      <img class="lazy" data-src="https://images.squarespace-cdn.com/content/637d087cfeae7764854916c4/79776134-233b-4b79-aa0e-64f5568ae82a/F8B-aIQWYAAcIzz.jpeg?content-type=image%2Fjpeg" alt="Art on Paper" style="max-width: 80%;">
      <p class="light-text" style="margin-top: 0.5rem;">Sold at <a href="https://ny.thepaperfair.com/" target="_blank">Art on Paper NYC</a>.</p>
    </div>
    
    <div class="contract-details light-text">
      The code, which is 57,199 characters long, is stored on an Ethereum smart contract <a target="_blank" href="https://etherscan.io/address/0x9489bdad5e36d16051c93ab2200172083eeba057#readContract#F5" title="Etherscan">here</a>. 
      Querying "GetScriptChunk" with 0x8E85815D9C6360e414F93483A3533D8172DCeC27 as the "creator", 1 as the "series", and 0 or 1 as the "index" will return the script.
      <br><br>
      <img src="https://images.squarespace-cdn.com/content/637d087cfeae7764854916c4/e0fe6345-c6a6-4be0-b303-ba6d9a3e3137/Screenshot%2B2024-06-29%2Bat%2B1.07.19%E2%80%AFAM.png?content-type=image%2Fpng" alt="Flowers of Alfiren Contract Details">
      <br><br>
      Additionally, the a live render of the script is available to view on <a href="https://irgeutoujrfsrznqfhcbsjfglehgnux7mlkr3hp6cfsfwssr5awq.arweave.net/RExKTdRMSyjlsCnEGSSmWQ5m0v9i1R2d_hFkW0pR6C0" title="Extension Contract">here</a>. It will give you a deeper insight into my process.
    </div>
    <div class="light-text">
      <p>
        Here is a little more information about how the script works:
      </p>
      <ol>
        <li>
          Draw each organism in a black box. The organisms I use here took the last year to create. The flowers themselves are comprised of hundreds of individual curves, drawn in a series of loops. To say it simply, these loops move from ~ 0 to ~2*PI. The geometric functions of cosine, sine, and tangent are used to draw curves rotationally around the center of the flower. Of the 86 pieces, there are 7 flower genus: 24 Echinacea, 19 Adenium, 14 Zinnia, 11 Camleia, 8 Magnolia, 6 Zephyranthes, and 6 Chrysanthemum.
        </li>
        <li>
          Drawing these organisms as well as any other textures to the canvas. When I say canvas, I am talking about a digital canvas on an HTML page. In HTML: &lt;canvas&gt; &lt;/canvas&gt;.
        </li>
        <li>
          Trial and error, constantly changing the formula. In simplest terms, the formula for placing the flowers uses a custom scaled noise field. I found success on ignoring gravity, increasing the crowdedness of flowers towards the center of each piece.
        </li>
        <li>
          Once I have a formula for placing all my digital paint strokes. I focus on creating layers. There are three main layers, background, color, and skeleton, each made up of many sub layers.
        </li>
      </ol>
    </div>
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px;">
      <div>
        <img class="lazy" data-src="https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/998f1d05-dd09-4723-a8a3-d4133b3df637/download+%281%29.png?format=1500w" alt="Background Layer" style="max-width: 100%;">
        <div>Background</div>
      </div>
      <div>
        <img class="lazy" data-src="https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/653218d6-f2b9-4aae-9084-349ebdbcf3fb/download+%282%29.png?format=1500w" alt="Skeleton Layer" style="max-width: 100%;">
        <div>Color</div>
      </div>
      <div>
        <img class="lazy" data-src="https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/257bcbde-43f5-407b-b692-b3bc9804e7fa/download+%283%29.png?format=1500w" alt="Color Layer" style="max-width: 100%;">
        <div>Skeleton</div>
      </div>
      <div>
        <img class="lazy" data-src="https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/d0fc1dfe-6c20-4fe3-a4c8-be3349773c06/download.png?format=1500w" alt="Final" style="max-width: 100%;">
        <div>Final</div>
      </div>
    </div>

    <div class="art-gallery" id="imageContainer"></div>

  <script>

        const imageUrls = ["https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/a1614daa-4a16-40f7-9747-23985531a217/Blue-FlowersofAlfirin2.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/97586de0-2fa5-4808-9847-c8aba98b9f5c/Blue-FlowersofAlfirin4.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/f4691bcb-c841-43df-85e9-c20397b63cd8/Blue-FlowersofAlfirin12.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/bcdb544c-a0df-412e-9957-b21dced7105d/Blue-FlowersofAlfirin5.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/03a43ba7-a242-4c5f-9307-e8da19b992ff/Blue-FlowersofAlfirin6.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/4aab9b34-3d25-465f-abca-08b879d3fd5c/Blue-FlowersofAlfirin7.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/98714b92-95d7-460a-bd9f-5a1238d95575/Blue-FlowersofAlfirin8.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/05835cc4-00eb-4996-b213-b4960954de74/Blue-FlowersofAlfirin9.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/565cb028-d9a8-4b28-88d3-1e28ee49a7bf/Blue-FlowersofAlfirin3.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/a61198ac-590d-4b3e-8b30-239a6899c690/Blue-FlowersofAlfirin10.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/115a8698-659f-43c8-9b50-5be14dff182c/FoA17.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/70b2f5b0-d011-416d-aae2-0cc3b50aadd8/Blue-FlowersofAlfirin11.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/159e714f-1a5f-45b7-89d8-cad79d4e993c/Blue-FlowersofAlfirin13.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/c2be01c0-1910-4631-b3c8-516aaee86ac6/Blue-FlowersofAlfirin14.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/120471f5-4c77-4d94-8885-1d720794c14a/Blue-FlowersofAlfirin15.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/72e0b672-09e3-4475-86ab-f15bc1f5463c/Blue-FlowersofAlfirin17.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/cc8c700f-9206-4cc5-ba3f-8f4e08328b69/Blue-FlowersofAlfirin18.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/48654472-b7fb-47b4-86c6-fedbf9e3d0b2/Green-FlowersofAlfirin1.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/7763d1a0-8901-4a4a-81e2-a089f6637b50/Green-FlowersofAlfirin2.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/4eec5b8d-4291-43a6-b1ce-0dc397a65578/Green-FlowersofAlfirin3.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/5d2791ce-8ed0-43e4-bade-36e61223a8e1/Green-FlowersofAlfirin4.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/ca17d9c9-72a6-46d7-b66a-b101dd81179c/Green-FlowersofAlfirin5.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/d6ac84e3-c83c-42ce-9951-cc814e3a8d52/Green-FlowersofAlfirin6.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/3db47767-6a9c-48fe-bf27-cdc3cf02b529/Green-FlowersofAlfirin7.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/9e88a724-c0ea-4e2a-9338-487997d7499e/Green-FlowersofAlfirin8.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/d707941b-d17b-4ea5-a9b7-286433b934eb/FoA22.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/f3766bef-debb-473d-8490-8bae0ebcc713/Green-FlowersofAlfirin9.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/05358460-eb7b-411d-ac31-af61bda5319d/FoA6.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/d3c8b7ea-cfbb-4db7-8972-04d07f25822a/Green-FlowersofAlfirin10.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/be2d08b8-29f1-4c81-8d69-7921f0891be9/Green-FlowersofAlfirin11.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/15333b99-797b-4094-a261-136d602c8096/Green-FlowersofAlfirin12.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/f8b16131-0f0c-4de6-b7f6-14efe1df46d3/Green-FlowersofAlfirin13.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/539143a2-1b0f-4de9-9c8f-ec4896306f47/Misc-FlowersofAlfirin1.jpg",
"https://f8n-production-collection-assets.imgix.net/0xfE0062a67615F40a7f21B6f2f446F2C15850dD7A/5/nft.png?auto=format%2Ccompress&q=70&cs=srgb&h=1200&w=1200&fnd_key=v1",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/1c648808-df6f-47c4-b0d4-61944f7a0c9f/Misc-FlowersofAlfirin2.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/987a755f-b7b6-43da-b148-cdf8aca71c3d/Misc-FlowersofAlfirin3.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/e1d588e1-f483-469a-b054-bc05094d2536/Misc-FlowersofAlfirin4.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/44fb117f-a282-45c7-b4b8-7e37043fe008/Misc-FlowersofAlfirin5.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/c314726b-e45a-46b1-a991-c22c14a44838/Misc-FlowersofAlfirin6.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/53074768-5e4f-4617-b0a5-b142e4715e22/Misc-FlowersofAlfirin7.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/082a0766-e7e6-4d32-bd60-2d985a3d2857/Misc-FlowersofAlfirin8.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/d3b34e67-bbef-4dea-9bc8-64dea2af42bb/Misc-FlowersofAlfirin9.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/8b9d36f2-f022-491f-8a47-87b8752cf2b4/Misc-FlowersofAlfirin10.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/2dda8894-04fa-45df-8d4f-8565c3ac3536/Misc-FlowersofAlfirin11.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/7c54b60e-0605-43b4-bf43-3603ad28d99d/178000186.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/8b4034c4-33b0-4727-a426-481950d1a57f/Misc-FlowersofAlfirin12.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/542d824b-bcf3-439a-9007-de45bbfda48d/Misc-FlowersofAlfirin13.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/3e4b2c27-b515-47be-9bbd-c8e942bb16bb/Misc-FlowersofAlfirin14.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/0be33426-6317-45b9-83f3-fd493efeaf17/Misc-FlowersofAlfirin15.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/cbe05ca0-71f3-43c3-80f8-e03f90d37aba/Misc-FlowersofAlfirin16.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/26eaab10-099d-4e8d-9bc3-830bc27f37a0/Misc-FlowersofAlfirin17.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/6b663b90-6395-4bd4-8981-b2184878e4f8/Misc-FlowersofAlfirin18.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/322499d9-6291-4c0f-b8d3-310a4afb5970/FoA20.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/f0ea0b54-4e15-4a2b-bcd2-0dcbb492e7ed/Misc-FlowersofAlfirin19.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/affa8269-c407-477c-92be-6954fb333e91/FoA21.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/852a3cf8-51e8-44a6-8199-437efc871b97/178000222.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/50fd8102-6d80-4a8b-8cf9-2d812fbbef24/FoA75.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/c4077fb4-047a-480d-a33e-643ca92ea954/178000127.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/f01be458-4571-4143-b0e0-7c3c7836c9a0/Misc-FlowersofAlfirin20.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/ec5b0b5e-8995-4ef6-a2e0-2e9468fcb27a/FoA16.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/21b980d3-8775-4bed-8dc9-7409a1c48616/Orange-FlowersofAlfirin1.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/923c10b2-ae05-430a-a48e-ed580ca8df25/Orange-FlowersofAlfirin3.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/a6776a3d-8ef1-42ff-9a59-aa03f94dbe38/Red-FlowersofAlfirin1.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/f9371a1f-a565-4736-84c5-9907b5312d59/Red-FlowersofAlfirin2.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/fe6d0038-5220-479d-81f0-013e246ea9dc/Red-FlowersofAlfirin3.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/71b4195c-eea7-49f1-a837-682f45a91537/Red-FlowersofAlfirin4.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/5c3699b2-292f-4eab-8818-ff9ffcad036d/FoA18.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/095b8b72-d6ea-4d6e-8f7e-6bd51cda6a23/Red-FlowersofAlfirin5.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/381eab5a-1661-4727-8a90-4f9b63e417ba/Red-FlowersofAlfirin6.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/056047e4-392c-45d7-ac25-f753864bfcf9/Red-FlowersofAlfirin7.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/7b2e8d6a-05ed-4100-98b3-819be62aee90/Tabiaa-123000758.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/1d30701c-3648-4d7b-9818-9608afe67ee4/Tabiaa-123000901.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/4a307eb9-6254-455b-8296-650cd6bc2b01/Yellow-FlowersofAlfirin1.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/20b4d1d0-ecf3-4bc1-a6df-20c379e6f9f9/Yellow-FlowersofAlfirin2.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/460ecca5-e184-4d18-84be-9a8c9377a880/Yellow-FlowersofAlfirin3.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/d459fe54-913b-4aa4-a7f7-88286340f6fe/Yellow-FlowersofAlfirin4.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/f79ca45c-7470-46bf-ba94-8550f321bb9d/Yellow-FlowersofAlfirin5.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/c87d4c49-ae4f-4739-9e7e-d3d465a37840/Yellow-FlowersofAlfirin6.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/72a0f9b8-d80d-4c16-b9b0-edf560f73b39/178000266.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/2fe161e5-47ab-4b91-9800-cb845769c47a/Yellow-FlowersofAlfirin8.jpg",


"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/3b07ff66-5c87-4e02-8638-d64e942062cd/FoA19.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/7cd45032-708c-427c-969c-1a131be12fe4/178000118.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/da2a8e0b-df78-488c-a1da-a2af50e90b2e/FoA23.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/cf62a0ee-afc5-4e5c-b37b-2887cb7284b5/Yellow-FlowersofAlfirin10.jpg",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/e7b1b4fc-6d73-49db-bde8-ebe3efd672f2/FoA24.jpg",



"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/d3453bbe-1c19-4e5d-82fc-402d33cb98b4/FoA42.png",
"https://images.squarespace-cdn.com/content/v1/637d087cfeae7764854916c4/5c694e72-0ef7-457f-9c8e-22684e8f7dd1/Yellow-FlowersofAlfirin7.jpg"];

    // Full gallery
    var container = document.getElementById('imageContainer');
    imageUrls.forEach(function(url, i) {
      var img = document.createElement('img');
      img.setAttribute('data-src', url);
      img.className = 'lazy';
      img.alt = 'Flowers of Alfiren ' + i;
      container.appendChild(img);
    });

  </script>
  </div>
 
  <div class="footer mt-5">
    <?php include '../footer.php'; ?>
  </div>
</body>
</html>
