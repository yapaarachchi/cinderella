<?php
require "../../Config.php";
require "../../ErrorCode.php";
require '../../../vendor/autoload.php';


$db = Config::initDb();
$Business = new \Delight\Auth\Business($db);
$Branch = new \Delight\Auth\Branch($db);
$auth = new \Delight\Auth\Auth($db);
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

$branch_address1= null;
$branch_address2= null;
$branch_address3= null;

				if (isset($_POST)) {
					if (isset($_POST['action'])) {
						if ($_POST['action'] === 'info') {
							
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
							
							echo '
							
							
							<div class="card" style="min-height: 300px; width: 100%;">
							  <img class="card-img-top  hidden-md-up" src="../../../assets/ads/8.jpg " style="height: 150px; width: 100%;" alt="Card image cap">
							  <div class="card-block">
								<h4 class="card-title">
									'.$business_name.'
								</h4>
								</br>
								<h6 class="card-subtitle mb-2 text-muted">
									<address><img  src="../../../assets/icons/location.png" alt="Card image cap"> </img>
									'.$branch_address1.','.$branch_address2.','.$branch_address3.'
									</address>
								</h6>
								<p class="card-text">
									<img  src="../../../assets/icons/mail.png" alt="Card image cap"> </img>
									'.$email.'
								</p>
								<p class="card-text">
									<img  src="../../../assets/icons/phone.png" alt="Card image cap"> </img>
									'.$mobile.' '.$mobile.'
								</p>
								<a href="http://'.$web.'" target="_blank" class="card-link"><img  src="../../../assets/icons/web.png" alt="Card image cap"> </img>'.$web.'</a>
							  </div>
							</div>
							';
							return;
						}
						elseif ($_POST['action'] === 'other') {
							
							$business_id = $_POST['business_id'] ;
							$Businesses = $Business->getBusinessById($business_id );
							if (is_array($Businesses) || is_object($Businesses))
							{
								foreach($Businesses as $key => $value) {
									$user_id = $value['user_id'];
								}
							}
							
							$Other_Branches = $Business->getBusinessByUserId($user_id);
							if (is_array($Other_Branches) || is_object($Other_Branches))
							{
								foreach($Other_Branches as $key => $value) {
									if($value['id'] != $business_id){
										echo '<a href="index.php?business='.$value['id'].'" class="card-link">'.$value['business_name'].'</a> </br>';
									}
								}
							}
						
							return;
						}
						elseif ($_POST['action'] === 'description') {
							
							$business_id = $_POST['business_id'] ;
							$Businesses = $Business->getBusinessById($business_id );
							if (is_array($Businesses) || is_object($Businesses))
							{
								foreach($Businesses as $key => $value) {
									
									echo '
									<h6 class="card-subtitle mb-2 text-muted">
										'.$value['description'].'
									</h6>
									';
								}
							}
							
							
						
							return;
						}
				}
}
?>
