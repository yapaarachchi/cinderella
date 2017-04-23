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
class Branch {

	private $db;
	
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
	
	public function addBranch($BusinessId , $other) {
		try{
			$this->db->startTransaction();
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
			if(array_key_exists('branch_mobile',$other)){
				$mobile = $other['branch_mobile'];
			}
			else{
				$mobile = null;
			}
			if(array_key_exists('branch_phone',$other)){
				$phone = $other['branch_phone'];
			}
			else{
				$phone = null;
			}
			
			if($other['main_branch'] == 'YES'){
			$this->db->update(
				'branch',
					[ 'main_branch' => 'NO'],
					[ 'business_id' => $BusinessId, 'main_branch' => 'YES' ]
				);
			}
			$this->db->insert(
				'branch',
				[
					'business_id' => $BusinessId,
					'branch_address1' => $address1,
					'branch_address2' => $address2,
					'branch_address3' => $address3,
					'contact_person' => $other['contact_person'],
					'branch_mobile' => $mobile,
					'branch_phone' => $phone,
					'main_branch' => $other['main_branch'],
					'branch_email' => $other['email'],
					'district' => $other['district']					
				]
			);
			$this->db->commit();
			return '200';
		}
			catch (Error $e) {
				$this->db->rollBack();
			throw new DatabaseError();
		}
		catch (Exception $e) {
			$this->db->rollBack();
			return '1';
		}
		
	}
	public function getBranchesByBusinessId($id) {
		try {
			$requestedColumns = 'id, branch_address1, branch_address2, branch_address3, district, contact_person, branch_email, branch_mobile, branch_phone, main_branch, description';
			
			$business = $this->db->select(
				'SELECT ' . $requestedColumns . ' FROM branch WHERE business_id = '.$id 
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
	
	public function getMainBranchByBusinessId($id) {
		try {
			$requestedColumns = 'id, branch_address1, branch_address2, branch_address3, district, contact_person, branch_email, branch_mobile, branch_phone, main_branch, description';
			
			$business = $this->db->select(
				'SELECT ' . $requestedColumns . ' FROM branch WHERE main_branch = "YES" AND business_id = '.$id 
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

	public function deleteBranch($businessId, $branchId) {	
		try {
			if(is_numeric($businessId) == false){
				return '1';
			}
			
			if(is_numeric($branchId) == false){
				return '1';
			}
			
			$this->db->delete(
				'branch',
				[ 'id' => $branchId, 'business_id' => $businessId ]
			);
			return "200";
		}
		catch (Error $e) {
			throw new DatabaseError();
		}
		catch (Exceptions $e) {
			return '1';
		}		
	}
	
	public function getBranchAddress1($id) {
		try {
			$requestedColumns = 'branch_address1';
			
			$branch = $this->db->selectRow(
				'SELECT ' . $requestedColumns . ' FROM branch WHERE business_id = '.$id 
			);
			
			if (is_array($branch) || is_object($branch)){
				$fields = $branch['branch_address1'];
			}
		}
		catch (Error $e) {
			throw new DatabaseError();
		}

		if ($fields != '') {
			return $fields;
		}
		else {
			return null;
		}
	}
	
	public function getBranchAddress2($id) {
		try {
			$requestedColumns = 'branch_address2';
			
			$branch = $this->db->selectRow(
				'SELECT ' . $requestedColumns . ' FROM branch WHERE business_id = '.$id 
			);
			
			if (is_array($branch) || is_object($branch)){
				$fields = $branch['branch_address2'];
			}
		}
		catch (Error $e) {
			throw new DatabaseError();
		}

		if ($fields != '') {
			return $fields;
		}
		else {
			return null;
		}
	}
	
	public function getBranchAddress3($id) {
		try {
			$requestedColumns = 'branch_address3';
			
			$branch = $this->db->selectRow(
				'SELECT ' . $requestedColumns . ' FROM branch WHERE business_id = '.$id 
			);
			
			if (is_array($branch) || is_object($branch)){
				$fields = $branch['branch_address3'];
			}
		}
		catch (Error $e) {
			throw new DatabaseError();
		}

		if ($fields != '') {
			return $fields;
		}
		else {
			return null;
		}
	}
	
	public function getBranchDistrict($id) {
		try {
			$requestedColumns = 'district';
			
			$branch = $this->db->selectRow(
				'SELECT ' . $requestedColumns . ' FROM branch WHERE business_id = '.$id 
			);
			
			if (is_array($branch) || is_object($branch)){
				$fields = $branch['district'];
			}
		}
		catch (Error $e) {
			throw new DatabaseError();
		}

		if ($fields != '') {
			return $fields;
		}
		else {
			return null;
		}
	}
	
	public function getContactPerson($id) {
		try {
			$requestedColumns = 'contact_person';
			
			$branch = $this->db->selectRow(
				'SELECT ' . $requestedColumns . ' FROM branch WHERE business_id = '.$id 
			);
			
			if (is_array($branch) || is_object($branch)){
				$fields = $branch['contact_person'];
			}
		}
		catch (Error $e) {
			throw new DatabaseError();
		}

		if ($fields != '') {
			return $fields;
		}
		else {
			return null;
		}
	}
	
	public function getBranchEmail($id) {
		try {
			$requestedColumns = 'branch_email';
			
			$branch = $this->db->selectRow(
				'SELECT ' . $requestedColumns . ' FROM branch WHERE business_id = '.$id 
			);
			
			if (is_array($branch) || is_object($branch)){
				$fields = $branch['branch_email'];
			}
		}
		catch (Error $e) {
			throw new DatabaseError();
		}

		if ($fields != '') {
			return $fields;
		}
		else {
			return null;
		}
	}
	
	public function getBranchMobile($id) {
		try {
			$requestedColumns = 'branch_mobile';
			
			$branch = $this->db->selectRow(
				'SELECT ' . $requestedColumns . ' FROM branch WHERE business_id = '.$id 
			);
			
			if (is_array($branch) || is_object($branch)){
				$fields = $branch['branch_mobile'];
			}
		}
		catch (Error $e) {
			throw new DatabaseError();
		}

		if ($fields != '') {
			return $fields;
		}
		else {
			return null;
		}
	}
	
	public function getBranchPhone($id) {
		try {
			$requestedColumns = 'branch_phone';
			
			$branch = $this->db->selectRow(
				'SELECT ' . $requestedColumns . ' FROM branch WHERE business_id = '.$id 
			);
			
			if (is_array($branch) || is_object($branch)){
				$fields = $branch['branch_phone'];
			}
		}
		catch (Error $e) {
			throw new DatabaseError();
		}

		if ($fields != '') {
			return $fields;
		}
		else {
			return null;
		}
	}
	
	public function getMainBranch($id) {
		try {
			$requestedColumns = 'main_branch';
			
			$branch = $this->db->selectRow(
				'SELECT ' . $requestedColumns . ' FROM branch WHERE business_id = '.$id 
			);
			
			if (is_array($branch) || is_object($branch)){
				$fields = $branch['main_branch'];
			}
		}
		catch (Error $e) {
			throw new DatabaseError();
		}

		if ($fields != '') {
			return $fields;
		}
		else {
			return null;
		}
	}

}
