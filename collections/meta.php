<meta>
<head>
    <meta charset="UTF-8">
    <title>Andrew Mitchell</title>
    <meta name="description" content="Linktree of Mitchell's portfolio">
    <meta name="author" content="Andrew Mitchell">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inconsolata&family=Roboto+Condensed:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/font/Satoshi_Complete/Fonts/WEB/css/satoshi.css">
<style>
    body {    .hero-image.blurred {
            filter: blur(5px);
            transition: filter 1s ease-in-out;
                       image-rendering: pixelated;
            image-rendering: -moz-crisp-edges;
            image-rendering: crisp-edges;
        }
    font-family: 'Satoshi-Regular' !important;
        margin-top: 0;
        box-sizing: border-box;
        color: antiquewhite;
        overflow-x: hidden;
    }

    header {
        display: none;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .text-fixed {
        position: fixed;
        left: 50vw;
        transform: translate(-50%, -50%);
        font-family: Arial, sans-serif;
        font-size: 0.75rem; /* Default font size */
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
        z-index: 2;
        box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.1);
        width: max-content;
    }
        .hero-image {
            transition: filter 1s ease-in-out;
                       image-rendering: pixelated;
            image-rendering: -moz-crisp-edges;
            image-rendering: crisp-edges;
        }
    .hero-image.blurred {
            filter: blur(50px);
            transition: filter 1s ease-in-out;
                       image-rendering: pixelated;
            image-rendering: -moz-crisp-edges;
            image-rendering: crisp-edges;
        }
    
     .scroll-indicator {
            position: absolute;
            bottom: 50px;
            left: 50%;
            transform: translateX(-50%);
            color: black;
 
            font-size: 3rem;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateX(-50%) translateY(0);
            }
            40% {
                transform: translateX(-50%) translateY(-10px);
            }
            60% {
                transform: translateX(-50%) translateY(-5px);
            }
        }

    .art-square-light {
        z-index: 1;
        box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.1);
    }
    
        .art-square-dark {
        z-index: 1;
        box-shadow: 4px 4px 8px rgba(255, 255, 255, 0.1);
    }
