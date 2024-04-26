<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to login page
    header("Location: ../Login/login.php");
    exit;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "alternate_arc";

    // Establish connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    // Add other fields here for updating

    // Update data in database
    $sql = "UPDATE stories SET title = ?, description = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $title, $description, $id);

    if ($stmt->execute()) {
        // Redirect to writer dashboard after successful update
        header("Location: input.php");
        exit;
    } else {
        echo "Error updating story: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
} else {
    // If the form is not submitted, redirect back to the dashboard
    header("Location: writer_dashboard.php");
    exit;
}
?>
