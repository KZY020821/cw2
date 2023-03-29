<?php
    include_once "connect-database.php";
    $username = $_POST["username"];
    $password = $_POST["password"];

    $q = "SELECT * FROM `creator` WHERE `name` = \"" . $username . "\";";
    $result = $mysqli->query($q);
    $row = $result->fetch_assoc();
    if ($password == $row["password"]) {
        setcookie("admin", $username, time() + (60 * 60)); // set cookie
        header("Location: view-meme.php" );
        exit ();
    } else {
        header("Location: index.php" );
        exit ();
    }
    // close connection
    mysqli_close($mysqli);
?>