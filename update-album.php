<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Cache-Control: post-check=0, pre-check=0', FALSE);
    header('Pragma: no-cache');
    // if do not have users cookie, redirect to index.php
    if (!isset($_COOKIE["admin"])) {
        header("Location: index.php");
    }
    $dbServerName = "localhost";
    $dbUserName = "root";
    $dbPassword = "";
    $dbName = "5614YCOM_CW";
    // connect the database with the server
    $mysqli = new mysqli($dbServerName, $dbUserName, $dbPassword, $dbName);

    // if error occurs 
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    //query select data from database
    $q = "UPDATE `photo` SET `idalbum` = '".$_POST["idalbum"]."' WHERE `photo`.`idphoto` =".$_POST["idphoto"].";";
    //execute query 
    if ($mysqli->query($q)) {
        echo "<p>Your meme has been added to the selected album.</p>";
    }
?>    
<a href="index.php">View memes</a>
</body>
</html>
