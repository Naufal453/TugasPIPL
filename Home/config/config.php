<?php
session_start();

function checkLoggedIn(){
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: ../choose.php");
        exit;
    }

}

function connectDatabase(){
    $servername = "localhost"; 
    $username = "root"; 
    $password = ""; 
    $database = "alternate_arc"; 

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
     return $conn;
}

function fetchStories(){
    checkLoggedIn();
    $conn = connectDatabase();
    $sql = "SELECT id, title, author, description FROM stories";
    $result = $conn->query($sql);

    
    $stories = [];
    if ($result->num_rows > 0) {
        
        while ($row = $result->fetch_assoc()) {
            $stories[] = $row;
        }
    }


    $conn->close();
    return $stories;
}
function searchStories($search_query) {
    // Check if user is logged in
    checkLoggedIn();

    // Establish database connection
    $conn = connectDatabase();

    // Execute query to fetch data
    $sql = "SELECT id, title, author, description FROM stories WHERE title LIKE '%$search_query%' OR author LIKE '%$search_query%'";
    $result = $conn->query($sql);

    // Check if there are any matching stories
    if ($result === false) {
        echo "Error executing query: " . $conn->error;
    } else {
        $stories = [];
        if ($result->num_rows > 0) {
            // Fetch data and store in an array
            while ($row = $result->fetch_assoc()) {
                $stories[] = $row;
            }
        }

        // Close database connection
        $conn->close();

        return $stories;
    }
}
function deleteStory($story_id) {
    // Check if user is logged in
    checkLoggedIn();

    // Establish database connection
    $conn = connectDatabase();

    // Check if story ID is provided
    if (empty($story_id)) {
        // Redirect to dashboard or appropriate page
        header("Location: writer_dashboard.php");
        exit;
    }

    // Fetch the story details based on the provided ID
    $author = $_SESSION['username'];
    $sql = "SELECT * FROM stories WHERE id = ? AND author = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $story_id, $author);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Delete the story
        $delete_sql = "DELETE FROM stories WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $story_id);
        $delete_stmt->execute();
        
        // Close statement
        $delete_stmt->close();
    } else {
        // Story not found or not authored by the logged-in user
        echo "Story not found or you don't have permission to delete.";
    }

    // Close connection and statement
    $stmt->close();
    $conn->close();

    // Redirect to writer dashboard or appropriate page
    header("Location: input.php");
    exit;
}
?>
