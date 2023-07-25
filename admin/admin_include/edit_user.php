<!-- UPDATE DETAILS -->
<?php
if (!isset($_SESSION['role'])) {
  header('Location: ../../index.php');
}

$id = $_GET['id'];
if (isset($_POST['submit'])) {
  $f_name        = escape($_POST['f_name']);
  $l_name        = escape($_POST['l_name']);
  $username      = escape($_POST['username']);
  $password      = escape($_POST['password']);
  $role          = escape($_POST['role']);
  $mail          = escape($_POST['mail']);

  // $img           = $_FILES['image']['name'];
  // $temp_img      = $_FILES['image']['tmp_name'];

  // move_uploaded_file($temp_img, "../img/$img");

  $password = password_hash($password, PASSWORD_BCRYPT, array('COST' => 10));

  $query_for_update_user  = "UPDATE user_table SET 
                            username      = '$username',
                            user_f_name   = '$f_name',
                            user_l_name   = '$l_name',
                            user_password = '$password',
                            user_mail     = '$mail',
                            user_role     = '$role'
                        WHERE user_id     = $id";

  $result_for_update_user = mysqli_query($connect, $query_for_update_user);
  errorFun($result_for_update_user);

  echo "User Updated: " . " " . "<a href='users.php'>View Users</a>";
}

?>

<!-- SELECT DETAILS -->
<?php
if (isset($_GET['id'])) {
  $query_for_edit_user  = "SELECT * FROM user_table WHERE user_id = $id";
  $result_for_edit_user = mysqli_query($connect, $query_for_edit_user);
  errorFun($result_for_edit_user);

  while ($row = mysqli_fetch_assoc($result_for_edit_user)) {
    $f_name        = $row['user_f_name'];
    $l_name        = $row['user_l_name'];
    $username      = $row['username'];
    // $password      = $row['user_password'];
    $role          = $row['user_role'];
    $image         = $row['user_image'];
    $mail          = $row['user_mail'];
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
        <select name="role">
          <option value="<?php echo $role; ?>"><?php echo $role; ?></option>
          <?php
          if ($role == 'admin') {
            echo "<option value='Subscriber'>Subscriber</option>";
          } else {
            echo "<option value='admin'>Admin</option>";
          }

          ?>
        </select>
      </div>

      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" value="<?php echo $username; ?>" name="username">
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="password">
      </div>

      <!-- <div class="form-group">
        <img width="100" src="../<?php // echo $image; 
                                  ?>" alt="">
        <input type="file" name="image">
      </div> -->

      <div class="form-group">
        <input type="submit" value="Update User" name='submit' class="btn btn-primary">
      </div>
    </form>
<?php
  }
} else {
  header("Location: admin_index.php");
}
?>