<?php
session_start();
//error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsstuid']) == 0) {
    header('location:logout.php');
} else {
?>
<?php
$uid = $_SESSION['sturecmsuid'];
$sql = "SELECT * FROM tblstudent WHERE ID='$uid'";
$query = mysqli_query($conn, $sql);
if ($query) {
    $row = mysqli_fetch_assoc($query);
    $ID = $row['ID'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Upload Files</title>
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
                                <!-- Dropdown to select subject -->
                                <form method="POST">
                                    <div class="form-group">
                                        <label for="subjectSelection">Select Subject:</label>
                                        <select name="selectedSubject" class="form-control" id="subjectSelection">  
                                        <option value="" disabled selected>Select Subject</option>
                                            <?php
                                            // Fetch subjects from tblsubject
                                            $subjectQuery = "SELECT subject FROM tblsubject where ID IN(select StudentClass from tblstudent where ID='$uid' )";
                                            $subjectResult = $conn->query($subjectQuery);
                                            while ($subjectRow = $subjectResult->fetch_assoc()) {
                                                $subject = $subjectRow['subject'];
                                                echo "<option value='$subject'>$subject</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <!-- Dropdown to select section -->
                                    <div class="form-group">
                                        <label for="sectionSelection">Select Section:</label>
                                        <select name="selectedSection" class="form-control" id="sectionSelection">
                                        <option value="" disabled selected>Select Section</option>
                                            <?php
                                            // Fetch sections from tblclass
                                            $sectionQuery = "SELECT DISTINCT Section FROM tblclass";
                                            $sectionResult = $conn->query($sectionQuery);
                                            while ($sectionRow = $sectionResult->fetch_assoc()) {
                                                $section = $sectionRow['Section'];
                                                echo "<option value='$section'>$section</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </form>

                                <!-- Display notes based on selected subject and section -->
                                <table class="table table-bordered mt-4">
                                    <thead>
                                        <tr>
                                            <th colspan="2" style="text-align: center; font-weight: bold; font-size: 24px;"><?php echo isset($_POST['selectedSubject']) ? $_POST['selectedSubject'] . ' Notes' : ''; ?></th>
                                        </tr>
                                        <tr>
                                            <th>Section</th>
                                            <th>Remarks</th>
                                            <th>File</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Process when form is submitted
                                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                            if (isset($_POST['selectedSubject']) && isset($_POST['selectedSection'])) {
                                                $selectedSubject = $_POST['selectedSubject'];
                                                $selectedSection = $_POST['selectedSection'];
                                                // Fetch data from tblnotes table based on selected subject and section
                                                $sql = "SELECT * FROM tblnotes WHERE ClassName = (SELECT ClassName FROM tblstudent WHERE ID=$ID) AND Subject = '$selectedSubject' AND Section = '$selectedSection' ORDER BY Section";
                                                $result = $conn->query($sql);

                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<tr>";
                                                        echo "<td>" . $row['Section'] . "</td>";
                                                        echo "<td>" . $row['remarks'] . "</td>";
                                                        echo "<td><a href='../uploads/" . $row['file'] . "'>Download</a></td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='2'>No notes available</td></tr>";
                                                }
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer and necessary scripts -->
                <?php include_once('includes/footer.php'); ?>
            </div>
        </div>

</body>

</html>
<?php } ?>
