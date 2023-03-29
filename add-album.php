<?php
    include_once "connect-database.php";
    //query select data from database
    $query = "SELECT * FROM `album` WHERE idcreator = (SELECT idcreator from photo where idphoto = ". convert_uudecode($_GET["idphoto"]) .");";
    //execute query 
    $result = mysqli_query($mysqli, $query);
    //display data row by row
    while ($row = mysqli_fetch_assoc($result)) {
      echo "<br><img src=\"album/".$row['imageurl']."\" alt=\"Albums coverpage\" width=\"50\" height=\"auto\">";
      echo "<br>".$row['title'];
      echo "<form action=\"update-album.php\"method=\"post\"enctype=\"multipart/form-data\"><button>Select</button>
      <input type=\"hidden\" name=\"idalbum\" value=\"". $row['idalbum']."\">
      <input type=\"hidden\" name=\"idphoto\" value=\"". convert_uudecode($_GET["idphoto"])."\">
      </form>";
    }
?>