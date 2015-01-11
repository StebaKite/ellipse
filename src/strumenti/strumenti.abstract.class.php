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
	
	public static $queryConfigurazioni = "/strumenti/ricercaConfigurazioni.sql";
	public static $queryRegoleConfigurazioni = "/strumenti/ricercaRegoleConfigurazioni.sql";
	public static $queryAggiornaStatoConfigurazione = "/strumenti/aggiornaConfigurazione.sql";
	
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

		$mess = $this->getMessaggi();
		
		array_push($mess, "Carico il file ..." . "<br>");
		$file = self::$root . $row['filepath'];
		
		if (file_exists($file)) {
			$temp = file($file);
		}
		else {
			array_push($mess, "Attenzione! Il file " . $file . " non esiste, salto questa importazione e proseguo" . "<br>");
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
}

?>