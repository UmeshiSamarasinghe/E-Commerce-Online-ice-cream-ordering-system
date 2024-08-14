<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/add_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>category</title>

  
   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.0.7/css/boxicons.min.css">


   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/user_style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="products">

   <h1 class="title">food category</h1>

   <div class="box-container">

      <?php
         $categeory = $_GET['categeory'];
         $select_products = $conn->prepare("SELECT * FROM products WHERE categeory = ?");
         $select_products->execute([$categeory]);
         if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
      ?>
      
      <form action="" method="post" class="box <?php if($fetch_products['stock'] == 0){echo 'disabled';}; ?>">
         <img src="uploaded_files/<?= $fetch_products['image']; ?>" class="image">
         <?php if ($fetch_products['stock'] > 9) { ?>
               <span class="stock" style="color: green;"><i class="fas fa-check" style="margin-right: .5rem;"></i>In Stock</span>
            <?php }elseif($fetch_products['stock'] == 0){ ?>
               <span class="stock" style="color: red;"><i class="fas fa-times" style="margin-right: .5rem;"></i>Out Of Stock</span>
            <?php }else{ ?>
               <span class="stock" style="color: red;">Hurry, only <?= $fetch_products['stock']; ?>left</span>
            <?php } ?>
         <div class="content">
            <img src="image/shape-19.png" alt="" class="shap">
            <div class="button">
               <div><h3 class="name"><?= $fetch_products['name']; ?></h3></div>
               <div>
                  <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
                  <button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
                  <a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="bx bxs-show"></a>
               </div>
            </div>
            <p class="price">price Rs<?= $fetch_products['price']; ?></p>
            <input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
            <div class="flex-btn">
               <a href="checkout.php?get_id=<?= $fetch_products['id']; ?>" class="btn">buy now</a>
               <input type="number" name="qty" required min="1" value="1" max="99" maxlength="2" class="qty">
            </div>
         </div>
      </form>
      <?php
            }
         }else{
            echo '<p class="empty">no products added yet!</p>';
         }
      ?>

   </div>

</section>

















<?php include 'components/footer.php'; ?>


<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>


</body>
</html>