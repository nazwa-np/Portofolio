<?php
// Include your database configuration
require_once "../config.php";

// Function to sanitize input data (to prevent SQL injection)
function sanitize($koneksi, $data) {
    return mysqli_real_escape_string($koneksi, $data);
}

// Handle form submission for updating all rows
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_items'])) {
    // Loop through all posted data to update each row
    foreach ($_POST['material_number'] as $key => $material_number) {
        $permintaan_harian = sanitize($koneksi, $_POST['permintaan_harian'][$key]);
        
        // Update query for each row, assuming material_number is the primary key
        $query_update_item = "UPDATE item_lpdc SET permintaan_harian = '$permintaan_harian' WHERE material_number = '$material_number'";
        
        // Execute query (you may want to add error handling here)
        if ($koneksi->query($query_update_item) === FALSE) {
            echo "Error updating record: " . $koneksi->error;
            exit();
        }
    }
    
    // Redirect back to selected_items.php after update
    header("Location: selected_items.php");
    exit();
} else {
    // Redirect to error page or handle invalid requests
    header("Location: error_page.php");
    exit();
}
?>