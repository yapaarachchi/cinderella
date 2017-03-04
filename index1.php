<?php

/*
 * PHP-Auth (https://github.com/delight-im/PHP-Auth)
 * Copyright (c) delight.im (https://www.delight.im/)
 * Licensed under the MIT License (https://opensource.org/licenses/MIT)
 */

// enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 'stdout');

// enable assertions
ini_set('assert.active', 1);
@ini_set('zend.assertions', 1);
ini_set('assert.exception', 1);

header('Content-type: text/html; charset=utf-8');

require __DIR__.'/vendor/autoload.php';
require 'app/config.php';
use Delight\Db\PdoDatabase;
$db = Config::initDb();

$auth = new \Delight\Auth\Auth($db);
$member = new \Delight\Auth\Member($db);
$result = processRequestData($auth,$db , $member);

showDebugData($auth, $result);

if ($auth->check()) {
	showAuthenticatedUserForm();
}
else {
	showGuestUserForm();
}

function processRequestData(\Delight\Auth\Auth $auth, $db , $member) {
	if (isset($_POST)) {
		if (isset($_POST['action'])) {
			if ($_POST['action'] === 'login') {
				if ($_POST['remember'] == 1) {
					// keep logged in for one year
					$rememberDuration = (int) (60 * 60 * 24 * 365.25);
				}
				else {
					// do not keep logged in after session ends
					$rememberDuration = null;
				}

				try {
					$auth->login($_POST['email'], $_POST['password'], $rememberDuration);

					return 'ok';
				}
				catch (\Delight\Auth\InvalidEmailException $e) {
					return 'wrong email address';
				}
				catch (\Delight\Auth\InvalidPasswordException $e) {
					return 'wrong password';
				}
				catch (\Delight\Auth\EmailNotVerifiedException $e) {
					return 'email not verified';
				}
				catch (\Delight\Auth\TooManyRequestsException $e) {
					return 'too many requests';
				}
			}
			else if ($_POST['action'] === 'register') {
				try {
					if ($_POST['require_verification'] == 1) {
						$callback = function ($selector, $token) {
							echo '<pre>';
							echo 'Email confirmation';
							echo "\n";
							echo '  >  Selector';
							echo "\t\t\t\t";
							echo htmlspecialchars($selector);
							echo "\n";
							echo '  >  Token';
							echo "\t\t\t\t";
							echo htmlspecialchars($token);
							echo '</pre>';
						};
					}
					else {
						$callback = null;
					}
					//$other['first_name'] = 'gayan';
					//$other['last_name'] = 'gayan';
					//$other['address1'] = 'no91';
					//$other['address2'] = 'ketandola';
					//$other['district'] = 'ratnapura';
					//$other['member_type'] = 'groom';
					//$other['mobile'] = 333333;
					
					$other['category1'] = 1;
					$other['category2'] = 2;
					$other['business_contact_person'] = 'sarath';
					$other['business_name'] = 'donal studio';
					$other['business_email'] = $_POST['email'];
					$other['more_info'] = 'TRUE';
					$other['business_mobile'] = 3333333333;
					$other['website'] = 'www.dddd.lk';
					$other['description'] = 'eeeee';
					$other['more_info'] = 'TRUE';
					$other['business_phone'] = 4444444444;
					
					$other['branch_address1'] = 'main rd';
					$other['branch_address2'] = 'ratnapura';
					$other['branch_contact_person'] = 'nimal';
					$other['branch_email'] = $_POST['email'];
					$other['main_branch'] = 'TRUE';
					$other['branch_description'] = 'eeeee';
					$other['district'] = 'kalutara';
					$other['branch_mobile'] = 6666666666;
					$other['branch_phone'] = 9999999999;
					
					
					
					
					$output = $auth->register($_POST['email'], $_POST['password'], $_POST['username'], 2, $other);
					if($output['status'] == 'OK'){
						$selector = htmlspecialchars($output['selector']);
						$token = htmlspecialchars($output['token']);	
						
						
					}
				}
				catch (\Delight\Auth\InvalidEmailException $e) {
					return 'invalid email address';
					
				}
				catch (\Delight\Auth\InvalidPasswordException $e) {
					return 'invalid password';
				}
				catch (\Delight\Auth\UserAlreadyExistsException $e) {
					return 'user already exists';
				}
				catch (\Delight\Auth\TooManyRequestsException $e) {
					return 'too many requests';
				}
				catch (Exception $e) {
					return 'Unexpected Error Occured'.$e;
				}
			}
			else if ($_POST['action'] === 'confirmEmail') {
				try {
					$auth->confirmEmail($_POST['selector'], $_POST['token']);

					return 'ok';
				}
				catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
					return 'invalid token';
				}
				catch (\Delight\Auth\TokenExpiredException $e) {
					return 'token expired';
				}
				catch (\Delight\Auth\TooManyRequestsException $e) {
					return 'too many requests';
				}
			}
			else if ($_POST['action'] === 'forgotPassword') {
				try {
					$auth->forgotPassword($_POST['email'], function ($selector, $token) {
						echo '<pre>';
						echo 'Password reset';
						echo "\n";
						echo '  >  Selector';
						echo "\t\t\t\t";
						echo htmlspecialchars($selector);
						echo "\n";
						echo '  >  Token';
						echo "\t\t\t\t";
						echo htmlspecialchars($token);
						echo '</pre>';
					});

					return 'ok';
				}
				catch (\Delight\Auth\InvalidEmailException $e) {
					return 'invalid email address';
				}
				catch (\Delight\Auth\EmailNotVerifiedException $e) {
					return 'email not verified';
				}
				catch (\Delight\Auth\TooManyRequestsException $e) {
					return 'too many requests';
				}
			}
			else if ($_POST['action'] === 'resetPassword') {
				try {
					$auth->resetPassword($_POST['selector'], $_POST['token'], $_POST['password']);

					return 'ok';
				}
				catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
					return 'invalid token';
				}
				catch (\Delight\Auth\TokenExpiredException $e) {
					return 'token expired';
				}
				catch (\Delight\Auth\InvalidPasswordException $e) {
					return 'invalid password';
				}
				catch (\Delight\Auth\TooManyRequestsException $e) {
					return 'too many requests';
				}
			}
			else if ($_POST['action'] === 'changePassword') {
				try {
					$auth->changePassword($_POST['oldPassword'], $_POST['newPassword']);

					return 'ok';
				}
				catch (\Delight\Auth\NotLoggedInException $e) {
					return 'not logged in';
				}
				catch (\Delight\Auth\InvalidPasswordException $e) {
					return 'invalid password(s)';
				}
			}
			else if ($_POST['action'] === 'logout') {
				$auth->logout();

				return 'ok';
			}
			else {
				throw new Exception('Unexpected action: '.$_POST['action']);
			}
		}
	}

	return null;
}

