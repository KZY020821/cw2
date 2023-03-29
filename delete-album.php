<?php
    include_once "connect-database.php";
    $q = "DELETE album FROM album WHERE idalbum = \"".$_GET['idalbum']."\";";
    if ($mysqli->query($q)) {
        header("Location: index.php" );
        exit ();
    }
    // close connection
    mysqli_close($mysqli);
?>