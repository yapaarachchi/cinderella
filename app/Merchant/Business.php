<?php
require "../Config.php";
require "../ErrorCode.php";
require '../../vendor/autoload.php';

$db = Config::initDb();
$auth = new \Delight\Auth\Auth($db);
$Business = new \Delight\Auth\Business($db);
$Branch = new \Delight\Auth\Branch($db);
$Media = new \Delight\Auth\Media($db);
$Category = new \Delight\Auth\Category($db);

$isLoggedIn = $auth->isLoggedIn();
if(!$isLoggedIn or $auth->getUserRole($auth->getEmail()) != '3'){
	header('Location: ../../index.php');
}

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

$profile_media_status;

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

//banner images
$text =
'
<div id="ApproveMessage"> '.$Business->getBusinessStatusMessage($business_id).'</div>
<a target="_blank" href="../Page/index.php?business='.$business_id.'" class="btn btn-primary" >View Business Page</a>
<a href="#" class="btn btn-danger" id="deleteConfirmation" data-toggle="modal" data-target="#DeleteModal">Delete '.$business_name.'</a>
</br></br>
<div class="card">
 <div class="card-header">
 <div class="row">
	 <div class="col-4">
	 Banner Images (800px * 300px)
	 </div>
	 <div class="col-8">
		 <div class="row">
			 <div class="col-4">
				<a style="cursor: pointer" id="UpdateImage1" data-toggle="modal" data-target="#UpdateBannerModal" data-id="1" > <u>Update Image 1</u></a>
			 </div>
			 <div class="col-4">
				<a style="cursor: pointer" id="UpdateImage2" data-toggle="modal" data-target="#UpdateBannerModal" data-id="2"> <u>Update Image 2</u></a>
			 </div>
			 <div class="col-4">
				<a style="cursor: pointer" id="UpdateImage3" data-toggle="modal" data-target="#UpdateBannerModal" data-id="3"> <u>Update Image 3</u></a>
			 </div>
		</div>
	 </div>
 </div>
 
  </div>
</div>

<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="3000">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner" role="listbox">
    <div class="carousel-item active">
      <img id="BannerImage1" class="d-block img-fluid" src="images/banner/'.$Media->getBannerImage($business_id, 1, false).'" style="height: 100%; width: 100%;">
	  <div class="carousel-caption d-none d-md-block">
		<h1><u>Image 1</u></h1>
		<div id="BannerImage1Message">'.$Media->getMediaStatusMessage($business_id, "BANNER", "IMAGE", $Media->getBannerImage($business_id, 1, false, false)).' </div>
	  </div>
    </div>
    <div class="carousel-item">
      <img id="BannerImage2" class="d-block img-fluid" src="images/banner/'.$Media->getBannerImage($business_id, 2, false).'" style="height: 100%; width: 100%;">
	  <div class="carousel-caption d-none d-md-block">
		<h1><u>Image 2</u></h1>
		<div id="BannerImage2Message">'.$Media->getMediaStatusMessage($business_id, "BANNER", "IMAGE", $Media->getBannerImage($business_id, 2, false, false)).' </div>
	  </div>
    </div>
    <div class="carousel-item">
      <img id="BannerImage3" class="d-block img-fluid" src="images/banner/'.$Media->getBannerImage($business_id, 3, false).'" style="height: 100%; width: 100%;">
	  <div class="carousel-caption d-none d-md-block">
		<h1><u>Image 3</u></h1>
		<div id="BannerImage3Message">'.$Media->getMediaStatusMessage($business_id, "BANNER", "IMAGE", $Media->getBannerImage($business_id, 3, false, false)).' </div>
	  </div>
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

<!-- Modal -->
<div class="modal fade" id="UpdateBannerModal" tabindex="-1" role="dialog" aria-labelledby="UpdateBannerModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="UpdateBannerModal">Update Banner Image (800px * 300px)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  <form id="UpdateBannerModalForm">
      <div class="modal-body">
	  <input type="hidden" name="imageindex" id="imageindex" value=""/>
        <div id="UpdateBannerModalMessage"> </div>
		
		  <div class="image-editor-banner">
			<div style="cursor: pointer" class="select-image-banner-btn btn btn-outline-primary"> Select New Image </div>
			<input type="file" style=" visibility: hidden;" class="cropit-image-input-banner"/>
			<div id="BannerImageInfo" class="text-muted"> </div>
			<div class="cropit-preview-banner" style="width: 800px; height: 300px;"></div>
			</br>
			
			<div class="row">
				<div class="col-2">
					<img src="../../assets/icons/rotate_left.png" class="rotate-banner-ccw img-thumbnail img-fluid" role="button"></img>
				</div>
				<div class="col-2">
					<img src="../../assets/icons/rotate_right.png" class="rotate-banner-cw img-thumbnail img-fluid" role="button"></img>
				</div>
				<div class="col-8">
					<input type="range" class="cropit-image-zoom-input">
				</div>
				
			</div>
			<input type="hidden" name="action" value="banner" />
			<input type="hidden" name="business_id" value="'.$business_id.'" />
			<input type="hidden" name="image-data" class="hidden-image-data-banner" />
			
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


';

//profile image
$text = $text .' </br>
<div id="profilecard" class="card">
 <div class="card-header">
 <div class ="float-left">Profile Image (300px * 200px)</div>
 <div class ="float-right" ><a style="cursor: pointer" data-toggle="modal" data-target="#UpdateProfileModal"> <u>Update</u></a></div>
  </div>
  <div class="card-block " >
    <img id="ProfileImage" src="images/profile/'.$Media->getProfileImage($business_id, false).'" class="img-fluid img-thumbnail float-right" alt="Responsive image">
  </div> 
  <div id="ProfileImageMessage" >
  '.$Media->getMediaStatusMessage($business_id, "PROFILE", "IMAGE").'
  </div> 

</div>
</br>

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
		
		  <div class="image-editor-profile">
			<div style="cursor: pointer" class="select-image-profile-btn btn btn-outline-primary"> Select New Image </div>
			<input type="file" style=" visibility: hidden;" class="cropit-image-input-profile" />
			<div id="ProfileImageInfo" class="text-muted"> </div>
			<div class="cropit-preview-profile" style="width: 300px; height: 200px;"></div>
			</br>
			
			<div class="row">
				<div class="col-2">
					<img src="../../assets/icons/rotate_left.png" class="rotate-profile-ccw img-thumbnail img-fluid" role="button"></img>
				</div>
				<div class="col-2">
					<img src="../../assets/icons/rotate_right.png" class="rotate-profile-cw img-thumbnail img-fluid" role="button"></img>
				</div>
				<div class="col-8">
					<input type="range" class="cropit-image-zoom-input">
				</div>
				
			</div>
			<input type="hidden" name="action" value="profile" />
			<input type="hidden" name="business_id" value="'.$business_id.'" />
			<input type="hidden" name="image-data" class="hidden-image-data-profile" />
			
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
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#videos" role="tab">Videos</a>
  </li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane active" id="business" role="tabpanel">
';



$text = $text. '
<div id="mainarea">

<div class="card">
  <div class="card-header">
   <div id="EditSection">   
	<div style="cursor: pointer" onclick="editonclick();" id="edit" class ="float-right" value="Edit"><u> Edit </u></div>
  </div>
  </div>
