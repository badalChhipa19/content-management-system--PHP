<?php
// HEADER FUNCTION********************************************************
function headerFun($location)
{
  header("Location: $location");
  exit;
}



// CHECK POST OR GET********************************************************
function ifItIsMethod($method = NULL)
{
  if ($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {
    return true;
  } else {
    return false;
  }
}

// CHECK ROLE********************************************************
function isLoggedIn()
{
  if (isset($_SESSION['role'])) {
    return true;
  } else {
    return false;
  }
}

// LOGEDIN AND REDIRECT********************************************************
function checkIfUserIsLoggedInAndRedirect($redirectLocation)
{
  if (isLoggedIn()) {
    headerFun($redirectLocation);
  }
}




//Error Function********************************************************
function errorFun($result)
{
  global $connect;
  if (!$result) {
    echo "ERROR" . " " . mysqli_error($connect);
  }
}

//  ESCAPING********************************************************
function escape($str)
{
  global $connect;
  return mysqli_real_escape_string($connect, trim($str));
}

// USER EXISTS********************************************************
function user_exists($username)
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
function mail_exists($email)
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


// USER REGISTERED********************************************************
function user_reg($username, $f_name, $l_name, $email, $password)
{
  global $connect;
  $password = password_hash($password, PASSWORD_BCRYPT, array('COST' => 10));

  $query  = "INSERT INTO user_table(username, user_password,
                    user_f_name, user_l_name, user_role, user_mail) 
                                        VALUES ('$username', '$password', '$f_name', '$l_name', 'subscriber', '$email')";
  $result = mysqli_query($connect, $query);
  headerFun('index.php');
}

// FOR USER LOGIN********************************************************
function login_user($username, $password)
{
  global $connect;
  $username = escape($username);
  $password = $password;

  $query_for_login  = "SELECT * FROM user_table WHERE username = '$username'";
  $result_for_login = mysqli_query($connect, $query_for_login);
  errorFun($result_for_login);

  while ($row = mysqli_fetch_array($result_for_login)) {
    $db_id       = $row['user_id'];
    $db_username = $row['username'];
    $db_password = $row['user_password'];
    $db_f_name   = $row['user_f_name'];
    $db_l_name   = $row['user_l_name'];
    $db_mail   = $row['user_mail'];
    $db_role     = $row['user_role'];

    if ($db_username === $username && password_verify($password, $db_password)) {
      $_SESSION['id']        = $db_id;
      $_SESSION['username']  = $db_username;
      $_SESSION['f_name']    = $db_f_name;
      $_SESSION['l_name']    = $db_l_name;
      $_SESSION['role']      = $db_role;
      $_SESSION['mail']      = $db_mail;
      headerFun('../admin/admin_index.php');
    } else {
      headerFun('../index.php');
    }
  }
}

// LOGGED IN USER********************************************************
function loggedInUser()
{
  if (isLoggedIn()) {
    global $connect;
    $query = "SELECT * FROM user_table WHERE username ='" . $_SESSION['username'] . "'";
    $result = mysqli_query($connect, $query);
    errorFun($result);
    $user = mysqli_fetch_array($result);
    if (mysqli_num_rows($result) >= 1) {
      return $user['user_id'];
    }
  }
  return false;
}

// USER LIKE POST********************************************************
function userLikePost($post_id = '')
{
  global $connect;
  $query = "SELECT * FROM likes WHERE user_id ='" . loggedInUser() . "' AND post_id = '$post_id'";
  $result = mysqli_query($connect, $query);
  errorFun($result);

  return mysqli_num_rows($result) >= 1 ? true : false;
}

// LIKES COUNT********************************************************
function likes($post_id)
{
  global $connect;
  $query  = "SELECT likes FROM posts WHERE post_id = '$post_id'";
  $result = mysqli_query($connect, $query);
  errorFun($result);
  $count = mysqli_fetch_assoc($result);
  echo $count['likes'];
}
