<?php

@include 'koneksi.php';

session_start();

$pelanggan_id = $_SESSION['pelanggan_id'];

if(!isset($pelanggan_id)){
   header('location:login_pelanggan.php');
};

// if(isset($_POST['add_to_wishlist'])){

//    $pid = $_POST['pid'];
//    $pid = filter_var($pid, FILTER_SANITIZE_STRING);
//    $p_name = $_POST['p_name'];
//    $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
//    $p_price = $_POST['p_price'];
//    $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
//    $p_image = $_POST['p_image'];
//    $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);

//    $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
//    $check_wishlist_numbers->execute([$p_name, $user_id]);

//    $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
//    $check_cart_numbers->execute([$p_name, $user_id]);

//    if($check_wishlist_numbers->rowCount() > 0){
//       $message[] = 'already added to wishlist!';
//    }elseif($check_cart_numbers->rowCount() > 0){
//       $message[] = 'already added to cart!';
//    }else{
//       $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
//       $insert_wishlist->execute([$user_id, $pid, $p_name, $p_price, $p_image]);
//       $message[] = 'added to wishlist!';
//    }

// }

// if(isset($_POST['add_to_cart'])){

//    $pid = $_POST['pid'];
//    $pid = filter_var($pid, FILTER_SANITIZE_STRING);
//    $p_name = $_POST['p_name'];
//    $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
//    $p_price = $_POST['p_price'];
//    $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
//    $p_image = $_POST['p_image'];
//    $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);
//    $p_qty = $_POST['p_qty'];
//    $p_qty = filter_var($p_qty, FILTER_SANITIZE_STRING);

//    $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
//    $check_cart_numbers->execute([$p_name, $user_id]);

//    if($check_cart_numbers->rowCount() > 0){
//       $message[] = 'already added to cart!';
//    }else{

//       $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
//       $check_wishlist_numbers->execute([$p_name, $user_id]);

//       if($check_wishlist_numbers->rowCount() > 0){
//          $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
//          $delete_wishlist->execute([$p_name, $user_id]);
//       }

//       $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
//       $insert_cart->execute([$user_id, $pid, $p_name, $p_price, $p_qty, $p_image]);
//       $message[] = 'added to cart!';
//    }

// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/stile.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="home-bg">

   <section class="home">

      <div class="content">
         <span>Lorem ipsum dolor sit</span>
         <h3>Lorem ipsum dolor sit amet consectetur adipisicing elit.</h3>
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iusto natus culpa officia quasi, accusantium explicabo?</p>
         <a href="about.php" class="btn">about us</a>
      </div>

   </section>

</div>

<!-- <section class="home-category">

   <h1 class="title">shop by category</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/cat-1.png" alt="">
         <h3>fruits</h3>
         <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem, quaerat.</p>
         <a href="category.php?category=fruits" class="btn">fruits</a>
      </div>

      <div class="box">
         <img src="images/cat-2.png" alt="">
         <h3>meat</h3>
         <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem, quaerat.</p>
         <a href="category.php?category=meat" class="btn">meat</a>
      </div>

      <div class="box">
         <img src="images/cat-3.png" alt="">
         <h3>vegitables</h3>
         <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem, quaerat.</p>
         <a href="category.php?category=vegitables" class="btn">vegitables</a>
      </div>

      <div class="box">
         <img src="images/cat-4.png" alt="">
         <h3>fish</h3>
         <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Exercitationem, quaerat.</p>
         <a href="category.php?category=fish" class="btn">fish</a>
      </div>

   </div>

</section> -->

<section class="products">

   <h1 class="title">Produk</h1>

   <div class="box-container">

   <?php
      $select_produk = $conn->prepare("SELECT * FROM `produk` JOIN `owner` 
      ON `produk`.`fid_owner` = `owner`.`id_owner` JOIN `pelanggan` 
      ON `pelanggan`.`fid_owner` = `owner`.`id_owner` JOIN `varian` 
      ON `produk`.`fid_varian` = `varian`.`id_varian`
      where `id_pelanggan` = ?;");
      $select_produk->execute([$pelanggan_id]);
      if($select_produk->rowCount() > 0){
         while($fetch_produk = $select_produk->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" class="box" method="POST">
      <div class="price">Rp.<span><?= $fetch_produk['harga']; ?></span>/-</div>

      <a href="view_page.php?pid=<?= $fetch_produk['id_produk']; ?>"><img src="uploaded_img/<?= $fetch_produk['produk_image']; ?>" alt=""></a>
      <div class="name"><?= $fetch_produk['nama_produk']; ?> - <?= $fetch_produk['varian']; ?></div>
      <!-- <div class="details"><?//= $fetch_produk['details']; ?></div> -->
      <input type="hidden" name="pid" value="<?= $fetch_produk['id_produk']; ?>">
      <input type="hidden" name="p_name" value="<?= $fetch_produk['nama_produk']; ?>">
      <input type="hidden" name="p_price" value="<?= $fetch_produk['harga']; ?>">
      <input type="hidden" name="p_image" value="<?= $fetch_produk['image']; ?>">
      <p>jumlah : <input type="number" min="1" value="1" name="p_qty" class="qty"></p>
      <!-- <input type="submit" value="add to wishlist" class="option-btn" name="add_to_wishlist"> -->
      <input type="submit" value="Tambah Permintaan" class="btn" name="add_to_cart">
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">no produk added yet!</p>';
   }
   ?>

   </div>

</section>







<?php //include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>