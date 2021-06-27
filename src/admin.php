<?php 
    
    require_once 'config.php';

?>

<?php
    if(isset($_GET['u']))
                {
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
                            echo "This page is restricted to admins";
                        break;
    
                    }
                    }
                    else{
                        header('Location: login.php');
                    }


                
                }
    else {
        header('Location: login.php');
    }
?>

<?php
    $user = $bdd->query('SELECT * FROM users ORDER BY pseudo');
    $ban = $bdd->query('SELECT * FROM ban ORDER BY pseudo');
    
    /*
    while($data = $user->fetch())
    {
        echo $data['pseudo'].";".$data['email'].";".$data['token'];
    }

    while($data = $ban->fetch())
    {
        echo $data['token']; ?>"><?php echo $data['pseudo'];
    }
    */
?>


<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
            <title>Admin Page</title>
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

            <br />
            <div class="container-fluid">
                <div class="d-flex justify-content-around">
                    <div class="form-group w-20 text-center">
                        <h2 class="p-3">Ban</h2>
                        <p> List of all users in the database "users"</p>
                        <form action="ban.php?u=<?php echo $get_admin; ?>" method="POST">
                            <select name="token" class="form-control">
                                <?php 
                                    
                                    while($data = $user->fetch())
                                    {
                                        
                                ?>
                                    <option value="<?php echo $data['pseudo'].";".$data['email'].";".$data['token'].";".$data['admin'];?>"><?php echo $data['pseudo']; ?></option>
                                <?php 
                                    }
                                ?>
                            </select>
                            <br />
                            <button type="submit" class="btn btn-success">Ban</button>
                        </form>
                    </div>
                    <div class="form-group w-20 text-center">
                        <h2 class="p-3">Unban</h2>
                        <p> List of all users in the database "ban"</p>
                        <form action="unban.php?u=<?php echo $get_admin; ?>" method="POST">
                            <select name="token" class="form-control">
                                <?php 
                                   
                                    while($data = $ban->fetch())
                                    {   
                                ?>
                                    <option value="<?php echo $data['token']; ?>"><?php echo $data['pseudo']; ?></option>
                                <?php 
                                    }
                                ?>
                            </select>
                            <br />
                            <button type="submit" class="btn btn-success">Unban</button>
                        </form>
                    </div>
                </div>
            </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!-- Optional JavaScript -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <style>.w-20{width: 20%;}</style>
    </body>
</html>