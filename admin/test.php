<?php 
include '../config/config.php';
$conn = connectDatabase();

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
</head>
<body>
    <div class="container dashboard">
        <h1 class="text-center">Admin Dashboard</h1>
        <div class="row">
            <div class="col-md-6">
                <h2>List Story</h2>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Revenant by kim eun he</h5>
                        <img src="image_url" class="card-img-top" alt="Revenant">
                        <p class="card-text">AYAM MIE AYAMMIE AYAM MIE AYAM MIE AYAM MIE AYAM MIE...</p>
                        <div class="story-footer">
                            <span>1,234 Like</span>
                            <button class="hapus-btn">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h2>List Report</h2>
                <div class="card mb-3">
                    <div class="card-body">
                        <p class="card-text">Budi reported by Jokoadi</p>
                        <p class="card-text">NOT APPROPRIATE FOR PUBLIC</p>
                        <p class="comment">Budi's Comment: He is too black</p>
                        <p class="posted-date">posted at: 2024-05-30</p>
                        <div class="report-footer">
                            <button class="hapus-btn">Hapus</button>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <p class="card-text">Budi reported by Jokoadi</p>
                        <p class="card-text">NOT APPROPRIATE FOR PUBLIC</p>
                        <p class="comment">Budi's Comment: He is too black</p>
                        <p class="posted-date">posted at: 2024-05-30</p>
                        <div class="report-footer">
                            <button class="hapus-btn">Hapus</button>
                        </div>
                    </div>
                </div>
                <!-- Add more report items as needed -->
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
