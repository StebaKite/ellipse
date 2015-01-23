<?php

require_once 'impostazioni.abstract.class.php';

class escludiVoceListino  extends impostazioniAbstract {

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
		$pathToInclude = self::$root . "/ellipse/src/impostazioni:" . self::$root . "/ellipse/src/utility";
		set_include_path($pathToInclude);
	}

	public function start() {
	
		error_log("<<<<<<< Start >>>>>>> " . $_SERVER['PHP_SELF']);
	
		require_once 'ricercaVociListino.class.php';
	
		if ($this->cancella()) {
			$ricercaVociListino = new ricercaVociListino();
			$ricercaVociListino->setMessaggio('%ml.escludiVoceOk%');
			$ricercaVociListino->start();
		}
		else {
			$ricercaVociListino = new ricercaVociListino();
			$ricercaVociListino->setMessaggio('%ml.escludiVoceKo%');
			$ricercaVociListino->start();
		}
	}
	
	private function cancella() {
	
		require_once 'database.class.php';
	
		$db = new database();
		$db->beginTransaction();
	
		if ($this->cancellaVoceListino($db)) {
			$db->commitTransaction();
			return TRUE;
		}
		return FALSE;
	}
	}
?>