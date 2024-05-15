
<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "alternate_arc";

// Establish connection
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk mengambil chapter_title dan chapter_content
$sql = "SELECT chapter_title, chapter_content FROM chapters WHERE id = ?"; // Sesuaikan dengan kolom dan kondisi yang sesuai
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_GET['chapter_id']); // Sesuaikan dengan parameter yang sesuai
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<h2>" . $row['chapter_title'] . "</h2>";
        echo "<p>" . $row['chapter_content'] . "</p>";
    }
} else {
    echo "Chapter not found.";
}

$stmt->close();
$conn->close();
?>