<?php
    include_once "connect-database.php";
    //query select data from database
    $q = "UPDATE `photo` SET `idalbum` = NULL WHERE `photo`.`idphoto` =".convert_uudecode($_GET["idphoto"]).";";
    //execute query 
    if ($mysqli->query($q)) {
        header("Location: view-meme.php" );
        exit ();        
    }
?>    
