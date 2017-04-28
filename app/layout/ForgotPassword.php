<?php
require "../Config.php";
require "../ErrorCode.php";
require '../../vendor/autoload.php';

$db = Config::initDb();
$auth = new \Delight\Auth\Auth($db);
$isLoggedIn = $auth->isLoggedIn();
if (isset($_POST)) {
		if (isset($_POST['action'])) {
		if ($_POST['action'] === 'forgotPassword') {
			$email = $_POST['forgotPwdEmail'];
			
			try {
					$check = $auth->forgotPassword($email);

					if($check == '200'){
						echo 'CINDERELLA_OK';
						return;
					}
					else if($check == '500'){
						ErrorCode::SetError(ErrorCode::CODE_500);
						return;
					}
					else if($check == '501'){
						ErrorCode::SetError(ErrorCode::CODE_501);
						return;
					}
					
				}
				catch (\Delight\Auth\InvalidEmailException $e) {
					ErrorCode::SetError(ErrorCode::USER_NOT_EXIST);
					return;
				}
				catch (\Delight\Auth\EmailNotVerifiedException $e) {
					ErrorCode::SetError(ErrorCode::ACCOUNT_NOT_ACTIVATED);
					return;
				}
				catch (\Delight\Auth\TooManyRequestsException $e) {
					ErrorCode::SetError(ErrorCode::ERROR_GENERAL);
					return;
				}
				catch (\Exception $e) {
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
	<?php include('NavBar.php'); ?>
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
		  <p style="color: #1980FC;"> Enter your email address to reset your account password.</p>
				<form id="fgtPassword">
				 <div class="form-group">
					<label class="form-control-label float-left" >Email</label><br/>
					<input class="form-control" id="forgotPwdEmail" name="forgotPwdEmail"  placeholder="youremail@example.com" type="email" aria-describedby="emailHelp" />
					<div id="forgotPwdEmail_validate" class="form-control-feedback"></div>
				</div>
				<input type="hidden" name="action" value="forgotPassword"/>
				<div class="float-right">
				<a href="../../index.php" style="margin-right:5px;" class="btn btn-secondary " role="button" aria-disabled="true">Cancel</a>
				<button type="submit" class="btn btn-primary float-right">Reset Password</button>
				</div>
				</form>
			
		  
		  
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
		<?php
	include('Footer.php');	
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

  $('#fgtPassword').validate({ // initialize the plugin
        rules: {
            forgotPwdEmail: {
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
                forgotPwdEmail: {
                    required: "Please Enter Email!",
                    email: "This is not a valid email!",
                    remote: "Email does not exists or This is not a valid email address"
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
	
	var request;

// Bind to the submit event of our form
$("#fgtPassword").submit(function(event){
	
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
	$('#waitModal').modal('show');
    // Fire off the request to /form.php
    request = $.ajax({
        url: "ForgotPassword.php",
        type: "post",
        data: serializedData
    });

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
		$('#waitModal').modal('hide');
		
		if(response.indexOf('CINDERELLA_OK') > -1)
		{
			$("#Error").html('<div class="alert alert-success" role="alert" >Verification mail has been sent to yor email</div>');
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
		$('#waitModal').modal('hide');
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