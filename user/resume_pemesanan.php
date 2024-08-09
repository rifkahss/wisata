<?php
$pageTitle = "Resume Pemesanan";

include '../db/db_connection.php';

// Cek apakah ID pemesanan ada di URL
if (isset($_GET['id'])) {
    $orderId = intval($_GET['id']);

    // Query untuk mendapatkan detail pemesanan
    $sql = "SELECT * FROM orders WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $orderId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
        $namaPemesan = $order['name'];
        $nomorHp = $order['phone'];
        $tanggalPemesanan = $order['date'];
        $waktuPelaksanaan = $order['time'];
        $jumlahPeserta = $order['participants'];
        $durasi = $order['duration_days'];
        $penginapan = $order['accommodations'];
        $transportasi = $order['transportation'];
        $makanan = $order['food'];
        $totalCost = $order['total_cost'];
    } else {
        echo "Pesanan tidak ditemukan.";
        exit;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ID pemesanan tidak diberikan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/resume.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3 class="text-center">Ringkasan Pemesanan</h3>
            </div>
            <div class="card-body">
                <p><strong>Nama Pemesan:</strong> <?php echo htmlspecialchars($namaPemesan); ?></p>
                <p><strong>Nomor HP/Telp:</strong> <?php echo htmlspecialchars($nomorHp); ?></p>
                <p><strong>Tanggal Pemesanan:</strong> <?php echo htmlspecialchars($tanggalPemesanan); ?></p>
                <p><strong>Tanggal Pelaksanaan Perjalanan:</strong> <?php echo htmlspecialchars($waktuPelaksanaan); ?></p>
                <p><strong>Biaya Penginapan:</strong> Rp. <?php echo number_format($penginapan, 0, ',', '.'); ?></p>
                <p><strong>Biaya Transportasi:</strong> Rp. <?php echo number_format($transportasi, 0, ',', '.'); ?></p>
                <p><strong>Biaya Makanan:</strong> Rp. <?php echo number_format($makanan, 0, ',', '.'); ?></p>
                <p><strong>Jumlah Peserta:</strong> <?php echo htmlspecialchars($jumlahPeserta); ?></p>
                <p><strong>Durasi (hari):</strong> <?php echo htmlspecialchars($durasi); ?></p>
                <p><strong>Total Biaya:</strong> Rp. <?php echo number_format($totalCost, 0, ',', '.'); ?></p>
            </div>
            <div class="card-footer text-center">
                <a href="form_pemesanan.php" class="btn btn-secondary">Pesan Lagi</a>
                <a href="reservations.php" class="btn btn-primary">Lihat Daftar Reservasi</a>
            </div>
        </div>
    </div>
</body>
</html>
