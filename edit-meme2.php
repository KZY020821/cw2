<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meme Edit Status</title>
    <!-- connect to style.css -->
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php
    $dbServerName = "localhost";
    $dbUserName = "root";
    $dbPassword = "";
    $dbName = "5614YCOM_CW";
    // connect the database with the server
    $mysqli = new mysqli($dbServerName, $dbUserName, $dbPassword, $dbName);

    // if error occurs 
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }

    $target_dir = "memes/"; // set target directory
    $target_filename = basename($_FILES["fileToUpload"]["name"]); // set target filename
    $target_file = $target_dir . $target_filename; // concatenate
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $uploadOk = TRUE; // variable to determine if upload was successful

    // array for extension of image
    $img = array("jpeg", "jpg", "png", "gif", "tiff", "psg", "ai", "pdf", "eps", "indd", "raw");
    // array for extension of video
    $vid = array("mp4", "mov", "avi", "wmv", "avchd", "flv", "f4v", "swf", "mkv", "webm", "html5", "mpeg-2");
    // array for extension of audio
    $aud = array("m4a", "flac", "mp3", "wav", "wma", "aac");
    // combine all extension into one array
    $allfiletype = array_merge($img, $vid, $aud);

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
        $message = "You meme has been updated.";
    }
    ?>

    <div class="container">
        <!-- header -->
        <h1>MemeHub Inc.<a href="index.php"><button class="button button2 btn-right">View Meme</button></a></h1>
        <h3>Meme Upload Edit Status</h3>

        <!-- box -->
        <div class="box martop15">
            <b>MemeHub Inc. would like to tell you</b>
            <br>
            <?php
            echo $message;
            ?>
            <a href="index.php">
                <button class="button button2 button3">
                    OK
                </button>
            </a>
        </div>
    </div>
</body>

</html>
<?php
// close connection
mysqli_close($mysqli);
?>