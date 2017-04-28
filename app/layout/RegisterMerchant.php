<?php
require "../Config.php";
require "../ErrorCode.php";
require '../../vendor/autoload.php';

$db = Config::initDb();
$auth = new \Delight\Auth\Auth($db);
$isLoggedIn = $auth->isLoggedIn();
if($isLoggedIn){
	header('Location: ../../index.php');
}

if (isset($_POST)) {
	if(isset($_POST['g-recaptcha-response'])){
			$recaptcha = new \ReCaptcha\ReCaptcha(Config::$recaptcha);
			 $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
			if ($resp->isSuccess()){
				
			
				if (isset($_POST['action'])) {
							
					if ($_POST['action'] === 'register') {

						if (isset($_POST['email']) and $_POST['email'] == '') {
							ErrorCode::SetError(ErrorCode::REQUIRED_EMAIL);
							return;
						}
						if (isset($_POST['password']) and $_POST['password'] == '') {
							ErrorCode::SetError(ErrorCode::REQUIRED_PASSWORD);
							return;
						}
						if (isset($_POST['repassword']) and $_POST['repassword'] == '') {
							ErrorCode::SetError(ErrorCode::REQUIRED_RE_PASSWORD);
							return;
						}
						if($_POST['password'] !== $_POST['repassword']){
							ErrorCode::SetError(ErrorCode::REQUIRED_PASSWORD_MISMATCH);
							return;
						}
						if (isset($_POST['contactPerson']) and $_POST['contactPerson'] == '') {
							ErrorCode::SetError(ErrorCode::REQUIRED_CONTACT_PERSON);
							return;
						}
						if (isset($_POST['businessName']) and $_POST['businessName'] == '') {
							ErrorCode::SetError(ErrorCode::REQUIRED_BUSINESS_NAME);
							return;
						}
						if (isset($_POST['district']) and $_POST['district'] == '') {
							ErrorCode::SetError(ErrorCode::REQUIRED_DISTRICT);
							return;
						}
						
						if (isset($_POST['mobile']) and $_POST['mobile'] == '') {
							ErrorCode::SetError(ErrorCode::REQUIRED_MOBILE);
							return;
						}
						if (isset($_POST['address1']) and $_POST['address1'] == '') {
							ErrorCode::SetError(ErrorCode::REQUIRED_MERCHANT_ADDRESS);
							return;
						}
						if (isset($_POST['address2']) and $_POST['address2'] == '') {
							ErrorCode::SetError(ErrorCode::REQUIRED_MERCHANT_ADDRESS);
							return;
						}
						if (isset($_POST['address3']) and $_POST['address3'] == '') {
							ErrorCode::SetError(ErrorCode::REQUIRED_MERCHANT_ADDRESS);
							return;
						}
						if (isset($_POST['category1']) and $_POST['category1'] == '') {
							ErrorCode::SetError(ErrorCode::REQUIRED_CATEGORY);
							return;
						}
						if (isset($_POST['category2']) and $_POST['category2'] == '') {
							ErrorCode::SetError(ErrorCode::REQUIRED_CATEGORY);
							return;
						}
					}
					
					try{
						$other['contact_person'] = $_POST['contactPerson'];
						$other['business_name'] = $_POST['businessName'];
						$other['district'] = $_POST['district'];
						$other['business_mobile'] = $_POST['mobile'];
						$other['category1'] = $_POST['category1'];
						$other['category2'] = $_POST['category2'];
						if (isset($_POST['phone']) and $_POST['phone'] !== '') {
							$other['business_phone'] = $_POST['phone'];
						}
						if (isset($_POST['description']) and $_POST['description'] !== '') {
							$other['description'] = $_POST['description'];
						}
						
						if (isset($_POST['address1']) and $_POST['address1'] !== '') {
							$other['address1'] = $_POST['address1'];
						}
						
						if (isset($_POST['address2']) and $_POST['address2'] !== '') {
							$other['address2'] = $_POST['address2'];
						}
						if (isset($_POST['address3']) and $_POST['address3'] !== '') {
							$other['address3'] = $_POST['address3'];
						}
						
						$check = $auth->registerWithUniqueUsername($_POST['email'], $_POST['password'], $_POST['email'], '3', $other);
						if($check == '500'){
							ErrorCode::SetError(ErrorCode::CODE_500);
							return ;
						}
						if($check == '501'){
							ErrorCode::SetError(ErrorCode::CODE_501);
							return ;
						}
						
					}
					catch (\Delight\Auth\UserAlreadyExistsException $e) {
						ErrorCode::SetError(ErrorCode::USER_EXIST);
						return;
					}
					catch (\Delight\Auth\DuplicateUsernameException $e) {
						ErrorCode::SetError(ErrorCode::USER_EXIST);
						return;
					}
					catch (Exception $e) {
						ErrorCode::SetError(ErrorCode::ERROR_GENERAL.$e);
						return;
					}
				}				
			}
			else{				
				ErrorCode::SetError(ErrorCode::REQUIRED_RECAPTCHA);
				return;
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
		<!-- Form Pannel -->
	<div id="topDiv" name="topDiv" class="col-lg-6">
		<div class="card ">
			<div class="card-header text-center">
				<h4 style="color: #1980FC;">Register as a Merchant</h4>
			</div>
			<div class="card-block">
				<div class="row">
					<div class="col-lg-12 float-xs-left">
					
					<div id="RegisterError" style="padding-bottom: 10px;"></div>
				
					<form id="registerAsMember" accept-charset="utf-8">
						<div class="form-group">
							<label class="form-control-label float-left" >E-Mail/Username</label>
							<input id="email" class="form-control" name="email" placeholder="youremail@example.com" type="email" />
							<div id="email_validate" class="form-control-feedback"></div>
						</div>
						
						<div class="form-group">
							<label class="form-control-label float-xs-left required">Password</label>
							<input class="form-control" name="password" id="password" type="password" />
							<div id="password_validate" class="form-control-feedback"></div>
						</div>
						
						<div class="form-group">
							<label class="form-control-label float-xs-left">Re-Enter Password</label>
							<input class="form-control" name="repassword" id="repassword"  type="password" />
							<div id="repassword_validate" class="form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label class="form-control-label float-xs-left">Business Name</label>
						<input class="form-control" name="businessName" type="text"/>
						<small class="form-text text-muted float-right">Ex: ABC Studio</small>
						<div id="businessName_validate" class="form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label class="form-control-label float-left">Main Category</label>
						<select class="form-control" id="category1" name="category1">
						</select>
						<div id="category1_validate" class="form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label class="form-control-label float-left">Sub Category</label>
						<select class="form-control" id="category2" name="category2">
						</select>
						<div id="category2_validate" class="form-control-feedback"></div>
						</div>
			
						<div class="form-group">
						<label class="form-control-label float-xs-left">Contact Person</label>
						<input class="form-control" name="contactPerson" type="text"/>
						<div id="contactPerson_validate" class="form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label class="form-control-label float-xs-left">Business Mobile</label>
						<input class="form-control" name="mobile" type="tel"/>
						<small class="form-text text-muted float-right">Ex: 0712345678</small>
						<div id="mobile_validate" class="form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label class="form-control-label float-xs-left">Business Phone</label>
						<input class="form-control" name="phone" type="tel"/>
						<small class="form-text text-muted float-right">Ex: 0112345678</small>
						<div id="phone_validate" class="form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label class="form-control-label float-xs-left">Address1</label>
						<input class="form-control" name="address1" type="text"/>
						<div id="address1_validate" class="form-control-feedback"></div>
						<small class="form-text text-muted float-right">Ex: No: 49/6/A</small>
						</div>
						
						<div class="form-group">
						<label class="form-control-label float-xs-left">Address2</label>
						<input class="form-control" name="address2" type="text"/>
						<div id="address2_validate" class="form-control-feedback"></div>
						<small class="form-text text-muted float-right">Ex: Temple Road</small>
						</div>
						
						<div class="form-group">
						<label class="form-control-label float-xs-left">City</label>
						<input class="form-control" name="address3" type="text"/>
						<div id="address3_validate" class="form-control-feedback"></div>
						<small class="form-text text-muted float-right">Ex: Maharagama</small>
						</div>
						
						<div class="form-group">
						<label class="form-control-label float-xs-left">District</label>
						<select class="form-control" name="district">
						<option></option>
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
						<div id="district_validate" class="form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label class="form-control-label float-left">Description</label>
						<textarea class="form-control" rows="10" name="description" > </textarea>
						<small class="form-text text-muted float-right">Small description about your business</small>
						<div id="description_validate" class="form-control-feedback"></div>
						</div>
						</br>
						<div align="center" class="form-group">
							<div class="g-recaptcha" data-sitekey="6LfSRhUUAAAAAC9_QF8XXJb2pekVh9Kphs4fk0JO" style="transform:scale(0.77);-webkit-transform:scale(0.77);transform-origin:0 0;-webkit-transform-origin:0 0;"></div><br/><br/>
							
						</div>
						
						
						<input type="hidden" name="action" value="register"/>
						<p class="text-muted text-center">
							By clicking Register, I agree to the Terms and Conditions of Cinderella
						</p>
						<div class="text-center">
							<a href="../../index.php" class="btn btn-secondary " role="button" aria-disabled="true">Cancel</a>
							<button type="submit" class="btn btn-primary">Register</button>
						</div>
					</form>
					
					</div>
				</div>
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
	<script src='https://www.google.com/recaptcha/api.js'></script>
	
	<script src="../../js/jquery.validate.min.js"></script>
	<script src="../../js/additional-methods.min.js"></script>
	
	<script src="../../js/cinderella.js"></script>
	
 <script>

$(document).ready(function() {	
loginModalValidate('loginGeneral');
loginModalSubmit('loginGeneral', 'loginModalGeneralError');
loginModalOnClose('LogInModalGeneral', 'loginGeneral', 'loginModalGeneralError');
signOut('signOut');

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


$('#registerAsMember').validate({ // initialize the plugin
        rules: {
            email: {
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
            password: {
                required: true,
                minlength: 6
            },
			repassword: {
				required: true,
		  equalTo: "#password"
		  },
		  contactPerson: {
                required: true
            },
			businessName: {
                required: true
            },
			mobile: {
                required: true,
				digits: true,
				minlength: 10,
				maxlength: 10
            },
			phone: {
				digits: true,
				minlength: 10,
				maxlength: 10
            },
			address1: {
                required: true
            },
			address2: {
                required: true
            },
			category1: {
                required: true
            },
			category2: {
                required: true
            },
			address3: {
                required: true
            },
			district: {
                required: true
            }
		
        },
		 messages: {
                email: {
                    required: "Please Enter Email!",
                    email: "This is not a valid email!",
                    remote: "Email already exists or This is not a valid email address"
                },
				mobile:{
					minlength: "Enter valid phone number",
					maxlength: "Enter valid phone number"
				},
				phone:{
					minlength: "Enter valid phone number",
					maxlength: "Enter valid phone number"
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



// Bind to the submit event of our form
$("#registerAsMember").submit(function(event){

if (!$(this).valid()) {  //<<< I was missing this check
grecaptcha.reset();
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
        url: "RegisterMerchant.php",
        type: "post",
        data: serializedData
    });
	
    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        console.log("Logged in "+ response);
		$('#waitModal').modal('hide');
		if(response.indexOf('UNICORN_OK') > -1)
		{
			window.location = "RegisterDone.php";
		}
		else{
			$("html,body").animate({scrollTop:$('div#topDiv').offset().top}, 500);
			$("#RegisterError").html(response);
			grecaptcha.reset();
			
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
		$("html,body").animate({scrollTop:$('div#topDiv').offset().top}, 500);
		$("#RegisterError").html(errorThrown);
		grecaptcha.reset()
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