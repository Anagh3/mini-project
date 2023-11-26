<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsstuid']) == 0) {
    header('location:logout.php');
    exit();
} else {
    $attendanceData = []; // Initialize attendance data
    $uid = $_SESSION['sturecmsuid'];
    if (isset($_POST['filterSummary'])) {
        // Get selected date and subject
        $selectedDate = $_POST['selectedDate'];
        $selectedSubject = $_POST['selectedSubject'];

        // Fetch attendance summary for selected date and subject
        $summaryQuery = "SELECT * FROM tblattendance WHERE AttendanceDate = '$selectedDate' AND sub_id = '$selectedSubject' AND StuID=$uid";
        $summaryResult = mysqli_query($conn, $summaryQuery);

        // Process summary data
        while ($row = mysqli_fetch_assoc($summaryResult)) {
            $attendanceData[] = $row;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Attendance</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="vendors/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="vendors/chartist/chartist.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
</head>
<body>
    <div class="container-scroller">
        <?php include_once('includes/header.php');?>
        <div class="container-fluid page-body-wrapper">
            <?php include_once('includes/sidebar.php');?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="container mt-5">
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <!-- Filter form -->
                                <form method="POST" action="">
                                    <div class="form-group">
                                        <label for="selectDate">Select Date:</label>
                                        <input type="date" name="selectedDate" id="selectDate" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="selectSubject">Select Subject:</label>
                                        <select name="selectedSubject" id="selectSubject" class="form-control">
                                            <!-- Fetch subjects from tblsubject -->
                                            <?php
                                            $subjectQuery = "SELECT * FROM tblsubject where ID IN(select StudentClass from tblstudent where ID='$uid' )";
                                            $subjectResult = mysqli_query($conn, $subjectQuery);
                                            while ($subjectRow = mysqli_fetch_assoc($subjectResult)) {
                                                echo "<option value='" . $subjectRow['sub_id'] . "'>" . $subjectRow['subject'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <input type="submit" name="filterSummary" value="Filter" class="btn btn-primary">
                                </form>

                                <!-- Display attendance summary based on filter -->
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Total Class</th>
                                            <th>Attended Class</th>
                                            <th>Absent Class</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
foreach ($attendanceData as $row) {
    $absentClass = $row['Total_class'] - $row['attented_class'];
    $attendancePercentage = ($row['attented_class'] / $row['Total_class']) * 100;
    echo "<tr>";
    echo "<td>" . $row['AttendanceDate'] . "</td>";
    echo "<td>" . $row['Total_class'] . "</td>";
    echo "<td>" . $row['attented_class'] . "</td>";
    echo "<td>" . $absentClass . "</td>";
    echo "<td>" . number_format($attendancePercentage, 2) . "%</td>"; // Display percentage with two decimal places
    echo "</tr>";
}
?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Include footer and necessary scripts -->
                <?php include_once('includes/footer.php');?>
            </div>
        </div>
    </div>
</body>
</html>
<?php
}
?>
