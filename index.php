<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MemeHub</title>
  <!-- connect to style.css -->
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <!-- header -->
  <div class="container">
    <h1>
      MemeHub Inc.
      <a href="create-meme.html">
        <button class="button button2 btn-right">
          Create Meme
        </button>
      </a>
    </h1>
    <h3>Homepage</h3>
  </div>

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

  // array for extension of image
  $img = array('jpeg', 'jpg', 'png', 'gif', 'tiff', 'psg', 'ai', 'pdf', 'eps', 'indd', 'raw');
  // array for extension of video
  $vid = array('mp4', 'mov', 'avi', 'wmv', 'avchd', 'flv', 'f4v', 'swf', 'mkv', 'webm', 'html5', 'mpeg-2');
  // array for extension of audio
  $aud = array('m4a', 'flac', 'mp3', 'wav', 'wma', 'aac');
  // combine all extension into one array
  $allfiletype = array_merge($img, $vid, $aud);

  //query select data from database
  $sql = "SELECT `idphoto`,`title`, `comment`, `imageurl` FROM `photo` ORDER BY `idphoto` DESC;";

  //execute query 
  $result = mysqli_query($mysqli, $sql);

  //display data row by row
  while ($row = mysqli_fetch_assoc($result)) {
    echo "<div class=\"container\">";
    echo "<div class=\"box\">";
    echo "<h3><b>Title:</b>" . $row['title'] . "</h3>";
    echo "<ul><li>Comment: " . $row['comment'] . "</li></ul>";
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
    echo "</div>";
    // head to edit page of the specific idphoto (encoded)
    echo "<a href=\"edit-meme.php?idphoto=" . urlencode(convert_uuencode($row['idphoto'])) . "\">Edit</a>";
    // head to depete page of the specific idphoto (encoded)
    echo "<a href=\"delete-meme.php?idphoto=" . urlencode(convert_uuencode($row['idphoto'])) . "\">Delete</a>";
    echo "</div>";
    echo "</div>";
  }
  ?>
</body>

</html>
<?php
// close connection
mysqli_close($mysqli);
?>