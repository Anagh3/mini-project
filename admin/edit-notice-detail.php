<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $nottitle = $_POST['nottitle'];
        $classid = $_POST['classid'];
        $notmsg = $_POST['notmsg'];
        $eid = $_GET['editid'];
        $sql = "UPDATE tblnotice SET NoticeTitle = '$nottitle', ClassId = '$classid', NoticeMsg = '$notmsg' WHERE ID = '$eid'";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            echo '<script>alert("Notice has been updated")</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Management System|| Update Notice</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="vendors/select2/select2.min.css">
    <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
<div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <?php include_once('includes/header.php'); ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <?php include_once('includes/sidebar.php'); ?>
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="page-header">
                    <h3 class="page-title">Update Notice</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page"> Update Notice</li>
                        </ol>
                    </nav>
                </div>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title" style="text-align: center;">Update Notice</h4>

                                <form class="forms-sample" method="post" enctype="multipart/form-data">
                                    <?php
                                    $eid = $_GET['editid'];
                                    $sql = "SELECT tblclass.ID, tblclass.ClassName, tblclass.Section, tblnotice.NoticeTitle, tblnotice.CreationDate, tblnotice.ClassId, tblnotice.NoticeMsg, tblnotice.ID as nid FROM tblnotice join tblclass on tblclass.ID=tblnotice.ClassId where tblnotice.ID='$eid'";
                                    $query = mysqli_query($conn, $sql);
                                    $cnt = 1;
                                    if (mysqli_num_rows($query) > 0) {
                                        while ($row = mysqli_fetch_assoc($query)) {
                                            ?>
                                            <div class="form-group">
                                                <label for="exampleInputName1">Notice Title</label>
                                                <input type="text" name="nottitle" value="<?php echo htmlentities($row['NoticeTitle']); ?>"
                                                       class="form-control" required='true'>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail3">Notice For</label>
                                                <select name="classid" class="form-control">
                                                    <option value="<?php echo htmlentities($row['ClassId']); ?>"><?php echo htmlentities($row['ClassName']); ?><?php echo htmlentities($row['Section']); ?></option>
                                                    <?php
                                                    $sql2 = "SELECT * from tblclass";
                                                    $query2 = mysqli_query($conn, $sql2);
                                                    while ($row1 = mysqli_fetch_assoc($query2)) {
                                                        ?>
                                                        <option value="<?php echo htmlentities($row1['ID']); ?>"><?php echo htmlentities($row1['ClassName']); ?><?php echo htmlentities($row1['Section']); ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputName1">Notice Message</label>
                                                <textarea name="notmsg" class="form-control"
                                                          required='true'><?php echo htmlentities($row['NoticeMsg']); ?></textarea>
                                            </div>
                                        <?php
                                        }
                                    } ?>
                                    <button type="submit" class="btn btn-primary mr-2" name="submit">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
            <!-- partial:partials/_footer.html -->
            <?php include_once('includes/footer.php'); ?>
            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script src="vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="vendors/select2/select2.min.js"></script>
<script src="vendors/typeahead.js/typeahead.bundle.min.js"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="js/off-canvas.js"></script>
<script src="js/misc.js"></script>
<!-- endinject -->
<!-- Custom js for this page -->
<script src="js/typeahead.js"></script>
<script src="js/select2.js"></script>
<!-- End custom js for this page -->
</body>
</html>
