<?php
header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');

$dbServerName = "localhost";
$dbUserName = "root";
$idcreator = urlencode(convert_uuencode($_POST['idcreator']));
$dbPassword = "";
$dbName = "5614YCOM_CW";
// connect the database with the server
$mysqli = new mysqli($dbServerName, $dbUserName, $dbPassword, $dbName);

// if error occurs 
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$title = $_POST["title"];
$imageurl = $_POST["imageurl"];
$message = "";
$gotopage = "";
$color = "";

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
        $q = "INSERT INTO `album` (`idalbum`, `title`, `imageurl`, `idcreator`) VALUES (NULL, \"".$title."\",\"".$newfilename."\",\"".$_POST["idcreator"]."\");";
        // execute SQL query.
        if ($mysqli->query($q)) {
            $message = "You meme has been created.";
        }
        $message = "album has been created";
        $gotopage = "profile-page.php?idcreator=".$idcreator;
        $color = "green";
    }    
}


// close connection
mysqli_close($mysqli);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
<form action="<?php echo $gotopage; ?>"method="post"enctype="multipart/form-data">    
        <p style="color: <?php echo $color; ?>;"><?php echo $message; ?></p>
        <button type="submit">OK</button>
    </form>
</body>

</html>