<?php ob_start(); ?>

<?php
$connect = mysqli_connect('localhost', 'root', '', 'cms');
if(!$connect){
    echo "Database connection failed";
}
?>