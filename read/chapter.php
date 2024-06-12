<?php
require_once '../config/config.php'; // Mengimpor file konfigurasi
$conn = connectDatabase();
// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['toggle_like'])) {
        $user_id = $_POST['user_id'];
        $chapter_id = $_POST['chapter_id'];

        // Check if the user has already liked the chapter
        $sql_check_like = "SELECT * FROM chapter_likes WHERE user_id = ? AND chapter_id = ?";
        $stmt_check_like = $conn->prepare($sql_check_like);
        $stmt_check_like->bind_param("ii", $user_id, $chapter_id);
        $stmt_check_like->execute();
        $result_check_like = $stmt_check_like->get_result();

        if ($result_check_like->num_rows > 0) {
            // User has already liked the chapter, so unlike it
            $sql_unlike = "DELETE FROM chapter_likes WHERE user_id = ? AND chapter_id = ?";
            $stmt_unlike = $conn->prepare($sql_unlike);
            $stmt_unlike->bind_param("ii", $user_id, $chapter_id);
            $stmt_unlike->execute();
            $stmt_unlike->close();
        } else {
            // User has not liked the chapter yet, so like it
            $sql_like = "INSERT INTO chapter_likes (user_id, chapter_id) VALUES (?, ?)";
            $stmt_like = $conn->prepare($sql_like);
            $stmt_like->bind_param("ii", $user_id, $chapter_id);
            $stmt_like->execute();
            $stmt_like->close();
        }

        $stmt_check_like->close();
    } else {
        // Ambil data yang dikirimkan melalui form
        $user_id = $_POST['user_id'];
        $comment_text = $conn->real_escape_string($_POST['comment_text']);
        $chapter_id = $_POST['chapter_id']; // Ambil id bab dari form

        // Pertanyaan untuk menambahkan komentar ke database
        $sql = "INSERT INTO comments (user_id, comment_text, chapter_id) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Mencegah SQL injection dengan mengikat parameter
        $stmt->bind_param("isi", $user_id, $comment_text, $chapter_id);

        if ($stmt->execute()) {
            echo "Komentar baru berhasil ditambahkan";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $stmt->close();

        // Arahkan kembali ke halaman bab setelah menambahkan komentar
        header("Location: chapter.php?chapter_id=" . $chapter_id);
        exit();
    }
}

// Pertanyaan untuk mengambil judul dan konten bab
$sql = "SELECT chapter_title, chapter_content,
        (SELECT COUNT(*) FROM chapter_likes WHERE chapter_likes.chapter_id = chapters.id) AS like_count
        FROM chapters WHERE id = ?";
$stmt = $conn->prepare($sql);