<form id="EditBusinessInfo">
  <div class="card-block" id="EditBusinessInfoDiv">
			<div id="EditBusinessInfoMessage"> </div>
			<div class="form-group">
				<label for="business_name" class="form-label text-muted ">Business Name:</label>
					<input value="'.$business_name.'" type="hidden"  id="business_name_hidden" name="business_name_hidden"></input>
					<p type="text" value="'.$business_name.'" id="businessName" name="businessName" class="form-control-static" > '.$business_name.'</p>
					<div id="businessName_validate" class="form-control-feedback"></div>
			</div>
			
			<div class="form-group">
					<label for="category1" class="form-label text-muted">Main Category:</label>
					<input value="'.$category1.'" type="hidden"  id="category1_hidden" name="category1_hidden"></input>
					<p type="text" value="'.$Category->getCategoryName($category1).'" id="category1_" name="category1_" class="form-control-static" > '.$Category->getCategoryName($category1).'</p>
				
				<select id="category1" name="category1" class="form-control" >
				</select>
				<div id="category1_validate" class="form-control-feedback"></div>
			</div>
			
			<div class="form-group">
					<label for="category2" class="form-label text-muted">Sub Category:</label>
					<input value="'.$category2.'" type="hidden"  id="category2_hidden" name="category2_hidden"></input>
					<p type="text" value="'.$Category->getSubCategoryName($category1, $category2).'" id="category2_" name="category2_" class="form-control-static" > '.$Category->getSubCategoryName($category1, $category2).'</p>
					
					<select id="category2" name="category2" class="form-control" >
				</select>
				<div id="category2_validate" class="form-control-feedback"></div>
			</div>
			
			<div class="form-group">
					<label for="email" class="form-label text-muted">Email:</label>
					<input value="'.$email.'" type="hidden"  id="email_hidden" name="email_hidden"></input>
					<p type="text" value="'.$email.'" id="email" name="email" class="form-control-static" > '.$email.'</p>
					<div id="email_validate" class="form-control-feedback"></div>
			</div>
			
			<div class="form-group">
					<label for="phone" class="form-label text-muted">Phone:</label>
					<input value="'.$phone.'" type="hidden"  id="phone_hidden" name="phone_hidden"></input>
					<p type="text" value="'.$phone.'" id="phone" name="phone" class="form-control-static" > '.$phone.'</p>
					<div id="phone_validate" class="form-control-feedback"></div>
			</div>
			
			<div class="form-group">
					<label for="mobile" class="form-label text-muted">Mobile:</label>
					<input value="'.$mobile.'" type="hidden"  id="mobile_hidden" name="mobile_hidden"></input>
					<p type="text" value="'.$mobile.'" id="mobile" name="mobile" class="form-control-static" > '.$mobile.'</p>
					<div id="mobile_validate" class="form-control-feedback"></div>
			</div>
			
			<div class="form-group">
					<label for="contact_person" class="form-label text-muted">Contact Person:</label>
					<input value="'.$contact_person.'" type="hidden"  id="contact_person_hidden" name="contact_person_hidden"></input>
					<p type="text" value="'.$contact_person.'" id="contactPerson" name="contactPerson" class="form-control-static" > '.$contact_person.'</p>
					<div id="contactPerson_validate" class="form-control-feedback"></div>
			</div>
			
			<div class="form-group">
					<label for="web" class="form-label text-muted">Web Site:</label>
					<input value="'.$web.'" type="hidden"  id="web_hidden" name="web_hidden"></input>
					<p type="text" value="'.$web.'" id="web" name="web" class="form-control-static" > '.$web.'</p>
			</div>
			
			<div class="form-group">
					<label for="description" class="form-label text-muted">Description:</label>
					<input value="'.$description.'" type="hidden"  id="description_hidden" name="description_hidden"></input>
					<p type="text" value="'.$description.'" id="description_" name="description_" class="form-control-static" > '.$description.'</p>
					<textarea rows="10" name="description" id="description"  class="form-control" >'.$description.'</textarea>
			</div>
			<input value="updatebusiness" type="hidden"  id="action" name="action"></input>
			<input value="'.$business_id.'" type="hidden"  id="business_id" name="business_id"></input>
			<button type="submit" class="btn btn-primary float-right" id="editFormButton">Save</button>
	</form>
	
  </div>
</div>


</div>


<div class="modal fade" id="ChangeCategoryModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Change Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>This change will affect to your business listing. Are you sure want to change the Business Category?</p>
      </div>
      <div class="modal-footer">
        <button onclick="NoChangeCategoryClick();" type="button" class="btn btn-secondary" id="NoChangeCategory">No</button>
		<button type="button" class="btn btn-primary" id="YesChangeCategory" data-dismiss="modal">Yes</button>
      </div>
    </div>
  </div>
</div>
';

$text = $text. '


</div>
  <div class="tab-pane" id="branches" role="tabpanel">
   </br>

  <button class="btn btn-primary" type="button" data-toggle="collapse" id="CollapseBranchSection" data-target="#AddBranchSection" aria-expanded="false" aria-controls="collapseExample">
    + Add Branch
  </button>

	<div class="collapse" id="AddBranchSection">
	  <div class="card card-block">
	  <div id="AddBranchMessage" name="AddBranchMessage">
	  </div>
		<form id="AddBranch" name="AddBranch" accept-charset="utf-8">
						
						
						
			
						<div class="form-check">
						<label class="form-check-label">
						<input type="checkbox" class="form-check-input" id="mainBranch" name="mainBranch">
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
						<input class="form-control" name="mobile" id="mobile" type="tel"/>
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
												
						<input type="hidden" name="action" value="AddBranch"/>
						<input type="hidden"  name="business_id" id="business_id" value="'.$business_id.'"/>
						<p class="text-muted text-center">
							By clicking Add Branch, I agree to the Terms and Conditions of Cinderella
						</p>
						<div class="text-center">
							<a href="" class="btn btn-secondary " role="button" aria-disabled="true" data-toggle="collapse" id="AddBranchCancelButton" name="AddBranchCancelButton" data-target="#AddBranchSection">Cancel</a>
							<button type="submit" class="btn btn-primary" id="AddBranchButton" name="AddBranchButton">Add Branch</button>
						</div>
					</form>
	  </div>
	</div>
   </br>
   
   <div name="BranchSectionDiv" id="BranchSectionDiv">
  ';
  
  
  $Branchses = $Branch->getBranchesByBusinessId($business_id);
  if (is_array($Branchses) || is_object($Branchses))
{
  foreach($Branchses as $key => $value) {
		$branch_id = $value['id'];
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
				<div id="EditSection">   
					<div class ="float-left">'.$district.'</div>
					<div class ="float-right">
					<a id="EditBranch" class ="float-left edit-branch" data-businessid="'.$business_id.'" data-mainbranch="'.$main_branch.'" data-branchid="'.$branch_id.'" data-contactperson="'.$contact_person.'" data-address1="'.$branch_address1.'" data-address2="'.$branch_address2.'" data-address3="'.$branch_address3.'" data-email="'.$branch_email.'" data-mobile="'.$branch_mobile.'" data-phone="'.$branch_phone.'" data-district="'.$district.'"><u> Edit </u></a> 
					';
					if($main_branch != 'YES'){
					$text = $text. '							
							&nbsp &nbsp
							<a id="DeleteBranch" class ="float-right delete-branch" data-toggle="modal" data-target="#DeleteBranchModal" data-branchid="'.$branch_id.'"><u> Delete </u></a>
					';
					}
		$text = $text. '
					</div>
					
				</div>
				
			</div>
			<div class="card-block">
				<div class="form-group row">
					<div class="col-2">
						<img class="img-fluid"  src="../../assets/icons/location.png" alt="Card image cap"> </img>
					</div>
					
					<div class="col-10">
						<p type="text" id="branch_address" name="branch_address" class="form-control-static" > '.$branch_address1.', '.$branch_address2.', '.$branch_address3.'</p>
					</div>
				</div>
				
				<div class="form-group row">
					<div class="col-2">
						<img class="img-fluid"  src="../../assets/icons/person.png" alt="Card image cap"> </img>
					</div>
					<div class="col-6">
						<p type="text" id="contact_person" name="contact_person" class="form-control-static" > '.$contact_person.'</p>
					</div>
				</div>
				
				<div class="form-group row">
					<div class="col-2">
						<img class="img-fluid"  src="../../assets/icons/mail.png" alt="Card image cap"> </img>
					</div>
					<div class="col-6">
						<p type="text" id="branch_email" name="branch_email" class="form-control-static" > '.$branch_email.'</p>
					</div>
				</div>
				
				<div class="form-group row">
					<div class="col-2">
						<img class="img-fluid"  src="../../assets/icons/phone.png" alt="Card image cap"> </img>
					</div>
					<div class="col-6">
						<p type="text" id="branch_mobile" name="branch_mobile" class="form-control-static" > '.$branch_mobile.' '.$branch_phone.'</p>
					</div>
				</div>
			</div>
		</div>
	';
  }
}
  $text = $text. '
  </div>
  
  </div>';

   $text = $text. '
  <div class="tab-pane" id="videos" role="tabpanel">
  <div id="profilecard" class="card">
 <div class="card-header">
 <div class ="float-left">Videos - 2 (youtube)</div>
 <div class ="float-right"><a href="#"  data-toggle="modal" data-target="#EditVideoHelpModal"><u>How to copy youtube link?</a></a></div>
  </div>
  <div class="card-block " >
	  <div id="VideoDiv" class="row" >';


	  $i_ = 0;
	  $j_ = 0;
	  $videos = $Media->getVideos($business_id);
	  if ($videos !== false) {
		  if (is_array($videos) || is_object($videos))
		{
		foreach($videos as $key => $value) {
			$j_ = $i_ + 1;
			if ($value['filename'] != '') {
				$text = $text. '
				<div class="card">
					<div class="card-header">
						<div class ="float-left">Video '.$j_.'</div>
						<div class ="float-right" ><a class="edit-video-link" style="cursor: pointer" data-toggle="modal" data-target="#EditVideoModal" data-id="'.$value['id'].'" data-link="https://www.youtube.com/watch?v='.$value['filename'].'"  > <u>Update</u></a></div>
					</div>
					<div class="card-block">
						<iframe width="300" height="200" class="col-12" src="http://www.youtube.com/embed/'.$value['filename'].'" frameborder="0" allowfullscreen></iframe>
					</div>
				</div>';
				
				
			} else {
				$text = $text.'
				<div class="card">
					<div class="card-header">
						<div class ="float-left">Video'.$j_.'</div>
						<div class ="float-right" ><a class="edit-video-link" style="cursor: pointer" data-toggle="modal" data-id="'.$value['id'].'" data-link="" data-target="#EditVideoModal"> <u>Add</u></a></div>
					</div>
					<div class="card-block">
						<div class="alert alert-warning" role="alert">
							<strong>No Video Link!</strong>
						</div>
					</div>
				</div>
		  	';
			}
			$i_ = $i_ + 1;			
		}
	  }
	  }
	  if ($i_ < 2) {
		  for ($i=$i_; $i < 2; $i++) { 
			  $j_ = $i + 1;
			 $text = $text.'
				<div class="card">
					<div class="card-header">
						<div class ="float-left">Video'.$j_.'</div>
						<div class ="float-right" ><a class="edit-video-link" style="cursor: pointer" data-toggle="modal" data-id="" data-link="" data-target="#EditVideoModal"> <u>Add</u></a></div>
					</div>
					<div class="card-block">
						<div class="alert alert-warning" role="alert">
							<strong>No Video Link!</strong>
						</div>
					</div>
				</div>
		  	';
		  }
	  }
  	


		$text = $text. '
	  </div> 
  </div> 
  <div id="VideoMessage" >
  </div> 

