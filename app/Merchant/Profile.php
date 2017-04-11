<?php
require "../Config.php";
require "../ErrorCode.php";
require '../../vendor/autoload.php';

$db = Config::initDb();
$auth = new \Delight\Auth\Auth($db);
$Business = new \Delight\Auth\Business($db);
$Branch = new \Delight\Auth\Branch($db);
$Media = new \Delight\Auth\Media($db);

echo '

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" data-toggle="tab" href="#general" role="tab">General</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#settings" role="tab">Settings</a>
  </li>
</ul>

<!-- Tab panes -->
<div class="tab-content">

  <div class="tab-pane active" id="general" role="tabpanel">
  <div class="card">
  <div class="card-block">
  
	<form>
		<div class="form-group row">
		<label class="col-2 col-form-label"><b>Email:</b></label>
		<div class="col-10">
		  <p class="form-control-static"> '.$auth->getEmail().'</p>
		</div>
		</div>
	</form>
 </div>
 </div>
  
 
  
  </div>
  <div class="tab-pane" id="settings" role="tabpanel">
  
  </div>
</div>
';

?>