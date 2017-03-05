<?php
require "../Config.php";
require "../ErrorCode.php";
require '../../vendor/autoload.php';

$db = Config::initDb();
$auth = new \Delight\Auth\Auth($db);
$selector="";
$token="";
$getRequest;
if (isset($_GET)) {
		if (isset($_GET['action']) && isset($_GET['selector']) && isset($_GET['token'])) {
		if ($_GET['action'] === 'reset') {
			$getRequest = true;
			$selector = htmlspecialchars($_GET['selector']);
			$token = htmlspecialchars($_GET['token']);
		}	
		}
}
if (isset($_POST)) {
		if (isset($_POST['action'])) {
		if ($_POST['action'] === 'resetPwd') {
			if($_POST['newPassword'] !== $_POST['renewPassword']){
				ErrorCode::SetError(ErrorCode::REQUIRED_PASSWORD_MISMATCH);
				return;				
			}
			if($_POST['token'] === '' or  $_POST['selector'] === ''){
				ErrorCode::SetError(ErrorCode::ERROR_GENERAL);
				return;				
			}
			
			try {
					if($auth->resetPassword($_POST['selector'], $_POST['token'], $_POST['newPassword']) == '200'){
						echo 'CINDERELLA_OK';
						return;
					}
					
				}
				catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
					ErrorCode::SetError(ErrorCode::VERIFY_INVALID);
					return;
				}
				catch (\Delight\Auth\TokenExpiredException $e) {
					ErrorCode::SetError(ErrorCode::ERROR_GENERAL);
					return;	
				}
				catch (\Delight\Auth\TooManyRequestsException $e) {
					ErrorCode::SetError(ErrorCode::ERROR_GENERAL);
					return;
				}
				catch (\Delight\Auth\InvalidPasswordException $e) {
					ErrorCode::SetError(ErrorCode::REQUIRED_PASSWORD);
					return;
				}
				catch (Exception $e) {
					ErrorCode::SetError(ErrorCode::ERROR_GENERAL);
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

	<div class="modal fade" id="waitModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" style="color: #1980FC;">Please Wait !</h5>				
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				<p>Your request is beign processing... This migh take few seconds</p>
			  </div>
			</div>
		</div>
	</div>
	
	
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
			<h4>Forgot Password ?</h4>
		  </div>
		  <div class="card-block">
		  <div id="Error"></div>
		  <p style="color: #1980FC;"> Enter new password to reset your account password</p>
				 <form id="resetPassword">
				 <div class="form-group">
					<label class="form-control-label float-left">Password</label><br/>
					<input class="form-control" type="password"  id="newPassword" name="newPassword" placeholder="Password"/>
					<div id="newPassword_validate" class="form-control-feedback"></div>
				</div>
				
				<div class="form-group">
					<label class="form-control-label float-left">Re-enter Password</label><br/>
					<input class="form-control" type="password"  id="renewPassword" name="renewPassword" placeholder="Re enter your Password"/>
					<div id="renewPassword_validate" class="form-control-feedback"></div>
				</div>
				<input type="hidden" name="selector" value="<?php echo $selector; ?>"/>
				<input type="hidden"  name="token" value="<?php echo $token; ?>"/>
				
				<input type="hidden" name="action" value="resetPwd"/>
				<div class="float-right">
				<a href="../../index.php" class="btn btn-secondary " role="button" aria-disabled="true">Cancel</a>
				<button type="submit" class="btn btn-primary">Reset Password</button>
				</div>
				</form>
		</div>
		<div class="card-footer text-muted text-xs-center">
			2017 © Cinderella
		</div>
	 </div>
	 
	<!-- Right Pannel -->
	
	 <div class="col-lg-2 hidden-md-down">
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
 
  $('#resetPassword').validate({ // initialize the plugin
        rules: {
            newPassword: {
                required: true,
				minlength: 6				
            },
			renewPassword: {
                required: true,
				equalTo: "#newPassword"				
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


	
	var request;

// Bind to the submit event of our form
$("#resetPassword").submit(function(event){
	
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
        url: "ResetPassword.php",
        type: "post",
        data: serializedData
    });

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
		
		if(response.indexOf('CINDERELLA_OK') > -1)
		{
			$("#Error").html('<div class="alert alert-success" role="alert" >Password reset successfully. <a href="#" data-toggle="modal" data-target="#LogInModal" class="alert-link"> <strong>Click here to Sign In</strong></a></div>');
			$inputs.prop("disabled", true);
		}
		else{
			$("#Error").html(response);
		}
		
		
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
		$("#Error").html(errorThrown);
    });

    // Callback handler that will be called regardless
    // if the request failed or succeeded
    request.always(function () {
        // Reenable the inputs
        $inputs.prop("disabled", false);
    });

});

});
	
	</script>
  </body>
</html>