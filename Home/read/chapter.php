<?php
session_start(); // Mulai sesi

// Koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$database = "alternate_arc";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Pertanyaan untuk mengambil judul dan konten bab
$sql = "SELECT chapter_title, chapter_content FROM chapters WHERE id = ?"; 
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
        /* Gaya CSS */
    </style>
</head>
<body>
    <div class="container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<h2>" . htmlspecialchars($row['chapter_title'], ENT_QUOTES, 'UTF-8') . "</h2>";
                echo "<p>" . nl2br(htmlspecialchars($row['chapter_content'], ENT_QUOTES, 'UTF-8')) . "</p>";
            }
        } else {
            echo "<p>Bab tidak ditemukan.</p>";
        }
        $stmt->close();
        ?>
    </div>

    <div class="comment-form">
        <h2>Tambahkan Komentar</h2>
        <form method="POST" action="add_comment.php">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
            <input type="hidden" name="chapter_id" value="<?php echo $_GET['chapter_id']; ?>"> <!-- Menambahkan input tersembunyi dengan id bab -->
            <textarea name="comment_text" placeholder="Masukkan komentar Anda" required></textarea>
            <button type="submit">Kirim</button>
        </form>
    </div>

    <div class="comments">
        <h2>Komentar</h2>
        <?php
        // Ambil dan tampilkan komentar
        $sql_comments = "SELECT comments.comment_text, users.username, comments.created_at
                         FROM comments 
                         JOIN users ON comments.user_id = users.id 
                         WHERE comments.chapter_id = ?  -- Tambahkan kondisi untuk hanya mengambil komentar pada bab yang sama
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
                echo "</div>";
            }
        } else {
            echo "Belum ada komentar.";
        }
        $stmt_comments->close();
        ?>
    </div>

    <?php $conn->close(); ?>
</body>
</html>
