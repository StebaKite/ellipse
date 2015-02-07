<?php

require_once 'ellipse.abstract.class.php';

abstract class preventivoAbstract extends ellipseAbstract {

	// Campi -----------------------------------------------------------------------------
	
	public static $messaggio;
	public static $numeroPreventiviTrovati;
	public static $preventiviTrovati;
	
	public static $cognomeRicerca;
	public static $idPaziente;
	public static $idListino;
	public static $idPreventivo;
	public static $idPreventivoPrincipale;
	public static $idSottoPreventivo;
	public static $idVocePreventivo;
	public static $idVoceSottoPreventivo;
	public static $cognome;
	public static $nome;
	public static $dataInserimento;
	public static $dataNascita;
	public static $stato;
	public static $prezzo;
	public static $nomeForm;
	public static $nomeCampoForm;
	public static $codiceVoceListino;
	public static $totalePreventivoPrincipale;
	public static $totalePreventivoSecondario;
	public static $totalePreventivo;
	public static $intestazioneColonnaAzioni;
	
	public static $azioneDentiSingoli;
	public static $azioneGruppi;
	public static $azioneCure;

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
	
	public static $dentiSingoli;
	public static $impostazioniVoci;

	private static $voceGruppo_1;
	private static $dentiGruppo_1;
	private static $voceGruppo_2;
	private static $dentiGruppo_2;
	private static $voceGruppo_3;
	private static $dentiGruppo_3;
	private static $voceGruppo_4;
	private static $dentiGruppo_4;
	
	public static $cureGeneriche;
	
	// Query -----------------------------------------------------------------------------
	
	public static $queryVociListinoPaziente = "/preventivo/ricercaVociListinoPaziente.sql";

	public static $queryCategorieVociListinoPaziente = "/preventivo/ricercaCategorieVociListinoPaziente.sql";
	public static $queryVociListinoCategoriaPaziente = "/preventivo/ricercaVociListinoCategoriaPaziente.sql";
	public static $queryVociGenericheListinoPaziente = "/preventivo/ricercaVociGenericheListinoPaziente.sql";

	public static $queryAggiornaUsoVoceListino = "/preventivo/aggiornaUsoVoceListino.sql";	
	public static $queryLeggiPrezzoVoceListino = "/preventivo/leggiPrezzoVoceListino.sql";
	public static $queryCreaPreventivo = "/preventivo/creaPreventivo.sql";
	public static $queryCreaSottoPreventivo = "/preventivo/creaSottoPreventivo.sql";
	
	public static $queryCreaVocePreventivo = "/preventivo/creaVocePreventivo.sql";
	public static $queryAggiornaPreventivo = "/preventivo/aggiornaPreventivo.sql";
	public static $queryAggiornaVocePreventivo = "/preventivo/aggiornaVocePreventivo.sql";
	public static $queryCancellaVocePreventivo = "/preventivo/cancellaVocePreventivo.sql";
	public static $queryVocePreventivoPaziente = "/preventivo/ricercaVocePreventivoPaziente.sql";	
	public static $queryIdVocePreventivoPaziente = "/preventivo/ricercaIdVocePreventivoPaziente.sql";	
	public static $queryVociPreventivoDentiSingoliPaziente = "/preventivo/ricercaVociPreventivoDentiSingoliPaziente.sql";

	public static $queryVociSottoPreventivoGruppiPaziente = "/preventivo/ricercaVociSottoPreventivoGruppiPaziente.sql";
	public static $queryVociPreventivoGruppiPaziente = "/preventivo/ricercaVociPreventivoGruppiPaziente.sql";

	public static $queryComboPreventivoPrincipaleGruppiPaziente = "/preventivo/ricercaComboPreventivoPrincipaleGruppiPaziente.sql";
	public static $queryComboPreventivoSecondarioGruppiPaziente = "/preventivo/ricercaComboPreventivoSecondarioGruppiPaziente.sql";

