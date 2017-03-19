<?php
require "../Config.php";
require "../ErrorCode.php";
require '../../vendor/autoload.php';

$db = Config::initDb();
$auth = new \Delight\Auth\Auth($db);
$Business = new \Delight\Auth\Business($db);
$Branch = new \Delight\Auth\Branch($db);

$business_id;
$business_details;
$business_name;
$category1;
$category2;
$email;
$phone;
$mobile;
$contact_person;
$web;
$description;

$branch_address1;
$branch_address2;
$branch_address3;
$district;
$contact_person;
$branch_email; 
$branch_mobile;
$branch_phone;
$main_branch;
$branch_description;

if (isset($_GET)) {
		if (isset($_GET['id'])){
			$business_id = $_GET['id'];
			$Businesses = $Business->getBusinessById($_GET['id']);
			if (is_array($Businesses) || is_object($Businesses))
			{
				foreach($Businesses as $key => $value) {
					$business_name = $value['business_name'];
					$category1 = $value['category1'];
					$category2 = $value['category2'];
					$email = $value['business_email'];
					$phone = $value['business_phone'];
					$mobile = $value['business_mobile'];
					$contact_person = $value['contact_person'];
					$web = $value['website'];
					$description = $value['description'];
				}
			}		

$text = '


<div id="AddBusinessBanner" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner" role="listbox">
    <div class="carousel-item active">
      <img src="images/7.png" alt="First slide" class="img-fluid rounded mx-auto d-block" style="height: 300px; width: 100%;">
    </div>
    <div class="carousel-item">
      <img src="images/7.png" alt="Second slide" class="img-fluid rounded mx-auto d-block" style="height: 300px; width: 100%;">
    </div>
    <div class="carousel-item">
      <img src="images/7.png" alt="Third slide" class="img-fluid rounded mx-auto d-block" style="height: 300px; width: 100%;">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

</br>';

$text = $text.'

	
<div class="card ">
			
			<div class="card-block">
				<div class="row">
						
						
					<div class="col-lg-12 float-xs-left">
						<div class="form-group">
						<small class="form-text text-muted float-left">* mandatory fields</small>
						</div>
						</br>
					<div id="RegisterError" style="padding-bottom: 10px;"></div>
					<form id="AddAsBusiness" accept-charset="utf-8">
						
						<div class="form-group">
						<label class="form-control-label float-xs-left">Business Name *</label>
						<input class="form-control" name="businessName" type="text"/>
						<small class="form-text text-muted float-right">Ex: ABC Studio</small>
						<div id="businessName_validate" class="form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label class="form-control-label float-left">Main Category *</label>
						<select class="form-control" id="category1" name="category1">
						</select>
						<div id="category1_validate" class="form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label class="form-control-label float-left">Sub Category *</label>
						<select class="form-control" id="category2" name="category2">
						</select>
						<div id="category2_validate" class="form-control-feedback"></div>
						</div>
			
						<div class="form-group">
						<label class="form-control-label float-xs-left">Contact Person *</label>
						<input class="form-control" name="contactPerson" type="text"/>
						<div id="contactPerson_validate" class="form-control-feedback"></div>
						</div>
						
						<div class="form-group">
							<label class="form-control-label float-left" >Business E-Mail *</label>
							<input id="email" class="form-control" name="email" placeholder="youremail@example.com" type="email" />
							<div id="email_validate" class="form-control-feedback"></div>
						</div>
						
						
						<div class="form-group">
						<label class="form-control-label float-xs-left">Business Mobile *</label>
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
						<label class="form-control-label float-xs-left">Address *</label>
						<input class="form-control" name="address1" type="text"/>
						<div id="address1_validate" class="form-control-feedback"></div>
						<small class="form-text text-muted float-right">Ex: No: 49/6/A</small>
						</div>
						
						<div class="form-group">
						<label class="form-control-label float-xs-left">Street *</label>
						<input class="form-control" name="address2" type="text"/>
						<div id="address2_validate" class="form-control-feedback"></div>
						<small class="form-text text-muted float-right">Ex: Temple Road</small>
						</div>
						
						<div class="form-group">
						<label class="form-control-label float-xs-left">City *</label>
						<input class="form-control" name="address3" type="text"/>
						<div id="address3_validate" class="form-control-feedback"></div>
						<small class="form-text text-muted float-right">Ex: Maharagama</small>
						</div>
						
						<div class="form-group">
						<label class="form-control-label float-xs-left">District *</label>
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
						<label class="form-control-label float-xs-left">Web Site</label>
						<input class="form-control" name="web" type="text"/>
						<div id="web_validate" class="form-control-feedback"></div>
						<small class="form-text text-muted float-right">Ex: www.abc.lk</small>
						</div>
						
						<div class="form-group">
						<label class="form-control-label float-left">Description</label>
						<textarea class="form-control" rows="3" name="description" > </textarea>
						<small class="form-text text-muted float-right">Small description about your business</small>
						<div id="description_validate" class="form-control-feedback"></div>
						</div>
						</br>
						
						<div align="center" class="form-group">
							<div class="g-recaptcha" data-sitekey="6LfSRhUUAAAAAC9_QF8XXJb2pekVh9Kphs4fk0JO" style="transform:scale(0.77);-webkit-transform:scale(0.77);transform-origin:0 0;-webkit-transform-origin:0 0;"></div><br/><br/>
						</div>
						
						
						<input type="hidden" name="action" value="register"/>
						<p class="text-muted text-center">
							By clicking Add Business, I agree to the Terms and Conditions of Cinderella
						</p>
						<div class="text-center">
							<a href="" class="btn btn-secondary " role="button" aria-disabled="true">Cancel</a>
							<button type="submit" class="btn btn-primary" id="submitbutton">Add Business</button>
						</div>
					</form>
					
					</div>
				</div>
			</div>
		</div>
';

//waitmodel
$text = $text.
'
<div class="modal fade" id="waitmodel"  tabindex="-1" role="dialog" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Please Wait</h5>
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Your request is beign processing... This migh take few seconds</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="errormodel"  tabindex="-1" role="dialog" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Error</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you not a Human? Please tick the Im not a robot check box</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>
</div>
';
echo $text;
}
			
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
						$other['business_email'] = $_POST['email'];
						$other['email'] = $auth->getEmail();
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
						if (isset($_POST['web']) and $_POST['web'] !== '') {
							$other['web'] = $_POST['web'];
						}
						
						$Business->addBusiness($auth->getUserId(), $other);
						
						
					}
					catch (\Delight\Auth\Error $e) {
						ErrorCode::SetError(ErrorCode::ERROR_GENERAL);
						return;
					}
					catch (Exception $e) {
						ErrorCode::SetError(ErrorCode::ERROR_GENERAL);
						return;
					}
					echo "CINDERELLA_OK";
					return;
				}				
			}
			else{				
				ErrorCode::SetError(ErrorCode::REQUIRED_RECAPTCHA);
				return;
			}
			
	}	
}




