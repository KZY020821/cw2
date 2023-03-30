<?php
    include_once "connect-database.php";
    include_once "file-type.php";
    
    $uploadOK = TRUE; // variable to determine if upload was successful
    $username_list = array();

    //check username is taken or not
    $sql = "SELECT name FROM creator;";
    $result = mysqli_query($mysqli, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        array_splice($username_list, count($username_list), 0, $row["name"]);
    }

    if (in_array($_POST["username"], $username_list)) {
        $uploadOK = FALSE;
        header("Location: index.php" );
        exit ();
        // cookie message failed
    } else if ($_POST["password"] != $_POST["confirm-password"]) {
        $uploadOK = FALSE;
        header("Location: index.php" );
        exit ();
    }else {
        $target_dir = "creator/"; // set target directory
        $target_filename = basename($_FILES["fileToUpload"]["name"]); // set target filename
        $target_file = $target_dir . $target_filename; // concatenate
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if ($target_filename != NULL) {
            // create a unique ID for new file name
            $newfilename = uniqid() . "." . $imageFileType;
            $newfiledir = "creator/" . $newfilename;
            if (in_array($imageFileType, $img)) {
                $uploadOk = TRUE;
            } else {
                $uploadOk = FALSE;
                header("Location: index.php" );
                exit ();
            }

            if ($uploadOk == TRUE) {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    // rename new file
                    rename($target_file, $newfiledir);
                } else {
                    $uploadOk = FALSE;
                    header("Location: index.php" );
                    exit ();
                }
            } 
        } else {
            // https://www.flaticon.com/free-icon/user_221729d
            $newfilename = "default.png";
            $uploadOK = TRUE;
        }

        if ($uploadOK == TRUE) {
            // insert data into database
            $q = "INSERT INTO `creator` (`name`, `password`, `imageurl`) VALUES ('" . $_POST["username"] . "', '" . $_POST["password"] . "','".$newfilename."');";
            // execute SQL query.
            if ($mysqli->query($q)){
                setcookie("admin", $_POST["username"], time() + (60 * 60)); // set cookie
                header("Location: view-meme.php" );
                exit ();
            }
        }
    }
    // close connection
    mysqli_close($mysqli);
    ?>
