<?php include "admin_include/header.php" ?>

<body>
    <div id="wrapper">

        <?php include "admin_include/nav.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Category Page
                        </h1>

                        <?php addCategory() ?>

                        <div class="col-xs-6">
                            <form action="" method="post">
                                <div class="form-group">
                                    <lable for="cat_title">Add Category</lable>
                                    <input type="text" class="form-control" name="cat_title">
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="Add Caegory" class="btn btn-primary" name="submit">
                                </div>
                                <?php
                                if (isset($_GET['edit'])) {
                                    $cat_id = $_GET['edit'];
                                    $query_for_edit_cat  = "SELECT * FROM cat WHERE(cat_id) = $cat_id";
                                    $result_for_edit_cat = mysqli_query($connect, $query_for_edit_cat);

                                    while ($row = mysqli_fetch_assoc($result_for_edit_cat)) {
                                        $cat_id    = $row['cat_id'];
                                        $cat_title = $row['cat_title'];
                                ?>

                                        <div class="frm-group">
                                            <input type="text" name="cat_title_update" value="<?php if (isset($cat_id)) echo $cat_title; ?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" value="Update Category" class="btn btn-primary" name="update">
                                        </div>
                                <?php }
                                }
                                ?>
                                <?php
                                if (isset($_POST['update'])) {
                                    $cat_title_update = $_POST['cat_title_update'];
                                    $query_for_update_cat  = "UPDATE cat SET cat_title = '{$cat_title_update}' WHERE cat_id = {$cat_id} ";
                                    $result_for_update_cat = mysqli_query($connect, $query_for_update_cat);
                                    if (!$result_for_update_cat) {
                                        die("Error" . mysqli_errno($connect));
                                    } else {
                                        header("Location:category.php");
                                    }
                                }
                                ?>
                            </form>
                        </div>
                        <div class="col-xs-6">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Category Title</th>
                                        <th>Update</th>
                                        <th>Delete</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php allCategory() ?>
                                    <?php deleteCategory() ?>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <?php include "admin_include/footer.php"; ?>

</body>

</php>