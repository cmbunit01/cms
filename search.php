<?php include "includes/header.php"; ?>

  <?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

              <?php
                // Check if search submitted
                if (isset($_POST["submit"]))
                {
                  if (isset($_POST["search"]) && strlen($_POST["search"]) > 0)
                  {
                    $search = $_POST["search"];
                  }

                  // If search value is set, look for it
                  if ($search)
                  {
                    $query = "SELECT * FROM posts WHERE postTags LIKE \"%$search%\";";
                    $result = mysqli_query($connection, $query);

                    if(!$result)
                    {
                      die("Query failed: " . mysqli_error($connection));
                    }
                    else
                    {
                      $count = mysqli_num_rows($result);

                      if ($count == 0)
                      {
                        echo "<b>No result.</b>";
                      }
                      else
                      {

                        while ($row = mysqli_fetch_assoc($result))
                        {
                          $postTitle =      $row["postTitle"];
                          $postAuthor =     $row["postAuthor"];
                          $postDate =       $row["postDate"];
                          $postImage =      $row["postImage"];
                          $postContent =    $row["postContent"];

                        ?>

                        <h1 class="page-header">
                            Page Heading
                            <small>Secondary Text</small>
                        </h1>

                        <!-- First Blog Post -->
                        <h2>
                            <a href="#"><?php echo $postTitle; ?></a>
                        </h2>
                        <p class="lead">
                            by <a href="index.php"><?php echo $postAuthor; ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span><?php echo $postDate; ?></p>
                        <hr>
                        <img class="img-responsive" src="images/<?php echo $postImage; ?>" alt="">
                        <hr>
                        <p><?php echo $postContent; ?></p>
                        <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                        <hr>

                        <?php
                        }
                      }
                    }

                  }
                }
              ?>

                <!-- Pager -->
                <ul class="pager">
                    <li class="previous">
                        <a href="#">&larr; Older</a>
                    </li>
                    <li class="next">
                        <a href="#">Newer &rarr;</a>
                    </li>
                </ul>

            </div>

            <?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>
<?php include "includes/footer.php"; ?>
