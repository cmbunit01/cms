<?php

  if (isset($_GET["pid"]))
  {
    $pid = $_GET["pid"];
  }

  $query = "SELECT * FROM posts WHERE postid = $pid;";

  $result = mysqli_query($connection, $query);

  while ($row = mysqli_fetch_assoc($result))
  {
    $postid = $row["postid"];
    $postCatid = $row["postCatid"];
    $postTitle = $row["postTitle"];
    $postAuthor = $row["postAuthor"];
    $postDate = $row["postDate"];
    $postImage = $row["postImage"];
    $postContent = $row["postContent"];
    $postTags = $row["postTags"];
    $postCommentCount = $row["postCommentCount"];
    $postStatus = $row["postStatus"];
  }

  if (isset($_POST["update"]))
  {
    $postCatid = $_POST["catid"];
    $postTitle = mysqli_real_escape_string($connection, $_POST["title"]);
    $postAuthor = mysqli_real_escape_string($connection, $_POST["author"]);

    $postDate = date("d-m-y");

    $postImage = $_FILES["image"]["name"];
    $postImage_temp = $_FILES["image"]["tmp_name"];

    $postContent = mysqli_real_escape_string($connection, $_POST["content"]);
    $postTags = mysqli_real_escape_string($connection, $_POST["tags"]);
    // $postCommentCount = 4;
    $postStatus = $_POST["status"];

    move_uploaded_file($postImage_temp, "../images/$postImage");

    if (empty($postImage))
    {
      $query = "SELECT `postImage` FROM posts WHERE postid = {$postid};";
      $image = mysqli_fetch_assoc(mysqli_query($connection, $query));

      $postImage = $image["postImage"];
    }

    $query = "UPDATE posts SET ";
    $query .="postCatid = {$postCatid}, ";
    $query .="postTitle = '{$postTitle}', ";
    $query .="postAuthor = '{$postAuthor}', ";
    $query .="postDate = now(), ";
    $query .="postImage = '{$postImage}', ";
    $query .="postContent = '{$postContent}', ";
    $query .="postTags = '{$postTags}', ";
    $query .="postCommentCount = '{$postCommentCount}', ";
    $query .="postStatus = '{$postStatus}' ";

    $query .= "WHERE postid = {$postid};";

    $result = mysqli_query($connection, $query);
    queryCheck($result);
  }

?>

<form class="" action="" method="post" enctype="multipart/form-data">
  <?php
    // If post is published, go to post - else, go back to all posts
    if (isset($_POST["update"]))
    {
      if ($postStatus == "published")
      {
  ?>
  <div class="form-group">
    <p class="bg-success">
      <span class="text-success">Post Updated: </span> - <a href="../post.php?pid=<?php echo $pid; ?>">View Post</a>
    </p>
  </div>
  <?php
      }
      else
      {
  ?>
    <div class="form-group">
      <p class="bg-success">
        <span class="text-success">Post Updated: </span> - <a href="posts.php">View All Posts</a>
      </p>
    </div>
  <?php
      }
    }
  ?>
  <div class="form-group">
    <label for="title">Post Title</label>
    <input class="form-control" type="text" name="title" value="<?php echo $postTitle; ?>">
  </div>
  <div class="form-group">
    <label for="catid">Post Category</label>
    <select class="form-control" name="catid">
      <?php
        $query = "SELECT * FROM categories;";
        $result = mysqli_query($connection, $query);
        queryCheck($result);

        while ($row = mysqli_fetch_assoc($result))
        {
          $catid = $row["catid"];
          $catTitle = $row["catTitle"];

          if ($catid == $postCatid)
          {
            $html = "<option value=\"$catid\" selected>{$catTitle}</option>";
          }
          else
          {
            $html = "<option value=\"$catid\">{$catTitle}</option>";
          }
          echo $html;
        }
      ?>
    </select>
  </div>
  <div class="form-group">
    <label for="author">Post Author</label>
    <input class="form-control" type="text" name="author" value="<?php echo $postAuthor; ?>">
  </div>
  <div class="form-group">
    <label for="status">Post Status</label>
    <select class="form-control" name="status">
      <?php
        switch ($postStatus)
        {
          case "published";
      ?>
        <option value="published" selected>Published</option>
        <option value="draft">Draft</option>
      <?php
          break;

          case "draft";
      ?>
        <option value="published">Published</option>
        <option value="draft" selected>Draft</option>
      <?php
          break;

          default;

      ?>
        <option value="published">Published</option>
        <option value="draft" selected>Draft</option>
      <?php
          break;
        }
      ?>
    </select>
  </div>
  <div class="form-group">
    <img src="../images/<?php echo $postImage; ?>" alt="" width="150">
    <input class="form-control" type="file" name="image" value="<?php echo $postImage; ?>">
  </div>
  <div class="form-group">
    <label for="tags">Post Tags</label>
    <input class="form-control" type="text" name="tags" value="<?php echo $postTags; ?>">
  </div>
  <div class="form-group">
    <label for="content">Post Content</label>
    <textarea id="body" class="form-control" name="content" rows="10" cols="30"><?php echo $postContent; ?></textarea>
  </div>
  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="update" value="Save">
  </div>
</form>
