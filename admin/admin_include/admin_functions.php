<?php
// ERROR FUNCTION******************************************************
if (!isset($_SESSION['role'])) {
  header('Location: ../../index.php');
}


function errorFun($result)
{
  global $connect;
  if (!$result) {
    echo "ERROR" . " " . mysqli_error($connect);
  }
}

// ESCAPE STRING******************************************************
function escape($str)
{
  global $connect;
  return mysqli_real_escape_string($connect, trim($str));
}

// HEADER FUNCTION******************************************************
function headerFun($location)
{
  header("Location: $location");
  exit;
}

// CHECK LOGGED IN OR NOT***********************************************
function ifUserLogIn()
{
  if (isset($_SESSION['role'])) {
    return true;
  } else {
    return false;
  }
}

// CHECK USER LROGEDIN AND REDIRECT***********************************
function ifUserisAdmin()
{
  if ($_SESSION['role'] == 'admin') {
    return true;
  } else {
    return false;
  }
}

// ADD CATEGORY******************************************************
function addCategory()
{
  global $connect;
  if (isset($_POST['submit'])) {
    $id = $_SESSION['id'];
    $cat_title = $_POST['cat_title'];

    if ($cat_title == " " || empty($cat_title)) {
      echo "This field should not be empty";
    } else {
      $query_for_cat_table = "INSERT INTO cat(cat_title, cat_user_id) VALUES('$cat_title', $id)";
      $result_for_cat_table = mysqli_query($connect, $query_for_cat_table);
    }
  }
}

// //////////////////////////////////////////////////////////////////////////////////
// ALL CATEGORY******************************************************
function allCategory()
{
  global $connect;
  $query_for_add_cat = "SELECT * FROM cat";
  $resule_for_add_cat = mysqli_query($connect, $query_for_add_cat);

  while ($row = mysqli_fetch_assoc($resule_for_add_cat)) {
    $cat_id = $row['cat_id'];
    $cat_title = $row['cat_title'];

    echo "<tr>
  <td>{$cat_id}</td>
  <td>{$cat_title}</td>
  <td><a class='btn btn-info' href='category.php?edit={$cat_id}'>Update</td>
  <td><a class='btn btn-danger' href='category.php?delete={$cat_id}'>Delete</td>
</tr>";
  }
}


// DELETE CATEGORY******************************************************
function deleteCategory()
{
  global $connect;
  if (isset($_GET['delete'])) {
    $query_for_delete_cat = "DELETE FROM cat WHERE(cat_id) = {$_GET['delete']}";
    $result_for_delete_cat = mysqli_query($connect, $query_for_delete_cat);
    if (!$result_for_delete_cat) {
      die("Error" . mysqli_error($connect));
    } else {
      header("Location: category.php");
    }
  }
}

// COUNT ANYTHING******************************************************
function countNum($tName)
{
  global $connect;
  $query = "SELECT * FROM " . $tName;
  $result = mysqli_query($connect, $query);
  errorFun($result);
  return mysqli_num_rows($result);
}

// CHECK STATUS**********************************************************
function checkStatus($tName, $status, $value)
{
  global $connect;
  $query = "SELECT * FROM {$tName} WHERE {$status} = '{$value}'";
  $result = mysqli_query($connect, $query);
  errorFun($result);
  return mysqli_num_rows($result);
}

// USERS ONLINE***********************************************************

function usersOnline()
{
  global $connect;
  $session = session_id();
  $time = time();
  $time_out_in_sec = 60;
  $time_out = $time - $time_out_in_sec;

  $query_for_user_online = "SELECT * FROM users_online WHERE session = '$session'";
  $result_for_user_online = mysqli_query($connect, $query_for_user_online);
  errorFun($result_for_user_online);
  $count = mysqli_num_rows($result_for_user_online);

  if ($count == NULL) {
    mysqli_query($connect, "INSERT INTO users_online(session, time) VALUES ('$session', '$time') ");
  } else {
    mysqli_query($connect, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
  }

  $user_online_query = mysqli_query($connect, "SELECT * FROM users_online WHERE time > '$time_out'");
  return $count_users = mysqli_num_rows($user_online_query);
}

// ADD NEW USER**********************************************************
function addNewUser($username, $password, $f_name, $l_name, $mail, $role)
{
  global $connect;
  $password = password_hash($password, PASSWORD_BCRYPT, array('COST' => 10));
  $query_for_insert_userData  = "INSERT INTO user_table(username, user_password, user_f_name, user_l_name, user_mail,  user_role) 
  VALUES('$username', '$password', '$f_name', '$l_name', '$mail', '$role')";
  $result_for_insert_userData = mysqli_query($connect, $query_for_insert_userData);
  errorFun($result_for_insert_userData);
}
// USER EXISTS********************************************************
function userExists($username)
{
  global $connect;

  $query  = "SELECT username FROM user_table WHERE username = '$username'";
  $result = mysqli_query($connect, $query);
  errorFun($result);
  if (mysqli_fetch_assoc($result) > 0) {
    return true;
  } else {
    return false;
  }
}

// EMAIL EXIST********************************************************
function mailExists($email)
{
  global $connect;

  $query  = "SELECT user_mail FROM user_table WHERE user_mail = '$email'";
  $result = mysqli_query($connect, $query);
  errorFun($result);
  if (mysqli_fetch_assoc($result) > 0) {
    return true;
  } else {
    return false;
  }
}
