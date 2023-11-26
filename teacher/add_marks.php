<?php
session_start();
include('includes/dbconnection.php');

// Assuming the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the selected class and subject from the form
    $selectedClass = $_POST['class'];
    $selectedSubject = $_POST['subject'];

    // Fetch the ClassName and Section from tblclass based on the selected values
    $sql = "SELECT * FROM tblclass WHERE ClassName = '$selectedClass' AND Section = '$selectedSubject'";
    $query = $conn->query($sql);

    if ($query->num_rows > 0) {
        $row = $query->fetch_assoc();

        // Store ClassName and Section in session variables
        $_SESSION['selectedClassName'] = $row['ClassName'];
        $_SESSION['selectedSection'] = $row['Section'];

        // Redirect to another page after setting session variables
        header("Location: students_list.php");
        exit(); // Ensure script execution stops after redirection
    } else {
        echo "No matching class and section found.";
    }
}
?>

<!-- Your HTML code remains unchanged -->


<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Your existing head content -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="vendors/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="vendors/chartist/chartist.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Add any additional custom styles here */
        /* Example: Add hover effect for button */
        .btn-primary:hover {
            background-color: #0069d9;
            color: white;
        }
    </style>
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
                            <div class="col-md-8 offset-md-2">
                                <table class="table table-bordered">
                                    <thead>
                                        <!-- Your table header content -->
                                    </thead>
                                    <tbody>
                                        <form id="uploadForm" method="post" enctype="multipart/form-data">
                                            <tr>
                                                <td><label for="class">Select Batch:</label></td>
                                                <td>
                                                    <div class="form-group">
                                                        <select name="class" id="SelectClass" class="form-control" required='true'>
                                                            <?php
                                                            $sql2 = "SELECT * FROM tblclass";
                                                            $query2 = $conn->query($sql2);
                                                            while ($row2 = $query2->fetch_assoc()) {
    
                                                                echo '<option value="' . htmlentities($row2['ClassName']) . '">' . htmlentities($row2['ClassName']) . '</option>';

                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label for="subject">Select year:</label></td>
                                                <td>
                                                    <div class="form-group">
                                                        <select name="subject" id="sectionselection" class="form-control" required='true'>
                                                        <?php
                                                            $sql2 = "SELECT * FROM tblclass";
                                                            $query2 = $conn->query($sql2);
                                                            while ($row2 = $query2->fetch_assoc()) {
                                                                echo '<option value="' . htmlentities($row2['Section']) . '">' . htmlentities($row2['Section']) . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="text-center">
                                                    <button type="submit" class="btn btn-primary">Show</button>
                                                </td>
                                            </tr>
                                        </form>
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
    </div>
    <script>
        // Your JavaScript code
    </script>
</body>
</html>
