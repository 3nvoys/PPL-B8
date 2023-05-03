<?php

if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}

?>

<header class="header">

   <div class="flex">

      <a href="" class="logo">J-Star<span>.</span></a>

      <nav class="navbar">
         <a href="home.php">home</a>
         <a href="produk.php">produk</a>
         <a href="orders.php">permintaan</a>
         <!-- <a href="about.php">about</a>
         <a href="contact.php">contact</a> -->
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
         <a href="search_page.php" class="fas fa-search"></a>
         <?php
            $count_cart_items = $conn->prepare("SELECT * FROM `permintaan` WHERE fid_pelanggan = ?");
            $count_cart_items->execute([$pelanggan_id]);
         ?>
         <a href="keranjang.php"><i class="fas fa-shopping-cart"></i><span>(<?= $count_cart_items->rowCount(); ?>)</span></a>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `pelanggan` WHERE id_pelanggan = ?");
            $select_profile->execute([$pelanggan_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <img src="uploaded_img/<?= $fetch_profile['image']; ?>" alt="">
         <p><?= $fetch_profile['nama']; ?></p>
         <a href="profil.php" class="btn">lihat profil</a>
         <a href="logout.php" class="delete-btn">logout</a>
         <a href="login_pelanggan.php" class="option-btn">login</a>
         <!-- <div class="flex-btn"> -->
            <!-- <a href="login.php" class="option-btn">login</a> -->
            <!-- <a href="register.php" class="option-btn">register</a> -->
         <!-- </div> -->
      </div>

   </div>

</header>