</div>
  </div>
</div>';
$text = $text. '
<!-- Modal -->
<div class="modal fade" id="EditVideoModal" tabindex="-1" role="dialog" aria-labelledby="EditVideoModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Video Link</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  <form id="EditVideoForm">
      <div class="modal-body" id="EditVideoModalBody">
	  <input type="hidden" name="BusinessId" id="BusinessId" value="'.$business_id.'"/>
	  <input type="hidden" name="action" id="action" value="EditVideo"/>
	  <input type="hidden" name="id" id="id"/>
	  Please make sure to add youtube link properly to avoid any issues in terms of loading the video. 
	  <div>
	  <image style="width: 100px; height: 60px" src="../../assets/icons/youtube.png"/> 
	  <input placeholder="https://www.youtube.com/watch?v=96yLr3Vt9JA" style="width: 100%; " type="text" name="link" id="link"/> 
	  </div>
      
      </div>
      <div class="modal-footer">
	  <div id="EditVideoMessage" class="float-left">  </div>
        <button id="CancelEditVideo" type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button id="DoneEditVideo" type="submit" class="btn btn-primary">Update</button>
      </div>
	  </form>
    </div>
  </div>
</div>
';

$text = $text. '
<!-- Modal -->
<div class="modal fade" id="EditVideoHelpModal" tabindex="-1" role="dialog" aria-labelledby="EditVideoHelpModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">How to copy youtube link</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="EditVideoHelpModalBody">
	  <image style="width: 100%; height: 100%" src="../../assets/other/youtubelink.png"/> 
      
      </div>
      <div class="modal-footer">
	  <div id="EditVideoMessage" class="float-left">  </div>
        <button class="btn btn-primary" data-dismiss="modal">Ok</button>
      </div>
	  </form>
    </div>
  </div>
</div>
';

 $text = $text. '
<!-- Modal -->
<div class="modal fade" id="DeleteBranchModal" tabindex="-1" role="dialog" aria-labelledby="DeleteBranchModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  <form id="DeleteBranchForm">
      <div class="modal-body" id="DeleteBranchModalBody">
	  <input type="hidden" name="BusinessId" id="BusinessId" value="'.$business_id.'"/>
	  <input type="hidden" name="BranchId" id="BranchId" value=""/>
	  <input type="hidden" name="action" id="action" value="deletebranch"/>
        Are you sure want to Delete this Branch?
      </div>
      <div class="modal-footer">
	  <div id="BranchDeleteMessage" class="float-left">  </div>
        <button id="CancelBranchDelete" type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button id="DoneBranchDelete" type="submit" class="btn btn-primary">Delete</button>
      </div>
	  </form>
    </div>
  </div>
</div>
';

//edit branch
$text = $text.

'
<!-- Modal -->
<div class="modal fade" id="EditBranchModal" tabindex="-1" role="dialog" aria-labelledby="EditBranchModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="EditBranchLabel">Edit Branch</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  
	  
	  <form id="EditBranchForm" name="EditBranchForm">
     <div class="modal-body" id="EditBranchModalBody">
	 <div id="EditBranchWaitMessage" class="float-left">  </div>
	 <br/>
	  <input type="hidden" name="BranchId" id="BranchId" value=""/>
	  <input type="hidden" name="BusinessId" id="BusinessId" value=""/>
	  <input type="hidden" name="editMainBranchOld" id="editMainBranchOld" value=""/>
	  <input type="hidden" name="action" id="action" value="EditBranch"/>
						<div class="form-check">
							<label class="form-check-label">
							<input type="checkbox" class="form-check-input" id="editMainBranch" name="editMainBranch">
								Main Branch
							</label>
							<div id="editMainBranch_validate" class="form-control-feedback"></div>
						</div>
						
						
						<div class="form-group">
						<label class="form-control-label float-xs-left">Contact Person *</label>
						<input class="form-control" name="editContactPerson" id="editContactPerson"  type="text"/>
						<div id="editContactPerson_validate" class="form-control-feedback"></div>
						</div>
						
						<div class="form-group">
							<label class="form-control-label float-left" >Branch E-Mail *</label>
							<input class="form-control" name="editEmail" id="editEmail" placeholder="youremail@example.com" type="email" />
							<div id="editEmail_validate" class="form-control-feedback"></div>
						</div>
						
						
						<div class="form-group">
						<label class="form-control-label float-xs-left">Branch Mobile *</label>
						<input class="form-control" name="editMobile" id="editMobile" id="mobile" type="tel"/>
						<small class="form-text text-muted float-right">Ex: 0712345678</small>
						<div id="editMobile_validate" class="form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label class="form-control-label float-xs-left">Branch Phone</label>
						<input class="form-control" name="editPhone" id="editPhone" type="tel"/>
						<small class="form-text text-muted float-right">Ex: 0112345678</small>
						<div id="editPhone_validate" class="form-control-feedback"></div>
						</div>
						
						<div class="form-group">
						<label class="form-control-label float-xs-left">Address *</label>
						<input class="form-control" name="editAddress1" id="editAddress1" type="text"/>
						<div id="editAddress1_validate" class="form-control-feedback"></div>
						<small class="form-text text-muted float-right">Ex: No: 49/6/A</small>
						</div>
						
						<div class="form-group">
						<label class="form-control-label float-xs-left">Street *</label>
						<input class="form-control" name="editAddress2" id="editAddress2" type="text"/>
						<div id="editAddress2_validate" class="form-control-feedback"></div>
						<small class="form-text text-muted float-right">Ex: Temple Road</small>
						</div>
						
						<div class="form-group">
						<label class="form-control-label float-xs-left">City *</label>
						<input class="form-control"  name="editAddress3" id="editAddress3" type="text"/>
						<div id="editAddress3_validate" class="form-control-feedback"></div>
						<small class="form-text text-muted float-right">Ex: Maharagama</small>
						</div>
						
						<div class="form-group">
						<label class="form-control-label float-xs-left">District *</label>
						<select class="form-control" name="editDistrict" id="editDistrict">
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
						<div id="editDistrict_validate" class="form-control-feedback"></div>
						</div>
	  
      </div>
      <div class="modal-footer">
        <button id="CancelEditBranch" type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button id="DoneEditBranch" type="submit" class="btn btn-primary">Save</button>
      </div>
	  </form>
    </div>
  </div>
