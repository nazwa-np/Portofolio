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
function editList($data){
    global $koneksi;
    $tipe_material = htmlspecialchars($data["tipe_material"]);
    $material_number = htmlspecialchars($data["material_number"]);
    $material_desc = htmlspecialchars($data["material_desc"]);
    $unit = htmlspecialchars($data["unit"]);
    $qty = intval($data["qty"]);
    $price = floatval($data["price"]);
    $std_using = htmlspecialchars($data["std_using"]);
    $kuota_mps = htmlspecialchars($data["kuota_mps"]);
    $actual_prod = htmlspecialchars($data["actual_prod"]);
    $vol_prod = htmlspecialchars($data["vol_prod"]);
    $plan = htmlspecialchars($data["plan"]);

    $query = "UPDATE list_aub SET 
                material_number = '$material_number',
                material_desc = '$material_desc',
                unit = '$unit',
                qty = '$qty',
                price = '$price',
                std_using = '$std_using',
                kuota_mps = '$kuota_mps',
                actual_prod = '$actual_prod',
                vol_prod = '$vol_prod',
                plan = '$plan'
                WHERE tipe_material = '$tipe_material'";

    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}
// Fungsi untuk mengambil data berdasarkan tipe_material
function getMaterialNumByTipeMaterial($tipe_material) {
    global $koneksi;
    $query = "SELECT * FROM list_aub WHERE tipe_material = '$tipe_material'";
    $result = mysqli_query($koneksi, $query);
    return mysqli_fetch_assoc($result);
}
?>
