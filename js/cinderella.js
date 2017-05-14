
function loginModalValidate(FormName){

$('#'+FormName).validate({
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

}
 
function loginModalSubmit(FormName, ErrorDiv){
var request;
$("#"+FormName).submit(function(event){

	if (!$(this).valid()) {  
        return false;
    }
    event.preventDefault();

    if (request) {
        request.abort();
    }
    var $form = $(this)	;

    var $inputs = $form.find("input, select, button, textarea");

    var serializedData = $form.serialize();

    $inputs.prop("disabled", true);

    request = $.ajax({
        url: "../controller/Login.php",
        type: "post",
        data: serializedData
    });

    request.done(function (response, textStatus, jqXHR){
        console.log("Logged in "+ response);
		
		if(response.indexOf('CINDERELLA_OK') > -1)
		{
			location.reload();
		}
		else{
			$("#"+ErrorDiv).html(response);
		}
		
		
    });


    request.always(function () {
        $inputs.prop("disabled", false);
    });

});
	
}

function loginModalOnClose(ModelName, FormName, ErrorDiv){
$('#'+ModelName).on('hidden.bs.modal', function (e) {
	$("#"+ErrorDiv).html('');
	$('#'+FormName).trigger("reset");
	$('#'+FormName).validate().resetForm();
	$('#'+FormName+' .form-group').removeClass('has-danger');
	$('#'+FormName+' .form-group').removeClass('has-success');
	$('#'+FormName+' .form-control').removeClass('form-control-danger');
	$('#'+FormName+' .form-control').removeClass('form-control-success');
});

}

function signOut(alink){
	var request;
	
	$('#'+alink).click(function () {
		
	if (request) {
        request.abort();
    }
	
	request = $.ajax({
        url: "../controller/logout.php",
        type: "post",
        data: { action: "signout"}
    });
	
	request.done(function (response, textStatus, jqXHR){
        console.log("Sign out "+ response);
		
		if(response.indexOf('CINDERELLA_OK') > -1)
		{
			location.reload();
		}		
    });
	
	});
}

function NavigateToPage(businessid, url){
	var request;

	if (request) {
        request.abort();
    }
	
		request = $.ajax({
        url: "../controller/Navigate.php",
        type: "post",
        data: { action: "NAVIGATE_MERCHANT_PAGE", business_id: businessid}
    });
	
		request.done(function (response, textStatus, jqXHR){
        console.log("NAVIGATE_MERCHANT_PAGE"+ response);
		
		if(response.indexOf('CINDERELLA_OK') > -1)
		{
			window.location = url+'?business='+ businessid;
		}		
    });
}