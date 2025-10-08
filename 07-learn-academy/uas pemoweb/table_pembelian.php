<?php
include 'database_create.php';

if(isset($_POST['kirim'])){
	$nama_pembeli = $_POST['nama_pembeli'];
	$email_pembeli = $_POST['email_pembeli'];
	$phone = $_POST['phone'];
	$alamat_pembeli = $_POST['alamat_pembeli'];
	$jenis_paket = $_POST['jenis_paket'];	
	$tanggal_pemesanan = $_POST['tanggal_pemesanan'];

	$simpan = "INSERT INTO tblpembelian (nama_pembeli, email_pembeli, phone, alamat_pembeli, 
	jenis_paket, tanggal_pemesanan)
	VALUES ('$nama_pembeli', '$email_pembeli' ,'$phone','$alamat_pembeli',
	'$jenis_paket', '$tanggal_pemesanan')";

	$result = mysqli_query($conn,$simpan);

	if ($result) {
		echo "<script>alert('Data Berhasil Di Tambahkan');window.location='pembelian.php</script>";
	}
}
?>
