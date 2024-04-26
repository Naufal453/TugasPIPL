<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to login page
    header("Location: ../Login/login.php");
    exit;
}

// Check if story ID is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Redirect to dashboard
    header("Location: writer_dashboard.php");
    exit;
}

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

// Fetch the story details based on the provided ID
$id = $_GET['id'];
$author = $_SESSION['username'];
$sql = "SELECT * FROM stories WHERE id = ? AND author = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $id, $author);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    // Delete the story
    $delete_sql = "DELETE FROM stories WHERE id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $id);
    $delete_stmt->execute();
    
    // Close statement
    $delete_stmt->close();
} else {
    // Story not found or not authored by the logged-in user
    echo "Story not found or you don't have permission to delete.";
}

// Close connection
$stmt->close();
$conn->close();

// Redirect to writer dashboard
header("Location: input.php");
exit;
?>
