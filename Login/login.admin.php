<?php
session_start();

// Database Connection
$db = mysqli_connect("localhost", "root", "", "alternate_arc");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetching data from the form
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    // Searching for user in the database
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($db, $query);

    // Checking if user is found
    if (mysqli_num_rows($result) === 1) {
        // User found
        $user = mysqli_fetch_assoc($result);

        // Verifying password
        if (password_verify($password, $user['password'])) {
            // Checking user role
            if ($user['role'] === 'admin') {
                // Successful login
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                header("Location: ../admin");
                exit();
            } else {
                // User is not an admin
                echo '<div class="alert alert-danger" role="alert">You don\'t have permission to access this page.</div>';
            }
        } else {
            // Incorrect password
            echo '<div class="alert alert-danger" role="alert">Incorrect password!</div>';
        }
    } else {
        // User not found
        echo '<div class="alert alert-danger" role="alert">Username not found!</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alternate Arc Archive - Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/style.css">
</head>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style/style.css">
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow">
            <h1 class="text-center">Welcome to A3</h1>
            <p class="text-center">Admin</p>
            <div class="tab-content" id="loginTabContent">
                <div class="tab-pane fade show active" id="writer" role="tabpanel" aria-labelledby="writer-tab">
                    <form id="writer-form" class="mt-3" action="login.admin.php" method="post">
                        <input type="hidden" name="role" value="writer">
                        <div class="form-group">
                            <input type="text" class="form-control" name="username" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                        <br>
                        <a href="login.php"><- Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>