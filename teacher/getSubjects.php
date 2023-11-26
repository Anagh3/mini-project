    <?php
    include('includes/dbconnection.php');
   
    if (!$conn->connect_error) {
        if(isset($_POST['batch'])){
        $selectedValue = $_POST['batch'];
        $sql = "SELECT * FROM tblsubject WHERE ID = '$selectedValue'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row as options for dropdown2
            while($row = $result->fetch_assoc()) {
                echo "<option value='" . $row["subject"] . "'>" . $row["subject"] . "</option>";
            }
        } else {
            echo "<option value=''>No subjects available</option>";
        }
    }
    }
    $conn->close();
    ?>
