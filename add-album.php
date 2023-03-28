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
    $query = "SELECT * FROM `album` WHERE idcreator = (SELECT idcreator from photo where idphoto = ". convert_uudecode($_GET["idphoto"]) .");";
    //execute query 
    $result = mysqli_query($mysqli, $query);
    //display data row by row
    while ($row = mysqli_fetch_assoc($result)) {
      $albumImageURL = $row['imageurl'];
      $albumTitle = $row['title'];
      echo "<br><img src=\"album/".$albumImageURL."\" alt=\"Albums coverpage\" width=\"200\" height=\"auto\">";
      echo "<br>".$albumTitle;
      echo "<form action=\"update-album.php\"method=\"post\"enctype=\"multipart/form-data\">
      <button>Select</button>
      <input type=\"hidden\" name=\"idalbum\" value=\"". $row['idalbum']."\">
      <input type=\"hidden\" name=\"idphoto\" value=\"". convert_uudecode($_GET["idphoto"])."\">
      </form>";
    }
?>