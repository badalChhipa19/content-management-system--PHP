<?php
if (!isset($_SESSION['role'])) {
  header('Location: ../../index.php');
}

if (isset($_POST['submit'])) {
  $id                 = escape($_SESSION['id']);
  $title              = escape($_POST['title']);
  $author             = escape($_POST['author']);
  $cat_id             = escape($_POST['post_cat_id']);
  $status             = escape($_POST['post_status']);

  $image              = escape($_FILES['image']['name']);
  $image_temp         = escape($_FILES['image']['tmp_name']);

  $tags               = escape($_POST['tags']);
  $content            = escape($_POST['content']);
  $date               = date('d-m-y');

  if (!empty($title) && !empty($author) && !empty($cat_id) && !empty($status) && !empty($content)) {
    move_uploaded_file($image_temp, "../img/$image");
    $query_for_add_post  = "INSERT INTO posts(post_cat_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status, post_user_id)  
                          VALUES('$cat_id', '$title', '$author', now(), 'img/$image', '$content', '$tags', '$status', '$id')";


    $result_for_add_post = mysqli_query($connect, $query_for_add_post);
    errorFun($result_for_add_post);
    // headerFun('posts.php');
    $the_cat_id = mysqli_insert_id($connect);
    echo "<p class='bg-success'>Post Created: " . " " . "<a  href='../post.php?source=$the_cat_id'>View Posts</a>";
  } else {
    echo "<p class='bg-success' >Empty post can not be submitted.</p>";
  }
}
?>

<form action="" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="title">Post Title</label>
    <input type="text" class="form-control" name="title">
  </div>
  <div class="form-group">
    <select name="post_cat_id">
      <?php
      $query_for_retrive_cat  = "SELECT * FROM cat";
      $result_for_retrive_cat = mysqli_query($connect, $query_for_retrive_cat);
      errorFun($result_for_retrive_cat);
      while ($row = mysqli_fetch_assoc($result_for_retrive_cat)) {
        $cat_id    = $row['cat_id'];
        $cat_title = $row['cat_title'];

        echo "<option value='$cat_id'>$cat_title</option>";
      }
      ?>
    </select>
  </div>
  <div class="form-group">
    <label for="author">Post Author</label>
    <input type="text" class="form-control" name="author">
  </div>
  <div class="form-group">
    <select name="post_status">
      <option value="draft">Select Status</option>
      <option value="published">Publish</option>
      <option value="draft">Draft</option>
    </select>
  </div>
  <div class="form-group">
    <label for="image">Post Image</label>
    <input type="file" name="image">
  </div>
  <div class="form-group">
    <label for="tags">Post Tags</label>
    <input type="text" class="form-control" name="tags">
  </div>
  <div class="form-group">
    <label for="summernote">Post Content</label>
    <textarea name="content" class="form-control summernote" cols="30" rows="10"></textarea>
  </div>
  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="submit" value="Add Post">
  </div>

</form>