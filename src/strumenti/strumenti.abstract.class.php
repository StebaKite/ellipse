<?php

abstract class strumentiAbstract {

	public static $root;
	public static $testata;
	public static $piede;
	public static $messaggioInfo;
	public static $messaggioErrore;
	public static $azione;
	public static $testoAzione;
	public static $titoloPagina;
	public static $importaTemplate;
	
	
	function __construct() {

		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/strumenti:" . self::$root . "/ellipse/src/utility";
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
	public function setTitoloPagina($titoloPagina) {
		self::$titoloPagina = $titoloPagina;
	}
	public function setImportaTemplate($importaTemplate) {
		self::$importaTemplate = $importaTemplate;
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
	public function getImportaTemplate() {
		return self::$importaTemplate;
	}
	
	// Start e Go funzione ----------------------------------------------------------------

	public function start() { }
		
	public function go() { }

	public function controlliLogici() { }
	
	public function displayPagina() { }
	
	
}
?>