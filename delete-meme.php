<?php
    include_once "connect-database.php";
    $sql = "SELECT * FROM photo WHERE idphoto =" . convert_uudecode($_GET["idphoto"]) . ";";
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_assoc()) {
        $fileloc = "memes/" . $row["imageurl"];
        if ($row["imageurl"] != NULL) {
            //delete file from local storage
            unlink($fileloc);
        }
    }

    $q = "DELETE FROM photo WHERE idphoto=" . convert_uudecode($_GET["idphoto"]) . ";";
    if ($mysqli->query($q)) {
        header("Location: view-meme.php" );
        exit ();
    }
    // close connection
    mysqli_close($mysqli);
?>