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


	public function getProfileImageDataByBusiness($bid) {
		$id = 0;
		try {
			if(is_numeric($bid) ){
				$id = $bid;
			}
			$requestedColumns = 'filename, location, mime_type';
			
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
	public function getProfileImage($bid, $approve) {
		$id = 0;
		$i=0;
		$media_image = '';
		try {
			if(is_numeric($bid) ){
				$id = $bid;
			}
			$requestedColumns = 'filename, approve';
			
			$media = $this->db->select(
				'SELECT ' . $requestedColumns . ' FROM media WHERE category = "PROFILE" AND type = "IMAGE" AND business_id = '.$id 
			);
			
			if (is_array($media) || is_object($media))
			{
				
				foreach($media as $key => $value) {
					$i = $i + 1;
					if($i == 1){
						$media_image = $value['filename'];
					}
					
				}
			}
		}
		catch (Error $e) {
			throw new DatabaseError();
		}
		catch (Exception $e) {
			$value['value'] = 'NULL';
			return $value;
		}

		if ($media_image == '') {
			return 'profile.png';
		}
		else {
			if($approve === true and $value['approve'] == '0'){
				return 'profile.png';
			}
			else{
				return $media_image.'?ver='.time();
			}
			
		}
	}
	
	public function getBannerImagesByBusiness($bid) {
		$id = 0;
		try {
			if(is_numeric($bid) ){
				$id = $bid;
			}
			$requestedColumns = 'filename, location, mime_type';
			
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
			return 'profile.png';
		}
		else {
			return $media;
		}
	}
	
	public function getBannerImage($bid,$index,$approve, $refresh = null) {
		$id = 0;
		$i=0;
		$media_image = '';
		try {
			if(is_numeric($bid) ){
				$id = $bid;
			}
			$requestedColumns = 'filename, approve';
			
			$media = $this->db->select(
				'SELECT ' . $requestedColumns . ' FROM media WHERE category = "BANNER" AND type = "IMAGE" AND business_id = '.$id 
			);
			
			if (is_array($media) || is_object($media))
			{
				foreach($media as $key => $value) {
					$imagearray = explode('_', $value['filename']);
					
					if($imagearray[1] == $index){
						$media_image = $value['filename'];
					}					
				}
			}
		}
		catch (Error $e) {
			throw new DatabaseError();
		}
		catch (Exception $e) {
			return 'banner.png';
		}

		if ($media_image == '') {
			return 'banner.png';
		}
		else {
			if($approve === true and $value['approve'] == '0'){
				return 'banner.png';
			}
			else{
				if($refresh === null or $refresh === true){
					return $media_image.'?ver='.time();
				}
				else{
					return $media_image;
				}
				
			}
			
		}
	}

	public function getGalleryImagesByBusiness($bid) {
		$id = 0;
		try {
			if(is_numeric($bid) ){
				$id = $bid;
			}
			$requestedColumns = 'filename, location, mime_type';
			
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
		
		if($category == 'BANNER'){
			$location = 'images/banner/'.$filename;
		}
		else if($category == 'PROFILE'){
			$location = 'images/profile/'.$filename;
		}	
		
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
						[ 'filename' => $filename, 'review' => '0', 'approve' => '0' ],
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
	
	public function getMediaStatus($bid,$category,$type, $filename = null) {
		$id = 0;
		$i=0;
		$file_name;
		$media_status;
		try {
			if(is_numeric($bid) ){
				$id = $bid;
			}
			if($filename == null){
				$file_name = $bid.'.png';
			}
			else{
				$file_name = $filename;
			}
			$media = $this->db->select(
				'SELECT approve FROM media WHERE category = "'.$category.'" AND type = "'.$type.'" AND business_id = '.$id.' AND filename = "'.$file_name.'"'				
			);
			
			if (is_array($media) || is_object($media))
			{
				foreach($media as $key => $value) {
					$i = $i + 1;
					$media_status = $value['approve'];	
					
				}
			}
		}
		catch (Error $e) {
			throw new DatabaseError();
		}
		catch (Exception $e) {
			return 'NULL';
		}
	if($i == 1){
		if ($media_status == '') {
			return 'NULL';
		}
		else {
			if($media_status == '1'){
				return 'APPROVE';
			}
			else{
				return 'NOT_APPROVE';
			}
		}	
	}
	else{
		return 'NULL';
	}
		
	}


	public function getMediaStatusMessage($bid,$category,$type, $filename = null) {
		$id = 0;
		$i=0;
		$file_name;
		$media_status;
		try {
			if(is_numeric($bid) ){
				$id = $bid;
			}
			if($filename == null){
				$file_name = $bid.'.png';
			}
			else{
				$file_name = $filename;
			}
			$media = $this->db->select(
				'SELECT approve FROM media WHERE category = "'.$category.'" AND type = "'.$type.'" AND business_id = '.$id.' AND filename = "'.$file_name.'"'				
			);
			
			if (is_array($media) || is_object($media))
			{
				foreach($media as $key => $value) {
					$i = $i + 1;
					$media_status = $value['approve'];	
					
				}
			}
		}
		catch (Error $e) {
			throw new DatabaseError();
		}
		catch (Exception $e) {
			return '';
		}
	if($i == 1){
		if ($media_status == '') {
			return '';
		}
		else {
			if($media_status == '0'){
				return '<div class="alert alert-warning" role="alert"><strong> This Image is not approved yet</strong>. It will display to the users once it get approved</div> ';
			}
			else{
				return '';
			}
		}	
	}
	else{
		return '<div class="alert alert-info" role="alert"><strong> NO Image!</strong>. Please insert an image</div> ';
	}
		
	}


}