.rounded{
border-radius:0px;
}
    #eye {
        width: 14px;
        display: inline-block;
        position: absolute;
        top: 3px;
        right: 12px;
        cursor: pointer;
    }

    .art-title {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .art-description {
        margin-top: 10px;
        font-size: 1rem;
    }

    .art-images {
        width: fit-content;
    }

    .art-images img {
        max-width: 100%;
        height: auto;
    }

    .item-count {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: .5rem;
        background: rgba(0, 0, 0, 0.5);
        color: white;
        padding: 1.5px  3px;
        border-radius: 5px;
    }
    
      .myContainer {
          position: absolute;
            padding:1%;
            opacity: 0;
            visibility: hidden;

            /* Smooth transition */
            transition: opacity 0.4s ease-in-out, visibility 0.4s ease-in-out;
        }
        
        .myContainer.position-absolute {
            position: absolute;
        }

       
     .myContainer.fade-in-scroll {
            opacity: 1;
            visibility: visible;
        }

    @media (max-width: 1200px) {
        .text-fixed {
            font-size: 0.5rem;
        }

        #eye {
            right: 12px;
        }

        .item-count {
            font-size: 0.5rem;
        }

        .art-description {
            font-size: 0.5rem;
        }
    }

    .text-fixed1 {
        bottom: 25px;
    }

    .navbar {
        color: antiquewhite;
        font-family: 'Satoshi-Regular' !important;
        list-style: none;
        display: flex;
        align-items: center; /* <-- ensure navbar children are vertically centered */
        margin: 0;
        padding: 10px 20px;
        position: fixed;
        top: 10px;
        left: 50%;
        transform: translateX(-50%);
        width: auto;
        z-index: 1;
        background: transparent !important;
        border: none !important;
        backdrop-filter: none;
        -webkit-backdrop-filter: none;
    }

    #home-link.active-page {
        text-decoration: underline;
        text-underline-offset: 4px;
    }

    .footer {
        color: antiquewhite;
    font-family: 'Satoshi-Regular' !important;
        position: fixed;
        bottom: 0;
    }

    pre, p, .container {
        color: antiquewhite;
    }
    
    .container {
                    width:100%;
    }

    .links a {
        color: limegreen !important;
        font-size: large;
    }

    canvas {
        overflow-x: hidden;
    }

    li {
        color: blueviolet;
    }

    ul {
        list-style-type: none;
        margin: auto;
        padding: 0;
        position: relative;
        width: 100%;
    }

    .fade-in {
        opacity: 0;
        transition: opacity 1s ease-in;
    }

    .fade-in.show {
        opacity: 1;
    }

    .fade-in-fast {
        opacity: 0;
        transition: opacity 1s ease-in;
    }

    .fade-in-fast.show {
        opacity: 1;
    }

    #header {
        color: ghostwhite;
    }

    .navbar-transparent {
        background-color: transparent !important;
    }

    /* Force navbar text to be light/white (for dark backgrounds) */
    .navbar-dark-text .nav-link,
    .navbar-dark-text .nav-item,
    .navbar-dark-text .light-text,
    .navbar-dark-text .dark-text,
    .navbar-dark-text a {
        color: #ffffff !important;
    }
    
    .navbar-dark-text svg {
        fill: #ffffff !important;
        color: #ffffff !important;
    }

    .navbar-dark-text #toggleDarkLight img {
        filter: invert(1) !important;
    }

    .dark-bg {
        background-color: #0a0108 !important;
    }
    
             .image-container .col-12, .image-container .col-md-6, .image-container .col-6, .image-container .col-md-4, .image-container .col-4, .image-container .col-md-3, .image-container .col-3, .image-container .col-md-2{
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            align-items:center;
        }
  .image-div {
          z-index: -10;
            position: absolute;
            width: 100vw;
            height: calc(100vh - 10px);
            top: 0;
            left: 0;
        }
        .cursor-pointer{
            cursor:pointer;
        }
        .image-div img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    .light-bg {
        background-color: var(--white) !important;
    }

    .dark-border, .dark-border-top {
        border-bottom: 1px solid transparent;
        transition: border-bottom-color 1s ease-in;
    }

    .dark-border-top {
        border-top: 1px solid transparent;
        transition: border-top-color 1s ease-in;
    }

    .dark-border.fade-in {
        border-bottom-color: var(--dark) !important;
    }

    .dark-border-top.fade-in {
        border-top-color: var(--dark) !important;
    }
    
    .dark-border-full{
        border: 1px solid transparent;
        border-color: var(--dark) !important;
    }
    
    .light-border-full{
        border: 1px solid transparent;
        border-color: var(--white) !important;
    }


    .light-border, .light-border-top {
        border-bottom: 1px solid transparent;
        transition: border-bottom-color 1s ease-in;
    }

    .light-border-top {
        border-top: 1px solid transparent;
        transition: border-top-color 1s ease-in;
    }

    .light-border.fade-in {
        border-bottom-color: var(--white) !important;
    }

    .light-border-top.fade-in {
        border-top-color: var(--white) !important;
    }

    .light-border2 {
        border-bottom-color: var(--white) !important;
        border-bottom: 1px solid;
    }

    .dark-border2 {
        border-bottom-color: var(--dark) !important;
        border-bottom: 1px solid;
    }

    .light-text {
        color: var(--white);
    }

    .dark-text {
        color: #0a0108;
    }

    .view-tokens-btn {
        display: inline-block;
        padding: 12px 28px;
        background: transparent;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        letter-spacing: 1px;
        text-transform: uppercase;
        border-width: 1px;
        border-style: solid;
        border-color: currentColor;
        transition: all 0.2s ease;
    }

    .view-tokens-btn:hover {
        opacity: 0.7;
        text-decoration: none;
        color: inherit;
    }

    /* Shared art page styles */
    .art-page {
        padding: 40px 30px;
    }

    .art-page li {
        color: inherit;
    }

    .art-page h1 {
        margin-bottom: 4px;
    }

    .art-page .date {
        margin-bottom: 20px;
        font-size: 14px;
        letter-spacing: 1px;
    }

    .art-page .btn-row {
        margin-bottom: 30px;
    }

    @media (max-width: 768px) {
        .art-page {
            padding: 20px 16px;
        }
    }

    .art-page .description {
        margin-bottom: 30px;
        line-height: 1.7;
    }

    .art-page .contract-details {
        margin-bottom: 30px;
        line-height: 1.7;
    }

    .art-page .contract-details img {
        max-width: 100%;
        height: auto;
        margin-top: 10px;
    }

    .art-page .featured-img {
        text-align: center;
        margin: 30px 0;
    }

    .art-page .featured-img img {
        max-width: 100%;
        height: auto;
        border: 1px solid currentColor;
    }

    .art-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(500px, 1fr));
        gap: 16px;
        padding: 20px 0;
    }

    .art-gallery img {
        width: 100%;
        height: auto;
        display: block;
        opacity: 0;
        transition: opacity 0.8s ease;
    }

    .art-gallery img.lazyloaded {
        opacity: 1;
    }

    .art-gallery .wide {
        grid-column: 1 / -1;
    }

    @media (max-width: 768px) {
        .art-gallery {
            grid-template-columns: 1fr;
        }
    }

    /* Slideshow */
    .slideshow {
        position: relative;
        margin: 0 0 0 0;
        max-height: 90vh;
        display: inline-block;
        border: 1px solid currentColor;
        overflow: hidden;
    }

    .slideshow img {
        max-width: 100%;
        max-height: 90vh;
        height: auto;
        width: auto;
        display: block;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.6s ease;
        object-fit: contain;
        position: absolute;
        top: 0;
        left: 0;
    }

    .slideshow img.active {
        opacity: 1;
        visibility: visible;
        position: relative;
    }

    .slideshow-dots {
        display: flex;
        gap: 6px;
        justify-content: flex-start;
        margin-top: 8px;
        margin-bottom: 16px;
    }

    .slideshow-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        border: none;
        padding: 0;
        cursor: pointer;
        background: currentColor;
        opacity: 0.3;
        transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .slideshow-dot.active {
        opacity: 0.9;
        transform: scale(1.25);
    }

    .slideshow-dot:hover {
        opacity: 0.7;
    }

    .dark-bg-transparent {
        background-color: rgba(10, 1, 8, 0.9);
    }

    .light-bg-transparent {
        background-color: rgba(255, 255, 255, 0.9);
    }

    .dark-bg-transparent2 {
        background-color: rgba(10, 1, 8, 0.85);
    }

    .light-bg-transparent2 {
        background-color: rgba(255, 255, 255, 0.85);
    }

    .border-dotted {
        border-bottom: 0.3px dotted !important;
    }

    /* Ensure the dark/light toggle button and its icon are vertically centered */
    #toggleDarkLight {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 6px; /* small padding to give a consistent click area */
        margin-top: 0; /* override any accidental top offset */
        background: none !important;
        border: none !important;
    }

    /* Vertical-rl navbar option: writing vertical text from right to left.
       Apply by adding the 'vertical-rl' class to the #nav element, or use
       the URL parameter ?layout=vertical to enable it automatically.
    */
    .navbar.vertical-rl {
        writing-mode: vertical-rl;
        -webkit-writing-mode: vertical-rl;
        flex-direction: column;
        position: fixed;
        right: 10px; /* pin to the right side */
        left: auto;
        top: 50%;
        transform: translateY(-50%);
        padding: 8px 6px;
        background: transparent !important;
    }

    .navbar.vertical-rl .navbar-nav {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .navbar.vertical-rl .nav-item,
    .navbar.vertical-rl .nav-link {
        margin: 6px 0;
        padding: 2px 4px;
        writing-mode: vertical-rl;
        transform: none; /* ensure no extra transform interferes */
    }

    .navbar.vertical-rl #toggleDarkLight {
        margin: 6px 0 0 0;
        align-self: center;
    }

    </style>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.9.0/p5.js"></script>

    
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>

