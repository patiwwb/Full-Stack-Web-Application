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
    <title>Change Password</title>
    
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
            if(isset($_GET['chg_pswd']))
            {
                $err = htmlspecialchars($_GET['chg_pswd']);
                
                switch($err)
                {
                    case 'not_same':
                    ?>
                        <div class="alert alert-danger">
                            <strong>Error</strong> enter same password !
                        </div>
                    <?php
                    break;

                }
            }
            ?>

        <form action="change_password.php?u=<?php echo $_GET['u']; ?>" method="post">
                    <!-- <?php echo base64_decode($_GET['u']);?> -->
                    <h2 class="text-center">Choose new password</h2>
                    <input type="hidden" name="token" value="<?php echo $_GET['u']; ?>"  />       
                    <div class="form-group">
                        <input type="password" name="new_password1" class="form-control" placeholder="New password" required="required" autocomplete="on">
                    </div>
                    <div class="form-group">
                        <input type="password" name="new_password2" class="form-control" placeholder="Confirm new password" required="required" autocomplete="on">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block" style=" margin-left: 35% ;">Reset</button>
                    </div>

        </form>
    </div>
    
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
    
        if( !empty($_POST['new_password1']) && !empty($_POST['new_password2']) &&!empty($_POST['token']))
        {   
            //Avoid XSS
            $password = htmlspecialchars($_POST['new_password1']);
            $password_repeat = htmlspecialchars($_POST['new_password2']);
            $token = htmlspecialchars(base64_decode($_POST['token']));


            if(strcmp($password,$password_repeat)!=0) 
            {
                 //echo "ERROR: Not identical passwords ! ";
                ?>
                 <div class="alert alert-danger" style="width: 22%; margin-left:39%">
                    <strong>Error</strong> Not identical passwords
                </div>
                <?php
            }
            else { 
                $check = $bdd->prepare('SELECT * FROM users WHERE token = ?');
                $check->execute(array($token));
                $row = $check->rowCount();
                
                if($row){
                    $cost = ['cost' => 12];
                    $password = password_hash($password, PASSWORD_BCRYPT, $cost);

                    $update = $bdd->prepare('UPDATE users SET password = ? WHERE token = ?');
                    $update->execute(array($password, $token));

                    //We can manually check here: https://bcrypt-generator.com/
                    
                    $delete = $bdd->prepare('DELETE FROM password_recover WHERE token_user = ?');
                    $delete->execute(array($token));

                    ?>
                        <div class="alert alert-success" style="width: 22%; margin-left:39%">
                            <strong>Success</strong> Password changed
                        </div>
                    <?php
                    
                }else{
                    ?>
                        <div class="alert alert-danger" style="width: 22%; margin-left:39%">
                            <strong>Error</strong> User not found
                        </div>
                    <?php
                }


            }

               
            
        }
           

?>