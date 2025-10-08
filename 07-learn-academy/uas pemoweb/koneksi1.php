<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tblpembelian";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if(!$conn){
	die('Tidak bisa terhubung ke MySQL:'. mysqli_error());
}
?>