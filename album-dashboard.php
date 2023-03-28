<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="index.php"> view meme</a>
<?php
    header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Cache-Control: post-check=0, pre-check=0', FALSE);
    header('Pragma: no-cache');
    // if do not have users cookie, redirect to index.php
    if (!isset($_COOKIE["admin"])) {
        header("Location: index.php");
    }
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
    $q = "SELECT title FROM album WHERE idalbum = \"".convert_uudecode($_GET["idalbum"])."\";";

    //execute query 
    $result = mysqli_query($mysqli, $q);
  
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<h1>".$row["title"]." Album</h1>";
    }
  // array for extension of image
  $img = array('jpeg', 'jpg', 'png', 'gif', 'tiff', 'psg', 'ai', 'pdf', 'eps', 'indd', 'raw');
  // array for extension of video
  $vid = array('mp4', 'mov', 'avi', 'wmv', 'avchd', 'flv', 'f4v', 'swf', 'mkv', 'webm', 'html5', 'mpeg-2');
  // array for extension of audio
  $aud = array('m4a', 'flac', 'mp3', 'wav', 'wma', 'aac');
  // combine all extension into one array
  $allfiletype = array_merge($img, $vid, $aud);

  //query select data from database
  $sql = "SELECT photo.idphoto, photo.title, photo.comment, photo.imageurl, creator.name, creator.imageurl AS createrImageURL FROM (creator INNER JOIN photo ON creator.idcreator = photo.idcreator) WHERE photo.idalbum = ".convert_uudecode($_GET["idalbum"]) ." ORDER BY photo.`idphoto` DESC;";

  //execute query 
  $result = mysqli_query($mysqli, $sql);

  while ($row = mysqli_fetch_assoc($result)) {
    echo "<div class=\"container\">";
    echo "<div class=\"box\">";
    if ($row['createrImageURL']!= NULL){
      echo '<img src="creator/' . $row['createrImageURL'] . '" class="rounded" alt=" " width="50px" height="auto" />';
    }
    echo "<h2><b>Username:</b>" . $row['name'] . "</h2>";
    echo "<h3><b>Title:</b>" . $row['title'] . "</h3>";
    echo "<p>Comment: " . $row['comment'] . "</p>";
    echo "<div class=\"container-img\">";

    // get the extension of the media file
    $ext = strtolower(pathinfo($row['imageurl'], PATHINFO_EXTENSION));;

    // if it exist in video array extension, display:
    if (in_array($ext, $vid)) {
      echo "<p><video controls>\n";
      echo "<source src=\"memes/" . $row['imageurl'] . "\" type=\"video/mp4\">\n";
      echo 'Your browser does not support the video tag.';
      echo '</video></p>';
    }
    // if it exist in audio array extension, display:
    else if (in_array($ext, $aud)) {
      echo "<audio controls>
                    <source src=\"memes/" . $row['imageurl'] . "\" type=\"audio/mpeg\" >
                            Your browser does not support the audio element.
                        </audio>";
    }
    // if it exist in image array extension, display:
    else if (in_array($ext, $img)) {
      echo '<img src="memes/' . $row['imageurl'] . '" class="rounded" alt="' . $row['imageurl'] . '" width="50%" height="auto" />';
    }
    // head to edit page of the specific idphoto (encoded)
    echo "<br>";
    echo "<a href=\"edit-meme.php?idphoto=" . urlencode(convert_uuencode($row['idphoto'])) . "\">Edit</a>";
    echo "<br>";
    // head to depete page of the specific idphoto (encoded)
    echo "<a href=\"delete-meme.php?idphoto=" . urlencode(convert_uuencode($row['idphoto'])) . "\">Delete</a>";
    echo "<br>";
    echo "<hr>";
  }
?>
</body>
</html>