<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>
<!doctype html>
<html>
<head>
<title>Student Management System || Contact Us Page</title>
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!--bootstrap-->
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
<!--custom css-->
<link href="css/style.css" rel="stylesheet" type="text/css"/>
<!--script-->
<script src="js/jquery-1.11.0.min.js"></script>
<!-- js -->
<script src="js/bootstrap.js"></script>
<!-- /js -->
<!--fonts-->
<link href='//fonts.googleapis.com/css?family=Open+Sans:300,300italic,400italic,400,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
<!--/fonts-->
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script>
<!--script-->
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $(".scroll").click(function(event){        
            event.preventDefault();
            $('html,body').animate({scrollTop:$(this.hash).offset().top},900);
        });
    });
</script>
<!--/script-->
</head>
<body>
<!--header-->
<?php include_once('includes/header.php');?>
<!-- Top Navigation -->
<div class="banner banner5">
    <div class="container">
    <h2>Contact</h2>
    </div>
</div>
<!--header-->
<!-- contact -->
<div class="contact">
    <!-- container -->
    <div class="container">
        <div class="contact-info">
            <h3 class="c-text">Feel Free to contact with us!!!</h3>
        </div>
        
        <div class="contact-grids">
            <?php
            $conn = new mysqli("localhost", "root", "", "studentmsdb");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM tblpage WHERE PageType='contactus'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-4 contact-grid-left">';
                    echo '<h3>Address :</h3>';
                    echo '<p>' . htmlentities($row['PageDescription']) . '</p>';
                    echo '</div>';
                    echo '<div class="col-md-4 contact-grid-middle">';
                    echo '<h3>Phones :</h3>';
                    echo '<p>' . htmlentities($row['MobileNumber']) . '</p>';
                    echo '</div>';
                    echo '<div class="col-md-4 contact-grid-right">';
                    echo '<h3>E-mail :</h3>';
                    echo '<p>' . htmlentities($row['Email']) . '</p>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>
    <!-- //container -->
</div>
<!-- //contact -->
<?php include_once('includes/footer.php');?>
<!--/copy-rights-->
</body>
</html>
