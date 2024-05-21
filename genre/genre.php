<?php

// Ambil daftar Addtags dari database atau dari array yang tersedia
$addtags = ["Fantasy", "Sci-Fi", "Romance", "Adventure", "Mystery"];

// Tampilkan setiap Addtags sebagai list item
foreach ($addtags as $tag) {
    echo '<li class="nav-item">
            <a class="nav-link" href="search.php?addtags=' . urlencode($tag) . '">' . $tag . '</a>
          </li>';
}
?>
