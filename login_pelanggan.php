<?php

@include 'koneksi.php';

session_start();

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = md5($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $sql = "SELECT * FROM `pelanggan` WHERE email = ? AND password = ?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$email, $pass]);
   $rowCount = $stmt->rowCount();  

   $row = $stmt->fetch(PDO::FETCH_ASSOC);

   if($rowCount > 0){

      if($row['user_type'] == 'pelanggan'){

         $_SESSION['pelanggan_id'] = $row['id_pelanggan'];
         header('location:home.php');

    //   }elseif($row['user_type'] == 'user'){

    //      $_SESSION['user_id'] = $row['id'];
    //      header('location:home.php');

      }else{
         $message[] = 'pelanggan tidak ditemukan!';
      }

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
   <link rel="stylesheet" href="css/comps.css">

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
   
<section class="form-container">

   <img src="images/gambar_login.png">

   <form action="" method="POST">
      <h3>Selamat Datang!</h3>
      <input type="email" name="email" class="box" placeholder="Masukkan Email Anda" required>
      <input type="password" name="pass" class="box" placeholder="Masukkan Password Anda" required>
      <input type="submit" value="Masuk" class="btn" name="submit">
      <p> </p>
   </form>

</section>


</body>
</html>