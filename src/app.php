<?php 

  session_start();
  require_once 'config.php'; 
  
  if(!isset($_SESSION['user'])){
      header('Location:index.php');
      die();
  }

  $req = $bdd->prepare('SELECT * FROM users WHERE token = ?');
  $req->execute(array($_SESSION['user']));
  $data = $req->fetch();

?>

<?php 

  if(isset($_GET['u']))
  {
      $get_admin = htmlspecialchars($_GET['u']);
      
      $decoded_token = base64_decode($get_admin);

  }
  else
  {
      header('Location: index.php'); 
  }

?>



<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <title>MyApp</title>
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
    
    <div class="content" style=" width: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;">
        <?php
          if(isset($_GET['success']))
          {
              $success_status = htmlspecialchars($_GET['success']);
              
              ?>
              <div id="HideMe" class="alert alert-success" style="position:absolute;  margin-left: 35%; width:30%;z-index: 1;">
                  <strong>Success</strong> files uploaded
              </div>

              <?php

          }
        ?>

        <div class="card w-50" style="justify-content: center;margin: 1em auto;">
            <div class="card-body">
            <h5 class="card-title" style="margin-left: 40%;">Welcome <?php echo $data['pseudo']; ?></h5>
            <p class="card-text" style="margin-left: 35%;">We are happy to see you here !</p>
            <form action="upload.php?u=<?php echo $get_admin;?>"
              method="post"
              enctype="multipart/form-data" 
              style="width: 55%;
                padding-top:10em;
                margin: 0 auto;"
              >
        
              <input type="file" 
                      name="my_image">

              <input class="btn btn-success"
                      type="submit" 
                      name="submit-files"
                      value="Upload">
          
            </form>
            <a href="view_all_images.php?u=<?php echo $get_admin?>" style="position:absolute ;text-align:center;width :100%;margin: 5% auto;"> View all uploaded files online</a>
            <a href="logout.php" class="btn btn-danger" style="margin-top:20%;margin-left: 45%;">Logout</a>
            </div>
        </div>
        <?php 

            $get_admin = htmlspecialchars($_GET['u']);
            
            $decoded_token = base64_decode($get_admin);

            $check_admin = $bdd->prepare('SELECT admin FROM users WHERE token = ?');
            $check_admin->execute(array($decoded_token));
            $result_admin = $check_admin->fetch();
            $row = $check_admin->rowCount();

            if($row)
            {
              switch($result_admin['admin'])
              {
                  case 1:
                  ?>
                  <div class="card w-50" style="justify-content: center;margin: 1em auto;">
                      <div class="card-body">
                      <h5 class="card-title" style="margin-left: 37%;">Admin Mode available (<?php echo $data['pseudo']; ?>)</h5>
                      <a href="admin.php?u=<?php echo $get_admin?>" class="btn btn-success" style="margin-left: 43%;">Enter admin mode</a>
                  </div>
                  </div>
                  <?php
                  break;

              }
            }


                  
                

                ?>
        <!-- Optional JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    </div>
  </body>
</html>

<!-- Script to hide success upload popup -->
<script>

  var fade_out = function() {
    $("#HideMe").fadeOut().empty();
  }

  setTimeout(fade_out, 5000);
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>