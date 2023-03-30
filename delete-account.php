<?php
    include_once "connect-database.php";
    $result = $mysqli->query("SELECT * FROM creator WHERE creator.name =\"" . $_COOKIE["admin"] . "\";");
    while ($row = $result->fetch_assoc()) {
        $fileloc = "creator/" . $row["imageurl"];
        if ($row["imageurl"] != "default.png") {
            //delete file from local storage
            unlink($fileloc);
        }
    }

    $deletePhoto = "SELECT * FROM photo WHERE idcreator = (SELECT idcreator FROM creator WHERE creator.name =\"" . $_COOKIE["admin"] . "\");";
    $result = $mysqli->query($deletePhoto);
    while ($row = $result->fetch_assoc()) {
        $fileloc = "memes/" . $row["imageurl"];
        if ($row["imageurl"] != NULL) {
            //delete file from local storage
            unlink($fileloc);
        }
    }
    
    $deleteCreatorPhotos = "DELETE photo FROM photo WHERE idcreator =(SELECT idcreator FROM creator where creator.`name` = \"".$_COOKIE["admin"]."\");";
    $mysqli->query($deleteCreatorPhotos);
    $deleteCreatorAlbum = "DELETE album FROM album WHERE idcreator =(SELECT idcreator FROM creator where creator.`name` = \"".$_COOKIE["admin"]."\");";
    $mysqli->query($deleteCreatorAlbum);
    $deleteCreatorAccount = "DELETE creator FROM creator WHERE  creator.`name` = \"".$_COOKIE["admin"]."\";";
    if ($mysqli->query($deleteCreatorAccount)) {
        setcookie("admin", "", time() - 60);
        header("Location: index.php" );
        exit ();
    }
    // close connection
    mysqli_close($mysqli);
?>