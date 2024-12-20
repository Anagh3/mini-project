<?php
session_start();
//error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsstuid']==0)) {
  header('location:logout.php');
  } else{
   
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
   
    <title>Student Management System|| View Students Profile</title>
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
     <?php include_once('includes/header.php');?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
      <?php include_once('includes/sidebar.php');?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> View Students Profile </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page"> View Students Profile</li>
                </ol>
              </nav>
            </div>
            <div class="row">
          
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    
                    <table border="1" class="table table-bordered mg-b-0">
                    <?php
session_start();
include('includes/dbconnection.php');

$sid = $_SESSION['sturecmsstuid'];
$sql = "SELECT tblstudent.StudentName, tblstudent.StudentEmail, tblstudent.StudentClass, tblstudent.Gender, tblstudent.DOB, tblstudent.StuID, tblstudent.FatherName, tblstudent.MotherName, tblstudent.ContactNumber, tblstudent.AltenateNumber, tblstudent.Address, tblstudent.UserName, tblstudent.Password, tblstudent.Image, tblstudent.DateofAdmission, tblclass.ClassName, tblclass.Section FROM tblstudent JOIN tblclass ON tblclass.ID = tblstudent.StudentClass WHERE tblstudent.StuID = '$sid'";
$query = mysqli_query($conn, $sql);

if ($query) {
    $row = mysqli_fetch_assoc($query);
    if ($row) {
        echo '<tr align="center" class="table-warning">';
        echo '<td colspan="4" style="font-size:20px;color:blue">Students Details</td></tr>';
        
        echo '<tr class="table-info">';
        echo '<th>Student Name</th><td>' . $row['StudentName'] . '</td>';
        echo '<th>Student Email</th><td>' . $row['StudentEmail'] . '</td></tr>';
        
        echo '<tr class="table-warning">';
        echo '<th>Student Class</th><td>' . $row['ClassName'] . ' ' . $row['Section'] . '</td>';
        echo '<th>Gender</th><td>' . $row['Gender'] . '</td></tr>';
        
        echo '<tr class="table-danger">';
        echo '<th>Date of Birth</th><td>' . $row['DOB'] . '</td>';
        echo '<th>Student ID</th><td>' . $row['StuID'] . '</td></tr>';
        
        echo '<tr class="table-success">';
        echo '<th>Father Name</th><td>' . $row['FatherName'] . '</td>';
        echo '<th>Mother Name</th><td>' . $row['MotherName'] . '</td></tr>';
        
        echo '<tr class="table-primary">';
        echo '<th>Contact Number</th><td>' . $row['ContactNumber'] . '</td>';
        echo '<th>Alternate Number</th><td>' . $row['AltenateNumber'] . '</td></tr>';
        
        echo '<tr class="table-progress">';
        echo '<th>Address</th><td>' . $row['Address'] . '</td>';
        echo '<th>User Name</th><td>' . $row['UserName'] . '</td></tr>';
        
        echo '<tr class="table-info">';
        echo '<th>Profile Pics</th><td><img src="../admin/images/' . $row['Image'] . '"></td>';
        echo '<th>Date of Admission</th><td>' . $row['DateofAdmission'] . '</td></tr>';
    } else {
        echo "No data found.";
    }
} else {
    echo "Error executing query: " . mysqli_error($conn);
}
?>

</table>
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
</html><?php }  ?>