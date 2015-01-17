<?php

abstract class impostazioniAbstract {

	public static $root;
	public static $testata;
	public static $piede;
	public static $messaggioInfo;
	public static $messaggioErrore;
	public static $azione;
	public static $testoAzione;
	public static $titoloPagina;

	public static $codiceCategoria;
	public static $codiceCategoriaTip;
	public static $codiceCategoriaStyle;
	public static $codiceCategoriaDisable;
	
	public static $descrizioneCategoria;
	public static $descrizioneCategoriaTip;
	public static $descrizioneCategoriaStyle;
	public static $descrizioneCategoriaDisable;
	
	public static $idcategoria;
	
	public static $queryCreaCategoria = "/impostazioni/creaCategoria.sql";
	public static $queryModificaCategoria	= "/impostazioni/modificaCategoria.sql";
	public static $queryCancellaCategoria = "/impostazioni/cancellaCategoria.sql";
	
	function __construct() {
	
		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/impostazioni:" . self::$root . "/ellipse/src/utility";
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


	public function setCodiceCategoria($codiceCategoria) {
		self::$codiceCategoria = $codiceCategoria;
	}
	public function setCodiceCategoriaTip($codiceCategoriaTip) {
		self::$codiceCategoriaTip = $codiceCategoriaTip;
	}
	public function setCodiceCategoriaStyle($codiceCategoriaStyle) {
		self::$codiceCategoriaStyle = $codiceCategoriaStyle;
	}
	public function setCodiceCategoriaDisable($codiceCategoriaDisable) {
		self::$codiceCategoriaDisable = $codiceCategoriaDisable;
	}

	public function setDescrizioneCategoria($descrizioneCategoria) {
		self::$descrizioneCategoria = $descrizioneCategoria;
	}
	public function setDescrizioneCategoriaTip($descrizioneCategoriaTip) {
		self::$descrizioneCategoriaTip = $descrizioneCategoriaTip;
	}
	public function setDescrizioneCategoriaStyle($descrizioneCategoriaStyle) {
		self::$descrizioneCategoriaStyle = $descrizioneCategoriaStyle;
	}
	public function setDescrizioneCategoriaDisable($descrizioneCategoriaDisable) {
		self::$descrizioneCategoriaDisable = $descrizioneCategoriaDisable;
	}
	

	public function setIdcategoria($idcategoria) {
		self::$idcategoria = $idcategoria;
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


	public function getCodiceCategoria() {
		return self::$codiceCategoria;
	}
	public function getCodiceCategoriaTip() {
		return self::$codiceCategoriaTip;
	}
	public function getCodiceCategoriaStyle() {
		return self::$codiceCategoriaStyle;
	}
	public function getCodiceCategoriaDisable() {
		return self::$codiceCategoriaDisable;
	}

	public function getDescrizioneCategoria() {
		return self::$descrizioneCategoria;
	}
	public function getDescrizioneCategoriaTip() {
		return self::$descrizioneCategoriaTip;
	}
	public function getDescrizioneCategoriaStyle() {
		return self::$descrizioneCategoriaStyle;
	}
	public function getDescrizioneCategoriaDisable() {
		return self::$descrizioneCategoriaDisable;
	}
	

	public function getIdcategoria() {
		return self::$idcategoria;
	}
	
	// Start e Go funzione ----------------------------------------------------------------
	
	public function start() { }
	
	public function go() { }
	
	public function controlliLogici() { }
	
	public function displayPagina() { }
	
	// Metodi comuni ----------------------------------------------------------------------

	public function creaCategoria($db) {
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$replace = array(
				'%codicecategoria%' => $this->getCodiceCategoria(),
				'%descrizionecategoria%' => $this->getDescrizioneCategoria()
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryCreaCategoria;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return $result;
	}
	
	
	
	
	
	
	
	
	
	
}	
	
?>