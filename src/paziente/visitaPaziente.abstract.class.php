<?php

require_once 'paziente.abstract.class.php';

abstract class visitaPazienteAbstract extends pazienteAbstract {

	public static $cognomeRicerca;
	public static $idPaziente;
	public static $idListino;
	public static $idVisita;
	public static $confermaTip;
	public static $titoloPagina;

	public static $visita;
	public static $visitaCure;
	public static $esitoControlliLogici;
	public static $cureGeneriche;

	public static $queryCreaVisita = "/paziente/creaVisita.sql";
	public static $queryCreaVoceVisita = "/paziente/creaVoceVisita.sql";
	public static $queryVociListinoPaziente = "/paziente/ricercaVociListinoPaziente.sql";
	public static $queryVociGenericheListinoPaziente = "/paziente/ricercaVociGenericheListinoPaziente.sql";
	
	// ------------------------------------------------

	public function setIdPaziente($idPaziente) {
		self::$idPaziente = $idPaziente;
	}
	public function setIdListino($idListino) {
		self::$idListino = $idListino;
	}
	public function setIdVisita($idVisita) {
		self::$idVisita = $idVisita;
	}
	public function setCognomeRicerca($cognomeRicerca) {
		self::$cognomeRicerca = $cognomeRicerca;
	}
	public function setVisita($visita) {
		self::$visita = $visita;
	}
	public function setVisitaCure($visitaCure) {
		self::$visitaCure = $visitaCure;
	}
	public function setEsitoControlloLogici($esito) {
		self::$esitoControlliLogici = $esito;
	}
	public function setConfermaTip($tip) {
		self::$confermaTip = $tip;
	}
	public function setTitoloPagina($titoloPagina) {
		self::$titoloPagina = $titoloPagina;
	}
	public function setCureGeneriche($cureGeneriche) {
		self::$cureGeneriche = $cureGeneriche;
	}
	
	// ------------------------------------------------
	
	public function getIdPaziente() {
		return self::$idPaziente;
	}
	public function getIdListino() {
		return self::$idListino;
	}
	public function getIdVisita() {
		return self::$idVisita;
	}
	public function getCognomeRicerca() {
		return self::$cognomeRicerca;
	}
	public function getVisita() {
		return self::$visita;
	}
	public function getVisitaCure() {
		return self::$visitaCure;
	}
	public function getEsitoControlliLogici() {
		return self::$esitoControlliLogici;
	}
	public function getConfermaTip() {
		return self::$confermaTip;
	}
	public function getTitoloPagina() {
		return self::$titoloPagina;
	}
	public function getCureGeneriche() {
		return self::$cureGeneriche;
	}

	// ------------------------------------------------

	public function controlliLogici() { }
	
	
	
	public function creaVisita($db) {
		
		$utility = new utility();
		$array = $utility->getConfig();

		$replace = array('%idpaziente%' => $this->getIdPaziente());
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryCreaVisita;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);

		return $result;
	}
	
	public function creaVoceVisita($db, $idVisitaUsato, $nomeForm, $nomeCampoForm, $codiceVoceListino) {
		
		$utility = new utility();
		$array = $utility->getConfig();
			
		$replace = array(
			'%nomeForm%' => trim($nomeForm), 
			'%nomecampoform%' => trim($nomeCampoForm),
			'%codicevocelistino%' => trim($codiceVoceListino),
			'%idvisita%' => $idVisitaUsato
		);
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryCreaVoceVisita;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);

		return $result;	
	} 	
}

?>

