<?php
    include_once "connect-database.php";
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