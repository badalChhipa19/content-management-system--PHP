<?php
if (!isset($_SESSION['role'])) {
  header('Location: ../../index.php');
}

if (isset($_POST['checkBoxArray'])) {
  foreach ($_POST['checkBoxArray'] as $anyName) {
    $option = $_POST['bulkOptions'];
    switch ($option) {
      case 'admin':
        $query_for_update_status  = "UPDATE user_table SET user_role = 'admin' WHERE user_id = $anyName";
        $result_for_update_status = mysqli_query($connect, $query_for_update_status);
        errorFun($result_for_update_status);
        break;
      case 'subscriber':
        $query_for_update_status  = "UPDATE user_table SET user_role = 'subscriber' WHERE user_id = $anyName";
        $result_for_update_status = mysqli_query($connect, $query_for_update_status);
        errorFun($result_for_update_status);
        break;
      case 'delete':
        $query_for_update_status  = "DELETE FROM user_table WHERE user_id = $anyName";
        $result_for_update_status = mysqli_query($connect, $query_for_update_status);
        errorFun($result_for_update_status);
        break;
      case 'clone':
        $query_for_clone  = "SELECT * FROM user_table WHERE user_id = '$anyName'";
        $result_for_clone = mysqli_query($connect, $query_for_clone);
        errorFun($result_for_clone);

        while ($row = mysqli_fetch_assoc($result_for_clone)) {
          $username = escape($row['username']);
          $password = escape($row['user_password']);
          $f_name   = escape($row['user_f_name']);
          $l_name   = escape($row['user_l_name']);
          $mail     = escape($row['user_mail']);
          $role     = escape($row['user_role']);
        }
        $query_for_cloning  = "INSERT INTO user_table(username, user_password, user_f_name, user_l_name, user_mail,  user_role) 
                                VALUES('$username', '$password', '$f_name', '$l_name', '$mail', '$role')";
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
      <option value="admin">Admin</option>
      <option value="subscriber">Subscriber</option>
      <option value="delete">Delete</option>
      <option value="clone">Clone</option>
    </select>
  </div>
  <div class="col-xs-4">
    <input type="submit" name='newSubmit' class="btn btn-primary" value="Apply">
    <a href="users.php?source=add_user" class="btn btn-primary">Add New</a>
  </div>
  <br><br>
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th><input type="checkbox" id="selectAllBoxes"></th>
        <td>ID</td>
        <td>UserName</td>
        <td>First Name</td>
        <td>Last Name</td>
        <td>E-Mail</td>
        <!-- <td>User Image</td> -->
        <td>User Role</td>
        <td>Approve</td>
        <td>Unapprove</td>
        <td>Edit</td>
        <td>Delete</td>
      </tr>
    </thead>
    <tbody>

      <?php
      $query_for_userData  = "SELECT * FROM user_table";
      $result_for_userData = mysqli_query($connect, $query_for_userData);
      errorFun($result_for_userData);

      while ($row = mysqli_fetch_assoc($result_for_userData)) {
        $id       = $row['user_id'];
        $username = $row['username'];
        $password = $row['user_password'];
        $f_name   = $row['user_f_name'];
        $l_name   = $row['user_l_name'];
        $mail     = $row['user_mail'];
        // $image    = $row['user_image'];
        $role     = $row['user_role'];

        echo "<tr>";
        echo "<td><input type='checkbox' name='checkBoxArray[]' value='$id'></td>";
        echo "<td>$id</td>";
        echo "<td>$username</td>";
        echo "<td>$f_name</td>";
        echo "<td>$l_name</td>";
        echo "<td>$mail</td>";
        echo "<td>$role</td>";
        echo "<td><a onClick='javascript: return confirm('Are you sure you want topromote')' href='users.php?admin=$id'>Admin</a></td>";
        echo "<td><a href='users.php?subscriber=$id'>Subscriber</a></td>";
        echo "<td><a class='btn btn-info' href='users.php?source=edit&id=$id'>Edit</a></td>";
        echo "<td><a class='btn btn-danger' onclick=\"javascript: return confirm('Are you sure you want to delete this user')\" href='users.php?delete=$id'>Delete</a></td>";
        echo "</tr>";
      } ?>

    </tbody>
  </table>
  <!-- DELETE USER -->
  <?php
  if (isset($_GET['delete'])) {

    if (isset($_SESSION['role'])) {
      if ($_SESSION['role'] == 'admin') {
        $id = escape($_GET['delete']);
        $query_for_userDelete  = "DELETE FROM user_table WHERE user_id = $id";
        $result_for_userDelete = mysqli_query($connect, $query_for_userDelete);
        errorFun($result_for_userDelete);
        header("Location: users.php");
      }
    }
  }
  ?>

  <!-- ROLE -->
  <?php
  if (isset($_GET['admin'])) {
    $id = $_GET['admin'];
    $query_to_admin  = "UPDATE user_table SET user_role = 'admin' WHERE user_id = $id";
    $result_to_admin = mysqli_query($connect, $query_to_admin);
    errorFun($result_to_admin);
    header("Location: users.php");
  }

  if (isset($_GET['subscriber'])) {
    $id = $_GET['subscriber'];
    $query_to_sub  = "UPDATE user_table SET user_role = 'subscriber' WHERE user_id = $id";
    $result_to_sub = mysqli_query($connect, $query_to_sub);
    errorFun($result_to_admin);
    header("Location: users.php");
  }
  ?>