<?php
// Web Server
$webServer = "";
// Database Credentials
  $dbserver = "";
  $dbuser = "";
  $dbpass = "";
  $dbname = "";
// Get Username and Password
if ((isset($_POST['username'])) && isset($_POST['password']) && !isset($_COOKIE['loggedIn'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  if (($username != "") || ($password != "")) {
    // Connect to MySQL for username and stored hash
    $link = mysqli_connect($dbserver, $dbuser, $dbpass, $dbname);
    $sql = "SELECT hash FROM users WHERE username='" .
        mysqli_real_escape_string($link, $username) . "' Limit 1;";
    $r = mysqli_fetch_assoc(mysqli_query($link,$sql));
    // The first 64 characters of the hash is the salt
    $salt = substr($r['hash'], 0, 64);
    $hash = $salt . $password;
    // Hash the password as we did before
    for ($i = 0; $i < 100000; $i++) {
      $hash = hash('sha256', $hash);
    }
    $hash = $salt . $hash;
  }
}
 // Test to see if the stored hash equals our newly created hash
if ((isset($hash)) && (isset($r['hash']))) {
  if ($hash == $r['hash']) { 
    setcookie("loggedIn", '1', time()+3600);  /* expire in 1 hour */
    welcome($webServer);
  } else {
    loginForm($webServer);
  }
} else {
  if (isset($_COOKIE['loggedIn'])) {
    if ($_COOKIE['loggedIn'] == '1') {
      welcome($webServer);
    }
  } else {
    loginForm($webServer);
  } 
}

function loginForm($webServer) {
  ?>
  <html>
    <head>
      <title>Login Form</title>
    </head>
    <body>
      <form method="post" action="<?php echo $webServer; ?>">
        <table>
          <tr>
            <td>Username: </td>
            <td><input type="text" name="username" value=""></td>
          </tr>
          <tr>
            <td>Password: </td>
            <td><input type="password" name="password" value=""></td>
          </tr>
          <tr>
            <td colspan="2" align="right"><input type="submit" name="Submit"></td>
          </tr>
        </table>
      </form>
    </body>
  </html>
<?php
}

function welcome($webServer) {
  ?>
    <html>
      <head>
        <title>Welcome to Super-Secret Land</title>
      </head>
      <body>
        Login Credentials are OK <br /><br /><a href="<?php echo $webServer; ?>/logout.php">Logout</a>
      </body>
    </html>
  <?php 
}
?>