?>
	<script src='https://www.google.com/recaptcha/api.js'></script>
 
	<script src="../../js/jquery.validate.min.js"></script>
	<script src="../../js/additional-methods.min.js"></script>
	
	<script src="../../js/notify.js"></script>
 
<script>
$(document).ready(function() {	
$("#editFormButton").hide();

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


$('#AddAsBusiness').validate({ // initialize the plugin
        rules: {
            email: {
                required: true,
                email: true				
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
                    email: "This is not a valid email!"
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

	
	var request;



// Bind to the submit event of our form
$("#AddAsBusiness").submit(function(event){

if (!$(this).valid()) {  //<<< I was missing this check
grecaptcha.reset();
                return false;
            }
			
			var response = grecaptcha.getResponse();

		if(response.length == 0){
				$('#errormodel').modal('show');
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

	$('#waitmodel').modal('show');
    // Fire off the request to /form.php
    request = $.ajax({
        url: "AddBusiness.php",
        type: "post",
        data: serializedData
    });
	
    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        console.log("Logged in "+ response);
		$('#waitmodel').modal('hide');
		if(response.indexOf('CINDERELLA_OK') > -1)
		{
			window.location = "index.php";
		}
		else{
			$("html,body").animate({scrollTop:$('div#AddBusinessBanner').offset().top}, 500);
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
		$("html,body").animate({scrollTop:$('div#AddBusinessBanner').offset().top}, 500);
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




	
} );
function editonclick(){
	
	
	var attr;
	var TextVale;
	var OldVale;
	var OldFieldVale;
	var possible;
	
	$('#EditSection').find('div').each(function(){
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
				$(this).replaceWith($('<div '+ attr +' > <u>' + TextVale + '</u></div>'));
		});
		
		if(OldVale == "Edit"){
			$('#mainarea').find('p').each(function(){
			$("#editFormButton").show();
				attr = "";
				  $.each(this.attributes, function() {
					// this.attributes is not a plain object, but an array
					// of attribute nodes, which contain both the name and value
					if(this.specified) {
						if(this.name == "type" & this.value == "hidden"){
							possible = false;
							return false; 
						}
						else{
							possible = true;						
						}	
						
						if(this.name == "class" & this.value == "form-control-static"){
								this.value= "form-control"
							}
						
						attr = attr + ' ' + this.name + ' = "' + this.value + '"';	
					}
				  });
				
				if(possible === true){
					$(this).replaceWith($('<input '+ attr +' >' + $(this).val() + '</input>'));
				}
		});
		}
		else if(OldVale == "CancelEdit"){
			$('#mainarea').find(':input').each(function(){
			
			$("#editFormButton").hide();
				attr = "";
				  $.each(this.attributes, function() {
					// this.attributes is not a plain object, but an array
					// of attribute nodes, which contain both the name and value
					if(this.specified) {
						if(this.name == "value"){
							OldFieldVale = this.value;
						}
						
						if(this.name == "type" & (this.value == "hidden" || this.value == "submit")){
							possible = false;
							return false; 
						}
						else{
							possible = true;						
						}	
						if(this.name == "class" & this.value == "form-control"){
							this.value= "form-control-static"
						}
						attr = attr + ' ' + this.name + ' = "' + this.value + '"';			
					}
				  });
				
				if(possible === true){
					$(this).replaceWith($('<p '+ attr +' >' + OldFieldVale + '</p>'));
					OldFieldVale = "";
				}
		});
		}

	$("#mainarea").hide().fadeIn('fast');	
		
	}
	

</script>