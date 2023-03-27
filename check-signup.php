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
$color = "";
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
    $message = "Your email has been taken.";
    $uploadOK = FALSE;
    $color = "red";
} else {
    $uploadOK = TRUE;
    $color = "green";
}

if ($uploadOK == TRUE) {
    // update data to database
    $q = "INSERT INTO `creator` (`name`, `password`) VALUES ('" . $username . "', '" . $password . "') ";
    if ($mysqli->query($q)) {
        $message = "Your account has been created.";
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
    <form action="login-signup.html">
        <p style="color: <?php echo $color; ?>;"><?php echo $message; ?></p>
        <button type="submit">OK</button>
    </form>
</body>

</html>