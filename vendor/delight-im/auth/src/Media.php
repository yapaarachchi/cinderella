<?php

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

namespace Delight\Auth;

use Delight\Db\PdoDatabase;
use Delight\Db\PdoDsn;
use Delight\Db\Throwable\Error;
use Delight\Db\Throwable\IntegrityConstraintViolationException;

require_once __DIR__ . '/Exceptions.php';

class Media {

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


	public function getProfileImageByBusiness($bid) {
		$id = 0;
		try {
			if(is_numeric($bid) ){
				$id = $bid;
			}
			$requestedColumns = 'file_name, location, mime_type';
			
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
			$requestedColumns = 'file_name, location, mime_type';
			
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
			$requestedColumns = 'file_name, location, mime_type';
			
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

	public function UpdateMedia($business_id, $category, $type, $filename, $mime_type, $data = null) {		
	
		$Throttler = new \Delight\Auth\Throttler($this->db);
		$Throttler->throttle('update_media');

		if($this->CheckMimeType($mime_type) === false){
			return '1';
		}
		
		$location = 'images/profile/'.$filename;
		$i = 0;
		$media_id;
		
		try {
			$this->db->startTransaction();
			
			$media = $this->db->select(
				'SELECT id FROM media WHERE category = "'.$category.'" AND type = "'.$type.'" AND business_id = '.$business_id.' AND filename = "'.$filename.'"'				
			);
			
			if (is_array($media) || is_object($media))
			{
				foreach($media as $key => $value) {
					$i = $i + 1;
					$media_id = $value['id'];
				}
			}
			
				if($i == 0){
					$this->db->insert(
						'media',
						[
							'business_id' => $business_id,
							'category' => $category,
							'type' => $type,
							'filename' => $filename,
							'mime_type' => $mime_type
						]
					);				
				}
				else{
					$this->db->update(
						'media',
						[ 'filename' => $filename ],
						[ 'id' => $media_id]
					);
									
				}
				
				if(file_put_contents($location, $data) === false){
					$this->db->rollBack();
					return '400';
				}
						
		}
		catch (Error $e) {
			throw new DatabaseError();
			$this->db->rollBack();
		}
		catch (TooManyRequestsException $e) {
			$this->db->rollBack();
			throw new TooManyRequestsException();
		}
		catch (Exception $e) {
			$this->db->rollBack();
			return $e;
		}
		
		$this->db->commit();
		return '200';
		
	}
	
	private function CheckMimeType($mime_type){
		
		if($mime_type == 'png' or $mime_type == 'gif' or $mime_type == 'jpg' or $mime_type == 'jpeg'){
			return true;
		}
		else{
			return false;
		}

	}


}
