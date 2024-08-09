<?php
include '../db/db_connection.php';

// Cek apakah ID pemesanan ada di POST request
if (isset($_POST['id'])) {
    $orderId = intval($_POST['id']);

    // Query untuk menghapus pemesanan
    $sql = "DELETE FROM orders WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('i', $orderId);

        if ($stmt->execute()) {
            // Jika penghapusan berhasil, arahkan kembali ke halaman daftar pemesanan
            header("Location: reservations.php?status=success");
        } else {
            // Jika terjadi kesalahan saat eksekusi query
            echo "Terjadi kesalahan saat menghapus pesanan: " . $stmt->error;
        }

        $stmt->close();
    } else {
        // Jika query gagal dipersiapkan
        echo "Terjadi kesalahan saat mempersiapkan query: " . $conn->error;
    }

    $conn->close();
} else {
    // Jika ID pemesanan tidak diberikan
    echo "ID pemesanan tidak diberikan.";
}
?>
