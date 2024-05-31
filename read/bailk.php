<?php
require_once '../config/config.php';

    $story_id = $_GET['id']; // Assuming the URL parameter is named 'id'

    // Fetch chapters for the story
    $sql = "SELECT id, chapter_title FROM chapters WHERE story_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $story_id);
    $stmt->execute();
    $result = $stmt->get_result();

    header("Location: chapter.php?chapter_id=" . $row['id'] . $row['chapter_title']);

    $stmt->close();