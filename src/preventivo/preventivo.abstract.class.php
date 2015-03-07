<?php

require_once 'ellipse.abstract.class.php';

abstract class preventivoAbstract extends ellipseAbstract {

	// Campi -----------------------------------------------------------------------------
	
	public static $root;
	public static $messaggio;
 	public static $intestazioneColonnaAzioni;
	
	public static $azioneDentiSingoli;
	public static $azioneGruppi;
	public static $azioneCure;
	public static $azionePagamento;

	public static $azionePreventivoLabelBottone;
	public static $azionePreventivo;
	public static $azionePreventivoTip;
	
	public static $confermaTip;
	public static $singoliTip;
	public static $gruppiTip;
	public static $cureTip;
	public static $azioneTip;
	
	public static $titoloPagina;
	public static $preventivoLabel;
	public static $totalePreventivoLabel;
		
	// Query -----------------------------------------------------------------------------
	
	public static $queryVociListinoPaziente = "/preventivo/ricercaVociListinoPaziente.sql";
	public static $queryRicercaIdPaziente = "/paziente/ricercaIdPaziente.sql";
	
	public static $queryCategorieVociListinoPaziente = "/preventivo/ricercaCategorieVociListinoPaziente.sql";
	public static $queryVociListinoCategoriaPaziente = "/preventivo/ricercaVociListinoCategoriaPaziente.sql";
	public static $queryVociGenericheListinoPaziente = "/preventivo/ricercaVociGenericheListinoPaziente.sql";

	public static $queryAggiornaUsoVoceListino = "/preventivo/aggiornaUsoVoceListino.sql";	
	public static $queryLeggiPrezzoVoceListino = "/preventivo/leggiPrezzoVoceListino.sql";
	public static $queryCreaSottoPreventivo = "/preventivo/creaSottoPreventivo.sql";
	
	public static $queryAggiornaStatoPreventivo = "/preventivo/aggiornaStatoPreventivo.sql";
	public static $queryAggiornaStatoSottoPreventivo = "/preventivo/aggiornaStatoSottoPreventivo.sql";
	public static $queryAggiornaPreventivo = "/preventivo/aggiornaPreventivo.sql";
	public static $queryAggiornaVocePreventivo = "/preventivo/aggiornaVocePreventivo.sql";
	public static $queryAggiornaVocePreventivoPrincipale = "/preventivo/aggiornaVocePreventivoPrincipale.sql";
	public static $queryAggiornaVocePreventivoSecondario = "/preventivo/aggiornaVocePreventivoSecondario.sql";
	
	public static $queryCancellaVocePreventivo = "/preventivo/cancellaVocePreventivo.sql";
	public static $queryVocePreventivoPaziente = "/preventivo/ricercaVocePreventivoPaziente.sql";	
	public static $queryIdVocePreventivoPaziente = "/preventivo/ricercaIdVocePreventivoPaziente.sql";	
	public static $queryVociPreventivoDentiSingoliPaziente = "/preventivo/ricercaVociPreventivoDentiSingoliPaziente.sql";

	public static $queryVociSottoPreventivoGruppiPaziente = "/preventivo/ricercaVociSottoPreventivoGruppiPaziente.sql";
	public static $queryVociPreventivoGruppiPaziente = "/preventivo/ricercaVociPreventivoGruppiPaziente.sql";

	public static $queryComboPreventivoPrincipaleGruppiPaziente = "/preventivo/ricercaComboPreventivoPrincipaleGruppiPaziente.sql";
	public static $queryComboPreventivoSecondarioGruppiPaziente = "/preventivo/ricercaComboPreventivoSecondarioGruppiPaziente.sql";

	public static $queryLeggiVociPreventivoPrincipale = "/preventivo/leggiVociPreventivoPrincipale.sql";
	public static $queryLeggiVociPreventivoSecondario = "/preventivo/leggiVociPreventivoSecondario.sql";
	public static $queryVocePreventivoPrincipalePaziente = "/preventivo/ricercaVocePreventivoPrincipalePaziente.sql";
	public static $queryVocePreventivoSecondarioPaziente = "/preventivo/ricercaVocePreventivoSecondarioPaziente.sql";
	public static $queryCreaVocePreventivo = "/preventivo/creaVocePreventivo.sql";
	
	public static $queryCreaVoceSottoPreventivo = "/preventivo/creaVoceSottoPreventivo.sql";
	public static $queryAggiornaSottoPreventivo = "/preventivo/aggiornaSottoPreventivo.sql";
	public static $queryAggiornaVoceSottoPreventivo = "/preventivo/aggiornaVoceSottoPreventivo.sql";
	public static $queryCancellaVoceSottoPreventivo = "/preventivo/cancellaVoceSottoPreventivo.sql";
	public static $queryVoceSottoPreventivoPaziente = "/preventivo/ricercaVoceSottoPreventivoPaziente.sql";
	public static $queryIdVoceSottoPreventivoPaziente = "/preventivo/ricercaIdVoceSottoPreventivoPaziente.sql";
	public static $queryVociSottoPreventivoDentiSingoliPaziente = "/preventivo/ricercaVociSottoPreventivoDentiSingoliPaziente.sql";

	public static $queryAggiornaStatoVocePreventivoPrincipale = "/preventivo/aggiornaStatoVocePreventivoPrincipale.sql";
	public static $queryAggiornaStatoVocePreventivoSecondario = "/preventivo/aggiornaStatoVocePreventivoSecondario.sql";

	public static $queryRicercaVociPreventivoPrincipale = "/preventivo/ricercaVociPreventivoPrincipale.sql"; 
	public static $queryRicercaVociPreventivoSecondario = "/preventivo/ricercaVociPreventivoSecondario.sql";
	public static $queryAggiornaPagamentoPreventivoPrincipale = "/preventivo/aggiornaPagamentoPreventivoPrincipale.sql";
	public static $queryAggiornaPagamentoPreventivoSecondario = "/preventivo/aggiornaPagamentoPreventivoSecondario.sql";
	
	public static $queryRicercaTipiVociPreventivoPrincipalePaziente = "/preventivo/ricercaTipiVociPreventivoPrincipalePaziente.sql";
	public static $queryRicercaTipiVociPreventivoSecondarioPaziente = "/preventivo/ricercaTipiVociPreventivoSecondarioPaziente.sql";

	public static $queryRiepilogoVociPreventivoPrincipalePaziente = "/preventivo/riepilogoVociPreventivoPrincipalePaziente.sql";
	public static $queryRiepilogoVociPreventivoSecondarioPaziente = "/preventivo/riepilogoVociPreventivoSecondarioPaziente.sql";
	public static $queryRiepilogoVociGruppiPreventivoPrincipalePaziente = "/preventivo/riepilogoVociGruppiPreventivoPrincipalePaziente.sql";
	public static $queryRiepilogoVociGruppiPreventivoSecondarioPaziente = "/preventivo/riepilogoVociGruppiPreventivoSecondarioPaziente.sql";
	
	public static $queryRiassuntoVociStampaPreventivoPrincipale = "/preventivo/riassuntoVociStampaPreventivoPrincipale.sql";
	public static $queryRiassuntoVociStampaPreventivoSecondario = "/preventivo/riassuntoVociStampaPreventivoSecondario.sql";
	
	public static $queryCancellaPreventivoPrincipale = "/preventivo/cancellaPreventivoPrincipale.sql";
	public static $queryCancellaPreventivoSecondario = "/preventivo/cancellaPreventivoSecondario.sql";
	public static $queryRicercaStatoPreventiviSecondari = "/preventivo/ricercaStatoPreventiviSecondari.sql";
	public static $queryLeggiImportoPreventiviPrincipale = "/preventivo/leggiImportoPreventivoPrincipale.sql";
	
	public static $queryCreaVoceCartellaClinica = "/cartellaclinica/creaVoceCartellaClinica.sql";
	public static $queryRicercaStatoCartellaClinica = "/preventivo/ricercaStatoCartellaClinica.sql";
	public static $queryCancellaCartellaClinicaPreventivo = "/preventivo/cancellaCartellaClinicaPreventivo.sql";

	public static $queryLeggiCondizioniPagamentoPreventivoPrincipale = "/preventivo/leggiCondizioniPagamentoPreventivoPrincipale.sql";
	public static $queryLeggiCondizioniPagamentoPreventivoSecondario = "/preventivo/leggiCondizioniPagamentoPreventivoSecondario.sql";

	public static $queryCreaRataPagamentoPreventivoPrincipale = "/preventivo/creaRataPagamentoPreventivoPrincipale.sql";
	public static $queryCreaRataPagamentoPreventivoSecondario = "/preventivo/creaRataPagamentoPreventivoSecondario.sql";
	public static $queryCancellaRatePagamentoPreventivoPrincipale = "/preventivo/cancellaRatePagamentoPreventivoPrincipale.sql";
	public static $queryCancellaRatePagamentoPreventivoSecondario = "/preventivo/cancellaRatePagamentoPreventivoSecondario.sql";
	public static $queryLeggiRatePagamentoPreventivoPrincipale = "/preventivo/leggiRatePagamentoPreventivoPrincipale.sql";
	public static $queryLeggiRatePagamentoPreventivoSecondario = "/preventivo/leggiRatePagamentoPreventivoSecondario.sql";

	public static $queryLeggiAccontiPreventivoPrincipale = "/preventivo/leggiAccontiPreventivoPrincipale.sql"; 
	public static $queryLeggiAccontiPreventivoSecondario = "/preventivo/leggiAccontiPreventivoSecondario.sql";
	public static $queryCreaAccontoPreventivoPrincipale = "/preventivo/creaAccontoPreventivoPrincipale.sql";
	public static $queryCreaAccontoPreventivoSecondario = "/preventivo/creaAccontoPreventivoSecondario.sql";
	public static $queryCancellaAccontoPagamentoPreventivoPrincipale = "/preventivo/cancellaAccontoPagamentoPreventivoPrincipale.sql";
	public static $queryCancellaAccontoPagamentoPreventivoSecondario = "/preventivo/cancellaAccontoPagamentoPreventivoSecondario.sql";

	public static $querySommaImportoVociPreventivoPrincipale = "/preventivo/sommaImportoVociPreventivoPrincipale.sql";
	public static $querySommaImportoVociPreventivoSecondario = "/preventivo/sommaImportoVociPreventivoSecondario.sql";

