<?php
// Koneksi ke db
$koneksi = mysqli_connect("localhost", "root", "", "db_project");
if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// query data
function query($query){
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;
}

// Fungsi untuk mengedit data material
function editMaterial($data){
    global $koneksi;
    $Reserv_no = $data["Reserv_no"];
    $material_number = htmlspecialchars($data["material_number"]);
    $Material_description = htmlspecialchars($data["Material_description"]);
    $Cost_Ctr = htmlspecialchars($data["Cost_Ctr"]);
    $Reqmts_date = htmlspecialchars($data["Reqmts_date"]);
    $Reqmnt_qty = htmlspecialchars($data["Reqmnt_qty"]);
    $Diff_qty = htmlspecialchars($data["Diff_qty"]);
    $BUn = htmlspecialchars($data["BUn"]);
    $Kode = htmlspecialchars($data["Kode"]);
    $Deskripsi = htmlspecialchars($data["Deskripsi"]);
    $Minggu_ke = htmlspecialchars($data["Minggu_ke"]);
    $Qty_Unit = htmlspecialchars($data["Qty_Unit"]);
    $Kode_Part = htmlspecialchars($data["Kode_Part"]);
    $Qty = htmlspecialchars($data["Qty"]);
    $Price = htmlspecialchars($data["Price"]);
    $Amount = htmlspecialchars($data["Amount"]);
    $Material_Seksi = htmlspecialchars($data["Material_Seksi"]);
    $Kategori = htmlspecialchars($data["Kategori"]);
    $Rp_Unit = htmlspecialchars($data["Rp_Unit"]);

    $query = "UPDATE material SET 
                Material = '$material_number',
                Material_description = '$Material_description',
                Cost_Ctr = '$Cost_Ctr',
                Reqmts_date = '$Reqmts_date',
                Reqmnt_qty = '$Reqmnt_qty',
                Diff_qty = '$Diff_qty',
                BUn = '$BUn',
                Kode = '$Kode',
                Deskripsi = '$Deskripsi',
                Minggu_ke = '$Minggu_ke',
                Qty_Unit = '$Qty_Unit',
                Kode_Part = '$Kode_Part',
                Qty = '$Qty',
                Price = '$Price',
                Amount = '$Amount',
                Material_Seksi = '$Material_Seksi',
                Kategori = '$Kategori',
                Rp_Unit = '$Rp_Unit'
                WHERE Reserv_no = '$Reserv_no'";

    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}

// Fungsi untuk mengambil data berdasarkan Reserv_no
function getMaterialByReservNo($Reserv_no) {
    global $koneksi;
    $query = "SELECT * FROM material WHERE Reserv_no = '$Reserv_no'";
    $result = mysqli_query($koneksi, $query);
    return mysqli_fetch_assoc($result);
}

?>
