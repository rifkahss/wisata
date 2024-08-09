<?php
session_start();
include('../db/db_connection.php');

if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $query = "SELECT * FROM facilities WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $facility = $result->fetch_assoc();
    } else {
        echo "Fasilitas tidak ditemukan.";
        exit();
    }

    if (isset($_POST['update'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];

        if (!empty($_FILES['image']['name'])) {
            $image = $_FILES['image']['name'];
            $image_tmp = $_FILES['image']['tmp_name'];
            $image_path = 'assets/img/' . $image;

            move_uploaded_file($image_tmp, $image_path);
        } else {
            $image = $facility['image']; // Maintain the existing image if no new file is uploaded
        }

        $update_query = "UPDATE facilities SET name = ?, image = ?, description = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param('sssi', $name, $image, $description, $id);
        if ($stmt->execute()) {
            header("Location: daftar_fasilitas.php");
            exit();
        } else {
            $error = "Gagal memperbarui fasilitas.";
        }
    }
} else {
    echo "ID fasilitas tidak tersedia.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Facility</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/edit.css">
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
        <h3 class="text-center"><strong>Edit Fasilitas</strong></h3>

        <?php if (isset($error)) echo "<p class='alert alert-danger'>$error</p>"; ?>

        <form action="edit_facility.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Nama Fasilitas:</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($facility['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="image">Gambar Fasilitas:</label>
                <input type="file" id="image" name="image" class="form-control-file">
                <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
            </div>
            <div class="form-group">
                <label for="description">Deskripsi:</label>
                <textarea id="description" name="description" class="form-control" rows="4" required><?php echo htmlspecialchars($facility['description']); ?></textarea>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update</button>
            <a href="daftar_fasilitas.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    </main>
    <script>
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.classList.toggle('active');
    }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
