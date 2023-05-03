<?php

@include 'koneksi.php';

session_start();

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = md5($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $sql = "SELECT * FROM `owner` WHERE email = ? AND password = ?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$email, $pass]);
   $rowCount = $stmt->rowCount();  

   $row = $stmt->fetch(PDO::FETCH_ASSOC);

   if($rowCount > 0){
    
    $_SESSION['owner_id'] = $row['id_owner'];
    header('location:owner_page.php');

   }else{
      $message[] = 'incorrect email or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

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
      <div id="user-btn" class="fas fa-user"></div>

   </div>

   <div class="profile">
      <a href="login_owner.php" class="btn">login</a>
      <a href="registrasi.php" class="delete-btn">registrasi</a>
      <!-- <div class="flex-btn">
         <a href="login.php" class="option-btn">login</a>
         <a href="register.php" class="option-btn">register</a>
      </div> -->
   </div>

</div>

</header>
   
<section class="form-container">

   <img src="images/gambar_login.png">

   <form action="" method="POST">
      <h3>Selamat Datang!</h3>
      <h2>Owner</h2>
      <input type="email" name="email" class="box" placeholder="Masukkan Email Anda" required>
      <input type="password" name="pass" class="box" placeholder="Masukkan Password Anda" required>
      <input type="submit" value="Masuk" class="btn" name="submit">
      <p>Belum punya akun? <a href="registrasi.php">Daftar disini</a></p>
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