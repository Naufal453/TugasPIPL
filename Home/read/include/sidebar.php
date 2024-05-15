<?php

$conn = connectDatabase();
//show author
if(isset($_GET['id']) && !empty(trim($_GET['id']))){
    $story_id = $_GET['id'];
    
    $sql = "SELECT author FROM stories WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $story_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows === 1){
        $row = $result->fetch_assoc();
        
        
        $author = $row["author"];

        
        echo '<p>'. 'Author:' . ' '. $author . '</p>';


    } else {
        echo "<p>Story not found.</p>";
    }
} else {
    echo "<p>Invalid story ID.</p>";
}

//show chapters
if(isset($_GET['id'])) {
    $story_id = $_GET['id']; // Assuming the URL parameter is named 'id'

    // Fetch chapters for the story
    $sql = "SELECT id, chapter_title FROM chapters WHERE story_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $story_id);
    $stmt->execute();
    $result = $stmt->get_result();
    echo "<li><p>" . "Chapters: " . "</p></li>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<li><a href='chapter.php?chapter_id=" . $row['id'] . "'>" . $row['chapter_title'] . "</a></li>";
        }
    } else {
        echo "<li>No chapters found.</li>";
    }

    $stmt->close();
} else {
    echo "<li>Invalid story id.</li>";
}
// Close connection

$conn->close();
?>
