<?php 
    require_once 'config.php';
?>

<?php

    if(isset($_GET['u']))
                    {
                        $get_admin = htmlspecialchars($_GET['u']);
                        
                    }
        else {
            header('Location: login.php');
        }

?>

<?php
    
    if(!empty($_POST['token'])){
        
        // avoid XSS
        $token = htmlspecialchars($_POST['token']);
        
        // On vérifie si l'utilisateur est banni
        $check_ban = $bdd->prepare('SELECT * FROM ban WHERE token = ?');
        $check_ban->execute([$token]);
        $row = $check_ban->rowCount();
        
        // if user banned
        if($row > 0)
        {
            $unban = $bdd->prepare('DELETE FROM ban WHERE token = ?');
            $unban->execute([$token]);
            echo "User has been unbanned ";
            ?>
            <a href="admin.php?u=<?php echo $get_admin; ?>" style="margin-left:25%;"> Back to previous page </a>
            <?php
        }
        else 
        {
            echo "User is not banned";
            ?>
            <a href="admin.php?u=<?php echo $get_admin; ?>" style="margin-left:25%;"> Back to previous page </a>
            <?php
        }
    }
    else //Avoid blank page
    {
        header('Location: login.php');
        die();
    }
?>