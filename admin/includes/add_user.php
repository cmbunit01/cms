<?php

  if (isset($_POST["create"]))
  {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];

    $role = $_POST["role"];
    $username = $_POST["username"];
    $email = $_POST["email"];

    $userimage = $_FILES["image"]["name"];
    $userimage_temp = $_FILES["image"]["tmp_name"];

    $password = $_POST["password"];

    $query = "SELECT randSalt FROM users;";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    $salt = $row["randSalt"];
    // Encrypt the password
    $password = crypt($password, $salt);

    move_uploaded_file($userimage_temp, "../images/$userimage");

    $query = "INSERT INTO users(firstname, lastname, role, username, email, userimage, password) ";

    $query .= "VALUES('{$firstname}', '{$lastname}', '{$role}', '{$username}', '{$email}', '{$userimage}', '{$password}');";

    $result = mysqli_query($connection, $query);
    queryCheck($result);

  }

?>

<form class="" action="" method="post" enctype="multipart/form-data">
  <?php
    if (isset($_POST["create"]))
    {
  ?>
  <div class="form-group">
    <p class="bg-success">
      <span class="text-success">User Created: </span> - <a href="users.php">View All Users</a>
    </p>
  </div>
  <?php
    }
  ?>
  <div class="form-group">
    <label for="firstname">First Name</label>
    <input class="form-control" type="text" name="firstname">
  </div>
  <div class="form-group">
    <label for="lastname">Last Name</label>
    <input class="form-control" type="text" name="lastname">
  </div>
  <div class="form-group">
    <label for="role">Role</label>
    <select class="" name="role">
      <option value="subscriber">Select Role</option>
      <option value="admin">Admin</option>
      <option value="subscriber">Subscriber</option>
      <?php
        /*
        $query = "SELECT * FROM users;";
        $result = mysqli_query($connection, $query);
        queryCheck($result);

        while ($row = mysqli_fetch_assoc($result))
        {
          $userid = $row["userid"];
          $role = $row["role"];

          $html = "<option value=\"$userid\">{$role}</option>";
          echo $html;
        }
        */
      ?>
    </select>
  </div>
  <div class="form-group">
    <label for="username">Username</label>
    <input class="form-control" type="text" name="username">
  </div>
  <div class="form-group">
    <label for="email">Email</label>
    <input class="form-control" type="text" name="email">
  </div>
  <div class="form-group">
    <label for="image">User Image</label>
    <input class="form-control" type="file" name="image">
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input class="form-control" type="password" name="password">
  </div>
  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="create" value="Publish">
  </div>
</form>
