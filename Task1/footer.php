<?php
if(!isset($user_id)){
?>
<html>
   <head>
      <link rel="stylesheet" href="style.css">
   </head>
<section class="footer">

<p class="credit">
    &copy; <?php echo date('Y'); ?> All rights reserved by  <br>
    <a href="home.php">
   <img src="images/logo-bg.png" alt="" style="margin-bottom:0rem;padding-top:1rem;width:20rem;height:10rem;">
   </a> </p>

</section>

<?php 
}
else{
?>
   <section class="footer">
   <p class="credit"> &copy; <?php echo date('Y'); ?> All rights reserved by <a href="home.php"><span><img src="images/logo-bg.png" alt=""></span></a> </p>

</section>
</html>
<?php
}
?> 
