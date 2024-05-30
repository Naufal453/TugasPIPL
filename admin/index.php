<?php 
include '../config/config.php';
$stories = fetchStories()
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Story</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <h1>Admin Dashboard</h1>
<div class="list-group">
    <?php 
    foreach ($stories as $story) {
        echo '<button type="button" class="list-group-item list-group-item-action">';
        echo '<p>Title: '. $story["title"] . '<p>';
        echo '<p>Author: '. $story["author"] . '<p>';
        echo '<a href>'. 'Lihat' . '</a>';
        echo '<br>';
        echo '<a href>'. 'Hapus' . '</a>';
        echo'</button>';
    }
    ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>