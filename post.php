<?php include "include/header.php" ?>

<body>

    <!-- Page Content -->
    <div class="container">
        <?php include "include/nav.php" ?>
        <div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <!-- <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1> -->

                <!-- First Blog Post -->
                <?php
                if (isset($_POST['liked'])) {
                    $post_id = $_POST['post_id'];
                    $user_id = $_POST['user_id'];


                    $query  = "SELECT * FROM posts WHERE post_id= '$post_id' ";
                    $postResult = mysqli_query($connect, $query);
                    errorFun($postResult);
                    $post = mysqli_fetch_array($postResult);
                    $like = $post['likes'];

                    if (mysqli_num_rows($postResult) >= 1) {
                        echo $post['post_id'];
                    }

                    mysqli_query($connect, "UPDATE posts SET likes = $like+1 WHERE post_id = '$post_id'");

                    mysqli_query($connect, "INSERT INTO likes(user_id, post_id) VALUES ('$user_id', '$post_id')");
                    exit;
                }

                if (isset($_POST['unliked'])) {
                    $post_id = $_POST['post_id'];
                    $user_id = $_POST['user_id'];


                    $query  = "SELECT * FROM posts WHERE post_id= '$post_id' ";
                    $postResult = mysqli_query($connect, $query);
                    errorFun($postResult);
                    $post = mysqli_fetch_array($postResult);
                    $like = $post['likes'];


                    mysqli_query($connect, "UPDATE posts SET likes = $like-1 WHERE post_id = '$post_id'");

                    mysqli_query($connect, "DELETE FROM likes WHERE user_id = '$user_id' AND post_id ='$post_id' ");
                    exit;
                }
                ?>
                <?php
                $the_post_id        =  $_GET['source'];
                $query_for_post     = "SELECT * FROM posts WHERE post_id = $the_post_id";
                $result_for_post    = mysqli_query($connect, $query_for_post);

                $query_for_post_view_count  = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = '$the_post_id'";
                $result_for_post_view_count = mysqli_query($connect, $query_for_post_view_count);
                errorFun($result_for_post_view_count);
                while ($row = mysqli_fetch_assoc($result_for_post)) {
                    $post_title    = $row['post_title'];
                    $post_author   = $row['post_author'];
                    $post_date     = $row['post_date'];
                    $post_image    = $row['post_image'];
                    $post_content  = $row['post_content'];
                    echo "<h2> {$post_title} </h2>
                    <p class='lead'>by <a href='author_post.php?source=$post_author'>{$post_author}</a></p>
                    <p>
                    <span class='glyphicon glyphicon-time'></span> Posted on {$post_date}
                    </p>
                    <hr/>
                    <img class='img-responsive' src='{$post_image}' alt='any_image' />
                    <hr/>
                    <p>{$post_content}</p>";
                }

                ?>
                <hr />
                <?php
                if (isLoggedIn()) {
                    if (userLikePost($the_post_id)) : ?>
                        <div class="row thumb">
                            <p class="pull-right"><a class="unlike" href=""><samp class="glyphicon glyphicon-thumbs-down"></samp> Unike</a></p>
                        </div>
                    <?php else : ?>
                        <div class="row thumb">
                            <p class="pull-right"><a class="like" href=""><samp class="glyphicon glyphicon-thumbs-up"></samp> Like</a></p>
                        </div>
                    <?php endif;
                } else { ?>
                    <div class="row thumb">
                        <p class="pull-right"><a class="" href="login.php"><samp class="glyphicon glyphicon-thumbs-up"></samp> Like</a></p>
                    </div>
                <?php } ?>


                <div class="row">
                    <p class="pull-right"><?php echo likes($the_post_id) ?>: Likes</p>
                </div>
                <div class="clearfix"></div>


                <?php include "include/comment.php" ?>




                <!-- Pager -->

            </div>

        </div>
        <!-- /.row -->

        <hr />
    </div>
    <?php include "include/footr.php" ?>
    <script>
        $(document).ready(function() {
            let post_id = <?php echo $the_post_id; ?>;
            let user_id = <?php echo loggedInUser(); ?>;
            $('.like').click(function() {
                $.ajax({
                    url: 'post.php?source=<?php echo $the_post_id; ?>',
                    type: 'post',
                    data: {
                        'liked': 1,
                        'post_id': post_id,
                        'user_id': user_id
                    }
                })
            })
            // ***************************************************************************************
            $('.unlike').click(function() {
                $.ajax({
                    url: 'post.php?source=<?php echo $the_post_id; ?>',
                    type: 'post',
                    data: {
                        'unliked': 1,
                        'post_id': post_id,
                        'user_id': user_id
                    }
                })
            })
        })
    </script>
</body>

</html>