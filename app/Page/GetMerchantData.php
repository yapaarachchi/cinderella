<?php
require "../Config.php";
require "../ErrorCode.php";
require '../../vendor/autoload.php';


$db = Config::initDb();
$Business = new \Delight\Auth\Business($db);
$Branch = new \Delight\Auth\Branch($db);
$Category = new \Delight\Auth\Category($db);
$auth = new \Delight\Auth\Auth($db);
$Media = new \Delight\Auth\Media($db);
$isLoggedIn = $auth->isLoggedIn();
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
$user_id;
$text = '';
$branch_address1= null;
$branch_address2= null;
$branch_address3= null;

				if (isset($_POST)) {
					if (isset($_POST['action'])) {
						if ($_POST['action'] === 'header') {
							
							$business_id = $_POST['business_id'] ;
							$Businesses = $Business->getBusinessById($business_id );
							if (is_array($Businesses) || is_object($Businesses))
							{
								foreach($Businesses as $key => $value) {
									$user_id = $value['user_id'];
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
							
							$Branches = $Branch->getMainBranchByBusinessId($business_id );
							if (is_array($Branches) || is_object($Branches))
							{
								foreach($Branches as $key => $value) {
									$branch_address1 = $value['branch_address1'];
									$branch_address2 = $value['branch_address2'];
									$branch_address3 = $value['branch_address3'];
								}
							}
							$MediaProfile = $Media->getProfileImage($business_id, true);
							$MediaCount = $Media->getBannerImagesCount($business_id, true);
							
							$text = '
							<div class="card text-center">
							  <div class="card-header">
								<h2 class="card-title">
									'.$business_name.'
								</h2>
							  </div>
							 </div>
								';
								
								if($MediaCount == 0){
								$text = $text. '
									<div id="MerchantPageBanner" class="carousel slide" data-ride="carousel">
									  <ol class="carousel-indicators">
										<li data-target="#MerchantPageBanner" data-slide-to="0" class="active"></li>
									  </ol>
									  <div class="carousel-inner" role="listbox">
										<div class="carousel-item active">
										  <img src="../Merchant/images/banner/'.$Media->getDefaultBannerImage().'" alt="First slide" class="img-fluid rounded mx-auto d-block" style="height: 100%; width: 100%;">
										</div>
									  </div>
									</div>
								
								';
							}
							else{
								$MediaBanners = $Media->getBannerImages($business_id, true);
								
								$text = $text . '<div id="MerchantPageBanner" class="carousel slide" data-ride="carousel" data-interval="2000">';
								$text = $text . '<ol class="carousel-indicators">';
								if (is_array($MediaBanners) || is_object($MediaBanners))
								{
									$i = 0;
									foreach($MediaBanners as $key => $value) {
										if($i == 0){
											$text = $text . '<li data-target="#MerchantPageBanner" data-slide-to="0" class="active"></li>';
										}
										else{
											$text = $text . '<li data-target="#MerchantPageBanner" data-slide-to="'.$i.'"></li>';
										}
										
										$i = $i + 1;
									}
								}
								$text = $text . '</ol>';
								
								$text = $text . '<div class="carousel-inner" role="listbox">';
								if (is_array($MediaBanners) || is_object($MediaBanners))
								{
									$i = 0;
									foreach($MediaBanners as $key => $value) {										
										if($i == 0){
											$text = $text . '
											<div class="carousel-item active">
											  <img src="../Merchant/images/banner/'.$value['filename'].'?ver='.time().'" alt="First slide" class="img-fluid rounded mx-auto d-block" style="height: 100%; width: 100%;">
											   
											</div>
											';
										}
										else{
											$text = $text . '
											<div class="carousel-item">
											  <img src="../Merchant/images/banner/'.$value['filename'].'?ver='.time().'" alt="First slide" class="img-fluid rounded mx-auto d-block" style="height: 100%; width: 100%;">
											  
											</div>
											';
										}
										
										$i = $i + 1;
									}
								}
								$text = $text . '
									<a class="carousel-control-prev" href="#MerchantPageBanner" role="button" data-slide="prev">
										<span class="carousel-control-prev-icon" aria-hidden="true"></span>
										<span class="sr-only">Previous</span>
									</a>
									<a class="carousel-control-next" href="#MerchantPageBanner" role="button" data-slide="next">
										<span class="carousel-control-next-icon" aria-hidden="true"></span>
										<span class="sr-only">Next</span>
									</a>
								';
								$text = $text . '</div>';
							}
							
							echo $text;
						}
						else if ($_POST['action'] === 'info') {
							
							$business_id = $_POST['business_id'] ;
							$Businesses = $Business->getBusinessById($business_id );
							if (is_array($Businesses) || is_object($Businesses))
							{
								foreach($Businesses as $key => $value) {
									$user_id = $value['user_id'];
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
							
							$Branches = $Branch->getMainBranchByBusinessId($business_id );
							if (is_array($Branches) || is_object($Branches))
							{
								foreach($Branches as $key => $value) {
									$branch_address1 = $value['branch_address1'];
									$branch_address2 = $value['branch_address2'];
									$branch_address3 = $value['branch_address3'];
								}
							}
							
							$MediaProfile = $Media->getProfileImage($business_id, true);
							
							echo '							
							  <div class="card-block" >
								
								<h6 class="card-subtitle mb-2 text-muted">
									<address><img  src="../../assets/icons/location.png" alt="Card image cap"> </img>
									'.$branch_address1.','.$branch_address2.','.$branch_address3.'
									</address>
								</h6>
								<p class="card-text text-muted">
									<img  src="../../assets/icons/mail.png" alt="Card image cap"> </img>
									'.$email.'
								</p>
								<p class="card-text text-muted">
									<img  src="../../assets/icons/phone.png" alt="Card image cap"> </img>
									'.$mobile.' '.$mobile.'
								</p>
								<a href="http://'.$web.'" target="_blank" class="card-link"><img  src="../../assets/icons/web.png" alt="Card image cap"> </img>'.$web.'</a>
								<p class="card-text text-muted">
									<img  src="../../assets/icons/person.png" alt="Card image cap"> </img>
									'.$contact_person.'
								</p>
							  </div>
							';
							return;
						}						
						elseif ($_POST['action'] === 'description') {
							
							$business_id = $_POST['business_id'] ;
							$Businesses = $Business->getBusinessById($business_id );
							if (is_array($Businesses) || is_object($Businesses))
							{
								foreach($Businesses as $key => $value) {
									
									echo '
									<div class="card">
									<div class="card-block">
										<h6 class="card-subtitle mb-2 text-muted">
											'.$value['description'].'
										</h6>								
									</div>
									</div>
									';
								}
							}
							return;
						}
						elseif ($_POST['action'] === 'branches') {
							
							$business_id = $_POST['business_id'] ;
							$Branches = $Branch->getBranchesByBusinessId($business_id );
							$BranchesCount = $Branch->getBrancheCountByBusinessId($business_id);
							$i = 0;
							if (is_array($Branches) || is_object($Branches))
							{
								$text = $text.'<div class="card-deck" >';
								foreach($Branches as $key => $value) {
									
									
									
									$text = $text. '
									
										<div class="card">
											<div class="card-header">
												'.$value['district'].'
											</div>
  
										  <div class="card-block">
											<div class="row">
											
											
											<div class="col-xs-12 text-muted">
											<address>
											<img  src="../../assets/icons/location.png" alt="Card image cap">
											'.$value['branch_address1'].', '.$value['branch_address2'].','.$value['branch_address3'].'</address>
											</div>
											</div>
											
											<div class="row">
											<div class="col-xs-12 text-muted">
											<img  src="../../assets/icons/mail.png" alt="Card image cap">
											'.$value['branch_email'].'
											</div>
											</div>
											
											<div class="row">
											<div class="col-xs-12 text-muted">
											<img  src="../../assets/icons/person.png" alt="Card image cap">
											'.$value['contact_person'].'
											</div>
											</div>
											
											<div class="row">
											<div class="col-xs-12 text-muted">
											<img  src="../../assets/icons/phone.png" alt="Card image cap">
											'.$value['branch_mobile'].' '.$value['branch_phone'].'
											</div>
											</div>
									</div></div>								
									';
									
								}
								$text = $text.'</div>';
							}
							echo $text;
							return;
						}
						elseif ($_POST['action'] === 'OtherBusinesses') {
							$business_id = $_POST['business_id'] ;
							$OtherBusinesses = $Business->getBusinessById($business_id );
							if (is_array($OtherBusinesses) || is_object($OtherBusinesses))
							{
								foreach($OtherBusinesses as $key => $value) {
									$user_id = $value['user_id'];
								}
							}
							$b_count1 = $Business->getBusinessesCount($user_id, true, $business_id);	
							
							
							if($b_count1 > 0){	
								$text = $text.'<div class="card-deck">';							
								$Other_Businesses = $Business->getBusinessByUserId($user_id, true);
								if (is_array($Other_Businesses) || is_object($Other_Businesses))
								{
									foreach($Other_Businesses as $key => $value) {
										if($value['id'] != $business_id){
											$Branches = $Branch->getMainBranchByBusinessId($value['id']);
											if (is_array($Branches) || is_object($Branches))
											{
												foreach($Branches as $key1 => $value1) {
													$branch_address1 = $value1['branch_address1'];
													$branch_address2 = $value1['branch_address2'];
													$branch_address3 = $value1['branch_address3'];
												}
											}
											$text = $text.'
											<div class="card">
												  <img class="card-img-top img-fluid" src="../Merchant/images/profile/'.$Media->getProfileImage($value['id'], true).'" alt="Card image cap">
												  <div class="card-block">
													<h4 class="card-title">'.$value['business_name'].'</h4>
													<div class="row">
													
													
													<div class="col-xs-12 text-muted">
													<address>
													<img  src="../../assets/icons/location.png" alt="Card image cap">
													'.$branch_address1.', '.$branch_address2.','.$branch_address3.'</address>
													</div>
													</div>
													<div class="row">
													<div class="col-xs-12 text-muted">
													<img  src="../../assets/icons/phone.png" alt="Card image cap">
													'.$value['business_mobile'].'
													</div>
													</div>
													
													<div class="row">
													<div class="col-xs-12 text-muted">
													<img  src="../../assets/icons/mail.png" alt="Card image cap">
													'.$value['business_email'].'
													</div>
													</div>
													
												  </div>
												  
														<div class="card-footer text-muted text-center">
															<div id="MoreDetails" style="cursor: pointer" class="btn btn-outline-primary btn-sm btn-block more-detail" data-businessid="'.$value['id'].'">More Details</div>
														</div>
														
												</div>
											
											';		
										}
									}
								}
								$text = $text.'</div>';	
							}
							
							echo $text;
							return;
						}
						elseif ($_POST['action'] === 'Videos') {
							
							$business_id = $_POST['business_id'] ;
							$Videos = $Media->getVideos($business_id, true);
							if (is_array($Videos) || is_object($Videos))
							{
								foreach($Videos as $key => $value) {
									
									echo '
									<iframe width="500" height="300" style="margin: 10px;" src="http://www.youtube.com/embed/'.$value['filename'].'" frameborder="0" allowfullscreen></iframe>
									';
								}
							}
							return;
						}
						elseif ($_POST['action'] === 'SmallDevices') {
							$business_id = $_POST['business_id'] ;
							$Businesses = $Business->getBusinessById($business_id );
							if (is_array($Businesses) || is_object($Businesses))
							{
								foreach($Businesses as $key => $value) {
									$user_id = $value['user_id'];
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
							
							$Branches = $Branch->getMainBranchByBusinessId($business_id );
							if (is_array($Branches) || is_object($Branches))
							{
								foreach($Branches as $key => $value) {
									$branch_address1 = $value['branch_address1'];
									$branch_address2 = $value['branch_address2'];
									$branch_address3 = $value['branch_address3'];
								}
							}
							
							$MediaProfile = $Media->getProfileImage($business_id, true);
							
							$text = $text. '<div class="card" style="height: 100%; width: 100%;">
							<h3 class="card-header">'.$business_name.'</h3>
							  <img class="card-img-top  hidden-md-up" src="../merchant/images/profile/'.$MediaProfile.'" style="height: 100%; width: 100%;" alt="Card image cap">
							  <div class="card-block">
								<h6 class="card-subtitle mb-2 text-muted">
									<address><img  src="../../assets/icons/location.png" alt="Card image cap"> </img>
									'.$branch_address1.','.$branch_address2.','.$branch_address3.'
									</address>
								</h6>
								<p class="card-text text-muted">
									<img  src="../../assets/icons/mail.png" alt="Card image cap"> </img>
									'.$email.'
								</p>
								<p class="card-text text-muted">
									<img  src="../../assets/icons/phone.png" alt="Card image cap"> </img>
									'.$mobile.' '.$mobile.'
								</p>
								<a href="http://'.$web.'" target="_blank" class="card-link"><img  src="../../assets/icons/web.png" alt="Card image cap"> </img>'.$web.'</a>
							  <p class="card-text text-muted">
									<img  src="../../assets/icons/person.png" alt="Card image cap"> </img>
									'.$contact_person.'
								</p>
							  </div>
							</div>';
							
							$text = $text. '
							</br>
							<div id="accordion" role="tablist" aria-multiselectable="true">
  <div class="card">
    <div class="card-header" role="tab" id="headingOne">
      <h5 class="mb-0">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Details
        </a>
      </h5>
    </div>

    <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
      <div class="card-block">
        '.$description.'
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" role="tab" id="headingTwo">
      <h5 class="mb-0">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Branches
        </a>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="card-block">
        ';
		
		
							$AllBranches = $Branch->getBranchesByBusinessId($business_id );
							if (is_array($AllBranches) || is_object($AllBranches))
							{
								foreach($AllBranches as $key => $value) {
									
									
									
									$text = $text. '
									
										<div class="card">
											<div class="card-header">
												'.$value['district'].'
											</div>
  
										  <div class="card-block">
											<div class="row">
											
											
											<div class="col-xs-12 text-muted">
											<address>
											<img  src="../../assets/icons/location.png" alt="Card image cap">
											'.$value['branch_address1'].', '.$value['branch_address2'].','.$value['branch_address3'].'</address>
											</div>
											</div>
											
											<div class="row">
											<div class="col-xs-12 text-muted">
											<img  src="../../assets/icons/mail.png" alt="Card image cap">
											'.$value['branch_email'].'
											</div>
											</div>
											
											<div class="row">
											<div class="col-xs-12 text-muted">
											<img  src="../../assets/icons/person.png" alt="Card image cap">
											'.$value['contact_person'].'
											</div>
											</div>
											
											<div class="row">
											<div class="col-xs-12 text-muted">
											<img  src="../../assets/icons/phone.png" alt="Card image cap">
											'.$value['branch_mobile'].' '.$value['branch_phone'].'
											</div>
											</div>
									</div></div>
									</br>									
									';
									
								}
							}
	$text = $text.'
      </div>
    </div>
  </div>';
	if($Media->getVideoCount($business_id, true) > 0){
	$text = $text.'
  <div class="card">
    <div class="card-header" role="tab" id="headingThree">
      <h5 class="mb-0">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Videos
        </a>
      </h5>
    </div>
    <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree">
      <div class="card-block">';
			
							$Videos = $Media->getVideos($business_id, true);
							if (is_array($Videos) || is_object($Videos))
							{
								foreach($Videos as $key => $value) {
									
									$text = $text.'
									<iframe height="300" src="http://www.youtube.com/embed/'.$value['filename'].'" frameborder="0" allowfullscreen></iframe>
									';
								}
							}

			
		$text = $text.'
		 </div>			
    </div>
  </div>
  ';
	}
						$OtherBusinesses = $Business->getBusinessById($business_id );
							if (is_array($OtherBusinesses) || is_object($OtherBusinesses))
							{
								foreach($OtherBusinesses as $key => $value) {
									$user_id = $value['user_id'];
								}
							}
	$b_count = $Business->getBusinessesCount($user_id, true, $business_id);				
  if($b_count > 0){
  $text = $text.'
  <div class="card">
    <div class="card-header" role="tab" id="headingFour">
      <h5 class="mb-0">
        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
          Other Businesses
        </a>
      </h5>
    </div>
    <div id="collapseFour" class="collapse" role="tabpanel" aria-labelledby="headingFour">
      <div class="card-block">
       ';
							
							
							$Other_Businesses = $Business->getBusinessByUserId($user_id, true);
							if (is_array($Other_Businesses) || is_object($Other_Businesses))
							{
								foreach($Other_Businesses as $key => $value) {
									if($value['id'] != $business_id){							
										$text = $text.'<a style="cursor: pointer"  class="card-link more-detail" data-businessid="'.$value['id'].'"><u>'.$value['business_name'].'</u> </a> </br>';
									}
								}
							}
	   
	   $text = $text.'   
      </div>
    </div>
	';
  }
	
	 $text = $text.' 
  </div>
  
</div>
							
							';
							echo $text;
						}
						
				}
}
?>
