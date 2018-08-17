<?php include "includes/header.php"; ?>

  <?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

              <?php

                if (isset($_GET["pid"]))
                {
                  $pid = $_GET["pid"];
                  $pauthor = $_GET["author"];
                }

                $query = "SELECT * FROM posts WHERE postAuthor = '{$pauthor}';";

                $result = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($result))
                {
                  $postTitle =      $row["postTitle"];
                  $postAuthor =     $row["postAuthor"];
                  $postDate =       $row["postDate"];
                  $postImage =      $row["postImage"];
                  $postContent =    $row["postContent"];

              ?>

                <h1 class="page-header">
                    All posts by <?php echo $postAuthor; ?>
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
                <hr>

              <?php
                }
              ?>

              <!-- Blog Comments -->

              <?php

                if (isset($_POST["create-comment"]))
                {

                  $pid = $_GET["pid"];
                  $author = $_POST["comment-author"];
                  $email = $_POST["comment-email"];
                  $content = mysqli_real_escape_string($connection, $_POST["comment-content"]);
                  // Make sure the form content isn't empty
                  if (!empty($author) && !empty($email) && !empty($content))
                  {

                    $query = "INSERT INTO comments (commentPostid, commentAuthor, commentEmail, commentContent, commentStatus, commentDate)";
                    $query .="VALUES ({$pid}, '{$author}', '{$email}', '{$content}', 'unapproved', now());";

                    $result = mysqli_query($connection, $query) or die("Query failed: " . mysqli_error($connection));

                    // Increment comment count on post
                    $query = "UPDATE posts SET postCommentCount = postCommentCount + 1 ";
                    $query .="WHERE postid = {$pid};";
                    $result = mysqli_query($connection, $query);

                  }
                  else
                  {
                    echo "<script>alert(\"Fields cannot be empty.\");</script>";

                  }

                }

              ?>

              <!-- Comments Form -->
              <div class="well">
                  <h4>Leave a Comment:</h4>
                  <form role="form" method="post" action="post.php?pid=<?php echo $pid; ?>">
                      <div class="form-group">
                        <label for="comment-author">Author</label>
                          <input type="text" class="form-control" name="comment-author">
                      </div>
                      <div class="form-group">
                        <label for="comment-author">Email</label>
                          <input type="email" class="form-control" name="comment-email">
                      </div>
                      <div class="form-group">
                          <label for="comment-author">Comment</label>
                          <textarea name="comment-content" class="form-control" rows="3"></textarea>
                      </div>
                      <button type="submit" name="create-comment" class="btn btn-primary">Submit</button>
                  </form>
              </div>

              <hr>

              <!-- Posted Comments -->

              <?php

                $query = "SELECT * FROM comments WHERE commentPostid = {$pid} ";
                $query .="AND commentStatus = \"approved\" ";
                $query .="ORDER BY commentid DESC;";

                $result = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($result))
                {
                  $date = $row["commentDate"];
                  $content = $row["commentContent"];
                  $author = $row["commentAuthor"];

              ?>

                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $author; ?>
                            <small><?php echo $date; ?></small>
                        </h4>
                        <?php echo $content; ?>
                    </div>
                </div>

              <?php
                }
              ?>

              <!-- Comment -->
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
