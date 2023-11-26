
<nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="profile-image">
                  <img class="img-xs rounded-circle" src="images/faces/face8.jpg" alt="profile image">
                  <div class="dot-indicator bg-success"></div>
                </div>
                <div class="text-wrapper">
                <?php
  include('includes/dbconnection.php');
$uid = $_SESSION['sturecmsuid'];


$sql = "SELECT * FROM tblstudent WHERE ID = '$uid'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <p class="profile-name"><?php echo htmlentities($row['StudentName']); ?></p>
        <p class="designation"><?php echo htmlentities($row['StudentEmail']); ?></p>
        <?php
    }
}

?>
 </div>
             
              </a>
            </li>
            <li class="nav-item nav-category">
              <span class="nav-link">Dashboard</span>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="dashboard.php">
                <span class="menu-title">Dashboard</span>
                <i class="icon-screen-desktop menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="view-notice.php">
                <span class="menu-title">View Notice</span>
                <i class="icon-book-open menu-icon"></i>
              </a>
            </li>
            
            <li class="nav-item">
              <a class="nav-link" href="viewdate_att.php">
                <span class="menu-title">View Attendace</span>
                <i class="icon-screen-desktop menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="att_report.php">
                <span class="menu-title">Attendance report</span>
                <i class="icon-screen-desktop menu-icon"></i>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="list_notes.php">
                <span class="menu-title">View Notes</span>
                <i class="icon-screen-desktop menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="view_marks.php">
                <span class="menu-title">View Marks</span>
                <i class="icon-book-open menu-icon"></i>
              </a>
            </li>


          </ul>
        </nav>