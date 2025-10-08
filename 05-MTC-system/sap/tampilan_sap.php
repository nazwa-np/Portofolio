<?php
require_once "../config.php";

$title = "Dashboard";
require_once "../template_admin/header.php";
require_once "../template_admin/navbar.php";
require_once "../template_admin/sidebar.php";

// Query untuk mengambil data dari tabel item_lpdc
$query = "SELECT * FROM item_lpdc";
$result = $koneksi->query($query);

// Memeriksa jika query berhasil dieksekusi
if ($result) {
    // Menginisialisasi array untuk menyimpan data
    $dataOptions = [];

    // Mengambil hasil query dan menyimpannya dalam array
    while ($row = $result->fetch_assoc()) {
        // Misalnya, menyimpan material_number sebagai key dan material_desc sebagai value
        $dataOptions[$row['material_number']] = htmlspecialchars($row['material_desc']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Barang</title>
    <link href="../asset/sb-admin/css/sap.css" rel="stylesheet" />
    <style>
        /* Custom CSS styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .form-container {
            display: flex;
            justify-content: space-between;
            width: 100%;
            max-width: 1200px;
            margin-bottom: 20px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .form-group label {
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group select,
        .form-group input[type="date"] {
            width: 200px;
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            text-align: center;
        }
        .btn-create {
            align-self: flex-start;
            padding: 10px;
            background-color: #333;
            color: white;
            border: 1px solid #333;
            cursor: pointer;
            font-size: 14px;
            border-radius: 4px;
            text-align: center;
            text-decoration: none;
            margin-left: auto;
        }
        .btn-create:hover {
            background-color: #555;
            border-color: #555;
        }
        .table-header {
            display: flex;
            justify-content: space-between;
            width: 100%;
            max-width: 1200px;
            margin-bottom: 10px;
            font-weight: bold;
        }
        #sap-data {
            width: 100%;
            max-width: 1200px;
            border: 1px solid green;
            border-radius: 4px;
            padding: 10px;
            background-color: #fff;
        }
        .sap-row {
            border: 1px solid green;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div id="layoutSidenav_content">
    <div class="container">
        <div class="form-container">
            <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal">
            </div>
            <div class="form-group">
                <label for="seksi">Pilih Seksi</label>
                <select name="seksi" id="seksi" >
                    <option value="">Pilih Seksi</option>
                    <option value="">Seksi 1</option>
                    <option value="">Seksi 2</option>
                    <option value="">Seksi 3</option>
                
                </select>
            </div>
            <a href="create_record.php" class="btn-create">Create +</a>
        </div>

        <div class="table-header">
            <span>Seksi Yang Mengorder Material</span>
            <span>Keterangan Tanggal</span>
        </div>

        <div id="sap-data">
            <?php
            // Menampilkan nama seksi LPDC secara statis untuk contoh
            $namaSeksi = "LPDC";
            echo '<a href="../sap_user/selected_items.php" id="../sap_user/selected_items.php">' . $namaSeksi . '</a>';
            ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tanggal').on('change', function() {
                var tanggal = $(this).val();
                if (tanggal) {
                    $('#material_number').prop('disabled', false);
                } else {
                    $('#material_number').prop('disabled', true);
                }
            });

            $('#material_number').on('change', function() {
                var tanggal = $('#tanggal').val();
                var materialNumber = $(this).val();

                if (materialNumber && tanggal) {
                    // Build link to selected_items.php
                    var link = 'selected_items.php?tanggal=' + tanggal + '&material_number=' + materialNumber;
                    $('#link-to-selected-items').attr('href', link).show();
                } else {
                    $('#link-to-selected-items').hide();
                }
            });

            $('#btn-show-data').on('click', function() {
                var tanggal = $('#tanggal').val();
                var materialNumber = $('#material_number').val();

                if (!tanggal) {
                    alert('Silakan pilih tanggal.');
                    return;
                }

                if (!materialNumber) {
                    alert('Silakan pilih material.');
                    return;
                }

                $.ajax({
                    url: 'fetch_sap_data.php',
                    method: 'POST',
                    data: { tanggal: tanggal, material_number: materialNumber },
                    success: function(response) {
                        $('#sap-data').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert('Terjadi kesalahan saat memuat data.');
                    }
                });
            });
        });
    </script>
</body>
</html>

<?php
require_once "../template_admin/footer.php";
?>
