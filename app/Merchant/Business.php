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


$text =
'


<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner" role="listbox">
    <div class="carousel-item active">
      <img src="images/7.png" alt="First slide" class="img-fluid rounded mx-auto d-block" style="height: 300px; width: 100%;">
	  <div class="carousel-caption d-none d-md-block">
		<a href="#"><h1><u>Change Image</u></h1></a>
		<p>...</p>
	  </div>
    </div>
    <div class="carousel-item">
      <img src="images/5.jpg" alt="Second slide" class="img-fluid rounded mx-auto d-block" style="height: 300px; width: 100%;">
    </div>
    <div class="carousel-item">
      <img src="images/3.jpg" alt="Third slide" class="img-fluid rounded mx-auto d-block" style="height: 300px; width: 100%;">
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

';

//delete confirm model and button
$text = $text.

'
<!-- Modal -->
<div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="DeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  <form id="DeleteBusinessForm">
      <div class="modal-body" id="DeleteModalBody">
	  <input type="hidden" name="BusinessId" id="BusinessId" value=""/>
	  <input type="hidden" name="action" id="action" value="deletebusiness"/>
        Are you sure want to Delete this Business? If yes, it will be deleted related information, including Branches.
      </div>
      <div class="modal-footer">
	  <div id="Message" class="float-left">  </div>
        <button id="CancelDelete" type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button id="DoneDelete" type="submit" class="btn btn-primary">Delete</button>
      </div>
	  </form>
    </div>
  </div>
</div>

<a href="#" class="btn btn-danger" id="deleteConfirmation" data-toggle="modal" data-target="#DeleteModal">Delete '.$business_name.'</a>
';

//profile image
$text=$text .' </br> </br> 
<div class="card">
 <div class="card-header">
 <div class ="float-left">Profile Image (300px * 200px)</div>
 <div class ="float-right" ><a data-toggle="modal" data-target="#UpdateProfileModal"> <u>Update</u></a></div>
  </div>
  <div class="card-block">
    <img src="images/profile/profile.jpg" class="img-fluid img-thumbnail float-right" alt="Responsive image">
  </div>  
</div>

<!-- Modal -->
<div class="modal fade" id="UpdateProfileModal" tabindex="-1" role="dialog" aria-labelledby="UpdateProfileModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="UpdateProfileModal">Update Profile Image (300px * 200px)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  <form id="UpdateProfileModalForm">
      <div class="modal-body">
        <div id="UpdateProfileModalMessage"> </div>
		
		  <div class="image-editor">
			<div class="select-image-btn btn btn-outline-primary"> Select New Image </div>
			<input type="file" style=" visibility: hidden;" class="cropit-image-input" />
			<div id="ImageInfo" class="text-muted"> </div>
			<div class="cropit-preview" style="width: 300px; height: 200px;"></div>
			</br>
			
			<div class="row">
				<div class="col-2">
					<img src="../../assets/icons/rotate_left.png" class="rotate-ccw img-thumbnail img-fluid" role="button"></img>
				</div>
				<div class="col-2">
					<img src="../../assets/icons/rotate_right.png" class="rotate-cw img-thumbnail img-fluid" role="button"></img>
				</div>
				<div class="col-8">
					<input type="range" class="cropit-image-zoom-input">
				</div>
				
			</div>
			<input type="hidden" name="action" value="profile" />
			<input type="hidden" name="business_id" value="'.$business_id.'" />
			<input type="hidden" name="image-data" class="hidden-image-data" />
			
		  </div>
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
	  </form>
    </div>
  </div>
</div>

';


$text = $text. '


</br>
</br>
<ul class="nav nav-tabs" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" data-toggle="tab" href="#business" role="tab">Business Information</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#branches" role="tab">Branches</a>
  </li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane active" id="business" role="tabpanel">





<div id="mainarea">

<div class="card">
  <div class="card-header">
   <div id="EditSection">
   
	<div onclick="editonclick();" id="edit" class ="float-right" value="Edit"><u> Edit </u></div>
  </div>
  </div>
