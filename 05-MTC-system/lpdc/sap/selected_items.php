<?php
// Include your database configuration
require_once "../../config.php";

// Define the section name
$sectionName = "LPDC"; // Replace with actual section name

// Get the current date
$currentDate = date('Y-m-d');

// Function to sanitize input data (to prevent SQL injection)
function sanitize($koneksi, $data) {
    return mysqli_real_escape_string($koneksi, $data);
}

// Handle form submission for updating all rows
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_items'])) {
    // Check if the necessary POST variables are set and not empty
    if (isset($_POST['material_number']) && isset($_POST['permintaan_harian'])) {
        // Loop through all posted data to update each row
        foreach ($_POST['material_number'] as $key => $material_number) {
            // Check if permintaan_harian is set for this key
            if (isset($_POST['permintaan_harian'][$key])) {
                $permintaan_harian = sanitize($koneksi, $_POST['permintaan_harian'][$key]);

                // Update query for each row
                $query_update_item = "UPDATE item_lpdc SET permintaan_harian = '$permintaan_harian' WHERE material_number = '$material_number'";
                $koneksi->query($query_update_item); // Execute query (you may want to add error handling here)
            } else {
                // Handle case where permintaan_harian[$key] is not set
                // This could be a validation or error handling step
            }
        }

        // Handle saving signatures
        $dibuat_mtc = sanitize($koneksi, $_POST['dibuat_mtc']);
        $disetujui_section_head = sanitize($koneksi, $_POST['disetujui_section_head']);
        $mengetahui_dept_head = sanitize($koneksi, $_POST['mengetahui_dept_head']);
        $diterima_epp_controller = sanitize($koneksi, $_POST['diterima_epp_controller']);

        // Query to save signatures into the database
        $query_update_signatures = "UPDATE item_lpdc SET dibuat_mtc = '$dibuat_mtc', disetujui_section_head = '$disetujui_section_head', mengetahui_dept_head = '$mengetahui_dept_head', diterima_epp_controller = '$diterima_epp_controller' WHERE 1";
        $koneksi->query($query_update_signatures); // Execute query (add error handling here if needed)

        // Redirect back to selected_items.php after update
        header("Location: selected_items.php");
        exit();
    } else {
        // Handle case where $_POST['material_number'] or $_POST['permintaan_harian'] is not set
        // This could be a validation or error handling step
        echo "Error: Material number or permintaan harian data is missing.";
    }
}

// Query to fetch data from item_lpdc
$query_select_items = "SELECT * FROM item_lpdc";
$result_select_items = $koneksi->query($query_select_items);

// Fetch signature data
$query_select_signatures = "SELECT dibuat_mtc, disetujui_section_head, mengetahui_dept_head, diterima_epp_controller FROM item_lpdc LIMIT 1";
$result_signatures = $koneksi->query($query_select_signatures);

// Initialize variables for signature fields
$dibuat_mtc = $disetujui_section_head = $mengetahui_dept_head = $diterima_epp_controller = '';

// Check if signature data exists
if ($result_signatures->num_rows > 0) {
    $signature_row = $result_signatures->fetch_assoc();
    $dibuat_mtc = $signature_row['dibuat_mtc'];
    $disetujui_section_head = $signature_row['disetujui_section_head'];
    $mengetahui_dept_head = $signature_row['mengetahui_dept_head'];
    $diterima_epp_controller = $signature_row['diterima_epp_controller'];
}

