<?php
require_once "../../config.php";

$title = "Dashboard";
require_once "../../template_admin/header.php";
require_once "../../template_admin/navbar.php";
require_once "../../template_admin/sidebar.php";
?>

<head>
    <link href="../../asset/sb-admin/css/styles.css" rel="stylesheet" />
</head>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-5">List Material Assy Unit A</h1>
            
            <div class="text-right">
                <a href="import_aua.php" class="btn btn-success">Import Data</a>
                <a href="reset.php" class="btn btn-danger">Reset</a>
            </div>
            <br>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Data 
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Tipe Material</th>
                                <th>Material Number</th>
                                <th>Material Description</th>
                                <th>Unit</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Std Using</th>
                                <th>Kuota Mps</th>
                                <th>Actual Prod</th>
                                <th>Volume Produksi</th>
                                <th>Plan</th>
                                <th>Update Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM list_aua";
                            if (isset($_GET['pencarian'])) {
                                $pencarian = trim(mysqli_real_escape_string($koneksi, $_GET['pencarian']));
                                $query .= " WHERE material_number LIKE '%$pencarian%'";
                            }

                            $result = mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));
                            if (mysqli_num_rows($result) > 0) {
                                $no = 1; // Start the numbering from 1
                                while ($data = mysqli_fetch_array($result)) { ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $data['tipe_material'] ?></td>
                                        <td><?= $data['material_number'] ?></td>
                                        <td><?= $data['material_desc'] ?></td>
                                        <td><?= $data['unit'] ?></td>
                                        <td><?= $data['qty'] ?></td>
                                        <td><?= $data['price'] ?></td>
                                        <td><?= $data['std_using'] ?></td>
                                        <td><?= $data['kuota_mps'] ?></td>
                                        <td><?= $data['actual_prod'] ?></td>
                                        <td><?= $data['vol_prod'] ?></td>
                                        <td><?= $data['plan'] ?></td>
                                        <td>
                                            <button type="submit" name="submit" class="edit-button" onclick="window.location.href='edit.php?material_number=<?= $data['material_number']; ?>'">Edit</button>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='13' align='center'>Data Tidak Ditemukan</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

<?php require_once "../../template_admin/footer.php"; ?>
