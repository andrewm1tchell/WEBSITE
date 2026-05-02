<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../meta.php'; ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('a.nav-item.nav-link').forEach(function(el) {
                if (el.textContent.includes('ART')) el.style.textDecoration = 'underline';
            });
        });
        document.title = "Andrew Mitchell - Nature Studies";
    </script>
    <style>
        /* Section styling */
        .section-title {
            font-size: 1.8rem;
            margin-bottom: 10px;
            border-bottom: 1px solid rgba(248, 249, 250, 0.3);
            padding-bottom: 10px;
        }

        .section-description {
            margin-bottom: 20px;
        }

        /* Masonry-style gallery */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            padding: 20px 0;
        }

        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0,0,0,0.0);
        }

        .gallery-item img {
            width: 100%;
            height: auto;
            display: block;
            opacity: 0;
            transition: opacity 0.8s ease, transform 0.3s ease;
        }

        .gallery-item img.lazyloaded {
            opacity: 1;
        }

        .gallery-item:hover img {
            transform: scale(1.02);
        }

        /* Full-width items */
        .gallery-item.full-width {
            grid-column: span 3;
        }


        /* Divider between sections */
        .section-divider {
            margin: 50px 0;
            border-top: 1px solid rgba(248, 249, 250, 0.2);
        }

        /* Featured item styling */
        .featured-item {
            text-align: center;
            padding: 30px 0;
        }

        .featured-item img {
            max-width: 600px;
            width: 100%;
            height: auto;
            margin: 0 auto;
            display: block;
            opacity: 0;
            transition: opacity 0.8s ease;
        }

        .featured-item img.lazyloaded {
            opacity: 1;
        }

        .featured-caption {
            margin-top: 15px;
            font-style: italic;
        }

        @media (max-width: 768px) {
            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 8px;
            }

            .gallery-item.full-width {
                grid-column: span 2;
            }

            .section-title {
                font-size: 1.4rem;
            }
        }

        @media (max-width: 480px) {
            .gallery-grid {
                grid-template-columns: 1fr;
                gap: 8px;
            }

            .gallery-item.full-width {
                grid-column: span 1;
            }
        }
    </style>

</head>
<body>
<div class="art-page">
    <h1 class="light-text"><em>Nature Studies</em></h1>
    <p class="date light-text">2022-2023</p>

    <p class="light-text" style="margin-bottom: 1rem;">A collection of generative works inspired by nature, created with JavaScript and <a href="https://p5js.org/" target="_blank">p5.js</a>.</p>

    <div class="btn-row">
            <a href="/collections/a-sudden-interest-in-nature/" target="_blank" class="view-tokens-btn light-text" onclick="event.preventDefault(); var mode = new URLSearchParams(window.location.search).get('mode') || '0'; window.open('/collections/a-sudden-interest-in-nature/?mode=' + mode, '_blank');">
                A Sudden Interest in Nature →
            </a>
            <a href="/collections/april-showers/" target="_blank" class="view-tokens-btn light-text" onclick="event.preventDefault(); var mode = new URLSearchParams(window.location.search).get('mode') || '0'; window.open('/collections/april-showers/?mode=' + mode, '_blank');">
                April Showers →
            </a>
            <a href="/collections/touch-grass/" target="_blank" class="view-tokens-btn light-text" onclick="event.preventDefault(); var mode = new URLSearchParams(window.location.search).get('mode') || '0'; window.open('/collections/touch-grass/?mode=' + mode, '_blank');">
                Touch Grass →
            </a>
    </div>

    <!-- A Sudden Interest in Nature Section -->
    <div class="mt-5">
        <h2 class="section-title light-text">A Sudden Interest in Nature</h2>
        <p class="section-description light-text">
            Secondary market on <a href="https://superrare.com/andrew_mitchell" target="_blank">SuperRare</a>.
        </p>

        <div class="gallery-grid" id="asiin-gallery">
            <!-- Images loaded via JS -->
        </div>
    </div>

    <div class="section-divider"></div>

    <!-- April Showers & Touch Grass Section -->
    <div class="mt-4">
        <h2 class="section-title light-text">April Showers & Touch Grass</h2>
        <p class="section-description light-text">
            April Showers (2023) and Touch Grass (2022) both make up a set of 9 generative surreal landscapes. Each piece attempts to encapsulate the viewer into a world overgrown. If I was shrunk down and placed into a thicket—one square inch of this thicket would look like an entire universe to me.
            <br><br>
            April Showers - <a href="https://opensea.io/collection/april-showers-by-andrew-mitchell" target="_blank">OpenSea</a> |
            Touch Grass - <a href="https://opensea.io/collection/touch-grass-by-andrew-mitchell" target="_blank">OpenSea</a>
        </p>

        <div class="gallery-grid" id="aprilshowers-gallery">
            <!-- Images loaded via JS -->
        </div>
    </div>

    <div class="section-divider"></div>

    <!-- Featured Items -->
    <div class="featured-item">
        <img data-src="https://raw2.seadn.io/ethereum/0x3f505d613218f1cb30341b5a1dd9656855811e29/ddfc3decee28131bf24478df1c7099cf.png" class="lazy" alt="Play Action Pass">
        <p class="featured-caption light-text"><strong><em>Play Action Pass</em></strong><br>Created between the times of these two series, this work was part of a group charity show for the <a href="https://bf-foundation.org" target="_blank">Benchetler Fasani Foundation</a>.</p>
    </div>

    <div class="section-divider"></div>

    <div class="featured-item">
        <img data-src="https://media.1155.tech/art-market/657911c3f920df2e21c9d14a-1702435595376.jpeg" class="lazy" alt="Flowers for Your Desktop Background">
        <p class="featured-caption light-text"><strong><em>Flowers for Your Desktop Background</em></strong></p>
    </div>

</div>

<script>
    // A Sudden Interest in Nature images
    const asiinImages = [
        "Ambien.png",
            "Shadowbox.png",
        "Kaleidoscope.png",
        "Atlantis.png",
        "Emeralds.png",
        "Royal.png",
        "VineIntervention.png",
        "OrangeCrush.png",
        "FleshAndBones.png",
        "Palisade.png"
    ];

    // April Showers & Touch Grass images
    const aprilShowersImages = [
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

    // Populate ASIIN gallery
    const asiinGallery = document.getElementById('asiin-gallery');
    asiinImages.forEach((filename, index) => {
        const item = document.createElement('div');
        item.className = 'gallery-item';
        const img = document.createElement('img');
        img.setAttribute('data-src', '/images/collections/asiin/' + filename);
        img.className = 'lazy';
        img.alt = filename.replace('.png', '');
        item.appendChild(img);
        asiinGallery.appendChild(item);
    });

    // Populate April Showers gallery
    const aprilGallery = document.getElementById('aprilshowers-gallery');
    aprilShowersImages.forEach((url, index) => {
        const item = document.createElement('div');
        item.className = 'gallery-item';
        const img = document.createElement('img');
        img.setAttribute('data-src', url);
        img.className = 'lazy';
        img.alt = 'Nature Study ' + (index + 1);
        item.appendChild(img);
        aprilGallery.appendChild(item);
    });
</script>

<div class="footer mt-5">
    <?php include '../footer.php'; ?>
</div>
</body>
</html>

