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
$username = $_POST ["username"];
$email = $_POST ["email"];
$password = $_POST ["password"];
$message = "";

// update data to database
$q = "INSERT INTO `users` (`username`, `email`, `password`) VALUES ('".$username."', '".$email."', '".$password."') ";
if ($mysqli->query($q)) {
    $message = "Your account has been created.";
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
    <form action="login-signup.html">
    <p style="color: green;"><?php echo $message; ?></p>
    <button type="submit">OK</button>
    </form>
</body>
</html>