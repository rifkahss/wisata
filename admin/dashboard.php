<?php
session_start();
include('../db/db_connection.php');

if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}

$query = "SELECT * FROM facilities";
$result = $conn->query($query);

if ($result === false) {
    die("Error executing query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <link rel="stylesheet" href="assets/css/admin.css">
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
        <h3 class="text-center"><strong>Fasilitas Scientia Square Park</strong></h3>
        <a href="add_facility.php" class="btn btn-success mb-4">Tambah Fasilitas</a>
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <img src="assets/img/'.$row['image'].'" class="card-img-top" alt="'.$row['name'].'">
                            <div class="card-body">
                                <h5 class="card-title"><strong>'.$row['name'].'</strong></h5>
                                <p class="card-text">'.$row['description'].'</p>
                                <a href="edit_facility.php?id='.$row['id'].'" class="btn btn-primary">Edit</a>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo '<p>Belum ada fasilitas yang tersedia.</p>';
            }

            $conn->close();
            ?>
        </div>
    </div>

    </main>

    <script>
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.classList.toggle('active');
    }
    </script>
</body>
</html>