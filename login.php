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
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare a select statement
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");

    // Bind parameters
    $stmt->bind_param("s", $username);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $row['password'])) {
            // Password is correct, start a new session
            session_start();

            // Store data in session variables
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $row['id'];
            $_SESSION["username"] = $username;

            // Redirect user to welcome page
            header("location: welcome.php");
        } else {
            // Password is incorrect
            echo "Invalid password";
        }
    } else {
        // Username doesn't exist
        echo "User not found";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
