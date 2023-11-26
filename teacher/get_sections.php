
<?php
  
    include('includes/dbconnection.php');

    if (!$conn->connect_error) {
       
        if(isset($_POST['batch'])){
        
        $selectedValue = $_POST['batch'];
        $sql = "SELECT * FROM tblclass WHERE ClassName = 'MCA'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row as options for dropdown2
            while($row = $result->fetch_assoc()) {
                echo "<option value='" . $row["Section"] . "'>" . $row["Section"] . "</option>";
            }
        } else {
            echo "<option value=''>No Year available</option>";
        }
    }
    }
    $conn->close();
    ?>
