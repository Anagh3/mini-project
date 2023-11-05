<?php
session_start();
//error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid']==0)) {
  header('location:logout.php');
  } else{
   
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
   
    <title>Student  Management System|||Dashboard</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="vendors/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="vendors/chartist/chartist.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="css/style.css">
    <!-- End layout styles -->
   
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
     <?php include_once('includes/header.php');?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <?php include_once('includes/sidebar.php');?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-md-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="d-sm-flex align-items-baseline report-summary-header">
                          <h5 class="font-weight-semibold">Report Summary</h5> <span class="ml-auto">Updated Report</span> <button class="btn btn-icons border-0 p-2"><i class="icon-refresh"></i></button>
                        </div>
                      </div>
                    </div>
                    <div class="row report-inner-cards-wrapper">
                      <div class=" col-md -6 col-xl report-inner-card">
                        <div class="inner-card-text">
                        <?php
$sql1 = "SELECT * FROM tblclass";
$query1 = mysqli_query($conn, $sql1);
$results1 = mysqli_fetch_all($query1, MYSQLI_ASSOC);
$totclass = mysqli_num_rows($query1);
?>
                          <span class="report-title">Total Class</span>
                          <h4><?php echo htmlentities($totclass);?></h4>
                          <a href="manage-class.php"><span class="report-count"> View Classes</span></a>
                        </div>
                        <div class="inner-card-icon bg-success">
                          <i class="icon-rocket"></i>
                        </div>
                      </div>
                      <div class="col-md-6 col-xl report-inner-card">
                        <div class="inner-card-text">
                        <?php
$sql2 = "SELECT * FROM tblstudent";
$query2 = mysqli_query($conn, $sql2);
$results2 = mysqli_fetch_all($query2, MYSQLI_ASSOC);
$totstu = mysqli_num_rows($query2);
?>
                          <span class="report-title">Total Students</span>
                          <h4><?php echo htmlentities($totstu);?></h4>
                          <a href="manage-students.php"><span class="report-count"> View Students</span></a>
                        </div>
                        <div class="inner-card-icon bg-danger">
                          <i class="icon-user"></i>
                        </div>
                      </div>
                      <div class="col-md-6 col-xl report-inner-card">
                        <div class="inner-card-text">
                        <?php
$sql3 = "SELECT * FROM tblnotice";
$query3 = mysqli_query($conn, $sql3);
$results3 = mysqli_fetch_all($query3, MYSQLI_ASSOC);
$totnotice = mysqli_num_rows($query3);
?>
                          <span class="report-title">Total Class Notice</span>
                          <h4><?php echo htmlentities($totnotice);?></h4>
                          <a href="manage-notice.php"><span class="report-count"> View Notices</span></a>
                        </div>
                        <div class="inner-card-icon bg-warning">
                          <i class="icon-doc"></i>
                        </div>
                      </div>
                      <div class="col-md-6 col-xl report-inner-card">
                        <div class="inner-card-text">
                        <?php
$sql4 = "SELECT * FROM tblpublicnotice";
$query4 = mysqli_query($conn, $sql4);
$results4 = mysqli_fetch_all($query4, MYSQLI_ASSOC);
$totpublicnotice = mysqli_num_rows($query4);
?>
                          <span class="report-title">Total Public Notice</span>
                          <h4><?php echo htmlentities($totpublicnotice);?></h4>
                          <a href="manage-public-notice.php"><span class="report-count"> View PublicNotices</span></a>
                        </div>
                        <div class="inner-card-icon bg-primary">
                          <i class="icon-doc"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
           
            
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
         <?php include_once('includes/footer.php');?>
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
    <script src="vendors/chart.js/Chart.min.js"></script>
    <script src="vendors/moment/moment.min.js"></script>
    <script src="vendors/daterangepicker/daterangepicker.js"></script>
    <script src="vendors/chartist/chartist.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="js/dashboard.js"></script>
    <!-- End custom js for this page -->
  </body>
</html><?php }  ?>