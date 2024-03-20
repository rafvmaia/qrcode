<?php
session_start();

// Database connection
$servername = "localhost";
$username = "u671310777_qrcode";
$password = "8/n6[B@H";
$dbname = "u671310777_qrcode";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['regUsername'];
    $password = password_hash($_POST['regPassword'], PASSWORD_DEFAULT); // Hash the password

    // Prepare a select statement to check if username already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Username already exists
        echo "Username already exists";
    } else {
        // Prepare an insert statement
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");

        // Bind parameters
        $stmt->bind_param("ss", $username, $password);

        // Execute the statement
        if ($stmt->execute()) {
            // Registration successful
            echo "Registration successful";
            // Redirect to index.html after successful registration
            header("Location: index.php");
            exit();
        } else {
            echo "Error occurred";
        }
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
