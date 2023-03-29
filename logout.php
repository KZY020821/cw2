<?php
  include_once "reset-cache.php";
  if(isset($_COOKIE["admin"])) {
  // set cookie to 1 minute in the past
  setcookie("admin", "", time() - 60);
  // the browser will automatically delete it !
  // (No one likes stale cookies!!!)
  header("Location: index.php" );
  exit ();
  }
?>