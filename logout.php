<?php
  header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
  header('Cache-Control: no-store, no-cache, must-revalidate');
  header('Cache-Control: post-check=0, pre-check=0', FALSE);
  header('Pragma: no-cache');
?>
<?php
if(isset($_COOKIE["admin"])) {
// set cookie to 1 minute in the past
setcookie("admin", "", time() - 60);
// the browser will automatically delete it !
// (No one likes stale cookies!!!)
}
?>
<html>
<head>
<title>Logout</title>
</head>
<body>
<h2 style="color: green;">You are logged out!!!</h2>
<a href="index.php">See Memes</a>
</body>
</html>