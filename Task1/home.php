<?php

include 'config1.php';

if(isset($_POST['add_to_cart'])){
      $event_name = $_POST['event_name'];
      $event_date = $_POST['event_date'];
   
      $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `events` WHERE name = '$event_name'") or die('query failed');
   
      mysqli_query($conn, "INSERT INTO `desc`( name,date) VALUES('$event_name','$event_date')") or die('query failed');
      header('location:description.php');
      
   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link href="https://fonts.googleapis.com/css?family=Teko:700&display=swap" rel="stylesheet">

   <!--favicon -->
   <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
   <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
   <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
   <link rel="manifest" href="favicon/site.webmanifest">

</head>
<body>

<?php include 'header.php'; ?>

<section class="home">

   <div class="content">
   <h4>
  <span>The</span>
  <span>Easiest</span>
  <span>way</span>
  <span>to</span>
  <span>book</span>
  <span>your</span>
  <span>next</span>
  <span>experience</span>
  <span>online !</span>
  
</h4>
   </div>

</section>
<section class="products">

   <h1 class="title">recommended movies</h1>

   <div class="box-container">

     <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `events` WHERE category='movie' LIMIT 4") or die('query failed1111');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
            $date = date('d F Y', strtotime($fetch_products['date']));
      ?>
     <form action="" method="post" class="box">
      <img class="image" src="uploaded_img/<?php echo $fetch_products['img']; ?>" alt="">
      <div class="name"><?php echo $fetch_products['name']; ?></div>
      <div class="date"><?php echo $date?></div>
      <div class="venue"><?php echo $fetch_products['venue']; ?></div>
      <span class="start-price">Prices starts from </span><span class="price1">₹<?php echo $fetch_products['price']; ?></span>
      <input type="hidden" name="event_name" value="<?php echo $fetch_products['name']; ?>">
      <input type="hidden" name="event_date"  value="<?php echo $fetch_products['date']; ?>">

      <input type="submit" value="Book Now" name="add_to_cart" class="btn">
     </form>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }  
      ?>
   </div>

   <div class="load-more" style="margin-top: 2rem; text-align:center">
      <a href="movies.php" class="option-btn">load more</a>
   </div>

</section>
<hr class="style-one">
<section class="products">

   <h1 class="title">latest events</h1>

   <div class="box-container">

     <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `events` LIMIT 8") or die('query failed1111');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
            $date = date('d F Y', strtotime($fetch_products['date']));
      ?>
     <form action="" method="post" class="box">
      <img class="image" src="uploaded_img/<?php echo $fetch_products['img']; ?>" alt="">
      <div class="name"><?php echo $fetch_products['name']; ?></div>
      <div class="date"><?php echo $date?></div>
      <div class="venue"><?php echo $fetch_products['venue']; ?></div>
      <span class="start-price">Prices starts from </span><span class="price1">₹<?php echo $fetch_products['price']; ?></span>
      <input type="hidden" name="event_name" value="<?php echo $fetch_products['name']; ?>">
      <input type="hidden" name="event_date"  value="<?php echo $fetch_products['date']; ?>">

      <input type="submit" value="Book Now" name="add_to_cart" class="btn">
     </form>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }  
      ?>
   </div>

  

</section>






<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
