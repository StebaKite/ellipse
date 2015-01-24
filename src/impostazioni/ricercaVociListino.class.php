<?php

require_once 'impostazioni.abstract.class.php';

class ricercaVociListino  extends impostazioniAbstract {

	public static $messaggio;
	public static $queryRicercaVociListino = "/impostazioni/ricercaVociListino.sql";
	public static $queryRicercaVociDisponibili = "/impostazioni/ricercaVociDisponibili.sql";
	
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

		require_once 'ricercaVociListino.template.php';

		$ricercaVociListinoTemplate = new ricercaVociListinoTemplate();
		$ricercaVociListinoTemplate->setMessaggio($this->getMessaggio());

		if ($this->ricerca($ricercaVociListinoTemplate) and $this->ricercaVociDisponibili($ricercaVociListinoTemplate)) {

			// compone la pagina
			include(self::$testata);
			$ricercaVociListinoTemplate->displayFiltri();
			$ricercaVociListinoTemplate->displayRisultati();
			include(self::$piede);
		}
	}

	public function go() {}
	
	public function ricerca($ricercaVociListinoTemplate) {
	
		require_once 'database.class.php';
	
		$esito = TRUE;
	
		// carica il comando sql da lanciare
	
		$utility = new utility();
		$array = $utility->getConfig();
		$sqlTemplate = self::$root . $array['query'] . self::$queryRicercaVociListino;
	
		$replace = array('%idlistino%' => $this->getIdlistino());
	
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$db = new database();
		$result = $db->getData($sql);
	
		$ricercaVociListinoTemplate->setNumeroVociListinoTrovate(pg_num_rows($result));
		$ricercaVociListinoTemplate->setVociListinoTrovate($result);
		return $esito;
	}	

	public function ricercaVociDisponibili($ricercaVociListinoTemplate) {
	
		require_once 'database.class.php';
	
		$esito = TRUE;
	
		// carica il comando sql da lanciare
	
		$utility = new utility();
		$array = $utility->getConfig();
		$sqlTemplate = self::$root . $array['query'] . self::$queryRicercaVociDisponibili;
	
		$replace = array('%idlistino%' => $this->getIdlistino());
	
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$db = new database();
		$result = $db->getData($sql);
	
		$ricercaVociListinoTemplate->setVociDisponibiliTrovate($result);
		return $esito;
	}	
}
	
?>