</div>


';
$text = $text. '

<div class="modal fade" id="RequestDone" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Successful</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<strong>Your request has been successfully completed.</strong> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>
</div>

';
//profile image
/*
$text = $text .' </br>
<div id="profilecard" class="card">
 <div class="card-header">
 <div class ="float-left">Videos - 2 (youtube)</div>
 <div class ="float-right" ><a> <u>Edit</u></a></div>
  </div>
  <div class="card-block " >
	  <div id="VideoDiv" class="row" >
		<iframe class="col-6" src="http://www.youtube.com/embed/W7qWa52k-nE" frameborder="0" allowfullscreen></iframe>
		<iframe class="col-6" src="http://www.youtube.com/embed/W7qWa52k-nE" frameborder="0" allowfullscreen></iframe>
	  </div> 
  </div> 
  <div id="ProfileImageMessage" >
  '.$Media->getMediaStatusMessage($business_id, "PROFILE", "IMAGE").'
  </div> 

</div>';
*/
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
			catch (DatabaseError $e) {
				ErrorCode::SetError(ErrorCode::ERROR_GENERAL);
				return;
			}	
			catch (Exception $e) {
				ErrorCode::SetError(ErrorCode::ERROR_GENERAL);
				return;
			}	
		}
		else if ($_POST['action'] === 'deletebranch') {
			try {
				$status ="";
				$status = $Branch->deleteBranch($_POST['BusinessId'], $_POST['BranchId']);
				if($status == '200'){
					echo "CINDERELLA_OK";
				}
				else if($status == '1'){
					ErrorCode::SetError(ErrorCode::ERROR_GENERAL);
				}
			}
			catch (DatabaseError $e) {
				ErrorCode::SetError(ErrorCode::ERROR_GENERAL);
				return;
			}	
			catch (Exception $e) {
				ErrorCode::SetError(ErrorCode::ERROR_GENERAL);
				return;
			}	
		}
		else if ($_POST['action'] === 'AddBranch') {
			try {
				if(isset($_POST['mainBranch']) and $_POST['mainBranch'] == 'on'){
					$other['main_branch'] = 'YES';
				}
				else{
					$other['main_branch'] = 'NO';
				}
				
				if(isset($_POST['contactPerson']) and $_POST['contactPerson'] != ''){
					$other['contact_person'] = $_POST['contactPerson'];
				}
				else{
					ErrorCode::SetError(ErrorCode::REQUIRED_BRANCH_CONTACT_PERSON);
					return;
				}
				if(isset($_POST['email']) and $_POST['email'] != ''){
					$other['email'] = $_POST['email'];
				}
				else{
					ErrorCode::SetError(ErrorCode::REQUIRED_EMAIL);
					return;
				}
				if(isset($_POST['district']) and $_POST['district'] != ''){
					$other['district'] = $_POST['district'];
				}
				else{
					ErrorCode::SetError(ErrorCode::REQUIRED_DISTRICT);
					return;
				}
				if(isset($_POST['address1']) and $_POST['address1'] != ''){
					$other['address1'] = $_POST['address1'];
				}
				else{
					ErrorCode::SetError(ErrorCode::REQUIRED_MERCHANT_BRANCH_ADDRESS);
					return;
				}
				if(isset($_POST['address2']) and $_POST['address2'] != ''){
					$other['address2'] = $_POST['address2'];
				}
				else{
					ErrorCode::SetError(ErrorCode::REQUIRED_MERCHANT_BRANCH_ADDRESS);
					return;
				}
				if(isset($_POST['address3']) and $_POST['address3'] != ''){
					$other['address3'] = $_POST['address3'];
				}
				else{
					ErrorCode::SetError(ErrorCode::REQUIRED_MERCHANT_BRANCH_ADDRESS);
					return;
				}
				if(isset($_POST['mobile']) and $_POST['mobile'] != null){
					$other['branch_mobile'] = $_POST['mobile'];
				}
				else{
					ErrorCode::SetError(ErrorCode::REQUIRED_MOBILE);
					return;
				}
				if(isset($_POST['phone']) and $_POST['phone'] != null){
					$other['branch_phone'] = $_POST['phone'];
				}				
				$status ="";
				$status = $Branch->addBranch($_POST['business_id'], $other);
				if($status == '200'){
					echo "CINDERELLA_OK";
				}
				else if($status == '1'){
					ErrorCode::SetError(ErrorCode::ERROR_GENERAL);
					return;
				}
			}
			catch (DatabaseError $e) {
				ErrorCode::SetError(ErrorCode::ERROR_GENERAL);
				return;
			}	
			catch (Exception $e) {
				ErrorCode::SetError(ErrorCode::ERROR_GENERAL);
				return;
			}	
		}
		else if ($_POST['action'] === 'EditBranch') {
			try {
			if( (isset($_POST['editMainBranch']) and $_POST['editMainBranch'] == 'on') or (isset($_POST['editMainBranch']) == false and $_POST['editMainBranchOld'] == 'YES') or ($_POST['editMainBranch'] == 'on' and $_POST['editMainBranchOld'] == 'NO')){
					$other['main_branch'] = 'YES';
				}
				else{
					$other['main_branch'] = 'NO';
				}
				
				if(isset($_POST['editContactPerson']) and $_POST['editContactPerson'] != ''){
					$other['contact_person'] = $_POST['editContactPerson'];
				}
				else{
					ErrorCode::SetError(ErrorCode::REQUIRED_BRANCH_CONTACT_PERSON);
					return;
				}
				if(isset($_POST['editEmail']) and $_POST['editEmail'] != ''){
					$other['email'] = $_POST['editEmail'];
				}
				else{
					ErrorCode::SetError(ErrorCode::REQUIRED_EMAIL);
					return;
				}
				if(isset($_POST['editDistrict']) and $_POST['editDistrict'] != ''){
					$other['district'] = $_POST['editDistrict'];
				}
				else{
					ErrorCode::SetError(ErrorCode::REQUIRED_DISTRICT);
					return;
				}
				if(isset($_POST['editAddress1']) and $_POST['editAddress1'] != ''){
					$other['address1'] = $_POST['editAddress1'];
				}
				else{
					ErrorCode::SetError(ErrorCode::REQUIRED_MERCHANT_BRANCH_ADDRESS);
					return;
				}
				if(isset($_POST['editAddress2']) and $_POST['editAddress2'] != ''){
					$other['address2'] = $_POST['editAddress2'];
				}
				else{
					ErrorCode::SetError(ErrorCode::REQUIRED_MERCHANT_BRANCH_ADDRESS);
					return;
				}
				if(isset($_POST['editAddress3']) and $_POST['editAddress3'] != ''){
					$other['address3'] = $_POST['editAddress3'];
				}
				else{
					ErrorCode::SetError(ErrorCode::REQUIRED_MERCHANT_BRANCH_ADDRESS);
					return;
				}
				if(isset($_POST['editMobile'])){
					$other['branch_mobile'] = $_POST['editMobile'];
				}
				else{
					ErrorCode::SetError(ErrorCode::REQUIRED_MOBILE);
					return;
				}
				if(isset($_POST['editPhone'])){
					$other['branch_phone'] = $_POST['editPhone'];
				}				
				$status ="";
				$edit_branch_id = $_POST['BranchId'];
				$status = $Branch->updateBranch($_POST['BusinessId'], $edit_branch_id, $other);
				
				if($status == '200'){
					echo "CINDERELLA_OK";
					return;
				}
				else if($status == '1'){
					ErrorCode::SetError(ErrorCode::ERROR_GENERAL);
					return;
				}
			}
			catch (DatabaseError $e) {
				ErrorCode::SetError(ErrorCode::ERROR_GENERAL);
				return;
			}	
			catch (Exception $e) {
				ErrorCode::SetError(ErrorCode::ERROR_GENERAL);
				return;
			}	
		}
		else if ($_POST['action'] === 'profile') {
			try {
				$business_id = $_POST['business_id'];
				if($_POST['image-data'] == ''){
					ErrorCode::SetError(ErrorCode::MEDIA_NO_FILE);
					return;
				}
				$encoded = $_POST['image-data'];
				 
				$exp = explode(',', $encoded);
				$data = base64_decode($exp[1]);
				
				$mime_type = finfo_buffer(finfo_open(), $data, FILEINFO_MIME_TYPE);
				$mime_type_arr = explode('/', $mime_type);
				
				$mime_type = $mime_type_arr[1];				
				$filename = $business_id.'.'.$mime_type;
				
				$status = $Media->UpdateMedia($business_id, 'PROFILE', 'IMAGE', $filename, $mime_type, $data);
				if($status == '200'){
					echo "CINDERELLA_OK^".$filename.'^';
				}
				else if($status == '1'){
					ErrorCode::SetError(ErrorCode::MEDIA_MIME_TYPES);
				}
				return;
			}
			catch (TooManyRequestsException $e) {
				ErrorCode::SetError(ErrorCode::TOO_MANY_REQUESTS);
				return;
			}
			catch (Exception $e) {
				ErrorCode::SetError(ErrorCode::ERROR_GENERAL);
				return;
			}	
		}
		else if ($_POST['action'] === 'updatebusiness') {
			
			$UpdatedValues;
			$updatedfields = array();
			$approve = null;
			if(isset($_POST['businessName']) == false or (isset($_POST['businessName']) and $_POST['businessName'] == '')){
				ErrorCode::SetError(ErrorCode::REQUIRED_BUSINESS_NAME);
			}
			
			if(isset($_POST['category1']) == false or (isset($_POST['category1']) and $_POST['category1'] == '')){
				ErrorCode::SetError(ErrorCode::REQUIRED_CATEGORY);
			}
			
			if(isset($_POST['category2']) == false or (isset($_POST['category2']) and $_POST['category2'] == '')){
				ErrorCode::SetError(ErrorCode::REQUIRED_CATEGORY);
			}
			
			if(isset($_POST['email']) == false or (isset($_POST['email']) and $_POST['email'] == '')){
				ErrorCode::SetError(ErrorCode::REQUIRED_EMAIL);
			}
			
			if(isset($_POST['mobile']) == false or (isset($_POST['mobile']) and $_POST['mobile'] == '')){
				ErrorCode::SetError(ErrorCode::REQUIRED_MOBILE);
			}
			
			if(isset($_POST['contactPerson']) == false or (isset($_POST['contactPerson']) and $_POST['contactPerson'] == '')){
				ErrorCode::SetError(ErrorCode::REQUIRED_CONTACT_PERSON);
			}
			
			$UpdatedValues['businessName'] = $_POST['businessName'];
			$UpdatedValues['category1'] = $_POST['category1'];
			$UpdatedValues['category2'] = $_POST['category2'];
			$UpdatedValues['email'] = $_POST['email'];
			$UpdatedValues['phone'] = $_POST['phone'];
			$UpdatedValues['mobile'] = $_POST['mobile'];
			$UpdatedValues['contactPerson'] = $_POST['contactPerson'];
			$UpdatedValues['description'] = $_POST['description'];
			
			if($_POST['web'] == ' '){
				$UpdatedValues['web'] = '';
			}
			else{
				$UpdatedValues['web'] = $_POST['web'];
			}
			
			if(isset($_POST['businessName'])and isset($_POST['business_name_hidden']) and $_POST['businessName'] != $_POST['business_name_hidden']){				
				array_push($updatedfields, 'business_name');
				$approve = '0';
			}
			if(isset($_POST['category1']) and isset($_POST['category1_hidden']) and $_POST['category1'] != $_POST['category1_hidden']){				
				array_push($updatedfields, 'category1');
			}
			if(isset($_POST['category2']) and isset($_POST['category2_hidden']) and $_POST['category2'] != $_POST['category2_hidden']){				
				array_push($updatedfields, 'category2');
			}
			if(isset($_POST['email']) and isset($_POST['email_hidden']) and $_POST['email'] != $_POST['email_hidden']){				
				array_push($updatedfields, 'business_email');
			}
			if(isset($_POST['phone']) and isset($_POST['phone_hidden']) and $_POST['phone'] != $_POST['phone_hidden']){				
				array_push($updatedfields, 'business_phone');
			}
			if(isset($_POST['mobile']) and isset($_POST['mobile_hidden']) and $_POST['mobile'] != $_POST['mobile_hidden']){				
				array_push($updatedfields, 'business_mobile');
			}
			if(isset($_POST['contactPerson']) and isset($_POST['contact_person_hidden']) and $_POST['contactPerson'] != $_POST['contact_person_hidden']){				
				array_push($updatedfields, 'contact_person');
				$approve = '0';
			}
			if(isset($_POST['description']) and isset($_POST['description_hidden']) and $_POST['description'] != $_POST['description_hidden']){				
				array_push($updatedfields, 'description');
				$approve = '0';
			}
			if(isset($_POST['web']) and isset($_POST['web_hidden']) and $_POST['web'] != $_POST['web_hidden']){				
				array_push($updatedfields, 'website');
				$approve = '0';
			}
			
			$status = $Business->updateBusiness($_POST['business_id'], $UpdatedValues, $updatedfields, $approve);
			if($status == '200'){
				echo "CINDERELLA_OK";
			}
			else if($status == '1'){
				ErrorCode::SetError(ErrorCode::ERROR_GENERAL);
			}
			return;
		}		
		else if ($_POST['action'] === 'banner') {
			try {
				$business_id = $_POST['business_id'];
				$imageindex = $_POST['imageindex'];
				if($_POST['image-data'] == ''){
					ErrorCode::SetError(ErrorCode::MEDIA_NO_FILE);
					return;
				}
				$encoded = $_POST['image-data'];
				 
				$exp = explode(',', $encoded);
				$data = base64_decode($exp[1]);
				
				$mime_type = finfo_buffer(finfo_open(), $data, FILEINFO_MIME_TYPE);
				$mime_type_arr = explode('/', $mime_type);
				
				$mime_type = $mime_type_arr[1];				
				$filename = $business_id.'_'.$imageindex.'.'.$mime_type;
				
				$status = $Media->UpdateMedia($business_id, 'BANNER', 'IMAGE', $filename, $mime_type, $data);
				if($status == '200'){
					echo "CINDERELLA_OK^".$filename.'^'.$imageindex.'^';
				}
				else if($status == '1'){
					ErrorCode::SetError(ErrorCode::MEDIA_MIME_TYPES);
				}
				return;
			}
			catch (TooManyRequestsException $e) {
				ErrorCode::SetError(ErrorCode::TOO_MANY_REQUESTS);
			}	
			catch (InvalidEmailException $e) {
				ErrorCode::SetError(ErrorCode::LOGIN_EMAIL_WRONG);
				return;
			}
			catch (Exception $e) {
				ErrorCode::SetError(ErrorCode::ERROR_GENERAL);
				return;
			}	
		}
		else if ($_POST['action'] == 'EditVideo') {
			try {
				$business_id = $_POST['BusinessId'];
				$link = $_POST['link'];	
				$id = $_POST['id'];	
				if ($id == '') {
					$id = null;
				}			
				
				$status = $Media->UpdateVideo($business_id, $id, $link);
				if($status == '200'){
					echo "CINDERELLA_OK^";
				}
				return;
			}
			catch (TooManyRequestsException $e) {
				ErrorCode::SetError(ErrorCode::TOO_MANY_REQUESTS);
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

$('body').on('click', 'a.edit-video-link', function() {
	 $("#EditVideoModalBody #link").val( $(this).data('link') );
	 $("#EditVideoModalBody #id").val( $(this).data('id') );
});

$('#AddBranchSection').on('shown.bs.collapse', function () {
  $("#BranchSectionDiv").hide();
})

$('#AddBranchSection').on('hide.bs.collapse', function () {
  $("#BranchSectionDiv").show();
})

var request;
$('#EditVideoModal').on('show.bs.modal', function (e) {
  $("#EditVideoMessage").html('');
})

$("#EditVideoForm").submit(function(event){
    event.preventDefault();

    if (request) {
        request.abort();
    }
    var $form = $(this);
    var $inputs = $form.find("input, select, button, textarea");
    var serializedData = $form.serialize();
	$("#CancelEditVideo").hide();
	$("#DoneEditVideo").hide();
	$("#EditVideoMessage").html('<div style="color: blue"><strong>Please Wait!</strong> You request is being processing.<div>');
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
			$('#EditVideoModal').modal('hide');
			$('#RequestDone').modal('show');	
			//window.location = "index.php";
		}
		else{
			$("#EditVideoMessage").html(response);
			$("#CancelEditVideo").show();
			$("#DoneEditVideo").show();
		}
		
		
    });

    request.fail(function (jqXHR, textStatus, errorThrown){
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
		//$('#waitModal').modal('hide');
		$("#EditVideoMessage").html(errorThrown);
		$("#CancelEditVideo").show();
		$("#DoneEditVideo").show();
    });
    request.always(function () {
		//$(this).prop('disabled',false);
    });

});

