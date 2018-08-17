<?php
  $db["db_host"] =   "localhost";
  $db["db_user"] =   "root";
  $db["db_pwd"] =    "root";
  $db["db_name"] =   "cms";
  $db["db_port"] =   3307;

  // Convert params to constants
  foreach($db as $key => $value)
  {
    define(strtoupper($key), $value);
  }

  $connection = mysqli_connect(DB_HOST, DB_USER, DB_PWD, DB_NAME, DB_PORT) or die("Connection failed.");
?>
