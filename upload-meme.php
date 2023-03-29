
    <?php
    include_once "connect-database.php";
    include_once "file-type.php";

    $target_dir = "memes/"; // set target directory
    $target_filename = basename($_FILES["fileToUpload"]["name"]); // set target filename
    $target_file = $target_dir . $target_filename; // concatenate
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $uploadOk = TRUE; // variable to determine if upload was successful


    $message = "";

    if ($target_filename != NULL) {
        // create a unique ID for new file name
        $newfilename = uniqid() . "." . $imageFileType;
        $newfiledir = "memes/" . $newfilename;
        if (in_array($imageFileType, $allfiletype)) {
            $uploadOk = TRUE;
        } else {
            $message = "ERROR, media extension is not supported.";
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
        $q = "INSERT INTO photo (title, comment, imageurl, idcreator) VALUES ('" . $_POST['title'] . "', '" . $_POST['comment'] . "', '" . $newfilename . "', '" . $_POST['idcreator'] . "')";
        // execute SQL query.
        $mysqli->query($q);
    }
    header("Location: view-meme.php" );
    exit ();
// close connection
mysqli_close($mysqli);
?>