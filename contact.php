<?php include "include/db.php"; ?>
<?php include "include/header.php"; ?>

<?php
if (isset($_POST['submit'])) {
  $email    = 'badalchhipa5@gmail.com';
  $sub      = wordwrap(($_POST['sub']), 70);
  $body     = $_POST['body'];
  $header   = "From: " . $_POST['email'];

  if (!empty($email) && !empty($sub) && !empty($body) && !empty($header)) {
    $email    = escape($email);
    $sub      = escape($sub);
    $body     = escape($body);
    $header   = escape($header);

    mail($email, $sub, $body, $header);
  } else {
    $message = '⚠️These fields can not be empty.';
  }
} else {
  $message = '';
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
            <h1>Contect</h1>
            <form role="form" action="contect.php" method="post">
              <h5 class="text-center"><?php
                                      if (empty($username) && empty($email) && empty($password) && empty($f_name) && empty($l_name)) {
                                        echo $message;
                                      } ?></h5>


              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="">
              </div>
              <div class="form-group">
                <label for="sub">Subject</label>
                <input type="text" name="sub" class="form-control" placeholder="">
              </div>
              <label for="body"></label>
              <textarea name="body" class="form-control" rows="5"></textarea>
              <br><br>
              <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Contect">
            </form>

          </div>
        </div> <!-- /.col-xs-12 -->
      </div> <!-- /.row -->
    </div> <!-- /.container -->
  </section>


  <hr>