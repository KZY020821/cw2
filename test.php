<?php
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
    $sql = "SELECT photo.idphoto AS idphotos, photo.title AS titles, photo.comment AS comments, photo.imageurl AS imageurls, creator.name AS names, creator.imageurl AS createrImageURL 
    FROM (creator 
      INNER JOIN photo 
      ON creator.idcreator = photo.idcreator) 
      ORDER BY `idphoto` DESC;";
    //execute query 
    $result = mysqli_query($mysqli, $sql);
    //display data row by row
    while ($row = mysqli_fetch_assoc($result)) {
      echo $row['createrImageURL'];
    }
?>