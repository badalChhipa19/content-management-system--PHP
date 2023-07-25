<?php
if (!isset($_SESSION['role'])) {
  header('Location: ../../index.php');
}

// ERROR FUNCTION*******************************************************

function errorFun($result)
{
  global $connect;
  if (!$result) {
    echo "ERROR" . " " . mysqli_error($connect);
  }
}

// ESCAPE STRING********************************************************
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

function ifUserisSubscriber()
{
  if ($_SESSION['role'] == 'subscriber') {
    return true;
  } else {
    return false;
  }
}

// ADD CATEGORY*********************************************************
function addCategory()
{
  global $connect;
  if (isset($_POST['submit'])) {
    $id        = $_SESSION['id'];
    $cat_title = $_POST['cat_title'];

    if ($cat_title == " " || empty($cat_title)) {
      echo "This field should not be empty";
    } else {
      $query_for_cat_table  = "INSERT INTO cat(cat_title, cat_user_id) VALUES('$cat_title', $id)";
      $result_for_cat_table = mysqli_query($connect, $query_for_cat_table);
    }
  }
}

// //////////////////////////////////////////////////////////////////////////////////
// MY CATEGORY*******************************************
function myCategory()
{
  global $connect;
  $id = $_SESSION['id'];
  $query_for_add_cat  = "SELECT * FROM cat WHERE cat_user_id = $id";
  $resule_for_add_cat = mysqli_query($connect, $query_for_add_cat);

  while ($row = mysqli_fetch_assoc($resule_for_add_cat)) {
    $cat_id    = $row['cat_id'];
    $cat_title = $row['cat_title'];

    echo "<tr>
          <td>{$cat_title}</td>
          <td><a class='btn btn-info' href='my_category.php?edit={$cat_id}'>Update</td>
          <td><a class='btn btn-danger' href='my_category.php?delete={$cat_id}'>Delete</td>
          </tr>";
  }
}

// DELETE CATEGORY****************************************************
function deleteMyCategory()
{
  global $connect;
  if (isset($_GET['delete'])) {
    // echo $_GET['delete'];
    $query_for_delete_cat  = "DELETE FROM cat WHERE(cat_id) = {$_GET['delete']}";
    $result_for_delete_cat = mysqli_query($connect, $query_for_delete_cat);
    if (!$result_for_delete_cat) {
      errorFun($result_for_delete_cat);
    } else {
      header("Location: my_category.php");
    }
  }
}

//COUNT ANYTHING*******************************************************
function countMyNum($table_name, $column_name, $id)
{
  global $connect;
  $query  = "SELECT * FROM  {$table_name} WHERE {$column_name} = '{$id}'";
  $result = mysqli_query($connect, $query);
  errorFun($result);
  return mysqli_num_rows($result);
}

// CHECK STATUS*********************************************************
function checkMyStatus($tName, $status, $value, $column_name, $id)
{
  global $connect;
  $query  = "SELECT * FROM {$tName} WHERE {$status} = '{$value}' AND {$column_name} = {$id}";
  $result = mysqli_query($connect, $query);
  errorFun($result);
  return mysqli_num_rows($result);
}

// COMMENT COUNT ON MY POSTS*********************************************************
function countMyComments()
{
  global $connect;
  $id = $_SESSION['id'];
  $query_fetch_posts  = "SELECT * FROM posts WHERE post_user_id = $id";
  $result_fetch_posts = mysqli_query($connect, $query_fetch_posts);
  errorFun($result_fetch_posts);

  $count = 0;
  while ($fetched_posts = mysqli_fetch_array($result_fetch_posts)) {
    $id = $fetched_posts['post_id'];

    $query  = "SELECT * FROM comments WHERE comm_post_id = $id ";
    $result = mysqli_query($connect, $query);
    errorFun($result);

    $count = $count + mysqli_num_rows($result);
  }
  return $count;
}

// CHECK MY COMMENTS STATUS*********************************************************
function checkMyCommentsStatus()
{
  global $connect;
  $id = $_SESSION['id'];
  $query_fetch_posts  = "SELECT * FROM posts WHERE post_user_id = $id";
  $result_fetch_posts = mysqli_query($connect, $query_fetch_posts);
  errorFun($result_fetch_posts);

  $count = 0;
  while ($fetched_posts = mysqli_fetch_array($result_fetch_posts)) {
    $id = $fetched_posts['post_id'];

    $query  = "SELECT * FROM comments WHERE comm_post_id = $id AND comm_status = 'unapproved' ";
    $result = mysqli_query($connect, $query);
    errorFun($result);

    $count = $count + mysqli_num_rows($result);
  }
  return $count;
}
