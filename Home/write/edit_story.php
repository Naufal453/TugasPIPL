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
    // Fetch the story details
    $row = $result->fetch_assoc();
} else {
    // Story not found or not authored by the logged-in user
    echo "Story not found or you don't have permission to edit.";
    exit;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Story</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Story</h1>
        <form action="update_story.php" method="post">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $row['title']; ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" rows="5" required><?php echo $row['description']; ?></textarea>
            </div>
            <!-- Add other fields here for editing -->
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="input.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
