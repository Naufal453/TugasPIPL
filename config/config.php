<?php
session_start();

function checkLoggedIn()
{
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: Login/login.php");
        exit;
    }
}

function connectDatabase()
{
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


function fetchStories()
{
    checkLoggedIn();
    $conn = connectDatabase();
    $sql = "SELECT Addtags, image_path, id, title, author, description FROM stories";
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

function searchStories($search_query)
{
    checkLoggedIn();
    $conn = connectDatabase();

    $sql = "SELECT image_path, Addtags, id, title, author, description FROM stories WHERE title LIKE '%$search_query%' OR author LIKE '%$search_query%'";
    $result = $conn->query($sql);

    if ($result === false) {
        echo "Error executing query: " . $conn->error;
    } else {
        $stories = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $stories[] = $row;
            }
        }

        $conn->close();
        return $stories;
    }
}

function deleteStory($story_id)
{
    checkLoggedIn();
    $conn = connectDatabase();

    if (empty($story_id)) {
        header("Location: ../write");
        exit;
    }

    $conn->begin_transaction();

    try {
        $get_chapters_sql = "SELECT id FROM chapters WHERE story_id = ?";
        $get_chapters_stmt = $conn->prepare($get_chapters_sql);
        $get_chapters_stmt->bind_param("i", $story_id);
        $get_chapters_stmt->execute();
        $result = $get_chapters_stmt->get_result();
        $chapter_ids = $result->fetch_all(MYSQLI_ASSOC);
        $get_chapters_stmt->close();

        foreach ($chapter_ids as $chapter) {
            $chapter_id = $chapter['id'];
            $delete_likes_sql = "DELETE FROM chapter_likes WHERE chapter_id = ?";
            $delete_likes_stmt = $conn->prepare($delete_likes_sql);
            $delete_likes_stmt->bind_param("i", $chapter_id);
            $delete_likes_stmt->execute();
            $delete_likes_stmt->close();
        }

        $delete_chapters_sql = "DELETE FROM chapters WHERE story_id = ?";
        $delete_chapters_stmt = $conn->prepare($delete_chapters_sql);
        $delete_chapters_stmt->bind_param("i", $story_id);
        $delete_chapters_stmt->execute();
        $delete_chapters_stmt->close();

        $author = $_SESSION['username'];
        $sql = "DELETE FROM stories WHERE id = ? AND author = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $story_id, $author);
        $stmt->execute();
        $stmt->close();

        $conn->commit();

    } catch (Exception $e) {
        $conn->rollback();
        throw $e;
    }

    $conn->close();
    header("Location: index.php");
    exit;
}

?>