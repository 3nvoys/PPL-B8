<?php

@include 'koneksi.php';

session_start();

$owner_id = $_SESSION['owner_id'];

if(!isset($owner_id)){
   header('location:login_owner.php');
};

if(isset($_POST['add_product'])){

   $nama_produk = $_POST['nama_produk'];
   $nama_produk = filter_var($nama_produk, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $owner = $_POST['owner'];
   $owner = filter_var($owner, FILTER_SANITIZE_STRING);
   $varian = $_POST['varian'];
   $varian = filter_var($varian, FILTER_SANITIZE_STRING);
   $ukuran = $_POST['ukuran'];
   $ukuran = filter_var($ukuran, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select_products = $conn->prepare("SELECT * FROM `produk` WHERE nama_produk = ?");
   $select_products->execute([$nama_produk]);

   if($select_products->rowCount() > 0){
      $message[] = 'Produk tersebut sudah ada!';
   }else{

      $insert_products = $conn->prepare("INSERT INTO `produk`(nama_produk, harga, produk_image, fid_owner, fid_varian, fid_ukuran) VALUES(?,?,?,?,?,?)");
      $insert_products->execute([$nama_produk, $price, $image, $owner_id, $varian, $ukuran]);

      if($insert_products){
         if($image_size > 2000000){
            $message[] = 'ukuran foto terlalu besar!';
         }else{
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'produk baru ditambahkan!';
         }

      }

   }

};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $select_delete_image = $conn->prepare("SELECT image FROM `produk` WHERE id_produk = ?");
   $select_delete_image->execute([$delete_id]);
   $fetch_delete_image = $select_delete_image->fetch(PDO::FETCH_ASSOC);
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   $delete_products = $conn->prepare("DELETE FROM `produk` WHERE id_produk = ?");
   $delete_products->execute([$delete_id]);
   // $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ?");
   // $delete_wishlist->execute([$delete_id]);
   // $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
   // $delete_cart->execute([$delete_id]);
   header('location:owner_products.php');


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>produk</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/owner_stile.css">

</head>
<body>
   
<?php include 'owner_header.php'; ?>

<section class="add-products">

   <h1 class="title">Tambah Produk</h1>

   <form action="" method="POST" enctype="multipart/form-data">
      <div class="flex">
         <div class="inputBox">
         <input type="text" name="name" class="box" required placeholder="enter product name">
         <select name="category" class="box" required>
            <option value="" selected disabled>pilih varian</option>
               <option value="Pedas">Pedas</option>
               <option value="Jagung bakar">Jagung bakar</option>
               <option value="Manis">Manis</option>
               <option value="Original">Original</option>
         </select>
         </div>
         <div class="inputBox">
         <input type="number" min="0" name="price" class="box" required placeholder="enter product price">
         <input type="file" name="image" required class="box" accept="image/jpg, image/jpeg, image/png">
         </div>
      </div>
      <!-- <textarea name="details" class="box" required placeholder="enter product details" cols="30" rows="10"></textarea> -->
      <input type="submit" class="btn" value="tambah produk" name="add_product">
   </form>

</section>

<section class="show-products">

   <h1 class="title">Produk Tersedia</h1>

   <div class="box-container">

   <?php
      $show_products = $conn->prepare("SELECT * FROM `produk`");
      $show_products->execute();
      if($show_products->rowCount() > 0){
         while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <div class="box">
      <div class="price">Rp. <?= $fetch_products['harga']; ?>/-</div>
      <img src="uploaded_img/<?= $fetch_products['produk_image']; ?>" alt="">
      <div class="name"><?= $fetch_products['nama_produk']; ?></div>
      <div class="cat"><?= $fetch_products['fid_varian']; ?></div>
      <div class="flex-btn">
         <a href="admin_update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">update</a>
         <a href="admin_products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
      </div>
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">now products added yet!</p>';
   }
   ?>

   </div>

</section>











<script src="js/script.js"></script>

</body>
</html>