<!DOCTYPE html>
<html lang="en">
<head>
   <?php include '../meta.php'; ?>
   <script>
          document.title = "Andrew Mitchell - Popup";

       document.addEventListener('DOMContentLoaded', function() {
           document.querySelectorAll('a.nav-item.nav-link').forEach(function(el) {
               if (el.textContent.includes('ART')) el.style.textDecoration = 'underline';
           });
       });
   </script>
       <style>
    .offcanvas-custom {
        position: fixed;
        top: 0;
        right: -700px; /* Initially offscreen */
        width: 700px;
        height: 100vh;
        background-color: #fff;
        box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
        transition: right 0.3s ease-in-out;
        z-index: 1045; /* Above other elements */
    }
.placeholder {
    min-height: 500px; /* Adjust this to approximate image height */
    display: flex;
    align-items: center;
    justify-content: center;
}.cropped-image {
    clip-path: inset(.5px);
}

.placeholder img {
    opacity: 0; /* Hide image until loaded */
    transition: opacity 0.3s ease-in-out; /* Smooth transition for the image load */
}

img:not(.lazy) {
    opacity: 1; /* Show fully loaded image */
}
    .offcanvas-custom.active {
        right: 0; /* Slide in from the right */
    }

    .offcanvas-header {
        display: flex;
        justify-content: space-between;
        padding: 1rem;
        border-bottom: 1px solid #ddd;
        background-color: #f8f9fa;
    }

    .offcanvas-body {
        padding: 1rem;
        overflow-y: auto;
    }

    .wrapped-svg-markup {
        white-space: pre-wrap;
        word-wrap: break-word;
        max-width: 100%;
        background-color: #f8f9fa;
        padding: 10px;
        border: 1px solid #ddd;
        overflow: auto;
        max-height: 97vh;
    }

    .btn-close {
        background: none;
        border: none;
        font-size: 1.5rem;
    }

    /* Timeline styles */
    .timeline-container {
        position: fixed;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        z-index: 1000;
        background: rgba(0, 0, 0, 0.7);
        padding: 5px;
        border-radius: 10px;
        color: #f8f9fa;
        font-size: 1em;
        max-width: 200px;
        text-align: center;
        transition: all 0.3s ease;
        opacity: 0;
        visibility: hidden;
    }

    .timeline-container.active {
        opacity: 1;
        visibility: visible;
    }

    .timeline-date {
        margin: 5px 0;
        padding: 5px;
        border-radius: 5px;
        transition: all 0.3s ease;
        opacity: 0;
        transform: translateY(20px);
    }

    .timeline-date.active {
        opacity: 1;
        transform: translateY(0);
        background-color: rgba(255, 255, 255, 0.2);
    }

    /* Palette styles */
    .palettes-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 25px;
        padding: 20px;
    }

    .palette {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 15px;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(5px);
    }

    .palette:hover {
        background: rgba(255, 255, 255, 0.08);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .palette-name {
        text-align: center;
        font-size: 1.2em;
        font-weight: 500;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        padding-bottom: 5px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .palette-colors {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        justify-content: center;
        padding: 5;
    }

    .palette-color {
        width: 20px;
        height: 20px;
        border-radius: 4px;
        border: 2px solid rgba(255, 255, 255, 0.2);
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .palette-color:hover {
        transform: scale(1.2);
        z-index: 1;
        border-color: #ffd700;
    }

    .palette-color::after {
        content: attr(title);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.8em;
        white-space: nowrap;
        opacity: 0;
        transition: opacity 0.2s ease;
        pointer-events: none;
    }

    .palette-color:hover::after {
        opacity: 1;
    }
    details {
  border-radius: 8px;

  padding: 1em;
  margin: 2em 0;
    margin-top: 1em;
  margin-bottom: 1em;
  color: white;
  transition: all 0.3s ease;
}

details[open] {
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
}

.image-grid {
    width:100%;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            padding: 20px;
        }

        .image-item {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }

        .image-item:hover {
            transform: scale(1.02);
        }

        .image-item img {
            width: 100%;
            height: 200px;
            display: block;
        }

        .image-index {
            position: absolute;
            top: 8px;
            left: 8px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            display:none;
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

.palettes-list {
  margin-top: 1em;
}
    </style>
</head>
<body>
  <div class="art-page">
    <h1 class="light-text"><em>Popup</em></h1>
    <p class="date light-text">2024</p>

    <div class="btn-row">
      <a href="/collections/popup/" target="_blank" class="view-tokens-btn light-text" onclick="event.preventDefault(); var mode = new URLSearchParams(window.location.search).get('mode') || '0'; window.open('/collections/popup/?mode=' + mode, '_blank');">
        View All Tokens →
      </a>
    </div>

    <p class="description light-text">
      Popup is <a href="https://onchainchecker.xyz/collection/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/1">on-chain</a>.
    </p>

    <div class="slideshow" id="slideshow"></div>
    <div class="slideshow-dots" id="slideshowDots"></div>

      <div id="imageGrid" class="image-grid">
        <!-- Images will be inserted here -->
    </div>
    <div class="light-text">
        <p class="light-text text-left">
        
        The Popup project consists of several smart contracts working together.
  <h3 class="light-text"><span class="contract-name"><a target="_blank" href="https://etherscan.io/address/0x981d04E3B2a88dd6674b16fFE65C8e050c3018fC#code">PopupExtension.sol</a></span></h3 class="light-text">
        <p class="light-text">The main contract that handles minting and metadata generation. This contract serves as the primary interface for users and integrates seamlessly with a Manifold contract to provide enhanced functionality and compatibility.</p>

        <h3 class="light-text"><span class="contract-name"><a target="_blank" href="https://etherscan.io/address/0xe6bf3b1c65f287b3ceb4e2df6921a05726dfa1d8#code">ColorEngine.sol</a></span></h3 class="light-text">
        <p class="light-text">Manages color palettes and color-related functionality throughout the system. The color engine will contain 114 color palettes after the mint is finished, 1 for each Popup. These palettes will exist permanently on the Ethereum blockchain and be utilizable by any other contracts.</p>
<div>

    <script>
        // Paste your imageUrls array here (from the previous script)
var imageUrls = [
    {
        "index": 1,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/13cd3a40e44ddbaa470406400948a5/4713cd3a40e44ddbaa470406400948a5.svg",
        "alt": "Item #1 Media",
        "filename": "image_001"
    },
    {
        "index": 2,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/b4149790482cd69bbcd9b22488d41e/19b4149790482cd69bbcd9b22488d41e.svg",
        "alt": "Item #2 Media",
        "filename": "image_002"
    },
    {
        "index": 3,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/2374cb25e18b11b44a0049900af7ad/882374cb25e18b11b44a0049900af7ad.svg",
        "alt": "Item #3 Media",
        "filename": "image_003"
    },
    {
        "index": 4,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/c083f1cc6ab8492def61c42316d1d9/bec083f1cc6ab8492def61c42316d1d9.svg",
        "alt": "Item #4 Media",
        "filename": "image_004"
    },
    {
        "index": 5,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/cca6dadc1914ac42fb469b31daf347/fecca6dadc1914ac42fb469b31daf347.svg",
        "alt": "Item #5 Media",
        "filename": "image_005"
    },
    {
        "index": 6,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/320ffc1969cf9191f35e8ef77c3d71/ca320ffc1969cf9191f35e8ef77c3d71.svg",
        "alt": "Item #6 Media",
        "filename": "image_006"
    },
    {
        "index": 7,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/681b8d01f8830555fc39fe53f0eb90/36681b8d01f8830555fc39fe53f0eb90.svg",
        "alt": "Item #7 Media",
        "filename": "image_007"
    },
    {
        "index": 8,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/6f757fb5e3b5c62780aadc060a1293/ad6f757fb5e3b5c62780aadc060a1293.svg",
        "alt": "Item #8 Media",
        "filename": "image_008"
    },
    {
        "index": 9,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/0db50907db5f1f76e47bc583af207d/730db50907db5f1f76e47bc583af207d.svg",
        "alt": "Item #9 Media",
        "filename": "image_009"
    },
    {
        "index": 10,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/f266986144a7e2bf759ab8955f0b49/05f266986144a7e2bf759ab8955f0b49.svg",
        "alt": "Item #10 Media",
        "filename": "image_010"
    },
    {
        "index": 11,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/6b3d69888f207fd1c384e460dc068f/ad6b3d69888f207fd1c384e460dc068f.svg",
        "alt": "Item #11 Media",
        "filename": "image_011"
    },
    {
        "index": 12,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/3c023b184b32dc603f71eb63663eb5/b83c023b184b32dc603f71eb63663eb5.svg",
        "alt": "Item #12 Media",
        "filename": "image_012"
    },
    {
        "index": 13,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/0b7dfc2dfbef2dc40e4ed3703817ba/a70b7dfc2dfbef2dc40e4ed3703817ba.svg",
        "alt": "Item #13 Media",
        "filename": "image_013"
    },
    {
        "index": 14,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/8d0425e9ea19962399c6a45c18ebbe/948d0425e9ea19962399c6a45c18ebbe.svg",
        "alt": "Item #14 Media",
        "filename": "image_014"
    },
    {
        "index": 15,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/6c185550a257af46cd8cc4c40df874/8f6c185550a257af46cd8cc4c40df874.svg",
        "alt": "Item #15 Media",
        "filename": "image_015"
    },
    {
        "index": 16,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/f98d77c2b5f59f886b82f5036dcbe0/e9f98d77c2b5f59f886b82f5036dcbe0.svg",
        "alt": "Item #16 Media",
        "filename": "image_016"
    },
    {
        "index": 17,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/e4185d58927cec799cea0da0a2d4c5/d5e4185d58927cec799cea0da0a2d4c5.svg",
        "alt": "Item #17 Media",
        "filename": "image_017"
    },
    {
        "index": 18,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/7a7f4f6f22478f1a8a1f8177df8963/617a7f4f6f22478f1a8a1f8177df8963.svg",
        "alt": "Item #18 Media",
        "filename": "image_018"
    },
    {
        "index": 19,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/e286a82ea2056215e017e54ddf03af/59e286a82ea2056215e017e54ddf03af.svg",
        "alt": "Item #19 Media",
        "filename": "image_019"
    },
    {
        "index": 20,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/2854b569a3499dad0143f560a9b41d/c02854b569a3499dad0143f560a9b41d.svg",
        "alt": "Item #20 Media",
        "filename": "image_020"
    },
    {
        "index": 21,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/2dec9a43247ce1749f182798f4e4b5/622dec9a43247ce1749f182798f4e4b5.svg",
        "alt": "Item #21 Media",
        "filename": "image_021"
    },
    {
        "index": 22,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/cb106cc64939a47e0f312635a45078/65cb106cc64939a47e0f312635a45078.svg",
        "alt": "Item #22 Media",
        "filename": "image_022"
    },
    {
        "index": 23,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/673f58f56e11c3ea53afb00e112235/b8673f58f56e11c3ea53afb00e112235.svg",
        "alt": "Item #23 Media",
        "filename": "image_023"
    },
    {
        "index": 24,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/c2928fa77ad545f72a29a014e3df9f/eec2928fa77ad545f72a29a014e3df9f.svg",
        "alt": "Item #24 Media",
        "filename": "image_024"
    },
    {
        "index": 25,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/77cce7eae6f7c65225dab779e7f0a5/1b77cce7eae6f7c65225dab779e7f0a5.svg",
        "alt": "Item #25 Media",
        "filename": "image_025"
    },
    {
        "index": 26,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/0d92c1dfb19c41cd41b6a48b1e83c4/760d92c1dfb19c41cd41b6a48b1e83c4.svg",
        "alt": "Item #26 Media",
        "filename": "image_026"
    },
    {
        "index": 27,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/44e74a1e48579da142a3547e7d4dd6/bd44e74a1e48579da142a3547e7d4dd6.svg",
        "alt": "Item #27 Media",
        "filename": "image_027"
    },
    {
        "index": 28,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/976d02e65102f53aaf1bcc4839f410/09976d02e65102f53aaf1bcc4839f410.svg",
        "alt": "Item #28 Media",
        "filename": "image_028"
    },
    {
        "index": 29,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/068ae9ce8ff5a501cb27dfc8056787/c6068ae9ce8ff5a501cb27dfc8056787.svg",
        "alt": "Item #29 Media",
        "filename": "image_029"
    },
    {
        "index": 30,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/847a1d40424d37a3b2ce0bd90a6174/ea847a1d40424d37a3b2ce0bd90a6174.svg",
        "alt": "Item #30 Media",
        "filename": "image_030"
    },
    {
        "index": 31,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/5eb7090c39b2c075a7f8c52db3f708/d95eb7090c39b2c075a7f8c52db3f708.svg",
        "alt": "Item #31 Media",
        "filename": "image_031"
    },
    {
        "index": 32,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/b253a792c299efe6172d21c498f295/06b253a792c299efe6172d21c498f295.svg",
        "alt": "Item #32 Media",
        "filename": "image_032"
    },
    {
        "index": 33,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/fa508ba3829ac690e91d49314b6707/96fa508ba3829ac690e91d49314b6707.svg",
        "alt": "Item #33 Media",
        "filename": "image_033"
    },
    {
        "index": 34,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/33b288895faf5aa42ca0181a42ae7a/cb33b288895faf5aa42ca0181a42ae7a.svg",
        "alt": "Item #34 Media",
        "filename": "image_034"
    },
    {
        "index": 35,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/46738a6661755026ea7077211b71d8/7f46738a6661755026ea7077211b71d8.svg",
        "alt": "Item #35 Media",
        "filename": "image_035"
    },
    {
        "index": 36,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/5cc6fb19c779846153041f519b6ab5/195cc6fb19c779846153041f519b6ab5.svg",
        "alt": "Item #36 Media",
        "filename": "image_036"
    },
    {
        "index": 37,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/1dccc831d78096338f21a9e0647006/361dccc831d78096338f21a9e0647006.svg",
        "alt": "Item #37 Media",
        "filename": "image_037"
    },
    {
        "index": 38,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/baca6f2c58a8fc0655f116e8b44521/93baca6f2c58a8fc0655f116e8b44521.svg",
        "alt": "Item #38 Media",
        "filename": "image_038"
    },
    {
        "index": 39,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/3da870e62227c6a1be00f65797829d/3a3da870e62227c6a1be00f65797829d.svg",
        "alt": "Item #39 Media",
        "filename": "image_039"
    },
    {
        "index": 40,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/599aa002a1c6dc777d5f3f1896fb7d/dc599aa002a1c6dc777d5f3f1896fb7d.svg",
        "alt": "Item #40 Media",
        "filename": "image_040"
    },
    {
        "index": 41,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/525f04cdb6eac3339b62b74f0380d4/2f525f04cdb6eac3339b62b74f0380d4.svg",
        "alt": "Item #41 Media",
        "filename": "image_041"
    },
    {
        "index": 42,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/a369d6722ebce9cd293870dcf6bed4/44a369d6722ebce9cd293870dcf6bed4.svg",
        "alt": "Item #42 Media",
        "filename": "image_042"
    },
    {
        "index": 43,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/48cfceaa6c37358702f60ac5e713f3/0548cfceaa6c37358702f60ac5e713f3.svg",
        "alt": "Item #43 Media",
        "filename": "image_043"
    },
    {
        "index": 44,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/26828d77a5a5cd1030410445cf6b9c/3d26828d77a5a5cd1030410445cf6b9c.svg",
        "alt": "Item #45 Media",
        "filename": "image_044"
    },
    {
        "index": 45,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/1b6fd2f52b1ac251f767c5d7e529ba/7a1b6fd2f52b1ac251f767c5d7e529ba.svg",
        "alt": "Item #44 Media",
        "filename": "image_045"
    },
    {
        "index": 46,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/6fe976a5e5a95a8977bf9c3642cfe0/2b6fe976a5e5a95a8977bf9c3642cfe0.svg",
        "alt": "Item #46 Media",
        "filename": "image_046"
    },
    {
        "index": 47,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/5c3fa51cae7f14096056341b9f045d/e05c3fa51cae7f14096056341b9f045d.svg",
        "alt": "Item #47 Media",
        "filename": "image_047"
    },
    {
        "index": 48,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/9d6b6464905a8412366af5fb01faba/f99d6b6464905a8412366af5fb01faba.svg",
        "alt": "Item #48 Media",
        "filename": "image_048"
    },
    {
        "index": 49,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/452af4c96f339a7d882d95e7e09912/f6452af4c96f339a7d882d95e7e09912.svg",
        "alt": "Item #49 Media",
        "filename": "image_049"
    },
    {
        "index": 50,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/c70b412c5b63a331fb1f09fce0b979/4ec70b412c5b63a331fb1f09fce0b979.svg",
        "alt": "Item #50 Media",
        "filename": "image_050"
    },
    {
        "index": 51,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/2f6baad05838d8ce8267dceac1df99/202f6baad05838d8ce8267dceac1df99.svg",
        "alt": "Item #51 Media",
        "filename": "image_051"
    },
    {
        "index": 52,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/bf756d5a1b4c5520f2a8939dfbd7b0/6dbf756d5a1b4c5520f2a8939dfbd7b0.svg",
        "alt": "Item #52 Media",
        "filename": "image_052"
    },
    {
        "index": 53,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/6ee4b97d653aa8aef479ef808435fd/6a6ee4b97d653aa8aef479ef808435fd.svg",
        "alt": "Item #53 Media",
        "filename": "image_053"
    },
    {
        "index": 54,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/489e8ef7e24ec056880d06db63bd14/89489e8ef7e24ec056880d06db63bd14.svg",
        "alt": "Item #54 Media",
        "filename": "image_054"
    },
    {
        "index": 55,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/ea6c216fd7d99e6fb80094b599c6a6/91ea6c216fd7d99e6fb80094b599c6a6.svg",
        "alt": "Item #55 Media",
        "filename": "image_055"
    },
    {
        "index": 56,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/323e6f96c4aa0752626fa7f788f652/7e323e6f96c4aa0752626fa7f788f652.svg",
        "alt": "Item #56 Media",
        "filename": "image_056"
    },
    {
        "index": 57,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/9615539cdd7f4de5c6191409322aa7/3f9615539cdd7f4de5c6191409322aa7.svg",
        "alt": "Item #57 Media",
        "filename": "image_057"
    },
    {
        "index": 58,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/996b5240c4c48cf6c2ef62a1d4b79e/c0996b5240c4c48cf6c2ef62a1d4b79e.svg",
        "alt": "Item #58 Media",
        "filename": "image_058"
    },
    {
        "index": 59,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/c908bbadd69c089519df5f7b9fea2a/37c908bbadd69c089519df5f7b9fea2a.svg",
        "alt": "Item #59 Media",
        "filename": "image_059"
    },
    {
        "index": 60,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/592f307bacdec0e464312585d66efc/68592f307bacdec0e464312585d66efc.svg",
        "alt": "Item #60 Media",
        "filename": "image_060"
    },
    {
        "index": 61,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/718e1a425f2b18aac710ab858db634/1c718e1a425f2b18aac710ab858db634.svg",
        "alt": "Item #61 Media",
        "filename": "image_061"
    },
    {
        "index": 62,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/23fbec870c949d439c9c68bf7c9b4b/5323fbec870c949d439c9c68bf7c9b4b.svg",
        "alt": "Item #62 Media",
        "filename": "image_062"
    },
    {
        "index": 63,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/cb4a74e1711a514d28d5d161348fba/50cb4a74e1711a514d28d5d161348fba.svg",
        "alt": "Item #63 Media",
        "filename": "image_063"
    },
    {
        "index": 64,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/6d31aa25cc3e9c9475589fb9444fa9/5a6d31aa25cc3e9c9475589fb9444fa9.svg",
        "alt": "Item #64 Media",
        "filename": "image_064"
    },
    {
        "index": 65,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/1b36adf8b9a22203c4353d7a381aab/a11b36adf8b9a22203c4353d7a381aab.svg",
        "alt": "Item #65 Media",
        "filename": "image_065"
    },
    {
        "index": 66,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/85cfa7cd17d11fd45a76662a308d21/1f85cfa7cd17d11fd45a76662a308d21.svg",
        "alt": "Item #66 Media",
        "filename": "image_066"
    },
    {
        "index": 67,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/2ca75ed82b2cb5d875d0f02af49de0/6f2ca75ed82b2cb5d875d0f02af49de0.svg",
        "alt": "Item #67 Media",
        "filename": "image_067"
    },
    {
        "index": 68,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/9469c5956902f2eb63b9432db604e7/3b9469c5956902f2eb63b9432db604e7.svg",
        "alt": "Item #68 Media",
        "filename": "image_068"
    },
    {
        "index": 69,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/3e497cb8a920b39de21482fc12e6a6/3f3e497cb8a920b39de21482fc12e6a6.svg",
        "alt": "Item #69 Media",
        "filename": "image_069"
    },
    {
        "index": 70,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/f9aa8c7196b00a5c32b26705c44e3d/09f9aa8c7196b00a5c32b26705c44e3d.svg",
        "alt": "Item #70 Media",
        "filename": "image_070"
    },
    {
        "index": 71,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/29f23a140c58d4763a6dd57819913e/b829f23a140c58d4763a6dd57819913e.svg",
        "alt": "Item #71 Media",
        "filename": "image_071"
    },
    {
        "index": 72,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/86bd0420bd9d56e3e6c4bf481c0583/7386bd0420bd9d56e3e6c4bf481c0583.svg",
        "alt": "Item #72 Media",
        "filename": "image_072"
    },
    {
        "index": 73,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/d9fb5682b1fb4fa3673866eb579248/cbd9fb5682b1fb4fa3673866eb579248.svg",
        "alt": "Item #73 Media",
        "filename": "image_073"
    },
    {
        "index": 74,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/07d3a4a8c2f1aa79632d32337ed718/2f07d3a4a8c2f1aa79632d32337ed718.svg",
        "alt": "Item #74 Media",
        "filename": "image_074"
    },
    {
        "index": 75,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/1fcc41fbee888ef06e99c2d71d2c0a/cc1fcc41fbee888ef06e99c2d71d2c0a.svg",
        "alt": "Item #75 Media",
        "filename": "image_075"
    },
    {
        "index": 76,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/2b8c7205c0b13cce9add012e1d8e9f/652b8c7205c0b13cce9add012e1d8e9f.svg",
        "alt": "Item #76 Media",
        "filename": "image_076"
    },
    {
        "index": 77,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/7be3f0e3e80492665aba39511cda11/097be3f0e3e80492665aba39511cda11.svg",
        "alt": "Item #77 Media",
        "filename": "image_077"
    },
    {
        "index": 78,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/a0659186ab8f5a91476af0abb48e4a/63a0659186ab8f5a91476af0abb48e4a.svg",
        "alt": "Item #78 Media",
        "filename": "image_078"
    },
    {
        "index": 79,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/b6b8727695afe2bad49207c6c8210d/e6b6b8727695afe2bad49207c6c8210d.svg",
        "alt": "Item #79 Media",
        "filename": "image_079"
    },
    {
        "index": 80,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/fd2a50ba06b102af7ca6096e419e8d/5ffd2a50ba06b102af7ca6096e419e8d.svg",
        "alt": "Item #80 Media",
        "filename": "image_080"
    },
    {
        "index": 81,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/85afc1f13def574fc33ccdd8435653/9485afc1f13def574fc33ccdd8435653.svg",
        "alt": "Item #81 Media",
        "filename": "image_081"
    },
    {
        "index": 82,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/b76b946925bd0f88651d5d2e5aa302/0db76b946925bd0f88651d5d2e5aa302.svg",
        "alt": "Item #82 Media",
        "filename": "image_082"
    },
    {
        "index": 83,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/38ebb65d9ad37ec7d4f52821cbe678/6338ebb65d9ad37ec7d4f52821cbe678.svg",
        "alt": "Item #83 Media",
        "filename": "image_083"
    },
    {
        "index": 84,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/3032d8f557417c86e4c2b3151f705e/ec3032d8f557417c86e4c2b3151f705e.svg",
        "alt": "Item #85 Media",
        "filename": "image_084"
    },
    {
        "index": 85,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/14b15d00145273b8cfb1aa52e58ecb/f814b15d00145273b8cfb1aa52e58ecb.svg",
        "alt": "Item #84 Media",
        "filename": "image_085"
    },
    {
        "index": 86,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/99b9c496306fbb2235d3096a925b00/2a99b9c496306fbb2235d3096a925b00.svg",
        "alt": "Item #86 Media",
        "filename": "image_086"
    },
    {
        "index": 87,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/2f815e8e3faa5eebd8a5de9c7ef0e9/992f815e8e3faa5eebd8a5de9c7ef0e9.svg",
        "alt": "Item #87 Media",
        "filename": "image_087"
    },
    {
        "index": 88,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/ae042f3de85c6a9848d1e880a2a909/f9ae042f3de85c6a9848d1e880a2a909.svg",
        "alt": "Item #89 Media",
        "filename": "image_088"
    },
    {
        "index": 89,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/28a5dbc665188685d5b0e3f15406f9/3328a5dbc665188685d5b0e3f15406f9.svg",
        "alt": "Item #88 Media",
        "filename": "image_089"
    },
    {
        "index": 90,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/5020f9e817541fe7d5c09f89558352/bf5020f9e817541fe7d5c09f89558352.svg",
        "alt": "Item #90 Media",
        "filename": "image_090"
    },
    {
        "index": 91,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/f52b7d1543cc52887c025e4f05054f/33f52b7d1543cc52887c025e4f05054f.svg",
        "alt": "Item #91 Media",
        "filename": "image_091"
    },
    {
        "index": 92,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/8a23196f8f7a7a3318a4be36ac0c20/798a23196f8f7a7a3318a4be36ac0c20.svg",
        "alt": "Item #92 Media",
        "filename": "image_092"
    },
    {
        "index": 93,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/939e770e6bce22a4eca0b6caa3a954/6b939e770e6bce22a4eca0b6caa3a954.svg",
        "alt": "Item #93 Media",
        "filename": "image_093"
    },
    {
        "index": 94,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/9bc26f2e771eeba3d8d9d0d7d0e228/389bc26f2e771eeba3d8d9d0d7d0e228.svg",
        "alt": "Item #94 Media",
        "filename": "image_094"
    },
    {
        "index": 95,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/63c512cc3147dc07bff3e3d41a439d/0563c512cc3147dc07bff3e3d41a439d.svg",
        "alt": "Item #95 Media",
        "filename": "image_095"
    },
    {
        "index": 96,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/a772d93e29124bda86acda77f04494/12a772d93e29124bda86acda77f04494.svg",
        "alt": "Item #96 Media",
        "filename": "image_096"
    },
    {
        "index": 97,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/82406b9a90b924c87cb7b92f836a46/7e82406b9a90b924c87cb7b92f836a46.svg",
        "alt": "Item #98 Media",
        "filename": "image_097"
    },
    {
        "index": 98,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/bdee94ad493122f893a41e14e8cea2/37bdee94ad493122f893a41e14e8cea2.svg",
        "alt": "Item #97 Media",
        "filename": "image_098"
    },
    {
        "index": 99,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/16fad8e9653d21f3b9bbcc62300999/a116fad8e9653d21f3b9bbcc62300999.svg",
        "alt": "Item #99 Media",
        "filename": "image_099"
    },
    {
        "index": 100,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/095827566efb93f7e5e736b7d94462/d2095827566efb93f7e5e736b7d94462.svg",
        "alt": "Item #100 Media",
        "filename": "image_100"
    },
    {
        "index": 101,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/73af28017aa3c10713ad04353a50af/3273af28017aa3c10713ad04353a50af.svg",
        "alt": "Item #101 Media",
        "filename": "image_101"
    },
    {
        "index": 102,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/a5d85379fda4ee23a1e23489023063/f5a5d85379fda4ee23a1e23489023063.svg",
        "alt": "Item #102 Media",
        "filename": "image_102"
    },
    {
        "index": 103,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/c59eab4494b55cab27862ed1e3a40f/8cc59eab4494b55cab27862ed1e3a40f.svg",
        "alt": "Item #103 Media",
        "filename": "image_103"
    },
    {
        "index": 104,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/2f83d07ce77d91ef230d3361b8f608/cd2f83d07ce77d91ef230d3361b8f608.svg",
        "alt": "Item #106 Media",
        "filename": "image_104"
    },
    {
        "index": 105,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/1087e657baa2c515abbf194d50835b/821087e657baa2c515abbf194d50835b.svg",
        "alt": "Item #104 Media",
        "filename": "image_105"
    },
    {
        "index": 106,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/92fc467aa501052b471767da3798d4/bf92fc467aa501052b471767da3798d4.svg",
        "alt": "Item #105 Media",
        "filename": "image_106"
    },
    {
        "index": 107,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/cea26360cb2db34c85830c493b1d4e/2ccea26360cb2db34c85830c493b1d4e.svg",
        "alt": "Item #107 Media",
        "filename": "image_107"
    },
    {
        "index": 108,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/1ddc80a147a0c095d7e435952fda2a/7a1ddc80a147a0c095d7e435952fda2a.svg",
        "alt": "Item #108 Media",
        "filename": "image_108"
    },
    {
        "index": 109,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/20655916c0cd2d3b4d3f850bae04da/5820655916c0cd2d3b4d3f850bae04da.svg",
        "alt": "Item #110 Media",
        "filename": "image_109"
    },
    {
        "index": 110,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/7fccf934c5838ec962df23ea5afd14/227fccf934c5838ec962df23ea5afd14.svg",
        "alt": "Item #109 Media",
        "filename": "image_110"
    },
    {
        "index": 111,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/3966930d17b5713d2a4dbe9cf9e3d5/7a3966930d17b5713d2a4dbe9cf9e3d5.svg",
        "alt": "Item #111 Media",
        "filename": "image_111"
    },
    {
        "index": 112,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/517d50300c0c32f09f51bc3670ef45/ba517d50300c0c32f09f51bc3670ef45.svg",
        "alt": "Item #112 Media",
        "filename": "image_112"
    },
    {
        "index": 113,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/c8212f6c5e0531116d3e39d2a17000/88c8212f6c5e0531116d3e39d2a17000.svg",
        "alt": "Item #114 Media",
        "filename": "image_113"
    },
    {
        "index": 114,
        "src": "https://raw2.seadn.io/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/48f990f1f29a6379252235574b5195/c348f990f1f29a6379252235574b5195.svg",
        "alt": "Item #113 Media",
        "filename": "image_114"
    }
];

        // Function to create the grid
        function createImageGrid(images) {
            const grid = document.getElementById('imageGrid');
            
            images.forEach(imageData => {
              const imageLink = document.createElement('a');
imageLink.href = "https://opensea.io/item/ethereum/0x40ea935bff2d4e8705a9664d47ce9bbadba2b96e/"+imageData.index;
imageLink.target = "_blank";

const imageItem = document.createElement('div');
imageItem.className = 'image-item';

const img = document.createElement('img');
img.src = imageData.src;
img.alt = imageData.alt || `Image ${imageData.index}`;
img.loading = 'lazy'; // Lazy loading for performance

const indexLabel = document.createElement('div');
indexLabel.className = 'image-index';
indexLabel.textContent = imageData.index;

imageItem.appendChild(img);
imageItem.appendChild(indexLabel);
imageLink.appendChild(imageItem); // Put the imageItem inside the anchor
grid.appendChild(imageLink); // Add the anchor to the grid
            });
            
            console.log(`Grid created with ${images.length} images`);
        }

        // Create the grid when page loads
        if (imageUrls.length > 0) {
            createImageGrid(imageUrls);
        } else {
            document.getElementById('imageGrid').innerHTML = '<p>Please add your imageUrls array to the script</p>';
        }

        // Slideshow
        var shuffled = imageUrls.slice().sort(function() { return 0.5 - Math.random(); });
        var slides = shuffled.slice(0, 6);
        var slideshow = document.getElementById('slideshow');
        var dotsContainer = document.getElementById('slideshowDots');

        slides.forEach(function(item, i) {
            var img = document.createElement('img');
            img.src = item.src;
            img.alt = item.alt || 'Popup ' + item.index;
            if (i === 0) img.classList.add('active');
            slideshow.appendChild(img);

            var dot = document.createElement('button');
            dot.className = 'slideshow-dot' + (i === 0 ? ' active' : '');
            dot.addEventListener('click', function() { goToSlide(i); resetAutoPlay(); });
            dotsContainer.appendChild(dot);
        });

        var currentSlide = 0;
        function goToSlide(n) {
            var imgs = slideshow.querySelectorAll('img');
            var dots = dotsContainer.querySelectorAll('.slideshow-dot');
            imgs[currentSlide].classList.remove('active');
            dots[currentSlide].classList.remove('active');
            currentSlide = n;
            imgs[currentSlide].classList.add('active');
            dots[currentSlide].classList.add('active');
        }

        var autoPlay = setInterval(function() {
            goToSlide((currentSlide + 1) % slides.length);
        }, 8000);

        function resetAutoPlay() {
            clearInterval(autoPlay);
            autoPlay = setInterval(function() {
                goToSlide((currentSlide + 1) % slides.length);
            }, 8000);
        }

        var touchStartX = 0;
        slideshow.addEventListener('touchstart', function(e) { touchStartX = e.touches[0].clientX; });
        slideshow.addEventListener('touchend', function(e) {
            var diff = touchStartX - e.changedTouches[0].clientX;
            if (Math.abs(diff) > 50) {
                goToSlide(diff > 0 ? (currentSlide + 1) % slides.length : (currentSlide - 1 + slides.length) % slides.length);
                resetAutoPlay();
            }
        });
    </script>
    <div class="col-12">
<!-- Color Palettes Section -->
<details class="dark-border-full" open>
  <summary class="light-text">Color Palettes (114)</summary>
                <div class="palettes-list" id="palettesContainer" style="max-height: 600px; overflow-y: auto;">
            <!-- Palettes will be dynamically added here -->
        </div>

</details>

</div>
</div>
      
        <h3 class="light-text"><span class="contract-name"><a target="_blank" href="https://etherscan.io/address/0xDfd90153c4582Bcc0527c43CD10b0089Ac1F7afc#code">PopupImageEngine.sol</a></span></h3 class="light-text">
        <p class="light-text">Responsible for generating the preview images for each NFT. This contract dynamically generates SVG images that serve as static representations of each token. It's important to note that the preview image will not match the animation URL directly.</p>

        <h3 class="light-text"><span class="contract-name"><a target="_blank" href="https://etherscan.io/address/0x45FeBff75E87fd42a6105e63EBe90578B20a0B5A#code">PopupAnimEngine1.sol</a> and <a target="_blank" href="https://etherscan.io/address/0x91a28683e28b22CA4533d5A8Ff58e1861Ce37892#code">PopupAnimEngine2.sol</a></span></h3 class="light-text">
        <p class="light-text">Handles the generation of animation URLs for each NFT. These contracts dynamically generate a complete HTML page containing the Popup javascript art piece. The work is created using vanilla JavaScript without libraries.</p>
        <h3 class="light-text"><span class="contract-name"><a target="_blank" href="https://etherscan.io/address/0xbc0dc64b07a01d7fa722f3fefff825c7892b260d#code">RandomGenerator.sol</a></span></h3 class="light-text">
        <p class="light-text">Provides secure random number generation.</p>

<br>
<br>

</p>    </div>

</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Color Palettes
    let colorPalettes = [
            {colors:["#8e0d00", "#7a0a00", "#a30e00", "#660900", "#9da332", "#979c30", "#b5bb3a", "#cbbd52", "#c2b33a", "#ab5f4e", "#a15b4a", "#566846", "#73a7a9", "#b7976b", "#e1d9c2"], name: "1400-30"},
            {colors:["#c8c699", "#c4c292", "#cbc895", "#2c6d41", "#2b693f", "#2b6e40", "#5fa595", "#60a393", "#8e3f1a", "#8a3d19", "#c22d3b", "#9fb46d", "#2a1616", "#c08047"], name: "1425-30"},
            {colors:["#06142c", "#071631", "#06142d", "#051229", "#e2d2ac", "#e3d4b1", "#e3d5b5", "#a6b15d", "#a4af5a", "#568047", "#547e45", "#e8ae77", "#a77d4d", "#b1443d", "#276687"], name: "1500"},
            {colors:["#c7226c", "#cd236f", "#c7236d", "#c5206a", "#bbad26", "#beaf27", "#b9ab27", "#457a11", "#477e11", "#2f5177", "#31547c", "#c24197", "#d496be", "#619ba7", "#babc9f"], name: "1560"},
            {colors:["#740000", "#7a0000", "#700101", "#750101", "#5d998a", "#5f9b8c", "#b68d07", "#ba9007", "#b58d08", "#5c998a", "#d9cfa9", "#d9cfa6", "#3e722a", "#99792c"], name: "1580-90"},
            {colors:["#877b5d", "#84795c", "#897c5d", "#e3c56a", "#e2c265", "#e3c66d", "#c4baa6", "#c9bfac", "#262e12", "#242c11", "#6d8153", "#814f06", "#640613", "#4e8093"], name: "16th/17th Century"},
            {colors:["#e8d2a9", "#ead3a9", "#ead5ae", "#e7cfa2", "#e8d1a6", "#e8d3ab", "#b6201e", "#b3211e", "#3f799f", "#40779c", "#a49228", "#a08e27", "#5e6d33", "#596831"], name: "17th Century"},
            {colors:["#12151d", "#101219", "#0e1016", "#ceb31b", "#cbb11a", "#c7ad1a", "#7f0b25", "#750a21", "#be7113", "#b46c13", "#397748", "#cb4b46", "#408175", "#d7d98b"], name: "1600-25"},
            {colors:["#c4bf95", "#c8c49d", "#ccc8a4", "#5a780d", "#526e0c", "#56740b", "#799341", "#7e9a42", "#a4885c", "#a68c64", "#adb279", "#acaf83", "#c8c148", "#bc8f2d"], name: "1600-29"},
            {colors:["#d32587", "#dd4099", "#d02586", "#da2f90", "#e6c22b", "#eac948", "#6c7e27", "#798c2b", "#e6d274", "#f5f5f5", "#ab5d14"], name: "1600-49"},
            {colors:["#c5cab9", "#cacfbf", "#c0c6b3", "#c6cdb7", "#820030", "#7a002d", "#5b8a3c", "#57833a", "#c29f00", "#4e1b1f", "#2d4c30", "#85b285"], name: "1600-30"},
            {colors:["#171b19", "#262c29", "#131614", "#232926", "#a91402", "#a21101", "#ca1602", "#d09514", "#cc9214", "#e9a920", "#3a621f", "#7ba17d", "#e6e1a4"], name: "1600-99"},
            {colors:["#bc2c0e", "#b2260a", "#ad361f", "#264e66", "#2a5b79", "#1d3e53", "#f0e0b3", "#c9a266", "#c1934e", "#cda770", "#71831c", "#7c8f1e", "#f0e0b3", "#f3e8c8"], name: "1600-99"},
            {colors:["#790213", "#690211", "#740617", "#740213", "#b18d36", "#ac8835", "#a48232", "#dcd9b6", "#d6d2a9", "#dbd8b8", "#342334", "#3f0417", "#87cdbe", "#c0407b"], name: "1600-99"},
            {colors:["#132e2b", "#0f2422", "#173632", "#c0b11d", "#b6a61b", "#27703d", "#256a3a", "#0e5687", "#105f94", "#c52c11", "#b22810", "#d98473", "#a48232", "#6aa81e", "#7ecb99"], name: "1640-70"},
            {colors:["#952832", "#81222c", "#97212d", "#909d55", "#92a14f", "#828f4d", "#fffaf7", "#ffffff", "#b7975d", "#bda06b", "#609251", "#786c78", "#e68db8", "#9acad9"], name: "17th to 18th Century"},
            {colors:["#eb6521", "#ed763b", "#e06324", "#c74618", "#bf4418", "#cf400c", "#a56a32", "#a46932", "#d7c314", "#decb1b", "#111d6f", "#a6bcc1", "#860f21", "#2b3706"], name: "1700"},
            {colors:["#e3d6c7", "#eee6dd", "#e0d3c2", "#eadfd1", "#c0022d", "#b6022c", "#ca0231", "#721543", "#5a1136", "#7da29d", "#85a8a3", "#1d4260", "#1b3e5a", "#eb85c7", "#854c8c"], name: "1720-50"},
            {colors:["#f7ebe3", "#f9f1eb", "#f7e8df", "#f8ebe3", "#010305", "#040d15", "#071d53", "#061846", "#240d12", "#1a090d", "#f7ebe3", "#010305", "#071d53", "#240d12", "#e3ac35", "#e5b243", "#6a2227", "#b55e40", "#384a34", "#b5a01c"], name: "1700-15"},
            {colors:["#000326", "#000433", "#05001f", "#d0a622", "#c79e23", "#a50008", "#aa030c", "#cce3d9", "#d4e7df", "#63849f", "#718fa8", "#d98dc0", "#0028dc", "#5d7d67", "#b3c478"], name: "1730-69"},
            {colors:["#ededde", "#e8e8d4", "#f1f1e5", "#e6d26f", "#e8d67d", "#e7d374", "#9f7e47", "#977944", "#ede8a8", "#efeaaf", "#ac7e9a", "#edc4d6", "#ba3f6f"], name: "1734"},
            {colors:["#d72a2f", "#d9363b", "#ce272d", "#d2282e", "#4891d2", "#428ed1", "#5390c6", "#e3f2d6", "#eaf5e0", "#d8e9c8", "#d78d54", "#0f1d6d", "#6fb46d", "#d08298"], name: "17480-1820"},
            {colors:["#dcd7c7", "#d8d2c0", "#dedbce", "#d6d0bd", "#d0c9b4", "#d4cdb5", "#880418", "#91041a", "#47817a", "#437a74", "#b3bd72", "#254345", "#d787a5", "#d59c81"], name: "Mid 18th Century"},
            {colors:["#d7d9c5", "#d5d7c1", "#d9dbc7", "#d9dbc7", "#b32b44", "#b62b44", "#b92d46", "#c58481", "#c78885", "#c68480"], name: "1750-90"},
            {colors:["#936b00", "#9e7400", "#8f6900", "#866303", "#cb53a6", "#ce5aa9", "#c7439d", "#ce55a7", "#6a0340", "#720446", "#a71118", "#b5121a", "#192312", "#d5ab00", "#595112", "#879d89"], name: "1763"},
            {colors:["#28762e", "#27722d", "#2e8535", "#226d28", "#2d7b34", "#307e36", "#ff1769", "#ff1f6d", "#ffdee6", "#ffe5ec", "#002b9d", "#3e9e09", "#f7ff6e", "#842d5d"], name: "1770-80"},
            {colors:["#0b151f", "#101f2d", "#050a0f", "#04111f", "#6b9744", "#77a94c", "#b7ad37", "#ada334", "#67552a", "#c7e6f0", "#d991f7", "#3f0a2f"], name: "1788-92"},
            {colors:["#a9dc97", "#bde4af", "#b7e2a7", "#a8d996", "#b0df9f", "#aedda6", "#43d252", "#38cc47", "#b99da1", "#ad3562", "#c2deb6", "#2e413b", "#adb93a", "#95ada6"], name: "1790-1820"},
            {colors:["#82a5a0", "#6e9690", "#7da19b", "#80a39e", "#8faea9", "#84a49f", "#959585", "#9b9b8c", "#d4d9cf", "#cfd4c9", "#9ea553", "#709017", "#2e4416"], name: "1797-8"},
            {colors:["#ae9a6c", "#b3a075", "#a6915e", "#911d1a", "#861b18", "#a0211c", "#254056", "#1f3547", "#656b50", "#6b7156", "#b15b5d", "#b45f61", "#4d2d34", "#5a353d"], name: "18th Century"},
            {colors:["#ba666b", "#be6f74", "#b9646a", "#be6066", "#b3565c", "#c1767b", "#160c0f", "#0d0709", "#cbae9a", "#d0b6a4", "#840d2b", "#4f3317", "#be6300", "#4f1c42"], name: "1800-60"},
            {colors:["#c59e0c", "#b7920b", "#d4a90c", "#bc9815", "#caa10c", "#cba210", "#9b1b18", "#9b1b18", "#303031", "#383839", "#006e2f", "#005c28", "#3e5961", "#44616a"], name: "1800-1950"},
            {colors:["#2a3b2b", "#263627", "#2f4230", "#bc0e02", "#b60e02", "#cc1400", "#e39f44", "#e29c40", "#f5e3ff", "#f8ebff", "#3d82ff", "#4284ff", "#150618", "#120515"], name: "1808"},
            {colors:["#003283", "#00378f", "#0c2e64", "#0b3474", "#274c86", "#033686", "#0b2f6b", "#0d3677", "#b6a737", "#a99b32", "#c2d9c2", "#cadeca", "#0f344e", "#0c2b40", "#3088a5", "#2e829e"], name: "1826"},
            {colors:["#d9cfa1", "#d3c792", "#ddd4ac", "#2052d4", "#1e4ec8", "#265de8", "#bf3d76", "#b2386d", "#cc9a42", "#cb953a", "#819339", "#8ea23f", "#dedede", "#e6e6e6"], name: "1830"},
            {colors:["#1f1912", "#271f16", "#1a150f", "#1b150e", "#17120d", "#13100b", "#498dc7", "#4f90c9", "#4f8ec4", "#d9b208", "#d4ae08", "#cfaa07"], name: "1831"},
            {colors:["#1E6AE8", "#1763DE", "#246fe0", "#1764d9", "#2a5314", "#264a12", "#785019", "#6e4a17", "#6350b6", "#6856b8", "#851a54", "#77184c", "#a48a15", "#9e8410", "#9f3a04", "#953704"], name: "1837"},
            {colors:["#ccd1ad", "#c8cda7", "#d4d8ba", "#d0d5b4", "#c7ce9c", "#cfd4b0", "#52aaaa", "#519e9e", "#b80717", "#ac0614", "#b99855", "#9ec2b5", "#9c8b94", "#2b1620"], name: "1838"},
            {colors:["#2d92b0", "#2f97b6", "#288faf", "#9a7c32", "#967931", "#8e732e", "#c91a00", "#bd1900", "#4b9209", "#458609", "#c94c27", "#d4c726", "#8a6a75", "#160e10"], name: "1840-70"},
            {colors:["#1f2951", "#192243", "#222d59", "#f5d157", "#f6d465", "#f6d56a", "#804a0c", "#75430b", "#311f12", "#2d1c11", "#e86512", "#ee6f20", "#fff7c7", "#fffad6"], name: "1840-70"},
            {colors:["#aa805c", "#ae8765", "#ae8d6f", "#542840", "#5a2b45", "#482337", "#b10726", "#a60724", "#417708", "#52831e", "#72a277", "#002ad2", "#776b9a", "#c9d191"], name: "1848"},
            {colors:["#131a13", "#0f150f", "#151e15", "#1a231a", "#dbb56b", "#dcb86f", "#debc78", "#d3b069", "#c4c47a", "#caca86", "#cdcd8e", "#484140", "#3e3837", "#151e15", "#bf7645", "#f2e3c4"], name: "1850-67"},
            {colors:["#a6e3a8", "#aee5af", "#b1e7b3", "#b5e8b7", "#a17961", "#936e58", "#99735c", "#96715a", "#ce0745", "#c50743", "#205a24", "#1d5321", "#fa42a1", "#d2a400", "#5591b9", "#100e1f"], name: "1860-75"},
            {colors:["#dbc7a6", "#ddcaac", "#e1cdad", "#0d1228", "#0a0e1f", "#101632", "#d70200", "#e00400", "#c30704", "#48694c", "#446448", "#405e44", "#d6b32b", "#d7b52d", "#122948", "#102641"], name: "1864-77"},
            {colors:["#577968", "#5e8270", "#4e7361", "#48705c", "#547363", "#9cd194", "#a6d69f", "#a9d7a2", "#badfb4", "#a3d49b", "#e6c754", "#e11400", "#760000"], name: "1872"},
            {colors:["#e3deb0", "#e7e3bb", "#e6e1b7", "#e1dba8", "#e5e1b8", "#e9e4ba", "#bfc47a", "#c6ca86", "#ded16e", "#e0d376", "#de7d7d", "#c9ba66", "#b17761", "#bdb38c"], name: "1879"},
            {colors:["#4f8465", "#4d8062", "#5c9975", "#66a380", "#99b8c9", "#94b5c7", "#afc7d5", "#526860", "#485b54", "#bba488", "#c3b097", "#48262a", "#5e3136", "#ba2727", "#2d49b0", "#b085bd", "#b0994a"], name: "1880-90"},
            {colors:["#4a5cff", "#5c6cff", "#707eff", "#5161f0", "#5263ff", "#4a5cff", "#f7db45", "#f8e262", "#f7db3b", "#f5c4e8", "#f3b9e4", "#f9dcf1", "#f7e6c4", "#8aac30", "#363639", "#b99d64"], name: "1880-90"},
            {colors:["#dcdcc5", "#d9d9bf", "#e8e8d9", "#d1d1b3", "#be6d91", "#c680a0", "#b9648b", "#498da3", "#498da3", "#3f601b", "#345016", "#760008", "#bc8d17", "#301f17", "#b86017"], name: "1883"},
            {colors:["#236264", "#20595b", "#2a7679", "#308588", "#ff66a1", "#ff85b4", "#ff99c0", "#ff5c9a", "#92b87c", "#9cbf88", "#f71424", "#f72634", "#4d2f2b", "#de744c", "#fce3ed"], name: "1884"},
            {colors:["#021992", "#0320b5", "#02198d", "#aa600e", "#97560c", "#d07711", "#3e9d82", "#46af91", "#ebe8e6", "#f5f2f0"], name: "1887"},
            {colors:["#6fb157", "#7bb865", "#65a84d", "#5d9a47", "#b80000", "#a30000", "#cc0000", "#022f7e", "#012665", "#0d0e16", "#171927", "#d4569d", "#e32800", "#e69a00", "#5cc7c7"], name: "1890"},
            {colors:["#d1c294", "#dacea9", "#e0d6b8", "#cebe8d", "#5b7171", "#647d7d", "#6d8888", "#c71100", "#a30e00", "#b80f00", "#869c60", "#778b55", "#ca9544", "#d2a460"], name: "1890"},
            {colors:["#87cfe0", "#7dccde", "#6dc6d9", "#9ed9e6", "#69928b", "#719891", "#89a9a4", "#7da19b", "#1e62d7", "#286ce2", "#1b59c5", "#1649a2", "#a39800", "#8f8500"], name: "1892"},
            {colors:["#76a47f", "#85ad8d", "#91b698", "#9dbea4", "#030d57", "#041276", "#05148a", "#06179d", "#cfbd75", "#d5c586", "#a66602", "#ca7d02", "#26512e", "#2e6137", "#d4d9d6", "#dfe2e0"], name: "1897"},
            {colors:["#021045", "#031863", "#041d77", "#04218b", "#107d4a", "#0e6c40", "#139056", "#15a261", "#27b384", "#2cc995", "#3ec65e", "#52cb6e", "#8c7412", "#a28615", "#769e13", "#89b715"], name: "1897-8"},
            {colors:["#eddeb5", "#f3e9ce", "#ebd9ad", "#e7d49c", "#436e20", "#4d7e25", "#304f17", "#e38c12", "#ed961d", "#f0a742", "#b8a27c", "#e13f44", "#423725", "#b05f05"], name: "1899"},
            {colors:["#193573", "#1d3e86", "#214697", "#254ea7", "#5d8ca9", "#79a0b9", "#6c97b2", "#bdbdb5", "#cfcfc9", "#b2b2a9", "#b8868d", "#c3989e", "#7f8986", "#767f7c"], name: "Late 19th Century"},
            {colors:["#699bac", "#7ba8b7", "#89b1be", "#7f5a04", "#9e7005", "#b17e06", "#080b0d", "#101519", "#172026", "#8d7e00", "#a39300", "#1a4790", "#2056ac", "#95833c", "#a45200", "#de6f5b", "#9f1500"], name: "20th Century"},
            {colors:["#4f6d97", "#5f7eab", "#6c89b2", "#7994b9", "#375421", "#30491d", "#436728", "#4d762e", "#7e2b80", "#973399", "#1f1a21", "#2b242e", "#1f3a88", "#b18341", "#c46bba", "#6c9163"], name: "1900"},
            {colors:["#112b73", "#133081", "#0f2562", "#1e87c3", "#1c7ab0", "#1f89c7", "#52a588", "#5bae91", "#4a967c", "#484068", "#4c446f", "#443c62", "#abcfad", "#7d91ac", "#36867f"], name: "1901"},
            {colors:["#40535e", "#4a606d", "#3a4b55", "#536b79", "#82872f", "#929735", "#a1a63a", "#afb540", "#182e1a", "#234326", "#b8b172", "#c1bb85", "#966656", "#c5b12b", "#aa5730", "#ba1c15"], name: "1903"},
            {colors:["#8cd49e", "#a6deb4", "#b5e3c0", "#79cd8e", "#c3e9cd", "#ccf0cc", "#dff6df", "#75c561", "#8acd79", "#dbbd57", "#b67124", "#e3f2d6", "#e0d9db"], name: "1903"},
            {colors:["#357d76", "#439d94", "#3d8f87", "#31726c", "#235021", "#2c6529", "#33742f", "#375d21", "#47792a", "#508830", "#8f8420", "#3c4479", "#9e274c", "#3f4746"], name: "1908"},
            {colors:["#dbd4c2", "#f0ede5", "#d2c9b2", "#e9e4d8", "#b1bd6f", "#bbc581", "#9aa84d", "#b1bd6f", "#94b39e", "#a0bba8", "#7ca288", "#5b7966", "#698c76", "#dba85c", "#e2b879"], name: "1910"},
            {colors:["#ad8129", "#c6942f", "#d09e39", "#d4a649", "#1f3446", "#253f55", "#2c4963", "#325471", "#bf5035", "#ca5b3f", "#6072d7", "#7c8bde", "#d1abba", "#dbbdc9", "#483e5e", "#55496f"], name: "1911"},
            {colors:["#c4bd99", "#bcb38a", "#d2cdb1", "#2b4c91", "#345aad", "#3862bc", "#ab2328", "#ba262b", "#cb2a2f", "#5d3875", "#57356e", "#784997", "#500d15", "#69111b", "#af2f00", "#cc3600"], name: "1913"},
            {colors:["#c73200", "#e03800", "#f53d00", "#ff571f", "#6ca16e", "#5f9561", "#83af84", "#8fb790", "#001f80", "#001f7a", "#001966", "#1e1817", "#2e2523", "#d4d9c7", "#e3e6db"], name: "1913"},
            {colors:["#47495f", "#3d3f51", "#585a74", "#606380", "#799751", "#89a960", "#93b06d", "#987634", "#a78339", "#b68e3e", "#deab17", "#354b1f", "#b8b394", "#ce4e00"], name: "1914"},
            {colors:["#e6ebdb", "#e4e9d8", "#dbe2ca", "#d1dbbd", "#a8e3b0", "#c1ebc7", "#d1f0d5", "#be9b00", "#e0b700", "#f5c800", "#f29103", "#fd9d0d", "#19328a", "#1c389b"], name: "1918"},
            {colors:["#dbd4e0", "#d7d0dd", "#cdc4d4", "#c3b8cc", "#1f1819", "#2e2325", "#3a2c2e", "#453538", "#7a5812", "#8e6615", "#4e4367", "#5d517b", "#374d38", "#445f45", "#2b2f72", "#2b2f72"], name: "1918"},
            {colors:["#113e76", "#144b8f", "#1755a1", "#195eb3", "#c4ccb0", "#d1d7c1", "#dadfcd", "#e3e7da", "#7eb88d", "#96c5a2", "#625c3f", "#706948", "#2f2b22", "#5492ad", "#d06500"], name: "1918"},
            {colors:["#7c613e", "#886a44", "#95754b", "#a38052", "#f5d499", "#f4cf90", "#f2c77d", "#facf29", "#f9ca10", "#efc006", "#80272f", "#232423", "#5eba77"], name: "1919-29"},
            {colors:["#090d15", "#121b2b", "#182339", "#1f2c47", "#082960", "#092f71", "#0b3784", "#e30200", "#ff0e0a", "#f2d6de", "#ebc1d1", "#610b04", "#61fa47", "#0007d0", "#eda675"], name: "1920-40"},
            {colors:["#131e36", "#1b2a4b", "#20335a", "#253b6a", "#2a4379", "#4569ff", "#335cff", "#64866d", "#72977c", "#a2b392", "#adbc9f", "#bb5c11", "#cd6413"], name: "1921"},
            {colors:["#c09328", "#ba8e26", "#d5a534", "#d9ac45", "#dcb456", "#43488f", "#4e54a6", "#8b4900", "#7a4100", "#d6cfc4", "#ded8cf", "#549292", "#64a6a6"], name: "1922"},
            {colors:["#a8c2cc", "#bfd2d9", "#ccdbe1", "#d8e4e8", "#ededcc", "#eaeac3", "#e4e4b4", "#dfdfa4", "#1e2431", "#272f3f", "#dc3c39", "#e05452", "#9cbade", "#ae6a42", "#edcfb3"], name: "1927"},
            {colors:["#bd928b", "#c39d97", "#cba9a4", "#786f6d", "#8b817e", "#948b89", "#ca9756", "#c48d45", "#529859", "#60a967", "#1a5030", "#236c40", "#6a7a91", "#be132d", "#d2607e", "#7f357f", "#0013b3", "#4d1d0b"], name: "1928"},
            {colors:["#e8ebe0", "#e4e7da", "#dbdfcd", "#d1d7c1", "#2938ff", "#4754ff", "#5c67ff", "#e84c00", "#ff5c0a", "#79a800", "#92cc00", "#cfae00", "#f5cc00", "#2d17ac", "#b68505"], name: "1930"},
            {colors:["#d6deb3", "#e0e6c6", "#e8ecd4", "#d1daaa", "#fafcd6", "#fdfeec", "#f8fbc6", "#bac28f", "#ced4b0", "#c6cca3", "#81b896", "#97c4a8", "#929269", "#b8d694"], name: "1930"},
            {colors:["#ebe6cc", "#e8e2c4", "#e2dbb6", "#f4f1e2", "#f9f8f0", "#b5e382", "#c4e89b", "#ceecac", "#306830", "#3a7e3a", "#993613", "#ff1c00"], name: "1930"},
            {colors:["#f2c7b0", "#f1c1a7", "#eeb596", "#f6daca", "#eba884", "#75a242", "#88b851", "#5d637d", "#686f8d", "#d4a451", "#cd6028", "#0f0f1a", "#c71d0a"], name: "1930"},
            {colors:["#ebe6d4", "#ede9d9", "#eae5d2", "#f1eddf", "#402d19", "#422f1a", "#46311b", "#b5d626", "#bbda2f", "#c5e04d", "#577900", "#507000", "#24210d", "#f71924"], name: "1931"},
            {colors:["#988264", "#a69377", "#ae9d84", "#b6a690", "#9f3624", "#b73f2a", "#485b74", "#566d8a", "#3e1014", "#51151a", "#644c3a", "#755843", "#ad8926", "#725000", "#0a1f4c", "#361f13"], name: "1931"},
            {colors:["#0f1826", "#06090f", "#17253a", "#1d2e49", "#718683", "#7a908c", "#859995", "#90a29f", "#7eb565", "#8cbd75", "#a77213", "#b87e14", "#d94d32", "#d1cfbf", "#acc55b", "#79000c"], name: "1932"},
            {colors:["#dbdebd", "#dadcc1", "#e9ead6", "#d4d8b1", "#c9b399", "#c5ad91", "#c1a88a", "#94bdad", "#9dc3b4", "#ae5332", "#9e4c2e", "#c994b0", "#cfa0ba", "#d2b119", "#c4a517"], name: "1932"},
            {colors:["#cfa400", "#f5c400", "#cca300", "#ffce0a", "#c7cfc4", "#d4dad2", "#dfe3dd", "#19191c", "#26262b", "#879589", "#7e4e00"], name: "1932"},
            {colors:["#ab0000", "#cc0000", "#e00000", "#7781cf", "#5966c5", "#6873ca", "#de45b3", "#e363bf", "#b5b0db", "#cbc7e5", "#d90543", "#ef064c", "#d54a00", "#f55600", "#11239a", "#142ab8", "#748100", "#0c0d0d"], name: "1933"},
            {colors:["#f2d6c4", "#f0d0bc", "#ecc5ac", "#f8e8de", "#c01523", "#dc1829", "#b81422", "#4f6491", "#576d9e", "#6178a8", "#2b292d", "#fab845", "#db8f85", "#88a4c5"], name: "1933"},
            {colors:["#a1ded4", "#97d8cf", "#b4e4dc", "#c3e9e3", "#721003", "#630e03", "#8b1304", "#f2c9ab", "#f9e8dc", "#e0c2eb", "#d9b2e6", "#addbff", "#ebbd0a", "#faadb0", "#000e87"], name: "1935-6"},
            {colors:["#7ea388", "#85a88e", "#94b39c", "#6d9778", "#82ab8d", "#85a88e", "#6d9778", "#9fbd9f", "#98b998", "#a7c3a7", "#863a15", "#7c3613", "#924017"], name: "1939"},
            {colors:["#c6672f", "#d07039", "#d8885a", "#d47c49", "#fcfffa", "#e7ffd6", "#f3ffeb", "#0d0f0f", "#2f3737", "#1c2121", "#ff192e", "#d9e8ff", "#57ca61"], name: "1950"},
            {colors:["#3a4e20", "#36481e", "#4b6529", "#56742f", "#42ff85", "#5cff95", "#33ff7a", "#70ffa2", "#aec75d", "#bbd076", "#c18d00", "#e0a500", "#1b401f", "#101c17", "#e8ff45", "#f70357"], name: "1950/60"},
            {colors:["#885838", "#825435", "#9f6741", "#ae7047", "#fcdb45", "#fde05e", "#fcd836", "#09060d", "#130d1c", "#1d132a", "#f7edf5", "#f2e3ef", "#e33f03", "#fb4d0e"], name: "1951"},
            {colors:["#8b8981", "#9d9b95", "#7f7d76", "#a7a5a0", "#2a2c31", "#383b42", "#42454d", "#4b4f58", "#e6e0db", "#d5cbc3", "#ded5cf", "#8cb325", "#a0cb2a", "#d6b333", "#dab944"], name: "1953"},
            {colors:["#e0e3d4", "#dbdfce", "#d2d7c1", "#c9cfb4", "#63986e", "#84ae8b", "#77a681", "#587356", "#638060", "#6c8c69", "#6ac5ac", "#7bccb6", "#6d1933", "#191b1c"], name: "1954"},
            {colors:["#748a82", "#859991", "#90a29b", "#9baba5", "#d9a88f", "#e0b8a4", "#e5c5b3", "#0f0d10", "#201c22", "#2a252d", "#faf7ed", "#f6f1df", "#f2e812", "#91c7fc"], name: "1954"},
            {colors:["#5c0300", "#7a0400", "#8f0500", "#520300", "#3d0200", "#080a0a", "#121717", "#1b2222", "#e8ad1c", "#ebb733", "#f7f7fc", "#7de654"], name: "1955"},
            {colors:["#d9c930", "#cfbe26", "#beae23", "#ac9e20", "#1b1c1d", "#141415", "#27292a", "#6a722b", "#7b8532", "#d4d9c4", "#e4e7da", "#c5a400", "#294836", "#3a2d4e", "#637977"], name: "1955"},
            {colors:["#e0e6f0", "#d6deeb", "#c8d2e4", "#bac7de", "#0b0f1d", "#11172c", "#161e3b", "#75973c", "#88af46", "#93b950", "#183024", "#202435", "#59945d"], name: "1960"},
            {colors:["#2b5b7a", "#306588", "#357097", "#3a7ba6", "#d6cfcc", "#d2cac6", "#edeae8", "#b08179", "#bb928b", "#c39f98", "#7da3c7", "#8daece", "#b8c23f", "#c5ce64"], name: "1960"},
            {colors:["#747029", "#6a6625", "#5b5820", "#888330", "#979235", "#a6a13a", "#ff99d9", "#ffade1", "#ffc2e9", "#f7573d", "#f8654f", "#f87662", "#6e502d", "#825e35"], name: "1964"},
            {colors:["#faf0eb", "#f7e7de", "#f3dace", "#efcebe", "#063854", "#084b72", "#095886", "#2dd96d", "#26cf64", "#23be5c", "#1b3c19", "#275624", "#258400", "#969100"], name: "1968"},
            {colors:["#151f42", "#1d2b5d", "#22326d", "#273a7c", "#b11b09", "#9b1708", "#881407", "#ae5bb6", "#b972c0", "#c080c6", "#214d56", "#275d68", "#2d6a76"], name: "1968"},
            {colors:["#1f5cff", "#0a4bff", "#4778ff", "#3369ff", "#e0e6e8", "#f3f6f6", "#d0d9dc", "#99ff33", "#a3ff47", "#9d0000", "#b80000", "#85f5c2", "#a1f7d0", "#1a7100", "#186600"], name: "1970"},
            {colors:["#121418", "#1a1d23", "#23272f", "#737e41", "#87944c", "#93a253", "#275126", "#2f612e", "#2a121a", "#ba8cb5", "#6897c2", "#7da4ca", "#dec2a1", "#abe3c2", "#2d5967", "#7d3c00", "#4a2c61", "#b29454"], name: "1974"},
            {colors:["#f5f0f5", "#f3edf3", "#f7f3f7", "#f7f3f7", "#242d2e", "#222a2b", "#e0f200", "#e9f500", "#6bff0f", "#ff6103", "#4abaff", "#00d4a9"], name: "1976"},
            {colors:["#b6101b", "#ce121f", "#e11421", "#0c52d7", "#1864f2", "#2b71f3", "#18a594", "#1cc4b1", "#1fd6c1", "#ffdb47", "#ffde5c", "#ffe785", "#a40788", "#c408a1", "#ff5496", "#8cc328"], name: "1981"},
            {colors:["#4a6d9b", "#5a7faf", "#688ab6", "#7594bd", "#839fb1", "#7595a9", "#688ba1", "#5e8197", "#abbaa8", "#bdc9ba", "#a90088", "#cc00a3", "#ce2400", "#0324ff", "#cfb300", "#0e1216"], name: "1986"},
            {colors:["#f2f7c9", "#edf4b8", "#e9f2a6", "#e5ef95", "#ffe329", "#ffe747", "#325403", "#477604", "#eb6e91", "#ee81a0", "#11574c", "#14665a", "#bddb08", "#d4f613", "#0b2d75", "#af4600"], name: "1992"},
            {colors:["#000a9b", "#000cb8", "#000ecc", "#000fe0", "#50bb8d", "#5dc095", "#6cc69f", "#7bcca9", "#55008f", "#6200a3", "#336a00", "#458f00", "#0b0c0d", "#f082d9", "#be3d00", "#47cb00"], name: "1992"},
            {colors:["#b0baa6", "#abb6a0", "#a6b19a", "#c7cec0", "#b0b7a9", "#e0e6e3", "#e2e4e3", "#e6ebe8", "#e8edeb", "#dee8e3", "#ab071d", "#a2071b", "#9b081c", "#31352b", "#2c3027", "#95a797", "#98a99a"], name: "2000"},
            {colors:["#d9ded6", "#d5dbd2", "#cbd2c6", "#c0c9bb", "#b6bfb0", "#e6d130", "#e9d649", "#ebda5c", "#c58688", "#d19fa0", "#d7acae", "#65707e", "#68b830", "#d95700", "#793c5d"], name: "2003"},
            {colors:["#1d1921", "#29232f", "#141217", "#332c3a", "#3d3546", "#c0b121", "#d1c023", "#dcca2e", "#d23b00", "#f54500", "#c2cfbd", "#d3ddd0"], name: "2009"},
        ]

    function createPaletteElement(palette) {
        const paletteDiv = document.createElement('div');
        paletteDiv.className = 'palette';
        
        //const nameDiv = document.createElement('div');
        //nameDiv.className = 'palette-name light-text';
        //nameDiv.textContent = palette.name;
        
        const colorsDiv = document.createElement('div');
        colorsDiv.className = 'palette-colors';
        
        palette.colors.forEach(color => {
            const colorDiv = document.createElement('div');
            colorDiv.className = 'palette-color';
            colorDiv.style.backgroundColor = color;
            colorDiv.title = color; // Show hex code on hover
            colorsDiv.appendChild(colorDiv);
        });
        
        //paletteDiv.appendChild(nameDiv);
        paletteDiv.appendChild(colorsDiv);
        return paletteDiv;
    }

    // Initialize palettes
    const palettesContainer = document.getElementById('palettesContainer');
    if (palettesContainer) {
        colorPalettes.forEach(palette => {
            palettesContainer.appendChild(createPaletteElement(palette));
        });
    }
    
    document.querySelectorAll('details').forEach(function(d) { d.click(); });
});

  </script>
 
  <div class="footer mt-5">
    <?php include '../footer.php'; ?>
  </div>
</body>
</html>
