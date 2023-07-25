<?php include "include/db.php" ?>
<?php include "include/header.php" ?>
<?php include "include/nav.php" ?>
<?php
if(isset($_POST['submit'])){
  if(empty($_POST['search'])){
    checkIfUserIsLoggedInAndRedirect('index.php');
  }else{

?>

<body>
 


  <!-- Page Content -->
  <div class="container">
    <div class="row">
      <!-- Blog Entries Column -->
      <div class="col-md-8">
        <h1 class="page-header">
          Page Heading
          <small>Secondary Text</small>
        </h1>

        <!-- First Blog Post -->
        <?php
          if(isset($_POST['submit'])){
            $search = $_POST['search'];
            
            $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%' ";
            $result = mysqli_query($connect, $query);

            $count = mysqli_num_rows($result);
            if($count == 0){
              echo "<H1>No Result</H1>";
            }else{
              
              while($row = mysqli_fetch_assoc($result)){
                $post_title    = $row['post_title'];
                $post_author   = $row['post_author'];
                $post_date     = $row['post_date'];
                $post_image    = $row['post_image'];
                $post_content  = $row['post_content'];
                echo "<h2>
                <a href='#'>{$post_title}</a>
                </h2>
                <p class='lead'>by <a href='index.php'>{$post_author}</a></p>
                <p>
                <span class='glyphicon glyphicon-time'></span> Posted on {$post_date}
                </p>
                <hr/>
                <img class='img-responsive' src='{$post_image}' alt='any_image' />
                <hr/>
                <p>{$post_content}</p>
                <a class='btn btn-primary' href='#'>
                Read More 
                <span class='glyphicon glyphicon-chevron-right'></span></a>";
              }
            }
          }
        
        ?>

        

        <hr />

        <!-- Pager -->
        <ul class="pager">
          <li class="previous">
            <a href="#">&larr; Older</a>
          </li>
          <li class="next">
            <a href="#">Newer &rarr;</a>
          </li>
        </ul>
      </div>

      <?php include "include/sidebar.php" ?>
    </div>
    <!-- /.row -->

    <hr />
  </div>
  <?php include "include/footr.php" ?>
</body>
</html>
<?php
  }
}
?>