$('#deleteConfirmation').click(function () {
	$("#DeleteModalBody #BusinessName").val( "<?php echo $business_name; ?>" );
	$("#DeleteModalBody #BusinessId").val( "<?php echo $business_id; ?>" );
	} );

	$('#CollapseBranchSection').click(function () {	
		$('#AddBranch').trigger("reset");
		$("#mainBranch_validate").html('');
		
		$("#AddBranch").validate().resetForm();
	
		$('#AddBranch .form-group').removeClass('has-danger');
		$('#AddBranch .form-group').removeClass('has-success');

		$('#AddBranch .form-control').removeClass('form-control-danger');
		$('#AddBranch .form-control').removeClass('form-control-success');
	} );
	
	$('#AddBranchCancelButton').click(function () {	
		$('#AddBranch').trigger("reset");
		$("#mainBranch_validate").html('');
		
		$("#AddBranch").validate().resetForm();
	
		$('#AddBranch .form-group').removeClass('has-danger');
		$('#AddBranch .form-group').removeClass('has-success');

		$('#AddBranch .form-control').removeClass('form-control-danger');
		$('#AddBranch .form-control').removeClass('form-control-success');	
		
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
	
	$('#editMainBranch').click(function () {
		var alert = '<div class="alert alert-warning" role="alert"> This branch will become the main branch</div>';
		if($("#editMainBranch").is(':checked')){
			$("#editMainBranch_validate").html(alert);
		}
		else{
			$("#editMainBranch_validate	").html('');
		}
		
	} );
	

	
$("#editFormButton").hide();
$("#category1").hide();
$("#category2").hide();
$("#description").hide();

$.ajax({
    type: "POST",
    url: '../controller/GetData.php',
    data: {'action': 'Category1_'},
    dataType:'html',
    success: function(data) {
		$("#category1").empty();
		$("#category1").html(data);
		if(category1 != 'NULL'){
			$("#category1 option[value=<?php echo $category1; ?>]").attr('selected', 'selected').change();
		}
		
    }
	
});

$('#category1').change(function () {
	
	var categoryOldValue = $('#EditBusinessInfo').find('input[name="category1_hidden"]').val();
	var category = $(this).find('option:selected').attr('id');
	
	if(category != categoryOldValue){
		$('#ChangeCategoryModal').modal('show');
	}
	
	$.ajax({
    type: "POST",
    url: '../controller/GetData.php',
    data: {'action': 'Category2_', 'Category1': category},
    dataType:'html',
    success: function(data) {
		$("#category2").empty();
		$("#category2").html(data);
		if(category2 != 'NULL'){
			$("#category2 option[value=<?php echo $category2; ?>]").attr('selected', 'selected').change();
		}
    }
});
	
});	
$('body').on('click', 'a.delete-branch', function() {
   var BranchId = $(this).data('branchid');
   $("#DeleteBranchModalBody #BranchId").val( BranchId );
});

$('body').on('click', 'a.edit-branch', function() {
	
		$('#EditBranchForm').trigger("reset");
		$("#editMainBranch_validate").html('');
		
		$("#EditBranchForm").validate().resetForm();
	
		$('#EditBranchForm .form-group').removeClass('has-danger');
		$('#EditBranchForm .form-group').removeClass('has-success');

		$('#EditBranchForm .form-control').removeClass('form-control-danger');
		$('#EditBranchForm .form-control').removeClass('form-control-success');
		
	var main_branch = "";
	if($(this).data('mainbranch') == "YES"){
		$('#editMainBranch').prop('checked', true);
		$('#editMainBranch').attr('disabled', true);
		$("#EditBranchModalBody #editMainBranchOld").val( 'YES' );
	}
	else{
		$('#editMainBranch').prop('checked', false);
		$('#editMainBranch').attr('disabled', false);
		$("#EditBranchModalBody #editMainBranchOld").val( 'NO' );
	}
   $("#EditBranchModalBody #BranchId").val( $(this).data('branchid') );
   $("#EditBranchModalBody #BusinessId").val( $(this).data('businessid') );   
   $("#EditBranchModalBody #editContactPerson").val( $(this).data('contactperson') );
   $("#EditBranchModalBody #editAddress1").val( $(this).data('address1') );
   $("#EditBranchModalBody #editAddress2").val( $(this).data('address2') );
   $("#EditBranchModalBody #editAddress3").val( $(this).data('address3') );
   $("#EditBranchModalBody #editEmail").val( $(this).data('email') );
   $("#EditBranchModalBody #editMobile").val( $(this).data('mobile') );
   $("#EditBranchModalBody #editPhone").val( $(this).data('phone') );
   $("#EditBranchModalBody #editDistrict").val( $(this).data('district') );
   
   $('#EditBranchModal').modal('show')
});

$('#EditBranchForm').validate({ // initialize the plugin
        rules: {
            editEmail: {
                required: true,
                email: true				
            },
           
			editContactPerson: {
                required: true
            },
			editAddress1:{
				required: true	
			},
			editAddress2:{
				required: true	
			},
			editAddress3:{
				required: true	
			},
			editDistrict:{
				required: true	
			},
			editMobile: {
                required: true,
				digits: true,
				minlength: 10,
				maxlength: 10
            },
			editPhone: {
				digits: true,
				minlength: 10,
				maxlength: 10
            },
        },
		 messages: {
                editEmail: {
                    required: "Please Enter Email!",
                    email: "This is not a valid email!"
                },
				editMobile:{
					minlength: "Enter valid phone number",
					maxlength: "Enter valid phone number",
					digits: "Enter valid phone number"
				},
				editPhone:{
					minlength: "Enter valid phone number",
					maxlength: "Enter valid phone number",
					digits: "Enter valid phone number"
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

$("#EditBranchForm").submit(function(event){
		 event.preventDefault();
	if (!$(this).valid()) {  //<<< I was missing this check
				//grecaptcha.reset();
                return false;
            }
			
    if (request) {
        request.abort();
    }
    var $form = $(this);
    var $inputs = $form.find("input, select, button, textarea");
    var serializedData = $form.serialize();
	$("#CancelEditBranch").hide();
	$("#DoneEditBranch").hide();
	//$("html,body").animate({scrollTop:$('div#branches').offset().top}, 500);
	$("#EditBranchWaitMessage").html('<div style="color: blue"><strong>Please Wait!</strong> You request is being processing.<div>');	
	//$('#waitmodel').modal('show');
	
    request = $.ajax({
        url: "Business.php",
        type: "post",
        data: serializedData
    });
	
    request.done(function (response, textStatus, jqXHR){
        console.log("Logged in "+ response);
		//$('#waitmodel').modal('hide');
		if(response.indexOf('CINDERELLA_OK') > -1)
		{
			$("#EditBranchWaitMessage").html('');
			$('#EditBranchModal').modal('hide');
			$('#RequestDone').modal('show');			
			//window.location = "index.php";
		}
		else{
			$("#CancelEditBranch").show();
			$("#DoneEditBranch").show();
			$("#EditBranchWaitMessage").html(response);	
			//$("html,body").animate({scrollTop:$('div#branches').offset().top}, 500);			
		}		
    });

    request.fail(function (jqXHR, textStatus, errorThrown){
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
		//$('#waitmodel').modal('hide');
		$("#CancelEditBranch").show();
			$("#DoneEditBranch").show();
			$("#EditBranchWaitMessage").html(errorThrown);	;
		//$("html,body").animate({scrollTop:$('div#branches').offset().top}, 500);
    });
    request.always(function () {
		//$(this).prop('disabled',false);
    });

});

$('#RequestDone').on('hidden.bs.modal', function (e) {
  window.location = "index.php";
})
	

/*
$('#DeleteBranch').click(function () {
	var BranchId = $(this).data('branchid');
     $("#DeleteBranchModalBody #BranchId").val( BranchId );
});
*/
$('#AddBranch').validate({ // initialize the plugin
        rules: {
            email: {
                required: true,
                email: true				
            },
           
			contactPerson: {
                required: true
            },
			address1:{
				required: true	
			},
			address2:{
				required: true	
			},
			address3:{
				required: true	
			},
			district:{
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
        },
		 messages: {
                email: {
                    required: "Please Enter Email!",
                    email: "This is not a valid email!"
                },
				mobile:{
					minlength: "Enter valid phone number",
					maxlength: "Enter valid phone number",
					digits: "Enter valid phone number"
				},
				phone:{
					minlength: "Enter valid phone number",
					maxlength: "Enter valid phone number",
					digits: "Enter valid phone number"
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


	
$("#AddBranch").submit(function(event){
		 event.preventDefault();
	if (!$(this).valid()) {  //<<< I was missing this check
				//grecaptcha.reset();
                return false;
            }
			
    if (request) {
        request.abort();
    }
    var $form = $(this);
    var $inputs = $form.find("input, select, button, textarea");
    var serializedData = $form.serialize();
	$("#AddBranchCancelButton").hide();
	$("#AddBranchButton").hide();
	$("html,body").animate({scrollTop:$('div#branches').offset().top}, 500);
	$("#AddBranchMessage").html('<div style="color: blue"><strong>Please Wait!</strong> You request is being processing.<div>');	
	//$('#waitmodel').modal('show');
    request = $.ajax({
        url: "Business.php",
        type: "post",
        data: serializedData
    });
	
    request.done(function (response, textStatus, jqXHR){
        console.log("Logged in "+ response);
		//$('#waitmodel').modal('hide');
		if(response.indexOf('CINDERELLA_OK') > -1)
		{
			$("#AddBranchMessage").html('');
			$('#RequestDone').modal('show');			
			//window.location = "index.php";
		}
		else{
			$("#AddBranchCancelButton").show();
			$("#AddBranchButton").show();
			$("#AddBranchMessage").html(response);	
			$("html,body").animate({scrollTop:$('div#branches').offset().top}, 500);			
		}		
    });

    request.fail(function (jqXHR, textStatus, errorThrown){
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
		//$('#waitmodel').modal('hide');
		$("#AddBranchCancelButton").show();
		$("#AddBranchButton").show();
		$("#AddBranchMessage").html(errorThrown);
		$("html,body").animate({scrollTop:$('div#branches').offset().top}, 500);
    });
    request.always(function () {
		//$(this).prop('disabled',false);
    });

});



$("#DeleteBranchForm").submit(function(event){
    event.preventDefault();

    if (request) {
        request.abort();
    }
    var $form = $(this);
    var $inputs = $form.find("input, select, button, textarea");
    var serializedData = $form.serialize();
	$("#CancelBranchDelete").hide();
	$("#DoneBranchDelete").hide();
	$("#BranchDeleteMessage").html('<div style="color: blue"><strong>Please Wait!</strong> You request is being processing.<div>');
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
			$('#DeleteBranchModal').modal('hide');	
			$('#RequestDone').modal('show');	
			//window.location = "index.php";
		}
		else{
			$("#BranchDeleteMessage").html(response);
			$("#CancelBranchDelete").show();
			$("#DoneBranchDelete").show();			
		}		
    });

    request.fail(function (jqXHR, textStatus, errorThrown){
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
		//$('#waitModal').modal('hide');
		$("#BranchDeleteMessage").html(errorThrown);
		$("#CancelBranchDelete").show();
		$("#DoneBranchDelete").show();
    });
    request.always(function () {
		//$(this).prop('disabled',false);
    });

});





$('#EditBusinessInfo').validate({ // initialize the plugin
        rules: {
            email: {
                required: true,
                email: true				
            },
           
		  contactPerson: {
                required: true
            },
			category1:{
				required: true	
			},
			category2:{
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

$("#EditBusinessInfo").submit(function(event){
    event.preventDefault();
		if (!$(this).valid()) { 
		//grecaptcha.reset();
                return false;
            }
	if (request) {
        request.abort();
    }
    var $form = $(this);
    var $inputs = $form.find("input, select, button, textarea");
    var serializedData = $form.serialize();
	
	
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
			$('#RequestDone').modal('show');	
			//window.location = "index.php";
			//$("#EditBusinessInfoDiv").hide().fadeIn('fast'); 
		}
		else{
			//$("#Message").html(response);
			//$("#CancelDelete").show();
			//$("#DoneDelete").show();
			$("#EditBusinessInfoMessage").html(response);
			$("html,body").animate({scrollTop:$('div#mainarea').offset().top}, 500);
		}
		
		
    });

    request.fail(function (jqXHR, textStatus, errorThrown){
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
		//$('#waitModal').modal('hide');
		//$("#CancelDelete").show();
		//$("#DoneDelete").show();
    });
    request.always(function () {
		//$(this).prop('disabled',false);
    });
	

});
	


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
			$('#DeleteModal').modal('hide');
			$('#RequestDone').modal('show');	
			//window.location = "index.php";
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


$('#UpdateImage1').click(function () {
	var imageindex = $(this).data('id');
     $(".modal-body #imageindex").val( imageindex );
});

$('#UpdateImage2').click(function () {
	var imageindex = $(this).data('id');
    $(".modal-body #imageindex").val( imageindex );
});

$('#UpdateImage3').click(function () {
	var imageindex = $(this).data('id');
    $(".modal-body #imageindex").val( imageindex );
});
//pro
	$(function() {
        $('.image-editor-profile').cropit({
		  $preview: $(".cropit-preview-profile"),
		  $fileInput: $("input.cropit-image-input-profile"),
		  smallImage: 'stretch',
		  allowDragNDrop: true,
		 //cropit-image-input
		  onFileReaderError: function() {
			$("#ProfileImageInfo").html(''); 
			   $("#UpdateProfileModalMessage").html('<div class="alert alert-danger" role="alert" >Please attach an image file. (.png, .gif, .jpeg, .jpg)</div>');            			
        },
		onImageError: function(e) {
			 $("#ProfileImageInfo").html(''); 
            if (e.code === 0) {
                $("#UpdateProfileModalMessage").html('<div class="alert alert-danger" role="alert" >Please attach an image file. (.png, .gif, .jpeg, .jpg)</div>');
            }
			else if (e.code === 1) {
                $("#UpdateProfileModalMessage").html('<div class="alert alert-danger" role="alert" >Image is too small.</div>');
            }
		},
		onFileChange: function() {
			   $("#UpdateProfileModalMessage").html('');            			
        },
		onImageLoaded: function() {
			$(this).prop('disabled',false);
			   $("#ProfileImageInfo").html('Resize and adjust the image as needed');   
				$("#UpdateProfileModalMessage").html('');	
				
        },
		onImageLoading: function() {
			$(this).prop('disabled',true);
			   $("#UpdateProfileModalMessage").html('<div class="alert alert-info" role="alert" >Image is loading...</div>');         			
        }
		});
		
		$('.select-image-profile-btn').click(function() {
		  $('.cropit-image-input-profile').click();
		});


		$('.rotate-profile-cw').click(function() {
          $('.image-editor-profile').cropit('rotateCW');
        });
        $('.rotate-profile-ccw').click(function() {
          $('.image-editor-profile').cropit('rotateCCW');
        });
   	

        $('#UpdateProfileModalForm').submit(function() {
			event.preventDefault();
          // Move cropped image data to hidden input
          var imageData = $('.image-editor-profile').cropit('export');
		
		  if(imageData == ""){
			  return false;
		  }
          $('.hidden-image-data-profile').val(imageData);

          // Print HTTP request params
          var formValue = $(this).serialize();

		  $(this).prop('disabled',true);
		  $("#UpdateProfileModalMessage").html('<div class="alert alert-info" role="alert" >Please wait....</div>');   
			request = $.ajax({
				url: "Business.php",
				type: "post",
				data: formValue
			});
			
			request.done(function (response, textStatus, jqXHR){
				console.log("Logged in "+ response);
				var responseString = response.split('^');
				if(responseString[0] == 'CINDERELLA_OK')
				{
					$("#UpdateProfileModalMessage").html('');
					var d = new Date(); 
					document.getElementById("ProfileImage").src = "images/profile/"+responseString[1]+"?ver=" + d.getTime();
					$("#profilecard").hide().fadeIn('fast');
					$('#UpdateProfileModal').modal('hide');		
					$("#ProfileImageMessage").html('<div class="alert alert-warning" role="alert"><strong> Profile Image is not approved yet</strong>. It will display to the users once it get approved</div>');  
				}
				else{
					$(this).prop('disabled',false);
					$("#UpdateProfileModalMessage").html(response);
					//$("#UpdateProfileModal").hide();	
				}
				
				
				
			});

			request.fail(function (jqXHR, textStatus, errorThrown){
				console.error(
					"The following error occurred: "+
					textStatus, errorThrown
				);
				$("#UpdateProfileModalMessage").html('');  
				$(this).prop('disabled',false);
				$("#UpdateProfileModalMessage").html(errorThrown);				
				$("#UpdateProfileModal").show();
			});
			request.always(function () {
				//$(this).prop('disabled',false);
			});
        });
		
		
		
		$('.image-editor-banner').cropit({
		  $preview: $(".cropit-preview-banner"),
		  $fileInput: $("input.cropit-image-input-banner"),
		  smallImage: 'stretch',
		  allowDragNDrop: true,
		  onFileReaderError: function() {
			$("#BannerImageInfo").html(''); 
			   $("#UpdateBannerModalMessage").html('<div class="alert alert-danger" role="alert" >Please attach an image file. (.png, .gif, .jpeg, .jpg)</div>');            			
        },
		onImageError: function(e) {
			 $("#BannerImageInfo").html(''); 
            if (e.code === 0) {
                $("#UpdateBannerModalMessage").html('<div class="alert alert-danger" role="alert" >Please attach an image file. (.png, .gif, .jpeg, .jpg)</div>');
            }
			else if (e.code === 1) {
                $("#UpdateBannerModalMessage").html('<div class="alert alert-danger" role="alert" >Image is too small.</div>');
            }
		},
		onFileChange: function() {
			   $("#UpdateBannerModalMessage").html('');            			
        },
		onImageLoaded: function() {
			$(this).prop('disabled',false);
			   $("#BannerImageInfo").html('Resize and adjust the image as needed');   
				$("#UpdateBannerModalMessage").html('');	
				
        },
		onImageLoading: function() {
			$(this).prop('disabled',true);
			   $("#UpdateBannerModalMessage").html('<div class="alert alert-info" role="alert" >Image is loading...</div>');         			
        }
		});
		
		$('.select-image-banner-btn').click(function() {
		  $('.cropit-image-input-banner').click();
		});

		$('.rotate-banner-cw').click(function() {
          $('.image-editor-banner').cropit('rotateCW');
        });
        $('.rotate-banner-ccw').click(function() {
          $('.image-editor-banner').cropit('rotateCCW');
        });
		
		 $('#UpdateBannerModalForm').submit(function() {
			event.preventDefault();
          // Move cropped image data to hidden input
          var imageData = $('.image-editor-banner').cropit('export');
		
		  if(imageData == ""){
			  return false;
		  }
          $('.hidden-image-data-banner').val(imageData);

          // Print HTTP request params
          var formValue = $(this).serialize();

		  $(this).prop('disabled',true);
		  $("#UpdateBannerModalMessage").html('<div class="alert alert-info" role="alert" >Please wait....</div>');   
			request = $.ajax({
				url: "Business.php",
				type: "post",
				data: formValue
			});
			
			request.done(function (response, textStatus, jqXHR){
				console.log("Logged in "+ response);
				var responseString = response.split('^');
				if(responseString[0] == 'CINDERELLA_OK')
				{
					$("#UpdateBannerModalMessage").html('');  
					var d = new Date(); 
					if(responseString[2] == '1'){
						document.getElementById("BannerImage1").src = "images/banner/"+responseString[1]+"?ver=" + d.getTime();
						$("#BannerImage1Message").html('<div class="alert alert-warning" role="alert"><strong> This Image is not approved yet</strong>. It will display to the users once it get approved</div>');  
					}
					else if(responseString[2] == '2'){
						document.getElementById("BannerImage2").src = "images/banner/"+responseString[1]+"?ver=" + d.getTime();
						$("#BannerImage2Message").html('<div class="alert alert-warning" role="alert"><strong> This Image is not approved yet</strong>. It will display to the users once it get approved</div>');  
					}
					else if(responseString[2] == '3'){
						document.getElementById("BannerImage3").src = "images/banner/"+responseString[1]+"?ver=" + d.getTime();
						$("#BannerImage3Message").html('<div class="alert alert-warning" role="alert"><strong> This Image is not approved yet</strong>. It will display to the users once it get approved</div>');  
					}
					
					$("#profilecard").hide().fadeIn('fast');
					$('#UpdateBannerModal').modal('hide');		
				}
				else{
					$(this).prop('disabled',false);
					$("#UpdateBannerModalMessage").html(response);
					//$("#UpdateProfileModal").hide();	
				}
				
				
				
			});

			request.fail(function (jqXHR, textStatus, errorThrown){
				console.error(
					"The following error occurred: "+
					textStatus, errorThrown
				);
				$("#UpdateBannerModalMessage").html('');  
				$(this).prop('disabled',false);
				$("#UpdateBannerModalMessage").html(errorThrown);
				$("#UpdateBannerModal").show();
			});
			request.always(function () {
				//$(this).prop('disabled',false);
			});
        });
		
		

});  

} );
function editonclick(){
	$("#EditBusinessInfo").validate().resetForm();
	
	$('#EditBusinessInfo .form-group').removeClass('has-danger');
	$('#EditBusinessInfo .form-group').removeClass('has-success');

	$('#EditBusinessInfo .form-control').removeClass('form-control-danger');
	$('#EditBusinessInfo .form-control').removeClass('form-control-success');	
	
	 

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
			$("#editFormButton").show();
			$("#category1_").hide();
			$("#category2_").hide();
			$("#description_").hide();
			$("#category1").show();
			$("#category2").show();
			$("#description").show();
			$("#category1 option[value='<?php echo $category1; ?>']").attr('selected', 'selected').change();
			$("#category2 option[value='<?php echo $category2; ?>']").attr('selected', 'selected').change();
			$('#mainarea').find('p').each(function(){
			
				attr = "";
				  $.each(this.attributes, function() {
					// this.attributes is not a plain object, but an array
					// of attribute nodes, which contain both the name and value
					if(this.specified) {
						if((this.name == "type" & this.value == "hidden") || (this.name == "id" & this.value == "category1") || (this.name == "id" & this.value == "category2") || (this.name == "id" & this.value == "description")){
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
			$("#editFormButton").hide();
			$("#category1_").show();
			$("#category2_").show();
			$("#category1").hide();
			$("#category2").hide();
			$("#description_").show();
			$("#description").hide();
			
			var category = $('#EditBusinessInfo').find('input[name="category1_hidden"]').val();
			$('#category1 option[value='+category+']').prop('selected', true);
			
			var category2 = $('#EditBusinessInfo').find('input[name="category2_hidden"]').val();
			$('#category2 option[value='+category2+']').prop('selected', true);
			
			
			$('#mainarea').find(':input').each(function(){			
				attr = "";
				  $.each(this.attributes, function() {
					// this.attributes is not a plain object, but an array
					// of attribute nodes, which contain both the name and value
					if(this.specified) {
						if(this.name == "value"){
							OldFieldVale = this.value;
						}
						
						if((this.name == "type" & (this.value == "hidden" || this.value == "submit")) || (this.name == "id" & this.value == "category1") || (this.name == "id" & this.value == "category2")|| (this.name == "id" & this.value == "description") ){
							possible = false;
							return false; 
						}
						else{
							possible = true;						
						}	
						if(possible == true){
							if(this.name == "class" & this.value == "form-control"){
							this.value= "form-control-static"
						}
							attr = attr + ' ' + this.name + ' = "' + this.value + '"';		
						}
							
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
	
function NoChangeCategoryClick(){
	$('#ChangeCategoryModal').modal('hide');
	var category = $('#EditBusinessInfo').find('input[name="category1_hidden"]').val();
	var category2 = $('#EditBusinessInfo').find('input[name="category2_hidden"]').val();
	
	$('#category1 option[value='+category+']').prop('selected', true).change();
	$('#category2 option[value='+category2+']').prop('selected', true).change();
	
}

function editbranchonclick(){
	$('#EditBranchModal').modal('show');
}

</script>