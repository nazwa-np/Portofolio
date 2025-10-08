<?php
require_once "../../config.php";

$title = "Dashboard";
require_once "../../template_admin/header.php";
require_once "../../template_admin/navbar.php";
require_once "../../template_admin/sidebar.php";

// Fungsi untuk menangani impor file CSV
function importCSV($file) {
    global $koneksi;

    // Membaca file CSV
    $handle = fopen($file, "r");
    if ($handle !== FALSE) {
        // Membuang baris pertama jika itu adalah header
        fgetcsv($handle);
        
        // Memasukkan data ke dalam database
        while (($data = fgetcsv($handle, 5000, ",")) !== FALSE) {
            // Lakukan sanitasi data di sini jika diperlukan
            $tipe_material = mysqli_real_escape_string($koneksi, $data[0]);
            $material_number = mysqli_real_escape_string($koneksi, $data[1]);
            $material_desc = mysqli_real_escape_string($koneksi, $data[2]);
            $unit = mysqli_real_escape_string($koneksi, $data[3]);
            $qty = intval($data[4]); // Konversi ke integer
            $price = floatval($data[5]); // Konversi ke float
            $std_using = mysqli_real_escape_string($koneksi, $data[6]);
            $kuota_mps = mysqli_real_escape_string($koneksi, $data[7]);
            $actual_prod = mysqli_real_escape_string($koneksi, $data[8]);
            $vol_prod = mysqli_real_escape_string($koneksi, $data[9]);
            $plan = mysqli_real_escape_string($koneksi, $data[10]);

            // Cek jika material_number tidak kosong
            if (!empty($material_number)) {
                // Contoh query insert, sesuaikan dengan struktur tabel Anda
                $query = "INSERT INTO list_aua (tipe_material, material_number, material_desc, unit, qty, price, std_using, kuota_mps, actual_prod, vol_prod, plan) 
                VALUES ('$tipe_material', '$material_number', '$material_desc', '$unit', $qty, $price, '$std_using', '$kuota_mps', '$actual_prod', '$vol_prod', '$plan')
                ON DUPLICATE KEY UPDATE
                material_number = VALUES(material_number), material_desc = VALUES(material_desc), unit = VALUES(unit), qty = VALUES(qty), price = VALUES(price), std_using = VALUES(std_using), kuota_mps = VALUES(kuota_mps), actual_prod = VALUES(actual_prod), vol_prod = VALUES(vol_prod), plan = VALUES(plan)";

                $result = mysqli_query($koneksi, $query);
            }
        }
        
        fclose($handle);
        return true;
    } else {
        return false;
    }
}

// Cek jika form untuk impor file CSV dikirim
if(isset($_POST['submit'])) {
    $file = $_FILES['file']['tmp_name'];
    $result = importCSV($file);
    if($result) {
        // Jika impor berhasil, tampilkan pesan JavaScript
        echo '<script>alert("Data berhasil di-submit!"); window.location.href = "list_aua.php";</script>';
    } else {
        // Jika impor gagal, tampilkan pesan JavaScript
        echo '<script>alert("Gagal melakukan impor. Pastikan file CSV benar.");</script>';
    }
}
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4 justify-content-center">
            <h1 class="mt-4 mb-5">List Material Assy Unit A</h1>
            <div class="container justify-content-center">
                <!-- Form untuk mengunggah file CSV -->
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="file">Upload CSV</label>
                        <input type="file" class="form-control-file" id="file" name="file">
                    </div>
                    <button type="submit" class="btn btn-dark mt-4 mb-5" name="submit">Import Data</button>
                </form>
            </div>
        </div>    
    </main>

<?php require_once "../../template_admin/footer.php";?>
