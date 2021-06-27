<?php 

    session_start();
    session_destroy();
    require_once "config.php";
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <title>Forgot Password</title>
    
</head>
<body>

        <nav class="navbar navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">My Web App</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="signup.php">Sign Up</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Coming soon</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>

    <div class="forgot-form">
        <?php 
            if(isset($_GET['forgot_err']))
            {
                $err = htmlspecialchars($_GET['forgot_err']);
                
                switch($err)
                {
                    case 'invalid_email':
                    ?>
                        <div class="alert alert-danger">
                            <strong>Error</strong> invalid email
                        </div>
                    <?php
                    break;

                    case 'not_same_email':
                    ?>
                        <div class="alert alert-danger">
                            <strong>Error</strong> not identical emails
                        </div>
                    <?php
                    break;
                    
                    case 'not_found':
                        ?>
                            <div class="alert alert-danger">
                                <strong>Error</strong> user not found
                            </div>
                        <?php
                        break;

                }
            }

        ?>
        <form action="forgot.php" method="post">
                    <h2 class="text-center">Reset password</h2>       
                    <div class="form-group">
                        <input type="email1" name="email1" class="form-control" placeholder="Email" required="required" autocomplete="on">
                    </div>
                    <div class="form-group">
                        <input type="email2" name="email2" class="form-control" placeholder="Retype-Email" required="required" autocomplete="on">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Last password" required="required" autocomplete="on">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block" style=" margin-left: 36% ;">Reset</button>
                    </div>

        </form>
    </div>
    
    <footer class="bg-light -lg-start" style="position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      height: 50px;
      background-color: red;">
          <!-- Copyright -->
          <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
          © 2021 Copyright 
          <a class="text-dark" href="contact.php">Contact Us</a>
          </div>
          <!-- Copyright -->
      </footer>


    <style>
            .forgot-form {
                width: 340px;
                margin: 50px auto;
            }
            .forgot-form form {
                margin-bottom: 15px;
                background: #f7f7f7;
                box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
                padding: 30px;
            }

            .form-group {
                margin-top: 1em;;
            }


            .forgot-form h2 {
                margin: 0 0 15px;
            }
            .form-control, .btn {
                min-height: 38px;
                border-radius: 2px;
            }
            .btn {        
                font-size: 15px;
                font-weight: bold;
            }
    </style>


    <!-- Optional JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

</body>
</html>

<?php 
    
        if( !empty($_POST['email1']) && !empty($_POST['email2']) && !empty($_POST['password']))
        {   
            //Avoid XSS
            $email1 = htmlspecialchars($_POST['email1']);
            $email2 = htmlspecialchars($_POST['email2']);
            $password = htmlspecialchars(($_POST['password']));

            $email1 = strtolower($email1);
            $email2 = strtolower($email2);



            if(strcmp($email1,$email2)!=0) 
            {
                header('Location: forgot.php?forgot_err=not_same_email'); 
                die;
            }
            else {

                $check = $bdd->prepare('SELECT token FROM users WHERE email = ?');
                $check->execute(array($email1));
                $data = $check->fetch();
                $row = $check->rowCount();
    
    
                if($row)
                {
                    if(filter_var($email1, FILTER_VALIDATE_EMAIL))
                    {
                        $token = bin2hex(openssl_random_pseudo_bytes(24));
                        $token_user = $data['token'];
            
                        $insert = $bdd->prepare('INSERT INTO password_recover(token_user, token) VALUES(?,?)');
                        $insert->execute(array($token_user, $token));
            
                        $link = 'forgot_handle.php?u='.base64_encode($token_user).'&token='.base64_encode($token);
                        
                        ?>
                            <a href=<?php echo $link ?> class="btn btn-secondary active" role="button" aria-pressed="true" style="margin-left:44%">Link to reset password</a>
                        <?php
                        //echo "<a href='$link' style='margin-left 33%'>Link to reset</a>";
     
                    }else{ header('Location: forgot.php?forgot_err=invalid_email'); die(); }
                
                }else{   header('Location: forgot.php?forgot_err=not_found'); die();}
             }
            
        }
           

?>