<form method="post" action ="Profile.php">
  <div class="card-block">
			<div class="form-group">
				<label for="business_name" class="form-label text-muted ">Business Name:</label>
					<input value="'.$business_name.'" type="hidden"  id="business_name_hidden"></input>
					<p class="form-control-static" type="text" value="'.$business_name.'" id="business_name" name="business_name"> '.$business_name.'</p>
			</div>
			
			<div class="form-group">
					<label for="category1" class="form-label text-muted">Main Category:</label>
					<input value="'.$category1.'" type="hidden"  id="category1_hidden"></input>
					<p class="form-control-static" type="text" value="'.$category1.'" id="category1" name="category1"> '.$category1.'</p>
			</div>
			
			<div class="form-group">
					<label for="category2" class="form-label text-muted">Sub Category:</label>
					<input value="'.$category2.'" type="hidden"  id="category2_hidden"></input>
					<p class="form-control-static" type="text" value="'.$category2.'" id="category2" name="category2"> '.$category2.'</p>
			</div>
			
			<div class="form-group">
					<label for="email" class="form-label text-muted">Email:</label>
					<input value="'.$email.'" type="hidden"  id="email_hidden"></input>
					<p class="form-control-static" type="text" value="'.$email.'" id="email" name="email"> '.$email.'</p>
			</div>
			
			<div class="form-group">
					<label for="phone" class="form-label text-muted">Phone:</label>
					<input value="'.$phone.'" type="hidden"  id="phone_hidden"></input>
					<p class="form-control-static" type="text" value="'.$phone.'" id="phone" name="phone"> '.$phone.'</p>
			</div>
			
			<div class="form-group">
					<label for="mobile" class="form-label text-muted">Mobile:</label>
					<input value="'.$mobile.'" type="hidden"  id="mobile_hidden"></input>
					<p class="form-control-static" type="text" value="'.$mobile.'" id="mobile" name="mobile"> '.$mobile.'</p>
			</div>
			
			<div class="form-group">
					<label for="contact_person" class="form-label text-muted">Contact Person:</label>
					<input value="'.$contact_person.'" type="hidden"  id="contact_person_hidden"></input>
					<p class="form-control-static" type="text" value="'.$contact_person.'" id="contact_person" name="contact_person"> '.$contact_person.'</p>
			</div>
			
			<div class="form-group">
					<label for="web" class="form-label text-muted">Web Site:</label>
					<input value="'.$web.'" type="hidden"  id="web_hidden"></input>
					<p class="form-control-static" type="text" value="'.$web.'" id="web" named="web"> '.$web.'</p>
			</div>
			
			<div class="form-group">
					<label for="description" class="form-label text-muted">Description:</label>
					<input value="'.$description.'" type="hidden"  id="description"></input>
					<p class="form-control-static" type="text" value="'.$description.'" id="description" name="description"> '.$description.'</p>
			</div>
			<button type="submit" class="btn btn-primary float-right" id="editFormButton">Save</button>
	</form>
	
  </div>
</div>


</div>



