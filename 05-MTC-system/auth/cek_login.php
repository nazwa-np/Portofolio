<?php 
// mengaktifkan session pada php
session_start();
 
// menghubungkan php dengan koneksi database
require_once "../config.php";
 
// menangkap data yang dikirim dari form login
$username = $_POST['username'];
$password = $_POST['password'];
 
 
// menyeleksi data user dengan username dan password yang sesuai
$login = mysqli_query($koneksi,"select * from tbl_user where username='$username' and password='$password'");
// menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($login);
 
// cek apakah username dan password di temukan pada database
if ($cek > 0) {

    $data = mysqli_fetch_assoc($login);

    // Debugging: Cek apakah query mengembalikan data yang benar
    echo "Username: " . $data['username'] . "<br>";
    echo "Password: " . $data['password'] . "<br>";
    echo "Level: " . $data['level'] . "<br>";
    //exit; // Hentikan script untuk melihat hasil debugging

    // cek jika user login sebagai admin
    if ($data['level'] == "admin") {
        $_SESSION['username'] = $username;
        $_SESSION['level'] = "admin";
        header("location:../halaman_admin.php");
    } 
    // cek jika user login sebagai lpdc
    else if ($data['level'] == "lpdc") {
        $_SESSION['username'] = $username;
        $_SESSION['level'] = "lpdc";
        header("location:../lpdc/halaman_lpdc.php");
    } 
    // cek jika user login sebagai diecasting
    else if ($data['level'] == "diecasting") {
        $_SESSION['username'] = $username;
        $_SESSION['level'] = "diecasting";
        header("location:../diecasting/halaman_diecasting.php");
    } 
	else if ($data['level'] == "crankcase") {
        $_SESSION['username'] = $username;
        $_SESSION['level'] = "crankcase";
        header("location:../crankcase/halaman_crankcase.php");
    } 
    // cek jika user login sebagai diecasting
    else if ($data['level'] == "crankshaft") {
        $_SESSION['username'] = $username;
        $_SESSION['level'] = "crankshaft";
        header("location:../crankshaft/halaman_crankshaft.php");
    } 
	else if ($data['level'] == "cylhead") {
        $_SESSION['username'] = $username;
        $_SESSION['level'] = "cylhead";
        header("location:../cylhead/halaman_cylhead.php");
    } 
    // cek jika user login sebagai diecasting
    else if ($data['level'] == "cylcomp") {
        $_SESSION['username'] = $username;
        $_SESSION['level'] = "cylcomp";
        header("location:../cylcomp/halaman_cylcomp.php");
    } 
	else if ($data['level'] == "aea") {
        $_SESSION['username'] = $username;
        $_SESSION['level'] = "aea";
        header("location:../aea/halaman_aea.php");
    } 
    // cek jika user login sebagai diecasting
    else if ($data['level'] == "aeb") {
        $_SESSION['username'] = $username;
        $_SESSION['level'] = "aeb";
        header("location:../aeb/halaman_aeb.php");
    } 
	else if ($data['level'] == "weldinga") {
        $_SESSION['username'] = $username;
        $_SESSION['level'] = "weldinga";
        header("location:../weldinga/halaman_weldinga.php");
    } 
    // cek jika user login sebagai diecasting
    else if ($data['level'] == "weldingb") {
        $_SESSION['username'] = $username;
        $_SESSION['level'] = "weldingb";
        header("location:../weldingb/halaman_weldingb.php");
    } 
	else if ($data['level'] == "ps") {
        $_SESSION['username'] = $username;
        $_SESSION['level'] = "ps";
        header("location:../ps/halaman_ps.php");
    } 
    // cek jika user login sebagai diecasting
    else if ($data['level'] == "gensub") {
        $_SESSION['username'] = $username;
        $_SESSION['level'] = "gensub";
        header("location:../gensub/halaman_gensub.php");
    } 
	else if ($data['level'] == "aua") {
        $_SESSION['username'] = $username;
        $_SESSION['level'] = "aua";
        header("location:../aua/halaman_aua.php");
    } 
    // cek jika user login sebagai diecasting
    else if ($data['level'] == "aub") {
        $_SESSION['username'] = $username;
        $_SESSION['level'] = "aub";
        header("location:../aub/halaman_aub.php");
    
	}else{
 
		// alihkan ke halaman login kembali
		header("location:login.php?pesan=gagal");
	}	
}else{
	header("location:login.php?pesan=gagal");
}
 
?>