<?php

require_once 'preventivo.abstract.class.php';

class ricercaNotaPreventivo extends preventivoAbstract {

	private static $queryRicercaNotaPreventivo = "/preventivo/ricercaNotaPreventivo.sql";

	function __construct() {
		self::$root = $_SERVER['DOCUMENT_ROOT'];
	}

	public function start() {
		
	}

	public function go() {
		
	}

	private function ricerca() {
		
	}
}

?>