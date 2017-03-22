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
	
	

	
	public function getBranchByBusinessId($id) {
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


}
