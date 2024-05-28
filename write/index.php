<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to login page
    header("Location: ../Login/login.php");
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Retrieve form data
    $title = $_POST['title'];
    // Fetch the username from the session
    $author = $_SESSION['username'];
    $description = $_POST['description'];
    $fandom = $_POST['fandom'];
    $language = $_POST['language'];
    $status = $_POST['status'];
    $series = $_POST['series'];
    $characters = $_POST['characters'];
    $relationship = $_POST['relationship'];
    $addtags = $_POST['addtags'];

    // Insert data into database
    $sql = "INSERT INTO stories (title, author, description, Fandom, Language, Status, Series, Characters, Relationship, Addtags) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssss", $title, $author, $description, $fandom, $language, $status, $series, $characters, $relationship, $addtags);

    if ($stmt->execute()) {
        echo "<p class='text-success'>Story submitted successfully.</p>";
    } else {
        echo "<p class='text-danger'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Writer Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./style/input.css">
</head>
<header>
    <?php include 'navbar.php' ?>
</header>
<body style="background-color:#E3FEF7;">
    <div class="container">
        <h1 class="mt-5 mb-4">Writer Dashboard</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
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
                    $sql = "SELECT id, title, description FROM stories WHERE author = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $author);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['title'] . "</td>";
                            echo "<td>
                                    <a href='edit_story.php?id=" . $row['id'] . "'>Edit</a> | 
                                    <a href='delete_story.php?id=" . $row['id'] . "'>Delete</a> |
                                    <a href='../read/story.writer.php?id=" . $row['id'] . "'>Review</a> |
                                    <a href='add_chapter.php?id=" . $row['id'] . "'>Add Chapter</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No stories found.</td></tr>";
                    }

                    // Close statement and connection
                    $stmt->close();
                    $conn->close();
                ?>
            </tbody>
        </table>

        <hr>

        <div>
    <h1 class="mt-5 mb-4">Submit Your Story</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="description">Synopsis:</label>
            <textarea class="form-control" id="description" name="description" maxlength="1500" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <label for="fandom">Fandom:</label>
            <input type="text" class="form-control" id="fandom" name="fandom">
        </div>
        <div class="form-group">
            <label for="language">Language:</label>
            <input type="text" class="form-control" id="language" name="language">
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <input type="text" class="form-control" id="status" name="status">
        </div>
        <div class="form-group">
            <label for="series">Series:</label>
            <input type="text" class="form-control" id="series" name="series">
        </div>
        <div class="form-group">
            <label for="characters">Characters:</label>
            <input type="text" class="form-control" id="characters" name="characters">
        </div>
        <div class="form-group">
            <label for="relationship">Relationship:</label>
            <input type="text" class="form-control" id="relationship" name="relationship">
        </div>
        <div class="form-group">
            <label for="new-tag">Register New Tag:</label>
            <input type="text" class="form-control" id="new-tag" name="new-tag" placeholder="Enter new tag">
            <button type="button" class="btn btn-primary" onclick="registerNewTag()">Register Tag</button>
        </div>
        <div id="tag-registration-status"></div>
        <div class="form-group">
            <label for="tags">Tags:</label>
            <input type="text" class="form-control" id="tags" name="addtags" readonly>
            <div id="tag-options">
                    <?php include 'tags.php'?>
            </div>
            <div id="selected-tags"></div>
        </div>
        <button type="submit" class="btn btn-primary" style="margin-bottom:20px;">Submit</button>
    </form>
    <?php
    // Define variables and initialize with empty values
    $title = $description = $fandom = $language = $status = $series = $characters = $relationship = $addtags = "";
    
    // Processing form data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate Title
        if (empty(trim($_POST["title"]))) {
            echo "<p class='text-danger'>Title cannot be empty.</p>";
        } else {
            $title = trim($_POST["title"]);
        }
    
        // Validate Description
        if (empty(trim($_POST["description"]))) {
            echo "<p class='text-danger'>Synopsis cannot be empty.</p>";
        } else {
            $description = trim($_POST["description"]);
        }
    }
    ?>
</div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
