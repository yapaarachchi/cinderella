
<?php
$db = Config::initDb();
$Business = new \Delight\Auth\Business($db);





?>



<div class="list-group">
				  <a href="#" style="font-size: 0.90rem; padding: 0.50rem;" class="list-group-item list-group-item-action" id="Profile">Profile</a>
				  
</div>
</br>

<div class="list-group" id="business-list-group">
<?php
foreach($Business->getBusinessByUserId($auth->getUserId()) as $key => $value) {
?>
 <?php 
 $text = '<a href="#" style="font-size: 0.90rem; padding: 0.50rem;" class="list-group-item list-group-item-action justify-content-between" id="'.$value['id'].'">'.$value['business_name'];
 if($Business->getBusinessStatus($value['id']) == 'NOT_APPROVE'){
	$text = $text. '<span class="badge badge-default badge-pill">!</span>';
 }
 $text = $text. '</a>';
 echo $text;
 ?>
				
<?php
}
?>				  
 
</div>
</br>
<div class="list-group">
				  <a href="#" style="font-size: 0.90rem; padding: 0.50rem;" class="list-group-item list-group-item-action" id="AddBusiness">+ Add Business</a>
				  
</div>