let isDarkMode = true;

function setInitialLightDarkMode() {
    const urlParams = new URLSearchParams(window.location.search);
    let mode = urlParams.get('mode');

    if (mode === null) {
        const cookieMode = getCookie('mode');
        console.log(cookieMode);
        if (cookieMode !== "") {
            mode = cookieMode;
             if (mode === "0") {
                setLightMode(true);  // Use dark mode if mode is 0
                isDarkMode = true;   // Update the local variable
            } else {
                setLightMode(false); // Use light mode if mode is 1
                isDarkMode = false;  // Update the local variable
            }
    } else {
            const now = new Date();
            const currentHour = now.getHours();

            // Default to dark mode and switch to light mode based on time
            if (currentHour >= 3 && currentHour < 22) {
                setLightMode(true); // Set to light mode during the day
                isDarkMode = true;  // Update the local variable
                mode = '1'; // Update mode
            } else {
                setLightMode(false);  // Set to dark mode during the night
                isDarkMode = false;   // Update the local variable
                mode = '0'; // Update mode
            }
        }
    } else {
        if (mode === "0") {
            setLightMode(true);  // Use dark mode if mode is 0
            isDarkMode = true;   // Update the local variable
        } else {
            setLightMode(false); // Use light mode if mode is 1
            isDarkMode = false;  // Update the local variable
        }
    }
    updateNavigationLinks(!isDarkMode);
}

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}


