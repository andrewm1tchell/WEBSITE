<!DOCTYPE html>
<html lang="en">
<head>
   <?php include '../meta.php'; ?>
   <script>
          document.title = "Andrew Mitchell - Gentle Skies";

       document.addEventListener('DOMContentLoaded', function() {
           document.querySelectorAll('a.nav-item.nav-link').forEach(function(el) {
               if (el.textContent.includes('ART')) el.style.textDecoration = 'underline';
           });
       });
   </script>
</head>
<body>
 <div class="art-page">
        <h1 class="light-text"><em>Gentle Skies</em></h1>
        <p class="date light-text">2022-2024</p>

        <div class="description light-text">
                    Welcome to my on-cyber gallery, Gentle Skies. This virtual gallery showcases all the art I have created over the years 2022-2024. All the work was built algorithmically with handwritten code. The music is also all self-produced and accompanies the work.
        </div>

        <p>
            <img src="https://cyber.mypinata.cloud/ipfs/QmTBSws6CmY15ZdEY5euRwFnUsQVZny3iwCyBLiLACSUgK" alt="Gentle Skies Gallery" style="max-width: 100%;">
        </p>

        <img src="../images/gentle-skies-description.png" style="max-width: 100%; margin-bottom: 1rem;" alt="Art Image 2">

        <img src="https://images.squarespace-cdn.com/content/637d087cfeae7764854916c4/27386416-4c5a-4e3e-8b8c-0803312bb764/Gentle+Skies-0.jpg?content-type=image%2Fjpeg" style="max-width: 100%; margin-bottom: 1rem;" alt="Art Image 1">

        <video style="width: 100%;" controls autoplay muted>
              <source src="../images/gentleskies.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <div style="margin-top: 1rem;">
            <a href="https://oncyber.io/gentle-skies" target="_blank"><i class="fa fa-external-link"></i> Visit the Gentle Skies On-Cyber Gallery</a>
        </div>
    </div>

   <?php include '../footer.php'; ?>

</body>
</html>
