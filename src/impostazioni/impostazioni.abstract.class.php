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

	public static $codiceVoce;
	public static $codiceVoceTip;
	public static $codiceVoceStyle;
	public static $codiceVoceDisable;

	public static $descrizioneVoce;
	public static $descrizioneVoceTip;
	public static $descrizioneVoceStyle;
	public static $descrizioneVoceDisable;

	public static $prezzo;
	public static $prezzoTip;
	public static $prezzoStyle;
	public static $prezzoDisable;

	public static $tipovoce;
	public static $tipovoceDisable;
	public static $tipovoceStandard;
	public static $tipovoceGenerica;
	
	public static $idvoce;
	public static $idcategoria;
	
	public static $queryCreaCategoria = "/impostazioni/creaCategoria.sql";
	public static $queryModificaCategoria	= "/impostazioni/modificaCategoria.sql";
	public static $queryCancellaCategoria = "/impostazioni/cancellaCategoria.sql";

	public static $queryCreaVoce = "/impostazioni/creaVoce.sql";
	
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


	public function setCodiceVoce($codiceVoce) {
		self::$codiceVoce = $codiceVoce;
	}
	public function setCodiceVoceTip($codiceVoceTip) {
		self::$codiceVoceTip = $codiceVoceTip;
	}
	public function setCodiceVoceStyle($codiceVoceStyle) {
		self::$codiceVoceStyle = $codiceVoceStyle;
	}
	public function setCodiceVoceDisable($codiceVoceDisable) {
		self::$codiceVoceDisable = $codiceVoceDisable;
	}

	public function setDescrizioneVoce($descrizioneVoce) {
		self::$descrizioneVoce = $descrizioneVoce;
	}
	public function setDescrizioneVoceTip($descrizioneVoceTip) {
		self::$descrizioneVoceTip = $descrizioneVoceTip;
	}
	public function setDescrizioneVoceStyle($descrizioneVoceStyle) {
		self::$descrizioneVoceStyle = $descrizioneVoceStyle;
	}
	public function setDescrizioneVoceDisable($descrizioneVoceDisable) {
		self::$descrizioneVoceDisable = $descrizioneVoceDisable;
	}

	public function setPrezzo($prezzo) {
		self::$prezzo = $prezzo;
	}
	public function setPrezzoTip($prezzoTip) {
		self::$prezzoTip = $prezzoTip;
	}
	public function setPrezzoStyle($prezzoStyle) {
		self::$prezzoStyle = $prezzoStyle;
	}
	public function setPrezzoDisable($prezzoDisable) {
		self::$prezzoDisable = $prezzoDisable;
	}

	public function setTipoVoce($tipoVoce) {
		self::$tipovoce = $tipoVoce;
	}
	public function setTipoVoceDisable($tipoVoceDisable) {
		self::$tipovoceDisable = $tipoVoceDisable;
	}
	public function setTipoVoceStandard($tipoVoceStandard) {
		self::$tipovoceStandard = $tipoVoceStandard;
	}
	public function setTipoVoceGenerica($tipoVoceGenerica) {
		self::$tipovoceGenerica = $tipoVoceGenerica;
	}
	

	public function setIdcategoria($idcategoria) {
		self::$idcategoria = $idcategoria;
	}
	public function setIdvoce($idvoce) {
		self::$idvoce = $idvoce;
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

	
	public function getCodiceVoce() {
		return self::$codiceVoce;
	}
	public function getCodiceVoceTip() {
		return self::$codiceVoceTip;
	}
	public function getCodiceVoceStyle() {
		return self::$codiceVoceStyle;
	}
	public function getCodiceVoceDisable() {
		return self::$codiceVoceDisable;
	}

	public function getDescrizioneVoce() {
		return self::$descrizioneVoce;
	}
	public function getDescrizioneVoceTip() {
		return self::$descrizioneVoceTip;
	}
	public function getDescrizioneVoceStyle() {
		return self::$descrizioneVoceStyle;
	}
	public function getDescrizioneVoceDisable() {
		return self::$descrizioneVoceDisable;
	}

	public function getPrezzo() {
		return self::$prezzo;
	}
	public function getPrezzoTip() {
		return self::$prezzoTip;
	}
	public function getPrezzoStyle() {
		return self::$prezzoStyle;
	}
	public function getPrezzoDisable() {
		return self::$prezzoDisable;
	}

	public function getTipoVoce() {
		return self::$tipovoce;
	}
	public function getTipoVoceDisable() {
		return self::$tipovoceDisable;
	}
	public function getTipoVoceStandard() {
		return self::$tipovoceStandard;
	}
	public function getTipoVoceGenerica() {
		return self::$tipovoceGenerica;
	}
	

	public function getIdcategoria() {
		return self::$idcategoria;
	}
	public function getIdvoce() {
		return self::$idvoce;
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
	
	public function modificaCategoria($db) {
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$replace = array(
				'%idcategoria%' => $this->getIdcategoria(),
				'%codicecategoria%' => $this->getCodiceCategoria(),
				'%descrizionecategoria%' => $this->getDescrizioneCategoria()
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryModificaCategoria;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return $result;
	}
	
	public function cancellaCategoria($db) {
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$replace = array('%idcategoria%' => $this->getIdcategoria());
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryCancellaCategoria;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return $result;
	}

	public function creaVoce($db) {
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$replace = array(
				'%codice%' => $this->getCodiceVoce(),
				'%descrizione%' => $this->getDescrizioneVoce(),
				'%prezzo%' => $this->getPrezzo(),
				'%tipo%' => $this->getTipoVoce(),
				'%idcategoria%' => $this->getIdcategoria()
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryCreaVoce;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return $result;
	}
	
	
	
}	
	
?>