// Check if there are rows returned
if ($result_select_items->num_rows > 0) {
    // Start HTML output
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Surat Permintaan Barang</title>
        <link rel="stylesheet" href="../../asset/sb-admin/css/sap.css">
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f9f9f9;
                margin: 0;
                padding: 20px;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }
            .container {
                max-width: 1200px;
                width: 100%;
                padding: 20px
            }
            h1 {
                text-align: center;
                font-size: 24px;
                margin-bottom: 20px;
            }
            p {
                font-size: 14px;
                margin-bottom: 10px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            th, td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }
            th {
                background-color: black;
            }
            input[type="text"] {
                width: 100%;
                padding: 8px;
                box-sizing: border-box;
                border: 1px solid #ccc;
            }
            .signature-table {
                width: 50%;
                margin: 20px 0 20px auto;
                border-collapse: collapse;
            }
            .signature-input {
                width: 100%;
                height: 18px; /* Adjust height to make it more square */
                padding: 0; /* Remove padding to keep the input square */
                text-align: center;
                border: 1px solid #ccc;
                box-sizing: border-box;
            }
            .signature-box {
                width: 100%;
                height: 60px; /* Make the box larger for signatures */
                border: 1px solid #ccc;
                box-sizing: border-box;
            }
            table, th, td {
                border: 1px solid #ddd;
                border-collapse: collapse;
                text-align: center;
                padding: 10px;
            }
            .signature-table th, .signature-table td {
                border: 1px solid #ddd;
                padding: 10px;
                text-align: center;
                width: 25%; /* Ensures equal width */
            }
            .signature-table th {
                background-color: black;
            }
            .button-container {
                text-align: left;
                margin-top: 20px;
            }
            .button-container button {
                padding: 10px 20px;
                background-color: #000;
                color: #fff;
                border: none;
                cursor: pointer;
                margin-right: 10px;
            }
            .button-container button:hover {
                background-color: #333;
            }
            @media print {
                body {
                    font-size: 10pt;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 10px;
                }
                table, th, td {
                    border: 1px solid black;
                    padding: 8px;
                    text-align: left;
                }
                th {
                    background-color: #f2f2f2;
                }
                input[type="text"] {
                    border: none;
                    background-color: transparent;
                    width: 100%;
                }
                .signature-table {
                    width: 30%;
                    border-collapse: collapse;
                    margin-top: 20px;
                    float: right;
                }
                .signature-table th, .signature-table td {
                    border: 1px solid black;
                    padding: 10px;
                    text-align: center;
                    width: 25%;
                }
                .signature-table th {
                    background-color: #f2f2f2;
                }
                .button-container button {
                    display: none;
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <form method="post" action="">
                <h1>Surat Permintaan Barang</h1>
                <p><strong>Tanggal:</strong> <?php echo $currentDate; ?></p>
                <p><strong>Seksi:</strong> <?php echo $sectionName; ?></p>
                <div class="table-wrapper">
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
                            <?php
                            // Fetch rows from result set
                            while ($row = $result_select_items->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['material_number']); ?></td>
                                    <td><?php echo htmlspecialchars($row['material_desc']); ?></td>
                                    <td><?php echo htmlspecialchars($row['unit']); ?></td>
                                    <td><?php echo htmlspecialchars($row['quota_bulan']); ?></td>
                                    <td><?php echo htmlspecialchars($row['sisa_quota']); ?></td>
                                    <td>
                                        <input type="hidden" name="material_number[]" value="<?php echo htmlspecialchars($row['material_number']); ?>">
                                        <input type="number" name="permintaan_harian[]" value="<?php echo htmlspecialchars($row['permintaan_harian']); ?>">
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="signature-table">
                    <table>
                        <tr>
                            <th>Dibuat</th>
                            <th>Disetujui</th>
                            <th>Mengetahui</th>
                            <th>Diterima</th>
                        </tr>
                        <tr>
                            <td class="signature-box"></td>
                            <td class="signature-box"></td>
                            <td class="signature-box"></td>
                            <td class="signature-box"></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="dibuat_mtc" class="signature-input" value="<?php echo htmlspecialchars($dibuat_mtc); ?>"></td>
                            <td><input type="text" name="disetujui_section_head" class="signature-input" value="<?php echo htmlspecialchars($disetujui_section_head); ?>"></td>
                            <td><input type="text" name="mengetahui_dept_head" class="signature-input" value="<?php echo htmlspecialchars($mengetahui_dept_head); ?>"></td>
                            <td><input type="text" name="diterima_epp_controller" class="signature-input" value="<?php echo htmlspecialchars($diterima_epp_controller); ?>"></td>
                        </tr>
                        <tr>
                            <td>MTC</td>
                            <td>Section Head</td>
                            <td>Dept. Head</td>
                            <td>EPP Controller</td>
                        </tr>
                    </table>
                </div>
                <div class="button-container">
                    <button type="submit" name="update_items">Update Data</button>
                    <button type="button" onclick="window.print()">Print</button>
                    <button type="button" onclick="goBack()">Kembali</button>
                </div>
            </form>
        </div>
        <script>
            function goBack() {
                window.history.back();
            }
        </script>
    </body>
    </html>
    <?php
} else {
    echo "No items selected.";
}

// Close the database connection
$koneksi->close();
?>
