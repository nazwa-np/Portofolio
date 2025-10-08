<?php
include "koneksi1.php";
$id = $_GET['id'];
if(isset($_POST['update']))
	// var_dump('$_POST'); 
{	

	$nama_pembeli = $_POST['nama_pembeli'];
	$email_pembeli = $_POST['email_pembeli'];
	$phone = $_POST['phone'];
	$alamat_pembeli = $_POST['alamat_pembeli'];
	$jenis_paket = $_POST['jenis_paket'];	
	$tanggal_pemesanan = $_POST['tanggal_pemesanan'];

	// update user data
	$check = mysqli_query($conn, "UPDATE tblpembelian SET nama_pembeli='$nama_pembeli',email_pembeli='$email_pembeli',
		phone='$phone',alamat_pembeli='$alamat_pembeli', jenis_paket='$jenis_paket',
		tanggal_pemesanan='$tanggal_pemesanan' WHERE id='$id'");

	if ($check) {
   echo "<script>alert('SELAMAT DATA PEMBELIAN BERHASIL DI EDIT')</script>";
	} else {
		include 'cart1.php';
	}
}
$result = mysqli_query($conn,"SELECT * FROM tblpembelian WHERE id='". $_GET['id']."'");
$row = mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>UPDATE DATA</title>
	<link rel="stylesheet" type="text/css" href="tabel.css">
</head>
<body>

<h1>LEARN ACADEMY</h1>
<form action="" method="POST">
		<table>
				<!-- nama pembeli -->
				<div class="row mb-2">
					<label class="col-sm-2 col-form-label">Nama Lengkap</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="nama_pembeli"
							value="<?php echo $row['nama_pembeli']?>">
					</div>
				</div>

				<!-- email -->
				<div class="row mb-2">
					<label class="col-sm-2 col-form-label">Email</label>
					<div class="col-sm-10">
						<input type="email" class="form-control" name="email_pembeli"
							value="<?php echo $row['email_pembeli']?>">
					</div>
				</div>

				<!-- no hp -->
				<div class="row mb-2">
					<label class="col-sm-2 col-form-label">No Handphone</label>
					<div class="col-sm-10">
						<input type="number" class="form-control" name="phone" value="<?php echo $row['phone']?>">
					</div>
				</div>

				<!-- alamat -->
				<div class="row mb-2">
					<label class="col-sm-2 col-form-label">Alamat</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="alamat_pembeli"
							value="<?php echo $row['alamat_pembeli']?>">
					</div>
				</div>

				<!-- jenis paket -->
				<div class="row mb-2">
					<label class="col-sm-2 col-form-label">Jenis Paket</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="jenis_paket"
							value="<?php echo $row['jenis_paket']?>">
					</div>
				</div>

				<!-- tanggal pemesanan -->
				<div class="row mb-2">
					<label class="col-sm-2 col-form-label">Tanggal Pemesesanan</label>
					<div class="col-sm-10">
						<input type="date" class="form-control" name="tanggal_pemesanan"
							value="<?php echo $row['tanggal_pemesanan']?>">
					</div>
				</div>
			<tr>
				<td></td>
				<td></td>
				<td>
				<button type="submit" class="btn btn-primary" name="update">Update</button>
				<button type="reset" class="btn btn-primary" name="save">Reset</button>
				<a href="pembelian.php?id=<?php echo $row["id"]; ?>">Insert</a></td>
				</td>
			</tr>
		</table>
	</form>
</body>
</html>