<?php
include '../config/config.php'
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="./style/story.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="background-color:#E3FEF7;">
<div class="container">
    <div class="sidebar">
        <ul>
            <a href="../home.writer.php">Kembali ke Home</a>
            <br>
            <br>
            <li><?php include './include/sidebar.php'?></li>
        </ul>
    </div>
    <div class="content">
        <ul>
            <li class="info"><?php include './include/info.php'?></li>
            <li class="summary1"><?php include './include/summary.php'?></li>
        </ul>
    </div>
</div>
</body>
</html>
