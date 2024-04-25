<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to login page
    header("Location: https://localhost/Tugaspipl/Home/choose.php");
    exit;
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TestBench Home</title>
    <link rel="stylesheet" href="./style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://code.jquery.com/jquery-1.12.0.min.js">
</head>

<body>

<nav id="header" class="navbar navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="./assets/channels4_profile.jpg" alt="" width="30" height="30" class="d-inline-block align-text-top">
      Naufal's Web
    </a>
  </div>
</nav>
<ul class="nav justify-content-center">
<div class="tabs">
  <!-- Navbar -->
<input type="radio" class="tabs__radio" name="tabs-example" id="tab1" checked>
<label for="tab1" class="tabs__label">
<img style="width:36px;height:36px;" src="./image/icons8-home-480.png" href="#">
</label>
<div class="tabs__content">
    <iframe src="./script/read.php" width="100%" height="300"></iframe>
</div>
<input type="radio" class="tabs__radio" name="tabs-example" id="tab2">
<label for="tab2" class="tabs__label">
  <img style="width:36px;height:36px;" src="./image/bookshelf (1).png" href="#">
</label>
<div class="tabs__content">
    <iframe src="./script/input.php" width="100%" height="300"></iframe>
</div>
<input type="radio" class="tabs__radio" name="tabs-example" id="tab3">
<label for="tab3" class="tabs__label">About</label>
<div class="tabs__content">
    CONTENT for Tab #3
</div>
</ul>
</body>
</html>