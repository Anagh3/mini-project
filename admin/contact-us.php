<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (empty($_SESSION['sturecmsaid'])) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    $pagetitle = $_POST['pagetitle'];
    $pagedes = $_POST['pagedes'];
    $email = $_POST['email'];
    $mobnum = $_POST['mobnum'];

    $sql = "UPDATE tblpage SET PageTitle='$pagetitle', PageDescription='$pagedes', Email='$email', MobileNumber='$mobnum' WHERE PageType='contactus'";
    $query = mysqli_query($conn, $sql);

    if ($query) {
      echo '<script>alert("Contact us has been updated")</script>';
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Student Management System|| Update Contact Us</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel stylesheet href="vendors/flag-icon-css/css/flag-icon.min.css">
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
    <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
    <script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
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
              <h3 class="page-title">Update Contact Us</h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Update Contact Us</li>
                </ol>
              </nav>
            </div>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="text-align: center;">Update Contact Us</h4>
                    <form class="forms-sample" method="post">
                      <?php
                        $sql = "SELECT * FROM tblpage WHERE PageType='contactus'";
                        $query = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($query);
                      ?>
                      <div class="form-group">
                        <label for="exampleInputName1">Page Title:</label>
                        <input type="text" name="pagetitle" value="<?php echo $row['PageTitle']; ?>" class="form-control" required="true">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Page Description:</label>
                        <textarea type="text" name="pagedes" class="form-control" required="true"><?php echo $row['PageDescription']; ?></textarea>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Email:</label>
                        <input type="text" name="email" id="email" required="true" value="<?php echo $row['Email']; ?>" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Mobile Number:</label>
                        <input type="text" name="mobnum" id="mobnum" required="true" value="<?php echo $row['MobileNumber']; ?>" class="form-control" maxlength="10" pattern="[0-9]+">
                      </div>
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
