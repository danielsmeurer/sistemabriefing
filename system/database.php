<?php
class Database extends PDO {
	protected static $instance;
	protected static $host = '';
	protected static $port = '3306';
	protected static $user = '';
	protected static $pass = '';
	protected static $db   = '';
	
	public function __construct() {
		self::$instance = new PDO('mysql:host=' . self::$host . ';port=' . self::$port .';dbname=' . self::$db , self::$user , self::$pass );
	}
	
	public static function getInstance(){
		return self::$instance;
	}
}


