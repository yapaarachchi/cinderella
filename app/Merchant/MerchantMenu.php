
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
 <?php echo '<a href="#" style="font-size: 0.90rem; padding: 0.50rem;" class="list-group-item list-group-item-action" id="'.$value['id'].'">'.$value['business_name'].'</a>';?>
				
<?php
}
?>				  
 
</div>
</br>
<div class="list-group">
				  <a href="#" style="font-size: 0.90rem; padding: 0.50rem;" class="list-group-item list-group-item-action" id="AddBusiness">+ Add Business</a>
				  
</div>