function showDebugData(\Delight\Auth\Auth $auth, $result) {
	echo '<pre>';

	echo 'Last operation'."\t\t\t\t";
	var_dump($result);
	echo 'Session ID'."\t\t\t\t";
	var_dump(session_id());
	echo "\n";

	echo '$auth->isLoggedIn()'."\t\t\t";
	var_dump($auth->isLoggedIn());
	echo '$auth->check()'."\t\t\t\t";
	var_dump($auth->check());
	echo "\n";

	echo '$auth->getUserId()'."\t\t\t";
	var_dump($auth->getUserId());
	echo '$auth->id()'."\t\t\t\t";
	var_dump($auth->id());
	echo "\n";

	echo '$auth->getEmail()'."\t\t\t";
	var_dump($auth->getEmail());
	echo '$auth->getUsername()'."\t\t\t";
	var_dump($auth->getUsername());
	echo '$auth->isRemembered()'."\t\t\t";
	var_dump($auth->isRemembered());
	echo '$auth->getIpAddress()'."\t\t\t";
	var_dump($auth->getIpAddress());
	echo "\n";

	echo 'Auth::createRandomString()'."\t\t";
	var_dump(\Delight\Auth\Auth::createRandomString());
	echo 'Auth::createUuid()'."\t\t\t";
	var_dump(\Delight\Auth\Auth::createUuid());

	echo '</pre>';
}

function showGeneralForm() {
	echo '<form action="" method="get" accept-charset="utf-8">';
	echo '<button type="submit">Refresh</button>';
	echo '</form>';
}

function showAuthenticatedUserForm() {
	showGeneralForm();

	echo '<form action="" method="post" accept-charset="utf-8">';
	echo '<input type="hidden" name="action" value="changePassword" />';
	echo '<input type="text" name="oldPassword" placeholder="Old password" /> ';
	echo '<input type="text" name="newPassword" placeholder="New password" /> ';
	echo '<button type="submit">Change password</button>';
	echo '</form>';

	echo '<form action="" method="post" accept-charset="utf-8">';
	echo '<input type="hidden" name="action" value="logout" />';
	echo '<button type="submit">Logout</button>';
	echo '</form>';
}

function showGuestUserForm() {
	showGeneralForm();

	echo '<form action="" method="post" accept-charset="utf-8">';
	echo '<input type="hidden" name="action" value="login" />';
	echo '<input type="text" name="email" placeholder="Email" /> ';
	echo '<input type="text" name="password" placeholder="Password" /> ';
	echo '<select name="remember" size="1">';
	echo '<option value="0">Remember (keep logged in)? — No</option>';
	echo '<option value="1">Remember (keep logged in)? — Yes</option>';
	echo '</select> ';
	echo '<button type="submit">Login</button>';
	echo '</form>';

	echo '<form action="" method="post" accept-charset="utf-8">';
	echo '<input type="hidden" name="action" value="register" />';
	echo '<input type="text" name="email" placeholder="Email" /> ';
	echo '<input type="text" name="password" placeholder="Password" /> ';
	echo '<input type="text" name="username" placeholder="Username (optional)" /> ';
	echo '<select name="require_verification" size="1">';
	echo '<option value="0">Require email confirmation? — No</option>';
	echo '<option value="1">Require email confirmation? — Yes</option>';
	echo '</select> ';
	echo '<button type="submit">Register</button>';
	echo '</form>';

	echo '<form action="" method="post" accept-charset="utf-8">';
	echo '<input type="hidden" name="action" value="confirmEmail" />';
	echo '<input type="text" name="selector" placeholder="Selector" /> ';
	echo '<input type="text" name="token" placeholder="Token" /> ';
	echo '<button type="submit">Confirm email</button>';
	echo '</form>';

	echo '<form action="" method="post" accept-charset="utf-8">';
	echo '<input type="hidden" name="action" value="forgotPassword" />';
	echo '<input type="text" name="email" placeholder="Email" /> ';
	echo '<button type="submit">Forgot password</button>';
	echo '</form>';

	echo '<form action="" method="post" accept-charset="utf-8">';
	echo '<input type="hidden" name="action" value="resetPassword" />';
	echo '<input type="text" name="selector" placeholder="Selector" /> ';
	echo '<input type="text" name="token" placeholder="Token" /> ';
	echo '<input type="text" name="password" placeholder="New password" /> ';
	echo '<button type="submit">Reset password</button>';
	echo '</form>';
}
