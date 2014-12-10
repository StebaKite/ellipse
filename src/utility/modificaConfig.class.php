<?php

class modificaConfig {

	private static $root;
	private static $cognomeRicerca;
	private static $azione = "../utility/modificaConfigFacade.class.php?modo=go";
	private static $configFile = "/ellipse/config/ellipse.config.ini";

	function __construct() {
		
		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/paziente:" . self::$root . "/ellipse/src/utility";  
		set_include_path($pathToInclude);		
	}

	public function getAzione() {
		return self::$azione;
	}

	public function start() {

		require_once 'utility.class.php';
		require_once 'modificaConfig.template.php';

		// Template
		$utility = new utility();
		$array = $utility->getConfig();

		$testata = self::$root . $array['testataPagina'];
		$piede = self::$root . $array['piedePagina'];
		$messaggioErrore = self::$root . $array['messaggioErrore'];
		$messaggioInfo = self::$root . $array['messaggioInfo'];

		$config = new config();
		$config->setAzione($this->getAzione());
		
		$config->setTitoloPagina("%ml.modificaConfig%");
		$config->setModificaConfig($config);		
		
		$file = self::$root . self::$configFile;
		$cnf = parse_ini_file($file);
		$config->setHostname($cnf['hostname']);
		$config->setPortnum($cnf['portnum']);
		$config->setUser($cnf['username']);
		$config->setPassword($cnf['password']);
		
		if ($cnf['dbname'] == "ellipse.prod") {
			 $config->setDatabaseProd("checked");
			 $config->setDatabaseTest("");
		}
		if ($cnf['dbname'] == "ellipse.test") {
			 $config->setDatabaseTest("checked");
			 $config->setDatabaseProd("");
		 }
			
		
		// Compone la pagina
		include($testata);
		$config->inizializzaPagina();
		$config->displayPagina();
		include($piede);
	}

	public function go() {
	}
}

?>
