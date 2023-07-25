<?php include "db.php"; ?>
<?php include "function.php"; ?>
<?php session_start() ?>
<?php
if (isset($_POST['login'])) {
  if(!empty($_POST['username']) && !empty($_POST['password'])){
    login_user($_POST['username'], $_POST['password']);
  } else{
    header('Location:../index.php');
  }
}
?>