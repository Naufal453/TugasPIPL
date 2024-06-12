<?php
include '../config/config.php';
$conn = connectDatabase();
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve form data
    $new_username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Password should be hashed before storing in database

    $sql = "UPDATE users SET username=?, email=?, password=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $new_username, $email, $password, $_SESSION['user_id']);

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
    <title>Profile Settings</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./style/profileset.css">
</head>
<header>
    <?php include 'navbarreader.php' ?>
</header>

<body style="margin-top:100px;">

    <h2 style="margin-top:100px;margin-left: 50px;margin-right: 50px;">Profile Settings</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label style="margin-left: 50px;margin-right: 50px;" for="username">Username:</label>
        <input style="margin-left: 50px;margin-right: 50px;" type="text" id="username" name="username"
            value="<?php echo $_SESSION['username']; ?>" required><br><br>

        <label style="margin-left: 50px;margin-right: 50px;" for="email">Email:</label>
        <input style="margin-left: 50px;margin-right: 50px;" type="email" id="email" name="email" required><br><br>

        <label style="margin-left: 50px;margin-right: 50px;" for="password">Password:</label>
        <input style="margin-left: 50px;margin-right: 50px;" type="password" id="password" name="password"
            required><br><br>

        <input style="margin-left: 50px;margin-right: 50px;" type="submit" value="Update">
    </form>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>


</html>