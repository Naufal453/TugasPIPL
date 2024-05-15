<?php
session_start(); // Mulai sesi

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'alternate_arc');

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
}

// Arahkan kembali ke halaman bab setelah menambahkan komentar
header("Location: chapter.php?chapter_id=" . $chapter_id);
exit();
?>
