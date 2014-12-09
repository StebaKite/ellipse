<?php

Class database {

	private static $root;

	function __construct() {
		
		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/paziente:" . self::$root . "/ellipse/src/utility";  
		set_include_path($pathToInclude);		
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

		$dblink = $this->getLink();
		$result = pg_query($dblink, $sql);
		pg_close($dblink); 
		return $result;
	}	
}

?>
