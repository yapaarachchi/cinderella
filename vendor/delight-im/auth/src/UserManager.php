<?php

/*
 * PHP-Auth (https://github.com/delight-im/PHP-Auth)
 * Copyright (c) delight.im (https://www.delight.im/)
 * Licensed under the MIT License (https://opensource.org/licenses/MIT)
 */

namespace Delight\Auth;

use Delight\Db\PdoDatabase;
use Delight\Db\PdoDsn;
use Delight\Db\Throwable\Error;
use Delight\Db\Throwable\IntegrityConstraintViolationException;

require_once __DIR__ . '/Exceptions.php';

/**
 * Abstract base class for components implementing user management
 *
 * @internal
 */
abstract class UserManager {

	const THROTTLE_ACTION_LOGIN = 'login';
	const THROTTLE_ACTION_REGISTER = 'register';
	const THROTTLE_ACTION_CONSUME_TOKEN = 'confirm_email';

	/** @var PdoDatabase the database connection to operate on */
	protected $db;

	/**
	 * Creates a random string with the given maximum length
	 *
	 * With the default parameter, the output should contain at least as much randomness as a UUID
	 *
	 * @param int $maxLength the maximum length of the output string (integer multiple of 4)
	 * @return string the new random string
	 */
	public static function createRandomString($maxLength = 24) {
		// calculate how many bytes of randomness we need for the specified string length
		$bytes = floor(intval($maxLength) / 4) * 3;

		// get random data
		$data = openssl_random_pseudo_bytes($bytes);

		// return the Base64-encoded result
		return Base64::encode($data, true);
	}

	/**
	 * @param PdoDatabase|PdoDsn|\PDO $databaseConnection the database connection to operate on
	 */
	protected function __construct($databaseConnection) {
		if ($databaseConnection instanceof PdoDatabase) {
			$this->db = $databaseConnection;
		}
		elseif ($databaseConnection instanceof PdoDsn) {
			$this->db = PdoDatabase::fromDsn($databaseConnection);
		}
		elseif ($databaseConnection instanceof \PDO) {
			$this->db = PdoDatabase::fromPdo($databaseConnection, true);
		}
		else {
			$this->db = null;

			throw new \InvalidArgumentException('The database connection must be an instance of either `PdoDatabase`, `PdoDsn` or `PDO`');
		}
	}

