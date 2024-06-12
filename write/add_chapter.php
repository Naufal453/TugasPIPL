<?php
include '../config/config.php';

$conn = connectDatabase();

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $story_id = $_GET['id']; // Get the story ID from the URL parameter
    $chapter_title = $_POST['chapter_title'];
    $chapter_content = $_POST['chapter_content'];

    // Insert new chapter into the database
    $sql = "INSERT INTO chapters (story_id, chapter_title, chapter_content) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $story_id, $chapter_title, $chapter_content);

    if ($stmt->execute()) {
        echo "<p class='text-success'>Chapter added successfully.</p>";
        header("Location: /Tugaspipl/write/");
    } else {
        echo "<p class='text-danger'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Chapter</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-light d-flex" style="background-color:#496989;">
        <a href="../write" class="navbar-brand text-white p-2 flex-grow-1">
            <img style="width:35px;height:45px;" class=navbar-brand src="../image/arrow.png">
        </a>

        <form class="form-inline p-2" method="GET" action="../search.php">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="button mr-sm-2" id="search" type="submit"
                style="border-radius:10px;border-color:transparent;background-color:grey;min-height:40px;min-width:50px;">
                cari</button>
        </form>
    </nav>
    <div class="container">
        <h1 class="mt-5 mb-4">Add Chapter</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id=<?php echo $_GET['id']; ?>"
            method="post">
            <div class="form-group">
                <label for="chapter_title">Chapter Title:</label>
                <input type="text" class="form-control" id="chapter_title" name="chapter_title" required>
            </div>
            <div class="form-group">
                <label for="chapter_content">Chapter Content:</label>
                <textarea class="form-control" id="chapter_content" name="chapter_content" rows="10"
                    required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Chapter</button>
        </form>
    </div>
</body>

</html>