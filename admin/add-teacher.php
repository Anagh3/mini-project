<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid']) == 0) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject']; // Update field name
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $teacherid = $_POST['teacherid'];
    $mobile = $_POST['mobile'];
    $altmobile = $_POST['altmobile'];
    $address = $_POST['address'];
    $uname = $_POST['uname'];
    $password = $_POST['password'];

    // Check if an image was uploaded
    if (isset($_FILES['image'])) {
      $image = $_FILES['image']['name'];
      $image_tmp = $_FILES['image']['tmp_name'];

      // Check for valid file extensions
      $allowed_extensions = array(".jpg", ".jpeg", ".png", ".gif");
      $extension = strtolower(substr($image, strrpos($image, ".")));
      
      if (in_array($extension, $allowed_extensions)) {
        $image = time() . $extension;

        // Move the uploaded file to the images directory
        move_uploaded_file($image_tmp, "images/" . $image);

        // Create and execute a prepared statement to insert data into the database
        echo "<script>console.log('done1')</script>";
      $sql = "INSERT INTO tblteacher (name, email, subject, dob, gender, teacher_id, mobile_number, alternate_number, address, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssss", $name, $email, $subject, $dob, $gender, $teacherid, $mobile, $altmobile, $address, $image);
$stmt->execute();
echo "<script>console.log('done2')</script>";
if ($stmt->affected_rows > 0) {
    // Get the teacher_id of the newly inserted row
    $teacher_id = $stmt->insert_id;

    // Insert into tblteacherlogin
    $sql1 = "INSERT INTO tblteacherlogin (id, username, password) VALUES (?, ?, ?)";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("iss", $teacher_id, $uname, $password);
    $stmt1->execute();

          if ($stmt1->affected_rows > 0) {
            echo '<script>alert("Teacher has been added.")</script>';
            echo "<script>window.location.href = 'add-students.php'</script>";
          } else {
            echo '<script>alert("Something Went Wrong. Please try again")</script>';
          }
        } else {
          echo '<script>alert("Something Went Wrong. Please try again")</script>';
        }
      } else {
        echo "<script>alert('Image has an invalid format. Only jpg / jpeg / png / gif format allowed');</script>";
      }
    } else {
      echo "<script>alert('Please select an image');</script>";
    }
  }
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
   
    <title>Student  Management System|| Add Teacher</title>
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
              <h3 class="page-title"> Add Teacher </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page"> Add Teacher</li>
                </ol>
              </nav>
            </div>
            <div class="row">
          
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="text-align: center;">Add Teachers</h4>
                   
                    <form class="forms-sample" method="post" enctype="multipart/form-data">
                      
                      <div class="form-group">
                        <label for="exampleInputName1">Teacher Name</label>
                        <input type="text" name="name" value="" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Teacher Email</label>
                        <input type="text" name="email" value="" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail3">Teaching Subject</label>
                        <select  name="subject" class="form-control" required='true'>
                          <option value="">Select Subject</option>
                          <?php
$sql2 = "SELECT * from    tblsubject ";
$query2 = mysqli_query($conn, $sql2);
while ($row1 = mysqli_fetch_array($query2)) {
    ?>
    <option value="<?php echo htmlentities($row1['sub_id']); ?>"><?php echo htmlentities($row1['subject']); ?> </option>
    <?php
}    ?>      </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Gender</label>
                        <select name="gender" value="" class="form-control" required='true'>
                          <option value="">Choose Gender</option>
                          <option value="Male">Male</option>
                          <option value="Female">Female</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Date of Birth</label>
                        <input type="date" name="dob" value="" class="form-control" required='true'>
                      </div>
                     
                      <div class="form-group">
                        <label for="exampleInputName1">Teacher ID</label>
                        <input type="text" name="teacherid" value="" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Teacher Photo</label>
                        <input type="file" name="image" value="" class="form-control" required='true'>
                      </div>
                     
                      <div class="form-group">
                        <label for="exampleInputName1">Contact Number</label>
                        <input type="text" name="mobile" value="" class="form-control" required='true' maxlength="10" pattern="[0-9]+">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Alternate Contact Number</label>
                        <input type="text" name="altmobile" value="" class="form-control" required='true' maxlength="10" pattern="[0-9]+">
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1">Address</label>
                        <textarea name="address" class="form-control" required='true'></textarea>
                      </div>
<h3>Login details</h3>
<div class="form-group">
                        <label for="exampleInputName1">User Name</label>
                        <input type="text" name="uname" value="" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Password</label>
                        <input type="Password" name="password" value="" class="form-control" required='true'>
                      </div>
                      <button type="submit" class="btn btn-primary mr-2" name="submit">Add</button>
                     
                    </form>
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
</html><?php   ?>