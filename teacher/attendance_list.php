<?php
session_start();
$selectedClassName = $_SESSION['selectedClassName'];
$selectedSection = $_SESSION['selectedSection'];
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('includes/dbconnection.php');

    // Access stored session variables
    if (isset($_SESSION['selectedClassName']) && isset($_SESSION['selectedSection'])) {
    
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
       
        // Process attendance data
        if (
            isset($_POST['stud_id']) &&
            isset($_POST['attendance_date']) &&
            isset($_POST['subject']) &&
            isset($_POST['total_hours']) &&
            isset($_POST['attended_hours'])
        ) {
            // Retrieve other form data
            $attendance_date = $_POST['attendance_date'];
            $subject = $_POST['subject'];
           
            $student_ids = $_POST['stud_id'];
            $total_hours = $_POST['total_hours'];
            $attended_hours = $_POST['attended_hours'];
          
            // Prepare and execute insertion query
            $stmt = $conn->prepare("INSERT INTO tblattendance (stuID, AttendanceDate, sub_id, Total_class, attented_class) VALUES (?, ?, ?, ?, ?)");

            
            foreach ($student_ids as $key => $student_id) {
                $total_hour = $total_hours[$key];
                $attended_hour = $attended_hours[$key];
                // Adjust the bind_param and execute statements accordingly
                
            $stmt->bind_param("sssss", $student_id, $attendance_date, $subject, $total_hour, $attended_hour);
                $stmt->execute();
            }
        
            $stmt->close();
            $conn->close();
        
            echo "<script>alert('Attendance added successfully');</script>";
        } else {
            
            echo "Error: Incomplete form data.";
        }
    } else {
        echo "Session variables not set.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
     <title>Student Attendance</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="vendors/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="vendors/chartist/chartist.min.css">
    <link rel="stylesheet" href="css/style.css">
</head> 
<body>
<div class="container-scroller">
    <?php include_once('includes/header.php');?>
    <div class="container-fluid page-body-wrapper">
        <?php include_once('includes/sidebar.php');?>
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="container mt-5">
                    <h1 class="mb-4">Mark Attendance</h1>
                    <form method="post">
                        <div class="form-group">
                            <label for="attendance_date">Select Date:</label>
                            <input type="date" id="attendance_date" name="attendance_date" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="subject">Select Subject:</label>
                            <select name="subject" class="form-control" required>
                                <?php
                                $query_subjects = "SELECT * FROM tblsubject where ID IN (SELECT ID from tblclass where ClassName='$selectedClassName')";
                                $result_subjects = $conn->query($query_subjects);
                                while ($row_subject = $result_subjects->fetch_assoc()) {
                                    echo "<option value='" . $row_subject['sub_id'] . "'>" . $row_subject['subject'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Student Name</th>
                                    <th>Total Hours</th>
                                    <th>Attended Hours</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query_students = "SELECT s.* FROM tblstudent s
                                INNER JOIN tblclass c ON s.StudentClass = c.ID
                                WHERE c.ClassName = '$selectedClassName' AND c.Section = '$selectedSection'";

                                $result_students = $conn->query($query_students);
                                while ($row = $result_students->fetch_assoc()) {
                                ?>
                                <tr>
    <td><?php echo $row['StuID']; ?></td>
    <td><?php echo $row['StudentName']; ?></td>


   <input type="hidden" name="stud_id[]" class="form-control" value="<?php echo $row['ID']; ?>">


    <td>
        <input type="number" name="total_hours[]" class="form-control" required>
    </td>
    <td>
        <input type="number" name="attended_hours[]" class="form-control" required>
    </td>
</tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>

                        <button type="submit" class="btn btn-primary btn-lg btn-block">Submit Attendance</button>
                    </form>
                </div>
            </div>
            <footer>
                <!-- Footer content -->
            </footer>
        </div>
    </div>
</div>
<!-- Other scripts and footer content here -->
</body>
</html>
