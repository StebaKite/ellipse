<?php

require_once 'strumenti.abstract.class.php';

class categoria extends strumentiAbstract {
	
	public static $queryRegoleConfigurazioni = "/strumenti/ricercaRegoleConfigurazioni.sql";
	public static $queryCreaCategoria = "/impostazioni/creaCategoria.sql";
	
	function __construct() {
		self::$root = $_SERVER['DOCUMENT_ROOT'];
	}
	
	public function start($db, $utility, $row) {

		$mess = $this->getMessaggi();		
		array_push($mess, "<br>" . "<<<<<<< Start della classe >>>>>>> " . "<br>");
		$this->setMessaggi($mess);
		
		$rows = $this->caricaRegoleMapping($db, $utility, $row);
		$temp = $this->caricaFileDati($row);
		
		/*
		 * se l'inserimento non prevede il recupero di chiavi esterne è sufficiente chiamare il metodo
		 * inserisciDati() 
		 * 
		 * se l'inserimento prevede il recupero di chiavi esterne in questa classe devi fare l'override
		 * del metodo componiInserimento()
		 * 
		 */
		if ($temp != "") {
			$this->inserisciDati($db, $utility, $row, self::$queryCreaCategoria, $temp, $rows);
			return TRUE;
		}
		else {
			return FALSE;
		}
	}
}

?>
