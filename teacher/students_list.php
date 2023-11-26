<?php
session_start(); // Start the session (if not started already)
include('includes/dbconnection.php');

// Access stored session variables
if (isset($_SESSION['selectedClassName']) && isset($_SESSION['selectedSection'])) {
    $selectedClassName = $_SESSION['selectedClassName'];
    $selectedSection = $_SESSION['selectedSection'];
  
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch students belonging to the selected class and section
    $query = "SELECT s.* FROM tblstudent s
    INNER JOIN tblclass c ON s.StudentClass = c.ID
    WHERE c.ClassName = '$selectedClassName' AND c.Section = '$selectedSection'";

    $result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Marks</title>
  
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
        <!-- Include Header and Sidebar -->
        <?php include_once('includes/header.php');?>
        <div class="container-fluid page-body-wrapper">
        <?php include_once('includes/sidebar.php');?>
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="container mt-5">
                    <div class="row">
                        <div class="col-md-10 offset-md-2">
                            
        <form method="post">
        <table class="table table-bordered">
                <thead>
                <tr>
                     <th colspan="2" style="text-align: center; font-weight: bold; font-size: 24px;">Upload Marks</th>
                </tr>
                    <tr>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Subject</th>
                        <th>Exam Name</th>
                        <th>Marks</th>
                        <th>Max Marks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        $ID = $row['ID'];
                        echo "<td>" . $row['StuID'] . "</td>";
                        echo "<td>" . $row['StudentName'] . "</td>";
                        echo "<td>
                            <input type='hidden' name='student_id[]' value='" . $row['StuID'] . "'>
                            <select name='subject[]' class='form-control' required>";
        
                        $sql2 = "SELECT * from tblsubject where ID IN (SELECT ID from tblclass where ClassName= '$selectedClassName')";
                        $query2 = $conn->query($sql2);
                        while ($row2 = $query2->fetch_assoc()) {
                            echo "<option value='" . htmlentities($row2['sub_id']) . "'>" . htmlentities($row2['subject']) . "</option>";
                        }
                        
                        echo "</select></td>";
                        echo "<td><input type='text' name='exam_name[]' class='form-control' required></td>";
                        echo "<td><input type='number' name='marks[]' class='form-control' required></td>";
                        echo "<td><input type='number' name='max_marks[]' class='form-control' required></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
            
        </form>
    </div>
</div>

    </div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['student_id']) && isset($_POST['subject']) && isset($_POST['exam_name']) && isset($_POST['marks']) && isset($_POST['max_marks'])) {
        // Prepare the SQL statement to insert data into tblmarks
        $stmt = $conn->prepare("INSERT INTO tblmarks (ID, exam, mark, max_mark, sub_id) VALUES (?, ?, ?, ?, ?)");
     
        // Bind parameters and execute for each set of data
        $stmt->bind_param("sssss", $ID, $examName, $marks, $maxMarks, $subject);

        foreach ($_POST['student_id'] as $key => $studentID) {
            // Use $row['ID'] from $query as StudentID
            $subject = $_POST['subject'][$key];
            $examName = $_POST['exam_name'][$key];
            $marks = $_POST['marks'][$key];
            $maxMarks = $_POST['max_marks'][$key];

            $stmt->execute();
        }

        $stmt->close();
        $conn->close();

        // Redirect or show a success message after inserting data
        echo "<script>alert('Mark Inserted Successfully');</script>";
        exit();
    } else {
        echo "Error: Incomplete form data.";
    }
}
?>

</body>
</html>

<?php
} else {
    echo "Session variables not set.";
}
?>
