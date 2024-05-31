<?php 
include '../config/config.php';
$conn = connectDatabase();
$stories = fetchStories();
// Fetch reported comments
$sql = "SELECT reports.report_id, comments.id AS comment_id, comments.comment_text, users.username, reports.reason
        FROM reports
        JOIN comments ON reports.comment_id = comments.id
        JOIN users ON comments.user_id = users.id
        ORDER BY reports.report_id DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
            <style>
        .dashboard {
            margin: 20px auto;
        }
        .story-footer, .report-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .hapus-btn {
            background-color: #e74c3c;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }
        .hapus-btn:hover {
            background-color: #c0392b;
        }
        .report-item .comment, .report-item .posted-date {
            font-size: 0.9em;
            color: #555;
        }
    </style>
    </style>
</head>
<body>
    <h1 class="text-center">Admin Dashboard</h1>
    <?php if (isset($_GET['delete_success'])): ?>
    <div class="alert alert-success" role="alert">
      Comment deleted successfully.
    </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-6">
            <h2>List Story</h2>
        <?php 
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

            // Fetch stories authored by the logged-in user
            $author = $_SESSION['username'];
            $sql = "SELECT author, id, title, description FROM stories WHERE author = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $author);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="card mb-3">';
                    echo '<div class="card-body">';
                    echo '<p class="comment">Title: ' . $row["title"] . '</p>';
                    echo '<p class="card-text">Author: ' . $row["author"] . '</p>';
                    echo '<a href="delete_story.php?id=' . $row["id"] . '" class="btn btn-danger">Delete Story</a>';
                    echo '</div>';
                    echo '</div>';
            }

            }
        ?>
        </div>
        <div class="col-md-6">
            <h2>List Report</h2>
        <?php 
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card mb-3">';
                echo '<div class="card-body">';
                echo '<p class="comment">Comment: ' . htmlspecialchars($row["comment_text"]) . '</p>';
                echo '<p class="card-text">Reported by: ' . htmlspecialchars($row["username"]) . '</p>';
                echo '<p class="card-text">Reason: ' . htmlspecialchars($row["reason"]) . '</p>';
                echo '<a href="delete_comment.php?comment_id=' . $row["comment_id"] . '" class="btn btn-danger">Delete Comment</a>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>No reported comments.</p>';
        }
        ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
