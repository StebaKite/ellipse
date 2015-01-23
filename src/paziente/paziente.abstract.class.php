<?php

abstract class pazienteAbstract {

	public static $root;
	public static $testata;
	public static $piede;
	public static $messaggioInfo;
	public static $messaggioErrore;
	public static $azione;
	public static $testoAzione;

	public static $queryAggiornaPaziente = "/paziente/aggiornaPaziente.sql";
	
	function __construct() {
		
		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/paziente:" . self::$root . "/ellipse/src/impostazioni:" . self::$root . "/ellipse/src/utility";  
		set_include_path($pathToInclude);		
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

	// Start e Go funzione ----------------------------------------------------------------

	public function start() { }
			
	public function go() { }
	
	public function aggiornaPaziente($db, $idPaziente) {
		
		$utility = new utility();
		$array = $utility->getConfig();
			
		$replace = array(
			'%idpaziente%' => $idPaziente
		);
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryAggiornaPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);

		return $result;	
	}	
}

?>
