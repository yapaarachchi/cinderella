<?php
require "../Config.php";
require '../../vendor/autoload.php';

$db = Config::initDb();
$auth = new \Delight\Auth\Auth($db);
$isLoggedIn = $auth->isLoggedIn();

if($isLoggedIn != false){
	header('Location: ../../index.php');
}

				if (isset($_POST)) {
					if (isset($_POST['action'])) {
						if ($_POST['action'] === 'signout') {
							try{
								$auth->logout();
							}
							catch(Exception $e){
								
							}
							echo "CINDERELLA_OK";
							return;
						}
						else{
							
					}
				}
}
?>