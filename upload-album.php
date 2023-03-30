<?php
include_once "connect-database.php";
include_once "file-type.php";
$uploadOk = TRUE; // variable to determine if upload was successful

$q = "SELECT * FROM `album` WHERE idcreator = \"".$_COOKIE["admin"]."\";";
$result = $mysqli->query($q);
$row = $result->fetch_assoc();
if ($_POST["title"] == $row["title"]) {
    // title taken
    header("Location: create-album.php" );
    exit ();
} else {
    $target_dir = "album/"; // set target directory
    $target_filename = basename($_FILES["fileToUpload"]["name"]); // set target filename
    $target_file = $target_dir . $target_filename; // concatenate
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if ($target_filename != NULL) {
        // create a unique ID for new file name
        $newfilename = uniqid() . "." . $imageFileType;
        $newfiledir = "album/" . $newfilename;
        if (in_array($imageFileType, $img)) {
            $uploadOk = TRUE;
        } else {
            $uploadOk = FALSE;
            header("Location: create-album.php" );
            exit ();
        }

        if ($uploadOk) {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                // rename new file
                rename($target_file, $newfiledir);
            } else {
                $uploadOk = FALSE;
                header("Location: create-album.php" );
                exit ();
            }
        }
    } else {
        // https://www.flaticon.com/free-icon/gallery_4047371?related_id=4047371
        $newfilename = "default.png";
        $uploadOk = TRUE;
    }

    if ($uploadOk == TRUE) {
        // insert data into database
        $q = "INSERT INTO `album` (`idalbum`, `title`, `imageurl`, `idcreator`) VALUES (NULL, \"".$_POST["title"]."\",\"".$newfilename."\",\"".$_POST["idcreator"]."\");";
        // execute SQL query.
        if ($mysqli->query($q)) {
            header("Location: view-meme.php" );
            exit ();
        }
    }    
}

// close connection
mysqli_close($mysqli);
?>