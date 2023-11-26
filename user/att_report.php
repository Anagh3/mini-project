<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsstuid']) == 0) {
    header('location:logout.php');
    exit();
} else {
    $uid = $_SESSION['sturecmsuid'];
    if (isset($_POST['filterSummary'])) {
        $attendanceData = []; // Initialize attendance data

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

        // Fetch subjects only if the attendance data retrieval was successful
        if ($summaryResult) {
            $subjectQuery = "SELECT * FROM tblsubject WHERE ID IN (SELECT StudentClass FROM tblstudent WHERE ID='$uid')";
            $subjectResult = mysqli_query($conn, $subjectQuery);

            if ($subjectResult) {
                // Rest of the code to display the attendance data in a table
                // ...
            } else {
                echo "Error fetching subjects: " . mysqli_error($conn);
            }
        } else {
            echo "Error fetching attendance data: " . mysqli_error($conn);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<!-- Rest of your HTML code -->

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

    <style>
        .table{
            margin-top:60px;
            
        }

    </style>
</head>

<body>
    <div class="container-scroller">
        <?php include_once('includes/header.php'); ?>
        <div class="container-fluid page-body-wrapper">
            <?php include_once('includes/sidebar.php'); ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="container mt-5">
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <form method="POST" action="">
                                    <!-- Your filter form -->
                                </form>
                                <h3>75% attendance is manditory</h3>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Subject</th>
                                                <th>Total Classes Taken</th>
                                                <th>Total Classes Attended</th>
                                                <th>Attendance Percentage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $subjectQuery = "SELECT * FROM tblsubject WHERE ID IN (SELECT StudentClass FROM tblstudent WHERE ID='$uid')";
                                            $subjectResult = mysqli_query($conn, $subjectQuery);
                                
                                            while ($subjectRow = mysqli_fetch_assoc($subjectResult)) {
                                                $subjectId = $subjectRow['sub_id'];
                                                $attendanceQuery = "SELECT * FROM tblattendance WHERE sub_id = '$subjectId' AND StuID='$uid'";
                                                $attendanceResult = mysqli_query($conn, $attendanceQuery);

                                                $totalAttendedClasses = 0;
                                                $totalClasses = 0;

                                                while ($attendanceRow = mysqli_fetch_assoc($attendanceResult)) {
                                                    $totalAttendedClasses += $attendanceRow['attented_class'];
                                                    $totalClasses += $attendanceRow['Total_class'];
                                                }

                                                $attendancePercentage = 0; // Default value if total classes are zero

                                                // Check if total classes are not zero to avoid division by zero
                                                if ($totalClasses > 0) {
                                                    $attendancePercentage = ($totalAttendedClasses / $totalClasses) * 100;
                                                }

                                                echo "<tr>";
                                                echo "<td>" . $subjectRow['subject'] . "</td>";
                                                echo "<td>" . $totalClasses . "</td>";
                                                echo "<td>" . $totalAttendedClasses . "</td>";
                                                echo "<td>" . number_format($attendancePercentage, 2) . "%</td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
}
?>







<table class="table table-bordered">
    <thead>
        <tr>
            <th>Subjects Below 75%</th>
            <th>Subjects Above 75%</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <ul>
                    <?php
                    $subjectQuery = "SELECT * FROM tblsubject WHERE ID IN (SELECT StudentClass FROM tblstudent WHERE ID='$uid')";
                    $subjectResult = mysqli_query($conn, $subjectQuery);

                    while ($subjectRow = mysqli_fetch_assoc($subjectResult)) {
                        $subjectId = $subjectRow['sub_id'];
                        $attendanceQuery = "SELECT * FROM tblattendance WHERE sub_id = '$subjectId' AND StuID='$uid'";
                        $attendanceResult = mysqli_query($conn, $attendanceQuery);

                        $totalAttendedClasses = 0;
                        $totalClasses = 0;

                        while ($attendanceRow = mysqli_fetch_assoc($attendanceResult)) {
                            $totalAttendedClasses += $attendanceRow['attented_class'];
                            $totalClasses += $attendanceRow['Total_class'];
                        }

                        $attendancePercentage = 0; // Default value if total classes are zero

                        // Check if total classes are not zero to avoid division by zero
                        if ($totalClasses > 0) {
                            $attendancePercentage = ($totalAttendedClasses / $totalClasses) * 100;
                        }

                        // Display subject names based on their attendance
                        if ($attendancePercentage < 75) {
                            echo "<li>" . $subjectRow['subject'] . "</li>";
                        }
                    }
                    ?>
                </ul>
            </td>
            <td>
                <ul>
                    <?php
                    // Reset subjectResult to the beginning to loop through again
                    mysqli_data_seek($subjectResult, 0);

                    while ($subjectRow = mysqli_fetch_assoc($subjectResult)) {
                        $subjectId = $subjectRow['sub_id'];
                        $attendanceQuery = "SELECT * FROM tblattendance WHERE sub_id = '$subjectId' AND StuID='$uid'";
                        $attendanceResult = mysqli_query($conn, $attendanceQuery);

                        $totalAttendedClasses = 0;
                        $totalClasses = 0;

                        while ($attendanceRow = mysqli_fetch_assoc($attendanceResult)) {
                            $totalAttendedClasses += $attendanceRow['attented_class'];
                            $totalClasses += $attendanceRow['Total_class'];
                        }

                        $attendancePercentage = 0; // Default value if total classes are zero

                        // Check if total classes are not zero to avoid division by zero
                        if ($totalClasses > 0) {
                            $attendancePercentage = ($totalAttendedClasses / $totalClasses) * 100;
                        }

                        // Display subject names based on their attendance
                        if ($attendancePercentage >= 75) {
                            echo "<li>" . $subjectRow['subject'] . "</li>";
                        }
                    }
                    ?>
                </ul>
            </td>
        </tr>
    </tbody>
</table>