	public static $queryAnnotazioniPreventivoPrincipale = "/preventivo/leggiAnnotazioniPreventivoPrincipale.sql";
	public static $queryAnnotazioniPreventivoSecondario = "/preventivo/leggiAnnotazioniPreventivoSecondario.sql";
	public static $queryAnnotazioniVociPreventivoPrincipale = "/preventivo/leggiAnnotazioniVociPreventivoPrincipale.sql";
	public static $queryAnnotazioniVociPreventivoSecondario = "/preventivo/leggiAnnotazioniVociPreventivoSecondario.sql";

	public static $queryRicercaNotaPreventivoPrincipale = "/preventivo/ricercaNotaPreventivoPrincipale.sql";
	public static $queryRicercaNotaPreventivoSecondario = "/preventivo/ricercaNotaPreventivoSecondario.sql";	
	public static $queryCreaNotaPreventivoPrincipale = "/preventivo/creaNotaPreventivoPrincipale.sql"; 
	public static $queryCreaNotaPreventivoSecondario = "/preventivo/creaNotaPreventivoSecondario.sql";
	public static $queryLeggiNotaPreventivoPrincipale = "/preventivo/leggiNotaPreventivoPrincipale.sql";
	public static $queryLeggiNotaPreventivoSecondario = "/preventivo/leggiNotaPreventivoSecondario.sql";
	public static $queryAggiornaNotaPreventivoPrincipale = "/preventivo/aggiornaNotaPreventivoPrincipale.sql";
	public static $queryAggiornaNotaPreventivoSecondario = "/preventivo/aggiornaNotaPreventivoSecondario.sql";
	public static $queryCancellaNotaPreventivoPrincipale = "/preventivo/cancellaNotaPreventivoPrincipale.sql";
	public static $queryCancellaNotaPreventivoSecondario = "/preventivo/cancellaNotaPreventivoSecondario.sql";
	
	// Costruttore -----------------------------------------------------------------------------
	
	function __construct() {
		self::$root = $_SERVER['DOCUMENT_ROOT'];
	}

	// Setters ---------------------------------------------------------------------------------

	public function setRoot($root) {
		self::$root = $root;
	}
	
	public function setAzioneDentiSingoli($azioneDentiSingoli) {
		self::$azioneDentiSingoli = $azioneDentiSingoli;
	}
	public function setAzioneGruppi($azioneGruppi) {
		self::$azioneGruppi = $azioneGruppi;
	}
	public function setAzioneCure($azioneCure) {
		self::$azioneCure = $azioneCure;
	}
	public function setAzionePagamento($azionePagamento) {
		self::$azionePagamento = $azionePagamento;
	}
	public function setAzionePreventivo($azionePreventivo) {
		self::$azionePreventivo = $azionePreventivo;
	}
	
	public function setConfermaTip($tip) {
		self::$confermaTip = $tip;
	}
	public function setSingoliTip($tip) {
		self::$singoliTip = $tip;
	}
	public function setGruppiTip($tip) {
		self::$gruppiTip = $tip;
	}
	public function setCureTip($tip) {
		self::$cureTip = $tip;
	}
	public function setAzionePreventivoTip($tip) {
		self::$azionePreventivoTip = $tip;
	}
	public function setAzionePreventivoLabelBottone($label) {
		self::$azionePreventivoLabelBottone = $label;
	}
	
	
	public function setTitoloPagina($titoloPagina) {
		self::$titoloPagina = $titoloPagina;
	}
	public function setPreventivoLabel($preventivoLabel) {
		self::$preventivoLabel = $preventivoLabel;
	}
	public function setTotalePreventivoLabel($totalePreventivoLabel) {
		self::$totalePreventivoLabel = $totalePreventivoLabel;
	}
	
	public function setMessaggio($messaggio) {
		self::$messaggio = $messaggio;
	}
	
	public function setIntestazioneColonnaAzioni($intestazioneColonnaAzioni) {
		self::$intestazioneColonnaAzioni = $intestazioneColonnaAzioni;
	}	
	
	// Getters -----------------------------------------------------------------------------

	public function getAzioneDentiSingoli() {
		return self::$azioneDentiSingoli;
	}
	public function getAzioneGruppi() {
		return self::$azioneGruppi;
	}
	public function getAzioneCure() {
		return self::$azioneCure;
	}
	public function getAzionePagamento() {
		return self::$azionePagamento;
	}
	public function getAzionePreventivo() {
		return self::$azionePreventivo;
	}
	public function getAzionePreventivoTip() {
		return self::$azionePreventivoTip;
	}
	public function getAzionePreventivoLabelBottone() {
		return self::$azionePreventivoLabelBottone;
	}
	
	public function getConfermaTip() {
		return self::$confermaTip;
	}
	public function getGruppiTip() {
		return self::$gruppiTip;
	}
	public function getSingoliTip() {
		return self::$singoliTip;
	}
	public function getCureTip() {
		return self::$cureTip;
	}
	
	public function getTitoloPagina() {
		return self::$titoloPagina;
	}
	public function getPreventivoLabel() {
		return self::$preventivoLabel;
	}
	public function getTotalePreventivoLabel() {
		return self::$totalePreventivoLabel;
	}
	
	public function getMessaggio() {
		return self::$messaggio;
	}
	
	public function getIntestazioneColonnaAzioni() {
		return self::$intestazioneColonnaAzioni;
	}
	
	// Start e Go funzione ----------------------------------------------------------------
	
	public function start() { }
	
	public function go() { }
	
	public function controlliLogici() { }
	
	public function displayPagina() { }
	
	// Metodi comuni ----------------------------------------------------------------------

	public function setPathToInclude() {
		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/paziente:" . self::$root . "/ellipse/src/preventivo:" . self::$root . "/ellipse/src/strumenti:" . self::$root . "/ellipse/src/utility";
		set_include_path($pathToInclude);
	}
	
	public function inizializzaPagina() { }

	public function inizializzaGruppiPagina() {
	
		// primo gruppo --------------------------------------------------------------------------------------------------------------
	
		$dentiGruppo_1 = array();
	
		array_push($dentiGruppo_1, array('SD_18_1', ''), array('SD_17_1', ''), array('SD_16_1', ''));
		array_push($dentiGruppo_1, array('SD_15_1', ''), array('SD_14_1', ''), array('SD_13_1', ''));
		array_push($dentiGruppo_1, array('SD_12_1', ''), array('SD_11_1', ''));
	
		array_push($dentiGruppo_1, array('SS_21_1', ''), array('SS_22_1', ''), array('SS_23_1', ''));
		array_push($dentiGruppo_1, array('SS_24_1', ''), array('SS_25_1', ''), array('SS_26_1', ''));
		array_push($dentiGruppo_1, array('SS_27_1', ''), array('SS_28_1', ''));
	
		array_push($dentiGruppo_1, array('ID_48_1', ''), array('ID_47_1', ''), array('ID_46_1', ''));
		array_push($dentiGruppo_1, array('ID_45_1', ''), array('ID_44_1', ''), array('ID_43_1', ''));
		array_push($dentiGruppo_1, array('ID_42_1', ''), array('ID_41_1', ''));
	
		array_push($dentiGruppo_1, array('IS_31_1', ''), array('IS_32_1', ''), array('IS_33_1', ''));
		array_push($dentiGruppo_1, array('IS_34_1', ''), array('IS_35_1', ''), array('IS_36_1', ''));
		array_push($dentiGruppo_1, array('IS_37_1', ''), array('IS_38_1', ''));
	
		$this->setDentiGruppo_1($dentiGruppo_1);
	
		// secondo gruppo --------------------------------------------------------------------------------------------------------------
	
		$dentiGruppo_2 = array();
	
		array_push($dentiGruppo_2, array('SD_18_2', ''), array('SD_17_2', ''), array('SD_16_2', ''));
		array_push($dentiGruppo_2, array('SD_15_2', ''), array('SD_14_2', ''), array('SD_13_2', ''));
		array_push($dentiGruppo_2, array('SD_12_2', ''), array('SD_11_2', ''));
	
		array_push($dentiGruppo_2, array('SS_21_2', ''), array('SS_22_2', ''), array('SS_23_2', ''));
		array_push($dentiGruppo_2, array('SS_24_2', ''), array('SS_25_2', ''), array('SS_26_2', ''));
		array_push($dentiGruppo_2, array('SS_27_2', ''), array('SS_28_2', ''));
	
		array_push($dentiGruppo_2, array('ID_48_2', ''), array('ID_47_2', ''), array('ID_46_2', ''));
		array_push($dentiGruppo_2, array('ID_45_2', ''), array('ID_44_2', ''), array('ID_43_2', ''));
		array_push($dentiGruppo_2, array('ID_42_2', ''), array('ID_41_2', ''));
	
		array_push($dentiGruppo_2, array('IS_31_2', ''), array('IS_32_2', ''), array('IS_33_2', ''));
		array_push($dentiGruppo_2, array('IS_34_2', ''), array('IS_35_2', ''), array('IS_36_2', ''));
		array_push($dentiGruppo_2, array('IS_37_2', ''), array('IS_38_2', ''));
	
		$this->setDentiGruppo_2($dentiGruppo_2);
	
		// terzo gruppo --------------------------------------------------------------------------------------------------------------
	
		$dentiGruppo_3 = array();
	
		array_push($dentiGruppo_3, array('SD_18_3', ''), array('SD_17_3', ''), array('SD_16_3', ''));
		array_push($dentiGruppo_3, array('SD_15_3', ''), array('SD_14_3', ''), array('SD_13_3', ''));
		array_push($dentiGruppo_3, array('SD_12_3', ''), array('SD_11_3', ''));
	
		array_push($dentiGruppo_3, array('SS_21_3', ''), array('SS_22_3', ''), array('SS_23_3', ''));
		array_push($dentiGruppo_3, array('SS_24_3', ''), array('SS_25_3', ''), array('SS_26_3', ''));
		array_push($dentiGruppo_3, array('SS_27_3', ''), array('SS_28_3', ''));
	
		array_push($dentiGruppo_3, array('ID_48_3', ''), array('ID_47_3', ''), array('ID_46_3', ''));
		array_push($dentiGruppo_3, array('ID_45_3', ''), array('ID_44_3', ''), array('ID_43_3', ''));
		array_push($dentiGruppo_3, array('ID_42_3', ''), array('ID_41_3', ''));
	
		array_push($dentiGruppo_3, array('IS_31_3', ''), array('IS_32_3', ''), array('IS_33_3', ''));
		array_push($dentiGruppo_3, array('IS_34_3', ''), array('IS_35_3', ''), array('IS_36_3', ''));
		array_push($dentiGruppo_3, array('IS_37_3', ''), array('IS_38_3', ''));
	
		$this->setDentiGruppo_3($dentiGruppo_3);
	
		// quarto gruppo --------------------------------------------------------------------------------------------------------------
	
		$dentiGruppo_4 = array();
	
		array_push($dentiGruppo_4, array('SD_18_4', ''), array('SD_17_4', ''), array('SD_16_4', ''));
		array_push($dentiGruppo_4, array('SD_15_4', ''), array('SD_14_4', ''), array('SD_13_4', ''));
		array_push($dentiGruppo_4, array('SD_12_4', ''), array('SD_11_4', ''));
	
		array_push($dentiGruppo_4, array('SS_21_4', ''), array('SS_22_4', ''), array('SS_23_4', ''));
		array_push($dentiGruppo_4, array('SS_24_4', ''), array('SS_25_4', ''), array('SS_26_4', ''));
		array_push($dentiGruppo_4, array('SS_27_4', ''), array('SS_28_4', ''));
	
		array_push($dentiGruppo_4, array('ID_48_4', ''), array('ID_47_4', ''), array('ID_46_4', ''));
		array_push($dentiGruppo_4, array('ID_45_4', ''), array('ID_44_4', ''), array('ID_43_4', ''));
		array_push($dentiGruppo_4, array('ID_42_4', ''), array('ID_41_4', ''));
	
		array_push($dentiGruppo_4, array('IS_31_4', ''), array('IS_32_4', ''), array('IS_33_4', ''));
		array_push($dentiGruppo_4, array('IS_34_4', ''), array('IS_35_4', ''), array('IS_36_4', ''));
		array_push($dentiGruppo_4, array('IS_37_4', ''), array('IS_38_4', ''));
	
		$this->setDentiGruppo_4($dentiGruppo_4);
	}
	
