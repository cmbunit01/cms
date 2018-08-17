<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>id</th>
      <th>In response to</th>
      <th>Author</th>
      <th>Email</th>
      <th>Content</th>
      <th>Status</th>
      <th>Date</th>
      <th>Approve</th>
      <th>Unapprove</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php

      $query = "SELECT * FROM comments;";

      $result = mysqli_query($connection, $query);
      //or die("Query failed: " . mysqli_error($connection))

      while ($row = mysqli_fetch_assoc($result))
      {
        $commentid = $row["commentid"];
        $commentPostid = $row["commentPostid"];
        $commentAuthor = $row["commentAuthor"];
        $commentEmail = $row["commentEmail"];
        $commentContent = $row["commentContent"];
        $commentStatus = $row["commentStatus"];
        $commentDate = $row["commentDate"];

        $html = "<tr>\n";
        $html .= "<td>" . $commentid . "</td>\n";

        $query = "SELECT `postTitle` FROM posts WHERE postid = {$commentPostid};";
        $return = mysqli_fetch_assoc(mysqli_query($connection, $query));
        $postTitle = $return["postTitle"];

        $html .= "<td>" . "<a href=\"../post.php?pid={$commentPostid}\">" . $postTitle . "</a>" . "</td>\n";
        $html .= "<td>" . $commentAuthor . "</td>\n";
        $html .= "<td>" . $commentEmail . "</td>\n";
        $html .= "<td>" . $commentContent . "</td>\n";
        $html .= "<td>" . $commentStatus . "</td>\n";
        $html .= "<td>" . $commentDate . "</td>\n";
        $html .= "<td><a href=\"comments.php?approve={$commentid}\">Approve</a></td>\n";
        $html .= "<td><a href=\"comments.php?unapprove={$commentid}\">Unapprove</a></td>\n";
        $html .= "<td><a href=\"comments.php?delete={$commentid}\">Delete</a></td>\n";
        $html .= "</tr>\n";

        echo $html;
      }

    ?>
  </tbody>
</table>

<?php

  if (isset($_GET["approve"]))
  {
    $commentid = $_GET["approve"];

    $query = "UPDATE comments SET commentStatus = 'approved' WHERE commentid = {$commentid};";
    $approve = mysqli_query($connection, $query);
    queryCheck($approve);
    header("Location: comments.php");
  }

  if (isset($_GET["unapprove"]))
  {
    $commentid = $_GET["unapprove"];

    $query = "UPDATE comments SET commentStatus = 'unapproved' WHERE commentid = {$commentid};";
    $unapprove = mysqli_query($connection, $query);
    queryCheck($unapprove);
    header("Location: comments.php");
  }

  if (isset($_GET["delete"]))
  {
    $commentid = $_GET["delete"];

    // Get the post id
    $query = "SELECT commentPostid FROM comments WHERE commentid = {$commentid};";
    $result = mysqli_fetch_assoc(mysqli_query($connection, $query)) or die("Query failed: " . mysqli_error($connection));
    $postid = $result["commentPostid"];

    // Update the post to reflect new comment count before deleting the comment itself
    $query = "UPDATE posts SET postCommentCount = postCommentCount - 1 ";
    $query .="WHERE postid = {$postid};";
    $result = mysqli_query($connection, $query) or die("Query failed: " . mysqli_error($connection));

    $query = "DELETE FROM comments WHERE commentid = {$commentid};";
    $delete = mysqli_query($connection, $query);
    queryCheck($delete);

    header("Location: comments.php");
  }

?>
