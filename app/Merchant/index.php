<?php
require "../Config.php";
require "../ErrorCode.php";
require '../../vendor/autoload.php';

$db = Config::initDb();
$auth = new \Delight\Auth\Auth($db);
$isLoggedIn = $auth->isLoggedIn();
if(!$isLoggedIn){
	//header('Location: ../../index.php');
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
		
		<?php
			if($isLoggedIn === false){				
		?>
			<ul class="nav navbar-nav">
			  <li class="nav-item">
				<a class="nav-link" href="#" data-toggle="modal" data-target="#LogInModal"><u>Sign In</u></a>
			  </li>
			</ul>
		<?php
			}
			else{
		?>
		<div class="active-links">
            <div id="session">
			<ul class="nav navbar-nav">
			<li class="nav-item dropdown">
            <a id="signin-link" class="nav-link dropdown-toggle" href="#">
			<div class="hidden-sm-down">Hi, <u><?php  echo $auth->getEmail(); ?> </u></div>
			<div class="hidden-md-up"><u>Hi,</u></div>
            </a>
			</li>
			</ul>
            </div>
            	<div class="nav navbar-nav float-xs-right" id="signin-dropdown">
				<a class="btn btn-secondary btn-sm btn-block"  return false;" style="margin-top: 5px;" href="app/user/userProfile.php" role="button">My Profile</a>
				<a class="btn btn-secondary btn-sm btn-block" onclick="logout(); return false;" style="margin-top: 5px;" href="#" role="button">Sign Out</a>
         	</div>
        </div>
		<?php
			}
		?>
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

	
	<div class="modal fade" id="LogInModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Sign In</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				<div id="loginModalError" style="padding-bottom: 10px;">
				</div>
				<form id="login"  accept-charset="utf-8">
				
				<div class="form-group">
					<label class="form-control-label" >Username</label>
					<input class="form-control" id="loginUsername" name="loginUsername"  placeholder="youremail@example.com" type="email" aria-describedby="emailHelp" />
					<div id="loginUsername_validate" class="form-control-feedback"></div>
				</div>
				
				<div class="form-group">
					<label class="form-control-label" >Password</label>
					<input class="form-control" type="password"  id="loginPassword" name="loginPassword" placeholder="Password"/>
					<div id="loginPassword_validate" class="form-control-feedback"></div>
				</div>
				
				<input type="hidden" name="action" value="login"/>
				
				<div class="form-check">
					<label class="form-check-label">
					<input id="loginRememberme" name="loginRememberme" class="form-check-input" type="checkbox" value="1">
					Remember me
					</label>
				</div>
				
			  </div>
			  <div class="modal-footer">
				<a href="app/layout/ForgotPassword.php">Forgot Password ?</a>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button type="submit" class="btn btn-primary">Sign In</button>
				</form>
			  </div>
			</div>
		</div>
	</div>


	<!-- Main Container -->
	<div id="topDiv" class="container-fluid">
		<!-- Main Row -->
		<div class="row">
		
			<!-- Margin Left Pannel -->
			<div class="col-lg-1 hidden-md-down">
			</div>
			
			
			<!-- Left Pannel -->
			<div class="col-lg-2 hidden-md-down">
				<?php
					include('MerchantMenu.php');
				?>
			</div>
			
			<!-- Middle Pannel -->
			<div class="col-lg-8">
				<div class="row">
					<div id="mainContent" class="col-lg-12">
						<!-- put main content here -->
						<div> Welcome to your page</div>
					
					</div>
				</div>
			</div>
			
			<!-- Margin Right Pannel -->
			<div class="col-lg-1 hidden-md-down">
			</div>
		
		</div>
	</div>
					
    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="../../js/jquery-3.1.1.slim.min.js"></script>
    <script src="../../js/tether.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
	
	<script src="../../js/jquery.validate.min.js"></script>
	<script src="../../js/additional-methods.min.js"></script>

	
<script>
$(document).ready(function() {	
var request;

$('#Profile').click( function(e) {
		
		e.preventDefault(); 
	 // Abort any pending request
    if (request) {
        request.abort();
    }
	request = $.ajax({
        url: "Profile.php",
        type: "get"
    });
	
    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        console.log("Logged in "+ response);
		$("html,body").animate({scrollTop:$('div#topDiv').offset().top}, 500);
		$("#mainContent").html(response);
		
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
		$("html,body").animate({scrollTop:$('div#topDiv').offset().top}, 500);
		$("#mainContent").html(errorThrown);
    });

    // Callback handler that will be called regardless
    // if the request failed or succeeded
    request.always(function () {
        // Reenable the inputs
        //$inputs.prop("disabled", false);
    });

	} );

$('#Business').click( function(e) {
		
		e.preventDefault(); 
	 // Abort any pending request
    if (request) {
        request.abort();
    }
	request = $.ajax({
        url: "Business.php",
        type: "get"
    });
	
    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        console.log("Logged in "+ response);
		$("html,body").animate({scrollTop:$('div#topDiv').offset().top}, 500);
		$("#mainContent").html(response);
		
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
		$("html,body").animate({scrollTop:$('div#topDiv').offset().top}, 500);
		$("#mainContent").html(errorThrown);
    });

    // Callback handler that will be called regardless
    // if the request failed or succeeded
    request.always(function () {
        // Reenable the inputs
        //$inputs.prop("disabled", false);
    });

	} );
	

function editonclick(){
	alert("OK");
	e.preventDefault(); 
	
	var attr;
	var TextVale;
	var OldVale;
	
	$('#EditSection').find('a').each(function(){
			
			$(this).each(function() {
				attr = "";
				  $.each(this.attributes, function() {
					// this.attributes is not a plain object, but an array
					// of attribute nodes, which contain both the name and value
					if(this.specified) {
						OldVale = this.value;
						if(this.name == "value" & OldVale == "Edit"){
							this.value= "CancelEdit"
							TextVale = "Cancel Edit";
						}
						
						if(this.name == "value" & OldVale == "CancelEdit"){
							this.value= "Edit"
							TextVale = "Edit";
						}
						attr = attr + ' ' + this.name + ' = "' + this.value + '"';			
					}
				  });
				}); 
				$(this).replaceWith($('<a '+ attr +' >' + TextVale + '</a>'));
		});
		
		if(OldVale == "Edit"){
			$('#mainarea').find('p').each(function(){
			
			$(this).each(function() {
				attr = "";
				  $.each(this.attributes, function() {
					// this.attributes is not a plain object, but an array
					// of attribute nodes, which contain both the name and value
					if(this.specified) {
						
						if(this.name == "class" & this.value == "form-control-static"){
							this.value= "form-control"
						}
						attr = attr + ' ' + this.name + ' = "' + this.value + '"';			
					}
				  });
				}); 
				$(this).replaceWith($('<input '+ attr +' >' + $(this).val() + '</input>'));
		});
		}
		else if(OldVale == "CancelEdit"){
			$('#mainarea').find(':input').each(function(){
			
			$(this).each(function() {
				attr = "";
				  $.each(this.attributes, function() {
					// this.attributes is not a plain object, but an array
					// of attribute nodes, which contain both the name and value
					if(this.specified) {
						
						if(this.name == "class" & this.value == "form-control"){
							this.value= "form-control-static"
						}
						attr = attr + ' ' + this.name + ' = "' + this.value + '"';			
					}
				  });
				}); 
				$(this).replaceWith($('<p '+ attr +' >' + $(this).val() + '</p>'));
		});
		}

	$("#mainarea").hide().fadeIn('fast');	
		
	}
	
	
	
} );

</script>
</body>
</html>