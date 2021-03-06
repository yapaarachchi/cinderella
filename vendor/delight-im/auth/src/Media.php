<?php

/*
Media

type
-----
IMAGE
VIDEO

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

	public function getProfileImage($bid, $approve) {
		$id = 0;
		$i=0;
		$media_image = '';
		$media_status = '';
		try {
			if(is_numeric($bid) ){
				$id = $bid;
			}
			$requestedColumns = 'filename, approve';
			
			$media = $this->db->selectRow(
				'SELECT ' . $requestedColumns . ' FROM media WHERE category = "PROFILE" AND type = "IMAGE" AND business_id = '.$id 
			);
			
			if (is_array($media) || is_object($media))
			{
				
				foreach($media as $key => $value) {
					$media_image = $media['filename'];
					$media_status = $media['approve'];
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
			if($approve === true and $media_status == '0'){
				return 'profile.png';
			}
			else{
				return $media_image.'?ver='.time();
			}
			
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

	public function UpdateMedia($business_id, $category, $type, $filename, $mime_type, $data = null) {		
	
		$Throttler = new \Delight\Auth\Throttler($this->db);
		$Throttler->throttle('update_media');

		if($this->CheckMimeType($type, $mime_type) === false){
			return '1';
		}
		
		if($category == 'BANNER'){
			$location = 'images/banner/'.$filename;
		}
		else if($category == 'PROFILE'){
			$location = 'images/profile/'.$filename;
		}

		if ($type == 'VIDEO' and $filename != '') {
			$arr = explode('watch?v=', $filename);
			$filename = $arr[1];
		}	
		
		$i = 0;
		$media_id = null;
		
		try {
			$this->db->startTransaction();
			
			$media = $this->db->selectRow(
				'SELECT id FROM media WHERE category = "'.$category.'" AND type = "'.$type.'" AND business_id = '.$business_id.' AND filename = "'.$filename.'"'				
			);
			
			if (is_array($media) || is_object($media))
			{
				$media_id = $media['id'];
			}
			
				if($media_id == null){
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
				if ($type == 'IMAGE') {
					if(file_put_contents($location, $data) === false){
						$this->db->rollBack();
						return '400';
					}
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
	
	private function CheckMimeType($type, $mime_type){
		
		if($type = 'IMAGE' and ($mime_type == 'png' or $mime_type == 'gif' or $mime_type == 'jpg' or $mime_type == 'jpeg')){
			return true;
		}
		elseif($type = 'VIDEO'){
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
		$media_status = '';
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
			$media = $this->db->selectRow(
				'SELECT approve FROM media WHERE category = "'.$category.'" AND type = "'.$type.'" AND business_id = '.$id.' AND filename = "'.$file_name.'"'				
			);
			
			if (is_array($media) || is_object($media))
			{
				$media_status = $media['approve'];	
			}
		}
		catch (Error $e) {
			throw new DatabaseError();
		}
		catch (Exception $e) {
			return 'NULL';
		}
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

	public function getMediaStatusMessage($bid,$category,$type, $filename = null) {
		$id = 0;
		$i=0;
		$file_name;
		$media_status = '';
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
			$media = $this->db->selectRow(
				'SELECT approve FROM media WHERE category = "'.$category.'" AND type = "'.$type.'" AND business_id = '.$id.' AND filename = "'.$file_name.'"'				
			);
			
			if (is_array($media) || is_object($media))
			{
				$media_status = $media['approve'];
			}
		}
		catch (Error $e) {
			throw new DatabaseError();
		}
		catch (Exception $e) {
			return '';
		}
	if ($media_status == '') {
			return '<div class="alert alert-info" role="alert"><strong> NO Image!</strong>. Please insert an image</div> ';
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

	public function getBannerImagesCount($bid, $approve = false) {
		$id = 0;
		$count=0;
		try {
			if(is_numeric($bid) ){
				$id = $bid;
			}
			
			if($approve === true){
				$media = $this->db->selectRow(
				'SELECT count(id) FROM media WHERE approve = "1" AND category = "BANNER" AND type = "IMAGE" AND business_id = '.$id 
				);
			}
			else{
				$media = $this->db->selectRow(
				'SELECT count(id) FROM media WHERE approve = "0" AND category = "BANNER" AND type = "IMAGE" AND business_id = '.$id 
				);
			}
			
			if (is_array($media) || is_object($media))
			{
				$count = $media['count(id)'];
			}
		}
		catch (Error $e) {
			throw new DatabaseError();
		}
		catch (Exception $e) {
			return 0;
		}

		return $count;
	}

	public function getDefaultBannerImage() {
		return 'banner.png';
	}

	public function getBannerImages($bid, $approve, $refresh = null) {
		$id = 0;
		$i=0;
		$media_image = '';
		try {
			if(is_numeric($bid) ){
				$id = $bid;
			}
			$requestedColumns = 'filename';
			
			if($approve === true){
				$media = $this->db->select(
				'SELECT ' . $requestedColumns . ' FROM media WHERE approve = "1" AND category = "BANNER" AND type = "IMAGE" AND business_id = '.$id 
			);
			}
			else{
				$media = $this->db->select(
				'SELECT ' . $requestedColumns . ' FROM media WHERE approve = "0" AND category = "BANNER" AND type = "IMAGE" AND business_id = '.$id 
			);
			}
			
		}
		catch (Error $e) {
			throw new DatabaseError();
		}
		catch (Exception $e) {
			return 'banner.png';
		}

		return $media;
	}

public function UpdateVideo( $business_id, $id, $filename) {		
	
		$Throttler = new \Delight\Auth\Throttler($this->db);
		$Throttler->throttle('update_video');

		if ($filename != '') {
			$arr = explode('watch?v=', $filename);
			$filename = $arr[1];
		}
		else{
			$filename = null;
		}
		
		$i = 0;
		
		try {
			$this->db->startTransaction();
			
				if($id == null){
					$this->db->insert(
						'media',
						[
							'business_id' => $business_id,
							'category' => 'GALLERY',
							'type' => 'VIDEO',
							'filename' => $filename
						]
					);				
				}
				else{
					$this->db->update(
						'media',
						[ 'filename' => $filename, 'review' => '0', 'approve' => '0' ],
						[ 'id' => $id]
					);
									
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

	public function getVideos($bid, $approve = false) {
		$id = 0;
		$media_video = '';
		try {
			if(is_numeric($bid) ){
				$id = $bid;
			}

			$requestedColumns = 'filename, id';

			if ($approve === true) {
				$media = $this->db->select(
				'SELECT ' . $requestedColumns . ' FROM media WHERE business_id = '.$id.' AND category = "GALLERY" AND type = "VIDEO" AND approve = "1"'  
			);
			} else {
				$media = $this->db->select(
				'SELECT ' . $requestedColumns . ' FROM media WHERE business_id = '.$id.' AND  category = "GALLERY" AND type = "VIDEO"'
			);
			}
			
			if (is_array($media) || is_object($media))
			{
				$media_video = $media;
			}
		}
		catch (Error $e) {
			throw new DatabaseError();
		}
		catch (Exception $e) {
			return false;
		}

		if ($media == null) {
			return false;
		}
		else {
			return $media_video;
		}
	}

	public function getVideoCount($business_id, $approve = false) {
		$count = 0;
		try{		
			if($approve === false){
				$media = $this->db->selectRow(
				'SELECT count(id) FROM media WHERE type = "VIDEO" AND category = "GALLERY" AND business_id = '.$business_id
				);
			}
			else{
				$media = $this->db->selectRow(
				'SELECT count(id) FROM media WHERE type = "VIDEO" AND category = "GALLERY" AND business_id = '.$business_id.' AND approve = "1" '
				);
			}
			
			
			if (is_array($media) || is_object($media))
			{
				$count = $media['count(id)'];
			}
		}
		catch (Error $e) {
			throw new DatabaseError();
		}

		if (empty($business_id)) {
			return 0;
		}
		else {
			return $count;
		}
	}


}
