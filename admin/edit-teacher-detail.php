<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid']==0)) {
  header('location:logout.php');
  } else{
   if(isset($_POST['submit']))
  {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject']; 
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $teacherid = $_POST['teacherid'];
    $mobile = $_POST['mobile'];
    $altmobile = $_POST['altmobile'];
    $address = $_POST['address'];
    $eid=$_GET['editid'];

 $eid=$_GET['editid'];
$sql="update tblteacher set name='$name',email=' $email ',Subject='$subject',gender='$gender',dob='$dob',teacher_id=' $teacherid',mobile_number=' $mobile ',alternate_number='$altmobile ',address='$address' where id='$eid'";
$query=$conn->query($sql);
  echo '<script>alert("Student has been updated")</script>';
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
   
    <title>Student  Management System|| Update Students</title>
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
              <h3 class="page-title"> Update Teacher </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page"> Update Teacher</li>
                </ol>
              </nav>
            </div>
            <div class="row">
          
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="text-align: center;">Update  Teacher</h4>
                   
                    <form class="forms-sample" method="post" enctype="multipart/form-data">
                      <?php
  $eid=$_GET['editid'];
  $sql = "SELECT * from tblteacher where id=$eid";
  $query=mysqli_query($conn, $sql);
  $results=mysqli_fetch_all($query, MYSQLI_ASSOC);
  $cnt=1;
  if(mysqli_num_rows($query) > 0){
  foreach($results as $row) {
  ?>
     
                      <div class="form-group">
                        <label for="exampleInputName1">Teacher Name</label>
                        <input type="text" name="name" value="<?php  echo htmlentities($row['name']);?>" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Teacher Email</label>
                        <input type="text" name="email" value="<?php  echo htmlentities($row['email']);?>" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail3">Subject</label>
                        <select  name="subject" class="form-control" required='true'>
                          <option value="<?php  echo htmlentities($row['sub_id']);?>"><?php  echo htmlentities($row['subject']);?></option>
                          <?php
$sql2 = "SELECT * from tblsubject";
$query2 = $conn->query($sql2);
while ($row1 = $query2->fetch_assoc()) {
?>
<option value="<?php echo htmlentities($row1['sub_id']) ; ?>"><?php echo htmlentities($row1['subject']) . ' '; ?></option>
<?php
}
?>

                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Gender</label>
                        <select name="gender" value="" class="form-control" required='true'>
                          <option value="<?php  echo htmlentities($row['gender']);?>"><?php  echo htmlentities($row['gender']);?></option>
                          <option value="Male">Male</option>
                          <option value="Female">Female</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Date of Birth</label>
                        <input type="date" name="dob" value="<?php  echo htmlentities($row['dob']);?>" class="form-control" required='true'>
                      </div>
                     
                      <div class="form-group">
                        <label for="studentid">Teacher ID</label>
                        <input type="text" name="teacherid" value="<?php  echo htmlentities($row['teacher_id']);?>" class="form-control" readonly='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Teacher Photo</label>
                        <img src="images/<?php echo $row['photo'];?>" width="100" height="100" value="<?php  echo $row['photo'];?>"><a href="changeimage.php?editid=<?php echo $row['id'];?>"> &nbsp; Edit Image</a>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Contact Number</label>
                        <input type="text" name="mobile" value="<?php  echo htmlentities($row['mobile_number']);?>" class="form-control" required='true' maxlength="10" pattern="[0-9]+">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Alternate Contact Number</label>
                        <input type="text" name="altmobile" value="<?php  echo htmlentities($row['alternate_number']);?>" class="form-control" required='true' maxlength="10" pattern="[0-9]+">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Address</label>
                        <textarea name="address" class="form-control" required='true'><?php  echo htmlentities($row['Address']);?></textarea>
                      </div>
                   <h3>Login details</h3>
                   <?php
  $sql = "SELECT * from tblteacherlogin where id=$eid";
  $query=mysqli_query($conn, $sql);
  $results=mysqli_fetch_all($query, MYSQLI_ASSOC);
  $cnt=1;
  if(mysqli_num_rows($query) > 0)
  {
  foreach($results as $row2) {
  ?>
                   <div class="form-group">
                        <label for="exampleInputName1">User Name</label>
                        <input type="text" name="uname" value="<?php  echo htmlentities($row2['username']);?>" class="form-control" readonly='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Password</label>
                        <input type="Password" name="password" value="<?php  echo htmlentities($row2['password']);?>" class="form-control" readonly='true'>
                      </div><?php $cnt=$cnt+1;}} ?>
                      <button type="submit" class="btn btn-primary mr-2" name="submit">Update</button>
                     
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
</html><?php } }}?>

