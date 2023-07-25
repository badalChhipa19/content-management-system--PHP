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
              Welcome to Users Section
              <small><?php echo $_SESSION['f_name']; ?></small>
            </h1>
            <?php
            if (isset($_GET['source'])) {
              $source = $_GET['source'];
            } else {
              $source = '';
            }
            switch ($source) {
              case 'add_user':
                include "admin_include/add_users.php";
                break;
              case 'edit':
                include "admin_include/edit_user.php";
                break;
              case 'delete':
                echo "wait";
                break;
              default:
                include "admin_include/view_all_users.php";
                break;
            }
            ?>
          </div>
        </div>
        <!-- /.row -->

      </div>
      <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

  </div>
  <!-- /#wrapper -->

  <?php include "admin_include/footer.php"; ?>

</body>

</php>