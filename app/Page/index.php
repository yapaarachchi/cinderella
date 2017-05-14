<?php
require "../Config.php";
require "../ErrorCode.php";
require '../../vendor/autoload.php';

$db = Config::initDb();
$auth = new \Delight\Auth\Auth($db);
$Business = new \Delight\Auth\Business($db);
$Media = new \Delight\Auth\Media($db);
$isLoggedIn = $auth->isLoggedIn();
$business_id = null;
$user_id;
if (isset($_GET)) {
					if (isset($_GET['business'])) {
						$business_id = $_GET['business'];
						if($Business->IsBusinessExistById($business_id, true) === false){
							header('Location: ../../');
						}
							$OtherBusinesses = $Business->getBusinessById($business_id );
							if (is_array($OtherBusinesses) || is_object($OtherBusinesses))
							{
								foreach($OtherBusinesses as $key => $value) {
									$user_id = $value['user_id'];
								}
							}
							$OtherBusinesses = $Business->getBusinessById($business_id );
							if (is_array($OtherBusinesses) || is_object($OtherBusinesses))
							{
								foreach($OtherBusinesses as $key => $value) {
									$user_id = $value['user_id'];
								}
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
			
			<!-- Mobile View -->
			<div class="col-12 hidden-md-up">
				<div id="SmallDevices" class="col-12" style="margin-bottom: 50px">
				</div>	
			</div>	
			
			
			<!-- left Pannel -->
			<div class="col-2 hidden-md-down">
					
			</div>				
			
			<!-- Middle Pannel -->
			<div class="col-lg-8 col-md-12 hidden-sm-down">
				<div class="row">
					<div id="MainHeaderLarge" class="col-12">
					</div>	
				</div>
				<div class="row" style="margin-top:10px; margin-bottom:30px">
					<div class="col-12" >
						<ul class="nav nav-tabs" role="tablist">
						  <li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#ContactTab" role="tab">Contact</a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#DetailTab" role="tab">Detail</a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#BranchesTab" role="tab">Branches</a>
						  </li>
							<?php 
								if($Media->getVideoCount($business_id, true) > 0){
							?>
						  <li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#VideosTab" role="tab">Videos</a>
						  </li>
						  <?php 
								}							
							if($Business->getBusinessesCount($user_id, true, $business_id) > 0){
							?>
						  <li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#OtherBusinessesTab" role="tab">Other Businesses</a>
						  </li>
						  <?php 
							}
							?>
						</ul>
					</div>

					<div class="tab-content">
					  <div class="tab-pane active" id="ContactTab" role="tabpanel" >
						<div id="Information" style="margin-top: 10px;">
						</div>	
					  </div>
					  <div class="tab-pane" id="DetailTab" role="tabpanel">
						<div id="Description" style="margin-top: 10px;">
						</div>	
					  </div>
					  <div class="tab-pane" id="BranchesTab" role="tabpanel" >
						<div id="Branches" style="margin-top: 10px;">
						</div>	
					  </div>
						 <?php 	
					if($Media->getVideoCount($business_id, true) > 0){
					?>
					  <div class="tab-pane" id="VideosTab" role="tabpanel" style="margin-top: 10px;">
						<div id="Videos" style="margin-top: 10px;">
						</div>
					  </div>
							<?php 
					}
					?>
					  <?php 	
					if($Business->getBusinessesCount($user_id, true, $business_id) > 0){
					?>
					<div class="tab-pane" id="OtherBusinessesTab" role="tabpanel" >
						<div id="OtherBusinesses" style="margin-top: 10px;">
						</div>	
					</div>
					<?php 
					}
					?>
					</div>
					
				</div>
		
			</div>	
			
			<!-- right Pannel -->
			<div class="col-2 hidden-md-down">
					
			</div>				
		</div>		
		
		
			
	</div>
	</br>
	<?php
		include('../layout/RegisterPannelSm.php');
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
getLayout("GetMerchantData.php","#MainHeaderLarge", "header");
getLayout("GetMerchantData.php","#Information", "info");
getLayout("GetMerchantData.php","#Description", "description");
getLayout("GetMerchantData.php","#Branches", "branches");
getLayout("GetMerchantData.php","#OtherBusinesses", "OtherBusinesses");
getLayout("GetMerchantData.php","#Videos", "Videos");

getLayout("GetMerchantData.php","#SmallDevices", "SmallDevices");

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

$('body').on('click', 'div.more-detail', function() {
   var businessid = $(this).data('businessid');
	 NavigateToPage(businessid, '../controller/Navigate.php', '../Page/index.php');		
});

$('body').on('click', 'a.more-detail', function() {
   var businessid = $(this).data('businessid');
	 NavigateToPage(businessid, '../controller/Navigate.php', '../Page/index.php');		
});

});
    


</script>
</body>
</html>