function setLightMode(isDark) {
    if (isDark) {
        $(".light-text").removeClass("light-text").addClass("dark-text");
        $(".dark-bg").removeClass("dark-bg").addClass("light-bg");
        $(".dark-bg-transparent").removeClass("dark-bg-transparent").addClass("light-bg-transparent");
        $(".dark-bg-transparent2").removeClass("dark-bg-transparent2").addClass("light-bg-transparent2");
        $(".dark-bg-transparent3").removeClass("dark-bg-transparent3").addClass("light-bg-transparent3");

        $(".light-border-top").removeClass("light-border-top").addClass("dark-border-top");
                $(".art-square-dark").removeClass("art-square-dark").addClass("art-square-light");

        $(".light-border").removeClass("light-border").addClass("dark-border2");
        $(".light-border2").removeClass("light-border2").addClass("dark-border2");
        $(".light-border-full").removeClass("light-border-full").addClass("dark-border-full");

        $("#darkMode").css("filter", "invert(0)");
    } else {
        $(".dark-text").removeClass("dark-text").addClass("light-text");
        $(".light-bg").removeClass("light-bg").addClass("dark-bg");
        $(".light-bg-transparent").removeClass("light-bg-transparent").addClass("dark-bg-transparent");
        $(".light-bg-transparent2").removeClass("light-bg-transparent2").addClass("dark-bg-transparent2");
                $(".art-square-light").removeClass("art-square-light").addClass("art-square-dark");
    $(".light-bg-transparent3").removeClass("light-bg-transparent3").addClass("dark-bg-transparent3");

        $(".dark-border").removeClass("dark-border").addClass("light-border2");
        $(".dark-border2").removeClass("dark-border2").addClass("light-border2");
        $(".dark-border-top").removeClass("dark-border-top").addClass("light-border-top");
        $("dark-border-full").removeClass("dark-border-full").addClass("light-border-full");

        $("#darkMode").css("filter", "invert(1)");
    }
    $("#toggleDarkLight").blur();
}

function toggleLightDark() {
    if (isDarkMode) {
        setLightMode(false);
        updateNavigationLinks(isDarkMode);
    } else {
        setLightMode(true);
        updateNavigationLinks(isDarkMode);
    }
    isDarkMode = !isDarkMode; // Toggle the local variable
}

$(document).ready(function() {
    setInitialLightDarkMode();
    // Apply vertical layout if requested via URL or cookie
    applyLayoutFromParam();
    $("#toggleDarkLight").on("click", function() {
        toggleLightDark();
    });
});

function applyLayoutFromParam() {
    const urlParams = new URLSearchParams(window.location.search);
    let layout = urlParams.get('layout');
    if (!layout) {
        // fallback to cookie
        const layoutCookie = getCookie('layout');
        if (layoutCookie) layout = layoutCookie;
    }
    if (layout && (layout === 'vertical' || layout === 'vertical-rl')) {
        const nav = document.getElementById('nav');
        if (nav) {
            nav.classList.add('vertical-rl');
        }
        // persist preference in a cookie so reloads keep it
        document.cookie = `layout=vertical; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/`;
    }
}

