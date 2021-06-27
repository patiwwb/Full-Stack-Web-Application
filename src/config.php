<?php 
        /*
            MySQL use port 3306 by default 
            To check if it is the case open PWSH or CMD and type netstat -t -n (check all TCP connexion without DNS)
            MySQL configuration is located in file "my.ini" or "php.ini"
           
         */
        try 
        {
            $bdd = new PDO("mysql:host=localhost;dbname=projects;charset=utf8;port=3306", "root", "");
        }
        catch(PDOException $e)
        {
            die('Erreur : '.$e->getMessage());
        }


?>