	public static $queryVocePreventivoPrincipalePaziente = "/preventivo/ricercaVocePreventivoPrincipalePaziente.sql";
	public static $queryVocePreventivoSecondarioPaziente = "/preventivo/ricercaVocePreventivoSecondarioPaziente.sql";
		
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

	public static $queryRicercaTipiVociPreventivoPrincipalePaziente = "/preventivo/ricercaTipiVociPreventivoPrincipalePaziente.sql";
	public static $queryRicercaTipiVociPreventivoSecondarioPaziente = "/preventivo/ricercaTipiVociPreventivoSecondarioPaziente.sql";

	public static $queryRiepilogoVociPreventivoPrincipalePaziente = "/preventivo/riepilogoVociPreventivoPrincipalePaziente.sql";
	public static $queryRiepilogoVociPreventivoSecondarioPaziente = "/preventivo/riepilogoVociPreventivoSecondarioPaziente.sql";
	public static $queryRiepilogoVociGruppiPreventivoPrincipalePaziente = "/preventivo/riepilogoVociGruppiPreventivoPrincipalePaziente.sql";
	public static $queryRiepilogoVociGruppiPreventivoSecondarioPaziente = "/preventivo/riepilogoVociGruppiPreventivoSecondarioPaziente.sql";
	
	public static $queryCancellaPreventivoPrincipale = "/preventivo/cancellaPreventivoPrincipale.sql";
	public static $queryCancellaPreventivoSecondario = "/preventivo/cancellaPreventivoSecondario.sql";
	
	// Costruttore -----------------------------------------------------------------------------
	
	function __construct() {
		self::$root = $_SERVER['DOCUMENT_ROOT'];
	}

	// Setters -----------------------------------------------------------------------------