function updateNavigationLinks(isDark) {
    const mode = isDark ? '1' : '0'; // 0 for dark mode, 1 for light mode
    document.querySelectorAll('.nav-link-2').forEach(function(link) {
        const href = link.getAttribute('href').split('?')[0]; // Get the base URL without any existing query parameters
        const newHref = `${href}?mode=${mode}`; // Create the new href with the mode query parameter
        link.setAttribute('href', newHref); // Update the href attribute with the mode query parameter
    });
  // Get the current URL and query parameters
const url = new URL(window.location.href);
const searchParams = new URLSearchParams(url.search);

// Update or add the 'mode' parameter
searchParams.set('mode', mode);

// Reconstruct the URL with the updated query parameters
url.search = searchParams.toString();

// Replace the URL in the browser without reloading the page
history.replaceState({}, document.title, url.toString());

    // Update the cookies with the mode
    document.cookie = `mode=${mode}; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/`;
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.fade-in').forEach(function(element) {
        element.classList.add('show');
    });
});

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.fade-in-fast').forEach(function(element) {
        element.classList.add('show');
    });
});

document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            document.getElementById('nav').classList.add('fade-in');
        }, 100); // Add a slight delay to ensure transition is visible
  		setTimeout(function() {
            document.getElementById('footer').classList.add('fade-in');
        }, 100); // 
        
    });
    $(document).ready(function() {
      // Function to check if the screen width is less than or equal to 768px (typically considered as mobile)
      function adjustFooterTextSize() {
        if ($(window).width() <= 1200) {
          $("#footer-text").css("font-size", "12px");
          $("#eye").css("top","-24px");
        } else {
        }
      }

      // Call the function on page load
      adjustFooterTextSize();

      // Call the function when the window is resized
      $(window).resize(function() {
        adjustFooterTextSize();
      });
    });

    // Shared lazy-load observer for all art pages
    document.addEventListener("DOMContentLoaded", function() {
        var lazyImages = [].slice.call(document.querySelectorAll("img.lazy"));
        if ("IntersectionObserver" in window) {
            var lazyImageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        var lazyImage = entry.target;
                        lazyImage.src = lazyImage.dataset.src;
                        lazyImage.classList.remove("lazy");
                        lazyImage.classList.add("lazyloaded");
                        lazyImageObserver.unobserve(lazyImage);
                    }
                });
            });
            lazyImages.forEach(function(lazyImage) {
                lazyImageObserver.observe(lazyImage);
            });
        }
    });

    // Sync slideshow-dots width with slideshow image width
    document.addEventListener("DOMContentLoaded", function() {
        var slideshow = document.getElementById('slideshow');
        var dots = document.getElementById('slideshowDots');
        if (!slideshow || !dots) return;
        function syncDotsWidth() {
            dots.style.width = '';
        }
        syncDotsWidth();
    });
    </script>
</head>

<body class="fade-in-fast dark-bg">
    
<nav id="nav" class="navbar navbar-expand navbar-custom navbar-transparent fade-in-fast">
  <div class="navbar-nav mr-auto ">
    <a id="home-link" class="nav-item nav-link nav-link-2 light-text font-16" style="margin-top:1.5px;" href="https://www.andrewmitchell.xyz"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
  <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"></path>
</svg></a>
    <a class="nav-item nav-link nav-link-2 underline light-text font-16" href="/art.php">ART</a>
    <a class="nav-item nav-link nav-link-2 underline light-text font-16" href="/collections/" target="catalog">CATALOG</a>
    <a class="nav-item nav-link nav-link-2 underline light-text font-16" href="/about.php">ABOUT</a>

  </div>
   <button id="toggleDarkLight" class="btn ml-auto"  style="background: none;"><img id="darkMode" height="16px" width="16px" style="filter:invert(1)" src="https://andrewmitchell-art.xyz/images/dark-icon.png" alt="Light Dark Toggle"/></button>
</nav>
