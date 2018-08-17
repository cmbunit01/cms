<?php include "includes/admin-header.php"; ?>

    <div id="wrapper">

      <?php include "includes/admin-navigation.php"; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Admin
                            <small>
                              <?php
                                if (isset($_SESSION["firstname"]))
                                {
                                  echo "Welcome, " . $_SESSION["firstname"];
                                }
                              ?>
                            </small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Blank Page
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->


                         <!-- /.row -->

                 <div class="row">
                     <div class="col-lg-3 col-md-6">
                         <div class="panel panel-primary">
                             <div class="panel-heading">
                                 <div class="row">
                                     <div class="col-xs-3">
                                         <i class="fa fa-file-text fa-5x"></i>
                                     </div>
                                     <div class="col-xs-9 text-right">
                                       <?php

                                        $query = "SELECT * FROM posts;";
                                        $result = mysqli_query($connection, $query);
                                        $postcount = mysqli_num_rows($result);

                                       ?>
                                       <div class='huge'>
                                         <?php

                                            echo $postcount;

                                         ?>
                                       </div>
                                         <div>
                                           <?php

                                            if ($postcount == 1)
                                            {
                                              echo "Post";
                                            }
                                            else
                                            {
                                              echo "Posts";
                                            }
                                           ?>
                                         </div>
                                       </div>
                                 </div>
                             </div>
                             <?php

                               $query = "SELECT * FROM posts WHERE postStatus = \"draft\";";
                               $drafts = mysqli_query($connection, $query);
                               $draftcount = mysqli_num_rows($drafts);

                             ?>
                             <div class="panel-footer">
                               <div class="container-fluid">
                                 <div class="row">Drafts: <?php echo $draftcount; ?></div>
                               </div>
                             </div>
                             <a href="posts.php">
                                 <div class="panel-footer">
                                     <span class="pull-left">View Details</span>
                                     <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                     <div class="clearfix"></div>
                                 </div>
                             </a>
                         </div>
                     </div>
                     <div class="col-lg-3 col-md-6">
                         <div class="panel panel-green">
                             <div class="panel-heading">
                                 <div class="row">
                                     <div class="col-xs-3">
                                         <i class="fa fa-comments fa-5x"></i>
                                     </div>
                                     <div class="col-xs-9 text-right">
                                       <?php

                                        $query = "SELECT * FROM comments;";
                                        $result = mysqli_query($connection, $query);
                                        $commentcount = mysqli_num_rows($result);

                                       ?>
                                      <div class='huge'>
                                        <?php

                                           echo $commentcount;

                                        ?>
                                      </div>
                                       <div>
                                         <?php

                                          if ($commentcount == 1)
                                          {
                                            echo "Comment";
                                          }
                                          else
                                          {
                                            echo "Comments";
                                          }
                                         ?>
                                       </div>
                                     </div>
                                 </div>
                             </div>
                             <?php

                               $query = "SELECT * FROM comments WHERE commentStatus = \"unapproved\";";
                               $unapproved = mysqli_query($connection, $query);
                               $unapprovedcount = mysqli_num_rows($unapproved);

                             ?>
                             <div class="panel-footer">
                               <div class="container-fluid">
                                 <div class="row">Unapproved: <?php echo $unapprovedcount; ?></div>
                               </div>
                             </div>
                             <a href="comments.php">
                                 <div class="panel-footer">
                                     <span class="pull-left">View Details</span>
                                     <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                     <div class="clearfix"></div>
                                 </div>
                             </a>
                         </div>
                     </div>
                     <div class="col-lg-3 col-md-6">
                         <div class="panel panel-yellow">
                             <div class="panel-heading">
                                 <div class="row">
                                     <div class="col-xs-3">
                                         <i class="fa fa-user fa-5x"></i>
                                     </div>
                                     <div class="col-xs-9 text-right">
                                       <?php

                                        $query = "SELECT * FROM users;";
                                        $result = mysqli_query($connection, $query);
                                        $usercount = mysqli_num_rows($result);

                                       ?>
                                     <div class='huge'>
                                       <?php

                                          echo $usercount;

                                       ?>
                                     </div>
                                         <div>
                                           <?php

                                              if ($usercount == 1)
                                              {
                                                echo "User";
                                              }
                                              else
                                              {
                                                echo "Users";
                                              }

                                           ?>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <?php

                               $query = "SELECT * FROM users WHERE role=\"subscriber\";";
                               $subs = mysqli_query($connection, $query);
                               $subcount = mysqli_num_rows($subs);

                             ?>
                             <div class="panel-footer">
                               <div class="container-fluid">
                                 <div class="row">Subscribers: <?php echo $subcount; ?></div>
                               </div>
                             </div>
                             <a href="users.php">
                                 <div class="panel-footer">
                                     <span class="pull-left">View Details</span>
                                     <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                     <div class="clearfix"></div>
                                 </div>
                             </a>
                         </div>
                     </div>
                     <div class="col-lg-3 col-md-6">
                         <div class="panel panel-red">
                             <div class="panel-heading">
                                 <div class="row">
                                     <div class="col-xs-3">
                                         <i class="fa fa-list fa-5x"></i>
                                     </div>
                                     <div class="col-xs-9 text-right">
                                         <?php

                                          $query = "SELECT * FROM categories;";
                                          $result = mysqli_query($connection, $query);
                                          $categorycount = mysqli_num_rows($result);

                                         ?>
                                         <div class='huge'>
                                           <?php

                                              echo $categorycount;

                                           ?>
                                         </div>
                                          <div>
                                            <?php

                                               if ($categorycount == 1)
                                               {
                                                 echo "Category";
                                               }
                                               else
                                               {
                                                 echo "Categories";
                                               }

                                            ?>
                                          </div>
                                     </div>
                                 </div>
                             </div>
                             <?php

                               $query = "SELECT postCatid FROM posts;";
                               $categories = mysqli_query($connection, $query);

                               $resultArray = [];

                               while ($row = mysqli_fetch_assoc($categories))
                               {
                                 $postCatid = $row["postCatid"];

                                 // Use to count how many posts in a category
                                 $query = "SELECT * FROM posts WHERE postCatid = {$postCatid} ";
                                 $query .="AND postStatus = 'published';";
                                 $result = mysqli_query($connection, $query);
                                 $number = mysqli_num_rows($result);

                                 // Get category name
                                 $query = "SELECT catTitle FROM categories WHERE catid = {$postCatid};";
                                 $result = mysqli_query($connection, $query);
                                 $catName = (mysqli_fetch_assoc($result))["catTitle"];

                                 $resultArray += ["{$catName}"=>$number];

                               }

                               // Find the category with the most published articles.
                               $mostCount = max($resultArray);
                               $mostPublished = array_search(max($resultArray), $resultArray);

                             ?>
                             <div class="panel-footer">
                               <div class="container-fluid">
                                 <div class="row">Most Posts: <?php echo $mostPublished . " - " . $mostCount; ?></div>
                               </div>
                             </div>
                             <a href="categories.php">
                                 <div class="panel-footer">
                                     <span class="pull-left">View Details</span>
                                     <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                     <div class="clearfix"></div>
                                 </div>
                             </a>
                         </div>
                     </div>
                 </div>
                         <!-- /.row -->

                <!-- Google Chart -->
                <div class="row">
                  <script type="text/javascript">
                    google.charts.load('current', {'packages':['bar']});
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                      var data = google.visualization.arrayToDataTable([
                        ['Data', 'Count'],

                          <?php

                            $query = "SELECT * FROM posts WHERE postStatus =\"published\";";
                            $pubposts = mysqli_query($connection, $query);
                            $pubpostcount = mysqli_num_rows($pubposts);

                            $elementText = ["Published Posts", "Comments", "Users", "Categories"];
                            $elementCount = [$pubpostcount, $commentcount, $usercount, $categorycount];

                            for ($i = 0; $i < count($elementText); $i++)
                            {
                              if (count($elementText) - $i == 1)
                              {
                                echo "['{$elementText[$i]}', {$elementCount[$i]}]";
                              }
                              else
                              {
                                echo "['{$elementText[$i]}', {$elementCount[$i]}], \n";
                              }
                            }

                          ?>

                      ]);

                      var options = {
                        chart: {
                          title: '',
                          subtitle: '',
                        }
                      };

                      var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                      chart.draw(data, google.charts.Bar.convertOptions(options));
                    }
                  </script>
                  <div id="columnchart_material" style="width: auto; height: 500px;"></div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php include "includes/admin-footer.php"; ?>
