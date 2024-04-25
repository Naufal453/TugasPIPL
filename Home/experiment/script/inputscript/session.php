<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to login page
    header("Location: .../Login/login.php");
    exit;
}

// Check if the form is submitted
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
    $title = $_POST['title'];
    // Fetch the username from the session
    $author = $_SESSION['username'];
    $description = $_POST['description'];

    // Insert data into database
    $sql = "INSERT INTO stories (title, author, description) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $title, $author, $description);

    if ($stmt->execute()) {
        echo "<p class='text-success'>Story submitted successfully.</p>";
    } else {
        echo "<p class='text-danger'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>