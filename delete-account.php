<?php
    include_once "connect-database.php";
    $q = "DELETE album, creator, photo FROM creator INNER JOIN photo ON creator.idcreator = photo.idcreator INNER JOIN album ON creator.idcreator = album.idcreator WHERE creator.`name` = \"".$_COOKIE["admin"]."\";";
    if ($mysqli->query($q)) {
        setcookie("admin", "", time() - 60);
        header("Location: index.php" );
        exit ();
    }
    // close connection
    mysqli_close($mysqli);
?>