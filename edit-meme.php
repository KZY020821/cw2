<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Meme</title>
  <!-- connect to style.css -->
  <link rel="stylesheet" href="style.css">
</head>

<body>
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

  $message = "";

  if ($_GET["idphoto"] != NULL) {
    echo "<div class=\"container\">";
    echo "<h1>MemeHub Inc.<a href=\"index.php\"><button class=\"button button2 btn-right\">View Meme</button></a></h1>";
    echo "<h3>Edit existing Meme</h3>";
    echo "<div class=\"box martop15\">";
    $q = "SELECT * FROM photo WHERE idphoto=" . convert_uudecode($_GET["idphoto"]) . ";";
    // execute query 
    if ($res = $mysqli->query($q)) {
      if ($res->data_seek(0)) {
        while ($row = $res->fetch_assoc()) {
          // form for user to insert data
          echo "<form action=\"edit-meme2.php\" method=\"post\" enctype=\"multipart/form-data\">" . "\n";

          // insert title
          echo "<div class=\"row\">";
          echo "<div class=\"col-25\">";
          echo "<label for=\"title\">Title</label>";
          echo "</div>";
          echo "<div class=\"col-75\">";
          echo "<input type=\"text\" name=\"title\" id=\"title\" value=\"" . $row["title"] . "\">" . "\n";
          echo "</div>";
          echo "</div>";

          // insert comment
          echo "<div class=\"row\">";
          echo "<div class=\"col-25\">";
          echo "<label for=\"comment\">Comment</label>";
          echo "</div>";
          echo "<div class=\"col-75\">";
          echo "<textarea name=\"comment\" id=\"comment\" rows=\"10\" cols =\"30\">" . $row["comment"] . "</textarea>" . "\n";
          echo "</div>";
          echo "</div>";

          // send idphoto secretly
          echo "<input type=\"hidden\" name=\"idphoto\" value=\"" . $row["idphoto"] . "\">" . "\n";

          // upload meme file
          echo "<div class=\"row\" style=\"margin-top: 20px;\">";
          echo "<div class=\"col-25\">Upload Meme:</div>";
          echo "<div class=\"col-75\">";
          echo "<input type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\" />";
          echo "</div>";
          echo "</div>";
          echo "<br>";

          //checkbox to remove the previous meme file
          echo "<label>";
          echo "<b>Remove the previous meme</b>";
          echo "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" VALUE=TRUE>";
          echo "</label>";

          //submit button
          echo "<button class=\"button button2 button3\" type=\"submit\" name=\"submit\">Post</button>";
          echo "</form>" . "\n";
        }
      } else {
        // tell user no meme were found 
        echo "<div class=\"container\">";
        // header
        echo "<h1>MemeHub Inc.<a href=\"index.php\"><button class=\"button button2 btn-right\">View Meme</button></a></h1>";
        echo "<h3>Meme Upload Edit Status</h3>";

        // box
        echo "<div class=\"box martop15\">";
        echo "<b>MemeHub Inc. would like to tell you</b><br>";
        echo "No Meme were found";
        echo "<a href=\"index.php\"><button class=\"button button2 button3\">OK</button></a>";
        echo "</div>";
        echo "</div>";
      }
    } else {
      // tell user try again later
      echo "<div class=\"container\">";

      // header
      echo "<h1>MemeHub Inc.<a href=\"index.php\"><button class=\"button button2 btn-right\">View Meme</button></a></h1>";
      echo "<h3>Meme Upload Edit Status</h3>";

      // box
      echo "<div class=\"box martop15\">";
      echo "<b>MemeHub Inc. would like to tell you</b><br>";
      echo "Something went wrong, please try again later";
      echo "<a href=\"index.php\"><button class=\"button button2 button3\">OK</button></a>";
      echo "</div>";
      echo "</div>";
    }
  } else {

    // tell user try again later
    echo "<div class=\"container\">";

    // header
    echo "<h1>MemeHub Inc.<a href=\"index.php\"><button class=\"button button2 btn-right\">View Meme</button></a></h1>";
    echo "<h3>Meme Upload Edit Status</h3>";

    // box
    echo "<div class=\"box martop15\">";
    echo "<b>MemeHub Inc. would like to tell you</b><br>";
    echo "Something went wrong, please try again later";
    echo "<a href=\"index.php\"><button class=\"button button2 button3\">OK</button></a>";
    echo "</div>";
    echo "</div>";
  }
  ?>
  </div>
  </div>
</body>

</html>
<?php
// close connection
mysqli_close($mysqli);
?>