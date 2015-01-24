<?php

require_once 'impostazioni.abstract.class.php';

class ricercaListino extends impostazioniAbstract {

	private static $messaggio;
	private static $queryRicercaListino = "/impostazioni/ricercaListino.sql";

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
	
		require_once 'ricercaListino.template.php';
	
		$ricercaListinoTemplate = new ricercaListinoTemplate();
		$ricercaListinoTemplate->setMessaggio($this->getMessaggio());
	
		if ($this->ricerca($ricercaListinoTemplate)) {
	
			// compone la pagina
			include(self::$testata);
			$ricercaListinoTemplate->displayFiltri();
			$ricercaListinoTemplate->displayRisultati();
			include(self::$piede);
		}
	}
	
	public function go() {}

	private function ricerca($ricercaListinoTemplate) {
	
		require_once 'database.class.php';
	
		$esito = TRUE;
	
		// carica il comando sql da lanciare
	
		$utility = new utility();
		$array = $utility->getConfig();
		$sqlTemplate = self::$root . $array['query'] . self::$queryRicercaListino;
	
		$sql = $utility->getTemplate($sqlTemplate);
	
		$db = new database();
		$result = $db->getData($sql);
	
		$ricercaListinoTemplate->setNumeroListiniTrovati(pg_num_rows($result));
		$ricercaListinoTemplate->setListiniTrovati($result);
		return $esito;
	}
}
	
?>