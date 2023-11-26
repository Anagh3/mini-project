<?php
session_start();
//error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['sturecmsstuid']) == 0) {
    header('location:logout.php');
} else {
?>


<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['class'])) {
    $_SESSION['selectedClassName'] = $_POST['class'];
    $_SESSION['selectedSection'] = $_POST['year'];
    $_SESSION['selectedSubject'] = $_POST['subject'];
    header('Location: list_notes.php');
    exit();
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
                                        <th colspan="2" style="text-align: center; font-weight: bold; font-size: 24px;">View Notes</th>
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
                                                <button type="submit" class="btn btn-primary">View Note</button>
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



