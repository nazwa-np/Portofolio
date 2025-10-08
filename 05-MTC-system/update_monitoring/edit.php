
<?php
require_once "../config.php";
require_once "fungsi_update.php";

// Fungsi untuk mengupdate data material
if (isset($_POST["edit"])) {
    if (editMaterial($_POST) > 0) {
        echo "
            <script>
                alert('Data Berhasil Diubah');
                document.location.href = 'data.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data Gagal Diubah');
                document.location.href = 'data.php';
            </script>
        ";
    }
}

// Ambil data material berdasarkan Reserv_no dari URL
$Reserv_no = $_GET["Reserv_no"];
$material = getMaterialByReservNo($Reserv_no);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../asset/sb-admin/css/styles.css" rel="stylesheet" />
    <title>Edit Material</title>
    <style>
        .container {
            justify-content: center;
        }
        .table {
            margin: auto;
            border-collapse: collapse;
        }
        .table td, .table th {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .table th {
            padding-top: 12px;
            padding-bottom: 12px;
            background-color: #4CAF50;
            color: white;
        }
        .save-button {
            background-color: #000;
            color: white;
            padding: 10px 25px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin: auto;
        }
        .cancel-button {
            background-color: #f2f2f2;
            color: black;
            padding: 10px 25px;
            border: #000;
            cursor: pointer;
            border-radius: 5px;
            margin: auto;
        }
    </style>
</head>
<body>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 justify-content-center">
                <h1 class="mt-4 mb-5">Edit Material</h1>
                <div class="container justify-content-center">
                    <form method="POST" action="">
                        <table class="table">
                            <tr>
                                <td><strong>Reserv.no.</strong></td>
                                <td><input type="text" placeholder="Masukkan Reserv.no." name="Reserv_no" value="<?= $material['Reserv_no'] ?>" readonly></td>
                            </tr>
                            <tr>
                                <td><strong>Material</strong></td>
                                <td><input type="text" placeholder="Masukkan Material" name="Material" value="<?= $material['material_number'] ?>"></td>
                            </tr>
                            <tr>
                                <td><strong>Material Description</strong></td>
                                <td><input type="text" placeholder="Masukkan Material Description" name="Material_description" value="<?= $material['Material_description'] ?>"></td>
                            </tr>
                            <tr>
                                <td><strong>Cost Ctr</strong></td>
                                <td><input type="text" placeholder="Masukkan Cost Ctr" name="Cost_Ctr" value="<?= $material['Cost_Ctr'] ?>"></td>
                            </tr>
                            <tr>
                                <td><strong>Reqmts Date</strong></td>
                                <td><input type="text" placeholder="Masukkan Reqmts Date" name="Reqmts_date" value="<?= $material['Reqmts_date'] ?>"></td>
                            </tr>
                            <tr>
                                <td><strong>Reqmnt Qty</strong></td>
                                <td><input type="text" placeholder="Masukkan Reqmnt Qty" name="Reqmnt_qty" value="<?= $material['Reqmnt_qty'] ?>"></td>
                            </tr>
                            <tr>
                                <td><strong>Diff. Qty</strong></td>
                                <td><input type="text" placeholder="Masukkan Diff. Qty" name="Diff_qty" value="<?= $material['Diff_qty'] ?>"></td>
                            </tr>
                            <tr>
                                <td><strong>BUn</strong></td>
                                <td><input type="text" placeholder="Masukkan BUn" name="BUn" value="<?= $material['BUn'] ?>"></td>
                            </tr>
                            <tr>
                                <td><strong>Kode</strong></td>
                                <td><input type="text" placeholder="Masukkan Kode" name="Kode" value="<?= $material['Kode'] ?>"></td>
                            </tr>
                            <tr>
                                <td><strong>Deskripsi</strong></td>
                                <td><input type="text" placeholder="Masukkan Deskripsi" name="Deskripsi" value="<?= $material['Deskripsi'] ?>"></td>
                            </tr>
                            <tr>
                                <td><strong>Minggu ke</strong></td>
                                <td><input type="text" placeholder="Masukkan Minggu ke" name="Minggu_ke" value="<?= $material['Minggu_ke'] ?>"></td>
                            </tr>
                            <tr>
                                <td><strong>Qty/Unit</strong></td>
                                <td><input type="text" placeholder="Masukkan Qty/Unit" name="Qty_Unit" value="<?= $material['Qty_Unit'] ?>"></td>
                            </tr>
                            <tr>
                                <td><strong>Kode Part</strong></td>
                                <td><input type="text" placeholder="Masukkan Kode Part" name="Kode_Part" value="<?= $material['Kode_Part'] ?>"></td>
                            </tr>
                            <tr>
                                <td><strong>Qty</strong></td>
                                <td><input type="text" placeholder="Masukkan Qty" name="Qty" value="<?= $material['Qty'] ?>"></td>
                            </tr>
                            <tr>
                                <td><strong>Price</strong></td>
                                <td><input type="text" placeholder="Masukkan Price" name="Price" value="<?= $material['Price'] ?>"></td>
                            </tr>
                            <tr>
                                <td><strong>Amount</strong></td>
                                <td><input type="text" placeholder="Masukkan Amount" name="Amount" value="<?= $material['Amount'] ?>"></td>
                            </tr>
                            <tr>
                                <td><strong>Material Seksi</strong></td>
                                <td><input type="text" placeholder="Masukkan Material Seksi" name="Material_Seksi" value="<?= $material['Material_Seksi'] ?>"></td>
                            </tr>
                            <tr>
                                <td><strong>Kategori</strong></td>
                                <td><input type="text" placeholder="Masukkan Kategori" name="Kategori" value="<?= $material['Kategori'] ?>"></td>
                            </tr>
                            <tr>
                                <td><strong>Rp/Unit</strong></td>
                                <td><input type="text" placeholder="Masukkan Rp/Unit" name="Rp_Unit" value="<?= $material['Rp_Unit'] ?>"></td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center" style="padding-top: 20px;">
                                    <button type="submit" name="edit" class="save-button">Save</button>
                                    <a href="<?= $main_url ?>update_monitoring/data.php">
                                        <button type="button" class="cancel-button">Cancel</button>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
