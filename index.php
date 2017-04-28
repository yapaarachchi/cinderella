<?php
require 'app/Config.php';
require __DIR__.'/vendor/autoload.php';

$db = Config::initDb();
$auth = new \Delight\Auth\Auth($db);
$isLoggedIn = $auth->isLoggedIn();

				if (isset($_POST)) {
					if (isset($_POST['action'])) {
						if ($_POST['action'] === 'signout') {
							try{
								$auth->logout();
							}
							catch(Exception $e){
								
							}
							echo "CINDERELLA_OK";
							return;
						}
						else{
							
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
    <link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/cinderella.css">
	
	<title>Cinderella</title>
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
			<a class="nav-link" href="app/layout/AboutUs.php">About Us</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" href="app/layout/ContactUs.php">Contact Us</a>
		  </li>
		</ul>
		
		<?php
			if($isLoggedIn === false){				
		?>
			<ul class="nav navbar-nav hidden-md-down">
			  <li class="nav-item">
				<a class="nav-link" href="#" data-toggle="modal" data-target="#LogInModal"><u>Sign In</u></a>
			  </li>
			</ul>
		<?php
			}
			else{
		?>
			<ul class="nav navbar-nav">
			
			<?php
			if($auth->getUserRole($auth->getEmail()) == '3')
			{
			?>
			  <li class="nav-item">
				<a class="nav-link active" href="app/Merchant/"><u>Merchant Page</u></a>
			  </li>
			  
			  <?php
			}
			  ?>
			  <li class="nav-item">
				<a class="nav-link" href="#" id="signOut"><u>Sign Out</u></a>
			  </li>
			</ul>
		<?php
			}
		?>
		<!-- Toggle - Small Screen -->
		<div class="collapse navbar-toggleable-md" id="navbarNavDropdown">
			<ul class="nav navbar-nav hidden-lg-up">
			<?php
			if($isLoggedIn === false){				
		?>
			<li class="nav-item">
				<a class="nav-link" href="#" data-toggle="modal" data-target="#LogInModal"><u>Sign In</u></a>
			  </li>
		<?php
			}
		?>
			</ul>
		</div>
		<span class = " hidden-md-down" style="color:white; margin-left: 30px">Advertise With us: Call - 076 5537100</span>
		
		<div class="navbar-toggler-right hidden-md-down"> <a class="btn btn-primary" href="app/Search" role="button">Search</a>  </div>
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
	<div class="container-fluid">
		<!-- Main Row -->
		<div class="row">
		
			<!-- Margin Left Pannel -->
			<div class="col-lg-1 hidden-md-down">
			</div>
			
			
			<!-- Left Pannel -->
			<div id="SideMenu" class="col-lg-2 hidden-md-down">
				
			</div>
			
			<!-- Middle Pannel -->
			<div class="col-lg-8">
				<div class="row">
					<div id="MainBanner" class="col-lg-12">
						<!-- put main banner here -->
						<!-- put promotions here -->
							<?php
								include('app/layout/MainBanner.php')
							?>
						

					</div>
				</div>
				
				<?php
				if($isLoggedIn === false){				
				?>
					<div class="row">
						<div class="col-lg-12">
							<!-- put promotions here -->
							<?php
								include('app/layout/RegisterPannelLg.php')
							?>
						</div>
					</div>
				<?php
				}
				?>
				
				<div class="row">
					<div id="Promotions" class="col-lg-12">
						<!-- put promotions here -->
							<?php
								include('app/layout/Promotions.php')
							?>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
					<!-- put main adds here -->
						<?php
							include('app/layout/MainAds.php')
						?>
					</div>
				</div>
			</div>
			
			<!-- Margin Right Pannel -->
			<div class="col-lg-1 hidden-md-down">
			</div>
		
		</div>
	</div>
	
	<nav class="navbar sticky-top navbar-light" style="background-color:#E6E8EA; margin-top:20px">

		<div class="row">
		
		<div class="col-5">
			
				<a href="app/layout/AboutUs.php" style="color:#888A8D">About Us</a>
				<span style="color:#888A8D">|</span>
				<a href="app/layout/ContactUs.php" style="color:#888A8D">Contact Us</a>
				<span style="color:#888A8D">|</span>
				<a href="app/Search/" style="color:#888A8D">Search</a>
			
		</div>
		
		<div class="col-5">
		
		<span style="color:#888A8D">© 2017 Cinderella  </span> 
		<span style="color:#B0B1B2"  >(All Rights Reserved)</span> 
		</div>
		
		<div class="col-2 float-right">
		<a href="https://www.facebook.com/Cinderellalk-379706339094765/" target="_blank" ><img src="assets/icons/facebook.png" style="width:30px; height:30px; margin: 0 auto" class="img-fluid d-block" alt="Image"></a>		
		</div>
		
		</div>
		
	</nav>
	
	<?php
	if($isLoggedIn === false){
		include('app/layout/RegisterPannelSm.php');
	}		
	?>
						
    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="js/jquery-3.1.1.slim.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	
	<script src="js/jquery.validate.min.js"></script>
	<script src="js/additional-methods.min.js"></script>

	
<script>


     

$(document).ready(function() {	


//getLayout("app/layout/MainBanner.php","#MainBanner");
getLayout("app/layout/SideMenu.php","#SideMenu");
//getLayout("app/layout/Promotions.php","#Promotions");
//getLayout("app/layout/SideMenu.php","#SideMenu");




function getLayout(pageName, divName){

	var response;
	var request;

    if (request) {
        request.abort();
    }
	
    request = $.ajax({
        url: pageName,
        type: "get",
        data: "action=getLayout"
    });
	
    request.done(function (response, textStatus, jqXHR){		
		$(divName).html(response);
		$(divName).hide().fadeIn('fast');	
    });

    request.fail(function (jqXHR, textStatus, errorThrown){
        $(divName).html('No data');
		$(divName).hide().fadeIn('fast');	
    });

};


function logout() {
         $.post('app/layout/logout.php', {"action":"logout"}, function(resp) {
             location.reload();
         });
     }

 

$('#LogInModal').on('hidden.bs.modal', function (e) {
  $("#loginModalError").html('');
})

 $('#login').validate({ // initialize the plugin
        rules: {
            loginUsername: {
                required: true,
                email: true,
				remote: {
					url: "app/controller/Validate.php",
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

// Bind to the submit event of our form
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
        url: "app/controller/Login.php",
        type: "post",
        data: serializedData
    });

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        console.log("Logged in "+ response);
		
		if(response.indexOf('CINDERELLA_OK') > -1)
		{
			location.reload();
		}
		else{
			$('#loginModal').modal('show');
			$("#loginModalError").html(response);
		}
		
		
    });


    // Callback handler that will be called regardless
    // if the request failed or succeeded
    request.always(function () {
        // Reenable the inputs
        $inputs.prop("disabled", false);
    });

});

$('#signOut').click(function () {
	if (request) {
        request.abort();
    }
	
	request = $.ajax({
        url: "index.php",
        type: "post",
        data: { action: "signout"}
    });
	
	request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        console.log("Sign out "+ response);
		
		if(response.indexOf('CINDERELLA_OK') > -1)
		{
			location.reload();
		}
		else{
			//$("#loginModalError").html(response);
		}
		
		
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
		//$("#loginModalError").html(errorThrown);
    });
	
	});  
	
});
    


</script>
</body>
</html>