	public function setAzioneDentiSingoli($azioneDentiSingoli) {
		self::$azioneDentiSingoli = $azioneDentiSingoli;
	}
	public function setAzioneGruppi($azioneGruppi) {
		self::$azioneGruppi = $azioneGruppi;
	}
	public function setAzioneCure($azioneCure) {
		self::$azioneCure = $azioneCure;
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
	
	public function setMessaggio($messaggio) {
		self::$messaggio = $messaggio;
	}
	public function setNumeroPreventiviTrovati($numEle) {
		self::$numeroPreventiviTrovati = $numEle;
	}
	public function setPreventiviTrovati($preventiviTrovati) {
		self::$preventiviTrovati = $preventiviTrovati;
	}
	public function setIdPaziente($idPaziente) {
		self::$idPaziente = $idPaziente;
	}
	public function setIdListino($idListino) {
		self::$idListino = $idListino;
	}
	public function setIdPreventivo($idPreventivo) {
		self::$idPreventivo = $idPreventivo;
	}
	public function setIdPreventivoPrincipale($idPreventivoPrincipale) {
		self::$idPreventivoPrincipale = $idPreventivoPrincipale;
	}
	public function setIdSottoPreventivo($idSottoPreventivo) {
		self::$idSottoPreventivo = $idSottoPreventivo;
	}
	public function setIdVocePreventivo($idVocePreventivo) {
		self::$idVocePreventivo = $idVocePreventivo;
	}
	public function setIdVoceSottoPreventivo($idVoceSottoPreventivo) {
		self::$idVoceSottoPreventivo = $idVoceSottoPreventivo;
	}
	public function setCognomeRicerca($cognomeRicerca) {
		self::$cognomeRicerca = $cognomeRicerca;
	}
	public function setCognome($cognome) {
		self::$cognome = $cognome;
	}
	public function setNome($nome) {
		self::$nome = $nome;
	}
	public function setDataNascita($dataNascita) {
		self::$dataNascita = $dataNascita;
	}
	public function setDataInserimento($dataInserimento) {
		self::$dataInserimento = $dataInserimento;
	}
	public function setStato($stato) {
		self::$stato = $stato;
	}
	public function setPrezzo($prezzo) {
		self::$prezzo = $prezzo;
	}
	public function setNomeForm($nomeForm) {
		self::$nomeForm = $nomeForm;
	}
	public function setNomeCampoForm($nomeCampoForm) {
		self::$nomeCampoForm = $nomeCampoForm;
	}
	public function setCodiceVoceListino($codiceVoceListino) {
		self::$codiceVoceListino = $codiceVoceListino;
	}
	public function setTotalePreventivoPrincipale($totalePreventivoPrincipale) {
		self::$totalePreventivoPrincipale = $totalePreventivoPrincipale;
	}
	public function setTotalePreventivoSecondario($totalePreventivoSecondario) {
		self::$totalePreventivoSecondario = $totalePreventivoSecondario;
	}
	public function setTotalePreventivo($totalePreventivo) {
		self::$totalePreventivo = $totalePreventivo;
	}
	public function setIntestazioneColonnaAzioni($intestazioneColonnaAzioni) {
		self::$intestazioneColonnaAzioni = $intestazioneColonnaAzioni;
	}
	
	
	public function setDentiSingoli($dentiSingoli) {
		self::$dentiSingoli = $dentiSingoli;
	}
	public function setImpostazioniVoci($impostazioniVoci) {
		self::$impostazioniVoci = $impostazioniVoci;
	}

	public function setDentiGruppo_1($dentiGruppo_1) {
		self::$dentiGruppo_1 = $dentiGruppo_1;
	}
	public function setDentiGruppo_2($dentiGruppo_2) {
		self::$dentiGruppo_2 = $dentiGruppo_2;
	}
	public function setDentiGruppo_3($dentiGruppo_3) {
		self::$dentiGruppo_3 = $dentiGruppo_3;
	}
	public function setDentiGruppo_4($dentiGruppo_4) {
		self::$dentiGruppo_4 = $dentiGruppo_4;
	}
	public function setVoceGruppo_1($voceGruppo_1) {
		self::$voceGruppo_1 = $voceGruppo_1;
	}
	public function setVoceGruppo_2($voceGruppo_2) {
		self::$voceGruppo_2 = $voceGruppo_2;
	}
	public function setVoceGruppo_3($voceGruppo_3) {
		self::$voceGruppo_3 = $voceGruppo_3;
	}
	public function setVoceGruppo_4($voceGruppo_4) {
		self::$voceGruppo_4 = $voceGruppo_4;
	}
	
	public function setCureGeneriche($cureGeneriche) {
		self::$cureGeneriche = $cureGeneriche;
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
	
	public function getMessaggio() {
		return self::$messaggio;
	}
	public function getNumeroPreventiviTrovati() {
		return self::$numeroPreventiviTrovati;
	}
	public function getPreventiviTrovati() {
		return self::$preventiviTrovati;
	}
	public function getIdPaziente() {
		return self::$idPaziente;
	}
	public function getIdListino() {
		return self::$idListino;
	}
	public function getIdPreventivo() {
		return self::$idPreventivo;
	}
	public function getIdVocePreventivo() {
		return self::$idVocePreventivo;
	}
	public function getIdVoceSottoPreventivo() {
		return self::$idVoceSottoPreventivo;
	}
	public function getIdPreventivoPrincipale() {
		return self::$idPreventivoPrincipale;
	}
	public function getIdSottoPreventivo() {
		return self::$idSottoPreventivo;
	}
	public function getCognomeRicerca() {
		return self::$cognomeRicerca;
	}
	public function getCognome() {
		return self::$cognome;
	}
	public function getNome() {
		return self::$nome;
	}
	public function getDataNascita() {
		return self::$dataNascita;
	}
	public function getDataInserimento() {
		return self::$dataInserimento;
	}
	public function getStato() {
		return self::$stato;
	}
	public function getPrezzo() {
		return self::$prezzo;
	}
	public function getNomeForm() {
		return self::$nomeForm;
	}
	public function getNomeCampoForm() {
		return self::$nomeCampoForm;
	}
	public function getCodiceVoceListino() {
		return self::$codiceVoceListino;
	}
	public function getTotalePreventivoPrincipale() {
		return self::$totalePreventivoPrincipale;
	}
	public function getTotalePreventivoSecondario() {
		return self::$totalePreventivoSecondario;
	}
	public function getTotalePreventivo() {
		return self::$totalePreventivo;
	}
	public function getIntestazioneColonnaAzioni() {
		return self::$intestazioneColonnaAzioni;
	}
	
	
	public function getDentiSingoli() {
		return self::$dentiSingoli;
	}
	public function getImpostazioniVoci() {
		return self::$impostazioniVoci;
	}

	
	public function getDentiGruppo_1() {
		return self::$dentiGruppo_1;
	}
	public function getDentiGruppo_2() {
		return self::$dentiGruppo_2;
	}
	public function getDentiGruppo_3() {
		return self::$dentiGruppo_3;
	}
	public function getDentiGruppo_4() {
		return self::$dentiGruppo_4;
	}
	public function getVoceGruppo_1() {
		return self::$voceGruppo_1;
	}
	public function getVoceGruppo_2() {
		return self::$voceGruppo_2;
	}
	public function getVoceGruppo_3() {
		return self::$voceGruppo_3;
	}
	public function getVoceGruppo_4() {
		return self::$voceGruppo_4;
	}
	
	public function getCureGeneriche() {
		return self::$cureGeneriche;
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
	
	/**
	 * 
	 * @param unknown $db
	 * @return il result ottenuto dalla creazione del preventivo
	 */	
	public function creaPreventivo($db) {
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$replace = array('%idpaziente%' => $this->getIdPaziente());
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryCreaPreventivo;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return $result;
	}

	/**
	 *
	 * @param unknown $db
	 * @return il result ottenuto dalla creazione del sottopreventivo
	 */
	public function creaSottoPreventivo($db) {
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$replace = array('%idpreventivo%' => $this->getIdpreventivo());
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryCreaSottoPreventivo;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return $result;
	}
	
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
	
		$vociInserite = pg_fetch_all($result);
	
		if (!$vociInserite) {
			return "";
		}
		else {
			foreach ($vociInserite as $voce) {
				return $voce['codicevocelistino'];
			}
		}
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
	
		$vociInserite = pg_fetch_all($result);
	
		if (!$vociInserite) {
			return "";
		}
		else {
			foreach ($vociInserite as $voce) {
				return $voce['codicevocelistino'];
			}
		}
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
				'%prezzo%' => $this->prelevaPrezzoVoceListino($db, $this->getIdlistino(), $codiceVoceListino)
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryCreaVocePreventivo;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		/**
		 * Se la creazione della voce è andata bene incremento il contatore di uso della voce sul listino
		*/
	
		if ($result) {
			$this->aggiornaUsoVoceListino($db, $this->getIdlistino(), trim($codiceVoceListino), '+');
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
				'%prezzo%' => $this->prelevaPrezzoVoceListino($db, $this->getIdlistino(), $codiceVoceListino)
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryCreaVoceSottoPreventivo;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		/**
		 * Se la creazione della voce è andata bene incremento il contatore di uso della voce sul listino
		*/
	
		if ($result) {
			$this->aggiornaUsoVoceListino($db, $this->getIdlistino(), trim($codiceVoceListino), '+');
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
			$this->aggiornaUsoVoceListino($db, $this->getIdlistino(), trim($codiceVoceListino), '-');
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
			$this->aggiornaUsoVoceListino($db, $this->getIdlistino(), trim($codiceVoceListino), '-');
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
	 * @param unknown $db
	 * @param unknown $dettaglioPreventivoTemplate
	 */
	public function prelevaVociPreventivoPrincipale($db, $dettaglioPreventivoTemplate) {
	
		//-- Prelevo i tipi voci caricati -----------------------------------------------------------
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$replace = array(
				'%idpaziente%' => $this->getIdPaziente(),
				'%idpreventivo%' => $this->getIdPreventivo()
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryRicercaTipiVociPreventivoPrincipalePaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
	
		$tipiVoci = pg_fetch_all($result);
	
		if ($tipiVoci) {
			foreach ($tipiVoci as $row) {
				if (trim($row['tipovoce']) == 'singoli') $this->prelevaVociDentiSingoli($db, $this->getIdPreventivo(), self::$queryRiepilogoVociPreventivoPrincipalePaziente, $utility, $array, $dettaglioPreventivoTemplate);
				if (trim($row['tipovoce']) == 'gruppi') $this->prelevaVociGruppi($db, $this->getIdPreventivo(), self::$queryRiepilogoVociGruppiPreventivoPrincipalePaziente, $utility, $array, $dettaglioPreventivoTemplate);
				if (trim($row['tipovoce']) == 'cure') $this->prelevaVociCure($db, $this->getIdPreventivo(), self::$queryRiepilogoVociPreventivoPrincipalePaziente, $utility, $array, $dettaglioPreventivoTemplate);
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
				'%idpaziente%' => $this->getIdPaziente(),
				'%idpreventivo%' => $this->getIdPreventivoPrincipale(),
				'%idsottopreventivo%' => $this->getIdSottoPreventivo()
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryRicercaTipiVociPreventivoSecondarioPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
	
		$tipiVoci = pg_fetch_all($result);
	
		if ($tipiVoci) {
			foreach ($tipiVoci as $row) {
				if (trim($row['tipovoce']) == 'singoli') $this->prelevaVociDentiSingoli($db, $this->getIdPreventivoPrincipale(), self::$queryRiepilogoVociPreventivoSecondarioPaziente, $utility, $array, $dettaglioPreventivoTemplate);
				if (trim($row['tipovoce']) == 'gruppi') $this->prelevaVociGruppi($db, $this->getIdPreventivoPrincipale(), self::$queryRiepilogoVociGruppiPreventivoSecondarioPaziente, $utility, $array, $dettaglioPreventivoTemplate);
				if (trim($row['tipovoce']) == 'cure') $this->prelevaVociCure($db, $this->getIdPreventivoPrincipale(), self::$queryRiepilogoVociPreventivoSecondarioPaziente, $utility, $array, $dettaglioPreventivoTemplate);
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
				'%idpaziente%' => $this->getIdPaziente(),
				'%idpreventivo%' => $idPreventivo,
				'%idsottopreventivo%' => $this->getIdSottoPreventivo(),
				'%nomeform%' => 'singoli'
		);
	
		$sqlTemplate = self::$root . $array['query'] . $query;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
	
		$dettaglioPreventivoTemplate->setVociPreventivoDentiSingoli(pg_fetch_all($result));
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
				'%idpaziente%' => $this->getIdPaziente(),
				'%idpreventivo%' => $idPreventivo,
				'%idsottopreventivo%' => $this->getIdSottoPreventivo(),
				'%nomeform%' => 'gruppi'
		);
	
		$sqlTemplate = self::$root . $array['query'] . $query;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
	
		$dettaglioPreventivoTemplate->setVociPreventivoGruppi(pg_fetch_all($result));
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
				'%idpaziente%' => $this->getIdPaziente(),
				'%idpreventivo%' => $idPreventivo,
				'%idsottopreventivo%' => $this->getIdSottoPreventivo(),
				'%nomeform%' => 'cure'
		);
	
		$sqlTemplate = self::$root . $array['query'] . $query;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
	
		$dettaglioPreventivoTemplate->setVociPreventivoCure(pg_fetch_all($result));
	}	
}

?>

