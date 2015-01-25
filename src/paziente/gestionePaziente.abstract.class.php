<?php

require_once 'ellipse.abstract.class.php';

abstract class gestionePazienteAbstract extends ellipseAbstract {

	public static $messaggio;
	public static $cognomeRicerca;
	public static $idPaziente;
	public static $confermaTip;

	public static $paziente;
	public static $esitoControlliLogici;
	
	public static $queryRicercaIdPaziente = "/paziente/ricercaIdPaziente.sql";	
	
	// ------------------------------------------------

	public function setIdPaziente($idPaziente) {
		self::$idPaziente = $idPaziente;
	}
	public function setCognomeRicerca($cognomeRicerca) {
		self::$cognomeRicerca = $cognomeRicerca;
	}
	public function setPaziente($paziente) {
		self::$paziente = $paziente;
	}
	public function setEsitoControlloLogici($esito) {
		self::$esitoControlliLogici = $esito;
	}
	public function setConfermaTip($tip) {
		self::$confermaTip = $tip;
	}
	public function setMessaggio($messaggio) {
		self::$messaggio = $messaggio;
	}
	
	// ------------------------------------------------
	
	public function getIdPaziente() {
		return self::$idPaziente;
	}
	public function getCognomeRicerca() {
		return self::$cognomeRicerca;
	}
	public function getPaziente() {
		return self::$paziente;
	}
	public function getEsitoControlliLogici() {
		return self::$esitoControlliLogici;
	}
	public function getConfermaTip() {
		return self::$confermaTip;
	}
	public function getMessaggio() {
		return self::$messaggio;
	}	
}

?>
