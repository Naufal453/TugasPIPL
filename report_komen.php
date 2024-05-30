<?php
// Loop untuk menampilkan komentar
if ($result_comments->num_rows > 0) {
    while ($row_comments = $result_comments->fetch_assoc()) {
        echo "<div class='comment'>";
        echo "<strong>" . htmlspecialchars($row_comments['username']) . ":</strong> " . htmlspecialchars($row_comments['comment_text']) . "<br>";
        echo "<small>Diposting pada: " . htmlspecialchars($row_comments['created_at']) . "</small>";

        // Form untuk pelaporan komentar
        echo "<form action='report_comment_handler.php' method='post' style='display:inline;'>";
        echo "<input type='hidden' name='comment_id' value='" . htmlspecialchars($row_comments['comment_id']) . "'>";
        echo "<button type='submit'>Report</button>";
        echo "</form>";
        echo "</div>";
    }
} else {
    echo "Belum ada komentar.";
}
?>