// Mencegah SQL injection dengan mengikat parameter
$stmt->bind_param("i", $_GET['chapter_id']);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konten Bab</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 800px;
            padding: 20px;
            margin: 20px 0;
            box-sizing: border-box;
        }

        .container h2 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .container p {
            color: #555;
            line-height: 1.6;
        }

        .like-button {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .like-button form {
            display: inline;
        }

        .like-button button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .like-button button:hover {
            background-color: #0069d9;
        }

        .like-button span {
            color: #555;
            margin-left: 10px;
            font-size: 16px;
        }

        .comment-form,
        .comments {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 800px;
            padding: 20px;
            margin: 20px 0;
            box-sizing: border-box;
        }

        .comment-form h2,
        .comments h2 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .comment-form textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            margin-bottom: 10px;
            resize: vertical;
        }

        .comment-form button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            display: block;
            margin: 0 auto;
        }

        .comment-form button:hover {
            background-color: #45a049;
        }

        .comment {
            background-color: #f9f9f9;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .comment strong {
            color: #333;
        }

        .comment small {
            color: #888;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Check if the user has liked the chapter
                $sql_check_like = "SELECT * FROM chapter_likes WHERE user_id = ? AND chapter_id = ?";
                $stmt_check_like = $conn->prepare($sql_check_like);
                $stmt_check_like->bind_param("ii", $_SESSION['user_id'], $_GET['chapter_id']);
                $stmt_check_like->execute();
                $result_check_like = $stmt_check_like->get_result();
                $liked = $result_check_like->num_rows > 0;
                $stmt_check_like->close();

                echo "<h2>" . htmlspecialchars($row['chapter_title'], ENT_QUOTES, 'UTF-8') . "</h2>";
                echo "<p>" . nl2br(htmlspecialchars($row['chapter_content'], ENT_QUOTES, 'UTF-8')) . "</p>";
                echo "<div class='like-button'>";
                echo "<form method='POST' action=''>";
                echo "<input type='hidden' name='user_id' value='" . $_SESSION['user_id'] . "'>";
                echo "<input type='hidden' name='chapter_id' value='" . $_GET['chapter_id'] . "'>";
                echo "<button type='submit' name='toggle_like'>" . ($liked ? "Unlike" : "Like") . "</button>";
                echo "<span>Likes: " . $row['like_count'] . "</span>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "<p>Bab tidak ditemukan.</p>";
        }
        $stmt->close();
        ?>
    </div>

    <div class="comment-form">
        <h2>Tambahkan Komentar</h2>
        <form method="POST" action="">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
            <input type="hidden" name="chapter_id" value="<?php echo $_GET['chapter_id']; ?>">
            <!-- Menambahkan input tersembunyi dengan id bab -->
            <textarea name="comment_text" placeholder="Masukkan komentar Anda" required></textarea>
            <button type="submit">Kirim</button>
        </form>
    </div>

    <div class="comments">
        <h2>Komentar</h2>
        <?php
        $sql_comments = "SELECT comments.id, comments.comment_text, users.username, comments.created_at
                         FROM comments 
                         JOIN users ON comments.user_id = users.id 
                         WHERE comments.chapter_id = ?
                         ORDER BY comments.created_at DESC";
        $stmt_comments = $conn->prepare($sql_comments);
        $stmt_comments->bind_param("i", $_GET['chapter_id']);
        $stmt_comments->execute();
        $result_comments = $stmt_comments->get_result();

        if ($result_comments->num_rows > 0) {
            while ($row_comments = $result_comments->fetch_assoc()) {
                echo "<div class='comment'>";
                echo "<strong>" . htmlspecialchars($row_comments['username']) . ":</strong> " . htmlspecialchars($row_comments['comment_text']) . "<br>";
                echo "<small>Diposting pada: " . htmlspecialchars($row_comments['created_at']) . "</small>";
                echo "<button type='button' onclick='openModal(\"" . $row_comments['id'] . "\")' style='background-color:red;'>Report</button>";
                echo "</div>";
            }
        } else {
            echo "Belum ada komentar.";
        }
        $stmt_comments->close();
        ?>
    </div>

    <!-- Report Modal -->
    <div id="reportModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form action="report.php?chapter_id=<?php echo $_GET['chapter_id']; ?>" method="POST">
                <input type="hidden" name="chapter_id" value="<?php echo $_GET['chapter_id']; ?>">
                <input type="hidden" name="comment_id" id="commentId" value="">
                <h2>Report Comment</h2>
                <textarea name="report_reason" placeholder="Enter reason for reporting" required></textarea>
                <button type="submit" name="report_comment">Submit Report</button>
            </form>
        </div>
    </div>

    <!-- Success Notification Modal -->
    <div id="successModal" class="modal"
        style="<?php echo isset($_GET['report_success']) ? 'display:block;' : 'display:none;'; ?>">
        <div class="modal-content">
            <span class="close" onclick="closeSuccessModal()">&times;</span>
            <p>Report submitted successfully!</p>
        </div>
    </div>

    <style>
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            /* Could be more or less, depending on screen size */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>

    <script>
        // Get the modal
        var modal = document.getElementById('reportModal');

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on the button, open the modal 
        function openModal(commentId) {
            document.getElementById('commentId').value = commentId;
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function () {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Get the success modal
        var successModal = document.getElementById('successModal');

        // Get the <span> element that closes the success modal
        var span = document.getElementsByClassName("close")[0];

        // Function to close the success modal
        function closeSuccessModal() {
            successModal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event) {
            if (event.target == successModal) {
                successModal.style.display = "none";
            }
        }
    </script>

    <?php $conn->close(); ?>
</body>

</html>