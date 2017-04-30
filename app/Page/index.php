<?php
require "../Config.php";
require "../ErrorCode.php";
require '../../vendor/autoload.php';

$db = Config::initDb();
$auth = new \Delight\Auth\Auth($db);
$Business = new \Delight\Auth\Business($db);
$isLoggedIn = $auth->isLoggedIn();
$business_id = null;
if (isset($_GET)) {
					if (isset($_GET['business'])) {
						$business_id = $_GET['business'];
						if($Business->IsBusinessExistById($business_id, true) === false){
							header('Location: ../../');
						}
						
					}
					else{
						header('Location: ../../');
					}
}

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
	
	<title>Cinderella</title>
  </head>
  <body>
  <?php include('../layout/NavBar.php'); ?>
	<!-- Main Container -->
	<div class="container-fluid">
		<!-- Main Row -->
		<div class="row">
		
			<!-- Margin Left Pannel -->
			<div class="col-lg-1 hidden-md-down">
			</div>
			
			
			
			
			<!-- Middle Pannel -->
			<div class="col-lg-10">
				<div class="row">
				
				<div id="HeaderInformation" class="col-lg-3 col-md-4">
					<!-- Business name and info -->
				</div>
				
				<div id="MerchantBanner" class="col-lg-9 col-md-8  hidden-sm-down">
					
				</div>
				
				</div><!-- end row -->
				
				
				<div class="row" style="margin-top:5px">
				
				
					<div class="col-lg-3 col-md-4 hidden-sm-down">
						<div class="card">								
								<div class="card-block">
									<h6 class="card-subtitle mb-2 text-muted">
									Branches
									</h6>	
								<div id="Branches" >	
								</div>
								</div>
							</div>
					</div>
					<div class="col-lg-9 col-md-8">
					
						<div id="Description"  class="card">
						 <!-- 
							<div class="card-header">
								<a data-toggle="collapse" href="#Description" aria-expanded="false" aria-controls="Description">
									Collapse
								</a>
							</div>
							-->
						  <div class="card-block">
								
						  </div>
						</div>
						</br>
						
						<div class="row">
							
								<iframe class="col-lg-6 col-md-6" height="300px" src="http://www.youtube.com/embed/W7qWa52k-nE" frameborder="0" allowfullscreen></iframe>
							
								<iframe class="col-lg-6 col-md-6" height="300px" src="http://www.youtube.com/embed/W7qWa52k-nE" frameborder="0" allowfullscreen></iframe>
							
						</div>
					
					</div>
					
					<div id="OtherBusinesses" class="col-lg-3 col-md-4 hidden-sm-up">
						<div class="card">
						  <div class="card-block">
							<h6 class="card-subtitle mb-2 text-muted">
								Other Businesses Of this Merchant
							</h6>
							</br>
							<div id="OtherMobile"> <!-- other businesses -->  </div>
						  </div>
						</div>
					</div>
				
				</div><!-- end row -->
				
				
				
				
				
				
			</div>
			
			<!-- Margin Right Pannel -->
			<div class="col-lg-1 hidden-md-down">
			</div>
		
		</div>
	</div>
	</br>
	<?php
	if($isLoggedIn === false){
		include('../layout/RegisterPannelSm.php');
	}		
	?>
	<?php
	include('../layout/Footer.php');	
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


var businessId = <?php echo $business_id ;?>;
getLayout("GetMerchantData.php","#HeaderInformation", "info");
getLayout("GetMerchantData.php","#MerchantBanner", "banner");
getLayout("GetMerchantData.php","#Description", "description");
getLayout("GetMerchantData.php","#Other", "other");
getLayout("GetMerchantData.php","#OtherMobile", "other");
getLayout("GetMerchantData.php","#Branches", "branches");

function getLayout(pageName, divName, action){

	var response;
	var request;

    if (request) {
        request.abort();
    }
	
    request = $.ajax({
        url: pageName,
        type: "post",
        data: {action:action,business_id: businessId}
    });
	
    request.done(function (response, textStatus, jqXHR){		
		$(divName).html(response);
		$(divName).hide().fadeIn('fast');	
    });

    request.fail(function (jqXHR, textStatus, errorThrown){
		$(divName).hide().fadeIn('fast');	
    });

};

});
    


</script>
</body>
</html>