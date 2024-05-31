<?php
require_once '../config/config.php';
$conn = connectDatabase();

if (isset($_GET['comment_id'])) {
    $comment_id = $_GET['comment_id'];

    // Delete related records in the reports table
    $sql_delete_reports = "DELETE FROM reports WHERE comment_id = ?";
    $stmt_delete_reports = $conn->prepare($sql_delete_reports);
    $stmt_delete_reports->bind_param("i", $comment_id);
    $stmt_delete_reports->execute();
    $stmt_delete_reports->close();

    // Delete the comment in the comments table
    $sql_delete_comment = "DELETE FROM comments WHERE id = ?";
    $stmt_delete_comment = $conn->prepare($sql_delete_comment);
    $stmt_delete_comment->bind_param("i", $comment_id);
    if ($stmt_delete_comment->execute()) {
        // Redirect back to the dashboard with a success message
        header("Location: index.php?delete_success=1");
    } else {
        echo "Error deleting comment: " . $conn->error;
    }
    $stmt_delete_comment->close();
} else {
    echo "No comment ID provided.";
}

$conn->close();
?>

