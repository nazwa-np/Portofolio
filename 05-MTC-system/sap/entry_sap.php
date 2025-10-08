<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkbox Table</title>
    <link href="../asset/sb-admin/css/sap.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px; /* Increase the font size */
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            padding: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .table-wrapper {
            overflow-x: auto; /* Allow horizontal scrolling */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            table-layout: auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 14px; /* Increase the font size */
            white-space: nowrap; /* Prevent text wrapping */
            background-color: #fff; /* Background color for all cells */
        }
        th {
            background-color: #333;
            color: #fff;
            position: sticky;
            top: 0;
        }
        th.sticky {
            left: 0;
            z-index: 2;
        }
        th.sticky-2 {
            left: 50px;
            z-index: 1;
        }
        th.sticky-3 {
            left: 150px;
            z-index: 0;
        }
        td.sticky,
        th.sticky {
            position: sticky;
            left: 0;
            z-index: 3;
        }
        td.sticky-2,
        th.sticky-2 {
            position: sticky;
            left: 50px;
            z-index: 2;
        }
        td.sticky-3,
        th.sticky-3 {
            position: sticky;
            left: 150px;
            z-index: 1;
        }
        .form-container {
            margin-top: 20px;
            text-align: center; /* Aligning form container to center */
        }
        .form-container label {
            display: block;
            width: 150px;
            margin: 0 auto 10px; /* Centering label */
            color: #333;
        }
        .form-container input {
            width: calc(100% - 160px);
            padding: 8px;
            margin: 0 auto 10px; /* Centering input */
            border: 1px solid #ddd;
            font-size: 14px; /* Increase the font size */
        }
        .bottom-container {
            margin-top: 20px;
            text-align: center; /* Aligning bottom container to center */
        }
        .bottom-container h2 {
            margin-bottom: 10px;
            color: #333;
        }
        #submit-button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #333;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 14px; /* Increase the font size */
        }
        #submit-button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
<?php
require_once "../config.php";

$title = "Dashboard";
require_once "../template_admin/header.php";
require_once "../template_admin/navbar.php";
require_once "../template_admin/sidebar.php";
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container">
            <h2>Entry SAP</h2>
            <?php
            // Query data from list_lpdc with required columns
            $query_lpdc = "SELECT l.material_number, l.material_desc, l.unit, l.kuota_mps, COALESCE(m.reqmnt_qty, 0) as reqmnt_qty 
                           FROM list_lpdc l 
                           LEFT JOIN material m ON l.material_number = m.material_number AND m.cost_ctr = 'P1LP10'";
            $result_lpdc = $koneksi->query($query_lpdc);

            // Fetch data from list_lpdc
            if ($result_lpdc->num_rows > 0) {
                $data_lpdc = $result_lpdc->fetch_all(MYSQLI_ASSOC);
            } else {
                $data_lpdc = [];
            }
            ?>

            <!-- Table with Checkboxes -->
            <div class="top-container">
                <form id="selected-form" method="post" action="selected_items.php">
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th class="sticky">Select</th> <!-- Changed from No to Select -->
                                    <th class="sticky-2">Part Number</th>
                                    <th class="sticky-3">Nama Barang</th>
                                    <th>Satuan</th>
                                    <th>Quota Bulan Ini</th>
                                    <th>Sisa Quota Bulan Ini</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            // Iterate through data_lpdc to display rows
                            foreach ($data_lpdc as $index => $item_lpdc): 
                                // Initialize variables
                                $material_number = $item_lpdc['material_number'];
                                $kuota_mps = $item_lpdc['kuota_mps'];
                                $reqmnt_qty = $item_lpdc['reqmnt_qty'];

                                // Ensure numeric values for calculation
                                $kuota_mps = is_numeric($kuota_mps) ? $kuota_mps : 0;
                                $reqmnt_qty = is_numeric($reqmnt_qty) ? $reqmnt_qty : 0;

                                // Calculate Sisa Quota Bulan Ini
                                $sisa_quota = $kuota_mps - $reqmnt_qty;

                            ?>
                                <tr>
                                    <td class="sticky"><input type="checkbox" name="selected_items[]" value="<?php echo $material_number; ?>"></td>
                                    <td class="sticky-2"><?php echo $material_number; ?></td>
                                    <td class="sticky-3"><?php echo $item_lpdc['material_desc']; ?></td>
                                    <td><?php echo $item_lpdc['unit']; ?></td>
                                    <td><?php echo number_format($kuota_mps, 0, ',', '.'); ?></td>
                                    <td><?php echo number_format($sisa_quota, 0, ',', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- Input fields for new data -->
                    <!-- Submit button -->
                    <div class="bottom-container">
                        <button type="submit" id="submit-button">Submit</button>
                    </div>
                </form>
            </div>

            <!-- Selected Data Table -->
            <div class="bottom-container">
                <h2>Selected Items</h2>
                <div id="selected-data"></div>
            </div>
            
        </div>
    </main>
</div>
</body>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
        $(document).ready(function() {
            $('input[type="checkbox"]').on('change', function() {
                updateSelectedData();
            });

            $('#submit-button').on('click', function() {
                $('#selected-form').submit();
            });

            function updateSelectedData() {
                var selectedIds = $('input[type="checkbox"]:checked').map(function() {
                    return $(this).val();
                }).get();

                $.ajax({
                    url: 'update_selection.php',
                    method: 'POST',
                    data: {selected: selectedIds},
                    success: function(response) {
                        $('#selected-data').html(response);
                    }
                });
            }
        });
    </script>
</html>
