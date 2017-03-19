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
	<style>
		.active-links {
			position:absolute;
			right:8px;
			top:0;
		}

		#session {
			cursor:pointer;
			display:inline-block;
			height:20px;
			padding:10px 12px;
			vertical-align: top;
			white-space: nowrap;
		}

		#signin-dropdown {
			background-color: #373a3c ;
			border-bottom-left-radius:5px;
			border-bottom-right-radius:5px;
			box-shadow:0 1px 2px #666666;
			-webkit-box-shadow: 0 1px 2px #666666;
			min-height:70px;
			min-width:130px;
			position:absolute;
			right:0;
			display:none;
			margin-top: 30px;
		}
	</style>
	
  </head>
  <body>
	<nav class="navbar fixed-top navbar-inverse bg-inverse navbar-toggleable-md">
		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<a class="navbar-brand" href="../../"><b>Cinderella</b></a>
		
		<!-- Large Screens -->
		<ul class="nav navbar-nav hidden-md-down">
		  <?php
			if($isLoggedIn === true){				
			?>
			<li class="nav-item">
			<a class="nav-link" href="#"><u>Sign Out</u></a>
		  </li>
			<?php
				}
			?>
		</ul>
		
		
				<form class="form-inline" id="searchForm">
				
				<select class="form-control" id="category1" name="category1">
				</select>
						
				<select class="form-control" id="category2" name="category2">
				<option value="" disabled selected>Sub Category</option>
				</select>
				
				<select class="form-control"  name="district" id="district">
							<option value="" disabled selected>District</option>
							<option value=""></option>
							<option>Colombo</option>
							<option>Kandy</option>
							<option>Galle</option>
							<option>Ratnapura</option>
							<option>Ampara</option>
							<option>Anuradhapura</option>
							<option>Badulla</option>
							<option>Batticaloa</option>
							<option>Gampaha</option>
							<option>Hambantota</option>
							<option>Jaffna</option>
							<option>Kalutara</option>
							<option>Kegalle</option>
							<option>Kilinochchi</option>
							<option>Kurunegala</option>
							<option>Mannar</option>
							<option>Matale</option>
							<option>Matara</option>
							<option>Moneragala</option>
							<option>Mullativu</option>
							<option>Nuwara Eliya</option>
							<option>Polonnaruwa</option>
							<option>Puttalam</option>
							<option>Trincomalee</option>
							<option>Vavuniya</option>
				</select>
					<input class="form-control" id="action"  name="action" type="hidden" value="search"></input>
					<input class="form-control"  id="searchText" name="searchText" type="text" placeholder="What are you searching for?"></input>
					<!--
					<button class="btn btn-primary" type="submit">Search</button>
					-->
				</form>
			
		
	</nav>



	<!-- Main Container -->
	<div id="topDiv" class="container-fluid">
		<!-- Main Row -->
		<div class="row">
		
			<!-- Margin Left Pannel -->
			<div class="col-lg-2 hidden-md-down">
			</div>
			
			
			<!-- Left Pannel 
			<div class="col-lg-2 hidden-md-down">
				
			</div>
			-->
			
			<!-- Middle Pannel -->
			<div class="col-lg-8">
						
				<div class="row">
					<div id="SearchArea" class="col-lg-12">
						<!-- put main content here -->
					</div>
				</div>
			</div>
			
			<!-- Margin Right Pannel 
			<div class="col-lg-1 hidden-md-down">
			</div>
			-->
			
			<!-- Ad Pannel -->
			<div class="col-lg-2  hidden-md-down">
				
				<div class="card">
					<div class="card-block">
								<div class="card card-block" style="padding: 0px; margin-bottom:10px;">
								  <a href="#" ><img src="../../assets/ads/300-300.jpg" class="img-fluid d-block" alt="Image"></a>
								</div>
								
								<div class="card card-block" style="padding: 0px; margin-bottom:10px;">
								  <a href="#" ><img src="../../assets/ads/300-300.jpg" class="img-fluid d-block" alt="Image"></a>
								</div>
								
								<div class="card card-block" style="padding: 0px; margin-bottom:10px;">
								  <a href="#" ><img src="../../assets/ads/300-300.jpg" class="img-fluid d-block" alt="Image"></a>
								</div>
								
								<div class="card card-block" style="padding: 0px;">
								  <a href="#" ><img src="../../assets/ads/300-300.jpg" class="img-fluid d-block" alt="Image"></a>
								</div>
					</div>
				</div>
			   
			</div>
		
		</div>
	</div>
					
    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="../../js/jquery-3.1.1.slim.min.js"></script>
    <script src="../../js/tether.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>

	<script src="../../js/notify.js"></script>
	
<script>


$(document).ready(function() {	

$("#searchText").keyup(function(){
	var form = document.getElementById('searchForm');
	search($("#searchForm"));
	
	});
	
$('#category1').on('change', function() {
  var form = document.getElementById('searchForm');
	search($("#searchForm"));
})	
$('#category2').on('change', function() {
  var form = document.getElementById('searchForm');
	search($("#searchForm"));
})
$('#district').on('change', function() {
  var form = document.getElementById('searchForm');
	search($("#searchForm"));
})	
	
function search($form){

	var response;
	var request;
	event.preventDefault();

    if (request) {
        request.abort();
    }
	
    var $inputs = $form.find("input, select, button, textarea");
    var serializedData = $form.serialize();
    request = $.ajax({
        url: "Search.php",
        type: "post",
        data: serializedData
    });
	
    request.done(function (response, textStatus, jqXHR){
		$("#SearchArea").hide().fadeIn('fast');	
		$("#SearchArea").html(response);
    });

    request.fail(function (jqXHR, textStatus, errorThrown){
		$("#SearchArea").hide().fadeIn('fast');	
        $("#SearchArea").html('No data');
    });

};




$.ajax({
    type: "POST",
    url: '../controller/GetData.php',
    data: {'action': 'Category1'},
    dataType:'html',
    success: function(data) {
		$("#category1").empty();
		$("#category1").html(data);
    }
});

$('#category1').change(function () {
	
	$.ajax({
    type: "POST",
    url: '../controller/GetData.php',
    data: {'action': 'Category2', 'Category1': $(this).find('option:selected').attr('id')},
    dataType:'html',
    success: function(data) {
		$("#category2").empty();
		$("#category2").html(data);

    }
});
	
});	
	
} );

</script>
</body>
</html>