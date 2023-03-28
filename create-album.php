<?php
header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
// if do not have users cookie, redirect to index.php
if (!isset($_COOKIE["admin"])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Create Meme</title>
    <!-- connect to style.css -->
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <div class="container">
      <!-- header -->
      <h1>
        MemeHub Inc.
      </h1>
      <h3>Create Album</h3>
      <!-- box -->
      <div class="box martop15">
        <form
          action="upload-album.php"
          method="post"
          enctype="multipart/form-data"
        >
          <div class="row">
            <div class="col-25">
              <label for="title">Title</label>
            </div>
            <div class="col-75">
              <input
                type="text"
                name="title"
                id="title"
                placeholder="Enter a title"
              />
            </div>
          </div>
          <div class="row" style="margin-top: 20px">
            <div class="col-25">Album Coverpage</div>
            <div class="col-75">
              <input type="file" name="fileToUpload" id="fileToUpload" />
            </div>
          </div>
          <input type="hidden" name="idcreator" value="<?php echo $_POST["idcreator"]; ?>">
          <button class="button button2 button3" type="submit" name="post">
            Post
          </button>
        </form>
      </div>
    </div>
  </body>
</html>
