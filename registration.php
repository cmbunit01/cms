<?php  include "includes/header.php"; ?>


    <!-- Navigation -->

    <?php  include "includes/navigation.php"; ?>

    <?php

      if (isset($_POST["submit"]))
      {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        if (!empty($username) && !empty($email) && !empty($password))
        {

          // Get values and clean up strings
          $username = mysqli_real_escape_string($connection, $username);
          $email = mysqli_real_escape_string($connection, $email);
          $password = mysqli_real_escape_string($connection, $password);

          $query = "SELECT randSalt FROM users;";
          $result = mysqli_query($connection, $query);

          $row = mysqli_fetch_assoc($result);
          $salt = $row["randSalt"];
          // Encrypt the password
          $password = crypt($password, $salt);

          // echo $salt;

          if (!$result)
          {
            die("Query failed: " . mysqli_error($connection));
          }

          // Add their details to the DB
          $query = "INSERT INTO users (username, email, password, role) ";
          $query .="VALUES('{$username}', '{$email}', '{$password}', 'subscriber');";
          $result = mysqli_query($connection, $query);

          $msgSuccess = "Thank you for registering.";
        }
        else
        {
          $msgFailure = "Fields must not be empty.";
        }
      }

    ?>

    <!-- Page Content -->
    <div class="container">

<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <?php

                          if (!empty($msgSuccess))
                          {
                            echo "<h3 class=\"text-success\">" . $msgSuccess . "</h6>";
                          }
                          else if (!empty($msgFailure))
                          {
                            echo "<h3 class=\"text-danger\">" . $msgFailure . "</h6>";
                          }

                        ?>
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                        </div>

                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>

                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