	public function prelevaCampiFormSingoli() {
	
		$dentiSingoli = array();
	
		// Prelevo il campo hidden che contiene tutte le voci applicate ------------------------------------------------------------------------
	
		$campimpostati = $_POST['campiValorizzati'];
		$campi = explode(',',$campimpostati);
	
		for ($i = 0; $i < count($campi); $i++) {
			array_push($dentiSingoli, array(trim($campi[$i]), $_POST[trim($campi[$i])]));
		}
		// restituisce l'array
	
		return $dentiSingoli;
	}

	public function inizializzaCurePagina() {
	
		$vociGeneriche = array();
	
		// primo gruppo --------------------------------------------------------------------------------------------------------------
	
		array_push($vociGeneriche, array('voceGenerica_1', ''));
		array_push($vociGeneriche, array('voceGenerica_2', ''));
		array_push($vociGeneriche, array('voceGenerica_3', ''));
		array_push($vociGeneriche, array('voceGenerica_4', ''));
		array_push($vociGeneriche, array('voceGenerica_5', ''));
		array_push($vociGeneriche, array('voceGenerica_6', ''));
	
		$this->setCureGeneriche($vociGeneriche);
	}
	
	public function prelevaCampiFormCure() {
	
		$vociGeneriche = array();
	
		// primo gruppo --------------------------------------------------------------------------------------------------------------
	
		array_push($vociGeneriche, array('voceGenerica_1', $_POST['voceGenerica_1']));
		array_push($vociGeneriche, array('voceGenerica_2', $_POST['voceGenerica_2']));
		array_push($vociGeneriche, array('voceGenerica_3', $_POST['voceGenerica_3']));
		array_push($vociGeneriche, array('voceGenerica_4', $_POST['voceGenerica_4']));
		array_push($vociGeneriche, array('voceGenerica_5', $_POST['voceGenerica_5']));
		array_push($vociGeneriche, array('voceGenerica_6', $_POST['voceGenerica_6']));
	
		// restituisce l'array
	
		return $vociGeneriche;
	}
	
	public function prelevaCampiFormGruppo_1() {
	
		$dentiGruppo_1 = array();
	
		// primo gruppo --------------------------------------------------------------------------------------------------------------
	
		array_push($dentiGruppo_1, array('SD_18_1', $_POST['SD_18_1']), array('SD_17_1', $_POST['SD_17_1']), array('SD_16_1', $_POST['SD_16_1']));
		array_push($dentiGruppo_1, array('SD_15_1', $_POST['SD_15_1']), array('SD_14_1', $_POST['SD_14_1']), array('SD_13_1', $_POST['SD_13_1']));
		array_push($dentiGruppo_1, array('SD_12_1', $_POST['SD_12_1']), array('SD_11_1', $_POST['SD_11_1']));
	
		array_push($dentiGruppo_1, array('SS_21_1', $_POST['SS_21_1']), array('SS_22_1', $_POST['SS_22_1']), array('SS_23_1', $_POST['SS_23_1']));
		array_push($dentiGruppo_1, array('SS_24_1', $_POST['SS_24_1']), array('SS_25_1', $_POST['SS_25_1']), array('SS_26_1', $_POST['SS_26_1']));
		array_push($dentiGruppo_1, array('SS_27_1', $_POST['SS_27_1']), array('SS_28_1', $_POST['SS_28_1']));
	
		array_push($dentiGruppo_1, array('ID_48_1', $_POST['ID_48_1']), array('ID_47_1', $_POST['ID_47_1']), array('ID_46_1', $_POST['ID_46_1']));
		array_push($dentiGruppo_1, array('ID_45_1', $_POST['ID_45_1']), array('ID_44_1', $_POST['ID_44_1']), array('ID_43_1', $_POST['ID_43_1']));
		array_push($dentiGruppo_1, array('ID_42_1', $_POST['ID_42_1']), array('ID_41_1', $_POST['ID_41_1']));
	
		array_push($dentiGruppo_1, array('IS_31_1', $_POST['IS_31_1']), array('IS_32_1', $_POST['IS_32_1']), array('IS_33_1', $_POST['IS_33_1']));
		array_push($dentiGruppo_1, array('IS_34_1', $_POST['IS_34_1']), array('IS_35_1', $_POST['IS_35_1']), array('IS_36_1', $_POST['IS_36_1']));
		array_push($dentiGruppo_1, array('IS_37_1', $_POST['IS_37_1']), array('IS_38_1', $_POST['IS_38_1']));
	
		// restituisce l'array
	
		return $dentiGruppo_1;
	}
	
	public function prelevaCampiFormGruppo_2() {
	
		$dentiGruppo_2 = array();
	
		// secondo gruppo --------------------------------------------------------------------------------------------------------------
	
		array_push($dentiGruppo_2, array('SD_18_2', $_POST['SD_18_2']), array('SD_17_2', $_POST['SD_17_2']), array('SD_16_2', $_POST['SD_16_2']));
		array_push($dentiGruppo_2, array('SD_15_2', $_POST['SD_15_2']), array('SD_14_2', $_POST['SD_14_2']), array('SD_13_2', $_POST['SD_13_2']));
		array_push($dentiGruppo_2, array('SD_12_2', $_POST['SD_12_2']), array('SD_11_2', $_POST['SD_11_2']));
	
		array_push($dentiGruppo_2, array('SS_21_2', $_POST['SS_21_2']), array('SS_22_2', $_POST['SS_22_2']), array('SS_23_2', $_POST['SS_23_2']));
		array_push($dentiGruppo_2, array('SS_24_2', $_POST['SS_24_2']), array('SS_25_2', $_POST['SS_25_2']), array('SS_26_2', $_POST['SS_26_2']));
		array_push($dentiGruppo_2, array('SS_27_2', $_POST['SS_27_2']), array('SS_28_2', $_POST['SS_28_2']));
	
		array_push($dentiGruppo_2, array('ID_48_2', $_POST['ID_48_2']), array('ID_47_2', $_POST['ID_47_2']), array('ID_46_2', $_POST['ID_46_2']));
		array_push($dentiGruppo_2, array('ID_45_2', $_POST['ID_45_2']), array('ID_44_2', $_POST['ID_44_2']), array('ID_43_2', $_POST['ID_43_2']));
		array_push($dentiGruppo_2, array('ID_42_2', $_POST['ID_42_2']), array('ID_41_2', $_POST['ID_41_2']));
	
		array_push($dentiGruppo_2, array('IS_31_2', $_POST['IS_31_2']), array('IS_32_2', $_POST['IS_32_2']), array('IS_33_2', $_POST['IS_33_2']));
		array_push($dentiGruppo_2, array('IS_34_2', $_POST['IS_34_2']), array('IS_35_2', $_POST['IS_35_2']), array('IS_36_2', $_POST['IS_36_2']));
		array_push($dentiGruppo_2, array('IS_37_2', $_POST['IS_37_2']), array('IS_38_2', $_POST['IS_38_2']));
	
		// restituisce l'array
	
		return $dentiGruppo_2;
	}
	
	public function prelevaCampiFormGruppo_3() {
	
		$dentiGruppo_3 = array();
	
		// terzo gruppo --------------------------------------------------------------------------------------------------------------
	
		array_push($dentiGruppo_3, array('SD_18_3', $_POST['SD_18_3']), array('SD_17_3', $_POST['SD_17_3']), array('SD_16_3', $_POST['SD_16_3']));
		array_push($dentiGruppo_3, array('SD_15_3', $_POST['SD_15_3']), array('SD_14_3', $_POST['SD_14_3']), array('SD_13_3', $_POST['SD_13_3']));
		array_push($dentiGruppo_3, array('SD_12_3', $_POST['SD_12_3']), array('SD_11_3', $_POST['SD_11_3']));
	
		array_push($dentiGruppo_3, array('SS_21_3', $_POST['SS_21_3']), array('SS_22_3', $_POST['SS_22_3']), array('SS_23_3', $_POST['SS_23_3']));
		array_push($dentiGruppo_3, array('SS_24_3', $_POST['SS_24_3']), array('SS_25_3', $_POST['SS_25_3']), array('SS_26_3', $_POST['SS_26_3']));
		array_push($dentiGruppo_3, array('SS_27_3', $_POST['SS_27_3']), array('SS_28_3', $_POST['SS_28_3']));
	
		array_push($dentiGruppo_3, array('ID_48_3', $_POST['ID_48_3']), array('ID_47_3', $_POST['ID_47_3']), array('ID_46_3', $_POST['ID_46_3']));
		array_push($dentiGruppo_3, array('ID_45_3', $_POST['ID_45_3']), array('ID_44_3', $_POST['ID_44_3']), array('ID_43_3', $_POST['ID_43_3']));
		array_push($dentiGruppo_3, array('ID_42_3', $_POST['ID_42_3']), array('ID_41_3', $_POST['ID_41_3']));
	
		array_push($dentiGruppo_3, array('IS_31_3', $_POST['IS_31_3']), array('IS_32_3', $_POST['IS_32_3']), array('IS_33_3', $_POST['IS_33_3']));
		array_push($dentiGruppo_3, array('IS_34_3', $_POST['IS_34_3']), array('IS_35_3', $_POST['IS_35_3']), array('IS_36_3', $_POST['IS_36_3']));
		array_push($dentiGruppo_3, array('IS_37_3', $_POST['IS_37_3']), array('IS_38_3', $_POST['IS_38_3']));
	
		// restituisce l'array
	
		return $dentiGruppo_3;
	}
	
