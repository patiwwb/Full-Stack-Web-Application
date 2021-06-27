<?php 

    require_once "config.php";

    echo "Hello there! <br>";

    $check = $bdd->prepare('SELECT * FROM USERS');
    $check->execute();
    $Alldata = $check->fetchAll();
    $check->execute();
    $data  = $check->fetch();
    $row = $check->rowCount();

    echo "Rows : ".$row;

    echo "<hr>";
  
    foreach ($Alldata as $line)
    {   
        foreach( $line as $col => $value)
        {
            echo $col. ":" . $value . "<br>";
        }
        echo "<br>";
    }

    echo "<hr>";


    foreach( $data as $value)
    {
        echo $value . "<br>";
    }



    


?>