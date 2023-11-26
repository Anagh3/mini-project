<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsstuid']) == 0) {
    header('location:logout.php');
    exit();
} else {
    $uid = $_SESSION['sturecmsuid'];
    $marksData = []; // Initialize marks data

    if (isset($_POST['filterMarks'])) {
        // Get selected subject
        $selectedSubject = $_POST['selectedSubject'];

        // Fetch marks for the selected subject and user ID
        $marksQuery = "SELECT tm.mark, tm.exam, tm.max_mark, ts.subject
        FROM tblmarks tm
        INNER JOIN tblsubject ts ON tm.sub_id = ts.sub_id
        WHERE tm.sub_id = '$selectedSubject' AND tm.ID = '$uid'";

        $marksResult = mysqli_query($conn, $marksQuery);

        // Process marks data
        while ($marksRow = mysqli_fetch_assoc($marksResult)) {
            $marksData[] = $marksRow;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Marks</title>
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
        <?php include_once('includes/header.php'); ?>
        <div class="container-fluid page-body-wrapper">
            <?php include_once('includes/sidebar.php'); ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="container mt-5">
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <!-- Filter form -->
                                <form method="POST" action="">
                                    <div class="form-group">
                                        <label for="selectSubject">Select Subject:</label>
                                        <select name="selectedSubject" id="selectSubject" class="form-control">
                                            <!-- Fetch subjects from tblsubject -->
                                            <?php
                                            $subjectQuery = "SELECT * FROM tblsubject WHERE ID IN (SELECT StudentClass FROM tblstudent WHERE ID='$uid')";
                                            $subjectResult = mysqli_query($conn, $subjectQuery);
                                            while ($subjectRow = mysqli_fetch_assoc($subjectResult)) {
                                                echo "<option value='" . $subjectRow['sub_id'] . "'>" . $subjectRow['subject'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <input type="submit" name="filterMarks" value="Fetch Marks" class="btn btn-primary">
                                </form>

                                <!-- Display marks based on filter -->
                                <table class="table">
                                    <thead>
                                        <tr>
                                          <th>Subject</th>
                                          <th>Exam</th>
                                            <th>Mark</th>
                                            <th>Max</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($marksData as $row) {
                                            echo "<tr>";
                                            echo "<td>" . $row['subject'] . "</td>";
                                            echo "<td>" . $row['exam'] . "</td>";
                                            echo "<td>" . $row['mark'] . "</td>";
                                            echo "<td>" . $row['max_mark'] . "</td>";
                                           
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
                <?php include_once('includes/footer.php'); ?>
            </div>
        </div>
    </div>
</body>
</html>
<?php
}
?>
