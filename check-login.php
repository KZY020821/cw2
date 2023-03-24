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
$email = $_POST ["email"];
$password = $_POST ["password"];
$message = "";
$gotopage ="";
$color = "";

$q = "SELECT * FROM `users` WHERE `email` = \"".$email."\";";
$result = $mysqli->query($q);
$row = $result->fetch_assoc();
if ($password == $row["password"]) {
    $message ="password correct";
    $gotopage = "index.php";
    $color = "green";
} else {
    $message ="password wrong";
    $gotopage = "login-signup.html";
    $color = "red";
}
echo $message;
echo $gotopage;
echo $color;
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
