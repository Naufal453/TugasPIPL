<?php
include '../config/config.php'
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Story</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    .container {
        display: flex;
        height: 100vh;
    }

    .sidebar {
        background-color: #4a678b;
        color: white;
        padding: 20px;
        width: 250px;
    }

    .sidebar h1 {
        font-size: 24px;
        margin-bottom: 20px;
    }

    .sidebar nav ul {
        list-style-type: none;
        padding: 0;
    }

    .sidebar nav ul li {
        margin: 10px 0;
    }

    .sidebar nav ul li a {
        color: white;
        text-decoration: none;
    }

    .content {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
    }

    .story-info {
        margin-bottom: 20px;
    }

    .story-info p {
        margin: 5px 0;
    }

    .chapter {
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        padding: 20px;
    }

    .chapter h2 {
        margin-top: 0;
    }

    .controls {
        display: flex;
        justify-content: space-around;
        margin-top: 20px;
    }

    .controls button {
        background-color: #4a678b;
        border: none;
        color: white;
        cursor: pointer;
        padding: 10px 20px;
        text-transform: uppercase;
    }

    .controls button:hover {
        background-color: #3b506f;
    }
</style>

<body>
    <div class="container">
        <aside class="sidebar" style="list-style-type: none;">
            <a href="../writer">Kembali ke Home</a>
            <br>
            <br>
            <?php
            include 'include/sidebar.php';
            ?>
        </aside>
        <main class="content">
            <section class="story-info">
                <?php include 'include/info.php'; ?>
            </section>
            <section class="chapter">
                <?php
                include 'include/summary.php';
                ?>
            </section>
        </main>
    </div>
</body>

</html>