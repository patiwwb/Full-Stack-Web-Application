<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
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
    <title>Login</title>
    
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



    <div class="login-form">
        <?php 
            if(isset($_GET['login_err']))
            {
                $err = htmlspecialchars($_GET['login_err']);
                
                switch($err)
                {
                    case 'password':
                    ?>
                        <div class="alert alert-danger">
                            <strong>Error</strong> wrong password
                        </div>
                    <?php
                    break;

                    case 'email':
                    ?>
                        <div class="alert alert-danger">
                            <strong>Error</strong> invalid email
                        </div>
                    <?php
                    break;

                    case 'already':
                    ?>
                        <div class="alert alert-danger">
                            <strong>Error</strong>Please enter valide information
                        </div>
                    <?php 

                }
            }
            ?>
        <form method="post" id="demo-form">
                    <h2 class="text-center">Login</h2>
                    <input type="hidden" id="g-token" name="g-token" />       
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Email" required="required" autocomplete="on">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="password" required="required" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="btnSubmit" class=" btn btn-primary btn-block" style=" margin-left: 35% ;"  >Login</button>
                    </div>
                    <div class="form-group">
                        <a href="forgot.php" style="margin-left:25%;"> Forgot password ? </a>
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
            .login-form {
                width: 340px;
                margin: 50px auto;
            }
            .login-form form {
                margin-bottom: 15px;
                background: #f7f7f7;
                box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
                padding: 30px;
            }

            .form-group {
                margin-top: 1em;;
            }


            .login-form h2 {
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

    <!-- Google Captcha Scripts -->
    <script src="https://www.google.com/recaptcha/api.js?render=6LcOd1cbAAAAAOiqthb4pwaH0vfrVDyB89D6q4V8"></script>
    
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('6LcOd1cbAAAAAOiqthb4pwaH0vfrVDyB89D6q4V8', {action: 'homepage'}).then(function(token) {
                console.log(token);
            document.getElementById("g-token").value = token;
            });
        });
    </script>

    <!-- Optional JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

</body>
</html>

<?php 

if(!empty($_POST["g-token"]) && !empty($_POST['email']) && !empty($_POST['password']))
{

    

    $secretKey  = '6LcOd1cbAAAAALaDm52utDpT2bt6DNtMNNivW-9s';
    $token      = $_POST["g-token"];
    $ip         = $_SERVER['REMOTE_ADDR'];

    /* ======================= POST METHOD =====================*/ 
    $url = "https://www.google.com/recaptcha/api/siteverify?";
    $data = array('secret' => $secretKey, 'response' => $token, 'remoteip'=> $ip);

    // use key 'http' even if you send the request to https://...
    $options = array('http' => array(
        'method'  => 'POST',
        'content' => http_build_query($data),
        'header' => 'Content-Type: application/x-www-form-urlencoded'
    ));
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $response = json_decode($result);
    if($response->success)
    {
        echo '<center><h1>Validation Success!</h1></center>';
    }
    else
    {
        echo '<center><h1>Captcha Validation Failed..!</h1></center>';
    }

    //Avoid XSS
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars(($_POST['password']));

    $email = strtolower($email);

    //echo $email;
    //echo $password;

    $check = $bdd->prepare('SELECT * FROM users WHERE email = ?');
    $check->execute(array($email));
    $data = $check->fetch();
    $row = $check->rowCount();

    //echo $row;
    if($row > 0)
    {
        
        if(filter_var($email, FILTER_VALIDATE_EMAIL))
        {

            if(password_verify($password, $data['password']))
            {
                $_SESSION['user'] = $data['token'];
                //echo $data['token'].'<br>';
                $encoded_token = base64_encode($data['token']);
                //echo $encoded_token.'<br>';
                /*$decoded_token = base64_decode($encoded_token);
                echo $decoded_token.'<br>';*/
                echo "<script type='text/javascript'>window.top.location='app.php?u=".$encoded_token."';</script>"; //exit;
                //header('Location: index.php');
                die();
            }else{echo "<script type='text/javascript'>window.top.location='login.php?login_err=password';</script>"; //exit;
                //header('Location: login.php?login_err=password'); die(); 
            }
        }else{echo "<script type='text/javascript'>window.top.location='login.php?login_err=email';</script>"; exit; }
    }else{ echo "<script type='text/javascript'>window.top.location='login.php?login_err=already';</script>"; exit; }
    

}
else{  die();}

?>



