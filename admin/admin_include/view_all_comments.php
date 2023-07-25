<?php
if (!isset($_SESSION['role'])) {
  header('Location: ../../index.php');
}

if (isset($_POST['checkBoxArray'])) {
  foreach ($_POST['checkBoxArray'] as $anyName) {
    $option = $_POST['bulkOptions'];
    switch ($option) {
      case 'approve':
        $query_for_update_status  = "UPDATE comments SET comm_status = 'approved' WHERE comm_is = $anyName";
        $result_for_update_status = mysqli_query($connect, $query_for_update_status);
        errorFun($result_for_update_status);
        break;
      case 'unapprove':
        $query_for_update_status  = "UPDATE comments SET comm_status = 'unapproved' WHERE comm_is = $anyName";
        $result_for_update_status = mysqli_query($connect, $query_for_update_status);
        errorFun($result_for_update_status);
        break;
      case 'delete':
        $query_for_update_status  = "DELETE FROM comments WHERE comm_is = $anyName";
        $result_for_update_status = mysqli_query($connect, $query_for_update_status);
        errorFun($result_for_update_status);
        break;
      case 'clone':
        $query_for_clone  = "SELECT * FROM comments WHERE comm_is = '$anyName'";
        $result_for_clone = mysqli_query($connect, $query_for_clone);
        errorFun($result_for_clone);

        while ($row = mysqli_fetch_assoc($result_for_clone)) {
          $id             = escape($row['comm_user_id']);
          $comm_id        = escape($row['comm_is']);
          $comm_post_id   = escape($row['comm_post_id']);
          $caomm_author   = escape($row['comm_author']);
          $comm_content   = escape($row['comm_content']);
          $mail           = escape($row['comm_mail']);
        }
        $query_for_cloning  = "INSERT INTO comments(comm_post_id, comm_author, comm_mail, comm_content, comm_status, comm_date, comm_user_id) 
                                VALUES('$comm_post_id', '$caomm_author', '$mail', '$comm_content', 'unapproved', now(), $id)";
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
      <option value="unapprove">Unapprove</option>
      <option value="approve">Approve</option>
      <option value="delete">Delete</option>
      <option value="clone">clone</option>
    </select>
  </div>
  <div class="col-xs-4">
    <input type="submit" name='newSubmit' class="btn btn-primary" value="Apply">
    <a href="posts.php?source=add_post" class="btn btn-primary">Add New</a>
  </div>
  <br><br>
  <table class="table table-hover table-bordered">
    <thead>
      <th><input type="checkbox" id="selectAllBoxes"></th>
      <th>ID</th>
      <th>Author id</th>
      <th>Author</th>
      <th>Comment</th>
      <th>E-Mail</th>
      <th>Status</th>
      <th>In Response to</th>
      <th>Date</th>
      <th>Approve</th>
      <th>Unapprove</th>
      <th>Delete</th>
    </thead>
    <tbody>
      <?php
      $query  = "SELECT * FROM comments ORDER BY comm_is  DESC";
      $result = mysqli_query($connect, $query);
      errorFun($result);

      while ($row = mysqli_fetch_assoc($result)) {
        $comm_id        = $row['comm_is'];
        $comm_user_id   = $row['comm_user_id'];
        $comm_post_id   = $row['comm_post_id'];
        $caomm_author   = $row['comm_author'];
        $comm_content   = $row['comm_content'];
        $mail           = $row['comm_mail'];
        $status         = $row['comm_status'];
        $date           = $row['comm_date'];



        echo "<tr>";
        echo "<td><input type='checkbox' class='  ' name='checkBoxArray[]' value='$comm_id'></td>";
        echo "<td>$comm_id</td>";
        echo "<td>$comm_user_id</td>";
        echo "<td>$caomm_author</td>";
        echo "<td>$comm_content</td>";
        echo "<td>$mail</td>";
        echo "<td>$status</td>";

        $query_for_in  = "SELECT * FROM posts WHERE post_id = '$comm_post_id'";
        $result_for_in = mysqli_query($connect, $query_for_in);
        while ($row = mysqli_fetch_assoc($result_for_in)) {
          $post_id     = $row['post_id'];
          $post_title = $row['post_title'];

          echo "<td><a href='../post.php?source=$post_id'>$post_title</a></td>";
        }
        echo "<td>$date</td>";
        echo "<td><a href='comment.php?approve=$comm_id''>Approve</a></td>";
        echo "<td><a href='comment.php?unapprove=$comm_id''>Unapprove</a></td>";
        echo "<td><a class='btn btn-danger' onclick=\"javascript: return confirm('Are you sure you want to delete this comment')\" href='comment.php?delete=$comm_id'>Delete</a></td>";
        echo "</tr>";
      }
      ?>
    </tbody>
  </table>
  <!-- DELETING COMMENT -->
  <?php
  if (isset($_GET['delete'])) {
    $comm_id = $_GET['delete'];

    $query_for_delete_comment  = "DELETE FROM comments WHERE comm_is = $comm_id";
    $result_for_delete_comment = mysqli_query($connect, $query_for_delete_comment);
    errorFun($result_for_delete_comment);
    if ($result_for_delete_comment) {
      header("Location: comment.php");
    }
  }
  ?>

  <!-- APPROVE && UNAPPROVE -->

  <?php
  if (isset($_GET['approve'])) {
    $id = $_GET['approve'];

    $query_for_approve  = "UPDATE comments SET comm_status = 'approved' WHERE comm_is = $id";
    $result_for_approve = mysqli_query($connect, $query_for_approve);
    errorFun($result_for_approve);
    header("Location: comment.php");
  }

  if (isset($_GET['unapprove'])) {
    $id = $_GET['unapprove'];

    $query_for_unapprove  = "UPDATE comments SET comm_status = 'unapproved' WHERE comm_is = $id";
    $result_for_unapprove = mysqli_query($connect, $query_for_unapprove);
    errorFun($result_for_approve);
    header("Location: comment.php");
  }
  ?>