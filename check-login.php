<?php
    include_once "connect-database.php";

    $q = "SELECT * FROM `creator` WHERE `name` = \"" . $_POST["username"] . "\";";
    $result = $mysqli->query($q);
    $row = $result->fetch_assoc();
    if ($_POST["password"] == $row["password"]) {
        setcookie("admin", $_POST["username"], time() + (60 * 60)); // set cookie
        header("Location: view-meme.php" );
        exit ();
    } else {
        header("Location: index.php" );
        exit ();
    }
    // close connection
    mysqli_close($mysqli);
?>