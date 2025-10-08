<?php
include 'koneksi1.php';
$id = $_GET['id'];
$result = mysqli_query($conn, "DELETE FROM tblpembelian WHERE id='$id'") or die(mysql_error());

if ($result) {
    print"Berhasil Hapus";
    header("location: cart1.php");
} else {
    print"Gagal Hapus";
}
?>
