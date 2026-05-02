<!DOCTYPE html>
<html lang="en">
<head>
   <?php include '../meta.php'; ?>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
          document.title = "Andrew Mitchell - Necromancer";

       $(document).ready(function() {
           $("a.nav-item.nav-link:contains('ART')").css("text-decoration", "underline");
       });
   </script>
       <style>
         code {
            background-color: #f5f5f5;
            border-radius: 3px;
            padding: 2px 4px;
            font-family: "Courier New", Courier, monospace;
        }
    </style>
</head>
<body>
  <div class="art-page">
    <h1 class="light-text"><em>Necromancer</em></h1>
    <p class="date light-text"><em>2023</em></p>

    <div class="btn-row">
      <a href="/collections/necromancer/" target="_blank" class="view-tokens-btn light-text" onclick="event.preventDefault(); var mode = new URLSearchParams(window.location.search).get('mode') || '0'; window.open('/collections/necromancer/?mode=' + mode, '_blank');">
        View All Tokens →
      </a>
    </div>

    <div class="slideshow" id="slideshow"></div>
    <div class="slideshow-dots" id="slideshowDots"></div>

    <p class="description light-text">
      128 unique pieces, created with with Javascript and <a href="https://p5js.org/" target="_blank">p5.js</a>, and minted on Arbitrum, an Ethereum L2. Presented by <a href="https://www.prohibition.art" target="_blank">Prohibition</a> and deployed on <a href="https://www.artblocks.io/" target="_blank">Art Blocks Engine</a>. Towering trees, imbued with magical power, reach high into the sky, guarding the secret hidden within.
      <br><br>
      Secondary market on <a href="https://opensea.io/collection/necromancer-by-andrew-mitchell" target="_blank" title="Opensea">Opensea</a>.
    </p>

    <div class="contract-details light-text">
      The code, which is 22,208 characters long, is stored on an Arbitrum smart contract <a target="_blank" href="https://arbiscan.io/address/0x47A91457a3a1f700097199Fd63c039c4784384aB#readContract#F38" title="Etherscan">here</a>.
      Querying "projectScriptByIndex" with 2 as the "_projectId" and 0 as the "index" will return the script.
      <br><br>
      <img src="https://images.squarespace-cdn.com/content/637d087cfeae7764854916c4/9bea9913-de72-43e0-b6d7-48c3c3ac5eaa/Screenshot+2024-06-30+at+11.43.56%E2%80%AFPM.png?content-type=image%2Fpng" alt="Necromancer Contract Details">
    </div>
    <div class="light-text">
      <img src="https://miro.medium.com/v2/resize:fit:1400/format:webp/1*yxqt_yxOrXT2RpSts4Bnfg.png" alt="Necromancer Sketch" style="max-width: 100%;">
      <p style="text-align: center;">
        This project began as a simple sketch of some parallel lines. It began to look as though I was standing in a forest looking uphill at the trees. <br>The code for this initial sketch is below:
      </p>
            <code class="text-center light-text">
                function setup() {
  createCanvas(1000, 400);
  noFill();
  pixelDensity(4);
  background("#fdfff5");
  stroke("#252321");
    curveTightness(-2);

}

function draw() {
  background("#fdfff5");
  let x = 100;
  let y2 = 50;
  let y = 266;
  let w = 4;
  let h = 20;
  let t = -10;
  let segments = (500-y2)/h;
  let s = w+10;
  for(let x = s/2; x < width; x+=s*2) {
    for(let i = 0; i > -h*segments; i-=h+h/10){
      push();
      translate(x,y+i);
      scale((y/height),1);
      translate(-x,-y-i);
      stroke("#363330");
      drawTreeTrunk(x,y+i,w,h,t,3*(y/height),10);
      stroke("#fdfff5");
      drawTreeTrunk(x,y+i,w,h,t,2*(y/height),10);
      stroke("#363330");
      drawTreeTrunk(x,y+i,w,h,t,1*(y/height),10);
      pop();
    }
  }
  y += 45;
  for(let x = s+s/1.25; x < width; x+=s*2) {
    let yInit = y;
    y += (Math.random() < .5 ? -1 : 1) * Math.random()*50;
    for(let i = 0; i > -h*segments; i-=h+h/10){
      push();
      translate(x,y+i);
      scale((y/height),1);
      translate(-x,-y-i);
      stroke("#201F1D")
      drawTreeTrunk(x,y+i,w,h,t,4*(y/height),15);
      stroke("#fdfff5");
      drawTreeTrunk(x,y+i,w,h,t,2*(y/height),15);
      stroke("#201F1D")
      drawTreeTrunk(x,y+i,w,h,t,1*(y/height),15);
      pop();
    }
    y = yInit;
  }
  y += 30;
  for(let x = s; x < width; x+=s*2) {
    let yInit = y;
    y += (Math.random() < .5 ? -1 : 1) * Math.random()*50;
    for(let i = 0; i > -h*segments; i-=h+h/10){
      let iInit = i;
      i += Math.random()*3;
      push();
      translate(x,y+i);
      scale((y/height),1);
      translate(-x,-y-i);
      stroke("#151513")
      drawTreeTrunk(x,y+i,w,h,t,5*(y/height),20);
      stroke("#fdfff5");
      drawTreeTrunk(x,y+i,w,h,t,2*(y/height),20);
      stroke("#151513")
      drawTreeTrunk(x,y+i,w,h,t,1*(y/height),20);
      pop();
      i = iInit;
    }
    y = yInit;
  }
  noLoop();
}

