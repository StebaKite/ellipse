<?php

Class database {

	private static $root;
	private static $dblink;
	private static $lastIdUsed;
	private static $numrows;

	function __construct() {
		
		self::$root = $_SERVER['DOCUMENT_ROOT'];
	}

	public function getDbLink() {
		return self::$dblink;
	}
	public function getLastIdUsed() {
		return self::$lastIdUsed;
	}
	public function getNumrows() {
		return self::$numrows;
	}

	public function setDbLink($dblink) {
		self::$dblink = $dblink;
	}
	public function setLastIdUsed($lastIdUsed) {
		self::$lastIdUsed = $lastIdUsed;
	}
	public function setNumrows($numrows) {
		self::$numrows = $numrows;
	}

	public function getLink() {

		require_once 'utility.class.php';

		$utility = new utility();
		$array = $utility->getConfig();

		$dsn = "host=" . $array['hostname'] . " port=" . $array['portnum'] . " dbname=" . $array['dbname'] . " user=" . $array['username'] . " password=" . $array['password']; 

		// Create connection
		$dblink = pg_connect("$dsn") or die('Connection failed');
		
		// restituisco un oggetto connessione
		return $dblink;			
	}

	public function getData($sql) {

		error_log("ESEGUO LA QUERY : " . $sql);
		$dblink = $this->getLink();
		$result = pg_query($dblink, $sql);
		pg_close($dblink); 
		return $result;
	}
	
	public function beginTransaction() {

		$dblink = $this->getLink();
		$result = pg_query($dblink, "BEGIN");
		
		if ($result) {
			error_log("BEGIN TRANSACTION");
			$this->setDbLink($dblink);
		}
	}
	
	public function commitTransaction() {
		
		$result = pg_query($this->getDbLink(), "COMMIT");
		
		if ($result) {
			error_log("COMMIT TRANSACTION");
			pg_close($this->getDbLink()); 
		}		
	}
	
	public function rollbackTransaction() {
	
		$result = pg_query($this->getDbLink(), "ROLLBACK");
		
		if ($result) {
			error_log("ROLLBACK TRANSACTION");
			pg_close($this->getDbLink()); 
		}		
	}
		
	public function execSql($sql) {

		if ($this->getDbLink() == null) {
			error_log("CONNESSIONE AL DATABASE NON STABILITA");
			return FALSE;
		}
		else {
			
			// Esegue la query e se sulla INSERT e' impostata la clausola RETURNING, salva l'ID usato
			// Salva il numero di righe risultato della query
			
			error_log("ESEGUO LA QUERY : " . $sql);
			$result = pg_query($this->getDbLink(), $sql);
			
			$row = pg_fetch_row($result);			
			$this->setLastIdUsed($row['0']);
			
			$this->setNumrows(pg_num_rows($result));	
			return $result;	
		}
	}
	
	public function closeDbLink() {

		if (pg_close($this->getDbLink()))
			error_log("CONNESSIONE AL DATABASE CHIUSA CON SUCCESSO");
		else
			error_log("Errore durante la chiusura della connessione al DB");
	}
}

?>
