<?php
//200 - done
//201 - resend
/*
if (!((isset($_GET) && isset($_GET['action']) && $_GET['action'] === 'verify') or (isset($_POST) && isset($_POST['action']) &&$_POST['action'] === 'resend'))){
	header('Location: ../../index.php');
}
*/
require "../Config.php";
require "../ErrorCode.php";
require '../../vendor/autoload.php';

$db = Config::initDb();
$auth = new \Delight\Auth\Auth($db);

if($auth->isLoggedIn()){
	header('Location: ../../index.php');
}

$error_code='';
$status_code = '';

if (isset($_GET)) {
		if (isset($_GET['action']) && isset($_GET['selector']) && isset($_GET['token'])) {
		if ($_GET['action'] === 'verify') {
			try{
				if($_GET['selector'] != '' and $_GET['token'] != ''){
					$selector = htmlspecialchars($_GET['selector']);
					$token = htmlspecialchars($_GET['token']);
					$auth->confirmEmail($selector, $token);
				}
				
				$status_code = '200';
			}
			catch(\Delight\Auth\TokenExpiredException $e){
			$status_code = '201';
			$error_code = '1';	
			}
			catch(\Delight\Auth\InvalidSelectorTokenPairException $e){
				$status_code = '201';
				$error_code = '2';
			}
			catch(\Delight\Auth\TooManyRequestsException $e){
				$status_code = '201';
				$error_code = '3';
			}
			catch(Exeption $e){
				$status_code = '201';
				$error_code = '3';	
			}
			catch(\Delight\Auth\DatabaseError $e){
				$status_code = '201';
				$error_code = '3';
			}
		}
		
		}
		
}


