<?php include "includes/header.php"; ?>

  <?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

              <?php

                // Posts per page
                $perPage = 5;

                if (isset($_GET["page"]))
                {
                  $page = $_GET["page"];
                }
                else
                {
                  $page = "";
                }

                if($page == "" || $page == 1)
                {
                  $page1 = 0;
                }
                else
                {
                  $page1 = ($page * $perPage) - $perPage;
                }

                // Count all posts for pagination
                $query = "SELECT * FROM posts;";
                $result = mysqli_query($connection, $query);
                $count = mysqli_num_rows($result);

                $count = ceil($count / $perPage);
                echo $count;

                $query = "SELECT * FROM posts ORDER BY postid DESC LIMIT $page1, $perPage;";

                $result = mysqli_query($connection, $query);

                // Comparison count to determine if "no content" message needed
                $pubCount = 0;
                $unpubCount = 0;

                while ($row = mysqli_fetch_assoc($result))
                {
                  $postid =         $row["postid"];
                  $postTitle =      $row["postTitle"];
                  $postAuthor =     $row["postAuthor"];
                  $postDate =       $row["postDate"];
                  $postImage =      $row["postImage"];
                  $postContent =    $row["postContent"];
                  // Shorten content for displaying
                  if ((strlen($postContent)) > 100)
                  {
                    $postContent = substr($postContent, 0, 100) . "...";
                  }
                  $postStatus = $row["postStatus"];

                  if ($postStatus == "published")
                  {
                    $pubCount++;
                ?>

                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?pid=<?php echo $postid; ?>"><?php echo $postTitle; ?></a>
                </h2>
                <p class="lead">
                    by <a href="author-posts.php?author=<?php echo $postAuthor; ?>&pid=<?php echo $postid; ?>"><?php echo $postAuthor; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $postDate; ?></p>
                <hr>
                <a href="post.php?pid=<?php echo $postid; ?>">
                  <img class="img-responsive" src="images/<?php echo $postImage; ?>" alt="">
                </a>
                <hr>
                <p><?php echo $postContent; ?></p>
                <a class="btn btn-primary" href="post.php?pid=<?php echo $postid; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

              <?php
                  }
                  else
                  {
                    if ($postStatus != "published")
                    {
                      $unpubCount++;

                      if ($pubCount < 1 && $unpubCount <= 1)
                      {
                        echo "<h1>No content available</h1>";
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
                    <?php

                      for ($i = 1; $i <= $count; $i++)
                      {
                        if ($i == $page || (($i == 1) && ($page1 == 0)))
                        {
                          echo "<li><a class=\"link--active\" href=\"index.php?page={$i}\">{$i}</a></li>";
                        }
                        else
                        {
                          echo "<li><a href=\"index.php?page={$i}\">{$i}</a></li>";
                        }
                      }

                    ?>
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
