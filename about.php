<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>
<!doctype html>
<html>
<head>
<title>Student Management System || About Us Page</title>
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
    <h2>About</h2>
    </div>
</div>
<!--header-->
<!-- About -->
<div class="about">
     <div class="container">
         <div class="about-info-grids">
             <div class="col-md-5 abt-pic">
                 <img src="images/abt.jpg" class="img-responsive" alt=""/>
             </div>
             <div class="col-md-7 abt-info-pic">
                <?php
                $sql = "SELECT * FROM tblpage WHERE PageType='aboutus'";
                $result = $conn->query($sql);

                $cnt = 1;

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<p>' . $row['PageDescription'] . '</p>';
                        $cnt = $cnt + 1;
                    }
                } else {
                    echo "No results found.";
                }
                ?>

             </div>
             <div class="clearfix"> </div>
         </div>
        
     </div>
</div>
<!-- /About -->
<?php include_once('includes/footer.php');?>
<!--/copy-rights-->
</body>
</html>
