<?php session_start() ?>

<?php
if (!isset($_SESSION['role'])) {
  header('Location: ../../index.php');
}
?>

<?php
$_SESSION['username']  = null;
$_SESSION['f_name']    = null;
$_SESSION['l_name']    = null;
$_SESSION['role']      = null;

header("Location: ../../index.php")
?>