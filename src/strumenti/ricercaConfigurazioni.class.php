<?php

require_once 'strumenti.abstract.class.php';

class ricercaConfigurazioni  extends strumentiAbstract {

	private static $messaggio;
	private static $queryRicercaConfigurazioni = "/strumenti/ricercaConfigurazioni.sql";

	// Setters ---------------------------------
	
	public function setMessaggio($messaggio) {
		self::$messaggio = $messaggio;
	}
	
	// Getters --------------------------------
	
	public function getMessaggio() {
		return self::$messaggio;
	}
	
	function __construct() {
	
		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/paziente:" . self::$root . "/ellipse/src/utility";
		set_include_path($pathToInclude);
		
		require_once 'utility.class.php';
		
		$utility = new utility();
		$array = $utility->getConfig();
		
		self::$testata = self::$root . $array['testataPagina'];
		self::$piede = self::$root . $array['piedePagina'];
		self::$messaggioErrore = self::$root . $array['messaggioErrore'];
		self::$messaggioInfo = self::$root . $array['messaggioInfo'];
	}
	
	public function start() {

		error_log("<<<<<<< Start >>>>>>> " . $_SERVER['PHP_SELF']);
		
		require_once 'ricercaConfigurazioni.template.php';
				
		$ricercaConfigurazioniTemplate = new ricercaConfigurazioniTemplate();
		$ricercaConfigurazioniTemplate->setMessaggio($this->getMessaggio());
		
		if ($this->ricerca($ricercaConfigurazioniTemplate)) {
		
			// compone la pagina
			include(self::$testata);
			$ricercaConfigurazioniTemplate->displayFiltri();		
			$ricercaConfigurazioniTemplate->displayRisultati();
			include(self::$piede);
		}	
	}
	
	public function go() {}
	
	private function ricerca($ricercaConfigurazioniTemplate) {

		require_once 'database.class.php';
		
		$esito = TRUE;
		
		// carica il comando sql da lanciare
		
		$utility = new utility();
		$array = $utility->getConfig();
		$sqlTemplate = self::$root . $array['query'] . self::$queryRicercaConfigurazioni;
		
		$sql = $utility->getTemplate($sqlTemplate);
		
		$db = new database();
		$result = $db->getData($sql);
		
		$ricercaConfigurazioniTemplate->setNumeroConfigurazioniTrovate(pg_num_rows($result));	
		$ricercaConfigurazioniTemplate->setConfigurazioniTrovate($result);		
		return $esito;
	}	
}

?>