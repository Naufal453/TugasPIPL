<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Story Details</title>
    <link rel="stylesheet" href="./style/story.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" style="padding-top:0;">
        <div style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"class="container-fluid">
        <img style="width:68px;height:68px;"class=navbar-brand src="..\image\Blue Wood (2).png">
            <form class="d-flex navbar-search" method="GET" action="search.php"> <!-- Moved the search form here -->
                <input style="border-radius:15px;box-shadow: inset 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success"style="" id="search"type="submit">
                    <img style="width:36px;height:36px;"src="..\image\search.png" alt="">
                </button>
            </form>
            
                <ul class="navbar-nav ms-auto"> <!-- Adjusted to mx-auto -->
                    <li class="nav-item">
                        <a class="nav-link"  href="../home.php">
                            <img style="width:36px;height:36px;" src="..\image\icons8-home-480.png" href="#">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../write/input.php" >
                            <img style="width:36px;height:36px;" src="..\image\bookshelf (1).png" href="">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="" href="../profile/profileset.php">
                            <img style="width:36px;height:36px;" src="..\image\user_1077012.png" href="#">
                        </a>
                    </li>
                </ul>
                
        </div>
    </nav>
<?php
    // Establish database connection
    $conn = new mysqli("localhost", "root", "", "alternate_arc");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve story data based on the ID passed in the URL
    if (isset($_GET['id'])) {
        $story_id = $_GET['id'];
        
        // Prepare and execute SQL query
        $stmt = $conn->prepare("SELECT title, description FROM stories WHERE id = ?");
        $stmt->bind_param("i", $story_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch story details
            $row = $result->fetch_assoc();
            $description = $row["description"];
            $title = $row["title"];

            // Output story description
            echo '<div style="margin-top:150px;" class="title">';
            echo '<h2 style="padding-top:15px;">' . $title .'</h2>';
            echo '</div>';
            echo '<div class="description">';
            echo '<p class="indented">' . $description . '</p>';
            echo '</div>';
            
        } else {
            echo "Story not found.";
        }
        // Close the result set
        $result->close();
        // Close the statement
        $stmt->close();
    } else {
        echo "No story ID provided.";
    }

    // Close database connection
    $conn->close();
    
    ?>
<a style="margin-left:25px; "href="../home.php">Kembail ke Home</a>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
