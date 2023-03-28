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
    //query select data from database
    $sql = "SELECT * FROM creator WHERE idcreator = \"" . convert_uudecode($_GET["idcreator"]) . "\";";
    //execute query 
    $result = mysqli_query($mysqli, $sql);
    //display data row by row
    while ($row = mysqli_fetch_assoc($result)) {
      $imageurl = $row['imageurl']  ;
      $name = $row['name'];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $name; ?> Profile Page</title>
</head>

<body>
    <img src="creator/<?php echo $imageurl; ?>" alt="Profile pics" width="200" height="auto">
    <h1><?php echo $name; ?></h1>
    <form action="create-meme.php"method="post"enctype="multipart/form-data">
            <button>create meme</button>
            <input type="hidden" name="idcreator" value="<?php echo convert_uudecode($_GET["idcreator"]); ?>">
    </form>
    <a href="index.php">
        <p>view memes</p>
    </a>
    <a href="logout.php">
        <p>logout</p>
    </a>
    <hr>
    <h2>Album</h2>
    <form action="create-album.php"method="post"enctype="multipart/form-data">
            <button>create a album</button>
            <input type="hidden" name="idcreator" value="<?php echo convert_uudecode($_GET["idcreator"]); ?>">
    </form>
    <?php
      //query select data from database
    $query = "SELECT * FROM album WHERE idcreator = \"" . convert_uudecode($_GET["idcreator"]) . "\";";
    //execute query 
    $result = mysqli_query($mysqli, $query);
    //display data row by row
    while ($row = mysqli_fetch_assoc($result)) {
      $albumImageURL = $row['imageurl'];
      $albumTitle = $row['title'];
      echo "<a href=\"album-dashboard.php?idalbum=" . urlencode(convert_uuencode($row['idalbum'])) . "\">"; 
      echo "<br><img src=\"album/".$albumImageURL."\" alt=\"Albums coverpage\" width=\"200\" height=\"auto\">";
      echo "<br>".$albumTitle;
      echo "</a>";
    }
    ?>
    <hr>
    <h2>Memes</h2>
    <?php
  // array for extension of image
  $img = array('jpeg', 'jpg', 'png', 'gif', 'tiff', 'psg', 'ai', 'pdf', 'eps', 'indd', 'raw');
  // array for extension of video
  $vid = array('mp4', 'mov', 'avi', 'wmv', 'avchd', 'flv', 'f4v', 'swf', 'mkv', 'webm', 'html5', 'mpeg-2');
  // array for extension of audio
  $aud = array('m4a', 'flac', 'mp3', 'wav', 'wma', 'aac');
  // combine all extension into one array
  $allfiletype = array_merge($img, $vid, $aud);

  //query select data from database
  $sql = "SELECT photo.idphoto, photo.title, photo.comment, photo.imageurl, creator.name
            FROM (creator INNER JOIN photo ON creator.idcreator = photo.idcreator) 
            WHERE creator.idcreator = \"".convert_uudecode($_GET["idcreator"])."\" ORDER BY `idphoto` DESC;
";

  //execute query 
  $result = mysqli_query($mysqli, $sql);

  //display data row by row
  while ($row = mysqli_fetch_assoc($result)) {
    echo "<div class=\"container\">";
    echo "<div class=\"box\">";
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
    echo "</div>";
    // head to edit page of the specific idphoto (encoded)
    echo "<a href=\"edit-meme.php?idphoto=" . urlencode(convert_uuencode($row['idphoto'])) . "\">Edit</a>";
    echo "<br>";
    // head to depete page of the specific idphoto (encoded)
    echo "<a href=\"delete-meme.php?idphoto=" . urlencode(convert_uuencode($row['idphoto'])) . "\">Delete</a>";
    echo "<br>";
    echo "<a href=\"add-album.php?idphoto=" . urlencode(convert_uuencode($row['idphoto'])) . "\">Add Album</a>";
    echo "<hr>";
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