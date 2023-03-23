<?php
session_start();
ob_start();
// test
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // get input values from form
  $username = $_POST["username"];
  $password = $_POST["password"];

  //connect to database
  $dbServerName = "localhost";
  $dbUserName = "root";
  $dbPassword = "";
  $dbName = "5614ycom_cw2";
  $mysqli = new mysqli($dbServerName, $dbUserName, $dbPassword, $dbName);

  // if error occurs 
  if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
  }

  // prepare statement for selecting user
  $stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ?");

  // bind parameters to statement
  $stmt->bind_param("s", $username);

  // execute statement
  $stmt->execute();

  // get result set from statement
  $result = $stmt->get_result();

  // check if user exists and password is correct
  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $plaintext_password = $_POST["password"];
    if (password_verify($plaintext_password, $row['password'])) {
      $_SESSION["username"] = $row['username'];
      session_write_close();
      header("Location: index.php");
      exit();
    } else {
      //echo "Invalid username or password";
    }
  } else {
    echo "Invalid username or password";
  }
}

// function to hash password using bcrypt algorithm
function hashPassword($password) {
  $options = [
    'cost' => 12, // number of times to apply the hash function (higher is more secure but slower)
  ];
  return password_hash($password, PASSWORD_BCRYPT, $options);
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Login</title>
</head>

<body>
  <h2>Login</h2>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="username">Username:</label>
    <input type="text" name="username" required><br><br>
    <label for="password">Password:</label>
    <input type="password" name="password" required><br><br>
    <input type="submit" value="Login">
  </form>
</body>

</html>