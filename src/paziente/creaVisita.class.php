<?php

class creaVisita {

	private static $root;
	private static $azioneDentiSingoli = "../paziente/creaVisitaFacade.class.php?modo=go&tipo=singoli";
	private static $cognomeRicerca;
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
	public function setCognomeRicerca($cognomeRicerca) {
		self::$cognomeRicerca = $cognomeRicerca;
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
	public function getCognomeRicerca() {
		return self::$cognomeRicerca;
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
		
		require_once 'ricercaPaziente.class.php';
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
		
		$dentiSingoli = array();
		
		array_push($dentiSingoli, array('SD_18_1', $_POST['SD_18_1']), array('SD_17_1', $_POST['SD_17_1']), array('SD_16_1', $_POST['SD_16_1']));
		array_push($dentiSingoli, array('SD_15_1', $_POST['SD_15_1']), array('SD_14_1', $_POST['SD_14_1']), array('SD_13_1', $_POST['SD_13_1']));
		array_push($dentiSingoli, array('SD_12_1', $_POST['SD_12_1']), array('SD_11_1', $_POST['SD_11_1']));







		$visita->setDentiSingoli($dentiSingoli);

		include($testata);

		if ($visita->controlliLogici()) {
			if ($this->inserisci($visita)) {
				$ricercaPaziente = new ricercaPaziente();
				$ricercaPaziente->setMessaggio("%ml.creaVisitaOk%");
				$ricercaPaziente->setCognomeRicerca($this->getCognomeRicerca());
				$ricercaPaziente->go();
			}
			else {
				$visita->displayPagina();
				$replace = array('%messaggio%' => '%ml.creaVisitaKo%');
				
				$template = $utility->tailFile($utility->getTemplate($messaggioErrore), $replace);			
				echo $utility->tailTemplate($template);
			}
		}
		else {
			$paziente->displayPagina();
		} 

		include($piede);		
		
		
		
		
		
		
		
		
		
		
	}
		
	public function goGruppi() {
	}
		
	public function goCure() {
	}
		
	private function inserisci($visita) {

		$dentiSingoli = $visita->getDentiSingoli();
			
		for ($i = 0; $i < sizeof($dentiSingoli); $i++) {





		
		}		
		return TRUE;
	}
}

?>
