<?php

require_once "../config.php";

$title = "Dashboard";
require_once "../template_admin/header.php";
require_once "../template_admin/navbar.php";
require_once "../template_admin/sidebar.php";

?>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Monitoring Data</title>
    <link href="../asset/sb-admin/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
</head>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Material Cost Plant 1</li>
            </ol>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Total Material Cost Plant 1
                        </div>
                        <div class="card-body"><canvas id="Plant1" width="100%" height="50"></canvas></div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            All Kategori Performance Plant STR
                        </div>
                        <div class="card-body"><canvas id="myChart2" width="100%" height="50"></canvas></div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Consumable STR
                        </div>
                        <div class="card-body"><canvas id="myChart3" width="100%" height="50"></canvas></div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Tool Equipment STR
                        </div>
                        <div class="card-body"><canvas id="myChart4" width="100%" height="50"></canvas></div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Fuel Lubricant STR
                        </div>
                        <div class="card-body"><canvas id="myChart5" width="100%" height="50"></canvas></div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Cutting Tool STR
                        </div>
                        <div class="card-body"><canvas id="myChart6" width="100%" height="50"></canvas></div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Indirect Material STR
                        </div>
                        <div class="card-body"><canvas id="myChart7" width="100%" height="50"></canvas></div>
                    </div>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        </div>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="../asset/sb-admin/assets/demo/chart-bar.js"></script>
