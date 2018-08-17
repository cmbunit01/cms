<?php

  if (isset($_GET["edit_user"]))
  {
    $userid = $_GET["edit_user"];

    // Get the user details
    $query = "SELECT * FROM users WHERE userid = {$userid};";
    $result = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($result))
    {
      $username = $row["username"];
      $password = $row["password"];
      $firstname = $row["firstname"];
      $lastname = $row["lastname"];
      $email = $row["email"];
      $userimage = $row["userimage"];
      $role = $row["role"];
    }
  }

  if (isset($_POST["update"]))
  {
    $userid = $_GET["edit_user"];

    $username = $_POST["username"];
    $password = $_POST["password"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];

    // Get salt to encrypt password.
    $query = "SELECT randSalt FROM users WHERE userid = $userid;";
    $result = mysqli_query($connection, $query) or die("Query failed: " . mysqli_error($connection));
    $row = mysqli_fetch_assoc($result);
    $salt = $row["randSalt"];
    $hashed = crypt($password, $salt);

    if(isset($_FILES["image"]["name"]))
    {
      $userimage = $_FILES["image"]["name"];
      $userimage_temp = $_FILES["image"]["tmp_name"];
    }

    $role = $_POST["role"];

    if (empty($userimage))
    {
      $query = "SELECT `userimage` FROM users WHERE userimage = {$userid};";
      $image = mysqli_fetch_assoc(mysqli_query($connection, $query));

      $userimage = $image["postImage"];
    }

    $query = "UPDATE users SET ";
    $query .="username = '{$username}', ";
    $query .="password = '{$hashed}', ";
    $query .="firstname = '{$firstname}', ";
    $query .="lastname = '{$lastname}', ";
    $query .="email = '{$email}', ";
    $query .="userimage = '{$userimage}', ";
    $query .="role = '{$role}' ";

    $query .= "WHERE userid = {$userid};";

    $result = mysqli_query($connection, $query);
    queryCheck($result);
  }

?>

<form class="" action="" method="post" enctype="multipart/form-data">
  <?php
    if (isset($_POST["update"]))
    {
  ?>
  <div class="form-group">
    <p class="bg-success">
      <span class="text-success">User Updated: </span> - <a href="users.php">View All Users</a>
    </p>
  </div>
  <?php
    }
  ?>
  <div class="form-group">
    <label for="firstname">First Name</label>
    <input class="form-control" type="text" name="firstname" value="<?php echo $firstname; ?>">
  </div>
  <div class="form-group">
    <label for="lastname">Last Name</label>
    <input class="form-control" type="text" name="lastname" value="<?php echo $lastname; ?>">
  </div>
  <div class="form-group">
    <label for="role">Role</label>
    <select class="" name="role">
      <?php
        if ($role == "admin")
        {
      ?>
      <option value="subscriber">Select Role</option>
      <option value="admin" selected>Admin</option>
      <option value="subscriber">Subscriber</option>
      <?php
        }
        else
        {
      ?>
      <option value="subscriber">Select Role</option>
      <option value="admin">Admin</option>
      <option value="subscriber" selected>Subscriber</option>
      <?php
        }
      ?>
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
    <input class="form-control" type="text" name="username" value="<?php echo $username; ?>">
  </div>
  <div class="form-group">
    <label for="email">Email</label>
    <input class="form-control" type="text" name="email" value="<?php echo $email; ?>">
  </div>
  <div class="form-group">
    <label for="userimage">User Image</label>
    <?php
      if ((isset($userimage)) && (strlen($userimage) > 0))
      {
    ?>
    <img src="../images/<?php echo $userimage; ?>" alt="" width="150">
    <?php
      }
    ?>
    <input class="form-control" type="file" name="userimage">
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input class="form-control" type="password" name="password" value="<?php echo $password; ?>">
  </div>
  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="update" value="Update">
  </div>
</form>
