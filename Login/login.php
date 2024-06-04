<!DOCTYPE html>
<html lang="en">

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
            <p class="text-center">Login</p>
            <ul class="nav nav-tabs justify-content-center" id="loginTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="writer-tab" data-toggle="tab" href="#writer" role="tab"
                        aria-controls="writer" aria-selected="true">Writer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="reader-tab" data-toggle="tab" href="#reader" role="tab"
                        aria-controls="reader" aria-selected="false">Reader</a>
                </li>
            </ul>
            <div class="tab-content" id="loginTabContent">
                <div class="tab-pane fade show active" id="writer" role="tabpanel" aria-labelledby="writer-tab">
                    <form id="writer-form" class="mt-3" action="login.php" method="post">
                        <input type="hidden" name="role" value="writer">
                        <div class="form-group">
                            <input type="text" class="form-control" name="username" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </form>
                </div>
                <div class="tab-pane fade" id="reader" role="tabpanel" aria-labelledby="reader-tab">
                    <form id="reader-form" class="mt-3" action="login.php" method="post">
                        <input type="hidden" name="role" value="reader">
                        <div class="form-group">
                            <input type="text" class="form-control" name="username" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </form>
                </div>
            </div>
            <br>
            <a href="register.php">You don't have an account yet?</a>
            <br>
            <form action="login.admin.php">
                <button type="submit" class="btn btn-primary">
                    Login as admin
                </button>
            </form>

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
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $role = mysqli_real_escape_string($db, $_POST['role']);

    // Debug: Check if data is received correctly
    echo "Received data: username=$username, password=$password, role=$role<br>";

    // Mencari user di database
    $query = "SELECT * FROM users WHERE username = '$username' AND role = '$role'";
    $result = mysqli_query($db, $query);

    // Check if the query executed successfully
    if (!$result) {
        die("Query failed: " . mysqli_error($db));
    }

    // Mengecek apakah user ditemukan
    if (mysqli_num_rows($result) === 1) {
        // User ditemukan
        $user = mysqli_fetch_assoc($result);

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Login berhasil
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['email'] = $user['email'];

            if ($role === 'writer') {
                header("Location: ../writer");
            } elseif ($role === 'reader') {
                header("Location: ../reader");
            } else {
                echo "Invalid role!";
            }
            exit();
        } else {
            // Password salah
            echo "Password salah!";
        }
    } else {
        // User tidak ditemukan
        echo "Username atau peran tidak ditemukan!";
    }
}
?>