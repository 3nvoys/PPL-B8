<?php

include 'koneksi.php';

if(isset($_POST['submit'])){

   $nama_umk = $_POST['nama_umk'];
   $nama_umk = filter_var($nama_umk, FILTER_SANITIZE_STRING);
   $alamat = $_POST['alamat'];
   $alamat = filter_var($alamat, FILTER_SANITIZE_STRING);
   $no_tlp = $_POST['no_tlp'];
   $no_tlp = filter_var($no_tlp, FILTER_SANITIZE_STRING);
   $no_ktp = $_POST['no_ktp'];
   $no_ktp = filter_var($no_ktp, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = md5($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = md5($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select = $conn->prepare("SELECT * FROM `owner` WHERE email = ?");
   $select->execute([$email]);

   if($select->rowCount() > 0){
      $message[] = 'user email already exist!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         $insert = $conn->prepare("INSERT INTO `owner`(nama_umkm, alamat_umkm, no_hp, no_ktp, email, password, image) VALUES(?,?,?,?,?,?,?)");
         $insert->execute([$nama_umk, $alamat, $no_tlp, $no_ktp, $email, $pass, $image]);

         if($insert){
            if($image_size > 2000000){
               $message[] = 'image size is too large!';
            }else{
               move_uploaded_file($image_tmp_name, $image_folder);
               $message[] = 'registered successfully!';
               header('location:login_owner.php');
            }
         }

      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/comp.css">

</head>
<body>


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

      <!-- <nav class="navbar">
         <a href="home.php">home</a>
         <a href="produk.php">produk</a>
         <a href="orders.php">permintaan</a>
      </nav> -->

      <div class="icons">
         <!-- <div id="menu-btn" class="fas fa-bars"></div> -->
         <div id="user-btn" class="fas fa-user"></div>
         <!-- <a href="search_page.php" class="fas fa-search"></a> -->
         <?php
            // $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            // $count_cart_items->execute([$user_id]);
         ?>
         <!-- <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?//= $count_cart_items->rowCount(); ?>)</span></a> -->
      </div>

      <div class="profile">
         <!-- <a href="user_profile_update.php" class="btn">update profile</a> -->
         <!-- <a href="logout.php" class="delete-btn">logout</a> -->
         <div class="flex-btn">
            <a href="login.php" class="option-btn">login</a>
            <a href="register.php" class="option-btn">register</a>
         </div>
      </div>

   </div>

</header>
   
<section class="form-container">

   <img src="images/gambar_login.png">

   <form action="" enctype="multipart/form-data" method="POST">
      <h3>Registrasi Akun</h3>
      <input type="text" name="nama_umk" class="box" placeholder="masukkan nama umkm" required>
      <input type="text" name="alamat" class="box" placeholder="masukkan alamat umkm" required>
      <input type="text" name="no_tlp" class="box" placeholder="masukkan nomor telepon" required>
      <input type="text" name="no_ktp" class="box" placeholder="masukkan no KTP" required>
      <input type="email" name="email" class="box" placeholder="masukkan email" required>
      <input type="password" name="pass" class="box" placeholder="masukkan password" required>
      <input type="password" name="cpass" class="box" placeholder="konfirmasi password" required>
      <input type="file" name="image" class="box" required accept="image/jpg, image/jpeg, image/png" placeholder="pilih foto profil" required>
      <input type="submit" value="register now" class="btn" name="submit">
      <p>Sudah memiliki akun? <a href="login_owner.php">login now</a></p>
   </form>

</section>

<script>
    let profile = document.querySelector('.header .flex .profile');

    document.querySelector('#user-btn').onclick = () =>{
        profile.classList.toggle('active');

    }

    window.onscroll = () =>{
        profile.classList.remove('active');

    }
</script>
</body>
</html>