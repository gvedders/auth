<html>
  <head>
    <title>Create Password Hash</title>
  </head>
  <body>
    <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
      Username: <input type="text" name="username" value=""><br />
      Password: <input type="password" name="password" value=""><br />
      <input type="submit" name="Submit">
    </form>
    
    <?php
    if (isset($_POST['username']) AND isset($_POST['password'])) {
      $username = $_POST['username'];
      $password = $_POST['password'];
      // Create a 256 bit (64 characters) long random salt
      // Let's add 'something random and the username
      // to the salt as well for added security
      $salt = hash('sha256', uniqid(mt_rand(), true) . 'something random'
          . strtolower($username));
      // prefix the password with the salt
      $hash = $salt . $password;
      // Hash the password a bunch of times
      for ($i = 0; $i < 100000; $i++) {
        $hash = hash('sha256',$hash);
      }
      // Prefix the hash with the salt so we can find it back later
      $hash = $salt . $hash;
      echo "username = $username<br />password = $password<br />
            salt = $salt<br />hash = $hash<br />";
      echo "Salt Length = " . strlen($salt) . "Characters<br />
            Hash Length = " . strlen($hash) . "Characters"; 
    }
    ?>
  </body>
</html>