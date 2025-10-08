<div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Home</div>
                            <a class="nav-link" href="<?= $main_url ?>index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>

                            <hr class="sidebar-divider"> 
                            <div class="sb-sidenav-menu-heading">System</div>
                            <a class="nav-link" href="<?= $main_url ?>sap_user/entry_sap.php">
                                <div class="sb-nav-link-icon"><i class="fa-regular fa-pen-to-square"></i></div>
                                Entry SPB
                            </a>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Monitoring Data
                            </a>
                        </div>
                    </div>
      
                                
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged In As</div>
                        User
                    </div>
                </nav>
            </div>