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
				'SELECT ' . $requestedColumns . ' FROM business_branch WHERE '.$where.' ORDER BY business_id DESC;'
			);
			
		}
		catch (Error $e) {
			throw new DatabaseError();
		}
		
		if(!empty($result)){
			return $result;
		}
	}

/*
Media

type
-----
IMAGE
EXT-VIDEO

category
--------
PROFILE
BANNER
GALLERY
*/

	public function getProfileImageByBusiness($bid) {
		$id = 0;
		try {
			if(is_numeric($bid) ){
				$id = $bid;
			}
			$requestedColumns = 'file_name, location';
			
			$media = $this->db->select(
				'SELECT ' . $requestedColumns . ' FROM media WHERE category = "PROFILE" AND type = "IMAGE" AND business_id = '.$id 
			);
		}
		catch (Error $e) {
			throw new DatabaseError();
		}
		catch (Exception $e) {
			$value['value'] = 'NULL';
			return $value;
		}

		if (empty($id)) {
			$value['value'] = 'NULL';
			return $value;
		}
		else {
			return $media;
		}
	}
	
	public function getBannerImagesByBusiness($bid) {
		$id = 0;
		try {
			if(is_numeric($bid) ){
				$id = $bid;
			}
			$requestedColumns = 'file_name, location';
			
			$media = $this->db->select(
				'SELECT ' . $requestedColumns . ' FROM media WHERE category = "BANNER" AND type = "IMAGE" AND business_id = '.$id 
			);
		}
		catch (Error $e) {
			throw new DatabaseError();
		}
		catch (Exception $e) {
			$value['value'] = 'NULL';
			return $value;
		}

		if (empty($id)) {
			$value['value'] = 'NULL';
			return $value;
		}
		else {
			return $media;
		}
	}

	public function getGalleryImagesByBusiness($bid) {
		$id = 0;
		try {
			if(is_numeric($bid) ){
				$id = $bid;
			}
			$requestedColumns = 'file_name, location';
			
			$media = $this->db->select(
				'SELECT ' . $requestedColumns . ' FROM media WHERE category = "GALLERY" AND type = "IMAGE" AND business_id = '.$id 
			);
		}
		catch (Error $e) {
			throw new DatabaseError();
		}
		catch (Exception $e) {
			$value['value'] = 'NULL';
			return $value;
		}

		if (empty($id)) {
			$value['value'] = 'NULL';
			return $value;
		}
		else {
			return $media;
		}
	}



}
