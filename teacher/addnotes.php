<?php
session_start();
//error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsaid']==0)) {
  header('location:logout.php');
  } else
{
     ?>
  <?php
include('includes/dbconnection.php');

// Populate subjects based on selected batch
if (isset($_POST['batch'])) {
    $selectedBatch = $_POST['batch'];
    // Your code for populating subjects based on batch
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDirectory = '../uploads/';
    $class = $_POST['class'];
    $year = $_POST['year'];
    $subject = $_POST['subject'];
    $additionalInfo = $_POST['additionalInfo'];

    // Handling file upload
    $file = $_FILES['file']; // Uploaded file information
    if (is_array($file['name'])) {
        // Handle multiple file uploads if 'name' is an array
        foreach ($file['name'] as $index => $fileName) {
            $targetPath = $uploadDirectory . basename($fileName);
            // Your file handling logic goes here for each uploaded file
            // Move each uploaded file to the desired directory
        }
    } else {
        // If only one file is uploaded, process it as a single file
        $fileName = $file['name'];
        $targetPath = $uploadDirectory . basename($fileName);
        // Your file handling logic for a single uploaded file
        // Move the uploaded file to the desired directory
    }
    $targetPath = $uploadDirectory . basename($fileName);
    if (move_uploaded_file($file['tmp_name'][$index], $targetPath)) {
        // File uploaded successfully, now insert data into tblnotes
        $queryInsert = "INSERT INTO tblnotes (ClassName, Section, subject, file, remarks) VALUES ('$class', '$year', '$subject', '$fileName', '$additionalInfo')";
        if ($conn->query($queryInsert)) {
            echo "<script>alert('Data inserted successfully!');</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error in uploading file.";
    }
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
                                    <tr>
                                        <th colspan="2" style="text-align: center; font-weight: bold; font-size: 24px;">Upload Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <form id="uploadForm" method="post" enctype="multipart/form-data">
                                    <tr>
                                                <td><label for="class">Select Batch:</label></td>
                                                <td>
                                                    <div class="form-group" >
                                                        <select  name="class" id="SelectClass" class="form-control" required='true'>
                                                            <option value="NA">Select Class</option>
                                                            <?php
                                                            $sql2 = "SELECT * from tblclass";
                                                            $query2 = $conn->query($sql2);
                                                            while ($row2 = $query2->fetch_assoc()) {
                                                            ?>
                                                            <option value="<?php echo htmlentities($row2['ID']) ; ?>"><?php echo htmlentities($row2['ClassName']) . ' '; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td><label for="year">Select Year:</label></td>
                                                <td>
                                                    <div class="form-group" >
                                                        <select  name="year" class="form-control" required='true'>
                                                        <option value="NA">Select Year</option>
                                                            <?php
                                                            $sql2 = "SELECT DISTINCT Section from tblclass";
                                                            $query2 = $conn->query($sql2);
                                                            while ($row2 = $query2->fetch_assoc()) {
                                                            ?>
                                                            <option value="<?php echo htmlentities($row2['Section']) ; ?>"><?php echo htmlentities($row2['Section']) . ' '; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                            <td><label for="subject">Select Subject:</label></td>
                                            <td>
                                                <div class="form-group">
                                                    <select name="subject" id="subjectSelection" class="form-control" required='true'>
                                                    <option value="NA">Select Subject</option>
                                                        <!-- Options will be loaded via AJAX -->
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-center">
                                                <label for="fileUpload">Select Files to Upload:</label><br>
                                                <input type="file" class="form-control-file" id="fileUpload" name="file[]" multiple accept=".pdf, .jpg, .png" required='true'>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-center">
                                                <label for="additionalInfo">Add Note :</label><br>
                                                <input type="text" class="form-control" id="additionalInfo" name="additionalInfo" required='true'>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-center">
                                                <button type="submit" class="btn btn-primary">Upload</button>
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
            <?php include_once('includes/footer.php');?>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#SelectClass').change(function () {
                $.ajax({
                    url: 'getSubjects.php',
                    type: 'post',
                    data: { batch: $(this).val() },
                    success: function (response) {
                        $('#subjectSelection').html(response);
                    }
                });
            });
        });
        
    </script>
</body>
</html><?php } ?>