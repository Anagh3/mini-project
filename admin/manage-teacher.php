<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid']==0)) {
  header('location:logout.php');
  } else{
   // Code for deletion
   if (isset($_GET['delid'])) {
    $rid = intval($_GET['delid']);

    // Deletion query for tblteacher
    $sql_teacher = "DELETE FROM tblteacher WHERE id = $rid";

    // Deletion query for tblteacherlogin
    $sql_teacherlogin = "DELETE FROM tblteacherlogin WHERE id = $rid";

    // Execute the deletion queries
    $query_teacher = $conn->query($sql_teacher);
    $query_teacherlogin = $conn->query($sql_teacherlogin);

    if ($query_teacher && $query_teacherlogin) {
        echo "<script>alert('Data deleted');</script>"; 
        echo "<script>window.location.href = 'manage-teacher.php'</script>";     
    } else {
        echo "<script>alert('Something went wrong');</script>"; 
        echo "<script>window.location.href = 'manage-teacher.php'</script>";     
        echo "$rid";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
   
    <title>Student  Management System|||Manage Students</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="./vendors/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="./vendors/chartist/chartist.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="./css/style.css">
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
             <div class="page-header">
              <h3 class="page-title"> Manage Teacher </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page"> Manage Teacher</li>
                </ol>
              </nav>
            </div>
            <div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-sm-flex align-items-center mb-4">
                      <h4 class="card-title mb-sm-0">Manage Teacher</h4>
                      <a href="#" class="text-dark ml-auto mb-3 mb-sm-0"> View all Teachers</a>
                    </div>
                    <div class="table-responsive border rounded p-1">
                      <table class="table">
                        <thead>
                          <tr>
                            <th class="font-weight-bold">S.No</th>
                            <th class="font-weight-bold">Teacher ID</th>
                            <th class="font-weight-bold">Teacher Subject</th>
                            <th class="font-weight-bold">Teacher Name</th>
                            <th class="font-weight-bold">Teacher Email</th>
                            <th class="font-weight-bold">Date-of-Birth</th>
                            <th class="font-weight-bold">Action</th>
                            
                          </tr>
                        </thead>
                        <tbody>
                        <?php
if (isset($_GET['pageno'])) {
  $pageno = $_GET['pageno'];
} else {
  $pageno = 1;
}

// Formula for pagination
$no_of_records_per_page = 15;
$offset = ($pageno-1) * $no_of_records_per_page;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get the total number of rows
$sql = "SELECT COUNT(*) FROM tblteacher";
$result = $conn->query($sql);
$total_rows = $result->fetch_row()[0];

// Calculate the total number of pages
$total_pages = ceil($total_rows / $no_of_records_per_page);

// Get the students for the current page

$sql = "SELECT t.*,t.id as tid, s.subject
FROM tblteacher t
JOIN tblsubject s ON t.subject  = s.sub_id;";
$result = $conn->query($sql);

$cnt = 1;
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
?>
    <tr>
      <td><?php echo htmlentities($cnt); ?></td>
      <td><?php echo htmlentities($row['id']); ?></td>
      <td><?php echo htmlentities($row['subject']); ?> </td>
      <td><?php echo htmlentities($row['name']); ?> </td>
      <td><?php echo htmlentities($row['email']); ?></td>
      <td><?php echo htmlentities($row['dob']); ?></td>
      <td>
        <div><a href="edit-teacher-detail.php?editid=<?php echo htmlentities($row['tid']); ?>"><i class="icon-eye"></i></a> || <a href="manage-teacher.php?delid=<?php echo $row['tid']; ?>" onclick="return confirm('Do you really want to Delete ?');"> <i class="icon-trash"></i></a></div>
      </td>
    </tr>
<?php
    $cnt++;
  }
}

// Close the connection
?>
                        </tbody>
                      </table>
                    </div>
                    <div align="left">
    <ul class="pagination" >
        <li><a href="?pageno=1"><strong>First></strong></a></li>
        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>"><strong style="padding-left: 10px">Prev></strong></a>
        </li>
        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>"><strong style="padding-left: 10px">Next></strong></a>
        </li>
        <li><a href="?pageno=<?php echo $total_pages; ?>"><strong style="padding-left: 10px">Last</strong></a></li>
    </ul>
</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
         <?php include_once('includes/footer.php');
         ?>
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
    <script src="./vendors/chart.js/Chart.min.js"></script>
    <script src="./vendors/moment/moment.min.js"></script>
    <script src="./vendors/daterangepicker/daterangepicker.js"></script>
    <script src="./vendors/chartist/chartist.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="./js/dashboard.js"></script>
    <!-- End custom js for this page -->
  </body>
</html><?php }  ?>