function drawTreeTrunk(x,y,w,h,t,weight,steps) {
  let x1 = x;
  let x2 = x+(w/3);
  let x3 = x+(2*(w/3));
  let x4 = x+w;
  let y1 = y;
  let y2 = y-sin(PI/4)*t;
  let y3 = y-sin(PI/4)*t;
  let y4 = y;
  if(Math.random()>.5) {
    strokeWeight(noise(x1,y2));
    bezier(x1,y1,x2,y2,x3,y3,x4,y4);
    bezier(x1,y1-h,x2,y2-h,x3,y3-h,x4,y4-h);
  }
  beginShape();
  for(let i = 0; i <= steps; i++) {
    push();
    let m = i/steps;
    let bX = bezierPoint(x1,x2,x3,x4,m);
    let bY = bezierPoint(y1,y2,y3,y4,m);
    let bTX = bezierTangent(x1,x2,x3,x4,m);
    let bTY = bezierTangent(y1,y2,y3,y4,m);
    if(i === 0 || i === steps){
      strokeWeight(weight);
    } else {
      translate(bX,bY);
      shearX(radians((noise(x,y) < .3 ? -1 : 1)*(noise(i))*5));
      translate(-bX,-bY);
      strokeWeight(noise(bX,bY)*weight);
    }
    curveVertex(bX,bY)
    curveVertex(bX,bY-h);
    pop();
  }
  endShape();
}
            </code>
    </div>

    <div class="art-gallery" id="imageContainer"></div>

  <script>

const imageUrls = [
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000000.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000001.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000002.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000003.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000004.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000005.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000006.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000007.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000008.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000009.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000010.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000011.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000012.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000013.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000014.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000015.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000016.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000017.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000018.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000019.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000020.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000021.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000022.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000023.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000024.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000025.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000026.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000027.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000028.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000029.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000030.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000031.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000032.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000033.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000034.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000035.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000036.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000037.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000038.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000039.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000040.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000041.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000042.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000043.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000044.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000045.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000046.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000047.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000048.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000049.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000050.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000051.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000052.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000053.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000054.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000055.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000056.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000057.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000058.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000059.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000060.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000061.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000062.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000063.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000064.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000065.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000066.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000067.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000068.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000069.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000070.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000071.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000072.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000073.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000074.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000075.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000076.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000077.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000078.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000079.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000080.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000081.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000082.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000083.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000084.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000085.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000086.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000087.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000088.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000089.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000090.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000091.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000092.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000093.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000094.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000095.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000096.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000097.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000098.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000099.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000100.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000101.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000102.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000103.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000104.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000105.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000106.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000107.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000108.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000109.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000110.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000111.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000112.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000113.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000114.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000115.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000116.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000117.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000118.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000119.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000120.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000121.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000122.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000123.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000124.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000125.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000126.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000127.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000128.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000129.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000130.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000131.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000132.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000133.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000134.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000135.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000136.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000137.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000138.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000139.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000140.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000141.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000142.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000143.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000144.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000145.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000146.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000147.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000148.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000149.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000150.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000151.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000152.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000153.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000154.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000155.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000156.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000157.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000158.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000159.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000160.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000161.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000162.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000163.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000164.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000165.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000166.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000167.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000168.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000169.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000170.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000171.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000172.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000173.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000174.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000175.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000176.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000177.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000178.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000179.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000180.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000181.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000182.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000183.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000184.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000185.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000186.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000187.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000188.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000189.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000190.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000191.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000192.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000193.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000194.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000195.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000196.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000197.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000198.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000199.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000200.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000201.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000202.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000203.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000204.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000205.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000206.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000207.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000208.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000209.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000210.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000211.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000212.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000213.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000214.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000215.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000216.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000217.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000218.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000219.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000220.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000221.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000222.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000223.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000224.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000225.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000226.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000227.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000228.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000229.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000230.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000231.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000232.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000233.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000234.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000235.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000236.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000237.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000238.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000239.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000240.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000241.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000242.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000243.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000244.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000245.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000246.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000247.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000248.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000249.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000250.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000251.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000252.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000253.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000254.png",
    "https://prohibition-arbitrum-2.s3.amazonaws.com/2000255.png"
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
      img.alt = 'Necromancer ' + i;
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
    var container = document.getElementById('imageContainer');
    imageUrls.forEach(function(url, i) {
      var img = document.createElement('img');
      img.setAttribute('data-src', url);
      img.className = 'lazy';
      img.alt = 'Necromancer ' + i;
      container.appendChild(img);
    });

  </script>
  </div>
 
  <div class="footer mt-5">
    <?php include '../footer.php'; ?>
  </div>
</body>
</html>
