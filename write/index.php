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
    $author = $_SESSION['username'];
    $description = $_POST['description'];
    $fandom = $_POST['fandom'];
    $language = $_POST['language'];
    $status = $_POST['status'];
    $series = $_POST['series'];
    $characters = $_POST['characters'];
    $relationship = $_POST['relationship'];
    $addtags = $_POST['addtags'];

    // Image upload
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // Create directory if it doesn't exist
    }

    $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $uploadOk = 1;

    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $_SESSION['message'] = "<p class='text-danger'>File is not an image.</p>";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) { // 500KB
        $_SESSION['message'] = "<p class='text-danger'>Sorry, your file is too large.</p>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $_SESSION['message'] = "<p class='text-danger'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</p>";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        // Generate a random string for the new file name
        $randomString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
        $target_file = $target_dir . $randomString . '.' . $imageFileType;

        // Check if file already exists
        while (file_exists($target_file)) {
            $randomString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
            $target_file = $target_dir . $randomString . '.' . $imageFileType;
        }

        // Attempt to move the uploaded file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $_SESSION['message'] = "<p class='text-success'>The file has been uploaded as $randomString.$imageFileType.</p>";

            // Insert data into database
            $sql = "INSERT INTO stories (title, author, description, Fandom, Language, Status, Series, Characters, Relationship, Addtags, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssssss", $title, $author, $description, $fandom, $language, $status, $series, $characters, $relationship, $addtags, $target_file);

            if ($stmt->execute()) {
                $_SESSION['message'] = "<p class='text-success'>Story submitted successfully.</p>";
            } else {
                $_SESSION['message'] = "<p class='text-danger'>Error: " . $sql . "<br>" . $conn->error . "</p>";
            }
            $stmt->close();
        } else {
            $_SESSION['message'] = "<p class='text-danger'>Sorry, there was an error uploading your file.</p>";
        }
    } else {
        $_SESSION['message'] = "<p class='text-danger'>Sorry, your file was not uploaded.</p>";
    }

    // Close connection
    $conn->close();

    // Redirect to the same page to display the message
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Writer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./style/input.css">
</head>
<header>
    <?php include 'navbar.php' ?>
</header>
<style>
    .modal-content {
        transition: opacity 1s ease-in-out;
    }

    .modal.fade-out .modal-content {
        opacity: 0;
    }
</style>


<body style="background-color:#FFFFFF;">
    <div class="container mt-5 pt-3 ">
        <hr>
        <div class="d-flex mb-2">
            <h1 class="me-auto p-2">Writer Dashboard</h1>
            <button style="max-height: 40px;margin-top:25px;" type="button" class="btn btn-primary btn-success p-2"
                data-bs-toggle="modal" data-bs-target="#exampleModal">
                Tambah Story
            </button>
        </div>
        <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="messageModalLabel">Message</h5>
                    </div>
                    <div class="modal-body">
                        <?php
                        if (isset($_SESSION['message'])) {
                            echo $_SESSION['message'];
                            unset($_SESSION['message']);
                        }
                        ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4  d-flex justify-content-around ">

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
            $sql = "SELECT id, author, image_path, title, description FROM stories WHERE author = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $author);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="card me-auto p-2" style="width: 18rem;background-color:#F1F1F1;" >';
                    echo '<br>';
                    echo '<img src="../write/' . $row["image_path"] . '" class="card-img-top" alt="...">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $row['title'] . '</h5>' . '<h7 style="font-style:italic;">' . '</h7> <br>';
                    echo '<p class="card-text">' . substr($row["description"], 0, 50) . '...' . '</p>';
                    echo '</div>';
                    echo '<ul class="list-group list-group-flush">';
                    echo '<div class="card-body">';
                    echo '<a href="../read/story.writer.php?id=' . $row["id"] . '" class="card-link">' . 'Read More' . '</a>';
                    echo "<a href='delete_story.php?id=" . $row['id'] . "' class='card-link'>Delete</a>";
                    echo "<a href='edit_story.php?id=" . $row['id'] . "' class='card-link'>Edit</a>";
                    echo "<a href='add_chapter.php?id=" . $row['id'] . "' class='card-link'>Add Chapter</a>";
                    echo '</div>';
                    echo '</ul>';
                    echo '</div>';
                }
            } else {
                echo "<tr><td colspan='3'>No stories found.</td></tr>";
            }

            // Close statement and connection
            $stmt->close();
            $conn->close();
            ?>
        </div>

        <hr>

        <div>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h1 class="mt-5 mb-4">Submit Your Story</h1>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
                                enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="image">Thumbnail:</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="title">Title:</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                                <div class="form-group">
                                    <label for="description">Synopsis:</label>
                                    <textarea class="form-control" id="description" name="description" maxlength="1500"
                                        rows="5" required></textarea>
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
                                    <input type="text" class="form-control" id="new-tag" name="new-tag"
                                        placeholder="Enter new tag">
                                    <button type="button" class="btn btn-primary" onclick="registerNewTag()">Register
                                        Tag</button>
                                </div>
                                <div id="tag-registration-status"></div>
                                <div class="form-group">
                                    <label for="tags">Tags:</label>
                                    <input type="text" class="form-control" id="tags" name="addtags" readonly>
                                    <div id="tag-options">
                                        <?php include 'tags.php' ?>
                                    </div>
                                    <div id="selected-tags"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary position-start">Submit</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

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
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
            integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
            crossorigin="anonymous"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var messageModal = new bootstrap.Modal(document.getElementById('messageModal'));
                var modalElement = document.getElementById('messageModal');

                if (modalElement.querySelector('.modal-body').innerHTML.trim() !== '') {
                    messageModal.show();

                    setTimeout(function () {
                        modalElement.classList.add('fade-out');
                        setTimeout(function () {
                            messageModal.hide();
                            modalElement.classList.remove('fade-out');
                        }, 1000); // Match the CSS transition duration
                    }, 3000); // Show the modal for 3 seconds
                }
            });
        </script>
</body>

</html>