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

    // Insert data into database
    $sql = "INSERT INTO stories (title, author, description) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $title, $author, $description);

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
    <title>Story Listing and Submission</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./style/input.css">
</head>
<header>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" style="background-color: #135D66;padding-top:0;padding-left:0px;padding-right:0px;">
        <div style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"class="container-fluid">
            <img style="width:68px;height:68px;"class=navbar-brand src="../image/Blue Wood (2).png">
                <ul class="navbar-nav ms-auto"> <!-- Adjusted to mx-auto -->
                    <li class="nav-item">
                        <a class="nav-link"  href="../home.php">
                            <img style="width:36px;height:36px;" src="../image/icons8-home-480.png" href="#">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" style="background-color:#E3FEF7;border:transparent;border-radius:35px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);" aria-current="page" href="./input.php" >
                            <img style="width:36px;height:36px;" src="../image/bookshelf (1).png" href="">
                            <div style="position: absolute; background-color: #E3FEF7; width: 10px; height: 10px; border-radius: 50%;margin-left:13px;margin-top:10px;"></div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="" href="../profile/profileset.php">
                            <img style="width:36px;height:36px;" src="../image/user_1077012.png" >
                        </a>
                    </li>
                </ul>
        </div>
    </nav>
</header>
<body style="background-color:#E3FEF7;">
    <div class="container">
        <h1 class="mt-5 mb-4">Story Listing</h1>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <!-- Story Listing -->
            <?php
                // Start session if not already started
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                // Check if user is logged in
                if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
                    // Redirect to login page
                    header("Location: ../Login/login.php");
                    exit;
                }

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

                // Fetch the latest added story for the logged-in user
                $user_id = $_SESSION['user_id']; // Assuming you have stored the user ID in the session variable
                $sql = "SELECT title, author, description FROM stories WHERE user_id = ? ORDER BY id DESC LIMIT 1"; // Assuming 'id' is the primary key column
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // Output the latest story
                    $row = $result->fetch_assoc();
                    echo '<div class="col">';
                    echo '<div class="card">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $row["title"] . '</h5>';
                    echo '<h6 class="card-subtitle mb-2 text-muted">Author: ' . $row["author"] . '</h6>';
                    echo '<p class="card-text">' . $row["description"] . '</p>';
                    echo '</div>'; // close card-body
                    echo '</div>'; // close card
                    echo '</div>'; // close col
                } else {
                    echo "<div class='col'><p>No stories available.</p></div>";
                }

                // Close statement and connection
                $stmt->close();
                $conn->close();
                ?>



        </div> <!-- close row -->

        <hr>

        <h1 class="mt-5 mb-4">Submit Your Story</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Tell the story:</label>
                <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div> <!-- close container -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
