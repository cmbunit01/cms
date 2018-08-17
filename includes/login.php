<?php include "db.php"; ?>
<?php session_start(); ?>
<?php

  if(isset($_POST["login"]))
  {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $query = "SELECT * FROM users WHERE username = '{$username}';";
    $result = mysqli_query($connection, $query) or die ("Query failed: " . mysqli_error($connection));

    while ($row = mysqli_fetch_assoc($result))
    {
      $dbuserid = $row["userid"];
      $dbusername = $row["username"];
      $dbpassword = $row["password"];
      $dbfirstname = $row["firstname"];
      $dblastname = $row["lastname"];
      $dbrole = $row["role"];
    }

    $password = crypt($password, $dbpassword);

    if (($username !== $dbusername) && ($password !== $dbpassword))
    {
      header("Location: ../index.php");
    }
    else if (($username == $dbusername) && ($password == $dbpassword))
    {
      $_SESSION["username"] = $dbusername;
      $_SESSION["firstname"] = $dbfirstname;
      $_SESSION["lastname"] = $dblastname;
      $_SESSION["role"] = $dbrole;

      header("Location: ../admin");
    }
    else
    {
      header("Location: ../index.php");
    }
  }
?>
