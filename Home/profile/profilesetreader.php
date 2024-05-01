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
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Password should be hashed before storing in database

    // Update user information in the database
    $sql = "UPDATE users SET username=?, email=?, password=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $username, $email, $password, $_SESSION['user_id']);

    if ($stmt->execute()) {
        echo "<p class='text-success'>Profile updated successfully.</p>";
    } else {
        echo "<p class='text-danger'>Error updating profile: " . $conn->error . "</p>";
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
    <link rel="stylesheet" href="./style/profileset.css">
</head>
<header>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" style="background-color: #135D66;padding-top:0;padding-left:0px;padding-right:0px;">
        <div style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"class="container-fluid">
            <img style="width:68px;height:68px;"class=navbar-brand src="../image/Blue Wood (2).png">
                <ul class="navbar-nav ms-auto"> <!-- Adjusted to mx-auto -->
                    <li class="nav-item">
                        <a class="nav-link"  href="../homereader.php">
                            <img style="width:36px;height:36px;" src="../image/icons8-home-480.png" href="#">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" style="background-color:#E3FEF7;border:transparent;border-radius:35px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);" aria-current="page" href="./profileset.php">
                            <img style="width:36px;height:36px;" src="../image/user_1077012.png" href="#">
                            <div style="position: absolute; background-color: #E3FEF7; width: 10px; height: 10px; border-radius: 50%;margin-left:13px;margin-top:10px;"></div>
                        </a>
                    </li>
                </ul>
        </div>
    </nav>
</header>
<body style="margin-top:100px;">

    <h2 style="margin-left: 50px;margin-right: 50px;">Profile Settings</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label style="margin-left: 50px;margin-right: 50px;"for="username">Username:</label>
        <input style="margin-left: 50px;margin-right: 50px;"type="text" id="username" name="username" value="<?php echo $_SESSION['username']; ?>" required><br><br>

        <label style="margin-left: 50px;margin-right: 50px;"for="email">Email:</label>
        <input style="margin-left: 50px;margin-right: 50px;"type="email" id="email" name="email" required><br><br>

        <label style="margin-left: 50px;margin-right: 50px;"for="password">Password:</label>
        <input style="margin-left: 50px;margin-right: 50px;"type="password" id="password" name="password" required><br><br>

        <input style="margin-left: 50px;margin-right: 50px;"type="submit" value="Update">
    </form>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>


</html>
