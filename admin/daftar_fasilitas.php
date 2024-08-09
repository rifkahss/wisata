<?php
session_start();
include('../db/db_connection.php');

if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}

$query = "SELECT * FROM facilities";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Fasilitas - Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/daftar.css">
    <link rel="stylesheet" href="assets/css/header.css">
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
        <h3 class="text-center"><strong>Daftar Fasilitas</strong></h3><br>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '
                        <tr>
                            <td>'.$row['id'].'</td>
                            <td>'.$row['name'].'</td>
                            <td>'.substr($row['description'], 0, 50).'</td>
                            <td><img src="assets/img/'.$row['image'].'" alt="'.$row['name'].'" style="width: 100px;"></td>
                            <td>
                                <a href="edit_facility.php?id='.$row['id'].'" class="btn btn-primary btn-sm">Edit</a>
                                <a href="delete_facility.php?id='.$row['id'].'" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\')">Hapus</a>
                            </td>
                        </tr>';
                    }
                } else {
                    echo '<tr><td colspan="5">Belum ada fasilitas yang tersedia.</td></tr>';
                }

                $conn->close();
                ?>
            </tbody>
        </table>

        <a href="add_facility.php" class="btn btn-success">Tambah Fasilitas</a>
    </div>

    </main>
    <script>
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.classList.toggle('active');
    }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
