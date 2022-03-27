<?php
// Destroy login info
if (!isset($_SERVER['PHP_AUTH_USER'])) {
  header('WWW-Authenticate: Basic realm="Super-Secret Land"');
  header('HTTP/1.0 401 Unathorized');
  echo 'Text to send if user hits cancel button';
  exit;
}
header('Location: index.php');
?>