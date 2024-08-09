<?php
session_start();

// Jika pengguna belum login, kirimkan script JavaScript untuk menampilkan pop-up konfirmasi
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo '<script type="text/javascript">
        if (confirm("Anda belum login. Ingin login sekarang?")) {
            window.location.href = "register.php";
        } else {
            window.location.href = "index.php"; // Arahkan ke halaman lain jika tidak ingin login
        }
    </script>';
    exit();
}

$pageTitle = "Form Pemesanan Paket Wisata";

// Jika form disubmit
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

    // Set tanggal pemesanan ke tanggal hari ini
    $tanggalPemesanan = date('Y-m-d');

    // Validasi data
    if (empty($namaPemesan) || empty($nomorHp) || empty($waktuPelaksanaan) || empty($jumlahPeserta) || empty($durasi)) {
        $error = "Data form pemesanan belum terisi.";
    } else {
        // Cek apakah waktu pelaksanaan tidak lebih awal dari tanggal pemesanan
        if ($waktuPelaksanaan < $tanggalPemesanan) {
            $error = "Waktu pelaksanaan tidak boleh sebelum tanggal pemesanan.";
        } else {
            // Menghitung harga paket perjalanan
            $hargaPaket = $penginapan + $transportasi + $makanan;
            $totalBiaya = $hargaPaket * $jumlahPeserta * $durasi;

            // Menyimpan ke database
            include '../db/db_connection.php';

            // Query yang diperbaiki
            $sql = "INSERT INTO orders (name, phone, date, time, participants, duration_days, accommodations, transportation, food, total_cost) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssssiiiiid', $namaPemesan, $nomorHp, $tanggalPemesanan, $waktuPelaksanaan, $jumlahPeserta, $durasi, $penginapan, $transportasi, $makanan, $totalBiaya);
            $stmt->execute();

            // Menampilkan halaman resume pemesanan
            header("Location: resume_pemesanan.php?id=" . $stmt->insert_id);
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fasilitas.css">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tanggalPemesananInput = document.getElementById('tanggal_pemesanan');
            const waktuPelaksanaanInput = document.getElementById('waktu_pelaksanaan');

            tanggalPemesananInput.addEventListener('change', function() {
                const tanggalPemesanan = new Date(this.value);
                const waktuPelaksanaan = new Date(waktuPelaksanaanInput.value);

                // Update min date for waktu_pelaksanaan
                if (waktuPelaksanaan < tanggalPemesanan) {
                    waktuPelaksanaanInput.setCustomValidity('Waktu pelaksanaan tidak boleh sebelum tanggal pemesanan.');
                } else {
                    waktuPelaksanaanInput.setCustomValidity('');
                }
            });

            waktuPelaksanaanInput.addEventListener('change', function() {
                const tanggalPemesanan = new Date(tanggalPemesananInput.value);
                const waktuPelaksanaan = new Date(this.value);

                // Validate if waktu_pelaksanaan is before tanggal_pemesanan
                if (waktuPelaksanaan < tanggalPemesanan) {
                    this.setCustomValidity('Waktu pelaksanaan tidak boleh sebelum tanggal pemesanan.');
                } else {
                    this.setCustomValidity('');
                }
            });
        });
    </script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4"><?php echo $pageTitle; ?></h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form-custom">
            <div class="form-group">
                <label for="nama_pemesan">Nama Pemesan</label>
                <input type="text" class="form-control" id="nama_pemesan" name="nama_pemesan" required>
            </div>
            <div class="form-group">
                <label for="nomor_hp">Nomor HP/Telp</label>
                <input type="text" class="form-control" id="nomor_hp" name="nomor_hp" required>
            </div>
            <div class="form-group">
                <label for="waktu_pelaksanaan">Tanggal Pelaksanaan Perjalanan</label>
                <input type="date" class="form-control" id="waktu_pelaksanaan" name="waktu_pelaksanaan" required>
            </div>
            <div class="form-group">
                <label for="jumlah_peserta">Jumlah Peserta</label>
                <input type="number" class="form-control" id="jumlah_peserta" name="jumlah_peserta" required>
            </div>
            <div class="form-group">
                <label for="durasi">Durasi/hari</label>
                <input type="number" class="form-control" id="durasi" name="durasi" required>
            </div>
            <div class="form-group">
                <label>Paket Perjalanan/orang</label><br>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="penginapan" name="penginapan">
                    <label class="form-check-label" for="penginapan">
                        Penginapan Rp. 1.000.000
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="transportasi" name="transportasi">
                    <label class="form-check-label" for="transportasi">
                        Transportasi Rp. 1.200.000
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="makanan" name="makanan">
                    <label class="form-check-label" for="makanan">
                        Makanan Rp. 500.000
                    </label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Kirim</button>
        </form>
        <br>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Validasi untuk memastikan waktu pelaksanaan tidak sebelum tanggal pemesanan
        document.addEventListener('DOMContentLoaded', function() {
            const tanggalPemesananInput = document.getElementById('tanggal_pemesanan');
            const waktuPelaksanaanInput = document.getElementById('waktu_pelaksanaan');

            tanggalPemesananInput.addEventListener('change', function() {
                const tanggalPemesanan = new Date(this.value);
                const waktuPelaksanaan = new Date(waktuPelaksanaanInput.value);

                // Update min date for waktu_pelaksanaan
                if (waktuPelaksanaan < tanggalPemesanan) {
                    waktuPelaksanaanInput.setCustomValidity('Waktu pelaksanaan tidak boleh sebelum tanggal pemesanan.');
                } else {
                    waktuPelaksanaanInput.setCustomValidity('');
                }
            });

            waktuPelaksanaanInput.addEventListener('change', function() {
                const tanggalPemesanan = new Date(tanggalPemesananInput.value);
                const waktuPelaksanaan = new Date(this.value);

                // Validate if waktu_pelaksanaan is before tanggal_pemesanan
                if (waktuPelaksanaan < tanggalPemesanan) {
                    this.setCustomValidity('Waktu pelaksanaan tidak boleh sebelum tanggal pemesanan.');
                } else {
                    this.setCustomValidity('');
                }
            });
        });
    </script>
</body>
</html>