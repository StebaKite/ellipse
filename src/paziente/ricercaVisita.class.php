<?php

require_once 'visitaPaziente.abstract.class.php';

class ricercaVisita  extends visitaPazienteAbstract {

	private static $messaggio;
	private static $queryRicercaVisitaPaziente = "/paziente/ricercaVisitaPaziente.sql";

	function __construct() {
		self::$root = $_SERVER['DOCUMENT_ROOT'];
	}

	// Setters ---------------------------------
	
	public function setMessaggio($messaggio) {
		self::$messaggio = $messaggio;
	}

	// Getters --------------------------------

	public function getMessaggio() {
		return self::$messaggio;
	}

	public function start() {
		
		require_once 'ricercaVisita.template.php';
		require_once 'utility.class.php';

		// Template
		$utility = new utility();
		$array = $utility->getConfig();

		$testata = self::$root . $array['testataPagina'];
		$piede = self::$root . $array['piedePagina'];		
		
		$ricercaVisitaTemplate = new ricercaVisitaTemplate();
		
		// Il messaggio		
		$ricercaVisitaTemplate->setMessaggio($this->getMessaggio());
		$ricercaVisitaTemplate->setCognomeRicerca($this->getCognomeRicerca());
		$ricercaVisitaTemplate->setCognome($this->getCognomeRicerca());
		
		if ($this->ricerca($ricercaVisitaTemplate)) {

			// compone la pagina
			include($testata);
			$ricercaVisitaTemplate->displayFiltri();		
			$ricercaVisitaTemplate->displayRisultati();		
			include($piede);
		}	
	}
	
	public function go() {
	}
		
	private function controlli() {
	
		$esito = True;
		
		return $esito; 	
	}
	
	private function ricerca($ricercaVisitaTemplate) {

		require_once 'database.class.php';

		$esito = TRUE;

		// carica e ritaglia il comando sql da lanciare
		
		$replace = array('%idpaziente%' => $this->getIdPaziente());

		$utility = new utility();
		$array = $utility->getConfig();
		$sqlTemplate = self::$root . $array['query'] . self::$queryRicercaVisitaPaziente;

		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);

		// esegue la query
		
		$db = new database();
		$result = $db->getData($sql);
		
		$ricercaVisitaTemplate->setNumeroVisiteTrovate(pg_num_rows($result));	
		$ricercaVisitaTemplate->setVisiteTrovate($result);
		
		return $esito;	
	}
}
?>
