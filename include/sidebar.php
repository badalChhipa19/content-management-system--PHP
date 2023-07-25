<!-- Blog Sidebar Widgets Column -->
<div class="col-md-4">
  <!-- Blog Search Well -->
  <div class="well">
    <h4>Blog Search</h4>
    <form action="search.php" method="post">
      <div class="input-group">
        <input name="search" type="text" class="form-control" />
        <span class="input-group-btn">
          <button class="btn btn-default" type="submit" name="submit">
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </span>
      </div>
    </form>
  </div>
  <!-- /.input-group -->



  <div class="well">
    <?php if (isLoggedIn()) : ?>

      <h4>Logged in as <?php echo $_SESSION['f_name'] . " " . $_SESSION['l_name']; ?></h4>
      <a href="admin/admin_include/logout.php" class="btn btn-primary">logout</a>

    <?php else : ?>

      <h4>Login</h4>
      <form action="include/login.php" method="post">
        <div class="form-group">
          <input placeholder="Enter username" name="username" type="text" class="form-control" />
        </div>
        <div class="input-group">
          <input placeholder="Enter password" name="password" type="password" class="form-control" />
          <span class="input-group-btn">
            <button class="btn btn-primary" name="login" type="submit">Submit</button>
          </span>
        </div>
        <div class="form-group">
          <a href="forgot.php?source=<?php echo uniqid(true) ?>">Forget password</a>
        </div>
      </form>
    <?php endif; ?>
  </div>

  <!-- Blog Categories Well -->
  <div class="well">
    <h4>Blog Categories</h4>
    <div class="row">
      <div class="col-lg-12">
        <ul class="list-unstyled">

          <?php
          $query_for_side_cat  =  "SELECT * FROM cat LIMIT 4";
          $result_for_side_cat = mysqli_query($connect, $query_for_side_cat);

          while ($row = mysqli_fetch_assoc($result_for_side_cat)) {
            $cat_title = $row['cat_title'];
            $cat_id    = $row['cat_id'];
            echo "<li><a href='category.php?source=$cat_id'>{$cat_title}</a></li>";
          }
          ?>
        </ul>
      </div>
      <!-- /.col-lg-6 -->
    </div>
    <!-- /.row -->
  </div>
  <?php include "widget.php" ?>
</div>