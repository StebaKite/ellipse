<?php

require_once 'visitaPaziente.abstract.class.php';

class ricercaPreventivo  extends preventivoPazienteAbstract {

	private static $messaggio;
	private static $queryRicercaVisitaPaziente = "/paziente/ricercaVisitaPaziente.sql";

	function __construct() {
		self::$root = $_SERVER['DOCUMENT_ROOT'];
	}

	
}

?>