<?php
require "../Config.php";
require '../../vendor/autoload.php';

$db = Config::initDb();
$auth = new \Delight\Auth\Auth($db);
//redirect to index page if not logged in

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
		if (isset($_POST['resendemail'])) {
			try{
				if (filter_var($_POST['resendemail'], FILTER_VALIDATE_EMAIL) === false) {
				  echo 'false';
				  return;
				} 
				if($auth->isUserExist($_POST['resendemail']))
				{
					echo 'true';
					return;
				}
				
				echo 'false';
				return;
			}
			catch(Exception $e){
				echo 'false';
				return;
			}
			
		}
	}
	
	if (isset($_POST['action'])) {
		if (isset($_POST['loginUsername'])) {
			try{
				if (filter_var($_POST['loginUsername'], FILTER_VALIDATE_EMAIL) === false) {
				  echo 'false';
				  return;
				} 
				if($auth->isUserExist($_POST['loginUsername']))
				{
					echo 'true';
					return;
				}
				
				echo 'false';
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