<!-- Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/ -->
<?php
require_once __DIR__ . '/../config.php';
$current_page = basename($_SERVER['PHP_SELF']);

// Always point to project root
$baseUrl = rtrim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']), '/');
$baseUrl = rtrim(preg_replace('#/admin(/|$)#', '/', $baseUrl), '/') . '/';
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin Page</title>

	<!-- favicon -->
	<link rel="shortcut icon" type="image/png" href="<?= $baseUrl ?>assets/images/icons/velvet-lavender-logo.png">

	<!-- google fonts -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">

	<!-- styles -->
	<link rel="stylesheet" href="<?= $baseUrl ?>assets/css/all.min.css">
	<link rel="stylesheet" href="<?= $baseUrl ?>assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= $baseUrl ?>assets/css/owl.carousel.css">
	<link rel="stylesheet" href="<?= $baseUrl ?>assets/css/magnific-popup.css">
	<link rel="stylesheet" href="<?= $baseUrl ?>assets/css/animate.css">
	<link rel="stylesheet" href="<?= $baseUrl ?>assets/css/meanmenu.min.css">
	<link rel="stylesheet" href="<?= $baseUrl ?>assets/css/main.css">
	<link rel="stylesheet" href="<?= $baseUrl ?>assets/css/responsive.css">
</head>

<body>
	<!--PreLoader-->
	<div class="loader">
		<div class="loader-inner">
			<div class="circle"></div>
		</div>
	</div>
	<!--PreLoader Ends-->

	<!-- header -->
	<div class="top-header-area" id="sticker">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-sm-12 text-center">
					<div class="main-menu-wrap">
						<!-- logo -->
						<div class="site-logo">
							<a href="<?= $baseUrl ?>index.php">
								<img src="<?= $baseUrl ?>assets/images/icons/velvet-lavender-logo.png" alt="Logo">
							</a>
						</div>

						<!-- menu start -->
						<nav class="main-menu">
							<ul>
								<li>
									<div class="header-icons">
										<a class="home-icon" href="<?= $baseUrl ?>admin/manage.php"><i class="fas fa-home"></i></a>
										<a class="logout-icon" href="<?= $baseUrl ?>admin-logout.php"><i class="fas fa-sign-out-alt"></i></a>
									</div>
								</li>
							</ul>
						</nav>
						<!-- menu end -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end header -->