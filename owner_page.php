<?php

@include 'koneksi.php';

session_start();

$owner_id = $_SESSION['owner_id'];

if(!isset($owner_id)){
   header('location:login_owner.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>owner page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/owner_stile.css">

</head>
<body>
   
<?php include 'owner_header.php'; ?>

<section class="dashboard">

   <h1 class="title">dashboard</h1>

   <div class="box-container">

      <div class="box">
      <?php
         $total_permintaan = 0;
         $select_permintaan = $conn->prepare("SELECT * FROM `permintaan` join `owner` 
         on `permintaan`.`fid_owner` = `owner`.`id_owner` JOIN `produk` 
         ON `owner`.`id_owner` = `produk`.`fid_owner`
         WHERE `permintaan`.`fid_owner` = ?"); 
         $select_permintaan->execute([$owner_id]);
         while($fetch_permintaan = $select_permintaan->fetch(PDO::FETCH_ASSOC)){
            $total_permintaan += $fetch_permintaan['id_permintaan'];
         };
      ?>
      <h3>Rp. <?//= $total_pendings; ?>/-</h3>
      <p>total permintaan</p>
      <a href="owner_orders.php" class="btn">see orders</a>
      </div>

      <!-- <div class="box">
      <?php
         // $total_completed = 0;
         // $select_completed = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
         // $select_completed->execute(['completed']);
         // while($fetch_completed = $select_completed->fetch(PDO::FETCH_ASSOC)){
         //    $total_completed += $fetch_completed['total_price'];
         // };
      ?>
      <h3>$<?//= $total_completed; ?>/-</h3>
      <p>completed orders</p>
      <a href="owner_orders.php" class="btn">see orders</a>
      </div> -->

      <div class="box">
      <?php
         $select_orders = $conn->prepare("SELECT * FROM `permintaan`");
         $select_orders->execute();
         $number_of_orders = $select_orders->rowCount();
      ?>
      <h3><?= $number_of_orders; ?></h3>
      <p>permintaan yang ditambahkan</p>
      <a href="owner_orders.php" class="btn">Lihat Permintaan</a>
      </div>

      <div class="box">
      <?php
         $select_products = $conn->prepare("SELECT * FROM `produk`");
         $select_products->execute();
         $number_of_products = $select_products->rowCount();
      ?>
      <h3><?= $number_of_products; ?></h3>
      <p>produk yang ditambahkan</p>
      <a href="owner_products.php" class="btn">Lihat Produk</a>
      </div>

      <div class="box">
      <?php
         $select_users = $conn->prepare("SELECT * FROM `pelanggan` WHERE fid_owner = ?");
         $select_users->execute([$owner_id]);
         $number_of_users = $select_users->rowCount();
      ?>
      <h3><?= $number_of_users; ?></h3>
      <p>total pelanggan</p>
      <a href="owner_users.php" class="btn">Lihat Pelanggan</a>
      </div>

      <!-- <div class="box">
      <?php
         $select_accounts = $conn->prepare("SELECT * FROM `users`");
         $select_accounts->execute();
         $number_of_accounts = $select_accounts->rowCount();
      ?>
      <h3><?= $number_of_accounts; ?></h3>
      <p>total accounts</p>
      <a href="owner_users.php" class="btn">see accounts</a>
      </div> -->

      <!-- <div class="box">
      <?php
         $select_messages = $conn->prepare("SELECT * FROM `message`");
         $select_messages->execute();
         $number_of_messages = $select_messages->rowCount();
      ?>
      <h3><?= $number_of_messages; ?></h3>
      <p>total messages</p>
      <a href="owner_contacts.php" class="btn">see messages</a>
      </div> -->

   </div>

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