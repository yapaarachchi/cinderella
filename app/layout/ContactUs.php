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
	
	<title>Cinderella - Contact Us</title>
  </head>
  <body>
	<nav class="navbar fixed-top navbar-inverse bg-inverse navbar-toggleable-md">
		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<a class="navbar-brand" href="../../">
		<img src="../../assets/icons/home.svg" width="30" height="30" alt="">
		<b>Cinderella</b>
		</a>
		
		<!-- Large Screens -->
		<ul class="nav navbar-nav hidden-md-down">
		  <li class="nav-item">
			<a class="nav-link" href="AboutUs.php">About Us</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" href="../Search">Search</a>
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
		<span class = " hidden-md-down" style="color:white; margin-left: 30px">Advertise With us: Call - 071 5104647</span>
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
			
			<!-- Middle Pannel -->
			<div class="col-lg-10">
				<div class="card">
				<div class="card-header">
				<h4 class="card-title">Contact Us</h4>
				</div>
				  <div class="card-block">
					
					<p class="card-subtitle mb-2 text-muted">
					Building a website is, in many ways, an exercise of willpower. It’s tempting to get distracted by the bells and whistles of the design process, and forget all about creating compelling content. But it's that last part that's crucial to making inbound marketing work for your business.

So how do you balance your remarkable content creation with your web design needs? It all starts with the "About Us" page.
For a remarkable about page, all you need to do is figure out your company's unique identity, and then share it with the world. Easy, right? Of course it's not easy. That said, the "About Us" page is one of the most important pages on your website, and it can't go neglected. It also happens to be one of the most commonly overlooked pages, which is why you should make it stand out. 
Download our collection of awesome 'About Us' page examples here, and get tips for making yours great, too. 

But it can be accomplished. In fact, there are some companies out there with remarkable "About Us" pages, and there are elements of them that you can emulate on your own website. By the end of this post, showing off how your company's greatness won't seem like such a challenging feat.
					
					
					
					
					</p>
				  </div>
				</div>
			</div>
			
			<!-- Margin Right Pannel -->
			<div class="col-lg-1 hidden-md-down">
			</div>
		
		</div>
	</div>
	</br>
	<nav class="navbar sticky-top navbar-inverse bg-inverse">

		<div class="row">
		
		<div class="col-5">
			
				<a href="AboutUs.php" >About Us</a>
				<span class="text-muted">|</span>
				<a href="../Search" >Search</a>
			
		</div>
		
		<div class="col-5">
		
		<span style="color:white">© 2017 Cinderella  </span> 
		<span  class="text-muted">(All Rights Reserved)</span> 
		</div>
		
		<div class="col-2 float-right">
		<a href="https://www.facebook.com/Cinderellalk-379706339094765/" target="_blank" ><img src="../../assets/icons/facebook.png" style="width:30px; height:30px; margin: 0 auto" class="img-fluid d-block" alt="Image"></a>		
		</div>
		
		</div>
		
	</nav>
	
	<?php
	if($isLoggedIn === false){
		include('RegisterPannelSm.php');
	}		
	?>
						
    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="../../js/jquery-3.1.1.slim.min.js"></script>
    <script src="../../js/tether.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
	
	<script src="../../js/jquery.validate.min.js"></script>
	<script src="../../js/additional-methods.min.js"></script>

	
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