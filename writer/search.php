<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./style/home.css">
</head>
<style>
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

    .card-title {
        font-weight: bold;
    }

    .card-text {
        white-space: pre-line;
    }

    .form-inline {
        display: flex;
        align-items: center;
    }

    .form-control {
        margin-left: 10px;
        border-radius: 15px;
        box-shadow: inset 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }
</style>

<body style="background-color:#FFFFFF;">
    <div class="fixed-bar">
        <nav class="navbar navbar-light d-flex" style="color:#496989;">
            <a class="navbar-brand text-white p-2 flex-grow-1" href="#">Alternate Arc Archive</a>
            <form class="form-inline p-2" method="GET" action="search.php">
                <button class="btn btn-outline-success" id="search" type="submit">
                    <img style="width:36px;height:36px;" src="../image/search.png" alt="">
                </button>
                <input name="query" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            </form>
        </nav>
    </div>
    <?php
    include '../config/config.php';
    if (isset($_GET['query'])) {
        $search_query = $_GET['query'];
        $search_results = searchStories($search_query);

        if (!empty($search_results)) {
            echo '<div class="container mt-5 pt-3">';
            echo '<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">';
            foreach ($search_results as $row) {
                echo '<div class="card me-auto p-2" style="width: 18rem;background-color:#F1F1F1;">';
                echo '<br>';
                echo '<img src="../write/' . $row["image_path"] . '" class="card-img-top" alt="...">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $row["title"] . '</h5>' . '<h7 style="font-style:italic;">' . ' by ' . $row["author"] . '</h7> <br>';
                echo '<p class="card-text">' . substr($row["description"], 0, 50) . '...' . '</p>';
                echo '</div>';
                echo '<ul class="list-group list-group-flush">';
                echo '<div class="card-body">';
                echo '<a href="../read/story.writer.php?id=' . $row["id"] . '" class="card-link">' . 'Read More' . '</a>';
                echo '</div>';
                echo '</ul>';
                echo '</div>';
            }
            echo '</div>';
            echo '</div>';
        } else {
            echo "No results found.";
        }
    } else {
        header("Location: index.php");
        exit;
    }
    ?>
    </div> <!-- close row -->

    </div>
    <a style="margin-left:25px; " href="index.php">Kembail ke Home</a>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>

</html>