	/**
	 * Creates a new user
	 *
	 * If you want the user's account to be activated by default, pass `null` as the callback
	 *
	 * If you want to make the user verify their email address first, pass an anonymous function as the callback
	 *
	 * The callback function must have the following signature:
	 *
	 * `function ($selector, $token)`
	 *
	 * Both pieces of information must be sent to the user, usually embedded in a link
	 *
	 * When the user wants to verify their email address as a next step, both pieces will be required again
	 *
	 * @param bool $requireUniqueUsername whether it must be ensured that the username is unique
	 * @param string $email the email address to register
	 * @param string $password the password for the new account
	 * @param string|null $username (optional) the username that will be displayed
	 * @param callable|null $callback (optional) the function that sends the confirmation email to the user
	 * @return int the ID of the user that has been created (if any)
	 * @throws InvalidEmailException if the email address has been invalid
	 * @throws InvalidPasswordException if the password has been invalid
	 * @throws UserAlreadyExistsException if a user with the specified email address already exists
	 * @throws DuplicateUsernameException if it was specified that the username must be unique while it was *not*
	 * @throws AuthError if an internal problem occurred (do *not* catch)
	 */
	 
	 
	 //500 - Mail Not Sent
	 //501 - Confirmation is not created
	protected function createUserInternal($requireUniqueUsername, $email, $password, $username = null, $userole, $other) {
		
		$return = array();
		$newUserId;
		$name;
		$this->throttle(self::THROTTLE_ACTION_REGISTER);

		ignore_user_abort(true);

		$email = self::validateEmailAddress($email);
		$password = self::validatePassword($password);

		$username = isset($username) ? trim($username) : null;

		// if the supplied username is the empty string or has consisted of whitespace only
		if ($username === '') {
			// this actually means that there is no username
			$username = null;
		}

		// if the uniqueness of the username is to be ensured
		if ($requireUniqueUsername) {
			// if a username has actually been provided
			if ($username !== null) {
				// count the number of users who do already have that specified username
				$occurrencesOfUsername = $this->db->selectValue(
					'SELECT COUNT(*) FROM users WHERE username = ?',
					[ $username ]
				);

				// if any user with that username does already exist
				if ($occurrencesOfUsername > 0) {
					// cancel the operation and report the violation of this requirement
					throw new DuplicateUsernameException();
				}
			}
		}

		$password = password_hash($password, PASSWORD_DEFAULT);
		$verified = 0;
		
		try {
			$this->db->startTransaction();
			if($userole == UserRole::MEMBER){
				
				//add user
				$this->db->insert(
				'users',
				[
					'email' => $email,
					'password' => $password,
					'username' => $username,
					'verified' => $verified,
					'registered' => time(),
					'user_role' => UserRole::MEMBER
				]
			);
			
			$newUserId = (int) $this->db->getLastInsertId();
			if(array_key_exists('address1',$other)){
				$address1 = $other['address1'];
			}
			else{
				$address1 = null;
			}
			if(array_key_exists('address2',$other)){
				$address2 = $other['address2'];
			}
			else{
				$address2 = null;
			}
			if(array_key_exists('address3',$other)){
				$address3 = $other['address3'];
			}
			else{
				$address3 = null;
			}
			//add user as member
			$this->db->insert(
				'member',
				[
					'user_id' => $newUserId,
					'email' => $email,
					'first_name' => $other['first_name'],
					'last_name' => $other['last_name'],
					'member_type' => $other['member_type'],
					'mobile' => $other['mobile'],
					'district' => $other['district'],
					'address1' => $address1,
					'address2' => $address2,
					'address3' => $address3					
				]
			);
			$name = $other['first_name'].' '.$other['last_name'];
			}
			else if($userole == UserRole::MERCHANT){
				$this->db->insert(
				'users',
				[
					'email' => $email,
					'password' => $password,
					'username' => $username,
					'verified' => $verified,
					'registered' => time(),
					'user_role' => UserRole::MERCHANT
				]
			);
			$newUserId = (int) $this->db->getLastInsertId();
			if(array_key_exists('business_mobile',$other)){
				$mobile = $other['business_mobile'];
			}
			else{
				$mobile = null;
			}
			if(array_key_exists('business_phone',$other)){
				$phone = $other['business_phone'];
			}
			else{
				$phone = null;
			}
			if(array_key_exists('description',$other)){
				$description = $other['description'];
			}
			else{
				$description = null;
			}
			//add business
			$this->db->insert(
				'business',
				[
					'user_id' => $newUserId,
					'email' => $email,
					'category1' => $other['category1'],
					'category2' => $other['category2'],
					'contact_person' => $other['contact_person'],
					'business_mobile' => $mobile,
					'business_phone' => $phone,
					'business_name' => $other['business_name'],
					'business_email' => $email,
					'description' => $description
				]
			);
			$name = $other['business_name'];
			$business_id = (int) $this->db->getLastInsertId();
			
			if(array_key_exists('address1',$other)){
				$address1 = $other['address1'];
			}
			else{
				$address1 = null;
			}
			if(array_key_exists('address2',$other)){
				$address2 = $other['address2'];
			}
			else{
				$address2 = null;
			}
			if(array_key_exists('address3',$other)){
				$address3 = $other['address3'];
			}
			else{
				$address3 = null;
			}
			//add branch - default this will take as main branch
			
			$this->db->insert(
				'branch',
				[
					'business_id' => $business_id,
					'branch_address1' => $address1,
					'branch_address2' => $address2,
					'branch_address3' => $address3,
					'contact_person' => $other['contact_person'],
					'branch_mobile' => $mobile,
					'branch_phone' => $phone,
					'main_branch' => 'YES',
					'branch_email' => $email,
					'description' => $description,
					'district' => $other['district']					
				]
			);
			
			}
			
			if ($verified === 0) {
				$return = $this->createConfirmationRequest($email);
				if(array_key_exists('selector',$return) === false and array_key_exists('token',$return) === false){
					$this->db->rollBack();
					return '501';
				}
				else{
					
					$mail = new MailHandler();
					$check = $mail->SendMail($email, $name, $return['token'], $return['selector'], 'register');	
					if($check === false){
						$this->db->rollBack();
						return '500';
					}
					else{
						$this->db->commit();
					}
				}
			}
		}
		// if we have a duplicate entry
		catch (IntegrityConstraintViolationException $e) {
			throw new UserAlreadyExistsException();
			$this->db->rollBack();
		}
		catch (Error $e) {
			throw new DatabaseError();
			$this->db->rollBack();
		}
		catch (Exception $e) {
			$this->db->rollBack();
			return $e;
		}

		return $newUserId;
	}

