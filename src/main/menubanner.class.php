<?php

require_once 'ellipse.abstract.class.php';

class menubanner extends ellipseAbstract {

	private static $messaggio;
	private static $queryTotaliProgressivi = "/main/totaliProgressivi.sql";

	function __construct() {
		
		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/main:" . self::$root . "/ellipse/src/utility";  
		error_log($pathToInclude);
		set_include_path($pathToInclude);
	}

	public function start() {

		session_start();
			
		require_once 'menubanner.template.php';
		require_once 'utility.class.php';
		require_once 'database.class.php';

		error_log("<<<<<<< Start >>>>>>> " . $_SERVER['PHP_SELF']);

		/**
		 * Scrivo in sessione un securecode che tutte le funzioni facade devono riconoscere
		 */
				
		$_SESSION['secureCode'] = '4406105963138001';
		
		// Template
		$utility = new utility();
		$db = new database();

		$array = $utility->getConfig();

		$testata = self::$root . $array['testataPagina'];
		$piede = self::$root . $array['piedePagina'];		

		$menubannerTemplate = new menubannerTemplate();
		
		//-------------------------------------------------------------
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryTotaliProgressivi;
		$sql = $utility->getTemplate($sqlTemplate);
		$result = $db->getData($sql);
			
		if ($result) $menubannerTemplate->setTotaliProgressivi(pg_fetch_all($result));
		else $menubannerTemplate->setTotaliProgressivi("");
		
		// compone la pagina
		include($testata);
		$menubannerTemplate->displayPagina();
		include($piede);
	}
}

?>
