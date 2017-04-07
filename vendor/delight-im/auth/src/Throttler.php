<?php


namespace Delight\Auth;

use Delight\Db\PdoDatabase;
use Delight\Db\PdoDsn;
use Delight\Db\Throwable\Error;
use Delight\Db\Throwable\IntegrityConstraintViolationException;

require_once __DIR__ . '/Exceptions.php';

class Throttler {

	private $db;
	private $ipAddress;
	private $throttlingTimeBucketSize;
	private $throttlingActionsPerTimeBucket;
	
	const IP_ADDRESS_HASH_ALGORITHM = 'sha256';
	const HTTP_STATUS_CODE_TOO_MANY_REQUESTS = 429;
	
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
		$this->throttlingTimeBucketSize = 3600;
		$this->throttlingActionsPerTimeBucket = 20;
	}
	
	
	public function throttle($actionType, $customSelector = null) {
		// if a custom selector has been provided (e.g. username, user ID or confirmation token)
		if (isset($customSelector)) {
			// use the provided selector for throttling
			$selector = self::hash($customSelector);
		}
		// if no custom selector was provided
		else {
			// throttle by the user's IP address
			$selector = self::hash($this->getIpAddress());
		}

		// get the time bucket that we do the throttling for
		$timeBucket = self::getTimeBucket();

		try {
			$this->db->insert(
				'users_throttling',
				[
					'action_type' => $actionType,
					'selector' => $selector,
					'time_bucket' => $timeBucket,
					'attempts' => 1
				]
			);
		}
		catch (IntegrityConstraintViolationException $e) {
			// if we have a duplicate entry, update the old entry
			try {
				$this->db->exec(
					'UPDATE users_throttling SET attempts = attempts+1 WHERE action_type = ? AND selector = ? AND time_bucket = ?',
					[
						$actionType,
						$selector,
						$timeBucket
					]
				);
			}
			catch (Error $e) {
				throw new DatabaseError();
			}
		}
		catch (Error $e) {
			throw new DatabaseError();
		}

		try {
			$attempts = $this->db->selectValue(
				'SELECT attempts FROM users_throttling WHERE action_type = ? AND selector = ? AND time_bucket = ?',
				[
					$actionType,
					$selector,
					$timeBucket
				]
			);
		}
		catch (Error $e) {
			throw new DatabaseError();
		}

		if (!empty($attempts)) {
			// if the number of attempts has acceeded our accepted limit
			if ($attempts > $this->throttlingActionsPerTimeBucket) {
				self::onTooManyRequests($this->throttlingTimeBucketSize);
			}
		}
	}


	
	
	
	
	private static function hash($data) {
		$hashRaw = hash(self::IP_ADDRESS_HASH_ALGORITHM, $data, true);

		return base64_encode($hashRaw);
	}

	public function getIpAddress() {
		return $this->ipAddress;
	}
	
	private function getTimeBucket() {
		return (int) (time() / $this->throttlingTimeBucketSize);
	}
	
	private static function onTooManyRequests($retryAfterInterval = null) {
		// if no interval has been provided after which the client should retry
		if ($retryAfterInterval === null) {
			// use one day as the default
			$retryAfterInterval = 60 * 60 * 24;
		}

		// send an appropriate HTTP status code
		http_response_code(self::HTTP_STATUS_CODE_TOO_MANY_REQUESTS);
		// tell the client when they should try again
		@header('Retry-After: '.$retryAfterInterval);
		// throw an exception
		throw new TooManyRequestsException();
	}

	

}
