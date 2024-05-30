echo "<div class='comment'>";
echo "<strong>" . htmlspecialchars($row_comments['username']) . ":</strong> " . htmlspecialchars($row_comments['comment_text']) . "<br>";
echo "<small>Diposting pada: " . htmlspecialchars($row_comments['created_at']) . "</small>";
echo "<form action='report_comment_handler.php' method='post' style='display:inline;'>
      <input type='hidden' name='comment_id' value='" . htmlspecialchars($row_comments['comment_id']) . "'>
      <button type='submit'>Report</button>
      </form>";
echo "</div>";
