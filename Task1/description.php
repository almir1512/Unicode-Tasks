<?php

include 'config1.php';

// session_start();

// $user_id = $_SESSION['user_id'];

// if(!isset($user_id)){
//    header('location:login.php');
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
   <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
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
$fetch1 = mysqli_query($conn, "SELECT * FROM `desc` ORDER BY id DESC LIMIT 1") or die('query failed1111');
$fetch_events1 = mysqli_fetch_assoc($fetch1);
$event_name = $fetch_events1['name'];

$sql = "SELECT * FROM `events` WHERE name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $event_name);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// $select_events = mysqli_query($link, "SELECT * FROM `events` WHERE name='{$event_name}'") or die('query failed');
if(mysqli_num_rows($result) > 0){
//     $fetch_events = mysqli_fetch_assoc($select_events);
    $date = date('d F Y', strtotime($row['date']));
    $event_name1=$row['name'];
   $event_price = $row['price'];
   $event_image = $row['img'];
   $event_venue = $row['venue'];
   $event_category =$row['category'];
   $event_desc = $row['description'];
}else{
    echo $event_name;
}
?>

<section class="description">
<img class="grid-item" style="width:90%;height:90%;border: 3px solid rgba(0, 0, 0, 0.8);" src="uploaded_img/<?php echo $row['img']; ?>" alt="">
<div class="grid-item"><div class="name"><?php echo $event_name?></div> 
<div class="title1">About the event :</div> 
<div class="desc"><?php echo $event_desc?></div>
<span class="title1">Date :</span> 
<span class="date"><?php echo $date?></span> <br>
<span class="title1">City :</span>   
<span class="venue"><?php echo $event_venue?></span><br>
<span class="title1">Prices start from ₹</span>   
<span class="price"><?php echo $event_price?>/-</span> 

</div>

</section>





<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>