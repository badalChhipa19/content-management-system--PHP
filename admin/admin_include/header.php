<?php ob_start() ?>
<?php session_start() ?>
<?php include "../include/db.php" ?>
<?php include "admin_functions.php" ?>

<?php
if (!isset($_SESSION['role']) || $_SESSION['role'] == 'subscriber') {
    header("Location: ../index.php");
}
?>

<!DOCTYPE php>
<php lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>SB Admin - Bootstrap Admin Template</title>

        <!-- Bootstrap Core CSS -->

        <link rel="stylesheet" href="css/summernote.min.css" class="css">
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="css/sb-admin.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- php5 Shim and Respond.js IE8 support of php5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/php5shiv/3.7.0/php5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
            <![endif]-->
        <link href="css/loader.css" rel="stylesheet">
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    </head>