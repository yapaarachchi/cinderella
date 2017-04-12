<?php
?>

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
			<a class="nav-link" href="../layout/ContactUs.php">Contact Us</a>
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
				<a class="nav-link active" href="../Merchant/"><u>Merchant Page</u></a>
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
	</nav>

<script>


     

$(document).ready(function() {	


//getLayout("app/layout/MainBanner.php","#MainBanner");
//getLayout("app/layout/SideMenu.php","#SideMenu");
//getLayout("app/layout/Promotions.php","#Promotions");
//getLayout("app/layout/SideMenu.php","#SideMenu");


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
        url: "./../index.php",
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