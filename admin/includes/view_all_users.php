<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>id</th>
      <th>Username</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Email</th>
      <th>Role</th>
      <th>Promote</th>
      <th>Demote</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php

      $query = "SELECT * FROM users;";

      $result = mysqli_query($connection, $query);
      //or die("Query failed: " . mysqli_error($connection))

      while ($row = mysqli_fetch_assoc($result))
      {
        $userid = $row["userid"];
        $username = $row["username"];
        $firstname = $row["firstname"];
        $lastname = $row["lastname"];
        $email = $row["email"];
        $userimage = $row["userimage"];
        $role = $row["role"];

        $html = "<tr>\n";
        $html .= "<td>" . $userid . "</td>\n";
        $html .= "<td>" . $username . "</td>\n";
        $html .= "<td>" . $firstname . "</td>\n";
        $html .= "<td>" . $lastname . "</td>\n";
        $html .= "<td>" . $email . "</td>\n";
        $html .= "<td>" . $role . "</td>\n";
        $html .= "<td><a href=\"users.php?promote={$userid}\">Promote</a></td>\n";
        $html .= "<td><a href=\"users.php?demote={$userid}\">Demote</a></td>\n";
        $html .= "<td><a href=\"users.php?source=edit&edit_user={$userid}\">Edit</a></td>\n";
        $html .= "<td><a onclick=\"javascript: return confirm('Are you sure you want to delete?');\" href=\"users.php?delete={$userid}\">Delete</a></td>\n";
        $html .= "</tr>\n";

        echo $html;
      }

    ?>
  </tbody>
</table>

<?php

  if (isset($_GET["promote"]))
  {
    $userid = $_GET["promote"];

    $query = "UPDATE users SET role = 'admin' WHERE userid = {$userid};";
    $promote = mysqli_query($connection, $query);
    queryCheck($promote);
    header("Location: users.php");
  }

  if (isset($_GET["demote"]))
  {
    $userid = $_GET["demote"];

    $query = "UPDATE users SET role = 'subscriber' WHERE userid = {$userid};";
    $demote = mysqli_query($connection, $query);
    queryCheck($demote);
    header("Location: users.php");
  }

  if (isset($_GET["delete"]))
  {
    $userid = $_GET["delete"];

    $query = "DELETE FROM users WHERE userid = {$userid};";
    $delete = mysqli_query($connection, $query);
    queryCheck($delete);

    header("Location: users.php");
  }

?>
