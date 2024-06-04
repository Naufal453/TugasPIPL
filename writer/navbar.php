<?php
include '../config/config.php';
checkLoggedIn();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alternate Arc Archive</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-title {
            font-weight: bold;
        }

        .card-text {
            white-space: pre-line;
        }

        .profile-dropdown {
            position: relative;
            display: inline-block;
        }

        .profile-dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .profile-dropdown:hover .profile-dropdown-content {
            display: block;
        }

        /* Added styles for fixed bar */
        .fixed-bar {
            background-color: #496989;
            color: #fff;
            padding: 10px;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            /* Ensure it's above the navbar */
        }
    </style>
</head>

<body>

    <!-- Fixed bar above navbar -->
    <div class="fixed-bar">
        <nav class="navbar navbar-light " style="color:#496989;">
            <a class="navbar-brand text-white" href="#">Alternate Arc Archive</a>
            <form class="form-inline">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            </form>
            <div class="profile-dropdown">
                <img src="https://via.placeholder.com/40" class="rounded-circle" alt="User Avatar">
                <div class="profile-dropdown-content p-3">
                    <?php

                    // Display user profile information from session
                    echo '<p class="mb-0"><strong>' . $_SESSION['username'] . '</strong></p>';
                    echo '<p class="mb-0"><strong>' . $_SESSION['email'] . '</strong></p>';
                    // echo '<p class="mb-0">' . $_SESSION['role'] . '</p>';
                    echo '<a href="../write/">' . 'Nulis' . '</a><br>';
                    echo '<a href="profile/profile.php">' . 'Profile Setting' . '</a><br>';
                    echo '<a href="logout.php">' . 'Logout' . '</a><br>';


                    // <a href="#" class="btn btn-primary btn-block">Pengaturan</a>
                    // <a href="#" class="btn btn-danger btn-block">Logout</a>
                    ?>
                </div>
            </div>
        </nav>
    </div>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>

</html>