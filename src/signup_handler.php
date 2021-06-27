<?php 

    require_once "config.php";
    echo "ECHO HERE";

    if( !empty($_POST['pseudo']) && !empty($_POST['email'])  && !empty($_POST['password'])  && !empty($_POST['password_retype']))
    {
       // Avoid XSS
       $pseudo = htmlspecialchars($_POST['pseudo']);
       $email = htmlspecialchars($_POST['email']);
       $password = htmlspecialchars($_POST['password']);
       $password_retype = htmlspecialchars($_POST['password_retype']);

       //  Check if user already exists
       $check = $bdd->prepare('SELECT pseudo, email, password FROM users WHERE email = ?');
       $check->execute(array($email));
       $data = $check->fetch();
       $row = $check->rowCount();

       $email = strtolower($email); 
       
       if($row == 0){ 
           if(strlen($pseudo) <= 100){ 
               if(strlen($email) <= 100){ 
                   if(filter_var($email, FILTER_VALIDATE_EMAIL)){ 
                       if($password === $password_retype){ 

                           // hash pwd with a cost of 12
                           $cost = ['cost' => 12];
                           $password = password_hash($password, PASSWORD_BCRYPT, $cost);
                           
                           //get IP address
                           $ip = $_SERVER['REMOTE_ADDR']; 

                           // insert into DB
                           $insert = $bdd->prepare('INSERT INTO users(pseudo, email, password, ip, token) VALUES(:pseudo, :email, :password, :ip, :token)');
                           $insert->execute(array(
                               'pseudo' => $pseudo,
                               'email' => $email,
                               'password' => $password,
                               'ip' => $ip,
                               'token' => bin2hex(openssl_random_pseudo_bytes(64))
                           ));
                           // On redirige avec le message de succès
                           header('Location:signup.php?reg_err=success');
                           die();
                       }else{ header('Location: signup.php?reg_err=password'); die();}
                   }else{ header('Location: signup.php?reg_err=email'); die();}
               }else{ header('Location: signup.php?reg_err=email_length'); die();}
           }else{ header('Location: signup.php?reg_err=pseudo_length'); die();}
       }else{ header('Location: signup.php?reg_err=already'); die();}
   }
    

?>