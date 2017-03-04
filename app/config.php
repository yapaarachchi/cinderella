<?php

Class Config{
	
	public static $host = 'localhost';
	public static $db = 'cinderella';
	public static $username = 'root';
	public static $pwd = '';
	public static $port = 3306;
	public static $domain = 'localhost/cinderella/';
	
	public static function initDb(){
		$db = new PDO('mysql:dbname='.Config::$db.';host='.Config::$host.';port='.Config::$port.';charset=utf8mb4', Config::$username,Config::$pwd);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $db;
	}

}
?>