</div>
  <div class="tab-pane" id="branches" role="tabpanel">
   </br>

  <button class="btn btn-primary" type="button" data-toggle="collapse" id="CollapseBranchSection" data-target="#AddBranchSection" aria-expanded="false" aria-controls="collapseExample">
    + Add Branch
  </button>

	<div class="collapse" id="AddBranchSection">
	  <div class="card card-block">
		<form id="AddBranch" accept-charset="utf-8">
						
						
						
			
						<div class="form-check">
						<label class="form-check-label">
						<input type="checkbox" class="form-check-input" id="mainBranch">
							Main Branch
						</label>
						<div id="mainBranch_validate" class="form-control-feedback"></div>
						</div>
						
						
						<div class="form-group">
						<label class="form-control-label float-xs-left">Contact Person *</label>
						<input class="form-control" name="contactPerson" type="text"/>
						<div id="contactPerson_validate" class="form-control-feedback"></div>
						</div>
						
						<div class="form-group">
							<label class="form-control-label float-left" >Branch E-Mail *</label>
							<input id="email" class="form-control" name="email" placeholder="youremail@example.com" type="email" />
							<div id="email_validate" class="form-control-feedback"></div>
						</div>
						
						
						<div class="form-group">
						<label class="form-control-label float-xs-left">Branch Mobile *</label>
						<input class="form-control" name="mobile" type="tel"/>
						<small class="form-text text-muted float-right">Ex: 0712345678</small>
						<div id="mobile_validate" class="form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label class="form-control-label float-xs-left">Branch Phone</label>
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
						<label class="form-control-label float-left">Branch Description</label>
						<textarea class="form-control" rows="3" name="description" > </textarea>
						<small class="form-text text-muted float-right">Small description about your business</small>
						<div id="description_validate" class="form-control-feedback"></div>
						</div>
						</br>
						
						<div align="center" class="form-group">
							<div class="g-recaptcha" data-sitekey="6LfSRhUUAAAAAC9_QF8XXJb2pekVh9Kphs4fk0JO" style="transform:scale(0.77);-webkit-transform:scale(0.77);transform-origin:0 0;-webkit-transform-origin:0 0;"></div><br/><br/>
						</div>
						
						
						<input type="hidden" name="action" value="AddBranch"/>
						<p class="text-muted text-center">
							By clicking Add Branch, I agree to the Terms and Conditions of Cinderella
						</p>
						<div class="text-center">
							<a href="" class="btn btn-secondary " role="button" aria-disabled="true" data-toggle="collapse" id="CollapseBranchSection" data-target="#AddBranchSection">Cancel</a>
							<button type="submit" class="btn btn-primary" id="submitbutton">Add Branch</button>
						</div>
					</form>
	  </div>
	</div>
   </br>
  ';
  $Branchses = $Branch->getBranchByBusinessId($business_id);
  if (is_array($Branchses) || is_object($Branchses))
{
  foreach($Branchses as $key => $value) {
		$branch_address1 = $value['branch_address1'];
		$branch_address2 = $value['branch_address2'];
		$branch_address3 = $value['branch_address3'];
		$district = $value['district'];
		$contact_person = $value['contact_person'];
		$branch_email = $value['branch_email']; 
		$branch_mobile = $value['branch_mobile'];
		$branch_phone = $value['branch_phone'];
		$main_branch = $value['main_branch'];
		$branch_description = $value['description'];

	  $text = $text. '
	  </br>
		<div class="card">
			<div class="card-header">
				'.$district.'
			</div>
			<div class="card-block">
				<h4 class="card-title">Special title treatment</h4>
				<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
				<a href="#" class="btn btn-primary">Go somewhere</a>
			</div>
		</div>
	';
  }
}
  $text = $text. '
  </div>
</div>
';

echo $text;
}
			
}

if (isset($_POST)) {
		if (isset($_POST['action'])) {
		if ($_POST['action'] === 'deletebusiness') {
			try {
				$status =" ";
				$status = $Business->deleteBusiness($_POST['BusinessId']);
			if($status == '200'){
				echo "CINDERELLA_OK";
			}
			}
			catch (Exception $e) {
				ErrorCode::SetError(ErrorCode::ERROR_GENERAL);
				return;
			}	
		}
		else if ($_POST['action'] === 'profile') {
			try {
				$business_id = $_POST['business_id'];
				 $encoded = $_POST['image-data'];
				//explode at ',' - the last part should be the encoded image now
				$exp = explode(',', $encoded);
				//decode the image and finally save it
				$data = base64_decode($exp[1]);
				
				$mime_type = finfo_buffer(finfo_open(), $data, FILEINFO_MIME_TYPE);
				$mime_type_arr = explode('/', $mime_type);
				$mime_type = $mime_type_arr[1];
				
				$file = 'images/profile/'.$business_id.'.'.$mime_type;
				//make sure you are the owner and have the rights to write content
				file_put_contents($file, $data);
	
	
			
				//$status =" ";
				//$status = $Business->deleteBusiness($_POST['BusinessId']);
			//if($status == '200'){
				//echo "CINDERELLA_OK";
			//}
			
			echo $file;
			}
			catch (Exception $e) {
				ErrorCode::SetError(ErrorCode::ERROR_GENERAL);
				return;
			}	
		}
		}
}

