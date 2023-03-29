<?php
    if (isset($_COOKIE["admin"])) {
        header("Location: view-meme.php" );
        exit ();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In & Sign Up</title>
</head>
<body>
    <h1>Login</h1>
    <form action="check-login.php" method="post" enctype="multipart/form-data">
        <p><input type="text" name="username" id="username" placeholder="username"/></p>
        <p><input type="password" name="password" id="password" placeholder="password"/></p>
        <button type="submit" name="post">Log In</button>
    </form>
    <hr>
    <h1>Signup</h1>
    <form action="check-signup.php" method="post" enctype="multipart/form-data">
        <p><input type="text" name="username" id="username" placeholder="username"/></p>
        <p><input type="password" name="password" id="password" placeholder="password"/></p>
        <p><input type="password" name="confirm-password" id="confirm-password" placeholder="re-type password"/></p>
        <p>Profile Picture:<br><input type="file" name="fileToUpload" id="fileToUpload" /></p>
        <button type="submit" name="post">Sign Up</button>
    </form>
</body>
</html>