	/**
	 * Returns the requested user data for the account with the specified username (if any)
	 *
	 * You must never pass untrusted input to the parameter that takes the column list
	 *
	 * @param string $username the username to look for
	 * @param array $requestedColumns the columns to request from the user's record
	 * @return array the user data (if an account was found unambiguously)
	 * @throws UnknownUsernameException if no user with the specified username has been found
	 * @throws AmbiguousUsernameException if multiple users with the specified username have been found
	 * @throws AuthError if an internal problem occurred (do *not* catch)
	 */
	protected function getUserDataByUsername($username, array $requestedColumns) {
		try {
			$projection = implode(', ', $requestedColumns);

			$users = $this->db->select(
				'SELECT ' . $projection . ' FROM users WHERE username = ? LIMIT 0, 2',
				[ $username ]
			);
		}
		catch (Error $e) {
			throw new DatabaseError();
		}

		if (empty($users)) {
			throw new UnknownUsernameException();
		}
		else {
			if (count($users) === 1) {
				return $users[0];
			}
			else {
				throw new AmbiguousUsernameException();
			}
		}
	}

	/**
	 * Validates an email address
	 *
	 * @param string $email the email address to validate
	 * @return string the sanitized email address
	 * @throws InvalidEmailException if the email address has been invalid
	 */
	protected static function validateEmailAddress($email) {
		if (empty($email)) {
			throw new InvalidEmailException();
		}

		$email = trim($email);

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			throw new InvalidEmailException();
		}

		return $email;
	}

	/**
	 * Validates a password
	 *
	 * @param string $password the password to validate
	 * @return string the sanitized password
	 * @throws InvalidPasswordException if the password has been invalid
	 */
	protected static function validatePassword($password) {
		if (empty($password)) {
			throw new InvalidPasswordException();
		}

		$password = trim($password);

		if (strlen($password) < 1) {
			throw new InvalidPasswordException();
		}

		return $password;
	}

	/**
	 * Throttles the specified action for the user to protect against too many requests
	 *
	 * @param string $actionType one of the constants from this class starting with `THROTTLE_ACTION_`
	 * @param mixed|null $customSelector a custom selector to use for throttling (if any), otherwise the IP address will be used
	 * @throws TooManyRequestsException if the number of allowed attempts/requests has been exceeded
	 * @throws AuthError if an internal problem occurred (do *not* catch)
	 */
	abstract protected function throttle($actionType, $customSelector = null);

	/**
	 * Creates a request for email confirmation
	 *
	 * The callback function must have the following signature:
	 *
	 * `function ($selector, $token)`
	 *
	 * Both pieces of information must be sent to the user, usually embedded in a link
	 *
	 * When the user wants to verify their email address as a next step, both pieces will be required again
	 *
	 * @param string $email the email address to verify
	 * @param callable $callback the function that sends the confirmation email to the user
	 * @throws AuthError if an internal problem occurred (do *not* catch)
	 */
	private function createConfirmationRequest($email) {
		
		$return = array();
		
		$selector = self::createRandomString(16);
		$token = self::createRandomString(16);
		$tokenHashed = password_hash($token, PASSWORD_DEFAULT);

		// the request shall be valid for one day
		$expires = time() + 60 * 60 * 24;

		try {
			$this->db->insert(
				'users_confirmations',
				[
					'email' => $email,
					'selector' => $selector,
					'token' => $tokenHashed,
					'expires' => $expires
				]
			);
		}
		catch (Error $e) {
			throw new DatabaseError();
		}

		$return['selector'] = $selector;
		$return['token'] = $token;
		
		return $return;
	}
	
	public function resendConfirmationRequest($email) {
		$selector = self::createRandomString(16);
		$token = self::createRandomString(16);
		$tokenHashed = password_hash($token, PASSWORD_DEFAULT);

		// the request shall be valid for one day
		$expires = time() + 60 * 60 * 24;
		

		try {
			$this->db->startTransaction();
			$this->db->delete(
				'users_confirmations',
				[ 'email' => $email ]
			);
			$this->db->insert(
				'users_confirmations',
				[
					'email' => $email,
					'selector' => $selector,
					'token' => $tokenHashed,
					'expires' => $expires
				]
			);
			
			$mail = new MailHandler();
			$check = $mail->SendMail($email, $name, $return['token'], $return['selector'], 'register');	
			if($check === false){
				$this->db->rollBack();
				return '500';
			}
			else{
				$this->db->commit();
				return true;
			}
		}
		catch (Error $e) {
			$this->db->rollBack();
			throw new DatabaseError();
		}
	}

}
