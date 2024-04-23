<?php
session_start();

// Koneksi ke database
$db = mysqli_connect("localhost", "root", "", "alternate_arc");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan data dari formulir
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    // Periksa apakah username atau email sudah digunakan
    $query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) > 0) {
        // Username atau email sudah digunakan
        $error_message = "Username atau email sudah digunakan!";
    } else {
        // Tambahkan user baru ke database dengan peran pembaca
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $insert_query = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$hashed_password', 'reader')";
        mysqli_query($db, $insert_query);
        $_SESSION['username'] = $username;
        header("Location: ./loginasreader.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>
<link href="https://fonts.googleapis.com/css?family=Inria+Sans&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Playfair+Display&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Inria+Serif&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Inknut+Antiqua&display=swap" rel="stylesheet">
<link rel="stylesheet" href="http://localhost/Tugaspipl/Home/Login/style/register.css">
<style>

</style>
</head>
<body>
<form action="registerasreader.php" method="post">
    <div class=e5_2>
        <div class="e5_3"></div>
        <span class="e13_18">Email</span>
        <span class="e5_5">Welcome to A3!</span>
        <input type="text" id="username" name="username" required class="e13_12"></input>
        <input type="email" id="email" name="email" required class="e5_6"></input>
        <input type="password" id="password" name="password" required class="e5_7"></input>
        <button type="submit" class="e5_8">Sign Up</button>
        <span class="e5_10">Username</span>
        <span class="e5_11">Password</span>
        <div class="e42_189"></div>
        <span class="e47_211">Register your account ! !</span>
        <span class="e50_305">Alternate Arc Archive</span>
        <br>
            <a href="http://localhost/Tugaspipl/Home/choose.php" style="position:absolute;margin-left:70px;margin-top:550px;font-size:20px;">back</a>
    </div>
</form>

<?php if(isset($error_message)) { ?>
    <p><?php echo $error_message; ?></p>
<?php } ?>
</div>
</div>
</body>
</html>
