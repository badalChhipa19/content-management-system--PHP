<?php include "include/header.php" ?>


<body>
  <?php include "include/nav.php" ?>
  <!-- Page Content -->
  <div class="container">
    <div class="row">
      <!-- Blog Entries Column -->
      <div class="col-md-8">
        <h1 class="page-header">
          Posts By
          <?php
          $author_name = $_GET['source'];
          $query  = "SELECT * FROM posts WHERE post_author LIKE '$author_name'";
          $result = mysqli_query($connect, $query);
          errorFun($result);

          $row1  = mysqli_fetch_array($result);
          $name  = $row1['post_author'];
          echo "<small>$name</small>";
          ?>

        </h1>

        <!-- First Blog Post -->
        <?php
        $query = "SELECT * FROM posts WHERE post_author LIKE '$author_name'";
        $result = mysqli_query($connect, $query);
        errorFun($result);
        while ($row = mysqli_fetch_assoc($result)) {
          $post_id       = $row['post_id'];
          $post_title    = $row['post_title'];
          $post_author   = $row['post_author'];
          $post_date     = $row['post_date'];
          $post_image    = $row['post_image'];
          $post_content  = substr($row['post_content'], 0, 100);
          $post_status   = $row['post_status'];
          if ($post_status === 'published') {
        ?>

            <h2>
              <a href='post.php?source=<?php echo $post_id; ?>'><?php echo $post_title; ?></a>
            </h2>
            <p class='lead'>by <?php echo $post_author; ?> </p>
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
        } ?>



        <hr />

        <!-- Pager -->
      </div>
    </div>
    <!-- /.row -->

    <hr />
  </div>
  <?php include "include/footr.php" ?>
</body>

</html>