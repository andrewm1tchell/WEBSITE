<!DOCTYPE html>
<html lang="en">
<head>
   <?php include '../meta.php'; ?>
   <script>
       document.title = "Andrew Mitchell - ???";
       document.addEventListener('DOMContentLoaded', function() {
           document.querySelectorAll('a.nav-item.nav-link').forEach(function(el) {
               if (el.textContent.includes('ART')) el.style.textDecoration = 'underline';
           });
       });
   </script>
   <style>
       .instagram-embed-wrap {
           width: 100%;
           max-width: 1200px;
           height: calc(100vh - 80px);
           border: 1px solid currentColor;
           overflow: hidden;
       }
       .instagram-embed-wrap iframe {
           width: 100%;
           height: 100%;
           border: none;
       }
   </style>
</head>
<body>
<div class="art-page light-text">
    <div class="instagram-embed-wrap">
        <iframe src="https://www.instagram.com/4ndrew_mitchell/embed" scrolling="yes" allowtransparency="true"></iframe>
    </div>
</div>

<div class="footer mt-5">
    <?php include '../footer.php'; ?>
</div>
</body>
</html>
