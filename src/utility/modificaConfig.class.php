<?php

class modificaConfig {

	private static $root;
	private static $cognomeRicerca;
	private static $azione = "../utility/modificaConfigFacade.class.php?modo=go";

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
