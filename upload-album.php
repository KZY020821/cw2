<?php
include_once "connect-database.php";
$title = $_POST["title"];
$imageurl = $_POST["imageurl"];

$q = "SELECT * FROM `album`;";
$result = $mysqli->query($q);
$row = $result->fetch_assoc();
if ($title == $row["title"]) {
    $message = "title has been taken";
    $gotopage = "create-album.php";
    $color = "red";
} else {
    $target_dir = "album/"; // set target directory
    $target_filename = basename($_FILES["fileToUpload"]["name"]); // set target filename
    $target_file = $target_dir . $target_filename; // concatenate
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $uploadOk = TRUE; // variable to determine if upload was successful

    // array for extension of image
    $img = array("jpeg", "jpg", "png", "gif", "tiff", "psg", "ai", "pdf", "eps", "indd", "raw");
    $message = "";

    if ($target_filename != NULL) {
        // create a unique ID for new file name
        $newfilename = uniqid() . "." . $imageFileType;
        $newfiledir = "album/" . $newfilename;
        if (in_array($imageFileType, $img)) {
            $uploadOk = TRUE;
        } else {
            $uploadOk = FALSE;
        }

        if ($uploadOk) {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                // rename new file
                rename($target_file, $newfiledir);
            } else {
                $message = "Something went wrong, please try again later.";
            }
        }
    } else {
        $newfilename = NULL;
    }

    if ($uploadOk) {
        // insert data into database
        $q = "INSERT INTO `album` (`idalbum`, `title`, `imageurl`, `idcreator`) VALUES (NULL, \"".$title."\",\"".$newfilename."\",\"".$_POST["idcreator"]."\");";
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