<?php include "includes/admin-header.php"; ?>

  <?php

    if (isset($_SESSION["username"]))
    {
      $username = $_SESSION["username"];

      $query = "SELECT * FROM users WHERE username = '{$username}';";
      $result = mysqli_query($connection, $query);

      while ($row = mysqli_fetch_assoc($result))
      {
        $userid = $row["userid"];
        $username = $row["username"];
        $firstname = $row["firstname"];
        $lastname = $row["lastname"];
        $email = $row["email"];
        $userimage = $row["userimage"];
        $role = $row["role"];
        $password = $row["password"];
      }
    }

  ?>

    <div id="wrapper">

      <?php include "includes/admin-navigation.php"; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Admin
                            <small>Author</small>
                        </h1>

                    </div>

                </div>
                <!-- /.row -->

                <?php include "includes/profile-page.php"; ?>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php include "includes/admin-footer.php"; ?>
