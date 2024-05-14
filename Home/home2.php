<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Home</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="pills-genre-tab" data-bs-toggle="pill" data-bs-target="#pills-genre" type="button" role="tab" aria-controls="pills-genre" aria-selected="false">Genre</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="pills-favorite-tab" data-bs-toggle="pill" data-bs-target="#pills-favorite" type="button" role="tab" aria-controls="pills-favorite" aria-selected="false">Favorite</button>
  </li>
</ul>
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
    <?php include 'home.php'?>
  </div>
  <div class="tab-pane fade" id="pills-genre" role="tabpanel" aria-labelledby="pills-genre-tab" tabindex="0">
    <?php include './genre/genre.php'?>
  </div>
  <div class="tab-pane fade" id="pills-favorite" role="tabpanel" aria-labelledby="pills-favorite-tab" tabindex="0">...</div>
  <div class="tab-pane fade" id="pills-disabled" role="tabpanel" aria-labelledby="pills-disabled-tab" tabindex="0">...</div>
</div>