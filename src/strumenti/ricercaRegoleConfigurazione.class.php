<?php

require_once 'strumenti.abstract.class.php';

class ricercaRegoleConfigurazione extends strumentiAbstract {

	private static $messaggio;
	public static $azioneRicercaRegoleConfigurazione = "../strumenti/ricercaRegoleConfigurazioneFacade.class.php?modo=go";

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
		$pathToInclude = self::$root . "/ellipse/src/strumenti:" . self::$root . "/ellipse/src/utility";
		set_include_path($pathToInclude);

		require_once 'utility.class.php';

		$utility = new utility();
		$array = $utility->getConfig();

		self::$testata = self::$root . $array['testataPagina'];
		self::$piede = self::$root . $array['piedePagina'];
		self::$messaggioErrore = self::$root . $array['messaggioErrore'];
		self::$messaggioInfo = self::$root . $array['messaggioInfo'];
	}

	// ------------------------------------------------

	public function start() {

		error_log("<<<<<<< Start >>>>>>> " . $_SERVER['PHP_SELF']);

		require_once 'ricercaRegoleConfigurazione.template.php';
		require_once 'utility.class.php';
		
		$ricercaRegoleConfigurazioneTemplate = new ricercaRegoleConfigurazioneTemplate();
		$ricercaRegoleConfigurazioneTemplate->setMessaggio($this->getMessaggio());
		
		if ($this->ricerca($ricercaRegoleConfigurazioneTemplate)) {
		
			// compone la pagina
			include(self::$testata);
			$ricercaRegoleConfigurazioneTemplate->displayFiltri();
			$ricercaRegoleConfigurazioneTemplate->displayRisultati();
			include(self::$piede);
		}
	}

	public function go() {}

	private function ricerca($ricercaRegoleConfigurazioneTemplate) {
	
		require_once 'database.class.php';
	
		$esito = TRUE;
	
		// carica il comando sql da lanciare
		$replace = array('%idguida%' => $this->getIdguida());
		
		$utility = new utility();
		$array = $utility->getConfig();
		$sqlTemplate = self::$root . $array['query'] . self::$queryRegoleConfigurazioni;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		
		$db = new database();
		$result = $db->getData($sql);
					
		$ricercaRegoleConfigurazioneTemplate->setNumeroRegoleConfigurazioniTrovate(pg_num_rows($result));
		$ricercaRegoleConfigurazioneTemplate->setRegoleConfigurazioniTrovate($result);
		return $esito;
	}	
}	
	
?>