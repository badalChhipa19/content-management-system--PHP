<?php include "include/header.php" ?>


<body>
  <?php include "include/nav.php" ?>
  <!-- Page Content -->
  <div class="container">
    <div class="row">
      <!-- Blog Entries Column -->
      <div class="col-md-8">
        <!-- <h1 class="page-header">
          Page Heading
          <small>Secondary Text</small>
        </h1> -->

        <!-- First Blog Post -->
        <?php
        $the_cat_id = escape($_GET['source']);
        $query      = "SELECT * FROM posts WHERE post_cat_id = $the_cat_id AND post_status ='published'";
        $result     = mysqli_query($connect, $query);
        errorFun($result);

        $count = mysqli_num_rows($result);
        if ($count < 1) {
          echo "<h1 class = 'text-center'>No Posts</h1>";
        }
        while ($row = mysqli_fetch_assoc($result)) {
          $post_id       = $row['post_id'];
          $post_title    = $row['post_title'];
          $post_author   = $row['post_author'];
          $post_date     = $row['post_date'];
          $post_image    = $row['post_image'];
          $post_content  = $row['post_content'];
          echo "<h2>
                    <a href='post.php?source=$post_id'>{$post_title}</a>
                </h2>
                <p class='lead'>by <a href='author_post.php?source=$post_author'>{$post_author}</a></p>
                <p>
                <span class='glyphicon glyphicon-time'></span> Posted on {$post_date}
                </p>
                <hr/>
                <a href='post.php?source=$post_id'><img class='img-responsive' src='{$post_image}' alt='any_image' /></a>
                <hr/>
                <p>{$post_content}</p>
                <a class='btn btn-primary' href='#'
          >Read More <span class='glyphicon glyphicon-chevron-right'></span
        ></a>";
        }

        ?>



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