?>

<script>
$(document).ready(function() {	

var request;
$('#deleteConfirmation').click(function () {
	$("#DeleteModalBody #BusinessName").val( "<?php echo $business_name; ?>" );
	$("#DeleteModalBody #BusinessId").val( "<?php echo $business_id; ?>" );
	} );

	$('#CollapseBranchSection').click(function () {	
		$('#AddBranch').trigger("reset");
		$("#mainBranch_validate").html('');
	} );
	
	$('#mainBranch').click(function () {
		var alert = '<div class="alert alert-warning" role="alert"> This branch will become the main branch of <?php echo $business_name; ?></div>'
		if($("#mainBranch").is(':checked')){
			$("#mainBranch_validate").html(alert);
		}
		else{
			$("#mainBranch_validate").html('');
		}
		
	} );

	
$("#editFormButton").hide();

// Bind to the submit event of our form
$("#DeleteBusinessForm").submit(function(event){
    event.preventDefault();

    if (request) {
        request.abort();
    }
    var $form = $(this);
    var $inputs = $form.find("input, select, button, textarea");
    var serializedData = $form.serialize();
	$("#CancelDelete").hide();
	$("#DoneDelete").hide();
	$("#Message").html('<div style="color: blue"><strong>Please Wait!</strong> You request is being processing.<div>');
	//$('#DeleteModal').modal('hide');
	$(this).prop('disabled',true);
    request = $.ajax({
        url: "Business.php",
        type: "post",
        data: serializedData
    });
	
    request.done(function (response, textStatus, jqXHR){
        console.log("Logged in "+ response);
		//$('#waitModal').modal('hide');
		if(response.indexOf('CINDERELLA_OK') > -1)
		{
			window.location = "index.php";
		}
		else{
			$("#Message").html(response);
			$("#CancelDelete").show();
			$("#DoneDelete").show();
		}
		
		
    });

    request.fail(function (jqXHR, textStatus, errorThrown){
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
		//$('#waitModal').modal('hide');
		$("#Message").html(errorThrown);
		$("#CancelDelete").show();
		$("#DoneDelete").show();
    });
    request.always(function () {
		//$(this).prop('disabled',false);
    });

});


//pro
	$(function() {
        $('.image-editor').cropit();
		
		$('.select-image-btn').click(function() {
		  $('.cropit-image-input').click();
			$("#ImageInfo").html('Resize and adjust the image as needed');
		});


		$('.rotate-cw').click(function() {
          $('.image-editor').cropit('rotateCW');
        });
        $('.rotate-ccw').click(function() {
          $('.image-editor').cropit('rotateCCW');
        });
   	

        $('#UpdateProfileModalForm').submit(function() {
			event.preventDefault();
          // Move cropped image data to hidden input
          var imageData = $('.image-editor').cropit('export');
		  if(imageData == ""){
			  return false;
		  }
          $('.hidden-image-data').val(imageData);

          // Print HTTP request params
          var formValue = $(this).serialize();

		  $(this).prop('disabled',true);
			request = $.ajax({
				url: "Business.php",
				type: "post",
				data: formValue
			});
			
			request.done(function (response, textStatus, jqXHR){
				console.log("Logged in "+ response);
				//$('#waitModal').modal('hide');
				$("#UpdateProfileModalMessage").html(response);
				$("#UpdateProfileModal").hide();	
				
				
			});

			request.fail(function (jqXHR, textStatus, errorThrown){
				console.error(
					"The following error occurred: "+
					textStatus, errorThrown
				);
				//$('#waitModal').modal('hide');
				//$("#UpdateProfileModalMessage").html(errorThrown);
				$("#UpdateProfileModal").show();
			});
			request.always(function () {
				//$(this).prop('disabled',false);
			});
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