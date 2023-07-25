<?php include "include/header.php" ?>


<body>
  <?php include "include/nav.php" ?>
  <!-- Page Content -->
  <div class="container">
    <div class="row">
      <!-- Blog Entries Column -->
      <div class="col-md-8">
        <h1 class="page-header">
          Welcome to INDIA
          <small>Center of Beauty </small>
        </h1>

        <?php
        $post_count_on_page = 5;
        if (isset($_GET['page'])) {
          $page = $_GET['page'];
        } else {
          $page = "";
        }

        if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
          if ($page == "" || $page == 1) {
            $page_1 = 0;
          } else {
            $page_1 = ($page * $post_count_on_page) - $post_count_on_page;
          }

          $query_for_count  = "SELECT * FROM posts";
          $result_for_count = mysqli_query($connect, $query_for_count);
          errorFun($result_for_count);

          $count = mysqli_num_rows($result_for_count);
          if ($count < 1) {
            echo  "<h1 class = 'text-center'>No Posts</h1>";
          }
          $page_0 = ceil($count / $post_count_on_page);
          $query = "SELECT * FROM posts ORDER BY post_id DESC LIMIT $page_1 , $post_count_on_page ";
          $result = mysqli_query($connect, $query);
          errorFun($result);
        } else {

          if ($page == "" || $page == 1) {
            $page_1 = 0;
          } else {
            $page_1 = ($page * $post_count_on_page) - $post_count_on_page;
          }
          $query_for_count  = "SELECT * FROM posts  WHERE post_status = 'published' ";
          $result_for_count = mysqli_query($connect, $query_for_count);
          errorFun($result_for_count);

          $count = mysqli_num_rows($result_for_count);
          if ($count < 1) {
            echo  "<h1 class = 'text-center'>No Posts</h1>";
          }
          $page_0 = ceil($count / $post_count_on_page);
          $query = "SELECT * FROM posts WHERE post_status = 'published' ORDER BY post_id DESC LIMIT $page_1 , $post_count_on_page ";
          $result = mysqli_query($connect, $query);
          errorFun($result);
        }
        while ($row = mysqli_fetch_assoc($result)) {
          $post_id       = $row['post_id'];
          $post_title    = $row['post_title'];
          $post_author   = $row['post_author'];
          $post_date     = $row['post_date'];
          $post_image    = $row['post_image'];
          $post_content  = substr($row['post_content'], 0, 100);
          $post_status   = $row['post_status'];
        ?>

          <h2>
            <a href='post.php?source=<?php echo $post_id; ?>'><?php echo $post_title; ?></a>
          </h2>
          <p class='lead'>by <a href='author_post.php?source=<?php echo $post_author; ?>'><?php echo $post_author; ?></a></p>
          <p>
            <span class='glyphicon glyphicon-time'></span> Posted on <?php echo $post_date; ?>
          </p>
          <hr />
          <a href='post.php?source=<?php echo $post_id; ?>'><img class='img-responsive' src='<?php echo $post_image; ?>' alt='any_image' /></a>
          <hr />
          <p><?php echo $post_content; ?></p>
          <a class='btn btn-primary' href='post.php?source=<?php echo $post_id; ?>'>
            Read More <span class='glyphicon glyphicon-chevron-right'></span>
          </a>

        <?php  }
        ?>

        <hr />
      </div>
      <?php include "include/sidebar.php" ?>
    </div>

    <hr />
  </div>
  <ul class="pager">
    <?php

    for ($i = 1; $i <= $page_0; $i++) {
      if ($i == $page) {
        echo "<li><a class='active_link' href='index.php?page=$i'>$i</a></li>";
      } else {
        echo "<li><a href='index.php?page=$i'>$i</a></li>";
      }
    }
    ?>
  </ul>

  <?php include "include/footr.php" ?>

</body>


</html>