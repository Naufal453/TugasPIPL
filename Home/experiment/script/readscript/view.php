
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/story.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<?php
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

    // Close database connection

    
    ?>

</body>
</html>