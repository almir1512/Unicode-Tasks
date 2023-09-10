<?php

include 'config1.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['add_product'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = $_POST['price'];
   $description=  $_POST['description'];
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;
   $date = $_POST['date'];
   $venue = $_POST['venue'];
   $category = $_POST['category'];

   $select_product_name = mysqli_query($conn, "SELECT name FROM `events` WHERE name = '$name'") or die('query failed11');

   if(mysqli_num_rows($select_product_name) > 0){
      $message[] = 'event already added';
   }else{
      $add_product_query = mysqli_query($conn, "INSERT INTO `events`(name, price,description,date,venue,category, img) VALUES('$name', '$price','$description','$date','$venue','$category', '$image')") or die('query failed12');

      if($add_product_query){
         if($image_size > 2000000){
            $message[] = 'image size is too large';
         }else{
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'product added successfully!';
         }
      }else{
         $message[] = 'product could not be added!';
      }
   }
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_image_query = mysqli_query($conn, "SELECT img FROM `events` WHERE id = '$delete_id'") or die('query failed13');
   $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   mysqli_query($conn, "DELETE FROM `events` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_products.php');
}

if(isset($_POST['update_product'])){

   $update_p_id = $_POST['update_p_id'];
   $update_name = $_POST['update_name'];
   $update_price = $_POST['update_price'];
   $update_desc = $_POST['update_desc'];
   $update_venue = $_POST['update_venue'];
   $update_date = $_POST['update_date'];
   $updated_category = $_POST['upd_category'];

   mysqli_query($conn, "UPDATE `events` SET name = '$update_name',date='$update_date', description='$update_desc',venue='$update_venue', price = '$update_price',category='$updated_category' WHERE id = '$update_p_id'") or die('query failed');

   $update_image = $_FILES['update_image']['name'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_folder = 'uploaded_img/'.$update_image;
   $update_old_image = $_POST['update_old_image'];

   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'image file size is too large';
      }else{
         mysqli_query($conn, "UPDATE `products` SET image = '$update_image' WHERE id = '$update_p_id'") or die('query failed');
         move_uploaded_file($update_image_tmp_name, $update_folder);
         unlink('uploaded_img/'.$update_old_image);
      }
   }

   header('location:admin_products.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
   
   <!-- favicon -->
   <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
   <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
   <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
   <link rel="manifest" href="favicon/site.webmanifest">


</head>
<body>
   
<?php include 'admin_header.php'; ?>
 
<!-- product CRUD section starts  -->

<section class="add-products">

   <h1 class="title"></h1>

   <form action="" method="post" enctype="multipart/form-data">
      <h3>add event</h3>
      <input type="text" name="name" class="box" placeholder="enter event name" required>
      <input type="number" min="0" name="price" class="box" placeholder="enter ticket price" required>
      <input type="textarea" class="box" name="description" placeholder="enter the event description" required>
      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
      <input placeholder="enter event date" name="date" class="box"  type="text"  onfocus="(this.type='date')"  id="date" />
      <input class = "box"type="text" name="venue" placeholder="enter event venue">
      <select name="category" class="box">
         <option value="" disabled selected>Select Event Category</option>
         <option value="movie">Movies</option>
         <option value="liveshow">Live Shows</option>
         <option value="sport">Sports</option>
         <option value="plays">Plays</option>
         <option value="activities">Activities</option>
         <option value="other">Other</option>
      </select>
      <input type="submit" value="add product" name="add_product" class="btn">
   </form>

</section>
<!-- product CRUD section ends -->

<!-- show products  -->

<section class="show-products">

   <div class="box-container">

      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `events`") or die('query failed14');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
      
      <div class="box">
         <div class="name"><?php echo $fetch_products['name']; ?></div>
         <div class="price"><?php echo $fetch_products['price']; ?>/-</div>
         <div class="description"><?php echo $fetch_products['description']; ?></div>
         <div class="date"><?php echo $fetch_products['date']; ?></div>
         <div class="venue"><?php echo $fetch_products['venue']; ?></div>
         <div class="category"><?php echo $fetch_products['category']; ?></div>

         <a href="admin_products.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">update</a>
         <a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>
</section>

<section class="edit-product-form">

   <?php
      if(isset($_GET['update'])){
         $update_id = $_GET['update'];
         $update_query = mysqli_query($conn, "SELECT * FROM `events` WHERE id = '$update_id'") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
      <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
      <img src="uploaded_img/<?php echo $fetch_update['image']; ?>" alt="">
      <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="enter product name">
      <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" min="0" class="box" required placeholder="enter product price">
      <input type="textarea" name="update_desc" value="<?php echo $fetch_update['description']?>" class="box" required placeholder="enter description">
      <input type="date" name="update_date" value = "<?php echo $fetch_update['date']?>" class="box">
      <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
      <input type="text" name="update_venue" value="<?php echo $fetch_update['venue']; ?>" class="box" required placeholder="enter venue name">
      <select placeholder="Register as" name="upd_category" class="box">
         <option value="" disabled selected>Select Event Category</option>
         <option value="movie">Movies</option>
         <option value="liveshow">Live Shows</option>
         <option value="sport">Sports</option>
         <option value="plays">Plays</option>
         <option value="activities">Activities</option>
         <option value="other">Other</option>
      </select>
      <input type="submit" value="update" name="update_product" class="btn">
      <input type="reset" value="cancel" id="close-update" class="option-btn">
   </form>
   <?php
         }
      }
      }else{
         echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
      }
   ?>

</section>







<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>