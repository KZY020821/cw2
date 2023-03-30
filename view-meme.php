<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MemeHub</title>
  <!-- connect to style.css -->
</head>

<body>
  <!-- header -->
  <h1>MemeHub Inc.</h1>
  <h3>Homepage</h3>
  <?php
  include_once "reset-cache.php";
  include_once "connect-database.php";
  include_once "file-type.php";
  // header part
  // check it there is any cookie about "admin"
  if (isset($_COOKIE["admin"])) {
    // log out button
    echo "<p><a href=\"logout.php\"><button>Log Out</button></a></p>";
    // query select data from database
    $sql = "SELECT idcreator FROM creator WHERE name = \"" . $_COOKIE["admin"] . "\";";
    // execute query 
    $result = mysqli_query($mysqli, $sql);
    // display data row by row
    while ($row = mysqli_fetch_assoc($result)) {
      // link to user profile page
      echo "<p><a href=\"profile-page.php?idcreator=" . urlencode(convert_uuencode($row['idcreator'])) . "\">View profile</a></p>";
      // button to create meme
      echo "<form action=\"create-meme.php\"method=\"post\"enctype=\"multipart/form-data\">
      <button>create meme</button>
      <input type=\"hidden\" name=\"idcreator\" value=\"" . $row['idcreator'] . "\"></form>";
    }
    echo "<hr>";
  } else {
    echo "<p><a href=\"index.php\"><button>Log In / Sign Up</button></a></p>";
  }
  // show memes part (no edit, delete, add to album function)
  // query select data from database
  $showMemes = "SELECT photo.idphoto, photo.title, photo.comment, photo.imageurl, creator.name, creator.imageurl AS createrImageURL FROM (creator INNER JOIN photo ON creator.idcreator = photo.idcreator) ORDER BY `idphoto` DESC;";
  // execute query 
  $result = mysqli_query($mysqli, $showMemes);
  // display data row by row
  while ($row = mysqli_fetch_assoc($result)) {
    if ($row['createrImageURL'] != NULL) {
      echo '<img src="creator/' . $row['createrImageURL'] . '" class="rounded" alt=" " width="50px" height="auto" />';
    }
    echo "<h2><b>Username:</b>" . $row['name'] . "</h2>";
    echo "<h3><b>Title:</b>" . $row['title'] . "</h3>";
    echo "<p>Comment: " . $row['comment'] . "</p>";
    // get the extension of the media file
    $ext = strtolower(pathinfo($row['imageurl'], PATHINFO_EXTENSION));;
    // if it exist in video array extension, display:
    if (in_array($ext, $vid)) {
      echo "<p><video controls><source src=\"memes/" . $row['imageurl'] . "\" type=\"video/mp4\">Your browser does not support the video tag. </video></p>";
    }
    // if it exist in audio array extension, display:
    else if (in_array($ext, $aud)) {
      echo "<audio controls><source src=\"memes/" . $row['imageurl'] . "\" type=\"audio/mpeg\" >Your browser does not support the audio element.</audio>";
    }
    // if it exist in image array extension, display:
    else if (in_array($ext, $img)) {
      echo '<img src="memes/' . $row['imageurl'] . '" class="rounded" alt="' . $row['imageurl'] . '" width="50%" height="auto" />';
    }
    echo "<hr>";
  }
  // close connection
  mysqli_close($mysqli);
  ?>
</body>
</html>