	public function prelevaCampiFormGruppo_4() {
	
		$dentiGruppo_4 = array();
	
		// quarto gruppo --------------------------------------------------------------------------------------------------------------
	
		array_push($dentiGruppo_4, array('SD_18_4', $_POST['SD_18_4']), array('SD_17_4', $_POST['SD_17_4']), array('SD_16_4', $_POST['SD_16_4']));
		array_push($dentiGruppo_4, array('SD_15_4', $_POST['SD_15_4']), array('SD_14_4', $_POST['SD_14_4']), array('SD_13_4', $_POST['SD_13_4']));
		array_push($dentiGruppo_4, array('SD_12_4', $_POST['SD_12_4']), array('SD_11_4', $_POST['SD_11_4']));
	
		array_push($dentiGruppo_4, array('SS_21_4', $_POST['SS_21_4']), array('SS_22_4', $_POST['SS_22_4']), array('SS_23_4', $_POST['SS_23_4']));
		array_push($dentiGruppo_4, array('SS_24_4', $_POST['SS_24_4']), array('SS_25_4', $_POST['SS_25_4']), array('SS_26_4', $_POST['SS_26_4']));
		array_push($dentiGruppo_4, array('SS_27_4', $_POST['SS_27_4']), array('SS_28_4', $_POST['SS_28_4']));
	
		array_push($dentiGruppo_4, array('ID_48_4', $_POST['ID_48_4']), array('ID_47_4', $_POST['ID_47_4']), array('ID_46_4', $_POST['ID_46_4']));
		array_push($dentiGruppo_4, array('ID_45_4', $_POST['ID_45_4']), array('ID_44_4', $_POST['ID_44_4']), array('ID_43_4', $_POST['ID_43_4']));
		array_push($dentiGruppo_4, array('ID_42_4', $_POST['ID_42_4']), array('ID_41_4', $_POST['ID_41_4']));
	
		array_push($dentiGruppo_4, array('IS_31_4', $_POST['IS_31_4']), array('IS_32_4', $_POST['IS_32_4']), array('IS_33_4', $_POST['IS_33_4']));
		array_push($dentiGruppo_4, array('IS_34_4', $_POST['IS_34_4']), array('IS_35_4', $_POST['IS_35_4']), array('IS_36_4', $_POST['IS_36_4']));
		array_push($dentiGruppo_4, array('IS_37_4', $_POST['IS_37_4']), array('IS_38_4', $_POST['IS_38_4']));
	
		// restituisce l'array
	
		return $dentiGruppo_4;
	}

	public function prelevaCampiFormPagamento() {
		
		$_SESSION['scontopercentuale'] = $_POST['scontopercentuale'];
		$_SESSION['scontocontante'] = $_POST['scontocontante'];

		$_SESSION['datascadenzaacconto'] = $_POST['datascadenzaacconto'];
		$_SESSION['descrizioneacconto'] = $_POST['descrizioneacconto'];
		$_SESSION['importoacconto'] = $_POST['importoacconto'];
		
		$_SESSION['importodarateizzare'] = $_POST['importodarateizzare'];
		$_SESSION['dataprimarata'] = $_POST['dataprimarata'];		
		$_SESSION['numerogiornirata'] = $_POST['numerogiornirata'];
		$_SESSION['importorata'] = $_POST['importorata'];		
	}
	
	/**
	 *
	 * @param unknown $db
	 * @return il result ottenuto dalla creazione del sottopreventivo
	 */
	public function creaSottoPreventivo($db) {
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$replace = array('%idpreventivo%' => $_SESSION['idPreventivo']);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryCreaSottoPreventivo;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return $result;
	}

