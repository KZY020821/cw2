<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Meme</title>
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

    // declare message to 
    $message = "";

    $sql = "SELECT * FROM photo WHERE idphoto =" . convert_uudecode($_GET["idphoto"]) . ";";
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_assoc()) {
        $fileloc = "memes/" . $row["imageurl"];
        if ($row["imageurl"] != NULL) {
            //delete file from local storage
            unlink($fileloc);
        }
    }

    // create SQL query to delete message with idmessage=id
    $q = "DELETE FROM photo WHERE idphoto=" . convert_uudecode($_GET["idphoto"]) . ";";
    // execute query and output a success/error message
    if ($mysqli->query($q)) {
        $message = "Your meme has been deleted.";
    }
    ?>
    <div class="container">
        <h1>
            MemeHub Inc.
            <a href="index.php">
                <button class="button button2 btn-right">View Meme</button>
            </a>
        </h1>
        <h3>Meme Delete Status</h3>
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