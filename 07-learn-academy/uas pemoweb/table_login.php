<?php
include 'create_database.php';

if(isset($_POST['log_in'])){
	$email = $_POST['email'];
	$password = $_POST['password'];
	

	$simpan = "INSERT INTO login ( email, password )
	VALUES ('$email' ,'$password')";

	$result = mysqli_query($conn,$simpan);

	if ($result) {
		echo "<script>alert('Data Berhasil Di Tambahkan');window.location='daftar.php</script>";
	}
}
?>