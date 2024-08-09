<?php
session_start();
include('../db/db_connection.php');

if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $query = "DELETE FROM facilities WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        header("Location: daftar_fasilitas.php?message=Fasilitas berhasil dihapus");
        exit();
    } else {
        echo "Terjadi kesalahan saat menghapus fasilitas: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "ID fasilitas tidak ditentukan.";
}

$conn->close();
?>
