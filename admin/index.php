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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
        }

        .list-item {
            margin-bottom: 20px;
        }

        .list-item img {
            width: 100%;
        }

        .hapus-btn {
            background-color: red;
            color: white;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top"
        style="background-color: #135D66;padding-top:0;padding-left:0px;padding-right:0px;">
        <div style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"
            class="container-fluid">
            <h1 class="text-center">Admin Dashboard</h1>
            <ul class="navbar-nav ms-auto"> <!-- Adjusted to mx-auto -->
                <li class="nav-item">
                    <a class="nav-link" href="../logout.php" style="background-color:red;border-radius:10px;">
                        Log out
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <br>
    <?php if (isset($_GET['delete_success'])): ?>
        <div class="alert alert-success" role="alert">
            Comment deleted successfully.
        </div>
    <?php endif; ?>
    <br>
    <style>
    </style>
    <div class="row">
        <div class="col-md-6">
            <h3>List Story</h3>
            <!-- <div class="list-item card"> -->
            <?php
            foreach ($stories as $story) {
                echo '<div class="card mb-3" style="max-width: 540px;">' .
                    '<div class="row g-0">' .
                    '<div class="col-md-4">' .
                    '<img src="../write/' . $story["image_path"] . '"alt="..." style="max-width:180px">' .
                    '</div>' .
                    '<div class="col-md-8">' .
                    '<div class="card-body">' .
                    '<h5 class="card-title">' . $story["title"] . ' by ' . $story["author"] . '</h5>' .
                    '<p class="card-text">' . substr($story["description"], 0, 100) . '...' . '</p>' .
                    '</p>' .
                    '</div>' .
                    '</div>' .
                    '</div>' .
                    '</div>';
            }
            ?>
            <!-- </div> -->
        </div>
        <div class="col-md-6">
            <h3>List Report</h3>
            <div class="list-item card">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="card-body">';
                        echo '<h6 class="card-subtitle mb-2 text-muted">Reported by: ' . htmlspecialchars($row["username"]) . '</h6>';
                        echo '<p class="card-text">Reason: ' . htmlspecialchars($row["reason"]) . '</p>';
                        echo '<p class="card-text"><strong>Comment: </strong>' . htmlspecialchars($row["comment_text"]) . '</p>';
                        echo '<button type="button" class="btn btn-primary btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Hapus
                            </button>';
                        // Asumsikan $row adalah array yang berisi data komentar
                        echo '
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            Yakin menghapus komentar?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="delete_comment.php?comment_id=' . $row["comment_id"] . '" method="post">
                                                <button type="submit" class="btn btn-primary">Yes</button>
                                            </form>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No reported comments.</p>';
                }
                ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>

</html>