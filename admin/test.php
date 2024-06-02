<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
        }
        .list-item {
            margin-bottom: 20px;
        }
        .list-item img {
            width: 100%;
        }
        .hapus-btn {
            background-color: red;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Admin Dashboard</h1>
        <div class="row">
            <div class="col-md-6">
                <h3>List Story</h3>
                <div class="list-item card">
                    <div class="card-body">
                        <h5 class="card-title">Revenant by kim eun he</h5>
                        <div class="media">
                            <img src="image_placeholder.jpg" class="mr-3" alt="Story Image">
                            <div class="media-body">
                                AYAM MIE AYAMMIE AYAM MIE AYAM MIE AYAM MIE AYAM
                                MIE AYAM MIE AYAM MIE AYAMMIE AYAM MIE AYAM MIE
                                AYAM MIE AYAM
                                MIE AYAM MIE AYAM MIE AYAMMIE AYAM MIE AYAM MIE
                                AYAM MIE AYAM
                                MIE AYAM MIE AYAM MIE AYAMMIE AYAM MIE AYAM MIE
                                AYAM MIE AYAM
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="mr-3"><i class="fa fa-heart"></i> 1,234 Lihat</span>
                            <button class="hapus-btn btn btn-sm">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h3>List Report</h3>
                <div class="list-item card">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Budi reported by Jokoadi</h6>
                        <p class="card-text">NOT APPROPRIATE FOR PUBLIC</p>
                        <p class="card-text"><strong>Budi's Comment:</strong> He is too black</p>
                        <p class="card-text"><small class="text-muted">posted at : 2024-05-30</small></p>
                        <button class="hapus-btn btn btn-sm">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
