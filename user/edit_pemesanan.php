<?php
$pageTitle = "Edit Pemesanan";

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
    } else {
        echo "Pesanan tidak ditemukan.";
        exit;
    }

    $stmt->close();
} else {
    echo "ID pemesanan tidak diberikan.";
    exit;
}

// Proses pembaruan data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $namaPemesan = $_POST['nama_pemesan'];
    $nomorHp = $_POST['nomor_hp'];
    $waktuPelaksanaan = $_POST['waktu_pelaksanaan'];
    $jumlahPeserta = $_POST['jumlah_peserta'];
    $durasi = $_POST['durasi'];
    $penginapan = isset($_POST['penginapan']) ? 1000000 : 0;
    $transportasi = isset($_POST['transportasi']) ? 1200000 : 0;
    $makanan = isset($_POST['makanan']) ? 500000 : 0;

    // Validasi data
    if (empty($namaPemesan) || empty($nomorHp) || empty($tanggalPemesanan) || empty($waktuPelaksanaan) || empty($jumlahPeserta) || empty($durasi)) {
        $error = "Data form pemesanan belum terisi.";
    } else {
        // Menghitung harga paket perjalanan
        $hargaPaket = $penginapan + $transportasi + $makanan;
        $totalBiaya = $hargaPaket * $jumlahPeserta * $durasi;

        // Query untuk memperbarui data pemesanan
        $sql = "UPDATE orders SET name = ?, phone = ?, date = ?, time = ?, participants = ?, duration_days = ?, accommodations = ?, transportation = ?, food = ?, total_cost = ?, edited_at = NOW() WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssiiiiidi', $namaPemesan, $nomorHp, $tanggalPemesanan, $waktuPelaksanaan, $jumlahPeserta, $durasi, $penginapan, $transportasi, $makanan, $totalBiaya, $orderId);

        if ($stmt->execute()) {
            // Jika berhasil, arahkan kembali ke halaman daftar pemesanan
            header("Location: reservations.php?status=updated");
            exit();
        } else {
            echo "Terjadi kesalahan saat memperbarui pesanan: " . $stmt->error;
        }

        $stmt->close();
    }
    
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/form.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Edit Pemesanan</h1>
        <form action="edit_pemesanan.php?id=<?php echo htmlspecialchars($orderId); ?>" method="POST">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <div class="form-group">
                <label for="nama_pemesan">Nama Pemesan</label>
                <input type="text" class="form-control" id="nama_pemesan" name="nama_pemesan" value="<?php echo htmlspecialchars($namaPemesan); ?>" required>
            </div>
            <div class="form-group">
                <label for="nomor_hp">Nomor HP/Telp</label>
                <input type="text" class="form-control" id="nomor_hp" name="nomor_hp" value="<?php echo htmlspecialchars($nomorHp); ?>" required>
            </div>
            <div class="form-group">
                <label for="waktu_pelaksanaan">Tanggal Pelaksanaan Perjalanan</label>
                <input type="date" class="form-control" id="waktu_pelaksanaan" name="waktu_pelaksanaan" value="<?php echo htmlspecialchars($waktuPelaksanaan); ?>" required>
            </div>
            <div class="form-group">
                <label for="jumlah_peserta">Jumlah Peserta</label>
                <input type="number" class="form-control" id="jumlah_peserta" name="jumlah_peserta" value="<?php echo htmlspecialchars($jumlahPeserta); ?>" required>
            </div>
            <div class="form-group">
                <label for="durasi">Durasi (hari)</label>
                <input type="number" class="form-control" id="durasi" name="durasi" value="<?php echo htmlspecialchars($durasi); ?>" required>
            </div>
            <div class="form-group">
                <label for="penginapan">Penginapan Rp. 1.000.000</label>
                <input type="checkbox" id="penginapan" name="penginapan" <?php echo $penginapan ? 'checked' : ''; ?>>
            </div>
            <div class="form-group">
                <label for="transportasi">Transportasi Rp. 1.200.000</label>
                <input type="checkbox" id="transportasi" name="transportasi" <?php echo $transportasi ? 'checked' : ''; ?>>
            </div>
            <div class="form-group">
                <label for="makanan">Makanan Rp. 500.000</label>
                <input type="checkbox" id="makanan" name="makanan" <?php echo $makanan ? 'checked' : ''; ?>>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div><br><br>
</body>
</html>