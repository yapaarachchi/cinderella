<?php
require '../../vendor/autoload.php';

if (isset($_POST)) {
	
	
	
	if(isset($_POST['g-recaptcha-response'])){
			$recaptcha = new \ReCaptcha\ReCaptcha('6LfSRhUUAAAAAFEdLWxrneyWgpLgtg8JaP6d74r0');
			 $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
			if ($resp->isSuccess()){
				
			
				if (isset($_POST['action'])) {

							
					if ($_POST['action'] === 'register') {

						if (isset($_POST['email']) and $_POST['email'] == '') {
							echo '<div class="alert alert-danger" role="alert" >Email is required</div>';
							return;
						}
						if (isset($_POST['password']) and $_POST['password'] == '') {
							echo '<div class="alert alert-danger" role="alert">Password is required</div>';
							return;
						}
						if (isset($_POST['repassword']) and $_POST['repassword'] == '') {
							echo '<div class="alert alert-danger" role="alert" >Re-Enter Password is required</div>';
							return;
						}
						if($_POST['password'] !== $_POST['repassword']){
							echo '<div class="alert alert-danger" role="alert" >Passwords mismatch with each other</div>';
							return;
						}
						if (isset($_POST['fname']) and $_POST['fname'] == '') {
							echo '<div class="alert alert-danger" role="alert" >First Name is required</div>';
							return;
						}
						if (isset($_POST['lname']) and $_POST['lname'] == '') {
							echo '<div class="alert alert-danger" role="alert" >Last Name is required</div>';
							return;
						}
						if (isset($_POST['radio']) and $_POST['radio'] == '') {
							echo '<div class="alert alert-danger" role="alert" >Are you Grrom or Bride ?</div>';
							return;
						}
						if (isset($_POST['district']) and $_POST['district'] == '') {
							echo '<div class="alert alert-danger" role="alert" >Distict is required</div>';
							return;
						}
						
						if (isset($_POST['mobile']) and $_POST['mobile'] == '') {
							echo '<div class="alert alert-danger" role="alert" >Mobile Number is required</div>';
							return;
						}
					}
					
					
					
					
					
				}
				
				
			}
			else{
				
				echo '<div class="alert alert-danger" role="alert" >Are you Human ?</div>';
				return;
			}
			echo 'UNICORN_OK';
				return;
			
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

	
	<div class="modal fade" id="waitModal" role="dialog" data-animation="false">
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
				<h4 style="color: #1980FC;">Register as a Member</h4>
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
						<label class="form-control-label float-xs-left">First Name</label>
						<input class="form-control" name="fname" type="text"/>
						<div id="fname_validate" class="form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label class="form-control-label float-xs-left">Last Name</label>
						<input class="form-control" name="lname" type="text"/>
						<div id="lname_validate" class="form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label class="form-control-label float-xs-left">I'm</label><br/>
						<label class="custom-control custom-radio">
						  <input id="radio1" name="radio" value="Groom" type="radio" class="custom-control-input">
						  <span class="custom-control-indicator"></span>
						  <span class="custom-control-description">Groom</span>
						</label>
						<label class="custom-control custom-radio">
						  <input id="radio" value="Bride" name="radio" type="radio" class="custom-control-input">
						  <span class="custom-control-indicator"></span>
						  <span class="custom-control-description">Bride</span>
						</label>
						<div id="radio_validate" class="form-control-feedback"></div>
						</div>
						
						
						<div class="form-group">
						<label class="form-control-label float-xs-left">Mobile</label>
						<input class="form-control" name="mobile" type="tel"/>
						<small class="form-text text-muted float-xs-right">Ex: 0712345678</small>
						<div id="mobile_validate" class="form-control-feedback"></div>
						</div>
						<!-- 
						<div class="form-group">
						<label class="form-control-label float-xs-left">Address1</label>
						<input class="form-control" name="address1" type="text"/>
						<div id="address1_validate" class="form-control-feedback"></div>
						<small class="form-text text-muted float-xs-right">Ex: No: 49/6/A</small>
						</div>
						
						<div class="form-group">
						<label class="form-control-label float-xs-left">Address2</label>
						<input class="form-control" name="address2" type="text"/>
						<div id="address2_validate" class="form-control-feedback"></div>
						<small class="form-text text-muted float-xs-right">Ex: Temple Road</small>
						</div>
						
						<div class="form-group">
						<label class="form-control-label float-xs-left">City</label>
						<input class="form-control" name="address3" type="text"/>
						<div id="address3_validate" class="form-control-feedback"></div>
						<small class="form-text text-muted float-xs-right">Ex: Maharagama</small>
						</div>
						-->
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

						<div align="center" class="form-group">
							<div class="g-recaptcha" data-sitekey="6LfSRhUUAAAAAC9_QF8XXJb2pekVh9Kphs4fk0JO" style="transform:scale(0.77);-webkit-transform:scale(0.77);transform-origin:0 0;-webkit-transform-origin:0 0;"></div><br/><br/>
							
						</div>
						
						
						<input type="hidden" name="action" value="register"/>
						<p class="text-muted text-center">
							By clicking Register, I agree to the Terms and Conditions of Cinderella
						</p>
						<div class="text-center">
							<a class="btn btn-secondary" data-dismiss="alert" href="../../index.php">Cancel</a>
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
	
	
	
 <script>

$(document).ready(function() {	

$('#registerAsMember').validate({ // initialize the plugin
        rules: {
            email: {
                required: true,
                email: true,
				/*
				remote: {
					url: "validate.php",
					type: "post",
					data: {
						  action: function() {
							return $( "#action" ).val();
						  }
						}
				}
				*/
				
            },
            password: {
                required: true,
                minlength: 6
            },
			repassword: {
				required: true,
		  equalTo: "#password"
		  },
		  fname: {
                required: true
            },
			lname: {
                required: true
            },
			mobile: {
                required: true,
				digits: true,
				minlength: 10,
				maxlength: 10
            },
			location1: {
                required: true
            },
			radio: {
            required: true
        }
		
        },
		 messages: {
                email: {
                    required: "Please Enter Email!",
                    email: "This is not a valid email!",
                    remote: "Email already exists or This is not a valid email address"
                },
				radio: {
					required: "Select either one"
				},
				mobile:{
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

	//$('#waitModal').modal('show');
    // Fire off the request to /form.php
    request = $.ajax({
        url: "RegisterMember.php",
        type: "post",
        data: serializedData
    });
	
    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        console.log("Logged in "+ response);
		//$('#waitModal').modal('hide');
		if(response.indexOf('UNICORN_OK') > -1)
		{
			window.location = "registerDone.php";
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
		//$('#waitModal').modal('hide');
		$("html,body").animate({scrollTop:$('div#topDiv').offset().top}, 500);
		$("#RegisterError").html(response);
		grecaptcha.reset()
    });

    // Callback handler that will be called regardless
    // if the request failed or succeeded
    request.always(function () {
        // Reenable the inputs
		//$('#waitModal').modal('hide');
        $inputs.prop("disabled", false);
    });

});
});
</script>
  
  
  </body>
</html>