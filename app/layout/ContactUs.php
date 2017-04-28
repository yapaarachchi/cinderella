<?php
require "../Config.php";
require "../ErrorCode.php";
require '../../vendor/autoload.php';

$db = Config::initDb();
$auth = new \Delight\Auth\Auth($db);
$isLoggedIn = $auth->isLoggedIn();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
	<link rel="stylesheet" href="../../css/cinderella.css">
	
	<title>Cinderella - Contact Us</title>
  </head>
  <body>
	<?php include('NavBar.php'); ?>
	
	<!-- Main Container -->
	<div class="container-fluid">
		<!-- Main Row -->
		<div class="row">
		
			<!-- Margin Left Pannel -->
			<div class="col-lg-1 hidden-md-down">
			</div>
			
			<!-- Middle Pannel -->
			<div class="col-lg-10">
				<div class="card">
				<div class="card-header">
				<h4 class="card-title">Contact Us</h4>
				</div>
				  <div class="card-block">
					
					<p class="card-subtitle mb-2 text-muted">
					Building a website is, in many ways, an exercise of willpower. It’s tempting to get distracted by the bells and whistles of the design process, and forget all about creating compelling content. But it's that last part that's crucial to making inbound marketing work for your business.

So how do you balance your remarkable content creation with your web design needs? It all starts with the "About Us" page.
For a remarkable about page, all you need to do is figure out your company's unique identity, and then share it with the world. Easy, right? Of course it's not easy. That said, the "About Us" page is one of the most important pages on your website, and it can't go neglected. It also happens to be one of the most commonly overlooked pages, which is why you should make it stand out. 
Download our collection of awesome 'About Us' page examples here, and get tips for making yours great, too. 

But it can be accomplished. In fact, there are some companies out there with remarkable "About Us" pages, and there are elements of them that you can emulate on your own website. By the end of this post, showing off how your company's greatness won't seem like such a challenging feat.
					
					
					
					
					</p>
				  </div>
				</div>
			</div>
			
			<!-- Margin Right Pannel -->
			<div class="col-lg-1 hidden-md-down">
			</div>
		
		</div>
	</div>
	</br>
	<nav class="navbar sticky-top navbar-inverse bg-inverse">

		<div class="row">
		
		<div class="col-5">
			
				<a href="AboutUs.php" >About Us</a>
				<span class="text-muted">|</span>
				<a href="../Search" >Search</a>
			
		</div>
		
		<div class="col-5">
		
		<span style="color:white">© 2017 Cinderella  </span> 
		<span  class="text-muted">(All Rights Reserved)</span> 
		</div>
		
		<div class="col-2 float-right">
		<a href="https://www.facebook.com/Cinderellalk-379706339094765/" target="_blank" ><img src="../../assets/icons/facebook.png" style="width:30px; height:30px; margin: 0 auto" class="img-fluid d-block" alt="Image"></a>		
		</div>
		
		</div>
		
	</nav>
	
	<?php
	if($isLoggedIn === false){
		include('RegisterPannelSm.php');
	}		
	?>
						
    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="../../js/jquery-3.1.1.slim.min.js"></script>
    <script src="../../js/tether.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
	
	<script src="../../js/jquery.validate.min.js"></script>
	<script src="../../js/additional-methods.min.js"></script>
	<script src="../../js/cinderella.js"></script>
	
<script>
$(document).ready(function() {	
loginModalValidate('loginGeneral');
loginModalSubmit('loginGeneral', 'loginModalGeneralError');
loginModalOnClose('LogInModalGeneral', 'loginGeneral', 'loginModalGeneralError');
signOut('signOut');
});
</script>
</body>
</html>