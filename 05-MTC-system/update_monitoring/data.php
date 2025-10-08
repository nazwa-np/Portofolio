<?php
require_once "../config.php";

$title = "Dashboard";
require_once "../template_admin/header.php";
require_once "../template_admin/navbar.php";
require_once "../template_admin/sidebar.php";
?>

<head>
        <link href="../asset/sb-admin/css/styles.css" rel="stylesheet" />
        
</head>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-5">Update Monitoring</h1>
            
            <div class="text-right">
                <a href="import.php" class="btn btn-success">Import Data</a>
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
                            <th>Reserv.no.</th>
                            <th>Material</th>
                            <th>Material Description</th>
                            <th>Cost Ctr</th>
                            <th>Reqmts Date</th>
                            <th>Reqmnt Qty</th>
                            <th>Diff. Qty</th>
                            <th>BUn</th>
                            <th>Kode</th>
                            <th>Deskripsi</th>
                            <th>Minggu ke</th>
                            <th>Qty/Unit</th>
                            <th>Kode Part</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Amount</th>
                            <th>Material Seksi</th>
                            <th>Kategori</th>
                            <th>Rp/Unit</th>
                            <th>Update Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $batas = 5000;
                        $hal = isset($_GET['hal']) ? $_GET['hal'] : 1;
                        $posisi = ($hal - 1) * $batas;

                        $query = "SELECT * FROM material";
                        if (isset($_GET['pencarian'])) {
                            $pencarian = trim(mysqli_real_escape_string($koneksi, $_GET['pencarian']));
                            $query .= " WHERE material_number LIKE '%$pencarian%'";
                        }
                        $query .= " LIMIT $posisi, $batas";

                        $result = mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));
                        if (mysqli_num_rows($result) > 0) {
                            $no = $posisi + 1;
                            while ($data = mysqli_fetch_array($result)) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $data['Reserv_no'] ?></td>
                                    <td><?= $data['material_number'] ?></td>
                                    <td><?= $data['Material_description'] ?></td>
                                    <td><?= $data['Cost_Ctr'] ?></td>
                                    <td><?= $data['Reqmts_date'] ?></td>
                                    <td><?= $data['Reqmnt_qty'] ?></td>
                                    <td><?= $data['Diff_qty'] ?></td>
                                    <td><?= $data['BUn'] ?></td>
                                    <td><?= $data['Kode'] ?></td>   
                                    <td><?= $data['Deskripsi'] ?></td>
                                    <td><?= $data['Minggu_ke'] ?></td>
                                    <td><?= $data['Qty_Unit'] ?></td>
                                    <td><?= $data['Kode_Part'] ?></td>
                                    <td><?= $data['Qty'] ?></td>
                                    <td><?= $data['Price'] ?></td>
                                    <td><?= $data['Amount'] ?></td>
                                    <td><?= $data['Material_Seksi'] ?></td>
                                    <td><?= $data['Kategori'] ?></td>
                                    <td><?= $data['Rp_Unit'] ?></td>
                                    <td>
                                        <button type="submit" name="submit" class="edit-button" onclick="window.location.href='edit.php?Reserv_no=<?= $data["Reserv_no"]; ?>'">Edit</button>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan=\"20\" align=\"center\">Data Tidak Ditemukan</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

<?php require_once "../template_admin/footer.php";?>
