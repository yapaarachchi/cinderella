<?php
namespace Delight\Auth;

use Delight\Db\PdoDatabase;
use Delight\Db\PdoDsn;
use Delight\Db\Throwable\Error;
use Delight\Db\Throwable\IntegrityConstraintViolationException;

require_once __DIR__ . '/Exceptions.php';

class BusinessHits {

	private $db;
	private $auth;
	private $ipAddress;
	
	const IP_ADDRESS_HASH_ALGORITHM = 'sha256';
	
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
		$this->ipAddress = empty($ipAddress) ? $_SERVER['REMOTE_ADDR'] : $ipAddress;
		
	}
	
	public function updateBusinessHits($BusinessId) {
		$Throttler = new \Delight\Auth\Throttler($this->db);
		$Throttler->throttle('update_media_'.self::hash($this->ipAddress).'_'.$BusinessId);
		$new_hits = $this->getBusinessHits($BusinessId);
		try{			
			$new_hits = $this->getBusinessHits($BusinessId) + 1;
			if($this->getBusinessHits($BusinessId) == 0){
				$this->db->insert(
				'hits',
				[
					'business_id' => $BusinessId,
					'hits' => $new_hits					
				]
				);
			}
			else{
				$this->db->update(
				'hits',
				[ 'hits' => $new_hits],
				[ 'business_id' => $BusinessId]
				);
			}
			
			return '200';
		}
			catch (Error $e) {
				throw new DatabaseError();
		}
		catch (Exception $e) {
			return '1';
		}
		
	}
	
	public function getBusinessHits($BusinessId) {
		$count = 0;
		try {	
		
			$branch = $this->db->selectRow(
				'SELECT hits FROM hits WHERE business_id ='.$BusinessId
				);
			
			if (is_array($branch) || is_object($branch))
			{
				$count = $branch['hits'];
			}
		}
		catch (Error $e) {
			throw new DatabaseError();
		}
		return $count;
	}
	
	private static function hash($data) {
		$hashRaw = hash(self::IP_ADDRESS_HASH_ALGORITHM, $data, true);

		return base64_encode($hashRaw);
	}
}
