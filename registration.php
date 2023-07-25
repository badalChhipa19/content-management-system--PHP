<?php include "include/db.php"; ?>
<?php include "include/header.php"; ?>

<?php
if (isset($_POST['submit'])) {

    $username = escape($_POST['username']);
    $f_name   = escape($_POST['f_name']);
    $l_name   = escape($_POST['l_name']);
    $email    = escape($_POST['email']);
    $password = escape($_POST['password']);


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
    if (user_exists($username)) {
        $error['username'] = "⚠️User Exists";
    }

    if ($email == '') {
        $error['mail'] = "⚠️E-mail can't be empty";
    }
    if (mail_exists($email)) {
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
            user_reg($username, $f_name, $l_name, $email, $password);
        }
    }
}
?>

<!-- Navigation -->

<?php include "include/nav.php"; ?>


<!-- Page Content -->
<div class="container">

    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1>Register</h1>
                        <h5></h5>
                        <form role="form" action="registration.php" method="post" id="login-form" autocomplete="on">
                            <div class="form-group">
                                <label for="username" class="sr-only">username</label>
                                <input type="text" name="username" id="username" class="form-control" value="<?php echo isset($username) ? $username : ''; ?>" placeholder="Enter Desired Username">
                                <p class="text-center"><?php echo isset($error['username']) ? $error['username'] : ''; ?></p>
                            </div>
                            <div class="form-group">
                                <label for="f_name" class="sr-only">First Name</label>
                                <input type="text" name="f_name" id="f_name" class="form-control" value="<?php echo isset($f_name) ? $f_name : ''; ?>" placeholder="Enter First Name">
                            </div>
                            <div class="form-group">
                                <label for="l_name" class="sr-only">Last Name</label>
                                <input type="text" name="l_name" id="l_name" class="form-control" value="<?php echo isset($l_name) ? $l_name : ''; ?>" placeholder="Enter Last Name">
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="<?php echo isset($email) ? $email : ''; ?>" placeholder="somebody@example.com">
                                <p class="text-center"><?php echo isset($error['mail']) ? $error['mail'] : ''; ?></p>
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                                <p class="text-center"><?php echo isset($error['password']) ? $error['password'] : ''; ?></p>
                            </div>

                            <input type="submit" name="submit" id="btn-login" class="btn btn-primary btn-lg btn-block" value="Register">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>



    <?php include "include/footr.php"; ?>