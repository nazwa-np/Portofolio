<?php
// Handle the selected data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selected'])) {
    // Include your database configuration
    require_once "../../config.php";

    // Assuming 'selected' contains array of selected material numbers
    $selectedItems = $_POST['selected'];

    // Variable to store selected items HTML
    $selectedItemsHTML = '';

    foreach ($selectedItems as $material_number) {
        // Sanitize and validate $material_number if necessary
        $material_number = mysqli_real_escape_string($koneksi, $material_number);

        // Query to fetch selected items data
        $query_selected = "SELECT l.material_number, l.material_desc, l.unit, l.kuota_mps, COALESCE(m.reqmnt_qty, 0) as reqmnt_qty 
                           FROM list_lpdc l 
                           LEFT JOIN material m ON l.material_number = m.material_number AND m.cost_ctr = 'P1LP10'
                           WHERE l.material_number = ?";
        
        // Prepare and execute the SELECT statement
        $stmt_select = $koneksi->prepare($query_selected);
        $stmt_select->bind_param("s", $material_number);
        $stmt_select->execute();
        $result_selected = $stmt_select->get_result();

        if ($result_selected->num_rows > 0) {
            while ($row = $result_selected->fetch_assoc()) {
                // Extract data from the selected row
                $part_number = $row['material_number'];
                $nama_barang = $row['material_desc'];
                $satuan = $row['unit'];
                $quota_bulan_ini = is_numeric($row['kuota_mps']) ? $row['kuota_mps'] : 0;
                $sisa_quota_bulan_ini = $quota_bulan_ini - (is_numeric($row['reqmnt_qty']) ? $row['reqmnt_qty'] : 0);
                $permintaan_harian = isset($_POST['permintaan_hari_ini'][$part_number]) ? $_POST['permintaan_hari_ini'][$part_number] : 0;

                // Append selected item data to HTML
                $selectedItemsHTML .= '<tr>';
                $selectedItemsHTML .= '<td>' . $part_number . '</td>';
                $selectedItemsHTML .= '<td>' . $nama_barang . '</td>';
                $selectedItemsHTML .= '<td>' . $satuan . '</td>';
                $selectedItemsHTML .= '<td>' . $quota_bulan_ini . '</td>';
                $selectedItemsHTML .= '<td>' . $sisa_quota_bulan_ini . '</td>';
                // Input field for permintaan harian
                $selectedItemsHTML .= '<td><input type="number" name="permintaan_hari_ini[' . $part_number . ']" value="' . htmlspecialchars($permintaan_harian) . '"></td>';
                $selectedItemsHTML .= '</tr>';
            }
        }
    }

    // Close the connection
    $koneksi->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<body>
    <div class="container">
        <div id="selected-data">
            <form id="submit-form" action="insert_to_database.php" method="POST">
                <table>
                    <thead>
                        <tr>
                            <th>Part Number</th>
                            <th>Nama Barang</th>
                            <th>Satuan</th>
                            <th>Quota Bulan Ini</th>
                            <th>Sisa Quota Bulan Ini</th>
                            <th>Permintaan Hari Ini</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $selectedItemsHTML; ?>
                    </tbody>
                </table>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>
