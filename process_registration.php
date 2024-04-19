<?php
// Function to sanitize input data

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "MHEI";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get and sanitize form data
$username = sanitize_input($_POST['username']);
$email = sanitize_input($_POST['email']);
$firstname = sanitize_input($_POST['firstname']);
$secondname = sanitize_input($_POST['secondname']);
$phone = sanitize_input($_POST['phone']);
$password = sanitize_input($_POST['password']);

// Validate form data
$errors = array();

if (empty($username) || empty($firstname) || empty($secondname)) {
    $errors[] = "Username, firstname, and secondname are required.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !strpos($email, "@")) {
    $errors[] = "Invalid email format.";
}

if (strlen($password) < 8) {
    $errors[] = "Password must be at least 8 characters long.";
}

if (!preg_match("/^[0-9+]+$/", $phone)) {
    $errors[] = "Phone number must contain only numbers and the symbol '+'";
}

// If there are validation errors, display them
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
} else {
    // Insert data into users table
    $sql = "INSERT INTO users (username, email, firstname, secondname, phone, password)
    VALUES ('$username', '$email', '$firstname', '$secondname', '$phone', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        // Confirmation message in console
        echo "<script>console.log('Data insertion successful!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


// Close connection
$conn->close();

// Exit the script
exit();
?>