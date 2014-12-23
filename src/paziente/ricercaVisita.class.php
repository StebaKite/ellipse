<?php

class ricercaVisita {

	private static $root;

	private static $messaggio;
	private static $cognomeRicerca;
	private static $idPaziente;
	private static $idListino;
	private static $queryRicercaVisitaPaziente = "/paziente/ricercaVisitaPaziente.sql";

	function __construct() {
		
		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/paziente:" . self::$root . "/ellipse/src/utility";  
		set_include_path($pathToInclude);
	}

	// Setters ---------------------------------
	public function setMessaggio($messaggio) {
		self::$messaggio = $messaggio;
	}
	public function setCognomeRicerca($cognomeRicerca) {
		self::$cognomeRicerca = $cognomeRicerca;
	}
	public function setIdPaziente($idPaziente) {
		self::$idPaziente = $idPaziente;
	}
	public function setIdListino($idListino) {
		self::$idListino = $idListino;
	}
	
	// Getters --------------------------------
	public function getMessaggio() {
		return self::$messaggio;
	}
	public function getCognomeRicerca() {
		return self::$cognomeRicerca;
	}
	public function getIdPaziente() {
		return self::$idPaziente;
	}
	public function getIdListino() {
		return self::$idListino;
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
