
<?php 

session_start();
require_once 'config.php'; 

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



<!DOCTYPE html>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	<title>View all images</title>

</head>
<style>

		.alb {
			width: 200px;
			height: 200px;
			padding: 5px;
		}
		.alb img {
			width: 100%;
			height: 100%;
		}
		a {
			text-decoration: none;
			color: black;
		}
	</style>

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
        <div class="GoBack">
            <a href="app.php?u=<?php echo $get_admin;?>" style="position:absolute;width:100%;text-align:center;margin-top:2%;">Go to previous page </a>
        </div>
        <div class="container" style="margin-top:10%;display: flex;flex-direction: row;" >
        <?php 
            $get_images = $bdd->query('SELECT * FROM images ORDER BY id DESC;');
            while($images = $get_images->fetch())
            {
               
                ?>
                <div class="card" style="width: 12rem;">
                <img class="card-img-top" src="uploads/<?=$images['image_url']?>" alt="Card image cap">
                <div class="card-body">
                <p class="card-text"> <?php echo $images['image_url']; ?></p>
                </div>
                </div>

                <?php
            }
        ?>
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
</body>
</html>

<!-- Optional JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
