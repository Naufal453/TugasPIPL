<?php
// Establish database connection
    $conn = new mysqli("localhost", "root", "", "alternate_arc");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve story data based on the ID passed in the URL
    if (isset($_GET['id'])) {
        $story_id = $_GET['id'];
        
        // Prepare and execute SQL query
        $stmt = $conn->prepare("SELECT title, description FROM stories WHERE id = ?");
        $stmt->bind_param("i", $story_id);
        $stmt->execute();
        $result = $stmt->get_result();

        <?php include 'view.php';?>
        } else {
            echo "Story not found.";
        }
        // Close the result set
        $result->close();
        // Close the statement
        $stmt->close();
    } else {
        echo "No story ID provided.";
    }
    $conn->close();
?>