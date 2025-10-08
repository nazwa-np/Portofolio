<?php include("koneksi1.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Last Project</title>
    <link rel="stylesheet" type="text/css" href="stylepemoweb.css">
</head>

<body>

    <!-- header -->
    <?php include('header.php') ?>
    
    <!-- menu -->
    <?php include('menu.php') ?>
   
    <!-- about --> 
    <section class="about">
        <div class="container2">
        <center>
            <h3><b>=&nbsp;&nbsp;PEMBELIAN PAKET BELAJAR&nbsp;&nbsp;=</b></h3>
                <p> Silahkan lengkapi data berikut untuk melakukan proses berlangganan di Learn Academy :</p>

                <form action="table_pembelian.php" method="POST">
                <table>
                    <tr>
                        <td>Nama Lengkap</td>
                        <!-- <td>:</td> -->
                        <td><input type="text" name="nama_pembeli"></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <!-- <td>:</td> -->
                        <td><input type="email" name="email_pembeli"></td>
                    </tr>
                    <tr>
                        <td>No Handphone</td>
                        <!-- <td>:</td> -->
                        <td><input type="tel" name="phone"></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <!-- <td>:</td> -->
                        <td><input type="text" name="alamat_pembeli"></td>
                    </tr>
                    <tr>
                        <td>Jenis Paket</td>
                        <!-- <td>:</td> -->
                        <td><select type="text" name="jenis_paket">
                        <option value="select_paket">-------- Select Paket --------</option>
                        <option value="paket_a">Paket A</option>
                        <option value="paket_b">Paket B</option>
                        <option value="paket_c">Paket C</option>
                        </select></td>             
                    </tr>
                    <tr>
                        <td>Tanggal Pemesanan</td>
                        <!-- <td>:</td> -->
                        <td><input type="datetime-local" name="tanggal_pemesanan"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <button type="submit" name="kirim">Kirim</button>
                            <button type="reset" name="reset">Batal</button>
                        </td>
                    </tr>
                </table>

            </form></center>

        </div>
    </section>
    <br><br><br>

    <!-- footer -->
    <?php include('footer.php') ?>

</body>

</html> 