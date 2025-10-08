<?php

require_once "../config.php";

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login - MTC System</title>
        <link href="<?= $main_url ?>asset/sb-admin/css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
	<body class="bg-secondary">
	<?php 
	if(isset($_GET['pesan'])){
		if($_GET['pesan']=="gagal"){
			echo "<div class='alert'>Username dan Password tidak sesuai !</div>";
		}
	}
	?>
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container mt-5">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h4 class="text-center font-weight-light my-4">Login - MTC System</h4></div>
                                    <div class="card-body">
 
		<form action="cek_login.php" method="post">
			<div class="form-floating mb-3">
				<input  class="form-control" type="text" name="username" placeholder="Username .." required="required">
				<label>Username</label>
			</div>
			<div class="form-floating mb-3">
				<input  class="form-control" type="password" name="password" placeholder="Password .." required="required">
				<label>Password</label>
			</div>
			<button type="submit" name="login" class="btn btn-dark col-12 rounded-pill my-2">Login</button>
 
			<br/>
		</form>
		</div>
                                    <div class="card-footer text-center py-3">
                                        <div class="text-muter small"> Copyright &copy; MTC System <?= date("Y") ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?= $main_url ?>asset/sb-admin/js/scripts.js"></script>
    </body>
</html>