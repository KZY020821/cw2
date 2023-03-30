<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Create Meme</title>
  </head>
  <body>
      <h1>
        MemeHub Inc.
        <a href="view-meme.php">
          <button>View Meme</button>
        </a>
      </h1>
      <h3>Create Meme</h3>
      <!-- box -->
        <form action="upload-meme.php"method="post"enctype="multipart/form-data">
              <label for="title">Title</label>
              <input type="text"name="title"id="title"placeholder="Enter a title"/>
              <br>
              <label for="comment">Comment</label>
              <textarea name="comment"id="comment"placeholder="What's on your mind?"rows="10"cols="30"></textarea>
              <br>
              Upload Meme <input type="file" name="fileToUpload" id="fileToUpload" />
              <input type="hidden" name="idcreator" value="<?php echo $_POST["idcreator"]; ?>">
              <button type="submit" name="post">Create</button>
        </form>
  </body>
</html>
