<!DOCTYPE html>
<html>

<head>
    <title>LEARN ACADEMY</title>
    <link rel="stylesheet" type="text/css" href="tabel.css">

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

</head>

<?php
include_once 'koneksi1.php';
$result = mysqli_query($conn, "SELECT * FROM tblpembelian");
?>

<body>
    <!-- header -->
    <?php include('header.php') ?>

    
    <!-- about -->
    <section class="about">
        <div class="container2">

        <!-- riwayat pembelian -->
            <center>
            <h3><b>|&nbsp;&nbsp;YOUR PURCHASE HISTORY&nbsp;&nbsp;|</b></h3>
            <br>
                <p>Riwayat Pembelian :</p>
            <br><br>
            
            <?php
                if (mysqli_num_rows($result) > 0) {
            ?>

            <div class="carttable">
                <table>
                    <tr class="fw-bolder">
                        <td>No</td>
                        <td>Nama Lengkap</td>
                        <td>E-mail</td>
                        <td>No Handphone</td>
                        <td>Alamat</td>
                        <td>Jenis Paket</td>
                        <td>Tanggal Pemesanan</td>
                        <td>Keterangan</td>
                        </tr>
                
                <?php
                    $i=1;
                    while ($row = mysqli_fetch_array($result)) {
                ?>
                
                <!-- <table> -->
                    <tr>
                        <td><?php echo $i; ?></td>
                        
                        <td><?php echo $row["nama_pembeli"]; ?></td>
                        <td><?php echo $row["email_pembeli"]; ?></td>
                        <td><?php echo $row["phone"]; ?></td>
                        <td><?php echo $row["alamat_pembeli"]; ?></td>
                        <td><?php echo $row["jenis_paket"]; ?></td>
                        <td><?php echo $row["tanggal_pemesanan"]; ?></td>
					    <td><a href="delete-process.php?id= <?php echo $row["id"]; ?>">Delete</a> &nbsp;|&nbsp; 
                            <a href="update-process.php?id=<?php echo $row["id"]; ?>">Update</a> &nbsp;|&nbsp; 
                            <a href="pembelian.php?id=<?php echo $row["id"]; ?>">Insert</a></td>
                    </tr>
                <?php
                    $i++;
                        }
                ?>
                </table>
            </div>
                
                <?php
                    }
                else{
                    echo "Data tidak ditemukan";
                }
                ?>
            </center>
            
            <br><br>
            <br><br>
            
        </div>
        
    </section>

    <!-- footer -->
    <?php include('footer.php') ?>

</body>

</html>