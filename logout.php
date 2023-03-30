<?php
  // Destroy login info
  setcookie("loggedIn", "", time()-(60*60*24*7));
  unset($_COOKIE["loggedIn"]);
  header('Location: index.php');
?>
