<?php
include 'config/config.php';
$stories = fetchStories();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Story</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./style/home.css">
</head>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" style="padding-top:0;">
        <div style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"class="container-fluid">
        <img style="width:68px;height:68px;"class=navbar-brand src="image\Blue Wood (2).png">
        <form class="d-flex navbar-search" method="GET" action="search.php">
            <input name="query" style="border-radius:15px;box-shadow: inset 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" style="" id="search" type="submit">
                <img style="width:36px;height:36px;" src="image\search.png" alt="">
            </button>
        </form>
            <ul class="navbar-nav ms-auto"> 
                <li class="nav-item">
                    <button class="nav-link active" style="background-color:#E3FEF7;border:transparent;border-radius:35px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);" aria-current="page" href="#">
                        <img style="width:36px;height:36px;" src="image\icons8-home-480.png" href="#">
                        <div style="position: absolute; background-color: #E3FEF7; width: 10px; height: 10px; border-radius: 50%;margin-left:13px;margin-top:10px;"></div>
                    </button>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./write" >
                        <img style="width:36px;height:36px;" src="image\bookshelf (1).png" href="">
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="" href="./profile/profileset.php">
                        <img style="width:36px;height:36px;" src="image\user_1077012.png" href="#">
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./logout.php" style="background-color:red;">
                        Log out
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<body style="background-color:#E3FEF7;">
    <div class="container mt-5 pt-3">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php
                foreach ($stories as $story) {
                    echo '<div class="col" style="margin-bottom:30px;">';
                    echo '<a href="./read/story.php?id=' . $story["id"] . '" class="card-link">';
                    echo '<div class="story card">';
                    echo '<div class="card-body" >';
                    echo '<h5 class="card-title">' . $story["title"] . '</h5>';
                    echo '<img src="image\book_3145755.png" style="display: block; margin: auto;width:72px;height:72px;margin-top:70px;">';
                    echo '<h6 class="card-subtitle mb-2 text-muted" style="text-align:center;position: absolute; bottom: 10px; left: 10px; right: 10px;">Author: ' . $story["author"] . '</h6>';
                    echo '</div>'; // close card-body
                    echo '</div>'; // close card
                    echo '</a>'; // close anchor tag
                    echo '</div>'; // close col
                }
            ?>
        </div> <!-- close row -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
