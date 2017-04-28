<?php

Class Config{
	
	public static $host = 'localhost';
	public static $db = 'cinderella';
	public static $username = 'root';
	public static $pwd = '';
	public static $port = 3306;
	public static $domain = 'localhost/cinderella/';
	public static $recaptcha = '6LfSRhUUAAAAAFEdLWxrneyWgpLgtg8JaP6d74r0';
	
	public static $tp = '076 5537100 / 0715104647';
	
	public static function initDb(){
		$db = new PDO('mysql:dbname='.Config::$db.';host='.Config::$host.';port='.Config::$port.';charset=utf8mb4', Config::$username,Config::$pwd);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $db;
	}

}
?>