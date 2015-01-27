<?php

require_once 'preventivo.abstract.class.php';

class ricercaPreventivo extends preventivoAbstract {

	private static $queryRicercaPreventivoPaziente = "/preventivo/ricercaPreventivoPaziente.sql";
	
	function __construct() {
		self::$root = $_SERVER['DOCUMENT_ROOT'];
	}

	public function start() {
	
		require_once 'ricercaPreventivo.template.php';
		require_once 'utility.class.php';
	
		// Template
		$utility = new utility();
		$array = $utility->getConfig();
	
		$testata = self::$root . $array['testataPagina'];
		$piede = self::$root . $array['piedePagina'];
	
		$ricercaPreventivoTemplate = new ricercaPreventivoTemplate();
	
		// Il messaggio
		$ricercaPreventivoTemplate->setMessaggio($this->getMessaggio());
		$ricercaPreventivoTemplate->setCognomeRicerca($this->getCognomeRicerca());
	
		if ($this->ricerca($ricercaPreventivoTemplate)) {
	
			// compone la pagina
			include($testata);
			$ricercaPreventivoTemplate->displayFiltri();
			$ricercaPreventivoTemplate->displayRisultati();
			include($piede);
		}
	}
	
	public function go() { }

	private function ricerca($ricercaPreventivoTemplate) {
	
		require_once 'database.class.php';
	
		$esito = TRUE;
	
		// carica e ritaglia il comando sql da lanciare
	
		$replace = array('%idpaziente%' => $this->getIdPaziente());
	
		$utility = new utility();
		$array = $utility->getConfig();
		$sqlTemplate = self::$root . $array['query'] . self::$queryRicercaPreventivoPaziente;
	
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
	
		// esegue la query
	
		$db = new database();
		$result = $db->getData($sql);
	
		$ricercaPreventivoTemplate->setNumeroPreventiviTrovati(pg_num_rows($result));
		$ricercaPreventivoTemplate->setPreventiviTrovati($result);
	
		return $esito;
	}
}

?>