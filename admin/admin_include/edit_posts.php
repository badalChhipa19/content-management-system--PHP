<?php
if (!isset($_SESSION['role'])) {
  header('Location: ../../index.php');
}

$the_cat_id   = $_GET['id'];

if (isset($_POST['submit'])) {
  $title          = escape($_POST['title']);
  $post_cat_id    = escape($_POST['post_cat']);
  $author         = escape($_POST['author']);
  $status         = escape($_POST['status']);

  $image          = $_FILES['image']['name'];
  $img_temp       = $_FILES['image']['tmp_name'];

  $tags           = escape($_POST['tags']);
  $content        = escape($_POST['content']);


  if (empty($image)) {
    $query_for_retrive_img  = "SELECT * FROM posts WHERE post_id = $the_cat_id";
    $result_for_retrive_img = mysqli_query($connect, $query_for_retrive_img);
    errorFun($result_for_retrive_img);

    while ($row = mysqli_fetch_assoc($result_for_retrive_img)) {
      $image = $row['post_image'];
      $image = str_replace('img/', '', $image);
    }
  }
  move_uploaded_file($img_temp, "../img/$image");



  $query_for_update_post  = "UPDATE posts SET 
                              post_title       = '$title', 
                              post_cat_id      = '$post_cat_id', 
                              post_author      = '$author', 
                              post_image       = 'img/$image', 
                              post_tags        = '$tags', 
                              post_content     = '$content', 
                              post_status      = '$status',
                              post_views_count = 0
                              WHERE post_id    = $the_cat_id";

  $result_for_update_post = mysqli_query($connect, $query_for_update_post);
  errorFun($result_for_update_post);

  echo "<p class='bg-success'>Post Updated: " . " " . "<a href='../post.php?source=$the_cat_id'>View User</a> OR <a href='posts.php'>Edit More</a> </p>";
}
?>
<?php
if (isset($_GET['id'])) {
  $post_id = $_GET['id'];
  $query_for_edit_post  = "SELECT * FROM posts WHERE post_id = $post_id";
  $result_for_edit_post = mysqli_query($connect, $query_for_edit_post);
  errorFun($result_for_edit_post);

  while ($row = mysqli_fetch_assoc($result_for_edit_post)) {
    $title        = $row['post_title'];
    $post_cat_id  = $row['post_cat_id'];
    $post_author  = $row['post_author'];
    $post_image   = $row['post_image'];
    $post_tags    = $row['post_tags'];
    $post_content = $row['post_content'];
    $post_status = $row['post_status'];
?>
    <form action="" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" value="<?php echo $title; ?>" name="title">
      </div>
      <div class="form-group">
        <select name="post_cat" id="">
          <?php
          $query_for_retrive_cat  = "SELECT * FROM cat";
          $result_for_retrive_cat = mysqli_query($connect, $query_for_retrive_cat);
          errorFun($result_for_retrive_cat);

          while ($row = mysqli_fetch_assoc($result_for_retrive_cat)) {
            $cat_id    = $row['cat_id'];
            $cat_title = $row['cat_title'];
            if ($cat_id == $post_cat_id) {
              echo "<option selected value='$cat_id'>$cat_title</option>";
            } else {
              echo "<option value='$cat_id'>$cat_title</option>";
            }
          }
          ?>
        </select>
      </div>
      <div class="form-group">
        <label for="author">Post Author</label>
        <input type="text" class="form-control" value="<?php echo $post_author; ?>" name="author">
      </div>

      <div class="form-group">
        <select name="status">
          <option value="<?php echo $post_status; ?>"><?php echo $post_status; ?></option>
          <?php
          if ($post_status === 'published') {
            echo "<option value='draft'>Draft</option>";
          } else {
            echo "<option value='published'>Publish</option>";
          }
          ?>
        </select>
      </div>
      <!-- <div class="form-group"> -->
      <!-- <label for="status">Post Status</label> -->
      <!-- <input type="text" class="form-control" value="<?php echo $post_status; ?>" name="status"> -->
      <!-- </div> -->
      <div class="form-group">
        <img width="100" src="../<?php echo $post_image; ?>" alt="image not found">
        <input type="file" name="image">
      </div>
      <div class="form-group">
        <label for="tags">Post Tags</label>
        <input type="text" class="form-control" value="<?php echo $post_tags; ?>" name="tags">
      </div>
      <div class="form-group">
        <label for="summernote">Post Content</label>
        <textarea name="content" class="form-control" cols="30" rows="10"><?php echo $post_content; ?></textarea>
      </div>
      <div class="form-group">
        <input type="submit" class="btn btn-primary" name="submit" value="Update Post">
      </div>

    </form>

<?php
  }
}
?>