<?php
	class Database {
		private $dbHost = DB_HOST;
		private $dbUser = DB_USER;
		private $dbPass = DB_PASS;
		private $dbName = DB_NAME;

		private $statement;
		private $dbHandler;
		private $error;

		public function __construct(){
			$conn = 'mysql:host=' . $this->dbHost .';dbname='. $this->dbName;
			$options = array(
				PDO::ATTR_PERSISTENT => true,
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			);
			try {
				$this->dbHandler = new PDO($conn, $this->dbUser, $this->dbPass, $options);
			} catch (PDOException $e) {
				$this->error =$e->getMessage();
				echo $this->error;
			}
		}
		// allows us to write query
		public function query($sql) {
			$this->statement = $this->dbHandler->prepare($sql);
		}
		//binding values
		public function bind($parameter, $value, $type = null){
			switch (is_null($type)) {
				case is_int($value):$type = PDO::PARM_INT;
				break;
				case is_bool($value):$type = PDO::PARM_BOOL;
				break;
				case is_null($value):$type = PDO::PARM_NULL;
				break;
				default:$type = PDO::PARM_STR;
		}
		$this->statement->bindValue($parameter,$value, $type);
	}
	// Execute the prepared statement
	public function execute(){
		return $this->statement->execute();
	}

	// returing an array
	public function resultSet(){
		$this->execute();
		return $this->statement->fetchAll(PDO::FETCH_OBJ);
	}
	// returing an single file
	public function single(){
		$this->execute();
		return $this->statement->fetch(PDO::FETCH_OBJ);
	}
	//Getting row count
	public function rowCount(){
		$this->statement->rowCount();
	}
	
}
