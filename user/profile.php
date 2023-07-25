<?php include "user_include/header.php" ?>

<body>

  <div id="wrapper">

    <?php include "user_include/nav.php" ?>

    <div id="page-wrapper">

      <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
          <div class="col-lg-12">
            <h1 class="page-header">
              Edit Profile
              <small><?php echo $_SESSION['f_name']; ?>
              </small>
            </h1>
          </div>
        </div>
        <!-- /.row -->
        <!-- ******************************************************************* -->
        <!-- UPDATING DETAILS -->

        <?php
        $id = $_SESSION['id'];

        if (isset($_POST['submit'])) {
          $f_name        = escape($_POST['f_name']);
          $l_name        = escape($_POST['l_name']);
          $username      = escape($_POST['username']);
          $password      = escape($_POST['password']);
          $mail          = escape($_POST['mail']);

          $query_for_update_user  = "UPDATE user_table SET 
                              username = '$username',
                              user_f_name   = '$f_name',
                              user_l_name   = '$l_name',
                              user_mail     = '$mail'
                          WHERE user_id = $id";

          $result_for_update_user = mysqli_query($connect, $query_for_update_user);
          errorFun($result_for_update_user);

          echo "<p class='bg-success'>Info Updated: " . " " . "<a href='user_index.php'>Deshboard</a></p>";
        }
        ?>

        <!-- SELECTING DETAILS -->
        <?php
        if (isset($_SESSION['username'])) {

          $query_for_check  = "SELECT * FROM user_table WHERE user_id = '$id'";
          $result_for_check = mysqli_query($connect, $query_for_check);
          errorFun($result_for_check);

          while ($row = mysqli_fetch_assoc($result_for_check)) {
            $f_name   = $row['user_f_name'];
            $l_name   = $row['user_l_name'];
            $mail     = $row['user_mail'];
            $role     = $row['user_role'];
            $username = $row['username'];
            $password = $row['user_password'];
            $image    = $row['user_image'];
        ?>


            <form action="" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label for="f_name">First Name</label>
                <input type="text" class="form-control" value="<?php echo $f_name; ?>" name="f_name">
              </div>

              <div class="form-group">
                <label for="l_name">Last Name</label>
                <input type="text" class="form-control" value="<?php echo $l_name; ?>" name="l_name">
              </div>

              <div class="form-group">
                <label for="mail">E-mail</label>
                <input type="text" class="form-control" value="<?php echo $mail; ?>" name="mail">
              </div>

              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" value="<?php echo $username; ?>" name="username">
              </div>

              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" value="<?php echo  $password; ?>">
              </div>

              <div class="form-group">
                <input type="submit" value="Update User" name='submit' class="btn btn-primary">
              </div>
            </form>

        <?php
          }
        }
        ?>
      </div>
      <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

  </div>
  <!-- /#wrapper -->

  <?php include "user_include/footer.php"; ?>

</body>

</php>