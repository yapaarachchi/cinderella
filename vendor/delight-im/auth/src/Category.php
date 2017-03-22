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
use PHPMailer;

require_once __DIR__ . '/Exceptions.php';


class Category {
	
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
	
	public function getMainCategory(){
		
		try {
			$categoryData = $this->db->select(
				'SELECT id, category, description FROM category1');
				return $categoryData;
		}
		catch (Error $e) {
			throw new DatabaseError();
		}
	}
	
	public function getSubCategory($cat1_id){
		
		try {
			$categoryData = $this->db->select(
				'SELECT id, category2, description FROM category2 WHERE category1_id = ? ',
				[$cat1_id]);
				return $categoryData;
		}
		catch (Error $e) {
			throw new DatabaseError();
		}
	}
	
	public function getCategoryName($cat1_id){
		
		try {
			$categoryData = $this->db->select(
				'SELECT category FROM category1 WHERE id = '.$cat1_id);
				
				if (is_array($categoryData) || is_object($categoryData))
				{
					foreach($categoryData as $key => $value) {
						$return = $value['category'];
					}
				}
				
				return $return;
		}
		catch (Error $e) {
			throw new DatabaseError();
		}
	}
	
	public function getSubCategoryName($cat1_id, $cat2_id){
		
		try {
			$categoryData = $this->db->select(
				'SELECT category2 FROM category2 WHERE category1_id = '.$cat1_id .' AND id = '.$cat2_id);
				
				if (is_array($categoryData) || is_object($categoryData))
				{
					foreach($categoryData as $key => $value) {
						$return = $value['category2'];
					}
				}
				return $return;
		}
		catch (Error $e) {
			throw new DatabaseError();
		}
	}
	
	
}
