<?php

require_once 'impostazioni.abstract.class.php';

class ricercaCategoria  extends impostazioniAbstract {

	private static $messaggio;
	private static $queryRicercaCategoria = "/impostazioni/ricercaCategoria.sql";

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
		
		require_once 'ricercaCategoria.template.php';
				
		$ricercaCategoriaTemplate = new ricercaCategoriaTemplate();
		$ricercaCategoriaTemplate->setMessaggio($this->getMessaggio());
		
		if ($this->ricerca($ricercaCategoriaTemplate)) {
		
			// compone la pagina
			include(self::$testata);
			$ricercaCategoriaTemplate->displayFiltri();		
			$ricercaCategoriaTemplate->displayRisultati();
			include(self::$piede);
		}	
	}
	
	public function go() {}
	
	private function ricerca($ricercaCategoriaTemplate) {
		
		require_once 'database.class.php';
		
		$esito = TRUE;
		
		// carica il comando sql da lanciare
		
		$utility = new utility();
		$array = $utility->getConfig();
		$sqlTemplate = self::$root . $array['query'] . self::$queryRicercaCategoria;
		
		$sql = $utility->getTemplate($sqlTemplate);
		
		$db = new database();
		$result = $db->getData($sql);
		
		$ricercaCategoriaTemplate->setNumeroCategorieTrovate(pg_num_rows($result));
		$ricercaCategoriaTemplate->setCategorieTrovate($result);
		return $esito;
	}
}		
		
?>