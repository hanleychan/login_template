<?php
define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "login");

class MySqlDatabase {
	private $connection;
	
	function __construct() {
		$this->open_connection();
	}
	
	public function open_connection() {
		$this->connection = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
		if($this->connection->errno) {
			die("Database connection failed: " . $this->connection->error . " (" . $this->connection->errno . ")");
		}
	}
	
	public function close_connection() {
		if(isset($this->connection)) {
			$this->connection->close();
			unset($this->connection);
		}
	}
	
	public function query($sql) {
		$result = $this->connection->query($sql);
		if(!$result) {
			die("Database query failed." . $this->connection->error);
		}
		return $result;
	}

	public function escape_string($string) {
		return $this->connection->real_escape_string($string);	
	}
	
	public function fetch_array($result_set) {
		return $result_set-> fetch_assoc();
	}
}

$database = new MySqlDatabase();

?>
