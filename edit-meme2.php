<?php
    include_once "connect-database.php";
    include_once "file-type.php";
    $target_dir = "memes/"; // set target directory
    $target_filename = basename($_FILES["fileToUpload"]["name"]); // set target filename
    $target_file = $target_dir . $target_filename; // concatenate
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $uploadOk = TRUE; // variable to determine if upload was successful

    $message = "";

    // get file name
    $sql = "SELECT * FROM photo WHERE idphoto =" . $_POST["idphoto"] . ";";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $fileloc = $target_dir . $row["imageurl"];
    if (empty($_POST["checkbox"]) && $target_filename == NULL) {
        // file name remain the same
        $newfilename = $row["imageurl"];
    } else if (!empty($_POST["checkbox"]) && $_POST["checkbox"] == TRUE && $target_filename == NULL) {
        // delete meme from local storage
        if ($row["imageurl"] != NULL) {
            // delete old file
            unlink($fileloc);
        }
        $newfilename = NULL;
    } else if ($target_filename != NULL) {
        // create a unique ID for new file name
        $newfilename = uniqid() . "." . $imageFileType;
        $newfiledir = $target_dir . $newfilename;
        if (in_array($imageFileType, $allfiletype)) {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                // rename new file
                rename($target_file, $newfiledir);
                if ($row["imageurl"] != NULL) {
                    // delete old file
                    unlink($fileloc);
                }
            } else {
                $message = "Something went wrong, please try again later.";
            }
        } else {
            $message = "ERROR, media extension is not supported.";
        }
    }

    // update data to database
    $q = "UPDATE photo SET title='" . addslashes($_POST['title']) . "', " . "comment='" . addslashes($_POST['comment']) . "', " . "imageurl='" . addslashes($newfilename) . "' " . " WHERE idphoto=" . $_POST['idphoto'] . ";";
    if ($mysqli->query($q)) {
        header("Location: view-meme.php" );
        exit ();
    }
// close connection
mysqli_close($mysqli);
?>