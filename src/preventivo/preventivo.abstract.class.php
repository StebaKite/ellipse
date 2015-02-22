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
	public static $nomeForm;
	public static $nomeCampoForm;
	public static $codiceVoceListino;
	public static $totalePreventivoPrincipale;
	public static $totalePreventivoSecondario;
	public static $totalePreventivo;
	public static $totalePreventivoDentiSingoli;
	public static $totalePreventivoGruppi;
	public static $totalePreventivoCure;
	public static $intestazioneColonnaAzioni;

	public static $totaleDaPagareFuoriPiano;
	public static $totaleDaPagareInPiano;
	public static $totalePagatoInPiano;
	
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
	
	public static $scontopercentuale;
	public static $scontocontante;
	public static $accontoiniziocura;
	public static $accontometacura;
	public static $saldofinecura;
	
	public static $ratePagamento;
	public static $importodarateizzare;
	public static $importodarateizzareStyle;
	public static $importodarateizzareTip;
	public static $numerogiornirata;
	public static $numerogiornirataStyle;
	public static $numerogiornirataTip;
	public static $importorata;
	public static $importorataStyle;
	public static $importorataTip;
	public static $dataprimarata;
	public static $dataprimarataStyle;
	public static $dataprimarataTip;

	public static $acconti;	
	public static $idAcconto;
	public static $dataScadenzaAcconto;
	public static $dataScadenzaAccontoStyle;
	public static $dataScadenzaAccontoTip;
	public static $descrizioneAcconto;
	public static $descrizioneAccontoStyle;
	public static $descrizioneAccontoTip;
	public static $importoAcconto;
	public static $importoAccontoStyle;
	public static $importoAccontoTip;

	public static $codiceVoce;
	public static $descrizioneVoce;
	public static $descrizioneVoceStyle;
	public static $descrizioneVoceTip;
	public static $descrizioneVoceListino;
	public static $prezzo;
	public static $prezzoStyle;
	public static $prezzoTip;

	public static $tabella;
	public static $dente;
	
	// Query -----------------------------------------------------------------------------
	
	public static $queryVociListinoPaziente = "/preventivo/ricercaVociListinoPaziente.sql";

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
	
	// Costruttore -----------------------------------------------------------------------------
	
	function __construct() {
		self::$root = $_SERVER['DOCUMENT_ROOT'];
	}

	// Setters ---------------------------------------------------------------------------------

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
	public function setTotalePreventivoDentiSingoli($totalePreventivoDentiSingoli) {
		self::$totalePreventivoDentiSingoli = $totalePreventivoDentiSingoli;
	}
	public function setTotalePreventivoGruppi($totalePreventivoGruppi) {
		self::$totalePreventivoGruppi = $totalePreventivoGruppi;
	}
	public function setTotalePreventivoCure($totalePreventivoCure) {
		self::$totalePreventivoCure = $totalePreventivoCure;
	}
	
	public function setTotaleDaPagareFuoriPiano($totaleDaPagareFuoriPiano) {
		self::$totaleDaPagareFuoriPiano = $totaleDaPagareFuoriPiano;
	}
	public function setTotaleDaPagareInPiano($totaleDaPagareInPiano) {
		self::$totaleDaPagareInPiano = $totaleDaPagareInPiano;
	}
	public function setTotalePagatoInPiano($totalePagatoInPiano) {
		self::$totalePagatoInPiano = $totalePagatoInPiano;
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

	public function setScontoPercentuale($scontoPercentuale) {
		self::$scontopercentuale = $scontoPercentuale;
	}
	public function setScontoContante($scontoContante) {
		self::$scontocontante = $scontoContante;
	}
	public function setAccontoInizioCura($accontoInizioCura) {
		self::$accontoiniziocura = $accontoInizioCura;
	}
	public function setAccontoMetaCura($accontoMetaCura) {
		self::$accontometacura = $accontoMetaCura;
	}
	public function setSaldoFineCura($saldoFineCura) {
		self::$saldofinecura = $saldoFineCura;
	}
	
	public function setImportoDaRateizzare($importoDaRateizzare) {
		self::$importodarateizzare = $importoDaRateizzare;
	}
	public function setStyleImportoDaRateizzare($style) {
		self::$importodarateizzareStyle = $style;
	}
	public function setTipImportoDaRateizzare($tip) {
		self::$importodarateizzareTip = $tip;
	}
	
	public function setNumeroGiorniRata($numeroGiorniRata) {
		self::$numerogiornirata = $numeroGiorniRata;
	}
	public function setStyleNumeroGiorniRata($style) {
		self::$numerogiornirataStyle = $style;
	}
	public function setTipNumeroGiorniRata($tip) {
		self::$numerogiornirataTip = $tip;
	}
	
	public function setImportoRata($importoRata) {
		self::$importorata = $importoRata;
	}
	public function setStyleImportoRata($style) {
		self::$importorataStyle = $style;
	}
	public function setTipImportoRata($tip) {
		self::$importorataTip = $tip;
	}
	
	public function setDataPrimaRata($dataPrimaRata) {
		self::$dataprimarata = $dataPrimaRata;
	}
	public function setStyleDataPrimaRata($style) {
		self::$dataprimarataStyle = $style;
	}
	public function setTipDataPrimaRata($tip) {
		self::$dataprimarataTip = $tip;
	}

	public function setAcconti($acconti) {
		self::$acconti = $acconti;
	}
	public function setIdAcconto($idacconti) {
		self::$idAcconto = $idacconti;
	}
	public function setRatePagamento($ratePagamento) {
		self::$ratePagamento = $ratePagamento;
	}
	public function setdataScadenzaAcconto($dataScadenzaAcconto) {
		self::$dataScadenzaAcconto = $dataScadenzaAcconto;
	}
	public function setStyledataScadenzaAcconto($style) {
		self::$dataScadenzaAccontoStyle = $style;
	}
	public function setTipdataScadenzaAcconto($tip) {
		self::$dataScadenzaAccontoTip = $tip;
	}
	public function setdescrizioneAcconto($descrizioneAcconto) {
		self::$descrizioneAcconto = $descrizioneAcconto;
	}
	public function setStyledescrizioneAcconto($style) {
		self::$descrizioneAccontoStyle = $style;
	}
	public function setTipdescrizioneAcconto($tip) {
		self::$descrizioneAccontoTip = $tip;
	}
	public function setimportoAcconto($importoAcconto) {
		self::$importoAcconto = $importoAcconto;
	}
	public function setStyleimportoAcconto($style) {
		self::$importoAccontoStyle = $style;
	}
	public function setTipimportoAcconto($tip) {
		self::$importoAccontoTip = $tip;
	}

	public function setCodiceVoce($codiceVoce) {
		self::$codiceVoce = $codiceVoce;
	}
	
	public function setDescrizioneVoce($descrizioneVoce) {
		self::$descrizioneVoce = $descrizioneVoce;
	}
	public function setDescrizioneVoceListino($descrizioneVoceListino) {
		self::$descrizioneVoceListino = $descrizioneVoceListino;
	}
	public function setStyleDescrizioneVoce($style) {
		self::$descrizioneVoceStyle = $style;
	}
	public function setTipDescrizioneVoce($tip) {
		self::$descrizioneVoceTip = $tip;
	}
	
	public function setStylePrezzo($style) {
		self::$prezzoStyle = $style;
	}
	public function setTipPrezzo($tip) {
		self::$prezzoTip = $tip;
	}
	public function setPrezzo($prezzo) {
		self::$prezzo = $prezzo;
	}

	public function setTabella($tabella) {
		self::$tabella = $tabella;
	}
	public function setDente($dente) {
		self::$dente = $dente;
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
	public function getTotalePreventivoDentiSingoli() {
		return self::$totalePreventivoDentiSingoli;
	}
	public function getTotalePreventivoGruppi() {
		return self::$totalePreventivoGruppi;
	}
	public function getTotalePreventivoCure() {
		return self::$totalePreventivoCure;
	}
	
	public function getTotaleDaPagareInPiano() {
		return self::$totaleDaPagareInPiano;
	}
	public function getTotaleDaPagareFuoriPiano() {
		return self::$totaleDaPagareFuoriPiano;
	}
	public function getTotalePagatoInPiano() {
		return self::$totalePagatoInPiano;
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

	public function getScontoPercentuale() {
		return self::$scontopercentuale;
	}
	public function getScontoContante() {
		return self::$scontocontante;
	}
	public function getAccontoInizioCura() {
		return self::$accontoiniziocura;
	}
	public function getAccontoMetaCura() {
		return self::$accontometacura;
	}
	public function getSaldoFineCura() {
		return self::$saldofinecura;
	}

	public function getRatePagamento() {
		return self::$ratePagamento;
	}
	public function getImportoDaRateizzare() {
		return self::$importodarateizzare;
	}
	public function getStyleImportoDaRateizzare() {
		return self::$importodarateizzareStyle;
	}
	public function getTipImportoDaRateizzare() {
		return self::$importodarateizzareTip;
	}
	
	public function getNumeroGiorniRata() {
		return self::$numerogiornirata;
	}
	public function getStyleNumeroGiorniRata() {
		return self::$numerogiornirataStyle;
	}
	public function getTipNumeroGiorniRata() {
		return self::$numerogiornirataTip;
	}
	
	public function getImportoRata() {
		return self::$importorata;
	}
	public function getStyleImportoRata() {
		return self::$importorataStyle;
	}
	public function getTipImportoRata() {
		return self::$importorataTip;
	}
	
	public function getDataPrimaRata() {
		return self::$dataprimarata;
	}
	public function getStyleDataPrimaRata() {
		return self::$dataprimarataStyle;
	}
	public function getTipDataPrimaRata() {
		return self::$dataprimarataTip;
	}
	
	public function getAcconti() {
		return self::$acconti;
	}	
	public function getIdAcconto() {
		return self::$idAcconto;
	}	
	public function getdataScadenzaAcconto() {
		return self::$dataScadenzaAcconto;
	}
	public function getStyledataScadenzaAcconto() {
		return self::$dataScadenzaAccontoStyle;
	}
	public function getTipdataScadenzaAcconto() {
		return self::$dataScadenzaAccontoTip;
	}
	
	public function getdescrizioneAcconto() {
		return self::$descrizioneAcconto;
	}
	public function getStyledescrizioneAcconto() {
		return self::$descrizioneAccontoStyle;
	}
	public function getTipdescrizioneAcconto() {
		return self::$descrizioneAccontoTip;
	}
	
	public function getimportoAcconto() {
		return self::$importoAcconto;
	}
	public function getStyleimportoAcconto() {
		return self::$importoAccontoStyle;
	}
	public function getTipimportoAcconto() {
		return self::$importoAccontoTip;
	}

	public function getCodiceVoce() {
		return self::$codiceVoce;
	}
	
	public function getDescrizioneVoceListino() {
		return self::$descrizioneVoceListino;
	}
	public function getDescrizioneVoce() {
		return self::$descrizioneVoce;
	}
	public function getStyleDescrizioneVoce() {
		return self::$descrizioneVoceStyle;
	}
	public function getTipDescrizioneVoce() {
		return self::$descrizioneVoceTip;
	}

	public function getPrezzo() {
		return self::$prezzo;
	}
	public function getStylePrezzo() {
		return self::$prezzoStyle;
	}
	public function getTipPrezzo() {
		return self::$prezzoTip;
	}
	
	public function getTabella() {
		return self::$tabella;
	}
	public function getDente() {
		return self::$dente;
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
		
		$this->setScontoPercentuale($_POST['scontopercentuale']);
		$this->setScontoContante($_POST['scontocontante']);

		$this->setDataScadenzaAcconto($_POST['datascadenzaacconto']);
		$this->setDescrizioneAcconto($_POST['descrizioneacconto']);
		$this->setImportoAcconto($_POST['importoacconto']);
		
// 		$this->setAccontoInizioCura($_POST['accontoiniziocura']);
// 		$this->setAccontoMetaCura($_POST['accontometacura']);
// 		$this->setSaldoFineCura($_POST['saldofinecura']);
		
		$this->setImportoDaRateizzare($_POST['importodarateizzare']);
		$this->setDataPrimaRata($_POST['dataprimarata']);		
		$this->setNumeroGiorniRata($_POST['numerogiornirata']);
		$this->setImportoRata($_POST['importorata']);
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
		$result = $db->getData($sql);
	
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
			$this->setScontoPercentuale($row['scontopercentuale']);
			$this->setScontoContante($row['scontocontante']);
			$this->setImportoDaRateizzare($row['importodarateizzare']);
			$this->setNumeroGiorniRata($row['numerogiornirata']);
			$this->setImportoRata($row['importorata']);
			$this->setDataPrimaRata($row['dataprimarata']);
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
			$this->setScontoPercentuale($row['scontopercentuale']);
			$this->setScontoContante($row['scontocontante']);
			$this->setImportoDaRateizzare($row['importodarateizzare']);
			$this->setNumeroGiorniRata($row['numerogiornirata']);
			$this->setImportoRata($row['importorata']);
			$this->setDataPrimaRata($row['dataprimarata']);
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
	
}

?>

