<?php
require "../Config.php";
require '../../vendor/autoload.php';

$db = Config::initDb();
$auth = new \Delight\Auth\Auth($db);
$BusinessHits = new \Delight\Auth\BusinessHits($db);

                if (isset($_POST)) {
					if (isset($_POST['action'])) {
						if ($_POST['action'] == 'NAVIGATE_MERCHANT_PAGE') {
							try{
								$business_id = $_POST['business_id'] ;
								$BusinessHits->updateBusinessHits($business_id);
							}
							catch(Exception $e){
								
							}
							echo 'CINDERELLA_OK';
							return;
						}
						else{
							
					}
				}
				}

?>