<?php

require_once 'impostazioni.abstract.class.php';

class includiVoceListino  extends impostazioniAbstract {

	public static $messaggio;

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
	}

	public function start() {

		error_log("<<<<<<< Start >>>>>>> " . $_SERVER['PHP_SELF']);
		
		require_once 'ricercaVociListino.class.php';
		
		if ($this->inserisci()) {
			$ricercaVociListino = new ricercaVociListino();
			$ricercaVociListino->setMessaggio('%ml.includiVoceOk%');
			$ricercaVociListino->start();
		}
		else {
			$ricercaVociListino = new ricercaVociListino();
			$ricercaVociListino->setMessaggio('%ml.includiVoceKo%');
			$ricercaVociListino->start();
		}		
	}

	private function inserisci() {
	
		require_once 'database.class.php';
	
		$db = new database();
		$db->beginTransaction();
	
		if ($this->creaVoceListino($db)) {
			$db->commitTransaction();
			return TRUE;
		}
		return FALSE;
	}
}
	
?>