<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style/style.css">
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow">
            <h1 class="text-center">Welcome to A3</h1>
            <p class="text-center">Create your account!</p>
            <ul class="nav nav-tabs justify-content-center" id="signupTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="writer-tab" data-toggle="tab" href="#writer" role="tab"
                        aria-controls="writer" aria-selected="true">Writer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="reader-tab" data-toggle="tab" href="#reader" role="tab"
                        aria-controls="reader" aria-selected="false">Reader</a>
                </li>
            </ul>
            <div class="tab-content" id="signupTabContent">
                <div class="tab-pane fade show active" id="writer" role="tabpanel" aria-labelledby="writer-tab">
                    <form id="writer-form" class="mt-3" action="register.php" method="post">
                        <input type="hidden" name="role" value="writer">
                        <div class="form-group">
                            <input type="text" class="form-control" name="username" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                    </form>
                </div>
                <div class="tab-pane fade" id="reader" role="tabpanel" aria-labelledby="reader-tab">
                    <form id="reader-form" class="mt-3" action="register.php" method="post">
                        <input type="hidden" name="role" value="reader">
                        <div class="form-group">
                            <input type="text" class="form-control" name="username" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                    </form>
                </div>
            </div>
            <br>
            <a href="login.php">Do you Have an account?</a>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<?php
session_start();

// Koneksi ke database
$db = mysqli_connect("localhost", "root", "", "alternate_arc");

// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan data dari formulir
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $role = mysqli_real_escape_string($db, $_POST['role']);

    // Debug: Check if data is received correctly
    echo "Received data: username=$username, email=$email, password=$password, role=$role<br>";

    // Periksa apakah username atau email sudah digunakan
    $query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $result = mysqli_query($db, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($db));
    }

    if (mysqli_num_rows($result) > 0) {
        // Username atau email sudah digunakan
        $error_message = "Username atau email sudah digunakan!";
        echo $error_message;  // Debug: Show error message
    } else {
        // Tambahkan user baru ke database dengan peran sesuai
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $insert_query = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$hashed_password', '$role')";
        $insert_result = mysqli_query($db, $insert_query);

        if (!$insert_result) {
            die("Insert query failed: " . mysqli_error($db));
        }

        $_SESSION['username'] = $username;

        if ($role == 'writer') {
            header("Location: ./login.php");
        } else {
            header("Location: ./login.php");
        }
        exit();
    }
}
?>