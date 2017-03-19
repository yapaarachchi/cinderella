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
class Business {

	private $db;
	private $auth;
	public function __construct($databaseConnection) {
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
			throw new \InvalidArgumentException('The database connection must be an instance of either `PdoDatabase`, `PdoDsn` or `PDO`');
		}
	}
	
	
	//Business related data handling
	public function getBusinessByUserId($user_id) {
		try {
			$requestedColumns = 'id, email, category1, category2, contact_person, business_mobile, business_phone, business_name, business_email, website, more_info, description';
			
			$business = $this->db->select(
				'SELECT ' . $requestedColumns . ' FROM business WHERE user_id = '.$user_id 
			);
		}
		catch (Error $e) {
			throw new DatabaseError();
		}

		if (empty($user_id)) {
			throw new UnknownUsernameException();
		}
		else {
			if (count($business) > 0) {
				return $business;
			}
			else {
				$value['value'] = 'NULL';
				return $value;
			}
		}
	}
	
	public function getBusinessById($id) {
		try {
			$requestedColumns = 'email, category1, category2, contact_person, business_mobile, business_phone, business_name, business_email, website, more_info, description';
			
			$business = $this->db->select(
				'SELECT ' . $requestedColumns . ' FROM business WHERE id = '.$id 
			);
		}
		catch (Error $e) {
			throw new DatabaseError();
		}

		if (empty($id)) {
			$value['value'] = 'NULL';
			return $value;
		}
		else {
			return $business;
		}
	}
	
	public function addBusiness($userId , $other) {		
	
		//$auth->throttle(self::THROTTLE_ACTION_REGISTER);

		$email = $other['email'];

		try {
			$this->db->startTransaction();
			
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
			
			if(array_key_exists('web',$other)){
				$web = $other['web'];
			}
			else{
				$web = null;
			}
			//add business
			$this->db->insert(
				'business',
				[
					'user_id' => $userId,
					'email' => $email,
					'category1' => $other['category1'],
					'category2' => $other['category2'],
					'contact_person' => $other['contact_person'],
					'business_mobile' => $mobile,
					'business_phone' => $phone,
					'business_name' => $other['business_name'],
					'business_email' => $other['business_email'],
					'description' => $description,
					'website' => $web
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
					'branch_email' => $other['business_email'],
					'description' => $description,
					'district' => $other['district']					
				]
			);
		}
		catch (Error $e) {
			throw new DatabaseError();
			$this->db->rollBack();
		}
		catch (Exception $e) {
			$this->db->rollBack();
			return $e;
		}
		
		$this->db->commit();
		return $business_id;
	}
	
	public function deleteBusiness($businessId) {	
	
		try {
			$this->db->startTransaction();
			$this->db->delete(
				'business',
				[ 'id' => $businessId ]
			);
			
			$this->db->delete(
				'branch',
				[ 'business_id' => $businessId ]
			);
			$this->db->commit();
			return "200";
		}
		catch (Error $e) {
			$this->db->rollBack();
			throw new DatabaseError();
		}	
	}




}
