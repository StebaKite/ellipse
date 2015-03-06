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

		include($testata);
		$ricercaPreventivoTemplate->displayFiltri();
		
		if ($this->ricerca($ricercaPreventivoTemplate)) {
			$ricercaPreventivoTemplate->displayRisultati();
		}
		else {
			$replace = array('%messaggio%' => $text0 . '%ml.ricercaPreventivoKo%');
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);			
			echo $utility->tailTemplate($template);				
		}
		include($piede);
		
	}
	
	public function go() { }

	private function ricerca($ricercaPreventivoTemplate) {
	
		require_once 'database.class.php';
	
		// carica e ritaglia il comando sql da lanciare
	
		$replace = array('%idpaziente%' => $_SESSION['idPaziente']);
	
		$utility = new utility();
		$array = $utility->getConfig();
		$sqlTemplate = self::$root . $array['query'] . self::$queryRicercaPreventivoPaziente;
	
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
	
		// esegue la query
	
		$db = new database();
		$result = $db->getData($sql);
	
		$_SESSION['numeroPreventiviTrovati'] = pg_num_rows($result);
		$_SESSION['preventiviTrovati'] = $result;
	
		return $result;
	}
}

?>