<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">HOME </a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <?php
        $query  = "SELECT * FROM cat LIMIT 6";
        $result = mysqli_query($connect, $query);

        while ($row = mysqli_fetch_assoc($result)) {
          $cat_id    = $row["cat_id"];
          $cat_title = $row["cat_title"];

          $category_class     = '';
          $registration_class = '';
          $contect_class      = '';
          $login_class        = '';

          $page_name = basename($_SERVER['PHP_SELF']);
          $reg_page  = 'registration.php';
          $con_page  = 'contect.php';
          $log_page  = 'login.php';

          if (isset($_GET['source']) && $_GET['source'] == $cat_id) {
            $category_class = 'active';
          } else if ($page_name == $reg_page) {
            $registration_class = 'active';
          } else if ($page_name == $con_page) {
            $contect_class = 'active';
          } else if ($page_name == $log_page) {
            $login_class = 'active';
          }

          echo "<li class='$category_class'><a href='category.php?source=$cat_id'>{$cat_title}</a></li>";
        }
        ?>

        <?php if (isLoggedIn() && $_SESSION['role'] == 'admin') : ?>
          <li><a href='admin/admin_index.php'>Control Panel</a></li>
          <li><a href='user/user_index.php'>My Data</a></li>
        <?php elseif (isLoggedIn() && $_SESSION['role'] == 'subscriber') : ?>
          <li><a href='user/user_index.php'>My Data</a></li>
        <?php endif; ?>

        <?php if (!isLoggedIn()) : ?>
          <li class="<?php echo $registration_class; ?>">
            <a href='registration.php'>Registration</a>
          </li>
        <?php endif; ?>

        <?php if (isLoggedIn()) : ?>
          <li class="<?php echo $contect_class; ?>">
            <a href='contact.php'>Contect</a>
          </li>
        <?php endif; ?>

        <?php if (isset($_SESSION['role'])) : ?>
          <li class="<?php echo $login_class; ?>">
            <a href='admin/admin_include/logout.php'>Log-out</a>
          </li>

        <?php else : ?>
          <li class="<?php echo $login_class; ?>">
            <a href='login.php'>Log-in</a>
          </li>
        <?php endif; ?>

        <?php
        // echo 555;
        if (isset($_SESSION['username'])) {
          if (isset($_GET['source'])) {
            $id = $_GET['source'];
            if (isLoggedIn() && $_SESSION['role'] == 'admin') :
              echo "<li><a href='admin/posts.php?source=update&id=$id'>Edit Post</a></li>";
            elseif (isLoggedIn() && $_SESSION['role'] == 'subscriber') :
              echo "<li><a href='user/posts.php?source=update&id=$id'>Edit Post</a></li>";
            endif;
          }
        }
        ?>
      </ul>
    </div>
    <!-- /.navbar-collapse -->
  </div>
  <!-- /.container -->
</nav>