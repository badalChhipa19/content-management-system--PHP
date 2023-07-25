<?php
if (!isset($_SESSION['role'])) {
  header('Location: ../../index.php');
}

if (isset($_POST['submit'])) {
  $f_name     = escape($_POST['f_name']);
  $l_name     = escape($_POST['l_name']);
  $mail       = escape($_POST['mail']);
  $role       = escape($_POST['role']);
  $username   = escape($_POST['username']);
  $password   = escape($_POST['password']);


  $error = [
    'username' => '',
    'mail'     => '',
    'password' => ''
  ];

  if (strlen($username) < 5) {
    $error['username'] = '⚠️Username is too small try something large';
  }

  if ($username == '') {
    $error['username'] = "⚠️Username can't be empty";
  }
  if (userExists($username)) {
    $error['username'] = "⚠️User Exists";
  }

  if ($mail == '') {
    $error['mail'] = "⚠️E-mail can't be empty";
  }
  if (mailExists($mail)) {
    $error['mail'] = "⚠️E-mail Exists";
  }

  if (strlen($password) < 6) {
    $error['password'] = '⚠️Password Need to be atleast 6 charector long';
  }

  if ($password == '') {
    $error['password'] = "⚠️Password can't be empty";
  }


  foreach ($error as $key => $value) {
    if (empty($value)) {
      addNewUser($username, $password, $f_name, $l_name, $mail, $role);
    }
  }
  if (empty($value)) {
    echo "User Created: " . " " . "<a href='users.php'>View User</a>";
  }
}
?>
<form action="" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="f_name">First Name</label>
    <input type="text" class="form-control" name="f_name">
  </div>

  <div class="form-group">
    <label for="l_name">Last Name</label>
    <input type="text" class="form-control" name="l_name">
  </div>

  <div class="form-group">
    <label for="mail">E-mail</label>
    <input type="text" class="form-control" name="mail">
    <p class="text-center"><?php echo isset($error['mail']) ? $error['mail'] : ''; ?></p>
  </div>
  <div class="form-group">
    <select name="role">
      <!-- <option value="">Select</option> -->
      <option value="admin">Admin</option>
      <option value="subscriber">Subscriber</option>
    </select>
  </div>

  <div class="form-group">
    <label for="username">Username</label>
    <input type="text" class="form-control" name="username">
    <p class="text-center"><?php echo isset($error['username']) ? $error['username'] : ''; ?></p>
  </div>

  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" name="password">
    <p class="text-center"><?php echo isset($error['password']) ? $error['password'] : ''; ?></p>
  </div>

  <!-- <div class="form-group">
    <input type="file" name="image">
  </div> -->

  <div class="form-group">
    <input type="submit" value="Add User" name='submit' class="btn btn-primary">
  </div>
</form>