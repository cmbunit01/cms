<?php

  function queryCheck($result)
  {
    global $connection;
    if (!$result)
    {
      die("Query failed: " . mysqli_error($connection));
    }
  }

  function insertCategory()
  {
    global $connection;
    if (isset($_POST["submit"]))
    {
      if (isset($_POST["cat_title"]) && !empty($_POST["cat_title"]))
      {
        $catTitle = $_POST["cat_title"];

        if ($catTitle)
        {
          $query = "INSERT INTO categories(catTitle) ";
          $query .= "VALUE ('{$catTitle}');";

          $create = mysqli_query($connection, $query);

          if(!$create)
          {
            die("Query failed: " . mysqli_error($connection));
          }
        }
      }
      else
      {
        echo "This field must not be empty.";
      }
    }
  }

  function findAllCategories()
  {
    global $connection;
    // Find all categories
    $query = "SELECT * FROM categories;";
    $select_cats = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_cats))
    {
      $id = $row["catid"];
      $title = $row["catTitle"];

      echo "<tr>\n";
      echo "<td>{$id}</td>\n";
      echo "<td>{$title}</td>\n";
      echo "<td><a href=\"categories.php?delete=" . $row["catid"] . "\">Delete</a></td>\n";
      echo "<td><a href=\"categories.php?edit=" . $row["catid"] . "\">Edit</a></td>\n";
      echo "</tr>\n";
    }

  }

  function deleteCategory()
  {
    global $connection;
    // Delete records
    if (isset($_GET["delete"]) && !empty($_GET["delete"]))
    {
      $catid = $_GET["delete"];
      $query = "DELETE FROM categories WHERE catid = $catid;";

      $delete = mysqli_query($connection, $query);

      // Refresh page once complete
      header("Location: categories.php");

      if (!$delete)
      {
        die("Delete failed: " . mysqli_error($connection));
      }

    }
  }

?>
