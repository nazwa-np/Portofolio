<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "log-in";
$conn = new mysqli($servername, $username, $password, $dbname);
$dbname;

if(!$conn)
{
	die("koneksi gagal". mysqli_connect_error());
}
echo "Log In Berhasil-! Silahkan Kembali Ke <a href='login.php'>AKUN</a>";
?>