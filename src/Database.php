<?php 

/**
 * Mysql database class - only one connection alowed
 */
class Database
{
	private $connection;
	private static $_instance; //The single instance

	/*
	Get an instance of the Database
	@return Instance
	*/
	public static function getInstance() {
		if(!self::$_instance) { // If no instance then make one
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	function __construct()
	{

		$config = require_once('config/db.php');
		$this->connection = new mysqli(
			$config['host'], 
			$config['user'], 
			$config['password'],
			$config['database'], 
		);

	}

	// Magic method clone is empty to prevent duplication of connection
	private function __clone() { }

	// Get mysqli connection
	public function getConnection() {
		return $this->connection;
	}

}

