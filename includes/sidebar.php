<!-- Blog Sidebar Widgets Column -->
<div class="col-md-4">

    <!-- Blog Search Well -->

    <div class="well">
        <h4>Blog Search</h4>
        <form class="" action="search.php" method="post">
          <div class="input-group">
              <input name="search" type="text" class="form-control">
              <span class="input-group-btn">
                  <button name="submit" class="btn btn-default" type="submit">
                      <span class="glyphicon glyphicon-search"></span>
              </button>
              </span>
          </div>
        </form>
        <!-- /.input-group -->
    </div>

    <!-- Login -->
    <div class="well">
        <h4>Login</h4>
        <form class="" action="includes/login.php" method="post">
          <div class="form-group">
              <input name="username" type="text" class="form-control" placeholder="Username">
          </div>
          <div class="input-group">
              <input name="password" type="password" class="form-control" placeholder="Password">
              <span class="input-group-btn">
                <button type="submit" name="login" class="btn btn-primary">Login</button>
              </span>
          </div>

        </form>
        <!-- /.input-group -->
    </div>

    <!-- Blog Categories Well -->
    <?php
      $query = "SELECT * FROM categories;";
      $select_cats = mysqli_query($connection, $query);
    ?>
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php
                    while ($row = mysqli_fetch_assoc($select_cats))
                    {
                      $id = $row["catid"];
                      $title = $row["catTitle"];

                      echo "<li><a href=\"category.php?category=$id\">{$title}</a></li>\n\t\t\t\t";
                    }
                    ?>
                </ul>
            </div>

            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <?php include "widget.php"; ?>

</div>
