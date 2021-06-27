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
        
        // Avoid XSS
        $tokenPost = htmlspecialchars($_POST['token']);

        // Values from array from form
        // [0] => pseudo
        // [1] => email 
        // [2] => token
        // [3] => admin
        $tokenPost = explode(';', $tokenPost);
        $pseudo = $tokenPost[0];
        $email = $tokenPost[1];
        $token = $tokenPost[2];
        $admin = $tokenPost[3];
        
        //Check if already banned
        $check_ban = $bdd->prepare('SELECT * FROM ban WHERE token = ?');
        $check_ban->execute([$token]);
        $row = $check_ban->rowCount();
        $data = $check_ban->fetch();
        echo $data['admin'];
        
        // if row ==0 not already banned
            if($row == 0)
            {   
    
                $ban = $bdd->prepare('INSERT INTO ban(pseudo, email, token,admin) VALUES(?,?,?,?)');
                $ban->execute([$pseudo, $email, $token, $admin]);
                echo "User $pseudo has been banned";
                ?>
                <a href="admin.php?u=<?php echo $get_admin; ?>" style="margin-left:25%;"> Back to previous page </a>
                <?php
            
    
            }
            else  
            {
                echo "User is already banned";
                ?>
                <a href="admin.php?u=<?php echo $get_admin; ?>" style="margin-left:25%;"> Back to previous page </a>
                <?php
            }
        }
    else  
    {
        header('Location: admin.php');
        die();
    }
?>