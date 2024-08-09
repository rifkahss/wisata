<?php
// Koneksi ke database
include('../db/db_connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fasilitas - Scientia Square Park</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/fasilitas.css">
</head>
<body>
    <?php include('includes/header.php'); ?>
    
    <h3 class="text-center"><strong>Fasilitas Scientia Square Park</strong></h3><br>

    <div class="container mt-4">
        <div class="row">
            <?php
            // Ambil data fasilitas dari database
            $query = "SELECT * FROM facilities";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <img src="../admin/assets/img/'.$row['image'].'" class="card-img-top" alt="'.$row['name'].'">
                            <div class="card-body">
                                <h5 class="card-title"><strong>'.$row['name'].'</strong></h5>
                                <p class="card-text">'.$row['description'].'</p>
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

    <?php include('includes/footer.php'); ?>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>