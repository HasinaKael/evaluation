<?php
include 'config.php';
session_start();

if (isset($_POST['submit']))
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
  

   $select = mysqli_query($conn,"SELET * FROM `user_form` WHERE email = '$email'
   AND password = '$pass'") or die ('query failed');

   if(mysqli_num_rows($select) >0){
      $row = mysqli_fetch_assoc($select);
      $_SESSION['user_id']; = $row ['id'];
      header('location:index.php');
     
   }else{
    $message[] = 'mot de passe incorrect';
   }
   

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Login</title>
</head>
<body>

<?php

if(isset($message)){
    foreach($message as $message){
        echo '<div class = "message" onclick = "this.remove();">'.$message.' </div>';
    }
}

?>   
    <div class="form-container">
        <form action="" method>
            <h3>Connecter maintenant</h3>        
            <input type="email" name="email" required placeholder="entrer votre email" class="box">
            <input type="password" name="password" required placeholder="entrer votre mot de passe" class="box">          
            <input type="submit" name="submit" class="btn" value="se connecter" >
            <p>Vous n'avez pas de compte? <a href="inscription.php">inscrivez maintenant</a></p>
        </form>
       
    </div>
    
</body>
</html>