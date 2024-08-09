<?php
session_start();
include('../db/db_connection.php');

if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}

$query = "SELECT * FROM orders";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pemesanan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/pemesanan.css">
</head>
<body>
    <button class="menu-toggle" onclick="toggleSidebar()">☰</button>
            <div class="wrapper">
                <aside class="sidebar">
                    <a href="dashboard.php" class="logo">
                        <img src="assets/img/logo.png" alt="Logo">
                    </a>
                    <nav>
                        <ul>
                            <li><a href="dashboard.php"><strong>Dashboard</strong></a></li>
                            <li><a href="daftar_fasilitas.php"><strong>Daftar Fasilitas</strong></a></li>
                            <li><a href="daftar_pemesanan.php"><strong>Daftar Pemesanan</strong></a></li>
                            <li><a href="logout.php" class="btn btn-danger text-white">Logout</a></li>
                        </ul>
                    </nav>
                </aside>
        <main class="content">

    <div class="container mt-4">
        <h3 class="text-center"><strong>Daftar Pemesanan</strong></h3><br>
        <div class="table-container">
            <table class="table table-striped table-responsive">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Nomor HP/Telp</th>
                        <th>Tanggal Pemesanan</th>
                        <th>Waktu Pelaksanaan</th>
                        <th>Jumlah Peserta</th>
                        <th>Durasi (Hari)</th>
                        <th>Penginapan</th>
                        <th>Transportasi</th>
                        <th>Food</th>
                        <th>Total Biaya</th>
                        <th>Created At</th>
                        <th>Edited At</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['phone']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['date']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['time']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['participants']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['duration_days']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['accommodations']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['transportation']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['food']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['total_cost']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['created_at']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['edited_at']) . '</td>';
                            echo '<td><button class="btn btn-success" onclick="completeOrder(' . $row['id'] . ')">Selesai</button></td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="13" class="text-center">Belum ada pemesanan yang tersedia.</td></tr>';
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Konfirmasi Penghapusan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menandai pesanan ini sebagai selesai?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <a href="#" id="confirmDeleteButton" class="btn btn-danger">Selesai</a>
                </div>
            </div>
        </div>
    </div>

    </main>
    <script>
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.classList.toggle('active');
    }
    </script>
    <script>
        let deleteUrl = '';

        function completeOrder(orderId) {
            deleteUrl = 'delete_reservation.php?id=' + orderId;
            $('#confirmationModal').modal('show');
        }

        document.getElementById('confirmDeleteButton').addEventListener('click', function() {
            window.location.href = deleteUrl;
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
