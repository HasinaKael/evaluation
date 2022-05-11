<?php
include 'config.php';

if (isset($_POST['submit']))
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));

   $select = mysqli_query($conn,"SELET * FROM `user_form` WHERE email = '$email'
   AND password = '$pass'") or die ('query failed');

   if(mysqli_num_rows($select) >0){
       $message[] = 'l/utilisateur existe deja!';

   }else{
       mysqli_query($conn, "INSERT INTO `user_form ` (name,email,password) VALUES('$name','$email','$pass','$cpass')")
       or die ('query failed');
       $message[] = 'enregistre avec succes!';
       header('location:ogin.php');
   }
   

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Inscription</title>
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
            <h3>Inscrivez-vous maintenant</h3>
            <input type="text" name="name" required placeholder="entrer votre nom" class="box">
            <input type="email" name="email" required placeholder="entrer votre email" class="box">
            <input type="password" name="password" required placeholder="entrer votre mot de passe" class="box">
            <input type="password" name="cpassword" required placeholder="confirmer votre mot de passe" class="box">
            <input type="submit" name="submit" class="btn" value="s'inscrire" >
            <p>Vous avez déjà un compte? <a href="login.php">Se connecter </a></p>
        </form>
       
    </div>
    
</body>
</html>