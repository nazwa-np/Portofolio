<?php

require_once "config.php";

$title = "Dashboard";
require_once "template_admin/header.php";
require_once "template_admin/navbar.php";
require_once "template_admin/sidebar.php";

?>

<div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4 justify-content-center">
                        <h1 class="mt-4 mb-4">Dashboard</h1>
                        <div class="container justify-content-center">
                        <div class="card">
  <div class="card-header">
    Monitoring   
  </div>
  <div class="card-body">
    <h5 class="card-title">Material Cost Plant 1</h5>
    <p class="card-text">Menampilkan Data Cost Plant 1 dalam bentuk grafik</p>
    <a href="<?= $main_url ?>/monitoring/plant.php" class="btn btn-dark">View Details</a>
  </div>
  <div class="card-body">
    <h5 class="card-title">Material Cost Department</h5>
    <p class="card-text">Menampilkan Data Cost Department dalam bentuk grafik</p>
    <a href="<?= $main_url ?>/monitoring/department.php" class="btn btn-dark">View Details</a>
  </div>
  <div class="card-body">
    <h5 class="card-title mb-3">Material Cost Section</h5>
    <p class="card-text">Menampilkan Data Cost Section dalam bentuk grafik</p>
    <a href="<?= $main_url ?>/monitoring/section.php" class="btn btn-dark">View Details</a>
  </div>
</div>


                        </div>
                        <div class="row">
<?php

require_once "template_admin/footer.php";

?>