<?php
header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');

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
$username = $_POST["username"];
$password = $_POST["password"];
$message = "";
$gotopage = "";
$color = "";

$q = "SELECT * FROM `creator` WHERE `name` = \"" . $username . "\";";
$result = $mysqli->query($q);
$row = $result->fetch_assoc();
if ($password == $row["password"]) {
    $message = "password correct";
    $gotopage = "index.php";
    $color = "green";
    setcookie("admin", $username, time() + (60 * 60)); // set cookie
} else {
    $message = "password wrong";
    $gotopage = "wrong-password.html";
    $color = "red";
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
    <form action="<?php echo $gotopage; ?>">
        <p style="color: <?php echo $color; ?>;"><?php echo $message; ?></p>
        <button type="submit">OK</button>
    </form>
</body>

</html>