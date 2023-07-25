<?php include "admin_include/header.php" ?>

<body>

  <div id="wrapper">

    <?php include "admin_include/nav.php" ?>

    <div id="page-wrapper">

      <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
          <div class="col-lg-12">
            <h1 class="page-header">
              Posts Section
            </h1>
            <?php
            if (isset($_GET['source'])) {
              $source = $_GET['source'];
            } else {
              $source = '';
            }
            switch ($source) {
              case 'add_post':
                include "admin_include/add_posts.php";
                break;
              case 'update':
                include "admin_include/edit_posts.php";
                break;
              case 'delete':
                echo "wait";
                break;
              default:
                include "admin_include/view_all_posts.php";
                break;
            }
            ?>
          </div>
        </div>
        <!-- /.row -->
        <?php include "admin_include/footer.php"; ?>

      </div>
      <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

  </div>
  <!-- /#wrapper -->


</body>

</php>