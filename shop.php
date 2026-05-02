<!DOCTYPE html>
<html lang="en">
   <?php include 'meta.php'; ?>
   <script>
          document.title = "Andrew Mitchell - Shop";

       $(document).ready(function() {
        $("a.nav-item.nav-link:contains('SHOP')").css("text-decoration", "underline");
    });
    let url = window.location.href;
    if(url.indexOf("mode=1") > -1) {
    window.location.href="https://andrewmitchell.xyz/shop?mode=1";
    } else {
            window.location.href="https://andrewmitchell.xyz/shop?mode=0";

    }
   </script>


</body>
   <?php include 'footer.php'; ?>

</html>
