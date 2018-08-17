<form class="" action="" method="post">
  <div class="form-group">
    <label for="update-title">Edit Category</label>
    <?php
      if ($catid)
      {
        $query = "SELECT * FROM categories WHERE catid = $catid;";
        $edit = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($edit))
        {
          $catid = $row["catid"];
          $catTitle = $row["catTitle"];

          if(isset($catTitle))
          {
            echo "<input value=\"$catTitle\" type=\"text\" class=\"form-control\" name=\"update-title\">";
          }
          else
          {
            echo "<input value=\"\" type=\"text\" class=\"form-control\" name=\"update-title\">";
          }
        }
      }

      // Update records
      if (isset($_POST["update-category"]))
      {
        if (isset($_POST["update-title"]))
        {
          $catTitle = $_POST["update-title"];

          $query = "UPDATE categories SET catTitle = '{$catTitle}' WHERE catid = {$catid};";

          $update = mysqli_query($connection, $query);

          // Refresh page once complete
          header("Location: categories.php");

          if (!$update)
          {
            die("Update failed: " . mysqli_error($connection));
          }
        }
        else
        {
          die("No name set.");
        }
      }
    ?>
  </div>
  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="update-category" value="Update">
  </div>
</form>
