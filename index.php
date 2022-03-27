<?php
// Get Username and Password
$username = $_SERVER['PHP_AUTH_USER'];
$password = $_SERVER['PHP_AUTH_PW'];
// Database Credentials
$dbserver = "";
$dbuser = "";
$dbpass = "";
$dbname = "";
// Web Server
$webServer = "";
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
// Test to see if the stored hash equals our newly created hash
if ($hash == $r['hash']) {
  ?>
<html>
  <head>
    <title>Welcome to Super-Secret Land</title>
  </head>
  <body>
    Login Credentials are OK <a href="https://x:x@<?php echo $webServer; ?>/logout.php">Logout</a>
  </body>
</html>
<?php
} else {
  // Send headers to cause a browser to request
  // username and password from user
  header("WWW-Authenticate: " .
          "Basic realm=\"Super-Secret Land\"");
  header("HTTP/1.0 401 Unathorized");
  // Show failure text, which browsers usually
  // show only after several failed attempts
  print("This page is protected by HTTP");
}
?>