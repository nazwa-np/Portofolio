<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database configuration
    require_once "../../config.php";

    // Prepare the INSERT statement template
    $insertQuery = "INSERT INTO item_aea (material_number, material_desc, unit, quota_bulan, sisa_quota, permintaan_harian) 
                    VALUES (?, ?, ?, ?, ?, ?)";
    
    // Prepare the statement
    $stmt = $koneksi->prepare($insertQuery);

    foreach ($_POST['permintaan_hari_ini'] as $material_number => $permintaan_harian) {
        // Fetch other data related to the material_number
        $query_selected = "SELECT l.material_number, l.material_desc, l.unit, l.kuota_mps, COALESCE(m.reqmnt_qty, 0) as reqmnt_qty 
                           FROM list_aea l 
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

                // Bind parameters to the statement
                $stmt->bind_param("sssiii", $part_number, $nama_barang, $satuan, $quota_bulan_ini, $sisa_quota_bulan_ini, $permintaan_harian);
                
                // Execute the statement
                $stmt->execute();

                // Optionally, you can check for errors here
                if ($stmt->errno) {
                    echo "Error: " . $stmt->error;
                }
            }
        }
    }

    // Close the statement and connection
    $stmt->close();
    $koneksi->close();

    // Redirect after successful insert
    header("Location: selected_items.php");
    exit;
}
?>
