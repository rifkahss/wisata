<?php
require 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

include '../db/db_connection.php';

// Ambil ID dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Query untuk mendapatkan data pemesanan berdasarkan ID
$sql = "SELECT * FROM orders WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // HTML untuk PDF
    $html = "
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
        }

        h1 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 100px;
            margin-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
        }

        .details {
            margin-bottom: 20px;
        }

        .details table {
            width: 100%;
        }

        .details td {
            padding: 5px 0;
            vertical-align: top;
        }

        .details .label {
            width: 150px;
            font-weight: bold;
        }

        .total {
            font-size: 16px;
            font-weight: bold;
            text-align: right;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }
    </style>

    <div class='container'>
        <div class='header'>
            <h1>Bukti Pemesanan</h1>
        </div>

        <div class='details'>
            <table>
                <tr>
                    <td class='label'>ID Pemesanan:</td>
                    <td>{$row['id']}</td>
                </tr>
                <tr>
                    <td class='label'>Nama Pemesan:</td>
                    <td>{$row['name']}</td>
                </tr>
                <tr>
                    <td class='label'>Nomor HP/Telp:</td>
                    <td>{$row['phone']}</td>
                </tr>
                <tr>
                    <td class='label'>Tanggal Pemesanan:</td>
                    <td>{$row['date']}</td>
                </tr>
                <tr>
                    <td class='label'>Tanggal Pelaksanaan:</td>
                    <td>{$row['time']}</td>
                </tr>
                <tr>
                    <td class='label'>Biaya Penginapan:</td>
                    <td>Rp. {$row['accommodations']} /orang</td>
                </tr>
                <tr>
                    <td class='label'>Biaya Transportasi:</td>
                    <td>Rp. {$row['transportation']} /orang</td>
                </tr>
                <tr>
                    <td class='label'>Biaya Makan:</td>
                    <td>Rp. {$row['food']} /orang</td>
                </tr>
                <tr>
                    <td class='label'>Jumlah Peserta:</td>
                    <td>{$row['participants']}</td>
                </tr>
                <tr>
                    <td class='label'>Durasi:</td>
                    <td>{$row['duration_days']} hari</td>
                </tr>
                <tr>
                    <td class='label total'>Total Biaya:</td>
                    <td class='total'>Rp. " . number_format($row['total_cost'], 0, ',', '.') . "</td>
                </tr>
            </table>
        </div>

        <div class='footer'>
            <p>Terima kasih telah melakukan pemesanan.</p>
        </div>
    </div>
    ";

    // Inisialisasi Dompdf
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);

    // Set kertas dan orientasi
    $dompdf->setPaper('A4', 'portrait');

    // Render HTML menjadi PDF
    $dompdf->render();

    // Output file PDF ke browser
    $dompdf->stream("bukti_pemesanan_{$row['id']}.pdf", array("Attachment" => false));
} else {
    echo "Data pemesanan tidak ditemukan.";
}
?>
