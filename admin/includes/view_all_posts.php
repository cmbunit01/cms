<?php

  // Set bulk options to apply to posts
  if (isset($_POST["checkBoxArray"]))
  {
    foreach (($_POST["checkBoxArray"]) as $checkBoxValue)
    {
      $bulkOptions = $_POST["bulkOptions"];

      switch ($bulkOptions)
      {
        case "published";
          $query = "UPDATE posts SET postStatus = '{$bulkOptions}' WHERE postid = {$checkBoxValue};";
          $result = mysqli_query($connection, $query);
          queryCheck($result);
          break;
        case "draft";
          $query = "UPDATE posts SET postStatus = '{$bulkOptions}' WHERE postid = {$checkBoxValue};";
          $result = mysqli_query($connection, $query);
          queryCheck($result);
          break;
        case "delete";
          $query = "DELETE FROM posts WHERE postid = {$checkBoxValue};";
          $result = mysqli_query($connection, $query);
          queryCheck($result);
          break;
        case "clone";
          $query = "SELECT * FROM posts WHERE postid = {$checkBoxValue};";
          $result = mysqli_query($connection, $query);
          while ($row = mysqli_fetch_assoc($result))
          {
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
          $query = "INSERT INTO posts(postCatid, postTitle, postAuthor, postDate, postImage, postContent, postTags, postStatus) ";
          $query .= "VALUES({$postCatid}, '{$postTitle}', '{$postAuthor}', now(), '{$postImage}', '{$postContent}', '{$postTags}', '{$postStatus}');";
          $result = mysqli_query($connection, $query);
          queryCheck($result);
          break;
      }
    }
  }

?>
<form class="" action="" method="post">
  <table class="table table-bordered table-hover">
    <div id="bulkOptionsContainer" class="col-xs-4" style="padding: 0; padding-bottom: 18px;">
      <select class="form-control" name="bulkOptions">
        <option value="">Select Options</option>
        <option value="published">Publish</option>
        <option value="draft">Draft</option>
        <option value="delete">Delete</option>
        <option value="clone">Clone</option>
      </select>
    </div>
    <div class="col-xs-4">
      <input class="btn btn-success" type="submit" name="submit" value="Apply">
      <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
    </div>
    <thead>
      <tr>
        <th><input id="selectAllBoxes" type="checkbox"></th>
        <th>id</th>
        <th>View Post</th>
        <th>Category ID</th>
        <th>Title</th>
        <th>Author</th>
        <th>Date</th>
        <th>Image</th>
        <th>Content</th>
        <th>Tags</th>
        <th>Comments</th>
        <th>Status</th>
        <th>Views</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
      <?php

        $query = "SELECT * FROM posts ORDER BY postid DESC;";

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
          // Shorten the string for output to table
          if ((strlen($postContent)) > 100)
          {
            $postContent = substr($postContent, 0, 100) . "...";
          }
          $postTags = $row["postTags"];
          $postCommentCount = $row["postCommentCount"];
          $postStatus = $row["postStatus"];
          $postViews = $row["postViews"];

          $postHTML = "<tr>\n";
          $postHTML .= "<th><input class=\"checkBoxes\" type=\"checkbox\" name=\"checkBoxArray[]\" value=\"{$postid}\"></th>\n";
          $postHTML .= "<td>" . $postid . "</td>\n";

          $postHTML .="<td><a href=\"../post.php?pid={$postid}\">View Post</a></td>\n";

          $query = "SELECT `catTitle` FROM categories WHERE catid = $postCatid;";
          $category = mysqli_fetch_assoc(mysqli_query($connection, $query));
          $postCatTitle = $category["catTitle"];

          $postHTML .= "<td>" . $postCatTitle . "</td>\n";
          $postHTML .= "<td>" . $postTitle . "</td>\n";
          $postHTML .= "<td>" . $postAuthor . "</td>\n";
          $postHTML .= "<td>" . $postDate . "</td>\n";
          $postHTML .= "<td>" . "<img class=\"img-responsive\" src=\"../images/" . $postImage . "\" alt=\"image\">" . "</td>\n";
          $postHTML .= "<td>" . $postContent . "</td>\n";
          $postHTML .= "<td>" . $postTags . "</td>\n";
          $postHTML .= "<td>" . $postCommentCount . "</td>\n";
          $postHTML .= "<td>" . $postStatus . "</td>\n";
          $postHTML .="<td><a onclick=\"javascript: return confirm('Are you sure you want to reset views?');\" href=\"posts.php?reset={$postid}\">" . $postViews . "</a></td>\n";
          $postHTML .= "<td><a href=\"posts.php?source=edit_post&pid={$postid}\">Edit</a></td>\n";
          $postHTML .= "<td><a onclick=\"javascript: return confirm('Are you sure you want to delete?');\" href=\"posts.php?delete={$postid}\">Delete</a></td>\n";
          $postHTML .= "</tr>\n";

          echo $postHTML;
        }

      ?>
    </tbody>
  </table>
</form>

<?php

  if (isset($_GET["delete"]))
  {
    $postid = $_GET["delete"];

    $query = "DELETE FROM posts WHERE postid = {$postid};";
    $delete = mysqli_query($connection, $query);
    queryCheck($delete);
    header("Location: posts.php");
  }

  if (isset($_GET["reset"]))
  {
    $postid = $_GET["reset"];

    $query = "UPDATE posts SET postViews = 0 WHERE postid = " . mysqli_real_escape_string($connection, $postid) . ";";
    $reset = mysqli_query($connection, $query);
    queryCheck($reset);
    header("Location: posts.php");
  }

?>
