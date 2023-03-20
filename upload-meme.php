<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post status</title>
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
        $q = "INSERT INTO photo (title, comment, imageurl) VALUES ('" . $_POST['title'] . "', '" . $_POST['comment'] . "', '" . $newfilename . "')";
        // execute SQL query.
        if ($mysqli->query($q)) {
            $message = "You meme has been created.";
        }
    }
    ?>
    <div class="container">
        <!-- header -->
        <h1>MemeHub Inc.<a href="index.php"><button class="button button2 btn-right">View Meme</button></a></h1>
        <h3>Meme Upload Status</h3>

        <!-- box -->
        <div class="box martop15">
            <b>MemeHub Inc. would like to tell you</b>
            <br>
            <?php echo $message; ?>
            <a href="index.php">
                <button class="button button2 button3">OK</button>
            </a>
        </div>
    </div>
</body>

</html>
<?php
// close connection
mysqli_close($mysqli);
?>