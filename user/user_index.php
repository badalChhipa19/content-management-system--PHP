<?php include "user_include/header.php" ?>


<body>

  <div id="wrapper">

    <?php include "user_include/nav.php"
    ?>
    <?php
    $id = $_SESSION['id'];
    ?>
    <div id="page-wrapper">

      <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
          <div class="col-lg-12">
            <h1 class="page-header">
              Welcome to Dashboard
              <small><?php echo $_SESSION['f_name']; ?>
              </small>
            </h1>
          </div>
        </div>
        <!-- /.row -->

        <!-- /.row -->


        <div class="row">
          <div class="col-lg-4 col-md-6">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-file-text fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                    <div class='huge'><?php echo $post_counts = countMyNum('posts', 'post_user_id', $id); ?></div>
                    <div>Posts</div>
                  </div>
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
          <div class="col-lg-4 col-md-6">
            <div class="panel panel-green">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-comments fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                    <div class='huge'><?php echo $comments_counts = countMyComments(); ?></div>
                    <div>Comments</div>
                  </div>
                </div>
              </div>
              <a href="my_comments.php">
                <div class="panel-footer">
                  <span class="pull-left">View Details</span>
                  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                  <div class="clearfix"></div>
                </div>
              </a>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="panel panel-red">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-list fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                    <div class='huge'><?php echo $category_counts = countMyNum('cat', 'cat_user_id', $id); ?></div>
                    <div>Categories</div>
                  </div>
                </div>
              </div>
              <a href="my_category.php">
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

        <div class="row">

          <?php
          $post_published_counts = checkMyStatus('posts', 'post_status', 'published', 'post_user_id', $id);

          $post_draft_counts = checkMyStatus('posts', 'post_status', 'draft', 'post_user_id', $id);

          $comments_Unapproved_counts = checkMyCommentsStatus();

          ?>

          <script type="text/javascript">
            google.charts.load('current', {
              'packages': ['bar']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
              var data = google.visualization.arrayToDataTable([

                <?php
                $element_text  = ['All Posts', 'Published Posts', 'Draft Posts', 'Comments', 'Panding Comments', 'Categories'];
                $element_count = [$post_counts, $post_published_counts, $post_draft_counts, $comments_counts, $comments_Unapproved_counts, $category_counts];
                echo "['Data', 'Count'],";
                for ($i = 0; $i < 6; $i++) {
                  echo "['$element_text[$i]'" . "," . "$element_count[$i]],";
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
          <div id="columnchart_material" style=" height: 500px;"></div>
        </div>
      </div>
      <!-- /.container-fluid -->

      <?php include "user_include/footer.php"; ?>
    </div>
    <!-- /#page-wrapper -->

  </div>
  <!-- /#wrapper -->


</body>

</php>