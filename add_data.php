<?php
session_start(); // Start the session to store user data

// Database connection configuration
$servername = "localhost";  // Database server
$username = "root";         // MySQL username
$password = "";             // MySQL password
$dbname = "ecommerce_db";    // Database name

// Create the database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Display error if connection fails
}

// Process the addition of data when the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate inputs
    if (empty($_POST['nama_dress']) || empty($_POST['deskripsi']) || empty($_FILES['foto']['name'])) {
        echo "<script>alert('Please complete all fields.');</script>"; // Alert if any field is empty
    } else {
        $nama_dress = $_POST['nama_dress']; // Get the dress name from the input
        $deskripsi = $_POST['deskripsi']; // Get the description from the input
        
        // Upload the photo
        $target_dir = "images/"; // Directory to store images
        $target_file = $target_dir . basename($_FILES["foto"]["name"]); // Full path of the uploaded file
        $uploadOk = 1; // Status of upload, initially set to 1 (success)
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // Get the file type

        // Check if the file is a genuine image or not
        $check = getimagesize($_FILES["foto"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image."; // If not an image, show error
            $uploadOk = 0; // Set upload status to 0 (failure)
        }

        // Check file size
        if ($_FILES["foto"]["size"] > 500000) {
            echo "Sorry, the file is too large."; // If file is too large, show error
            $uploadOk = 0; // Set upload status to 0 (failure)
        }

        // Check file format
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "Sorry, only JPG, JPEG, PNG, & GIF files are allowed."; // If the file format is not valid, show error
            $uploadOk = 0; // Set upload status to 0 (failure)
        }

        // If no errors, upload the file and save data to the database
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) { // Upload the file
                // Save data into the database
                $sql = "INSERT INTO dress (nama_dress, deskripsi, foto) VALUES (?, ?, ?)"; // Query to insert data
                $stmt = $conn->prepare($sql); // Prepare the statement
                $stmt->bind_param("sss", $nama_dress, $deskripsi, $target_file); // Bind the parameters
                if ($stmt->execute()) { // Execute the statement
                    $_SESSION['message'] = "Data has been added successfully."; // Set success message in session
                    header("Location: admin_dashboard.php"); // Redirect to the admin dashboard page
                    exit; // Stop script execution after redirect
                } else {
                    echo "Error: " . $stmt->error; // Show error if the query fails
                }
                $stmt->close(); // Close the statement
            } else {
                echo "Sorry, there was an error uploading the file."; // Show error if upload fails
            }
        }
    }
}

$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Dress - Ecommerce</title>
    <style>
        body {
            background-image: url('images/background.jpg'); /* Set background image */
            background-size: cover; /* Cover the entire background */
            background-position: center; /* Center the background image */
            font-family: Arial, sans-serif; /* Set font for the page */
            padding: 20px; /* Padding for the body */
            color: white; /* Change text color to white for better contrast */
        }
        h1 {
            text-align: center; /* Align title in the center */
            color: #4b2e2e; /* Title color */
        }
        .form-container {
            max-width: 600px; /* Set max width for the form */
            margin: auto; /* Center the form */
            background-color: rgba(150, 121, 59, 0.8); /* Set semi-transparent background */
            padding: 20px; /* Padding for the form */
            border-radius: 10px; /* Rounded corners for the form */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add shadow effect for the form */
        }
        label {
            display: block; /* Display labels as block elements */
            margin-bottom: 5px; /* Add margin to the bottom of labels */
        }
        input[type="text"],
        textarea,
        input[type="file"] {
            width: 90%; /* Set width for input fields and textarea */
            padding: 10px; /* Padding for input fields */
            margin-bottom: 15px; /* Margin below input fields */
            border: 1px solid #ccc; /* Border for input fields */
            border-radius: 5px; /* Rounded corners for input fields */
        }
        button {
            background-color: rgb(215, 171, 88); /* Button background color */
            color: white; /* Button text color */
            padding: 10px; /* Button padding */
            border: none; /* Remove border from the button */
            border-radius: 5px; /* Rounded corners for the button */
            cursor: pointer; /* Pointer cursor on hover */
        }
        button:hover {
            opacity: 0.8; /* Button opacity on hover */
        }
    </style>
</head>
<body>
<div class="form-container">
    <h1>Tambah Dress Baru</h1> <!-- Form title -->
    <form action="" method="POST" enctype="multipart/form-data"> <!-- Form for adding a new dress -->
        <label for="nama_dress">Nama Dress:</label>
        <input type="text" name="nama_dress" required> <!-- Input for dress name -->

        <label for="deskripsi">Deskripsi:</label>
        <textarea name="deskripsi" required></textarea> <!-- Textarea for dress description -->

        <label for="foto">Foto Dress:</label>
        <input type="file" name="foto" accept="image/*" required> <!-- Input for uploading dress photo -->

        <button type="submit">Tambah Dress</button> <!-- Submit button -->
    </form>
</div>

</body>
</html>
