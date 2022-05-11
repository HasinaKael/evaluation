<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset(user_id)){
    header('location:login.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy(); 
   header('location:login.php');
   
};
if(isset($_POST['add_to_cart'])){
    $product_name = $_POST ['product_name']; 
    $product_price = $_POST ['product_price']; 
    $product_image = $_POST ['product_image']; 
    $product_quantity = $_POST ['product_quantity']; 

    $select_cart = mysqli_query($conn, "SELECT*FROM `cart` WHERE name ='$product_name'
    AND user_id = 'user_id'") or die ('query failed');

    if(mysqli_num_rows($select_cart)>0){
        $message [] = 'produit deja ajouter au panier';
    }else{
        mysqli_query($conn,"INSERT INTO `cart`(user_id,nom, prix,image,quantite)
        VALUES('$user_id','$product_name','$product_price','$product_image','$product_quantity')") or die (query failed)
        $message [] = 'produit ajouter au panier';
    }
}
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Produit Bio</title>
</head>
<body>

<?php
     
if(isset($message)){
    foreach($message as $message){
        echo '<div class = "message" onclick = "this.remove();">'.$message.' </div>';
    }
}

?>

<div class="container">
    <div class="user-profile">
        <?php
           $select_user = mysqli_query($conn, "SELECT*FROM `user_form` WHERE id = '$user_id'") 
           or die ('query failed');
           if(mysqli_num_rows($select_user) >0){
               $fetch_user = mysqli_fetch_assoc($select_user);
           };

        ?>

    <p>Nom d'utilisateur: <span><?php echo  $fetch_user ['name'];?></span></p>
    <p>Email: <span><?php echo  $fetch_user ['email'];?></span></p>
    <div class="flex">
        <a href="login.php" class="btn">Connexion</a>
        <a href="inscription.php" class="option-btn">Inscription</a>
        <a href="index.php?logout=<?php  echo $user_id;?>" onclick="return confirm('etes vous sure de vouloir vous deconnecter?');"
         class="delete-btn">Deconnexion</a>
    </div>
   
    </div>
  <div class="products">
      <div class="box-container">
      <?php
           $select_product = mysqli_query($conn, "SELECT*FROM `products`") 
           or die ('query failed');
           if(mysqli_num_rows($select_product) >0){
              while( $fetch_product = mysqli_fetch_assoc($select_product);){

        ?>
    <form action="" method="post" class="box">
        <img src="img/broccoli.jpg<?php echo $fetch_product['image']; ?>" alt="">
        <div class="name"><?php echo $fetch_product['nom'];?>brocoli</div>
        <div class="price"><?php echo $fetch_product['prix'];?>Ar2500</div>
        <input type="number" min=1 name="product_quantity">
        <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
        <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
        <input type="hidden" name="product_price" value="<?php echo $fetch_product['prix']; ?>">
        <input type="subimt" value="ajouter a la carte" name="add_to_cart" class="btn">
    </form>
        <?php
        
              };
          };
        ?>

      </div>

  </div>

<div class="shopping-cart">
    <h1 class="heading">Panier</h1>
    <table>
        <thead>
            <th>image</th>
            <th>nom</th>
            <th>prix</th>
            <th>quantite</th>
            <th>total prix</th>
            <th>total prix</th>
            <th>action</th>
        </thead>
        <tbody>
        <?php
           $select_product = mysqli_query($conn, "SELECT*FROM `cart` WHERE user_id ='user_id'") 
           or die ('query failed');
           if(mysqli_num_rows($select_product) >0){
              while( $fetch_cart = mysqli_fetch_assoc($cart_query);){

        ?>

        <tr>
            <td><img src="img/broccoli.jpg"<?php echo $fetch_cart['image'];?> height="100"></td>
            <td><?php echo $fetch_cart['nom'];?></td>
            <td><?php echo $fetch_cart['prix'];?></td>
            <td>
                <form action="" method="post">
                    <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id'];?>">
                    <input type="number" min='1' name="cart_quantity" value="<?php echo $fetch_cart['quantite'];?>">
                    <input type="submit" name="update_cart" value="mettre a jour" class="option-btn">
                </form>
            </td>
            <td>Ar<?php echo $sub_total = number_format( $fetch_cart['prix']* $fetch_cart['quantite'])?></td>
            <td><a href="index.php?remove=<?php  echo $fetch_cart['id'];?>" class="delete-btn" onclick="return confirm('supprimer du panier?')">supprimer</a></td>
        </tr>
        <?php
            $grand_total += $sub_total;
              };
            };   
        ?>
        <tr class="table-bottom">
            <td coldspan=""4>Grand total</td>
            <td>Ar<?php echo $grand_total;?></td>
            <td><a href="index.php?delete_all" onclick="return confirm(effacer tout de la carte);">Effacer tout</a></td>
        </tr>
        </tbody>
    </table>

</div>
</div>
    
</body>
</html>