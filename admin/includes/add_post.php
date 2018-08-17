<?php

  if (isset($_POST["create"]))
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

    $query = "INSERT INTO posts(postCatid, postTitle, postAuthor, postDate, postImage, postContent, postTags, postStatus) ";

    $query .= "VALUES({$postCatid}, '{$postTitle}', '{$postAuthor}', now(), '{$postImage}', '{$postContent}', '{$postTags}', '{$postStatus}');";

    $result = mysqli_query($connection, $query);
    queryCheck($result);

    // Get last id created to redirect to article
    $pid = mysqli_insert_id($connection);
  }

?>

<form class="" action="" method="post" enctype="multipart/form-data">
  <?php
    // If post is published, go to post - else, go back to all posts
    if (isset($_POST["create"]))
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
    <input class="form-control" type="text" name="title">
  </div>
  <div class="form-group">
    <label for="catid">Post Category</label>
    <select class="" name="catid">
      <?php
        $query = "SELECT * FROM categories;";
        $result = mysqli_query($connection, $query);
        queryCheck($result);

        while ($row = mysqli_fetch_assoc($result))
        {
          $catid = $row["catid"];
          $catTitle = $row["catTitle"];

          $html = "<option value=\"$catid\">{$catTitle}</option>";
          echo $html;
        }
      ?>
    </select>
  </div>
  <div class="form-group">
    <label for="author">Post Author</label>
    <input class="form-control" type="text" name="author">
  </div>
  <div class="form-group">
    <label for="status">Post Status</label>
    <select class="form-control" name="status">
      <option value="published">Published</option>
      <option value="draft" selected>Draft</option>
    </select>
  </div>
  <div class="form-group">
    <label for="image">Post Image</label>
    <input class="form-control" type="file" name="image">
  </div>
  <div class="form-group">
    <label for="tags">Post Tags</label>
    <input class="form-control" type="text" name="tags">
  </div>
  <div class="form-group">
    <label for="content">Post Content</label>
    <textarea id="body" class="form-control" name="content" rows="10" cols="50"></textarea>
  </div>
  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="create" value="Publish">
  </div>
</form>
