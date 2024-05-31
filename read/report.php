<?php
require_once '../config/config.php';
$conn = connectDatabase();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['report_comment'])) {
    $comment_id = $_POST['comment_id'];
    $report_reason = $conn->real_escape_string($_POST['report_reason']); // Sanitize the input
    $chapter_id = isset($_POST['chapter_id']) ? $_POST['chapter_id'] : (isset($_GET['chapter_id']) ? $_GET['chapter_id'] : null);

    if ($chapter_id === null) {
        echo "Error: Chapter ID is missing in the URL.";
        exit();
    }

    // SQL to insert report into the database
    $sql = "INSERT INTO reports (comment_id, reason) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $comment_id, $report_reason);

    try {
        if ($stmt->execute()) {
            // Redirect with success message
            header("Location: chapter.php?chapter_id=" . $chapter_id);
            exit(); // Make sure to exit after redirecting
        } else {
            echo "Error submitting report: " . $stmt->error;
        }
    } catch (mysqli_sql_exception $e) {
        echo "Error submitting report: " . $e->getMessage();
    }

    $stmt->close();
}

$conn->close();
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
