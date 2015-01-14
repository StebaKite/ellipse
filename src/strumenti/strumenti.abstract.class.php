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
	public static $messaggi;

	public static $stato;
	public static $statoDisable;
	public static $statoDaeseguire;
	public static $statoEseguito;

	public static $progressivo;
	public static $progressivoTip;
	public static $progressivoStyle;
	public static $progressivoDisable;

	public static $classe;
	public static $classeTip;
	public static $classeStyle;
	public static $classeDisable;

	public static $filepath;
	public static $filepathTip;
	public static $filepathStyle;
	public static $filepathDisable;
	
	public static $idguida;
	
	public static $queryConfigurazioni = "/strumenti/ricercaConfigurazioni.sql";
	public static $queryRegoleConfigurazioni = "/strumenti/ricercaRegoleConfigurazioni.sql";
	public static $queryAggiornaStatoConfigurazione = "/strumenti/aggiornaConfigurazione.sql";

	public static $queryCreaConfigurazione = "/strumenti/creaConfigurazione.sql";
	public static $queryModificaConfigurazione	= "/strumenti/modificaConfigurazione.sql";
	public static $queryCancellaConfigurazione = "/strumenti/cancellaConfigurazione.sql";
	
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
	public function setMessaggi($messaggi) {
		self::$messaggi = $messaggi;
	}
	
	public function setStato($stato) {
		self::$stato = $stato;
	}
	public function setStatoDisable($statoDisable) {
		self::$statoDisable = $statoDisable;
	}
	public function setStatoDaeseguire($statoDaeseguire) {
		self::$statoDaeseguire = $statoDaeseguire;
	}
	public function setStatoEseguito($statoEseguito) {
		self::$statoEseguito = $statoEseguito;
	}

	public function setProgressivo($progressivo) {
		self::$progressivo = $progressivo;
	}
	public function setProgressivoTip($progressivoTip) {
		self::$progressivoTip = $progressivoTip;
	}
	public function setProgressivoStyle($progressivoStyle) {
		self::$progressivoStyle = $progressivoStyle;
	}
	public function setProgressivoDisable($progressivoDisable) {
		self::$progressivoDisable = $progressivoDisable;
	}

	public function setClasse($classe) {
		self::$classe = $classe;
	}
	public function setClasseTip($classeTip) {
		self::$classeTip = $classeTip;
	}
	public function setClasseStyle($classeStyle) {
		self::$classeStyle = $classeStyle;
	}
	public function setClasseDisable($classeDisable) {
		self::$classeDisable = $classeDisable;
	}

	public function setFilepath($filepath) {
		self::$filepath = $filepath;
	}
	public function setFilepathTip($filepathTip) {
		self::$filepathTip = $filepathTip;
	}
	public function setFilepathStyle($filepathStyle) {
		self::$filepathStyle = $filepathStyle;
	}
	public function setFilepathDisable($filepathDisable) {
		self::$filepathDisable = $filepathDisable;
	}

	public function setIdguida($idguida) {
		self::$idguida = $idguida;
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
	public function getMessaggi() {
		return self::$messaggi;
	}
	
	public function getStato() {
		return self::$stato;
	}
	public function getStatoDisable() {
		return self::$statoDisable;
	}
	public function getStatoDaeseguire() {
		return self::$statoDaeseguire;
	}
	public function getStatoEseguito() {
		return self::$statoEseguito;
	}

	public function getProgressivo() {
		return self::$progressivo;
	}
	public function getProgressivoTip() {
		return self::$progressivoTip;
	}
	public function getProgressivoStyle() {
		return self::$progressivoStyle;
	}
	public function getProgressivoDisable() {
		return self::$progressivoDisable;
	}

	public function getClasse() {
		return self::$classe;
	}
	public function getClasseTip() {
		return self::$classeTip;
	}
	public function getClasseStyle() {
		return self::$classeStyle;
	}
	public function getClasseDisable() {
		return self::$classeDisable;
	}

	public function getFilepath() {
		return self::$filepath;
	}
	public function getFilepathTip() {
		return self::$filepathTip;
	}
	public function getFilepathStyle() {
		return self::$filepathStyle;
	}
	public function getFilepathDisable() {
		return self::$filepathDisable;
	}

	public function getIdguida() {
		return self::$idguida;
	}
	
	// Start e Go funzione ----------------------------------------------------------------

	public function start() { }
		
	public function go() { }

	public function controlliLogici() { }
	
	public function displayPagina() { }
	

	public function caricaRegoleMapping($db, $utility, $row) {

		$mess = $this->getMessaggi();
		
		$array = $utility->getConfig();
		$sqlTemplate = self::$root . $array['query'] . self::$queryRegoleConfigurazioni;
		
		$replace = array('%idguida%' => $row['idguida']);
		
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);		
		$rows = pg_fetch_all($result);
		
		array_push($mess, "Carico le regole di mapping ..." . "<br>");
		
		foreach($rows as $regola) {
			array_push($mess, implode(" , ", $regola) . "<br>");
		}

		$this->setMessaggi($mess);
		return $rows;		
	}
	
	public function caricaFileDati($row) {

		$temp = "";
		$mess = $this->getMessaggi();
		
		array_push($mess, "Carico il file ..." . "<br>");
		$file = self::$root . $row['filepath'];

		if (file_exists($file)) {
			$temp = file($file);
		}
		else {
			array_push($mess, "Attenzione! Il file " . $file . " non esiste, salto all'importazione successiva..." . "<br>");
		}

		$this->setMessaggi($mess);
		return $temp;
	}
	
	
	public function inserisciDati($db, $utility, $row, $insertTemplate, $temp, $rows) {
		
		/*
		 * Inserimento dati semplice senza prelievo di chiavi esterne
		 */

		$mess = $this->getMessaggi();
		
		$db->beginTransaction();
		
		array_push($mess, "Carico i dati nella tabella '" . $row['classe'] . "' ...<br>");
		
		for($i = 0; $i < count($temp); $i++) {
		
			$result = $this->componiInserimento($db, $utility, $insertTemplate, $temp[$i], $rows);
			if (!$result) break;
		}
		
		if ($i >= count($temp)) {
			if ($this->aggiornaStatoConfigurazione($db, $utility, $row['idguida'])) {				
				$db->commitTransaction();
				array_push($mess, "ok, caricate " . $i . " righe ...<br>");				
			}
		}
		else {
			$db->rollbackTransaction();
			array_push($mess, "Errore SQL riscontrato durante l'INSERT dei dati, salto il caricamento e proseguo <br>");
		}
		$this->setMessaggi($mess);
	}
	
	public function componiInserimento($db, $utility, $insertTemplate, $record, $rows) {

		$array = $utility->getConfig();
		$campiRecord = explode(";",$record);
		$replace = array();
		
		foreach($rows as $regola) {
			$replace['%' . trim($regola['colonna']) . '%'] = str_replace('"', '', $campiRecord[$regola['posizionevalore']]);
		}
		
		$sqlTemplate = self::$root . $array['query'] . $insertTemplate;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		
		return $db->execSql($sql);
	}
	
	public function aggiornaStatoConfigurazione($db, $utility, $idguida) {
		
		$array = $utility->getConfig();
		$sqlTemplate = self::$root . $array['query'] . self::$queryAggiornaStatoConfigurazione;

		$replace = array('%idguida%' => $idguida);
		$sql = $utility->getTemplate($sqlTemplate);
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		
		return $db->execSql($sql);
	}
	
	public function creaConfigurazione($db) {
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$replace = array(
				'%progressivo%' => $this->getProgressivo(),
				'%classe%' => $this->getClasse(),
				'%filepath%' => $this->getFilepath(),
				'%stato%' => $this->getStato()				
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryCreaConfigurazione;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return $result;
	}

	public function modificaConfigurazione($db) {
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$replace = array(
				'%idguida%' => $this->getIdguida(),
				'%progressivo%' => $this->getProgressivo(),
				'%classe%' => $this->getClasse(),
				'%filepath%' => $this->getFilepath(),
				'%stato%' => $this->getStato()
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryModificaConfigurazione;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return $result;
	}

	public function cancellaConfigurazione($db) {
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$replace = array('%idguida%' => $this->getIdguida());
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryCancellaConfigurazione;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return $result;
	}
	
}

?>
