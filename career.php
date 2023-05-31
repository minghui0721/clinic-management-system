<?php
// Assuming you have already established a database connection

// Prepare and execute the query
$query = "SELECT name, description, type FROM career";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    // Loop through the result set
    while ($row = mysqli_fetch_assoc($result)) {
        $name = $row['name'];
        $description = $row['description'];
        $type = $row['type'];

        // Determine the job type
        $jobType = ($type == 0) ? "Full-Time" : "Part-Time";

        // Output the career information
        echo "<h3>$name</h3>";
        echo "<p>$description</p>";
        echo "<p>Type: $jobType</p>";
        echo "<hr>";
    }

    // Free the result set
    mysqli_free_result($result);
} else {
    // Query was unsuccessful
    echo "Error: " . mysqli_error($conn);
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career | Well Medical</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="career_style.css?v=<?php echo time(); ?>">
</head>
<body>



    <div class="web-container">

        <!-- division to make sure all boxes are align to each other-->
        <div class="boxes-container">

            <!-- apply now button -->
            <div class="apply-boxes">
                <a href="apply_form.php" target="_blank">
                    <button class="apply-button">
                        Apply Now
                    </button>
                </a>
            </div>
        </div>

    </div>

</body>
</html>