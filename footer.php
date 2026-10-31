<footer id="footer" class="footer p-1 dark-bg light-border-top fade-in-fast" style="
    position: fixed;
    bottom: 0px;
    width: 100vw;
    z-index: 100;
">

  <style>
    #footer { display: flex; align-items: center; }
    #footer-text { flex: 1 1 auto; min-width: 0; }

    #footer-list-link {
      margin-left: auto;              /* pins it to the far right */
      flex: 0 0 auto;
      align-items: center;
      justify-content: center;
      padding: 8px;                   /* ~34px tap target on mobile */
      line-height: 1;
      opacity: .85;
      color: #fff;                    /* dark mode */
      transition: opacity .2s ease;
      -webkit-tap-highlight-color: transparent;
    }
    #footer.light-bg #footer-list-link,
    body.light-bg #footer-list-link { color: #111; }   /* light mode */
    #footer-list-link:hover,
    #footer-list-link:focus-visible { opacity: 1; }
    #footer-list-link svg { display: block; width: 18px; height: 18px; }

    @media (max-width: 600px) {
      #footer-list-link { padding: 6px; }
      #footer-list-link svg { width: 20px; height: 20px; }
    }
  </style>

  <text id="footer-text" class="light-text">© Andrew Mitchell
    <a href="mailto:andrewmitchellart@proton.me"  style="margin-left:1px"> Email</a> |
    <a target="_blank" href="https://twitter.com/4ndrew_mitchell"> Twitter</a> |
      <a target="_blank" href="https://instagram.com/4ndrew_mitchell"> Instagram</a>
 </text>

  <a id="footer-list-link" class="light-text fade-in-fast"
     href="https://opensea.io/item/ethereum/0x61559410389a46be8c5e92acb7a39b8f9db35196/9"
     target="_blank" rel="noopener noreferrer"
     aria-label="Catalog" title="Catalog"
     style="display:none">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="bi bi-list" aria-hidden="true">
      <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5"/>
    </svg>
  </a>

  <script>
    // Only surface the list link on art.php
    (function () {
      if (!/(^|\/)art\.php$/i.test(window.location.pathname)) return;
      var el = document.getElementById('footer-list-link');
      if (el) el.style.display = 'inline-flex';
    })();
  </script>
</footer>
