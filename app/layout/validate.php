<?php
require "../LoginController.php";

$login = new LoginControl;
$db = Config::initDb();
$auth = $login->initAuth($db);
$isLoggedIn = $login->isLoggedIn($auth);
if($isLoggedIn){
	header('Location: ../../index.php');
}
if (!isset($_POST['action'])) {
	header('Location: ../../index.php');
}

if (isset($_POST)) {
	if (isset($_POST['action'])) {
		if (isset($_POST['email'])) {
			try{
				if($auth->isUserExist($_POST['email']))
				{
					echo 'false';
					return;
				}
				if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
				  echo 'false';
				  return;
				} 
				echo 'true';
				return;
			}
			catch(Exception $e){
				echo 'false';
				return;
			}
			
		}
	}
	
	if (isset($_POST['action'])) {
		if (isset($_POST['forgotPwdEmail'])) {
			try{
				if($auth->isUserExist($_POST['forgotPwdEmail']) === false)
				{
					echo 'false';
					return;
				}
				if (filter_var($_POST['forgotPwdEmail'], FILTER_VALIDATE_EMAIL) === false) {
				  echo 'false';
				  return;
				} 
				echo 'true';
				return;
			}
			catch(Exception $e){
				echo 'false';
				return;
			}
			
		}
		
	}
	
}


?>