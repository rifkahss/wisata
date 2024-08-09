<?php
session_start();
include('../db/db_connection.php');

if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];

    $image = $_FILES['image']['name'];
    $target_dir = "assets/img/";
    $target_file = $target_dir . basename($image);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES['image']['tmp_name']);
    if ($check === false) {
        $error = "File yang diupload bukan gambar.";
        $uploadOk = 0;
    }

    if ($_FILES['image']['size'] > 500000) {
        $error = "File terlalu besar.";
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $error = "Hanya format JPG, JPEG, PNG, & GIF yang diizinkan.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        $error = "Gambar tidak terupload.";
    } else {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $query = "INSERT INTO facilities (name, description, image) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sss', $name, $description, $image);

            if ($stmt->execute()) {
                $success = "Fasilitas berhasil ditambahkan.";
            } else {
                $error = "Terjadi kesalahan: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $error = "Terjadi kesalahan saat mengupload gambar.";
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Fasilitas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/add.css">
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
        <h3 class="text-center"><strong>Tambah Fasilitas Baru</strong></h3>
        
        <?php if (isset($success)) echo "<p class='alert alert-success'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p class='alert alert-danger'>$error</p>"; ?>
        
        <form action="add_facility.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Nama Fasilitas</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Gambar Fasilitas</label>
                <input type="file" class="form-control-file" id="image" name="image" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Fasilitas</button>
        </form>
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