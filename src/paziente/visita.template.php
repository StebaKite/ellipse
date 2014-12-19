<?php

class visita {
	
	private static $root;
	private static $pagina = "/paziente/visita.form.html";
	private static $queryVociListinoPaziente = "/paziente/ricercaVociListinoPaziente.sql";
	
	private static $azioneDentiSingoli;
	private static $confermaTip;
	private static $titoloPagina;
	private static $messaggio;	

	private static $idPaziente;
	private static $idListino;
	private static $idVisita;
	private static $visita;
	private static $esitoControlliLogici;
	
	private static $riepilogoDentiSingoli;
	private static $dentiSingoli;
	

//	private static $
	
	//-----------------------------------------------------------------------------

	function __construct() {
		
		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/paziente:" . self::$root . "/ellipse/src/utility";  
		set_include_path($pathToInclude);		
	}

	//-----------------------------------------------------------------------------
	// Setters --------------------------------------------------------------------
	
	public function setAzioneDentiSingoli($azioneDentiSingoli) {
		self::$azioneDentiSingoli = $azioneDentiSingoli;
	}
	public function setConfermaTip($tip) {
		self::$confermaTip = $tip;
	}
	public function setTitoloPagina($titoloPagina) {
		self::$titoloPagina = $titoloPagina;
	}
	public function setMessaggio($messaggio) {
		self::$messaggio = $messaggio;
	}
	public function setIdPaziente($idPaziente) {
		self::$idPaziente = $idPaziente;
	}
	public function setIdVisita($idVisita) {
		self::$idVisita = $idVisita;
	}
	public function setIdListino($idListino) {
		self::$idListino = $idListino;
	}
	public function setVisita($visita) {
		self::$visita = $visita;
	}
	public function setEsitoControlloLogici($esito) {
		self::$esitoControlliLogici = $esito;
	}
	public function setRiepilogoDentiSingoli($riepilogoDentiSingoli) {
		self::$riepilogoDentiSingoli = $riepilogoDentiSingoli;
	}
	public function setDentiSingoli ($dentiSingoli) {
		self::$dentiSingoli = $dentiSingoli;
	}


	
	// ----------------------------------------------------------------------------
	// Getters --------------------------------------------------------------------

	public function getAzioneDentiSingoli() {
		return self::$azioneDentiSingoli;
	}
	public function getConfermaTip() {
		return self::$confermaTip;
	}
	public function getTitoloPagina() {
		return self::$titoloPagina;
	}
	public function getMessaggio() {
		return self::$messaggio;
	}
	public function getIdPaziente() {
		return self::$idPaziente;
	}
	public function getIdListino() {
		return self::$idListino;
	}
	public function getIdVisita() {
		return self::$idVisita;
	}
	public function getVisita() {
		return self::$visita;
	}
	public function getEsitoControlliLogici() {
		return self::$esitoControlliLogici;
	}
	public function getRiepilogoDentiSingoli() {
		return self::$riepilogoDentiSingoli;
	}
	public function getDentiSingoli() {
		return self::$dentiSingoli;
	}


	// template ------------------------------------------------

	public function inizializzaPagina() {
	
		$this->setRiepilogoDentiSingoli("");
	
	
	
	}

	public function controlliLogici() {
		
		require_once 'database.class.php';
		require_once 'utility.class.php';

		$esito = TRUE;
		
		// Template --------------------------------------------------------------

		$visita = $this->getVisita();

		$utility = new utility();
		$db = new database();

		//-------------------------------------------------------------

		$replace = array('%idlistino%' => $this->getIdListino());
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryVociListinoPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
		
		while ($row = pg_fetch_row($result)) {			
			$map .= "'" . $row[0] .  "' => '" . $row[0] . "',";
		}

		$vociValide = array($map);

		// controllo esistenza delle voci immesse in pagina
		// alla prima voce non esistente termina il controllo con un errore

		for ($i = 0; $i < sizeof($this->getDentiSingoli()); $i++) {
		
			if ($dentiSingoli[$i][1] != "") {
			
				if (!array_key_exists($dentiSingoli[$i][1], $vociValide)) {
					$esito = FALSE;
					break;
				}			
			}
		}		
		return $esito;
	}
	
	public function displayPagina() {

		require_once 'database.class.php';
		require_once 'utility.class.php';
		
		// Template --------------------------------------------------------------

		$visita = $this->getVisita();

		$utility = new utility();
		$array = $utility->getConfig();

		$form = self::$root . $array['template'] . self::$pagina;

		$db = new database();

		//-------------------------------------------------------------

		$replace = array('%idlistino%' => $this->getIdListino());
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryVociListinoPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
		
		while ($row = pg_fetch_row($result)) {			
			$vociListino .= '"' . $row[0] . '",';
		}

		$replace = array(
			'%titoloPagina%' => $this->getTitoloPagina(),
			'%azioneDentiSingoli%' => $this->getAzioneDentiSingoli(),
			'%confermaTip%' => $this->getConfermaTip(),
			'%vociListino%' => $vociListino,
			'%riepilogoDentiSingoli%' => $this->getRiepilogoDentiSingoli()
		);

		$utility = new utility();

		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);		
	}	
}	

?>
