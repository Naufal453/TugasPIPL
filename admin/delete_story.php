<?php
include '../config/config.php';

// Check if story ID is provided in the URL
if (!isset($_GET['id'])) {
    // Redirect to dashboard or appropriate page
    header("Location: index.php");
    exit;
}

// Get the story ID from the URL
$story_id = $_GET['id'];

// Call the deleteStory function
deleteStory($story_id);
?>