<?php
require "../LoginController.php";

$login = new LoginControl;
$db = Config::initDb();
$auth = $login->initAuth($db);
$isLoggedIn = $login->isLoggedIn($auth);
if($isLoggedIn){
	header('Location: ../../index.php');
}


if (isset($_POST)) {
		if (isset($_POST['action'])) {
			if ($_POST['action'] === 'logout') {
				try {
					$auth->logout();
				}
				catch (Exception  $e) {
					echo 'Unexpected Error Occurred ! Try again.';
					return;
				}
			}
		}
}

?>