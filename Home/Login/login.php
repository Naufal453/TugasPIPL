<?php
session_start();

// Koneksi ke database
$db = mysqli_connect("localhost", "root", "", "alternate_arc");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan data dari formulir
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    // Mencari user di database
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($db, $query);

    // Mengecek apakah user ditemukan
    if (mysqli_num_rows($result) === 1) {
        // User ditemukan
        $user = mysqli_fetch_assoc($result);

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Mengecek peran pengguna
            if ($user['role'] === 'writer') {
                // Login berhasil
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                header("Location: ../home.php");
                exit();
            } else {
                // Pengguna bukan penulis
                echo "Anda tidak memiliki izin untuk mengakses halaman ini.";
            }
        } else {
            // Password salah
            echo "Password salah!";
        }
    } else {
        // User tidak ditemukan
        echo "Username tidak ditemukan!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="http://localhost/Tugaspipl/Home/Login/style/login.css">
</head>
<body>
    <form action="login.php" method="post">
        <div class="e13_2">
            <div class="e13_3">
                
            </div>
            <span class="e13_4">Alternate Arc Archive</span>
            <span class="e13_5">Login</span>
            <input type="text" id="username" name="username" required="" class="e13_6">
            <input type="password" id="password" name="password" required="" class="e13_7">
            <button type="submit" class="e13_8">Sign In</button>
            <span class="e13_10">Username</span>
            <span class="e13_11">Password</span>
            <div class="e50_306"></div>
            <br>
            <a href="http://localhost/Tugaspipl/Home/choose.php" style="position:absolute;margin-left:70px;margin-top:550px;font-size:20px;">back</a>
        </div>
        <br>
    </form>
</body>
</html>
