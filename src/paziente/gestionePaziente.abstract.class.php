<?php

require_once 'paziente.abstract.class.php';

abstract class gestionePazienteAbstract extends pazienteAbstract {

	public static $cognomeRicerca;
	public static $idPaziente;
	public static $confermaTip;
	public static $titoloPagina;

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
	public function setTitoloPagina($titoloPagina) {
		self::$titoloPagina = $titoloPagina;
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
	public function getTitoloPagina() {
		return self::$titoloPagina;
	}
}

?>
