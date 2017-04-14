<?php

/*
 * PHP-Auth (https://github.com/delight-im/PHP-Auth)
 * Copyright (c) delight.im (https://www.delight.im/)
 * Licensed under the MIT License (https://opensource.org/licenses/MIT)
 */

final class ErrorCode {
	
	
	const REQUIRED_EMAIL = 'Email is required';
	const REQUIRED_PASSWORD = 'Password is required';
	const REQUIRED_RE_PASSWORD = 'Re-Enter Password is required';
	const REQUIRED_PASSWORD_MISMATCH = 'Passwords mismatch with each other';
	const REQUIRED_FIRST_NAME = 'First Name is required';
	const REQUIRED_LAST_NAME = 'Last Name is required';
	const REQUIRED_MEMBER_TYPE = 'Are you Grrom or Bride ?';
	const REQUIRED_DISTRICT = 'Distict is required';
	const REQUIRED_RECAPTCHA = 'Are you Human ?';
	const REQUIRED_CONTACT_PERSON = 'Contact Person for your business is required';
	const REQUIRED_BRANCH_CONTACT_PERSON = 'Contact Person for your branch is required';
	const REQUIRED_BUSINESS_NAME = 'Your Business Name is required';
	const REQUIRED_MERCHANT_ADDRESS = 'Address of Your Business is required';
	const REQUIRED_MERCHANT_BRANCH_ADDRESS = 'Please add Address/Street/City fields of Your Branch';
	const REQUIRED_CATEGORY = 'Categories are required';
	const REQUIRED_MOBILE = 'Mobile Number is required';
	
	/*
	const REQUIRED_EMAIL = 'Email is required';
	const REQUIRED_EMAIL = 'Email is required';
	const REQUIRED_EMAIL = 'Email is required';
	const REQUIRED_EMAIL = 'Email is required';
	const REQUIRED_EMAIL = 'Email is required';
	const REQUIRED_EMAIL = 'Email is required';
	*/
	
	const ERROR_UNEXPECTED = 'Unexpected error Occured. Please try again';
	const ERROR_GENERAL = 'Unexpected error Occured. Please try again';
	
	const CODE_500 = 'Verification mail is not sent';
	//confirmation is not created
	const CODE_501 = 'Unexpected error Occured. Please try again';
	const CODE_502 = 'Unexpected error Occured. Please contact Cinderella Team';
	
	const VERIFY_TOKEN_EXPIRED = 'Your verification token has expired.';
	const VERIFY_INVALID = 'Invalid Request.';
	
	const USER_NOT_EXIST = 'Email does not exist. Probably you are not registered as a user.';
	const USER_EXIST = 'User already exist.';
	const ACCOUNT_ALREADY_ACTIVATED = 'Account is already activated.';
	const ACCOUNT_NOT_ACTIVATED = 'Account has not been activated. Check your Email Account to activate your account.';
	
	const LOGIN_EMAIL_WRONG = 'The email appears to be incorrect.';
	const LOGIN_PASSWOED_WRONG = 'The password appears to be incorrect.';
	
	const TOO_MANY_REQUESTS = 'Too many requests. Please try againg later';
	
	const MEDIA_MIME_TYPES = 'Allowed extensions are .png, .gif, .jpeg, .jpg';
	const MEDIA_NO_FILE = 'Please attach an image file (.png, .gif, .jpeg, .jpg)';
	
	public static function SetError($errorcode){
		echo '<div class="alert alert-danger" role="alert" >'.$errorcode.'</div>';
	}

}
