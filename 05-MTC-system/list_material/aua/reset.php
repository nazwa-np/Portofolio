<?php
require_once "../../config.php";

// Hapus semua data dalam tabel tbl_sap
$query = "TRUNCATE TABLE list_aua";
$result = mysqli_query($koneksi, $query);

if ($result) {
    // Redirect ke halaman sebelumnya dengan pesan sukses
    header("Location: {$_SERVER['HTTP_REFERER']}?success=reset");
    exit;
} else {
    // Jika terjadi kesalahan, redirect ke halaman sebelumnya dengan pesan error
    header("Location: {$_SERVER['HTTP_REFERER']}?error=reset");
    exit;
}
?>
