<?php
    include_once "reset-cache.php";
    // if do not have users cookie, redirect to index.php
    if (!isset($_COOKIE["admin"])) {
        header("Location: index.php");
    }

    include_once "connect-database.php";
    include_once "file-type.php";
    
    // query select creator data from database
    $getCreatorData = "SELECT * FROM creator WHERE idcreator = \"" . convert_uudecode($_GET["idcreator"]) . "\";";
    // execute query 
    $result = mysqli_query($mysqli, $getCreatorData);
    // get data row by row and set into variables
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
    <!-- display creator name at title -->
    <title><?php echo $name; ?> Profile Page</title>
</head>

<body>
    <!-- creator info part -->
    <!-- display creator profile picture -->
    <img src="creator/<?php echo $imageurl; ?>" alt="Profile pics" width="100px" height="auto">
    <h1><?php echo $name; ?> Profile Page</h1>
    <a href="view-meme.php"><p>view memes</p></a>
    <a href="logout.php"><p>logout</p></a>
    <a href="delete-account.php"><p>Delete Account</p></a>
    <hr>

    <!-- album part -->
    <h2>Album</h2>
    <form action="create-album.php"method="post"enctype="multipart/form-data">
            <button>create a album</button>
            <input type="hidden" name="idcreator" value="<?php echo convert_uudecode($_GET["idcreator"]); ?>">
    </form>
    <?php
      // query album data from database
      $query = "SELECT * FROM album WHERE idcreator = \"" . convert_uudecode($_GET["idcreator"]) . "\";";
      //execute query 
      $result = mysqli_query($mysqli, $query);
      //display data row by row
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<a href=\"album-dashboard.php?idalbum=" . urlencode(convert_uuencode($row['idalbum'])) . "\">"; 
        echo "<br><img src=\"album/".$row['imageurl']."\" alt=\"Albums coverpage\" width=\"50\" height=\"auto\">";
        echo "<br>".$row['title']. "</a>";
      } 
    ?>
    <hr>
    <!-- memes part -->
    <h2>Memes</h2>
    <form action="create-meme.php"method="post"enctype="multipart/form-data">
            <button>create meme</button>
            <input type="hidden" name="idcreator" value="<?php echo convert_uudecode($_GET["idcreator"]); ?>">
    </form>
    <?php
      //query select data from database
      $sql = "SELECT photo.idphoto, photo.title, photo.comment, photo.imageurl, creator.name FROM (creator INNER JOIN photo ON creator.idcreator = photo.idcreator)WHERE creator.idcreator = \"".convert_uudecode($_GET["idcreator"])."\" ORDER BY `idphoto` DESC;";
      //execute query 
      $result = mysqli_query($mysqli, $sql);
      //display data row by row
      while ($row = mysqli_fetch_assoc($result)) {
      echo "<h2><b>Username:</b>" . $row['name'] . "</h2>";
      echo "<h3><b>Title:</b>" . $row['title'] . "</h3>";
      echo "<p>Comment: " . $row['comment'] . "</p>";

      // get the extension of the media file
      $ext = strtolower(pathinfo($row['imageurl'], PATHINFO_EXTENSION));;

      // if it exist in video array extension, display:
      if (in_array($ext, $vid)) {
        echo "<p><video controls> <source src=\"memes/" . $row['imageurl'] . "\" type=\"video/mp4\"> Your browser does not support the video tag. </video></p>";
      }
      // if it exist in audio array extension, display:
      else if (in_array($ext, $aud)) {
        echo "<audio controls><source src=\"memes/" . $row['imageurl'] . "\" type=\"audio/mpeg\" >Your browser does not support the audio element.</audio>";
      }
      // if it exist in image array extension, display:
      else if (in_array($ext, $img)) {
        echo '<img src="memes/' . $row['imageurl'] . '" class="rounded" alt="' . $row['imageurl'] . '" width="50%" height="auto" />';
      }
      echo "<br>";
      // head to edit page of the specific idphoto (encoded)
      echo "<a href=\"edit-meme.php?idphoto=" . urlencode(convert_uuencode($row['idphoto'])) . "\">Edit</a>";
      echo "<br>";
      // head to depete page of the specific idphoto (encoded)
      echo "<a href=\"delete-meme.php?idphoto=" . urlencode(convert_uuencode($row['idphoto'])) . "\">Delete</a>";
      echo "<br>";
      echo "<a href=\"add-album.php?idphoto=" . urlencode(convert_uuencode($row['idphoto'])) . "\">Add Album</a>";
      echo "<hr>";
      }
      // close connection
      mysqli_close($mysqli);
    ?>
</body>

</html>