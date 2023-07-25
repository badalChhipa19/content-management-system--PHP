<!-- Blog Comments -->
<?php
$get_id = escape($_GET['source']);

if (isset($_POST['submit_comment'])) {
  $id         = $_SESSION['id'];
  $username   = $_SESSION['username'];
  $mail       = $_SESSION['mail'];
  $content    = escape($_POST['comment_content']);

  if (!empty($content)) {
    if (loggedInUser()) {
      $query_for_add_comment  = "INSERT INTO comments(comm_post_id, comm_author, comm_mail, comm_content, comm_status, comm_date, comm_user_id) 
                              VALUES('$get_id', '$username', '$mail', '$content', 'unapproved', now(), $id)";
      $result_for_add_comment = mysqli_query($connect, $query_for_add_comment);
      errorFun($result_for_add_comment);
    } else {
      echo "<script>
  alert('logg in first');
  </script>";
    }
  } else {
    echo "<script>
  alert('These fields can not be empty');
  </script>";
  }
}
?>
<!-- Comments Form -->
<div class="well">
  <h4>Leave a Comment:</h4>
  <form role="form" method="post">
    <!-- <div class="form-group">
      <label for="comment_author">Author</label>
      <input type="text" name='comment_author' class="form-control">
    </div>
    <div class="form-group">
      <label for="comment_email">Email</label>
      <input type="email" name='comment_mail' class="form-control">
    </div> -->
    <div class="form-group">
      <textarea name="comment_content" cols="30" rows="5" class="form-control"></textarea>
    </div>

    <button type="submit" name='submit_comment' class="btn btn-primary">Submit</button>
  </form>
</div>

<hr>

<!-- Posted Comments -->


<!-- Comment -->

<?php
$query_for_comments  = "SELECT * FROM comments WHERE comm_post_id = $get_id AND comm_status = 'approved'  ORDER BY comm_is DESC";
$result_for_comments = mysqli_query($connect, $query_for_comments);
errorFun($result_for_comments);

while ($row = mysqli_fetch_assoc($result_for_comments)) {
  $author = $row['comm_author'];
  $date = $row['comm_date'];
  $content = $row['comm_content'];
?>

  <div class="media">
    <!-- <a class="pull-left" href="#">
      <img class="media-object" src="http://placehold.it/64x64" alt="comment_img">
    </a> -->
    <div class="media-body">
      <h4 class="media-heading"><?php echo $author;  ?>
        <small><?php echo $date; ?></small>
      </h4>
      <?php echo $content; ?>
    </div>
  </div>

<?php   } ?>

<!-- Comment -->
<!-- <div class="media">
  <a class="pull-left" href="#">
    <img class="media-object" src="http://placehold.it/64x64" alt="">
  </a>
  <div class="media-body">
    <h4 class="media-heading">Start Bootstrap
      <small>August 25, 2014 at 9:30 PM</small>
    </h4> -->
<!-- Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus. -->
<!-- Nested Comment -->
<!-- <div class="media">
  <a class="pull-left" href="#">
    <img class="media-object" src="http://placehold.it/64x64" alt="">
  </a>
  <div class="media-body">
    <h4 class="media-heading">Nested Start Bootstrap
      <small>August 25, 2014 at 9:30 PM</small>
    </h4>
    Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
  </div>
</div> -->
<!-- End Nested Comment -->
<!-- </div>
</div> -->