<?php
include '../config/config.php'
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="./style/story.css">
    <meta name="viewport" content="width=device-width, initial-scale=3"> 

</head>
<body style="background-color:#E3FEF7;";>
        <div class="container">
            <div class="sidebar">
                <ul>
                    <a href="../homereader.php">Kembail ke Home</a>
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
            
            
                <!-- <div class="buttons">
                    <button class="vote-button"><img src="asset/vote button.svg" alt="vote-button"></button>
                    <button class="comment-button"><img src="asset/comment button.svg" alt="comment-button"></button>
                    <button class="prev-button"><img src="asset/previous chapter button.svg" alt="prev-button"></button>
                    <button class="next-button"><img src="asset/next chapter button.svg" alt="next-button"></button>
                </div> -->

</body>
</html>