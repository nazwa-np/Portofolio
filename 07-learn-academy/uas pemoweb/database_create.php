<?php
$servername = "localhost";
$username = "root";
$password ="";
$dbname = "tblpembelian";
$conn = new mysqli($servername, $username, $password, $dbname);
$dbname;

if(!$conn)
{
    die("koneksi gagal". mysqli_connect_error());
}
echo "Selamat Pembelian Anda Sukses!!..... Terima Kasih, Silahkan Kembali Ke <a href='pembelian.php'>PEMBELIAN</a>";
?>