$email='';
if (isset($_POST)) {
		if (isset($_POST['action']) and isset($_POST['resendemail'])) {

		if ($_POST['action'] === 'resend') {
			
			if (isset($_POST['resendemail']) and $_POST['resendemail'] == '') {
				ErrorCode::SetError(ErrorCode::REQUIRED_EMAIL);
				return;
			}
						
			$email = $_POST['resendemail'];
			
			try{
				$userData = $auth->getUserDataByEmailAddress($email, ['verified']);
				
				if($userData['verified'] === null){
					ErrorCode::SetError(ErrorCode::USER_NOT_EXIST.'<a href="../../index.php" class="alert-link"> Click here to Register</a>.');
					return;
				}
				if ($userData['verified'] === 0) {
					$check = $auth->resendConfirmationRequest($email);
					if($check == '500'){
						ErrorCode::SetError(ErrorCode::CODE_500);
						return;
					}
					else if($check === true){
						echo "CINDERELLA_OK";
						return;
					}
				}
				else if ($userData['verified'] === 1) {
					ErrorCode::SetError(ErrorCode::ACCOUNT_ALREADY_ACTIVATED.'<a href="#" data-toggle="modal" data-target="#LogInModal" class="alert-link"> Click here to Sign In</a>.');
					return;
				}
				else{
					ErrorCode::SetError(ErrorCode::ERROR_UNEXPECTED);
					return;
				}
			}
			catch(\Delight\Auth\InvalidEmailException $e){
				ErrorCode::SetError(ErrorCode::USER_NOT_EXIST.'<a href="../../index.php" class="alert-link"> Click here to Register</a>.');
				return;
			}
			catch(Exception $e){
				ErrorCode::SetError(ErrorCode::ERROR_UNEXPECTED);
				return;
			}
			
			
			
			
		}
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
	
  </head>
  <body>
	<nav class="navbar fixed-top navbar-inverse bg-inverse navbar-toggleable-md">
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
				<a href="ForgotPassword.php">Forgot Password ?</a>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button type="submit" class="btn btn-primary">Sign In</button>
				</form>
			  </div>
			</div>
		</div>
	</div>


	<div class="modal fade" id="waitModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" style="color: #1980FC;">Please Wait !</h5>
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				<p>Your request is beign processing... This migh take few seconds</p>
			  </div>
			</div>
		</div>
	</div>


	
		<!-- Main Container -->
	<div class="container-fluid">
	
	<!-- Main Row -->
	<div class="row">
	
	<!-- Left Pannel -->
	<div class="col-lg-2 hidden-md-down">
			
	</div>
	
	<!-- Main Pannel -->
	<div id="topDiv" name="topDiv" class="col-lg-8">
		<div class="card  text-center">
		  <div class="card-header">
			<h4>Account Activation</h4>
		  </div>
		  <div class="card-block">
			<div id="RegisterError" style="padding-bottom: 10px;">
			<?php
			if($status_code === '201'){
				if($error_code === '1'){
					ErrorCode::SetError(ErrorCode::VERIFY_TOKEN_EXPIRED.'<strong> Please enter again your email address to activate your account.</strong>');
				}
				if($error_code === '2'){
					ErrorCode::SetError(ErrorCode::VERIFY_INVALID.'<strong> Please enter again your email address to activate your account.</strong>');
				}
				if($error_code === '3'){
					ErrorCode::SetError(ErrorCode::CODE_502);
				}
			}
			?>
			</div>
					
			<?php
			if($status_code === '200'){
			?>
				<h4 style="color: #1980FC;">Congratulations !</h4>	 
				<p> Your acount is now activated</p>
				<a class="btn btn-primary-unicorn" data-toggle="modal" data-target="#LogInModal" role="button">Sign in</a>
			<?php
			}
			if($status_code === '201' and $error_code !== '3'){
			?>	 
				<form id="resendForm" accept-charset="utf-8">
				<div class="form-group">
					<label class="form-control-label float-left">E-Mail</label>
					<input class="form-control" name="resendemail" placeholder="youremail@example.com" type="email" aria-describedby="emailHelp" />
					<div id="resendemail_validate" class="form-control-feedback"></div>
					
					
				</div>
				<input type="hidden" name="action" value="resend"/>
				<div class="form-group  float-right">
					<a href="../../index.php" class="btn btn-secondary " role="button" aria-disabled="true">Cancel</a>
					<button type="submit" class="btn btn-primary">Resend</button>	
				</div>
				</form>
			<?php
			}
			?>
		</div>
		<div class="card-footer text-muted text-center">
			2017 © Cinderella
		</div>
	 </div>
	</div>
		 
	<!-- Right Pannel -->
	
	 <div class="col-lg-2 hidden-md-down">
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

$('#LogInModal').on('hidden.bs.modal', function (e) {
  $("#loginModalError").html('');
})

 $('#login').validate({ // initialize the plugin
        rules: {
            loginUsername: {
                required: true,
                email: true,
				remote: {
					url: "../controller/Validate.php",
					type: "post",
					data: {
						  action: function() {
							return $( "#action" ).val();
						  }
						}
				}
            },	
			loginPassword: {
                required: true				
            }		
        },
		 messages: {
                loginUsername: {
                    required: "Please Enter Email!",
                    email: "This is not a valid email!",
                    remote: "Email does not exists or This is not a valid email address"
                },
				 loginPassword: {
                    required: "Please Enter Password!"
                }
            },
			errorPlacement: function(error, element) {
				var name = $(element).attr("name");
				error.appendTo($("#" + name + "_validate"));
			},
		highlight: function(element) {
			jQuery(element).closest('.form-group').addClass('has-danger').removeClass('has-success');
			jQuery(element).closest('.form-control').addClass('form-control-danger').removeClass('form-control-success');
    },	
	success: function(element) {
		jQuery(element).closest('.form-group').addClass('has-success').removeClass('has-danger');
			jQuery(element).closest('.form-control').addClass('form-control-success').removeClass('form-control-danger');
    },
	onkeyup: function(element) {$(element).valid()},
	unhighlight: function(element) {
		jQuery(element).closest('.form-group').addClass('has-success').removeClass('has-danger');
			jQuery(element).closest('.form-control').addClass('form-control-success').removeClass('form-control-danger');
    },
	
    });

 
	 // Variable to hold request
var request;

$("#login").submit(function(event){

	if (!$(this).valid()) {  
        return false;
    }
			
    // Prevent default posting of form - put here to work in case of errors
    event.preventDefault();

    // Abort any pending request
    if (request) {
        request.abort();
    }
    // setup some local variables
    var $form = $(this)	;

    // Let's select and cache all the fields
    var $inputs = $form.find("input, select, button, textarea");

    // Serialize the data in the form
    var serializedData = $form.serialize();

    // Let's disable the inputs for the duration of the Ajax request.
    // Note: we disable elements AFTER the form data has been serialized.
    // Disabled form elements will not be serialized.
    $inputs.prop("disabled", true);

    // Fire off the request to /form.php
    request = $.ajax({
        url: "../controller/Login.php",
        type: "post",
        data: serializedData
    });

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        console.log("Logged in "+ response);
		
		if(response.indexOf('CINDERELLA_OK') > -1)
		{
			window.location = "../../index.php";
		}
		else{
			$('#loginModal').modal('show');
			$("#loginModalError").html(response);
		}
		
		
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
		$('#loginModal').modal('show');
		$("#loginModalError").html(errorThrown);
    });

    // Callback handler that will be called regardless
    // if the request failed or succeeded
    request.always(function () {
        // Reenable the inputs
        $inputs.prop("disabled", false);
    });

});



  $('#resendForm').validate({ // initialize the plugin
  
        rules: {
            resendemail: {
                required: true,
                email: true,
				remote: {
					url: "../controller/Validate.php",
					type: "post",
					data: {
						  action: function() {
							return $( "#action" ).val();
						  }
						}
				}				
            }		
        },
		 messages: {
                resendemail: {
                    required: "Please Enter Email!",
                    email: "This is not a valid email!",
                    remote: "Email does not exist. Probably you are not registered as a user."
                }
            },
			errorPlacement: function(error, element) {
				var name = $(element).attr("name");
				error.appendTo($("#" + name + "_validate"));
			},
		highlight: function(element) {
			jQuery(element).closest('.form-group').addClass('has-danger').removeClass('has-success');
			jQuery(element).closest('.form-control').addClass('form-control-danger').removeClass('form-control-success');
    },	
	success: function(element) {
		jQuery(element).closest('.form-group').addClass('has-success').removeClass('has-danger');
			jQuery(element).closest('.form-control').addClass('form-control-success').removeClass('form-control-danger');
    },
	onkeyup: function(element) {$(element).valid()},
	unhighlight: function(element) {
		jQuery(element).closest('.form-group').addClass('has-success').removeClass('has-danger');
			jQuery(element).closest('.form-control').addClass('form-control-success').removeClass('form-control-danger');
    },
	
    });


	
	
