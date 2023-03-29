<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Album Dashboard</title>
</head>
<body>
    <a href="view-meme.php"> view meme</a>
    <a href="delete-album.php?idalbum=<?php echo convert_uudecode($_GET["idalbum"]); ?>"> delete album</a>
<?php
    include_once "connect-database.php";
    include_once "file-type.php";
    $q = "SELECT title FROM album WHERE idalbum = \"".convert_uudecode($_GET["idalbum"])."\";";
    //execute query 
    $result = mysqli_query($mysqli, $q);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<h1>".$row["title"]." Album</h1>";
    }
    //query select data from database
    $sql = "SELECT photo.idphoto, photo.title, photo.comment, photo.imageurl, creator.name, creator.imageurl AS createrImageURL FROM (creator INNER JOIN photo ON creator.idcreator = photo.idcreator) WHERE photo.idalbum = ".convert_uudecode($_GET["idalbum"]) ." ORDER BY photo.`idphoto` DESC;";
    //execute query 
    $result = mysqli_query($mysqli, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
      if ($row['createrImageURL']!= NULL){
        echo '<img src="creator/' . $row['createrImageURL'] . '" class="rounded" alt=" " width="50px" height="auto" />';
      }
      echo "<h2><b>Username:</b>" . $row['name'] . "</h2>";
      echo "<h3><b>Title:</b>" . $row['title'] . "</h3>";
      echo "<p>Comment: " . $row['comment'] . "</p>";
      // get the extension of the media file
      $ext = strtolower(pathinfo($row['imageurl'], PATHINFO_EXTENSION));;

    // if it exist in video array extension, display:
    if (in_array($ext, $vid)) {
      echo "<p><video controls><source src=\"memes/" . $row['imageurl'] . "\" type=\"video/mp4\">Your browser does not support the video tag.</video></p>";
    }
    // if it exist in audio array extension, display:
    else if (in_array($ext, $aud)) {
      echo "<audio controls><source src=\"memes/" . $row['imageurl'] . "\" type=\"audio/mpeg\">Your browser does not support the audio element.</audio>";
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
    echo "<a href=\"remove-meme-from-album.php?idphoto=" . urlencode(convert_uuencode($row['idphoto'])) . "\">Remove from album</a>";
    echo "<br>";
    echo "<hr>";
  }
  // close connection
  mysqli_close($mysqli);
?>
</body>
</html>