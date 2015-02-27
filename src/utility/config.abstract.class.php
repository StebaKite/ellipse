<?php

require_once 'ellipse.abstract.class.php';

abstract class configAbstract extends ellipseAbstract {

	public static $root;
	public static $messaggio;
	public static $titoloPagina;
	public static $azione;
	public static $validitaGiorniPreventivo;
	public static $validitaGiorniPreventivoTip;
	public static $preventivoRiassuntivoSi;
	public static $preventivoRiassuntivoNo;
	public static $sezioneIntestazioneSi;
	public static $sezioneIntestazioneNo;
	public static $sezioneDatiAnagraficiPazienteSi;
	public static $sezioneDatiAnagraficiPazienteNo;	
	public static $sezioneNotaValiditaSi;
	public static $sezioneNotaValiditaNo;
	public static $sezioneFirmaAccettazioneSi;
	public static $sezioneFirmaAccettazioneNo;
	public static $sezionePianoPagamentoSi;
	public static $sezionePianoPagamentoNo;
	public static $sezioneAnnotazioniSi;	
	public static $sezioneAnnotazioniNo;
	public static $sezioneAnnotazioniVociSi;
	public static $sezioneAnnotazioniVociNo;
	public static $nota1Validita;	
	public static $nota2Validita;
	
	

	// Costruttore -----------------------------------------------------------------------------
	
	function __construct() {
		self::$root = $_SERVER['DOCUMENT_ROOT'];
	}
	
	// Setters ---------------------------------------------------------------------------------
	
	public function setRoot($root) {
		self::$root = $root;
	}
	public function setTitoloPagina($titoloPagina) {
		self::$titoloPagina = $titoloPagina;
	}	
	public function setMessaggio($messaggio) {
		self::$messaggio = $messaggio;
	}
	public function setAzione($azione) {
		self::$azione = $azione;
	}
	public function setNota1Validita($value) {
		self::$nota1Validita = $value;
	}
	public function setNota2Validita($value) {
		self::$nota2Validita = $value;
	}
	public function setValiditaGiorniPreventivo($validitaGiorniPreventivo) {
		self::$validitaGiorniPreventivo = $validitaGiorniPreventivo;
	}
	public function setTipValiditaGiorniPreventivo($tip) {
		self::$validitaGiorniPreventivoTip = $tip;
	}
	public function setPreventivoRiassuntivoSi($value) {
		self::$preventivoRiassuntivoSi = $value;
	}
	public function setPreventivoRiassuntivoNo($value) {
		self::$preventivoRiassuntivoNo = $value;
	}
	public function setSezioneIntestazioneSi($value) {
		self::$sezioneIntestazioneSi = $value;
	}
	public function setSezioneIntestazioneNo($value) {
		self::$sezioneIntestazioneNo = $value;
	}
	public function setSezioneDatiAnagraficiPazienteSi($value) {
		self::$sezioneDatiAnagraficiPazienteSi = $value;
	}
	public function setSezioneDatiAnagraficiPazienteNo($value) {
		self::$sezioneDatiAnagraficiPazienteNo = $value;
	}
	public function setSezioneNotaValiditaSi($value) {
		self::$sezioneNotaValiditaSi = $value;
	}
	public function setSezioneNotaValiditaNo($value) {
		self::$sezioneNotaValiditaNo = $value;
	}
	public function setSezioneFirmaAccettazioneSi($value) {
		self::$sezioneFirmaAccettazioneSi = $value;
	}
	public function setSezioneFirmaAccettazioneNo($value) {
		self::$sezioneFirmaAccettazioneNo = $value;
	}
	public function setSezionePianoPagamentoSi($value) {
		self::$sezionePianoPagamentoSi = $value;
	}
	public function setSezionePianoPagamentoNo($value) {
		self::$sezionePianoPagamentoNo = $value;
	}
	public function setSezioneAnnotazioniSi($value) {
		self::$sezioneAnnotazioniSi = $value;
	}
	public function setSezioneAnnotazioniNo($value) {
		self::$sezioneAnnotazioniNo = $value;
	}
	public function setSezioneAnnotazioniVociSi($value) {
		self::$sezioneAnnotazioniVociSi = $value;
	}
	public function setSezioneAnnotazioniVociNo($value) {
		self::$sezioneAnnotazioniVociNo = $value;
	}
	
	// Getters ---------------------------------------------------------------------------------
	
	public function getRoot() {
		return self::$root;
	}
	public function getTitoloPagina() {
		return self::$titoloPagina;
	}
	public function getMessaggio() {
		return self::$messaggio;
	}
	public function getAzione() {
		return self::$azione;
	}
	public function getValiditaGiorniPreventivo() {
		return self::$validitaGiorniPreventivo;
	}
	public function getNota1Validita() {
		return self::$nota1Validita;
	}
	public function getNota2Validita() {
		return self::$nota2Validita;
	}
	public function getTipValiditaGiorniPreventivo() {
		return self::$validitaGiorniPreventivoTip;
	}
	public function getPreventivoRiassuntivoSi() {
		return self::$preventivoRiassuntivoSi;
	}
	public function getPreventivoRiassuntivoNo() {
		return self::$preventivoRiassuntivoNo;
	}
	public function getSezioneIntestazioneSi() {
		return self::$sezioneIntestazioneSi;
	}
	public function getSezioneIntestazioneNo() {
		return self::$sezioneIntestazioneNo;
	}
	public function getSezioneDatiAnagraficiPazienteSi() {
		return self::$sezioneDatiAnagraficiPazienteSi;
	}
	public function getSezioneDatiAnagraficiPazienteNo() {
		return self::$sezioneDatiAnagraficiPazienteNo;
	}
	public function getSezioneNotaValiditaSi() {
		return self::$sezioneNotaValiditaSi;
	}
	public function getSezioneNotaValiditaNo() {
		return self::$sezioneNotaValiditaNo;
	}
	public function getSezioneFirmaAccettazioneSi() {
		return self::$sezioneFirmaAccettazioneSi;
	}
	public function getSezioneFirmaAccettazioneNo() {
		return self::$sezioneFirmaAccettazioneNo;
	}
	public function getSezionePianoPagamentoSi() {
		return self::$sezionePianoPagamentoSi;
	}
	public function getSezionePianoPagamentoNo() {
		return self::$sezionePianoPagamentoNo;
	}
	public function getSezioneAnnotazioniSi() {
		return self::$sezioneAnnotazioniSi;
	}
	public function getSezioneAnnotazioniNo() {
		return self::$sezioneAnnotazioniNo;
	}
	public function getSezioneAnnotazioniVociSi() {
		return self::$sezioneAnnotazioniVociSi;
	}
	public function getSezioneAnnotazioniVociNo() {
		return self::$sezioneAnnotazioniVociNo;
	}
	
	
	
	
	
	
	
}

?>