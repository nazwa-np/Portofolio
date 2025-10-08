<?php
require_once "../../config.php";
require_once "fungsi_update.php";

// Fungsi untuk mengupdate data material
if (isset($_POST["edit"])) {
    if (editList($_POST) > 0) {
        echo "
            <script>
                alert('Data Berhasil Diubah');
                document.location.href = 'list_aeb.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Data Gagal Diubah');
                document.location.href = 'list_aeb.php';
            </script>
        ";
    }
}

// Ambil data material berdasarkan Reserv_no dari URL
$tipe_material = $_GET["tipe_material"];
$material_number = getMaterialNumByTipeMaterial($tipe_material);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../asset/sb-admin/css/styles.css" rel="stylesheet" />
    <title>Edit Material LPDC</title>
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
                <h1 class="mt-4 mb-5">Edit Material LPDC</h1>
                <div class="container justify-content-center">
                    <form method="POST" action="">
                        <table class="table">
                        <tr>
                                <td><strong>Tipe Material</strong></td>
                                <td><input type="text" name="tipe_material" value="<?= htmlspecialchars($material_number['tipe_material']); ?>"></td>
                            </tr>
                            <tr>
                                <td><strong>Material Number</strong></td>
                                <td><input type="text" name="material_number" value="<?= htmlspecialchars($material_number['material_number']); ?>"></td>
                            </tr>
                            <tr>
                                <td><strong>Material Description</strong></td>
                                <td><input type="text"  name="material_desc" value="<?= htmlspecialchars($material_number['material_desc']); ?>"></td>
                            </tr>
                            <tr>
                                <td><strong>Unit</strong></td>
                                <td><input type="text" name="unit" value="<?= htmlspecialchars($material_number['unit']); ?>"></td>
                            </tr>
                            <tr>
                                <td><strong>Quantity</strong></td>
                                <td><input type="text" name="qty" value="<?= htmlspecialchars($material_number['qty']); ?>"></td>
                            </tr>
                            <tr>
                                <td><strong>Price</strong></td>
                                <td><input type="text"  name="price" value="<?= htmlspecialchars($material_number['price']); ?>"></td>
                            </tr>
                            <tr>
                                <td><strong>Standard Using</strong></td>
                                <td><input type="text"  name="std_using" value="<?= htmlspecialchars($material_number['std_using']); ?>"></td>
                            </tr>
                            <tr>
                                <td><strong>Kuota MPS</strong></td>
                                <td><input type="text"  name="kuota_mps" value="<?= htmlspecialchars($material_number['kuota_mps']); ?>"></td>
                            </tr>
                            <tr>
                                <td><strong>Actual Production</strong></td>
                                <td><input type="text"  name="actual_prod" value="<?= htmlspecialchars($material_number['actual_prod']); ?>"></td>
                            </tr>
                            <tr>
                                <td><strong>Volume Production</strong></td>
                                <td><input type="text" name="vol_prod" value="<?= htmlspecialchars($material_number['vol_prod']); ?>"></td>
                            </tr>
                            <tr>
                                <td><strong>Plan</strong></td>
                                <td><input type="text"  name="plan" value="<?= htmlspecialchars($material_number['plan']); ?>"></td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center" style="padding-top: 20px;">
                                    <button type="submit" name="edit" class="save-button">Save</button>
                                    <a href="list_aeb.php">
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
