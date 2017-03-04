<?php
require 'app/config.php';
require __DIR__.'/vendor/autoload.php';

$db = Config::initDb();
$auth = new \Delight\Auth\Auth($db);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/cinderella.css">
	
  </head>
  <body>
	<nav class="navbar fixed-top navbar-inverse bg-inverse navbar-toggleable-md">
		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<a class="navbar-brand" href="#"><b>Cinderella</b></a>
		
		<!-- Large Screens -->
		<ul class="nav navbar-nav hidden-md-down">
		  <li class="nav-item">
			<a class="nav-link" href="#">About Us</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" href="#">Contact Us</a>
		  </li>
		</ul>
		
		<!-- Toggle - Small Screen -->
		<div class="collapse navbar-toggleable-md" id="navbarNavDropdown">
			<ul class="nav navbar-nav hidden-lg-up">
			  <li class="nav-item">
				<a class="nav-link" href="#">Photography & Videography <span class="sr-only">(current)</span></a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="#">Bridal Dressing</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="#">Bridal Wear and Designing</a>
			  </li>
			</ul>
		</div>
	</nav>

	<!-- Main Container -->
	<div class="container-fluid">
		<!-- Main Row -->
		<div class="row">
		
			<!-- Margin Left Pannel -->
			<div class="col-lg-1 hidden-md-down">
			</div>
			
			
			<!-- Left Pannel -->
			<div class="col-lg-2 hidden-md-down">
				<?php
					include('app/layout/SideMenu.php');
				?>
			</div>
			
			<!-- Middle Pannel -->
			<div class="col-lg-8">
				<div class="row">
					<div class="col-lg-12">
						<!-- put main banner here -->
						<?php
							include('app/layout/MainBanner.php');
						?>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<!-- put promotions here -->
						<?php
							include('app/layout/RegisterPannelLg.php')
						?>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<!-- put promotions here -->
						<?php
							include('app/layout/Promotions.php')
						?>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
					<!-- put main adds here -->
						<?php
							include('app/layout/MainAds.php')
						?>
					</div>
				</div>
			</div>
			
			<!-- Margin Right Pannel -->
			<div class="col-lg-1 hidden-md-down">
			</div>
		
		</div>
	</div>
	
	<?php
		include('app/layout/RegisterPannelSm.php')
	?>
						
    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="js/jquery-3.1.1.slim.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>