<?php
// Pastikan ada akses yang sesuai atau validasi, jika diperlukan

// Ambil data dari form sebelumnya, jika perlu
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['permintaan_hari_ini'])) {
    $permintaan_hari_ini = $_POST['permintaan_hari_ini'];
    // Lakukan sesuatu dengan data ini, seperti menyimpan ke database atau proses cetak
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Page</title>
    <!-- Tambahkan CSS atau style yang diperlukan -->
</head>
<body>
    <!-- Tambahkan konten halaman cetak sesuai kebutuhan -->
    <h1>Halaman Cetak atau Tampilan Berikutnya</h1>
    <!-- Misalnya, tampilkan data yang sudah diproses atau form untuk mencetak -->
</body>
</html>
