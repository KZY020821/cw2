<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Create album</title>
</head>

<body>
    <!-- header -->
    <h1>
      MemeHub Inc.
    </h1>
    <h3>Create Album</h3>
      <form action="upload-album.php" method="post" enctype="multipart/form-data">
        <p><input type="text" name="title" id="title" placeholder="Enter a title" /></p>
        <p>Album Coverpage<input type="file" name="fileToUpload" id="fileToUpload" /></p>
        <input type="hidden" name="idcreator" value="<?php echo $_POST["idcreator"]; ?>">
        <p><button type="submit" name="post">Post</button></p>
      </form>
</body>

</html>