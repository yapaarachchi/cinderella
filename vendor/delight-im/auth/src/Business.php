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
	public function getBusinessByUserId($buser_id) {
		$id = 0;
		try {
			if(is_numeric($buser_id) ){
				$user_id = $buser_id;
			}
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
	/*
	public function getUserIdByBusinessId($id) {
		try {
			$requestedColumns = 'user_id';
			
			$user_id = $this->db->select(
				'SELECT ' . $requestedColumns . ' FROM business WHERE id = '.$id 
			);
		}
		catch (Error $e) {
			throw new DatabaseError();
		}

		return $user_id;
	}
	*/
	public function getBusinessById($bid) {
		$id = 0;
		try {
			if(is_numeric($bid) ){
				$id = $bid;
			}
			$requestedColumns = 'user_id, email, category1, category2, contact_person, business_mobile, business_phone, business_name, business_email, website, more_info, description';
			
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
	
	public function IsBusinessByIdExist($bid) {
		$id = 0;
		try {
			if(is_numeric($bid) ){
				$id = $bid;
			}
			$requestedColumns = 'id';
			
			$count = $this->db->select(
				'SELECT ' . $requestedColumns . ' FROM business WHERE id = '.$id 
			);
		}
		catch (Error $e) {
			throw new DatabaseError();
		}

		if (empty($count)) {
			return false;
		}
		else {
			return true;
		}
	}
	
	public function addBusiness($userId , $other) {		
	
		try {
			$Throttler = new \Delight\Auth\Throttler($this->db);
			$Throttler->throttle('add_business');
			
			$email = $other['email'];
		
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
	
	public function updateBusiness($businessId , $fields = null, $updatedfields = array(), $approve = null) {	
	
		$found = false;
		if(is_numeric($businessId) == false){
			throw new Exception(); 
		}
		$email = self::validateEmailAddress($fields['email']);
		
		$updated_fields = $this->getUpdatedFields($businessId);
		
		if($updated_fields != ''){
			$u_fields = explode(',', $updated_fields);
			
			if (is_array($u_fields) || is_array($updatedfields))
			{
				$merge_array = array_unique(array_merge($u_fields,$updatedfields));
				$updated_fields = '';
				foreach($merge_array as $value) {
					if($updated_fields == ''){
						$updated_fields = $value;
					}
					else{
						$updated_fields = $updated_fields .','.$value;
					}
				}
			}
		}
		else{
			$updated_fields = '';
			foreach($updatedfields as $value) {
				if($updated_fields == ''){
					$updated_fields = $value;
				}
				else{
					$updated_fields = $updated_fields .','.$value;
				}				
			}
		}
		
		
		if(is_numeric($fields['phone'])){
			$phone = $fields['phone'];
		}
		else{
			$phone = null;
		}
		
		if(is_numeric($fields['mobile'])){
			$mobile = $fields['mobile'];
		}
		else{
			$mobile = null;
		}
		
		try {
			$Throttler = new \Delight\Auth\Throttler($this->db);
			$Throttler->throttle('update_business');
		
			$this->db->update(
				'business',
				[ 'approve' => $approve, 'business_name' => $fields['businessName'], 'category1' => $fields['category1']
					, 'category2' => $fields['category2'], 'business_email' => $email, 'business_phone' => $phone, 
					'business_mobile' => $phone, 'contact_person' => $fields['contactPerson'], 'website' => $fields['web'] , 
					'description' => $fields['description'], 'updated_fields' => $updated_fields	],
				[ 'id' => $businessId ]
			);
			
			return '200';
		}
		catch (Error $e) {
			throw new DatabaseError();
		}
		catch (Exception $e) {
			return '1';
		}

	}
		
	public function getUpdatedFields($bid) {
		$id = 0;
		$fields = '';
		try {
			if(is_numeric($bid) ){
				$id = $bid;
			}
			$requestedColumns = 'updated_fields';
			
			$updated_fields = $this->db->selectRow(
				'SELECT ' . $requestedColumns . ' FROM business WHERE id = '.$id 
			);
			
			if (is_array($updated_fields) || is_object($updated_fields)){
				$fields = $updated_fields['updated_fields'];
			}
		}
		catch (Error $e) {
			throw new DatabaseError();
		}
		catch (Exception $e) {
			return null;
		}

		if ($fields != ''){
			return $fields;
		}
		else{
			return null;
		}
	}		
	
	public function deleteBusiness($businessId) {	
	
		try {
			$Throttler = new \Delight\Auth\Throttler($this->db);
			$Throttler->throttle('delete_business');
		
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
	
	public function search($category1, $category2, $district, $text) {
		try {
			$requestedColumns = 'business_id, business_name, branch_address1, branch_address2, branch_address3, business_email, business_mobile ';
			
			$where = "";
			
			if($category1 !== null ){
				$where = " category1 = ".$category1;			
			}
			
			if($category2 != null ){
				if($where != ""){
					$where = $where." AND category2 = ".$category2	;	
				}
				else{
					$where = " category2 = ".$category2;	
				}
						
			}
			
			if($district !== null ){
				if($where != ""){
					$where = $where." AND district = '".$district."'";	
				}
				else{
					$where = " district = '".$district."'";	
				}
							
			}
			
			if($text !== null){
				if($where != ""){
					$where = $where." AND (business_name like '%".$text."%' OR category1 like '%".$text."%' OR category2 like '%".$text."%' OR business_description like '%".$text."%' OR branch_address1 like '%".$text."%' OR branch_address2 like '%".$text."%' OR branch_address3 like '%".$text."%' OR district like '%".$text."%')";	
				}
				else{
					$where = " business_name like '%".$text."%' OR category1 like '%".$text."%' OR category2 like '%".$text."%' OR business_description like '%".$text."%' OR branch_address1 like '%".$text."%' OR branch_address2 like '%".$text."%' OR branch_address3 like '%".$text."%' OR district like '%".$text."%'";	
				}			
			}
			
			if($where == null or $where == ""){
				$where = "1=1";
			}
			
			$result = $this->db->select(
				'SELECT ' . $requestedColumns . ' FROM business_branch WHERE '.$where.' AND approve = "1" ORDER BY business_id DESC;'
			);
			
		}
		catch (Error $e) {
			throw new DatabaseError();
		}
		
		if(!empty($result)){
			return $result;
		}
	}
	
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
	
	public function getBusinessStatus($bid) {
		$id = 0;
		$status = '';
		try {
			if(is_numeric($bid) ){
				$id = $bid;
			}
			$requestedColumns = 'approve';
			
			$result = $this->db->selectRow(
				'SELECT ' . $requestedColumns . ' FROM business WHERE id = '.$id 
			);
			
			if (is_array($result) || is_object($result)){
				$status = $result['approve'];
			}
		}
		catch (Error $e) {
			throw new DatabaseError();
		}
		catch (Exception $e) {
			return null;
		}

		if ($status == '1'){
			return 'APPROVE';
		}
		else{
			return 'NOT_APPROVE';
		}
	}	

	public function getBusinessStatusMessage($bid) {
		$id = 0;
		$status = '';
		$business_name = '';
		try {
			if(is_numeric($bid) ){
				$id = $bid;
			}
			$requestedColumns = 'approve, business_name';
			
			$result = $this->db->selectRow(
				'SELECT ' . $requestedColumns . ' FROM business WHERE id = '.$id 
			);
			
			if (is_array($result) || is_object($result)){
				$status = $result['approve'];
				$business_name = $result['business_name'];
			}
		}
		catch (Error $e) {
			throw new DatabaseError();
		}
		catch (Exception $e) {
			return null;
		}

		if ($status == '0'){
			return '<div class="alert alert-warning" role="alert"><strong> '.$business_name.' is not approved yet</strong>. It will display to the users once it get approved</div> ';
		}
		else{
			return '';
		}
	}			
}
