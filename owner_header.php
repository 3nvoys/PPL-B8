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

      <a href="owner_page.php" class="logo">Owner<span> J-Star</span></a>

      <nav class="navbar">
         <a href="owner_page.php">home</a>
         <a href="owner_products.php">produk</a>
         <a href="owner_orders.php">permintaan</a>
         <a href="owner_users.php">pelanggan</a>
         <!-- <a href="owner_contacts.php">messages</a> -->
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `owner` WHERE id_owner = ?");
            $select_profile->execute([$owner_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <img src="uploaded_img/<?= $fetch_profile['image']; ?>" alt="">
         <p><?= $fetch_profile['nama_umkm']; ?></p>
         <a href="owner_profil.php" class="btn">lihat profil</a>
         <a href="logout.php" class="delete-btn">logout</a>
         <div class="flex-btn">
            <a href="login_owner.php" class="option-btn">login</a>
            <a href="registrasi.php" class="option-btn">register</a>
         </div>
      </div>

   </div>

</header>