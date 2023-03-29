<?php
    include_once "connect-database.php";

    $username = $_POST["username"];
    $password = $_POST["password"];
    $uploadOK = TRUE;
    $username_list = array();

    //check username is taken or not
    $sql = "SELECT name FROM creator;";
    $result = mysqli_query($mysqli, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $num = count($username_list);
        $position = $num;
        $inserted_value = $row["name"];
        array_splice($username_list, $position, 0, $inserted_value);
    }

    if (in_array($username, $username_list)) {
        $uploadOK = FALSE;
        header("Location: index.php" );
        exit ();
    } else {
        $target_dir = "creator/"; // set target directory
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
            $newfiledir = "creator/" . $newfilename;
            if (in_array($imageFileType, $img)) {
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
            $q = "INSERT INTO `creator` (`name`, `password`, `imageurl`) VALUES ('" . $username . "', '" . $password . "','".$newfilename."');";
            // execute SQL query.
            if ($mysqli->query($q)){
            setcookie("admin", $username, time() + (60 * 60)); // set cookie
            }
        }

        header("Location: view-meme.php" );
        exit ();
    }
    // close connection
    mysqli_close($mysqli);
    ?>