	/**
	 * 
	 * @param unknown $db
	 * @param unknown $idpreventivo
	 * @param unknown $nomeForm
	 */
	public function leggiVociPreventivoPrincipale($db, $idpreventivo, $nomeForm) {
	
		require_once 'database.class.php';
		require_once 'utility.class.php';
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$replace = array(
				'%idpreventivo%' => $idpreventivo,
				'%nomeform%' => $nomeForm,
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryLeggiVociPreventivoPrincipale;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return pg_fetch_all($result);
	}

	/**
	 * 
	 * @param unknown $db
	 * @param unknown $idsottopreventivo
	 * @param unknown $nomeForm
	 */
	public function leggiVociPreventivoSecondario($db, $idsottopreventivo, $nomeForm) {
	
		require_once 'database.class.php';
		require_once 'utility.class.php';
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$replace = array(
				'%idsottopreventivo%' => $idsottopreventivo,
				'%nomeform%' => $nomeForm,
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryLeggiVociPreventivoSecondario;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return pg_fetch_all($result);
	}
	
	/**
	 * 
	 * @param unknown $db
	 * @param unknown $idpreventivo
	 * @param unknown $nomeCampo
	 * @param unknown $nomeForm
	 */
	public function leggiVoceCuraPreventivoPrincipale($db, $idpreventivo, $nomeCampo, $nomeForm) {
	
		require_once 'database.class.php';
		require_once 'utility.class.php';
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$replace = array(
				'%idpreventivo%' => $idpreventivo,
				'%nomeform%' => $nomeForm,
				'%idnomecampo%' => $nomeCampo
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryVocePreventivoPrincipalePaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return pg_fetch_all($result);
	}

	public function leggiVoceCuraPreventivoSecondario($db, $idsottopreventivo, $nomeCampo, $nomeForm) {
	
		require_once 'database.class.php';
		require_once 'utility.class.php';
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$replace = array(
				'%idsottopreventivo%' => $idsottopreventivo,
				'%nomeform%' => $nomeForm,
				'%idnomecampo%' => $nomeCampo
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryVocePreventivoSecondarioPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return pg_fetch_all($result);
	}

	/**
	 *
	 * @param unknown $db
	 * @param unknown $idPreventivoUsato
	 * @param unknown $nomeForm
	 * @param unknown $nomeCampoForm
	 * @param unknown $codiceVoceListino
	 * @return il result ottenuto
	 */
	public function creaVocePreventivo($db, $idPreventivoUsato, $nomeForm, $nomeCampoForm, $codiceVoceListino) {
	
		$utility = new utility();
		$array = $utility->getConfig();
			
		$replace = array(
				'%nomeform%' => trim($nomeForm),
				'%nomecampoform%' => trim($nomeCampoForm),
				'%codicevocelistino%' => trim($codiceVoceListino),
				'%idpreventivo%' => $idPreventivoUsato,
				'%prezzo%' => $this->prelevaPrezzoVoceListino($db, $_SESSION['idListino'], $codiceVoceListino)
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryCreaVocePreventivo;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		/**
		 * Se la creazione della voce è andata bene incremento il contatore di uso della voce sul listino
		*/
	
		if ($result) {
			$this->aggiornaUsoVoceListino($db, $_SESSION['idListino'], trim($codiceVoceListino), '+');
		}
		return $result;
	}
	
	/**
	 * 
	 * @param unknown $db
	 * @param unknown $idPreventivoUsato
	 * @param unknown $nomeForm
	 * @param unknown $nomeCampoForm
	 * @param unknown $codiceVoceListino
	 * @return unknown
	 */
	public function creaVoceSottoPreventivo($db, $idPreventivoUsato, $nomeForm, $nomeCampoForm, $codiceVoceListino) {
	
		$utility = new utility();
		$array = $utility->getConfig();
			
		$replace = array(
				'%nomeform%' => trim($nomeForm),
				'%nomecampoform%' => trim($nomeCampoForm),
				'%codicevocelistino%' => trim($codiceVoceListino),
				'%idpreventivo%' => $idPreventivoUsato,
				'%prezzo%' => $this->prelevaPrezzoVoceListino($db, $_SESSION['idListino'], $codiceVoceListino)
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryCreaVoceSottoPreventivo;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		/**
		 * Se la creazione della voce è andata bene incremento il contatore di uso della voce sul listino
		*/
	
		if ($result) {
			$this->aggiornaUsoVoceListino($db, $_SESSION['idListino'], trim($codiceVoceListino), '+');
		}
		return $result;
	}
	
	/**	
	 * 
	 * @param unknown $db
	 * @param unknown $idListino
	 * @param unknown $codiceVoceListino
	 * @return il prezzo della voce
	 */
	public function prelevaPrezzoVoceListino($db, $idListino, $codiceVoceListino) {
		
		$this->setPathToInclude();
	
		require_once 'vocelistino.class.php';
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$voceListino = new voceListino();
	
		$idVoce = $voceListino->prelevaIdVoce($db, $utility, $codiceVoceListino);
	
		$replace = array(
				'%idvocelistino%' => trim($idVoce),
				'%idlistino%' => trim($idListino)
		);

		$sqlTemplate = self::$root . $array['query'] . self::$queryLeggiPrezzoVoceListino;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
			
		$voceListino = pg_fetch_all($result);
		
		if (!$voceListino) {
			return 0;
		}
		else {
			foreach ($voceListino as $row) {
				return $row['prezzo'];
			}
		}		
	}	

	/**
	 * 
	 * @param unknown $db
	 * @param unknown $idvocevisita
	 * @return il codice voce listino
	 */
	public function leggiIdVocePreventivo($db, $idvocepreventivo) {
	
		require_once 'database.class.php';
		require_once 'utility.class.php';
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$replace = array('%idvocepreventivo%' => $idvocepreventivo);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryIdVocePreventivoPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		$voceVisita = pg_fetch_all($result);
	
		if (!$voceVisita) {
			return "";
		}
		else {
			foreach ($voceVisita as $row) {
				return $row['codicevocelistino'];
			}
		}
	}

	/**
	 * 
	 * @param unknown $db
	 * @param unknown $idvocepreventivo
	 * @return la tupla della vocepreventivo trovata
	 */
	public function leggiVocePreventivoPrincipale($db, $idvocepreventivo) {
	
		require_once 'database.class.php';
		require_once 'utility.class.php';
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$replace = array('%idvocepreventivo%' => $idvocepreventivo);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryIdVocePreventivoPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return pg_fetch_all($result);
	}
	
	/**
	 *
	 * @param unknown $db
	 * @param unknown $idvocevisita
	 * @return il codice voce listino
	 */
	public function leggiIdVoceSottoPreventivo($db, $idvocesottopreventivo) {
	
		require_once 'database.class.php';
		require_once 'utility.class.php';
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$replace = array('%idvocesottopreventivo%' => $idvocesottopreventivo);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryIdVoceSottoPreventivoPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		$voceVisita = pg_fetch_all($result);
	
		if (!$voceVisita) {
			return "";
		}
		else {
			foreach ($voceVisita as $row) {
				return $row['codicevocelistino'];
			}
		}
	}

	public function leggiVocePreventivoSecondario($db, $idvocesottopreventivo) {
	
		require_once 'database.class.php';
		require_once 'utility.class.php';
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$replace = array('%idvocesottopreventivo%' => $idvocesottopreventivo);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryIdVoceSottoPreventivoPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return pg_fetch_all($result);
	}
	
	/**
	 * 
	 * @param unknown $db
	 * @param unknown $idListino
	 * @param unknown $codiceVoceListino
	 * @param unknown $operatore
	 * @return il result dell'aggiornamento
	 */
	public function aggiornaUsoVoceListino($db, $idListino, $codiceVoceListino, $operatore) {
	
		$this->setPathToInclude();
	
		require_once 'vocelistino.class.php';
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$voceListino = new voceListino();
	
		$idVoce = $voceListino->prelevaIdVoce($db, $utility, $codiceVoceListino);
	
		$replace = array(
				'%idvocelistino%' => trim($idVoce),
				'%idlistino%' => trim($idListino),
				'%operatore%' => $operatore
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryAggiornaUsoVoceListino;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return $result;
	}

	/**
	 * 
	 * @param unknown $db
	 * @param unknown $idpreventivo
	 * @param unknown $nomeCampo
	 * @param unknown $nomeForm
	 * @return l'ID della voce inserita nel preventivo
	 */
	public function leggiVocePreventivo($db, $idpreventivo, $nomeCampo, $nomeForm) {
	
		require_once 'database.class.php';
		require_once 'utility.class.php';
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$replace = array(
				'%idpreventivo%' => $idpreventivo,
				'%nomeform%' => $nomeForm,
				'%idnomecampo%' => $nomeCampo
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryVocePreventivoPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		$vociInserite = pg_fetch_all($result);
	
		if (!$vociInserite) {
			return "";
		}
		else {
			foreach ($vociInserite as $voce) {
				return $voce['idvocepreventivo'];
			}
		}
	}
	
	/**
	 * 
	 * @param unknown $db
	 * @param unknown $idpreventivo
	 * @param unknown $nomeCampo
	 * @param unknown $nomeForm
	 * @return string|unknown
	 */
	public function leggiVoceSottoPreventivo($db, $idsottopreventivo, $nomeCampo, $nomeForm) {
	
		require_once 'database.class.php';
		require_once 'utility.class.php';
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$replace = array(
				'%idsottopreventivo%' => $idsottopreventivo,
				'%nomeform%' => $nomeForm,
				'%idnomecampo%' => $nomeCampo
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryVoceSottoPreventivoPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		$vociInserite = pg_fetch_all($result);
	
		if (!$vociInserite) {
			return "";
		}
		else {
			foreach ($vociInserite as $voce) {
				return $voce['idvocesottopreventivo'];
			}
		}
	}
	
	/**
	 * 
	 * @param unknown $db
	 * @param unknown $idvocepreventivo
	 * @param unknown $codiceVoceListino
	 * @return L'esito dell'aggiornamento della voce
	 */
	public function aggiornaVocePreventivo($db, $idvocepreventivo, $codiceVoceListino) {
	
		$utility = new utility();
		$array = $utility->getConfig();
			
		$replace = array(
				'%codicevocelistino%' => trim($codiceVoceListino),
				'%idvocepreventivo%' => $idvocepreventivo
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryAggiornaVocePreventivo;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return $result;
	}

	/**
	 * 
	 * @param unknown $db
	 * @param unknown $idvocepreventivo
	 * @param unknown $codiceVoceListino
	 * @return unknown
	 */
	public function aggiornaVoceSottoPreventivo($db, $idvocesottopreventivo, $codiceVoceListino) {
	
		$utility = new utility();
		$array = $utility->getConfig();
			
		$replace = array(
				'%codicevocelistino%' => trim($codiceVoceListino),
				'%idvocesottopreventivo%' => $idvocesottopreventivo
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryAggiornaVoceSottoPreventivo;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return $result;
	}
	
	/**
	 * 
	 * @param unknown $db
	 * @param unknown $utility
	 * @param unknown $descrizione
	 * @param unknown $prezzo
	 * @return L'esito dell'aggiornamento
	 */
	public function aggiornaVocePreventivoPrincipale($db, $utility, $descrizione, $prezzo, $idvocepreventivo) {
	
		$utility = new utility();
		$array = $utility->getConfig();
			
		$replace = array(
				'%descrizione%' => trim($descrizione),
				'%prezzo%' => $prezzo,
				'%idvocepreventivo%' => $idvocepreventivo
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryAggiornaVocePreventivoPrincipale;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return $result;
	}

	/**
	 * 
	 * @param unknown $db
	 * @param unknown $utility
	 * @param unknown $descrizione
	 * @param unknown $prezzo
	 * @param unknown $idvocesottopreventivo
	 * @return L'esito dell'aggiornamento
	 */
	public function aggiornaVocePreventivoSecondario($db, $utility, $descrizione, $prezzo, $idvocesottopreventivo) {
	
		$utility = new utility();
		$array = $utility->getConfig();
			
		$replace = array(
				'%descrizione%' => trim($descrizione),
				'%prezzo%' => $prezzo,
				'%idvocesottopreventivo%' => $idvocesottopreventivo
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryAggiornaVocePreventivoSecondario;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return $result;
	}
	
	
	/**
	 * 
	 * @param unknown $db
	 * @param unknown $idVocePreventivo
	 * @return L'esito della cancellazione
	 */
	public function cancellaVocePreventivo($db, $idVocePreventivo) {
	
		$utility = new utility();
		$array = $utility->getConfig();
	
	
		$codiceVoceListino = $this->leggiIdVocePreventivo($db, $idVocePreventivo);
	
		$replace = array('%idvocepreventivo%' => $idVocePreventivo );
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryCancellaVocePreventivo;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		/**
		 * Se la cancellazione della voce è andata bene decremento il contatore di uso della voce sul listino
		*/
	
		if ($result) {
			$this->aggiornaUsoVoceListino($db, $_SESSION['idListino'], trim($codiceVoceListino), '-');
		}
		return $result;
	}

	/**
	 * 
	 * @param unknown $db
	 * @param unknown $idVocePreventivo
	 * @return unknown
	 */
	public function cancellaVoceSottoPreventivo($db, $idVoceSottoPreventivo) {
	
		$utility = new utility();
		$array = $utility->getConfig();
	
	
		$codiceVoceListino = $this->leggiIdVoceSottoPreventivo($db, $idVoceSottoPreventivo);
	
		$replace = array('%idvocesottopreventivo%' => $idVoceSottoPreventivo );
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryCancellaVoceSottoPreventivo;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		/**
		 * Se la cancellazione della voce è andata bene decremento il contatore di uso della voce sul listino
		*/
	
		if ($result) {
			$this->aggiornaUsoVoceListino($db, $_SESSION['idListino'], trim($codiceVoceListino), '-');
		}
		return $result;
	}
	
	/**
	 * 
	 * @param unknown $db
	 * @param unknown $idPreventivo
	 * @return L'esito dell'aggiornamento
	 */
	public function aggiornaPreventivo($db, $idPreventivo) {
	
		$utility = new utility();
		$array = $utility->getConfig();
			
		$replace = array('%idpreventivo%' => $idPreventivo);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryAggiornaPreventivo;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return $result;
	}
	
	/**
	 * 
	 * @param unknown $db
	 * @param unknown $idPreventivo
	 * @param unknown $stato
	 * @return unknown
	 */
	public function aggiornaStatoPreventivo($db, $idPreventivo, $stato) {
	
		$utility = new utility();
		$array = $utility->getConfig();
			
		$replace = array(
				'%idpreventivo%' => $idPreventivo,
				'%stato%' => $stato
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryAggiornaStatoPreventivo;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return $result;
	}

	public function aggiornaStatoSottoPreventivo($db, $idSottoPreventivo, $stato) {
	
		$utility = new utility();
		$array = $utility->getConfig();
			
		$replace = array(
				'%idsottopreventivo%' => $idSottoPreventivo,
				'%stato%' => $stato
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryAggiornaStatoSottoPreventivo;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return $result;
	}
	
	/**
	 * 
	 * @param unknown $db
	 * @param unknown $idVocePreventivo
	 * @param unknown $stato
	 * @return L'esito dell'aggiornamento
	 */
	public function aggiornaStatoVocePreventivoPrincipale($db, $idVocePreventivo, $stato) {

		$utility = new utility();
		$array = $utility->getConfig();
			
		$replace = array(
				'%idvocepreventivo%' => $idVocePreventivo,
				'%stato%' => $stato
		);
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryAggiornaStatoVocePreventivoPrincipale;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
		
		return $result;		
	}

	/**
	 * 
	 * @param unknown $db
	 * @param unknown $idVoceSottoPreventivo
	 * @param unknown $stato
	 * @return L'esito dell'aggiornamento
	 */
	public function aggiornaStatoVocePreventivoSecondario($db, $idVoceSottoPreventivo, $stato) {
	
		$utility = new utility();
		$array = $utility->getConfig();
			
		$replace = array(
				'%idvocesottopreventivo%' => $idVoceSottoPreventivo,
				'%stato%' => $stato
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryAggiornaStatoVocePreventivoSecondario;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return $result;
	}
		
	/**
	 * 
	 * @param unknown $db
	 * @param unknown $idPreventivo
	 * @return unknown
	 */
	public function aggiornaSottoPreventivo($db, $idSottoPreventivo) {
	
		$utility = new utility();
		$array = $utility->getConfig();
			
		$replace = array('%idsottopreventivo%' => $idSottoPreventivo);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryAggiornaSottoPreventivo;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return $result;
	}
	
	/**
	 * 
	 * @param unknown $db
	 */
	public function prelevaRiassuntoVociStampaPreventivoPrincipale($db, $root, $idpaziente, $idpreventivo) {

		$utility = new utility();
		$array = $utility->getConfig();
		
		$replace = array(
				'%idpaziente%' => $idpaziente,
				'%idpreventivo%' => $idpreventivo
		);
	
		$sqlTemplate = $root . $array['query'] . self::$queryRiassuntoVociStampaPreventivoPrincipale;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return pg_fetch_all($result);
	}

	/**
	 * 
	 * @param unknown $db
	 * @param unknown $root
	 * @param unknown $idpaziente
	 * @param unknown $idsottopreventivo
	 */
	public function prelevaRiassuntoVociStampaPreventivoSecondario($db, $root, $idpaziente, $idsottopreventivo) {
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$replace = array(
				'%idpaziente%' => $idpaziente,
				'%idsottopreventivo%' => $idsottopreventivo
		);
	
		$sqlTemplate = $root . $array['query'] . self::$queryRiassuntoVociStampaPreventivoSecondario;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return pg_fetch_all($result);
	}
	
	/**
	 * @param unknown $db
	 * @param unknown $dettaglioPreventivoTemplate
	 */
	public function prelevaVociPreventivoPrincipale($db, $dettaglioPreventivoTemplate) {
	
		//-- Prelevo i tipi voci caricati -----------------------------------------------------------
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$replace = array(
			'%idpaziente%' => $_SESSION['idPaziente'],
			'%idpreventivo%' => $_SESSION['idPreventivo']
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryRicercaTipiVociPreventivoPrincipalePaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
	
		$tipiVoci = pg_fetch_all($result);
	
		unset($_SESSION['vociPreventivoDentiSingoli']);
		unset($_SESSION['vociPreventivoGruppi']);
		unset($_SESSION['vociPreventivoCure']);
				
		if ($tipiVoci) {
			foreach ($tipiVoci as $row) {
				if (trim($row['tipovoce']) == 'singoli') $this->prelevaVociDentiSingoli($db, $_SESSION['idPreventivo'], self::$queryRiepilogoVociPreventivoPrincipalePaziente, $utility, $array, $dettaglioPreventivoTemplate);
				if (trim($row['tipovoce']) == 'gruppi') $this->prelevaVociGruppi($db, $_SESSION['idPreventivo'], self::$queryRiepilogoVociGruppiPreventivoPrincipalePaziente, $utility, $array, $dettaglioPreventivoTemplate);
				if (trim($row['tipovoce']) == 'cure') $this->prelevaVociCure($db, $_SESSION['idPreventivo'], self::$queryRiepilogoVociPreventivoPrincipalePaziente, $utility, $array, $dettaglioPreventivoTemplate);
			}
		}
	}

	/**
	 * @param unknown $db
	 * @param unknown $dettaglioPreventivoTemplate
	 */
	public function prelevaVociPreventivoSecondario($db, $dettaglioPreventivoTemplate) {
	
		//-- Prelevo i tipi voci caricati -----------------------------------------------------------
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$replace = array(
				'%idpaziente%' => $_SESSION['idPaziente'],
				'%idpreventivo%' => $_SESSION['idPreventivoPrincipale'],
				'%idsottopreventivo%' => $_SESSION['idSottoPreventivo']
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryRicercaTipiVociPreventivoSecondarioPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
	
		$tipiVoci = pg_fetch_all($result);
		
		unset($_SESSION['vociPreventivoDentiSingoli']);
		unset($_SESSION['vociPreventivoGruppi']);
		unset($_SESSION['vociPreventivoCure']);
		
		if ($tipiVoci) {
			foreach ($tipiVoci as $row) {
				if (trim($row['tipovoce']) == 'singoli') $this->prelevaVociDentiSingoli($db, $_SESSION['idPreventivoPrincipale'], self::$queryRiepilogoVociPreventivoSecondarioPaziente, $utility, $array, $dettaglioPreventivoTemplate);
				if (trim($row['tipovoce']) == 'gruppi') $this->prelevaVociGruppi($db, $_SESSION['idPreventivoPrincipale'], self::$queryRiepilogoVociGruppiPreventivoSecondarioPaziente, $utility, $array, $dettaglioPreventivoTemplate);
				if (trim($row['tipovoce']) == 'cure') $this->prelevaVociCure($db, $_SESSION['idPreventivoPrincipale'], self::$queryRiepilogoVociPreventivoSecondarioPaziente, $utility, $array, $dettaglioPreventivoTemplate);
			}
		}
	}

	/**
	 * @param unknown $db
	 * @param unknown $idPreventivo
	 * @param unknown $query
	 * @param unknown $utility
	 * @param unknown $array
	 * @param unknown $dettaglioPreventivoTemplate
	 */
	public function prelevaVociDentiSingoli($db, $idPreventivo, $query, $utility, $array, $dettaglioPreventivoTemplate) {
	
		$replace = array(
				'%idpaziente%' => $_SESSION['idPaziente'],
				'%idpreventivo%' => $idPreventivo,
				'%idsottopreventivo%' => $_SESSION['idSottoPreventivo'],
				'%nomeform%' => 'singoli'
		);
	
		$sqlTemplate = self::$root . $array['query'] . $query;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
	
		$_SESSION['vociPreventivoDentiSingoli'] = pg_fetch_all($result);
	}

	/**
	 * @param unknown $db
	 * @param unknown $idPreventivo
	 * @param unknown $query
	 * @param unknown $utility
	 * @param unknown $array
	 * @param unknown $dettaglioPreventivoTemplate
	 */
	public function prelevaVociGruppi($db, $idPreventivo, $query, $utility, $array, $dettaglioPreventivoTemplate) {
	
		$replace = array(
				'%idpaziente%' => $_SESSION['idPaziente'],
				'%idpreventivo%' => $idPreventivo,
				'%idsottopreventivo%' => $_SESSION['idSottoPreventivo'],
				'%nomeform%' => 'gruppi'
		);
	
		$sqlTemplate = self::$root . $array['query'] . $query;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
	
		$_SESSION['vociPreventivoGruppi'] = pg_fetch_all($result);
	}

	/**
	 * @param unknown $db
	 * @param unknown $idPreventivo
	 * @param unknown $query
	 * @param unknown $utility
	 * @param unknown $array
	 * @param unknown $dettaglioPreventivoTemplate
	 */
	public function prelevaVociCure($db, $idPreventivo, $query, $utility, $array, $dettaglioPreventivoTemplate) {
		
		$replace = array(
				'%idpaziente%' => $_SESSION['idPaziente'],
				'%idpreventivo%' => $idPreventivo,
				'%idsottopreventivo%' => $_SESSION['idSottoPreventivo'],
				'%nomeform%' => 'cure'
		);
	
		$sqlTemplate = self::$root . $array['query'] . $query;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
	
		$_SESSION['vociPreventivoCure'] = pg_fetch_all($result);
	}	

	/**
	 * 
	 * @param unknown $db
	 * @param unknown $idCartellaClinicaUsato
	 * @param unknown $nomeForm
	 * @param unknown $nomeCampoForm
	 * @param unknown $codiceVoceListino
	 * @param unknown $prezzo
	 * @return unknown
	 */
	public function creaVoceCartellaClinica($db, $idCartellaClinicaUsato, $nomeForm, $nomeCampoForm, $codiceVoceListino, $prezzo) {
	
		$utility = new utility();
		$array = $utility->getConfig();
			
		$replace = array(
				'%nomeform%' => trim($nomeForm),
				'%nomecampoform%' => trim($nomeCampoForm),
				'%codicevocelistino%' => trim($codiceVoceListino),
				'%idcartellaclinica%' => $idCartellaClinicaUsato,
				'%prezzo%' => $prezzo
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryCreaVoceCartellaClinica;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return $result;
	}

	/**
	 * 
	 * @param unknown $db
	 * @param unknown $utility
	 * @param unknown $idPreventivo
	 * @param unknown $idPaziente
	 * @return unknown
	 */
	public function leggiStatoPreventiviSecondari($db, $utility, $idPreventivo, $idPaziente, $stato) {

		$array = $utility->getConfig();
		
		$replace = array(
				'%idpaziente%' => $idPaziente,
				'%idpreventivo%' => $idPreventivo,
				'%stato%' => $stato
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryRicercaStatoPreventiviSecondari;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		$rows = pg_fetch_all($result);
		foreach ($rows as $row) {
			return $row['totaleproposti'];	
		}		
	}	

	/**
	 * 
	 * @param unknown $db
	 * @param unknown $utility
	 * @param unknown $idPreventivo
	 * @param unknown $idPaziente
	 * @return unknown
	 */
	public function leggiImportoPreventiviPrincipale($db, $utility, $idPreventivo, $idPaziente) {
	
		$array = $utility->getConfig();
	
		$replace = array(
				'%idpaziente%' => $idPaziente,
				'%idpreventivo%' => $idPreventivo
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryLeggiImportoPreventiviPrincipale;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		$rows = pg_fetch_all($result);
		foreach ($rows as $row) {
			return $row['totaleimportoprincipale'];
		}
	}

	/**
	 * 
	 * @param unknown $db
	 * @param unknown $utility
	 * @param unknown $idPreventivo
	 * @param unknown $idPaziente
	 * @return Ambigous <string, unknown>
	 */
	public function leggiStatoCartellaClinica($db, $utility, $idPreventivo, $idPaziente) {
	
		$stato = "";
		$array = $utility->getConfig();
	
		$replace = array(
				'%idpaziente%' => $idPaziente,
				'%idpreventivo%' => $idPreventivo
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryRicercaStatoCartellaClinica;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
	
		$rows = pg_fetch_all($result);
		foreach ($rows as $row) {
			$stato = $row['stato'];
		}
		return $stato;
	}	

	/**
	 * 
	 * @param unknown $db
	 * @param unknown $utility
	 * @param unknown $idPreventivo
	 * @param unknown $idPaziente
	 */
	public function rimuoviCartellaClinicaPreventivo($db, $utility, $idPreventivo, $idPaziente) {

		$array = $utility->getConfig();
		
		$replace = array(
				'%idpreventivo%' => $idPreventivo,
				'%idpaziente%' => $idPaziente				
		 );
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryCancellaCartellaClinicaPreventivo;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
		
		return $result;		
	}
	
	/**
	 * 
	 * @param unknown $db
	 * @param unknown $idPreventivo
	 * @param unknown $dataScadenza
	 * @param unknown $importo
	 * @param unknown $stato
	 * @return L'esito dell'operazione di creazione rata
	 */
	public function creaRataPagamentoPreventivoPrincipale($db, $utility, $idPreventivo, $dataScadenza, $importo, $stato) {
	
		$array = $utility->getConfig();
	
		$replace = array(
				'%idpreventivo%' => $idPreventivo,
				'%stato%' => $stato,
				'%datascadenza%' => $dataScadenza,
				'%importo%' => $importo
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryCreaRataPagamentoPreventivoPrincipale;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return $result;
	}

	/**
	 * 
	 * @param unknown $db
	 * @param unknown $utility
	 * @param unknown $idSottoPreventivo
	 * @param unknown $dataScadenza
	 * @param unknown $importo
	 * @param unknown $stato
	 * @return L'esito booleano della creazione
	 */
	public function creaRataPagamentoPreventivoSecondario($db, $utility, $idSottoPreventivo, $dataScadenza, $importo, $stato) {
	
		$array = $utility->getConfig();
	
		$replace = array(
				'%idsottopreventivo%' => $idSottoPreventivo,
				'%stato%' => $stato,
				'%datascadenza%' => $dataScadenza,
				'%importo%' => $importo
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryCreaRataPagamentoPreventivoSecondario;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return $result;
	}
	
	/**
	 * 
	 * @param unknown $db
	 * @param unknown $utility
	 * @param unknown $idPreventivo
	 * @param unknown $dataScadenzaAcconto
	 * @param unknown $descrizioneAcconto
	 * @param unknown $importoAcconto
	 * @return unknown
	 */
	public function creaAccontoPreventivoPrincipale($db, $utility, $idPreventivo, $dataScadenzaAcconto, $descrizioneAcconto, $importoAcconto) {
	
		$array = $utility->getConfig();
	
		$replace = array(
				'%idpreventivo%' => $idPreventivo,
				'%datascadenza%' => $dataScadenzaAcconto,
				'%descrizione%' => $descrizioneAcconto,
				'%importo%' => $importoAcconto
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryCreaAccontoPreventivoPrincipale;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return $result;
	}
	
	/**
	 * 
	 * @param unknown $db
	 * @param unknown $utility
	 * @param unknown $idSottoPreventivo
	 * @param unknown $dataScadenzaAcconto
	 * @param unknown $descrizioneAcconto
	 * @param unknown $importoAcconto
	 * @return unknown
	 */
	public function creaAccontoPreventivoSecondario($db, $utility, $idSottoPreventivo, $dataScadenzaAcconto, $descrizioneAcconto, $importoAcconto) {
	
		$array = $utility->getConfig();
	
		$replace = array(
				'%idsottopreventivo%' => $idSottoPreventivo,
				'%datascadenza%' => $dataScadenzaAcconto,
				'%descrizione%' => $descrizioneAcconto,
				'%importo%' => $importoAcconto
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryCreaAccontoPreventivoSecondario;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return $result;
	}
	
	/**
	 * 
	 * @param unknown $db
	 * @param unknown $utility
	 * @param unknown $idPreventivo
	 * @return L'esito della cancellazione
	 */
	public function cancellaRatePagamentoPreventivoPrincipale($db, $utility, $idPreventivo) {

		$array = $utility->getConfig();
		
		$replace = array('%idpreventivo%' => $idPreventivo);
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryCancellaRatePagamentoPreventivoPrincipale;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
		
		return $result;		
	}
	
	/**
	 * 
	 * @param unknown $db
	 * @param unknown $utility
	 * @param unknown $idSottoPreventivo
	 * @return L'esito della cancellazione
	 */
	public function cancellaRatePagamentoPreventivoSecondario($db, $utility, $idSottoPreventivo) {
	
		$array = $utility->getConfig();
	
		$replace = array('%idsottopreventivo%' => $idSottoPreventivo);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryCancellaRatePagamentoPreventivoSecondario;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return $result;
	}
	
	/**
	 * 
	 * @param unknown $db
	 * @param unknown $utility
	 * @param unknown $IdPreventivo
	 * @return un'array che contiene il resultset
	 */
	public function leggiRatePagamentoPreventivoPrincipale($db, $utility, $idPreventivo) {

		$array = $utility->getConfig();
		
		$replace = array('%idpreventivo%' => $idPreventivo);
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryLeggiRatePagamentoPreventivoPrincipale;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);

		return pg_fetch_all($result);
	}

	/**
	 * 
	 * @param unknown $db
	 * @param unknown $utility
	 * @param unknown $IdSottoPreventivo
	 * @return un'array che contiene il resultset
	 */
	public function leggiRatePagamentoPreventivoSecondario($db, $utility, $idSottoPreventivo) {

		$array = $utility->getConfig();
		
		$replace = array('%idsottopreventivo%' => $idSottoPreventivo);
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryLeggiRatePagamentoPreventivoSecondario;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
		
		return pg_fetch_all($result);		
	}
	
	/**
	 * 
	 * @param unknown $db
	 * @param unknown $utility
	 * @param unknown $idSottoPreventivo
	 */
	public function leggiAccontiPreventivoPrincipale($db, $utility, $idPreventivo) {

		$array = $utility->getConfig();
		
		$replace = array('%idpreventivo%' => $idPreventivo);
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryLeggiAccontiPreventivoPrincipale;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
		
		return pg_fetch_all($result);
	}	

	/**
	 * 
	 * @param unknown $db
	 * @param unknown $utility
	 * @param unknown $idSottoPreventivo
	 */
	public function leggiAccontiPreventivoSecondario($db, $utility, $idSottoPreventivo) {
	
		$array = $utility->getConfig();
	
		$replace = array('%idsottopreventivo%' => $idSottoPreventivo);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryLeggiAccontiPreventivoSecondario;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return pg_fetch_all($result);
	}
	
	/**
	 * 
	 * @param unknown $idPreventivo
	 * @return Void, setta le variabili di classe corrispondenti alle colonne della tupla
	 */
	public function leggiCondizioniPagamentoPreventivoPrincipale($db, $utility, $idPreventivo) {
	
		$array = $utility->getConfig();
		$replace = array('%idpreventivo%' => $idPreventivo);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryLeggiCondizioniPagamentoPreventivoPrincipale;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		$rows = pg_fetch_all($result);
	
		foreach ($rows as $row) {
			$_SESSION['scontopercentuale'] = $row['scontopercentuale'];
			$_SESSION['scontocontante'] = $row['scontocontante'];
			$_SESSION['importodarateizzare'] = $row['importodarateizzare'];
			$_SESSION['numerogiornirata'] = $row['numerogiornirata'];
			$_SESSION['importorata'] = $row['importorata'];
			$_SESSION['dataprimarata'] = $row['dataprimarata'];
		}
	}

	public function leggiCondizioniPagamentoPreventivoSecondario($db, $utility, $idSottoPreventivo) {

		$array = $utility->getConfig();
		$replace = array('%idsottopreventivo%' => $idSottoPreventivo);
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryLeggiCondizioniPagamentoPreventivoSecondario;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
		
		$rows = pg_fetch_all($result);
		
		foreach ($rows as $row) {
			$_SESSION['scontopercentuale'] = $row['scontopercentuale'];
			$_SESSION['scontocontante'] = $row['scontocontante'];
			$_SESSION['importodarateizzare'] = $row['importodarateizzare'];
			$_SESSION['numerogiornirata'] = $row['numerogiornirata'];
			$_SESSION['importorata'] = $row['importorata'];
			$_SESSION['dataprimarata'] = $row['dataprimarata'];
		}		
	}	

	/**
	 * 
	 * @param unknown $db
	 * @param unknown $utility
	 * @param unknown $idAcconto
	 * @return L'esito della cancellazione
	 */
	public function cancellaAccontoPagamentoPreventivoPrincipale($db, $utility, $idAcconto) {

		$array = $utility->getConfig();
		
		$replace = array('%idacconto%' => $idAcconto);
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryCancellaAccontoPagamentoPreventivoPrincipale;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
		
		return $result;
	}
	
	/**
	 * 
	 * @param unknown $db
	 * @param unknown $utility
	 * @param unknown $idAcconto
	 * @return L'esito della cancellazione
	 */
	public function cancellaAccontoPagamentoPreventivoSecondario($db, $utility, $idAcconto) {
	
		$array = $utility->getConfig();
	
		$replace = array('%idaccontosottopreventivo%' => $idAcconto);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryCancellaAccontoPagamentoPreventivoSecondario;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return $result;	
	}

	/**
	 * 
	 * @param unknown $db
	 * @param unknown $utility
	 * @param unknown $idPreventivo
	 * @param unknown $stato
	 * @return Un'array con i totali acconti e rate
	 */
	public function sommaImportoVociPreventivoPrincipale($db, $utility, $idPreventivo, $stato) {
	
		$array = $utility->getConfig();
	
		$replace = array(
				'%idpreventivo%' => $idPreventivo,
				'%stato%' => $stato
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$querySommaImportoVociPreventivoPrincipale;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return pg_fetch_all($result);
	}

	public function sommaImportoVociPreventivoSecondario($db, $utility, $idsottoPreventivo, $stato) {
	
		$array = $utility->getConfig();
	
		$replace = array(
				'%idsottopreventivo%' => $idsottoPreventivo,
				'%stato%' => $stato
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$querySommaImportoVociPreventivoSecondario;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return pg_fetch_all($result);
	}

	/**
	 * 
	 * @param unknown $db
	 * @return unknown
	 */
	public function prelevaVociGruppiPreventivoPrincipale($db) {
	
		require_once 'database.class.php';
		require_once 'utility.class.php';
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$replace = array(
				'%idpaziente%' => $_SESSION['idPaziente'],
				'%idpreventivo%' => $_SESSION['idPreventivo']
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryVociPreventivoGruppiPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
	
		$dentiGruppo = pg_fetch_all($result);
		return $dentiGruppo;
	}

	/**
	 * 
	 * @param unknown $db
	 * @return unknown
	 */
	public function prelevaVociGruppiPreventivoSecondario($db) {
	
		require_once 'database.class.php';
		require_once 'utility.class.php';
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$replace = array(
				'%idpaziente%' => $_SESSION['idPaziente'],
				'%idpreventivo%' => $_SESSION['idPreventivoPrincipale'],
				'%idsottopreventivo%' => $_SESSION['idSottoPreventivo']
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryVociSottoPreventivoGruppiPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
	
		$dentiGruppo = pg_fetch_all($result);
		return $dentiGruppo;
	}
	
	/**
	 * 
	 * @param unknown $db
	 * @param unknown $utility
	 */
	public function caricaDatiAnagraficiPaziente($db, $utility) {
	
		$array = $utility->getConfig();
	
		$replace = array('%idpaziente%' => $_SESSION['idPaziente']);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryRicercaIdPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return pg_fetch_all($result);
	}
	
	/**
	 * 
	 * @return number
	 */
	public function calcolaTotalePreventivo($db) {

		if ($_SESSION['idPreventivo'] != "") {
		
			/**
			 * Totalizzo i denti singoli
			 */
			$totaleSingoli = 0;
			foreach ($this->leggiVociPreventivoPrincipale($db, $_SESSION['idPreventivo'], "singoli") as $row) {
				$totaleSingoli += $row['prezzo'];
			}
			$_SESSION['totalepreventivodentisingoli'] = $totaleSingoli;
		
			/**
			 * Totalizzo i gruppi
			 */
			$totaleGruppi = 0;
			foreach ($this->leggiVociPreventivoPrincipale($db, $_SESSION['idPreventivo'], "gruppi") as $row) {
				$totaleGruppi += $row['prezzo'];
			}
			$_SESSION['totalepreventivogruppi'] = $totaleGruppi;
		
			/**
			 * Totalizzo le cure
			 */
			$totaleCure = 0;
			foreach ($this->leggiVociPreventivoPrincipale($db, $_SESSION['idPreventivo'], "cure") as $row) {
				$totaleCure += $row['prezzo'];
			}
			$_SESSION['totalepreventivocure'] = $totaleCure;
		
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {
		
			/**
			 * Totalizzo i denti singoli
			 */
			$totaleSingoli = 0;
			foreach ($this->leggiVociPreventivoSecondario($db, $_SESSION['idSottoPreventivo'], "singoli") as $row) {
				$totaleSingoli += $row['prezzo'];
			}
			$_SESSION['totalepreventivodentisingoli'] = $totaleSingoli;
		
			/**
			 * Totalizzo i gruppi
			 */
			$totaleGruppi = 0;
			foreach ($this->leggiVociPreventivoSecondario($db, $_SESSION['idSottoPreventivo'], "gruppi") as $row) {
				$totaleGruppi += $row['prezzo'];
			}
			$_SESSION['totalepreventivogruppi'] = $totaleGruppi;
				
			/**
			 * Totalizzo le cure
			 */
			$totaleCure = 0;
			foreach ($this->leggiVociPreventivoSecondario($db, $_SESSION['idSottoPreventivo'], "cure") as $row) {
				$totaleCure += $row['prezzo'];
			}
			$_SESSION['totalepreventivocure'] = $totaleCure;
		}
		
		return $_SESSION['totalepreventivodentisingoli'] + $_SESSION['totalepreventivogruppi'] + $_SESSION['totalepreventivocure'];
	}

	/**
	 * 
	 * @param unknown $db
	 * @param unknown $utility
	 * @param unknown $idPreventivo
	 */
	public function leggiAnnotazioniPreventivoPrincipale($db, $utility, $idPreventivo) {
		
		$array = $utility->getConfig();
		
		$replace = array('%idpreventivo%' => $idPreventivo);
				
		$sqlTemplate = self::$root . $array['query'] . self::$queryAnnotazioniPreventivoPrincipale;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
		
		return pg_fetch_all($result);
	}

	/**
	 * 
	 * @param unknown $db
	 * @param unknown $utility
	 * @param unknown $idSottoPreventivo
	 */
	public function leggiAnnotazioniPreventivoSecondario($db, $utility, $idSottoPreventivo) {
	
		$array = $utility->getConfig();
	
		$replace = array('%idsottopreventivo%' => $idSottoPreventivo);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryAnnotazioniPreventivoSecondario;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return pg_fetch_all($result);
	}	
	
	/**
	 * 
	 * @param unknown $db
	 * @param unknown $utility
	 * @param unknown $idPreventivo
	 */
	public function leggiAnnotazioniVociPreventivoPrincipale($db, $utility, $idPreventivo) {
		
		$array = $utility->getConfig();
		
		$replace = array('%idpreventivo%' => $idPreventivo);
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryAnnotazioniVociPreventivoPrincipale;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
		
		return pg_fetch_all($result);
		
	}

	/**
	 * 
	 * @param unknown $db
	 * @param unknown $utility
	 * @param unknown $idSottoPreventivo
	 */
	public function leggiAnnotazioniVociPreventivoSecondario($db, $utility, $idSottoPreventivo) {
	
		$array = $utility->getConfig();
	
		$replace = array('%idsottopreventivo%' => $idSottoPreventivo);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryAnnotazioniVociPreventivoSecondario;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return pg_fetch_all($result);
	}

	/**
	 * 
	 * @param unknown $idPreventivo
	 * @param unknown $query
	 * @return unknown
	 */
	public function leggiNotaPreventivo($idPreventivo, $query) {
	
		require_once 'database.class.php';
	
		// carica e ritaglia il comando sql da lanciare
	
		$replace = array('%idpreventivo%' => $idPreventivo);
	
		$utility = new utility();
		$array = $utility->getConfig();
		$sqlTemplate = self::$root . $array['query'] . $query;
	
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
	
		// esegue la query
	
		$db = new database();
		$result = $db->getData($sql);
	
		$_SESSION['numeronotetrovate'] = pg_num_rows($result);
		$_SESSION['notetrovate'] = $result;
	
		return $result;
	}
	
	/**
	 * 
	 * @param unknown $db
	 * @param unknown $utility
	 * @param unknown $idpreventivo
	 * @param unknown $query
	 */
	public function creaNotaPreventivo($db, $utility, $idpreventivo, $query) {
		
		$array = $utility->getConfig();
		
		$replace = array(
				'%idpreventivo%' => $idpreventivo,
				'%nota%' => $_SESSION['notapreventivo']
		);
		
		$sqlTemplate = self::$root . $array['query'] . $query;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
		
		return $result;		
	}

	/**
	 * 
	 * @param unknown $db
	 * @param unknown $utility
	 * @param unknown $idNotaPreventivo
	 * @return NULL
	 */
	public function leggiNotaPreventivoPrincipale($db, $utility, $idNotaPreventivo) {

		$array = $utility->getConfig();
		
		$replace = array(
				'%idnotapreventivo%' => $idNotaPreventivo,
				'%idpreventivo%' => $_SESSION['idPreventivo']
		);
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryLeggiNotaPreventivoPrincipale;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);

		foreach (pg_fetch_all($result) as $row) {
			return trim($row['nota']);
		}
		return null;	
	}

	/**
	 * 
	 * @param unknown $db
	 * @param unknown $utility
	 * @param unknown $idNotaPreventivo
	 * @return NULL
	 */
	public function leggiNotaPreventivoSecondario($db, $utility, $idNotaPreventivo) {
	
		$array = $utility->getConfig();
	
		$replace = array(
				'%idnotasottopreventivo%' => $idNotaPreventivo,
				'%idsottopreventivo%' => $_SESSION['idSottoPreventivo']
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryLeggiNotaPreventivoSecondario;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		foreach (pg_fetch_all($result) as $row) {
			return trim($row['nota']);
		}
		return null;
	}
	
	/**
	 * 
	 * @param unknown $db
	 * @param unknown $utility
	 * @return unknown
	 */
	public function modificaNotaPreventivoPrincipale($db, $utility) {
	
		$array = $utility->getConfig();
	
		$replace = array(
				'%idpreventivo%' => $_SESSION['idPreventivo'],
				'%idnotapreventivo%' => $_SESSION['idNotaPreventivo'],
				'%notapreventivo%' => $_SESSION['notapreventivo']
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryAggiornaNotaPreventivoPrincipale;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return $result;
	}

	/**
	 * 
	 * @param unknown $db
	 * @param unknown $utility
	 * @return unknown
	 */
	public function modificaNotaPreventivoSecondario($db, $utility) {
	
		$array = $utility->getConfig();
	
		$replace = array(
				'%idsottopreventivo%' => $_SESSION['idSottoPreventivo'],
				'%idnotasottopreventivo%' => $_SESSION['idNotaPreventivo'],
				'%notapreventivo%' => $_SESSION['notapreventivo']
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryAggiornaNotaPreventivoSecondario;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return $result;
	}
	
	/**
	 * 
	 * @param unknown $db
	 * @param unknown $utility
	 * @return unknown
	 */
	public function cancellaNotaPreventivoPrincipale($db, $utility) {

		$array = $utility->getConfig();
		
		$replace = array(
				'%idpreventivo%' => $_SESSION['idPreventivo'],
				'%idnotapreventivo%' => $_SESSION['idNotaPreventivo']
		);
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryCancellaNotaPreventivoPrincipale;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
		
		return $result;
	}
	
	/**
	 * 
	 * @param unknown $db
	 * @param unknown $utility
	 * @return unknown
	 */
	public function cancellaNotaPreventivoSecondario($db, $utility) {
	
		$array = $utility->getConfig();
	
		$replace = array(
				'%idsottopreventivo%' => $_SESSION['idSottoPreventivo'],
				'%idnotasottopreventivo%' => $_SESSION['idNotaPreventivo']
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryCancellaNotaPreventivoSecondario;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return $result;
	}
	
}

?>

