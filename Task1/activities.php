<?php

include 'config1.php';

// session_start();

// $user_id = $_SESSION['user_id'];

// if(!isset($user_id)){
//    header('location:login.php');4


if(isset($_POST['add_to_cart'])){
//    if(!isset($user_id)){
//    header('location:login.php');
//    }else{
   $event_name = $_POST['event_name'];
//    $event_price = $_POST['event_price'];
//    $event_image = $_POST['event_image'];
   $event_date = $_POST['event_date'];
//    $event_venue = $_POST['event_venue'];
//    $event_category = $_POST['event_category'];
//    $event_desc = $_POST['event_desc'];


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
   <title>engineering book</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <!-- favicon -->
   <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
   <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
   <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
   <link rel="manifest" href="favicon/site.webmanifest">
</head>
<body>
   
<?php 
if(!isset($user_id)){
   
   include 'header.php'; 
   }
else{

   include 'header1.php'; 
}

?>

<div class="movie-heading">
   <h3>Discover Latest Activities</h3>
</div>

<section class="products">

   <div class="box-container">

   <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `events` WHERE category='activities'") or die('query failed1111');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
            $date = date('d F Y', strtotime($fetch_products['date']));
      ?>
     <form action="" method="post" class="box">
      <img class="image" src="uploaded_img/<?php echo $fetch_products['img']; ?>" alt="">
      <div class="name"><?php echo $fetch_products['name']; ?></div>
      <div class="date"><?php echo $date?></div>
      <div class="venue"><?php echo $fetch_products['venue']; ?></div>
      <span class="name">Prices start from </span><span class="price1">₹<?php echo $fetch_products['price']; ?></span>

      <!-- check whether the item is already added to the cart or not -->
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