<?php
session_start();

// Cek apakah pengguna sudah login
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

$pageTitle = "Daftar Reservasi";

include '../db/db_connection.php';

// Query untuk mendapatkan daftar pemesanan
$sql = "SELECT * FROM orders";
$result = $conn->query($sql);

// Cek apakah ada data reservasi
if ($result === FALSE) {
    die("Terjadi kesalahan saat mengambil data pemesanan: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/reservasi.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Jika halaman ini diakses tanpa login, konfirmasi dan arahkan pengguna
            <?php if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true): ?>
                if (confirm("Anda belum login. Ingin login sekarang?")) {
                    window.location.href = "register.php";
                } else {
                    window.location.href = "index.php"; // Arahkan ke halaman lain jika tidak ingin login
                }
            <?php endif; ?>
        });
    </script>
</head>
<body>
    <?php include('includes/header.php'); ?>

    <div class="container mt-5">
        <h3 class="text-center"><strong><?php echo htmlspecialchars($pageTitle); ?></strong></h3><br>
        
        <div class="table-container">
            <table class="table table-striped table-responsive">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Pemesan</th>
                        <th>Nomor HP/Telp</th>
                        <th>Tanggal Pemesanan</th>
                        <th>Tanggal Pelaksanaan</th>
                        <th>Jumlah Peserta</th>
                        <th>Durasi</th>
                        <th>Total Biaya</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td><?php echo htmlspecialchars($row['date']); ?></td>
                            <td><?php echo htmlspecialchars($row['time']); ?></td>
                            <td><?php echo htmlspecialchars($row['participants']); ?></td>
                            <td><?php echo htmlspecialchars($row['duration_days']); ?></td>
                            <td>Rp. <?php echo number_format($row['total_cost'], 0, ',', '.'); ?></td>
                            <td class="action-buttons">
                                <a href="generate_pdf.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">PDF</a>
                                <a href="edit_pemesanan.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal" data-id="<?php echo $row['id']; ?>">Hapus</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin akan menghapus pesanan ini?
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="POST" action="delete_pemesanan.php">
                        <input type="hidden" name="id" id="deleteId">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Ya, Saya Yakin</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="logout-container">
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    <?php include('includes/footer.php'); ?>

    <script>
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Tombol yang mengaktifkan modal
            var id = button.data('id'); // Mendapatkan data-id dari tombol
            var modal = $(this);
            modal.find('#deleteId').val(id);
        });
    </script>
</body>
</html>
