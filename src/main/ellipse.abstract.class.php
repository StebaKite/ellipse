<?php

abstract class ellipseAbstract {

	public static $root;
	public static $testata;
	public static $piede;
	public static $messaggioInfo;
	public static $messaggioErrore;
	public static $azione;
	public static $testoAzione;
	public static $titoloPagina;

	public static $dentiDecidui = array("51","52","53","54","55","61","62","63","64","65","71","72","73","74","75","81","82","83","84","85");	
	
	public static $queryAggiornaPaziente = "/paziente/aggiornaPaziente.sql";
	public static $queryCreaPreventivo = "/preventivo/creaPreventivo.sql";
	public static $queryCreaCartellaClinica = "/cartellaclinica/creaCartellaClinica.sql";
	
	function __construct() {
		self::$root = $_SERVER['DOCUMENT_ROOT'];
	}

	// Setters -----------------------------------------------------------------------------
	
	public function setTestata($testata) {
		self::$testata = $testata;
	}
	public function setPiede($piede) {
		self::$piede = $piede;
	}
	public function setMessaggioInfo($messaggioInfo) {
		self::$messaggioInfo = $messaggioInfo;
	}
	public function setMessaggioErrore($messaggioErrore) {
		self::$messaggioErrore = $messaggioErrore;
	}
	public function setAzione($azione) {
		self::$azione = $azione;
	}
	public function setTestoAzione($testoAzione) {
		self::$testoAzione = $testoAzione;
	}	
	public function setTitoloPagina($titoloPagina) {
		self::$titoloPagina = $titoloPagina;
	}
	public function setSid($sid) {
		self::$sid = $sid;
	}
	
	// Getters -----------------------------------------------------------------------------

	public function getTestata() {
		return self::$testata;
	}
	public function getPiede() {
		return self::$piede;
	}
	public function getMessaggioInfo() {
		return self::$messaggioInfo;
	}
	public function getMessaggioErrore() {
		return self::$messaggioErrore;
	}
	public function getAzione() {
		return self::$azione;
	}
	public function getTestoAzione() {
		return self::$testoAzione;
	}
	public function getTitoloPagina() {
		return self::$titoloPagina;
	}
	public function getSid() {
		return self::$sid;
	}
	
	// Start e Go funzione ----------------------------------------------------------------

	public function start() { }
			
	public function go() { }
	
	public function aggiornaPaziente($db, $idPaziente, $root) {
		
		$utility = new utility();
		$array = $utility->getConfig();
			
		$replace = array(
			'%idpaziente%' => $idPaziente
		);
		
		$sqlTemplate = $root . $array['query'] . self::$queryAggiornaPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);

		return $result;	
	}	

	/**
	 *
	 * @param unknown $db
	 * @return il result ottenuto dalla creazione del preventivo
	 */
	public function creaPreventivo($db, $root) {
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$replace = array('%idpaziente%' => $_SESSION['idPaziente']);
	
		$sqlTemplate = $root . $array['query'] . self::$queryCreaPreventivo;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return $result;
	}

	/**
	 * 
	 * @param unknown $db
	 * @param unknown $idPreventivo
	 * @param unknown $idPaziente
	 * @return unknown
	 */
	public function creaCartellaClinica($db, $idPreventivo, $idPaziente, $root) {
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$replace = array(
				'%idpaziente%' => $idPaziente,
				'%idpreventivo%' => $idPreventivo				
		);
	
		$sqlTemplate = $root . $array['query'] . self::$queryCreaCartellaClinica;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return $result;
	}

	/**
	 * 
	 * @param unknown $data
	 * @param unknown $carattereSeparatore
	 * @param unknown $gioniDaSommare
	 * @return unknown una data in formatto d-m-Y aumentata di N giorni
	 */
	public function sommaGiorniData($data, $carattereSeparatore, $giorniDaSommare) {
		
		list($giorno, $mese, $anno) = explode($carattereSeparatore, $data);		
		return date("d/m/Y",mktime(0,0,0, $mese, $giorno + $giorniDaSommare, $anno));
	}
}

?>
