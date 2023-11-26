<?php
session_start();
include "../connection.php";

if (isset($_POST['selectedLocation'])) {
    // Get the selected location from the form
    $selectedLocation = $_POST['selectedLocation'];
    // Get the selected cruise type from the form
    $selectedCruiseType = $_POST['selectedCruiseType'];  // Add this line

    // Query to fetch boat details based on the selected location and cruise type
    $query = "SELECT b.* 
    FROM boat_reg b
    JOIN selected_cruise_types sct ON b.boat_number = sct.boat_number
    WHERE b.dist = ? AND b.boat_loc = ? AND b.status = 1 AND sct.cruise_name = ?";

    // Prepare and bind the parameters
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $_SESSION['selected_district'], $selectedLocation, $selectedCruiseType);

    // Execute the query
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Store boat details in a session variable
        $_SESSION['boat_details'] = $result->fetch_all(MYSQLI_ASSOC);

        // Redirect to the new page to display boat details
        header("Location: hb_available.php");
        exit();
    } else {
        echo "No location selected.";
    }

    // Close the statement
    $stmt->close();
}

?>

        
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Your Trip</title>
    <link rel="stylesheet" type="text/css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('../home/images/island.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Arial', sans-serif;
            color: white;
        }

        .navbar {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px 0;
            text-align: right;
        }

        .navbar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .navbar ul li {
            display: inline;
            margin: 0 15px;
            font-size: 20px;
        }

        .navbar ul li a {
            text-decoration: none;
            color: white;
            transition: color 0.3s;
        }

        .navbar ul li a:hover {
            color: #ff9900;
        }

        .container {
            text-align: center;
            padding: 100px;
        }

        h1 {
            margin-top: 0;
            font-size: 36px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .selection-form-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 8px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -45%);
            width: 50%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        label, h2 {
            color: #333;
        }

        select, button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }

        button {
            background-color: #0099cc;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #007399;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <ul>
            <li><a href="#">User Dashboard</a></li>
            <li><a href="#">Contact Us</a></li>
            <li><a href="#">Feedback</a></li>
            <li><a href="#">Logout</a></li>
        </ul>
    </div>

    <div class="container">
        <h1>Book Your Trip</h1>
    </div>

    <!-- Starting Place and Destination Selection Form -->
    <div class="selection-form-container">
        <form action="houseb_booking.php" id="boatForm" method="POST">
            <label for="district"><h2>Select The District In Which You Are Looking For  Journey:</h2></label>
            <select name="district" id="district">
                <option value="option">Select district</option>
                <!-- Options for starting places go here -->
                <option value="option">select district</option>
                <option value="thiruvananthapuram">Thiruvanathapuram</option>
                <option value="kollam">Kollam</option>
                <option value="pt">Pathanamthitta</option>
                <option value="alapuzha">alapuzha</option>
                <option value="ktym">Kottayam</option>
                <option value="idk">Idukki</option>
                <option value="ekm">Ernakulam</option>
                <option value="thrissur">thrissur</option>
                <option value="pkd">Palakkad</option>
                <option value="mpm">Malappuram</option>
                <option value="clt">Kozhikode</option>
                <option value="wynd">Wayanad</option>
                <option value="knr">Kannur</option>
                <option value="ksr">Kasargod</option>
               
                </select>

<label for="location"><h2 style="color:black;">Select Boat Location:</h2></label>
<select name="location" id="location"></select><br><br>

<input type="hidden" name="selectedLocation" id="selectedLocation">

<label for="cruiseType"><h2 style="color:black;">Select Cruise Type:</h2></label>
<select name="cruiseType" id="cruiseType"></select><br><br>

<input type="hidden" name="selectedCruiseType" id="selectedCruiseType">
<button type="submit" id="showAvailableBoatsButton">Show available boats</button>
</form>
</div>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
    const districtDropdown = document.getElementById("district");
    const locationDropdown = document.getElementById("location");
    const selectedLocationInput = document.getElementById("selectedLocation");
    const cruiseTypeDropdown = document.getElementById("cruiseType");

    districtDropdown.addEventListener("change", function() {
        const selectedDistrict = districtDropdown.value;
        locationDropdown.innerHTML = "<option value=''>Select Boat Location</option>";
        cruiseTypeDropdown.innerHTML = "<option value=''>Select Cruise Type</option>";

        if (selectedDistrict) {
            // Send an AJAX request to set the district in the session.
            fetch("set_session.php", {
                method: "POST",
                body: new URLSearchParams({ district: selectedDistrict }),
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
            })
            .then((response) => response.text())
            .then((data) => {
                console.log("District set:", data);
            })
            .catch((error) => console.error("Error setting district:", error));

            // Now populate the location dropdown.
            fetch("get_location.php", {
                method: "POST",
                body: new URLSearchParams({ district: selectedDistrict }),
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
            })
            .then((response) => response.json())
            .then((data) => {
                console.log("Locations received:", data);
                data.forEach((location) => {
                    const option = document.createElement("option");
                    option.value = location;
                    option.textContent = location;
                    locationDropdown.appendChild(option);
                });
            })
            .catch((error) => console.error("Error getting locations:", error));

            fetch("get_cruise_types.php", {
                method: "POST",
                body: new URLSearchParams({ district: selectedDistrict }),
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
            })
            .then(response => response.json())
            .then(data => {
                console.log("Cruise types received:", data);
                data.forEach(cruiseType => {
                    const option = document.createElement("option");
                    option.value = cruiseType;
                    option.textContent = cruiseType;
                    cruiseTypeDropdown.appendChild(option);
                });
            })
            .catch(error => console.error("Error getting cruise types:", error));
        }
    });

    // Handle form submission
    document.getElementById("showAvailableBoatsButton").addEventListener("click", function(event) {
        event.preventDefault();

        // Set the value of the hidden input fields
        selectedLocationInput.value = locationDropdown.value;
        document.getElementById("selectedCruiseType").value = cruiseTypeDropdown.value;

        console.log("Form submitted. Location:", locationDropdown.value, "Cruise Type:", cruiseTypeDropdown.value);

        // Submit the form
        document.getElementById("boatForm").submit();
    });
});

</script>

</body>
</html>