<?php

class creaVisita {

	private static $root;
	private static $azioneDentiSingoli = "../paziente/creaVisitaFacade.class.php?modo=go&tipo=singoli";
	private static $idPaziente;
	private static $idListino;

	function __construct() {
		
		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/paziente:" . self::$root . "/ellipse/src/utility";  
		set_include_path($pathToInclude);		
	}

	// ------------------------------------------------

	public function setIdPaziente($idPaziente) {
		self::$idPaziente = $idPaziente;
	}
	public function setIdListino($idListino) {
		self::$idListino = $idListino;
	}

	// ------------------------------------------------
	
	public function getAzioneDentiSingoli() {
		return self::$azioneDentiSingoli;
	}
	public function getIdPaziente() {
		return self::$idPaziente;
	}
	public function getIdListino() {
		return self::$idListino;
	}

	// ------------------------------------------------

	public function start() {

		require_once 'visita.template.php';
		require_once 'utility.class.php';

		// Template
		$utility = new utility();
		$array = $utility->getConfig();

		$testata = self::$root . $array['testataPagina'];
		$piede = self::$root . $array['piedePagina'];
		$messaggioErrore = self::$root . $array['messaggioErrore'];
		$messaggioInfo = self::$root . $array['messaggioInfo'];

		$visita = new visita();		
		$visita->setIdPaziente($this->getIdPaziente());
		$visita->setIdListino($this->getIdListino());
		
		$this->startSingoli($visita);
		
		
				
		$visita->setTitoloPagina("%ml.creaNuovaVisita%");
		$visita->setVisita($visita);		

		// Compone la pagina
		include($testata);
		$visita->inizializzaPagina();
		$visita->displayPagina();
		include($piede);		
	}

	public function startSingoli($visita) {

		$visita->setAzioneDentiSingoli($this->getAzioneDentiSingoli());
		$visita->setConfermaTip("%ml.confermaCreazioneVisita%");		
	}
		
	public function go() {
	}
		
	public function goSingoli() {
	}
		
	public function goGruppi() {
	}
		
	public function goCure() {
	}
		
	private function inserisci($visita) {
	}
}

?>
