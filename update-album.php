<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php
    include_once "connect-database.php";
    //query select data from database
    $q = "UPDATE `photo` SET `idalbum` = '".$_POST["idalbum"]."' WHERE `photo`.`idphoto` =".$_POST["idphoto"].";";
    //execute query 
    if ($mysqli->query($q)) {
        header("Location: view-meme.php" );
        exit ();
    }
?>    
</body>
</html>
