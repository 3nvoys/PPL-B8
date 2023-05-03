<?php

@include 'koneksi.php';

session_start();

$pelanggan_id = $_SESSION['pelanggan_id'];

if(!isset($pelanggan_id)){
   header('location:login_pelanggan.php');
};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_cart_item = $conn->prepare("DELETE FROM `permintaan` WHERE id_req = ?");
   $delete_cart_item->execute([$delete_id]);
   header('location:keranjang.php');
}

if(isset($_GET['delete_all'])){
   $delete_cart_item = $conn->prepare("DELETE FROM `permintaan` WHERE fid_pelanggan = ?");
   $delete_cart_item->execute([$pelanggan_id]);
   header('location:keranjang.php');
}

if(isset($_POST['update_qty'])){
   $cart_id = $_POST['cart_id'];
   $p_qty = $_POST['p_qty'];
   $p_qty = filter_var($p_qty, FILTER_SANITIZE_STRING);
   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
   $update_qty->execute([$p_qty, $cart_id]);
   $message[] = 'cart quantity updated';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shopping cart</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/stile.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="shopping-cart">

   <h1 class="title">daftar permintaan produk</h1>

   <div class="box-container">

   <?php
      $grand_total = 0;
      $select_cart = $conn->prepare("SELECT * FROM `permintaan` JOIN `produk` 
      ON `permintaan`.`fid_produk` = `produk`.`id_produk` 
      WHERE fid_pelanggan = ?");
      $select_cart->execute([$pelanggan_id]);
      if($select_cart->rowCount() > 0){
         while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" method="POST" class="box">
      <a href="keranjang.php?delete=<?= $fetch_cart['id_req']; ?>" class="fas fa-times" onclick="return confirm('delete this from cart?');"></a>
      <a href="view_page.php?pid=<?= $fetch_cart['id_produk']; ?>"><img src="uploaded_img/<?= $fetch_cart['produk_image']; ?>" alt=""></a>
      <div class="name"><?= $fetch_cart['nama_produk']; ?></div>
      <div class="price">Rp.<?= $fetch_cart['harga']; ?>/-</div>
      <input type="hidden" name="cart_id" value="<?= $fetch_cart['id_req']; ?>">
      <div class="flex-btn">
         <input type="number" min="1" value="<?= $fetch_cart['jumlah_req']; ?>" class="qty" name="p_qty">
         <input type="submit" value="update" name="update_qty" class="option-btn">
      </div>
      <div class="sub-total"> sub total : <span>Rp.<?= $sub_total = ($fetch_cart['harga'] * $fetch_cart['jumlah_req']); ?>/-</span> </div>
   </form>
   <?php
      $grand_total += $sub_total;
      }
   }else{
      echo '<p class="empty">your cart is empty</p>';
   }
   ?>
   </div>

   <div class="cart-total">
      <p>grand total : <span>Rp. <?= $grand_total; ?>/-</span></p>
      <a href="shop.php" class="option-btn">kembali</a>
      <a href="keranjang.php?delete_all" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>">hapus semua</a>
      <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">minta</a>
   </div>

</section>








<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>