<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paket Wisata - Scientia Square Park</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/paket.css">
</head>
<body>

<?php
$pageTitle = "Paket Wisata";
include 'includes/header.php';
?>

<div class="container">
    <h3 class="text-center"><strong>Paket Wisata</strong></h3><br>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="assets/img/penginapan.jpg" class="card-img-top" alt="Penginapan">
                <div class="card-body">
                    <h5 class="card-title">Penginapan</h5>
                    <p class="card-text">Nikmati penginapan yang nyaman selama perjalanan Anda.</p>
                    <p class="card-text"><strong>Harga: Rp. 1.000.000/orang</strong></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="assets/img/transportasi.jpg" class="card-img-top" alt="Transportasi">
                <div class="card-body">
                    <h5 class="card-title">Transportasi</h5>
                    <p class="card-text">Transportasi yang aman dan nyaman untuk perjalanan Anda.</p>
                    <p class="card-text"><strong>Harga: Rp. 1.200.000/orang</strong></p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="assets/img/makanan.jpg" class="card-img-top" alt="Makanan">
                <div class="card-body">
                    <h5 class="card-title">Makanan</h5>
                    <p class="card-text">Nikmati kuliner beraneka rasa dengan berbagai pilihan makanan.</p>
                    <p class="card-text"><strong>Harga: Rp. 500.000/orang</strong></p>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="form_pemesanan.php" class="btn btn-primary">Pesan Paket Wisata</a>
    </div>
</div>
    
<?php
include 'includes/footer.php';
?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>