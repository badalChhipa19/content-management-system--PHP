<?php
if (!isset($_SESSION['role'])) {
  header('Location: ../../index.php');
}

if (isset($_POST['checkBoxArray'])) {
  foreach ($_POST['checkBoxArray'] as $anyName) {
    $option = $_POST['bulkOptions'];
    switch ($option) {
      case 'published':
        $query_for_update_status  = "UPDATE posts SET post_status = 'published' WHERE post_id = $anyName";
        $result_for_update_status = mysqli_query($connect, $query_for_update_status);
        errorFun($result_for_update_status);
        break;
      case 'draft':
        $query_for_update_status  = "UPDATE posts SET post_status = 'draft' WHERE post_id = $anyName";
        $result_for_update_status = mysqli_query($connect, $query_for_update_status);
        errorFun($result_for_update_status);
        break;
      case 'delete':
        $query_for_update_status  = "DELETE FROM posts WHERE post_id = $anyName";
        $result_for_update_status = mysqli_query($connect, $query_for_update_status);
        errorFun($result_for_update_status);
        break;
      case 'clone':
        $query_for_clone  = "SELECT * FROM posts WHERE post_id = '$anyName'";
        $result_for_clone = mysqli_query($connect, $query_for_clone);
        errorFun($result_for_clone);

        while ($row = mysqli_fetch_assoc($result_for_clone)) {
          $clone_user_id = $row['post_user_id'];
          $clone_id     = escape($row['post_id']);
          $clone_author = escape($row['post_author']);
          $clone_title  = escape($row['post_title']);
          $clone_cat_id = escape($row['post_cat_id']);
          $clone_status = 'draft';
          $clone_img    = escape($row['post_image']);
          $clone_tags   = escape($row['post_tags']);
          $post_content = escape($row['post_content']);
          $clone_date   = escape($row['post_date']);
        }
        $query_for_cloning  = "INSERT INTO posts(post_author, post_title, post_cat_id, post_status, post_image, post_tags, post_date, post_content, post_user_id)
                                VALUES ('$clone_author', '$clone_title', '$clone_cat_id', '$clone_status', '$clone_img', '$clone_tags', '$clone_date', '$post_content', $clone_user_id)";
        $result_for_cloning = mysqli_query($connect, $query_for_cloning);
        errorFun($result_for_cloning);
    }
  }
}
?>


<form action="" method="post">
  <div class="col-xs-4" id="bulkOptionContainer">
    <select name="bulkOptions" class="form-control">
      <option value="">Select</option>
      <option value="draft">Dfaft</option>
      <option value="published">publishe</option>
      <option value="delete">Delete</option>
      <option value="clone">clone</option>
    </select>
  </div>
  <div class="col-xs-4">
    <input type="submit" name='newSubmit' class="btn btn-primary" value="Apply">
    <a href="posts.php?source=add_post" class="btn btn-primary">Add New</a>
  </div>
  <br><br>
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th><input type="checkbox" id="selectAllBoxes"></th>
        <th>Title</th>
        <th>Category</th>
        <th>Author</th>
        <th>Image</th>
        <th>Tags</th>
        <th>Comments</th>
        <th>Date</th>
        <th>Status</th>
        <th>Viewed By(count)</th>
        <th>View Post</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $id = $_SESSION['id'];
      $query  = "SELECT * FROM posts WHERE post_user_id = '$id' ORDER BY post_id DESC";
      $result = mysqli_query($connect, $query);


      while ($row = mysqli_fetch_assoc($result)) {
        $post_id          = $row['post_id'];
        $post_author      = $row['post_author'];
        $post_title       = $row['post_title'];
        $post_cat_id      = $row['post_cat_id'];
        $post_status      = $row['post_status'];
        $post_img         = $row['post_image'];
        $post_tags        = $row['post_tags'];
        $post_date        = $row['post_date'];
        $post_views_count = $row['post_views_count'];

        $query_for_comment_count  = "SELECT * FROM comments WHERE comm_post_id = '$post_id'";
        $result_for_comment_count = mysqli_query($connect, $query_for_comment_count);
        errorFun($result_for_comment_count);

        $post_comment_count = mysqli_num_rows($result_for_comment_count);

        echo "<tr>";
        echo "<td><input type='checkbox' class='  ' name='checkBoxArray[]' value='$post_id'></td>";
        echo "<td>$post_title</td>";

        $query_for_retrive_cat  = "SELECT * FROM cat WHERE cat_id = $post_cat_id";
        $result_for_retrive_cat = mysqli_query($connect, $query_for_retrive_cat);
        while ($row1 = mysqli_fetch_assoc($result_for_retrive_cat)) {
          $cat_id = $row1['cat_id'];
          $cat_title = $row1['cat_title'];
          echo "<td>$cat_title</td>";
        }

        echo "<td>$post_author </td>";

        echo "<td><img src='../$post_img' width='100px' alt='image'></td>";
        echo "<td>$post_tags</td>";
        echo "<td><a href='post_comments.php?source={$post_id}'>$post_comment_count</a></td>";
        echo "<td>$post_date</td>";
        echo "<td>$post_status</td>";
        echo "<td>$post_views_count</td>";
        echo "<td><a class='btn btn-primary' href='../post.php?source={$post_id}'>View Post</td>";
        echo "<td><a class='btn btn-info' href='posts.php?source=update&id={$post_id}'>Edit</td>";
        echo "<td><a class='btn btn-danger' onclick=\"javascript: return confirm('Are you sure you want to delete this post')\" href='my_posts.php?delete={$post_id}'>Delete</td>";
        echo "</tr>";
      }

      ?>
    </tbody>
  </table>
</form>


<!-- <?php
      if (isset($_GET['delete'])) {
        $post_id = $_GET['delete'];
        $query_for_delete_post  = "DELETE from posts WHERE (post_id) = $post_id";
        $result_for_delete_post = mysqli_query($connect, $query_for_delete_post);
        if ($result_for_delete_post) {
          header("Location: my_posts.php");
        } else {
          echo "Error" . " " . mysqli_error($connect);
        }
      }
      ?> -->