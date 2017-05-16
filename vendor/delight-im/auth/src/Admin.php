<?php

namespace Delight\Auth;

use Delight\Db\PdoDatabase;
use Delight\Db\PdoDsn;
use Delight\Db\Throwable\Error;
use Delight\Db\Throwable\IntegrityConstraintViolationException;

require_once __DIR__ . '/Exceptions.php';

class Admin {

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

    public function ApproveBusiness($business_id, $approve){
        try{
            if ($approve == null) {
               $approve = '0';
            }
            $this->db->update(
				'business',
				[ 'approve' => $approve],
				[ 'id' => $business_id ]
			);
        }
        catch (Error $e) {
			throw new DatabaseError();
		}
		catch (Exception $e) {
			return '1';
		}
    }

    public function ApproveMedia($media_id, $approve){
        try{
            if ($approve == null) {
               $approve = '0';
            }
            $this->db->update(
				'media',
				[ 'approve' => $approve],
				[ 'id' => $media_id ]
			);
        }
        catch (Error $e) {
			throw new DatabaseError();
		}
		catch (Exception $e) {
			return '1';
		}
    }
}

?>