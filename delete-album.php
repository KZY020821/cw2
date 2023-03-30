<?php
    include_once "connect-database.php";
    $sql = "SELECT * FROM album WHERE idalbum =" . $_GET['idalbum'] . ";";
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_assoc()) {
        $fileloc = "album/" . $row["imageurl"];
        if ($row["imageurl"] != "default.png") {
            //delete file from local storage
            unlink($fileloc);
        }
    }

    $updateIdAlbumNull ="UPDATE `photo` SET `idalbum` = NULL WHERE `photo`.`idalbum` =".$_GET['idalbum'].";";
    $mysqli->query($updateIdAlbumNull);
    $q = "DELETE album FROM album WHERE idalbum = \"".$_GET['idalbum']."\";";
    if ($mysqli->query($q)) {
        header("Location: index.php" );
        exit ();
    }
    // close connection
    mysqli_close($mysqli);
?>