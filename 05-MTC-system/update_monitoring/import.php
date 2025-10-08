<?php
require_once "../config.php";

$title = "Dashboard";
require_once "../template_admin/header.php";
require_once "../template_admin/navbar.php";
require_once "../template_admin/sidebar.php";

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
            $Reserv_no = mysqli_real_escape_string($koneksi, $data[0]);
            $material_number = mysqli_real_escape_string($koneksi, $data[1]);
            $Material_description = mysqli_real_escape_string($koneksi, $data[2]);
            $Cost_Ctr = mysqli_real_escape_string($koneksi, $data[3]);
            $Reqmts_date = date('Y-m-d', strtotime($data[4]));
            $Reqmnt_qty = intval($data[5]); // Konversi ke integer
            $Diff_qty = intval($data[6]); // Konversi ke integer
            $BUn = mysqli_real_escape_string($koneksi, $data[7]);
            $Kode = mysqli_real_escape_string($koneksi, $data[8]);
            $Deskripsi = mysqli_real_escape_string($koneksi, $data[9]);
            $Minggu_ke = intval($data[10]); // Konversi ke integer
            $Qty_Unit = intval($data[11]); // Konversi ke integer
            $Kode_Part = mysqli_real_escape_string($koneksi, $data[12]);
            $Qty = intval($data[13]); // Konversi ke integer
            $Price = floatval($data[14]); // Konversi ke float
            $Amount = floatval($data[15]); // Konversi ke float
            $Material_Seksi = mysqli_real_escape_string($koneksi, $data[16]);
            $Kategori = mysqli_real_escape_string($koneksi, $data[17]);
            $Rp_Unit = intval($data[18]); // Konversi ke integer

            // Periksa jika nilai Reqmts Date kosong atau tidak valid
            if (empty($Reserv_no)) {
                // Tindakan perbaikan sesuai kebutuhan
                // Misalnya, beri nilai default atau abaikan baris tersebut
                continue; // Melanjutkan ke baris berikutnya
            }

            // Contoh query insert, sesuaikan dengan struktur tabel Anda
            $query = "INSERT INTO material (Reserv_no, Material, Material_description, Cost_Ctr, Reqmts_date, Reqmnt_qty, Diff_qty, BUn, Kode, Deskripsi, Minggu_ke, Qty_Unit, Kode_Part, Qty, Price, Amount, Material_Seksi, Kategori, Rp_Unit) 
            VALUES ('$Reserv_no', '$material_number', '$Material_description', '$Cost_Ctr', '$Reqmts_date', $Reqmnt_qty, $Diff_qty, '$BUn', '$Kode', '$Deskripsi', $Minggu_ke, $Qty_Unit, '$Kode_Part', $Qty, $Price, $Amount, '$Material_Seksi', '$Kategori', $Rp_Unit)
            ON DUPLICATE KEY UPDATE
            Material = VALUES(Material), Material_description = VALUES(Material_description), Cost_Ctr = VALUES(Cost_Ctr), Reqmts_date = VALUES(Reqmts_date), Reqmnt_qty = VALUES(Reqmnt_qty), Diff_qty = VALUES(Diff_qty), BUn = VALUES(BUn), Kode = VALUES(Kode), Deskripsi = VALUES(Deskripsi), Minggu_ke = VALUES(Minggu_ke), Qty_Unit = VALUES(Qty_Unit), Kode_Part = VALUES(Kode_Part), Qty = VALUES(Qty), Price = VALUES(Price), Amount = VALUES(Amount), Material_Seksi = VALUES(Material_Seksi), Kategori = VALUES(Kategori), Rp_Unit = VALUES(Rp_Unit)";

            $result = mysqli_query($koneksi, $query);
        }
        


        fclose($handle);
        return true;
    } else {
        return false;
    }
    // Periksa jika nilai Reqmts Date kosong atau tidak valid
    
}

// Cek jika form untuk impor file CSV dikirim

if(isset($_POST['submit'])) {
    $file = $_FILES['file']['tmp_name'];
    $result = importCSV($file);
    if($result) {
        // Jika impor berhasil, tampilkan pesan JavaScript
        echo '<script>alert("Data berhasil di-submit!"); window.location.href = "data.php";</script>';
    } else {
        // Jika impor gagal, tampilkan pesan JavaScript
        echo '<script>alert("Gagal melakukan impor. Pastikan file CSV benar.");</script>';
    }
    
}

?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4 justify-content-center">
            <h1 class="mt-4 mb-5">Update Monitoring</h1>
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

<?php require_once "../template_admin/footer.php";?>
