<?php
require "../Config.php";
require "../ErrorCode.php";
require '../../vendor/autoload.php';

$db = Config::initDb();
$auth = new \Delight\Auth\Auth($db);
$isLoggedIn = $auth->isLoggedIn();

if($isLoggedIn){
	header('Location: ../../index.php');
}


if (isset($_POST)) {
		if (isset($_POST['action'])) {
			if ($_POST['action'] === 'login') {
				if (isset($_POST['loginRememberme']) and $_POST['loginRememberme'] == 1) {
					// keep logged in for one year
					$rememberDuration = (int) (60 * 60 * 24 * 365.25);
				}
				else {
					// do not keep logged in after session ends
					$rememberDuration = null;
				}

				try {
					$auth->login($_POST['loginUsername'], $_POST['loginPassword'], $rememberDuration);					
				}
				catch (\Delight\Auth\InvalidEmailException $e) {
					ErrorCode::SetError(ErrorCode::LOGIN_EMAIL_WRONG);
					return;
				}
				catch (\Delight\Auth\InvalidPasswordException $e) {
					ErrorCode::SetError(ErrorCode::LOGIN_PASSWOED_WRONG);
					return;
				}
				catch (\Delight\Auth\EmailNotVerifiedException $e) {
					ErrorCode::SetError(ErrorCode::ACCOUNT_NOT_ACTIVATED);
					return;
				}
				catch (\Delight\Auth\TooManyRequestsException $e) {
					ErrorCode::SetError(ErrorCode::ERROR_GENERAL);
					return;
				}
				catch (Exception  $e) {
					ErrorCode::SetError(ErrorCode::ERROR_GENERAL);
					return;
				}
				echo 'CINDERELLA_OK';
				return;
			}
		}
}

?>