$("#resendForm").submit(function(event){
	$("#RegisterError").html('');
	if (!$(this).valid()) { 
                return false;
            }
	
    // Prevent default posting of form - put here to work in case of errors
    event.preventDefault();

    // Abort any pending request
    if (request) {
        request.abort();
    }
    // setup some local variables
    var $form = $(this);

    // Let's select and cache all the fields
    var $inputs = $form.find("input, select, button, textarea");

    // Serialize the data in the form
    var serializedData = $form.serialize();

    // Let's disable the inputs for the duration of the Ajax request.
    // Note: we disable elements AFTER the form data has been serialized.
    // Disabled form elements will not be serialized.
    $inputs.prop("disabled", true);

    // Fire off the request to /form.php
    request = $.ajax({
        url: "VerifyAccount.php",
        type: "post",
        data: serializedData
    });

	$('#waitModal').modal('show');
	
    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        console.log("Logged in "+ response);
		$('#waitModal').modal('hide');
		if(response.indexOf('CINDERELLA_OK') > -1)
		{
			//location.reload();
			$("#RegisterError").html('<div class="alert alert-success" role="alert" >Verification mail has been sent to your email</div>');
		}
		else{
			$("#RegisterError").html(response);
		}
		
		
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
		$('#waitModal').modal('hide');
		$("#RegisterError").html(errorThrown);
    });

    // Callback handler that will be called regardless
    // if the request failed or succeeded
    request.always(function () {
        // Reenable the inputs
		$('#waitModal').modal('hide');
        $inputs.prop("disabled", false);
    });

});


});


  </script>
  </body>
</html>