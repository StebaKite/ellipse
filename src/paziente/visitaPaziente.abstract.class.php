<?php

require_once 'paziente.abstract.class.php';

abstract class visitaPazienteAbstract extends pazienteAbstract {

	public static $azioneDentiSingoli;
	public static $azioneGruppi;
	public static $azioneCure;

	public static $testata;
	public static $piede;
	public static $messaggioErrore;
	public static $messaggioInfo;
	
	public static $cognomeRicerca;
	public static $idPaziente;
	public static $idListino;
	public static $idVisita;
	
	public static $confermaTip;
	public static $singoliTip;
	public static $gruppiTip;
	public static $cureTip;

	public static $titoloPagina;
	public static $visitaLabel;

	public static $cognome;
	public static $nome;
	public static $dataNascita;
	public static $dataInserimento;
	public static $stato;

	public static $visita;
	public static $visitaGruppi;
	public static $visitaCure;
	public static $esitoControlliLogici;
	public static $cureGeneriche;

	private static $voceGruppo_1;
	private static $dentiGruppo_1;	
	private static $voceGruppo_2;
	private static $dentiGruppo_2;
	private static $voceGruppo_3;
	private static $dentiGruppo_3;
	private static $voceGruppo_4;
	private static $dentiGruppo_4;

	public static $queryCreaVisita = "/paziente/creaVisita.sql";
	public static $queryAggiornaVisita = "/paziente/aggiornaVisita.sql";
	public static $queryCreaVoceVisita = "/paziente/creaVoceVisita.sql";
	public static $queryAggiornaVoceVisita = "/paziente/aggiornaVoceVisita.sql";
	public static $queryCancellaVoceVisita = "/paziente/cancellaVoceVisita.sql";

	public static $queryVociListinoPaziente = "/paziente/ricercaVociListinoPaziente.sql";
	public static $queryVociGenericheListinoPaziente = "/paziente/ricercaVociGenericheListinoPaziente.sql";
	public static $queryRiepilogoVociVisitaPaziente = "/paziente/riepilogoVociVisitaPaziente.sql";
	public static $queryRiepilogoTipiVociVisitaPaziente = "/paziente/riepilogoTipiVociVisitaPaziente.sql";
	public static $queryRiepilogoVociVisitaGruppiPaziente = "/paziente/riepilogoVociVisitaGruppiPaziente.sql";
	
	public static $queryVociVisitaDentiSingoliPaziente = "/paziente/ricercaVociVisitaDentiSingoliPaziente.sql";
	public static $queryVoceVisitaPaziente = "/paziente/ricercaVoceVisitaPaziente.sql";
	public static $queryVoceCuraVisitaPaziente = "/paziente/ricercaVoceCuraVisitaPaziente.sql";
	
	public static $queryVociVisitaGruppiPaziente = "/paziente/ricercaVociVisitaGruppiPaziente.sql";
	public static $queryVociVisitaCurePaziente = "/paziente/ricercaVociVisitaCurePaziente.sql";

	// ------------------------------------------------

	public function setAzioneDentiSingoli($azioneDentiSingoli) {
		self::$azioneDentiSingoli = $azioneDentiSingoli;
	}
	public function setAzioneGruppi($azioneGruppi) {
		self::$azioneGruppi = $azioneGruppi;
	}
	public function setAzioneCure($azioneCure) {
		self::$azioneCure = $azioneCure;
	}

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
	public function setVisitaGruppi($visitaGruppi) {
		self::$visitaGruppi = $visitaGruppi;
	}
	public function setEsitoControlloLogici($esito) {
		self::$esitoControlliLogici = $esito;
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
	
	public function setTitoloPagina($titoloPagina) {
		self::$titoloPagina = $titoloPagina;
	}
	public function setVisitaLabel($visitaLabel) {
		self::$visitaLabel = $visitaLabel;
	}
	public function setCureGeneriche($cureGeneriche) {
		self::$cureGeneriche = $cureGeneriche;
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
	
	// ------------------------------------------------

	public function getAzioneDentiSingoli() {
		return self::$azioneDentiSingoli;
	}
	public function getAzioneGruppi() {
		return self::$azioneGruppi;
	}
	public function getAzioneCure() {
		return self::$azioneCure;
	}
	
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
	public function getVisitaGruppi() {
		return self::$visitaGruppi;
	}
	public function getEsitoControlliLogici() {
		return self::$esitoControlliLogici;
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
	public function getVisitaLabel() {
		return self::$visitaLabel;
	}
	public function getCureGeneriche() {
		return self::$cureGeneriche;
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

	// ------------------------------------------------

	public function controlliLogici() { }
		
	public function leggiVoceVisita($db, $idvisita, $nomeCampo, $nomeForm) {

		require_once 'database.class.php';
		require_once 'utility.class.php';

		$utility = new utility();
		$array = $utility->getConfig();

		$replace = array(
			'%idvisita%' => $idvisita,
			'%nomeform%' => $nomeForm,
			'%idnomecampo%' => $nomeCampo
		);
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryVoceVisitaPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
		
		$vociInserite = pg_fetch_all($result);

		if (!$vociInserite) {
			return "";
		}
		else {
			foreach ($vociInserite as $voce) {
				return $voce['idvocevisita'];
			}		
		}
	}	
		
	public function leggiVoceCuraVisita($db, $idvisita, $nomeCampo, $nomeForm) {

		require_once 'database.class.php';
		require_once 'utility.class.php';

		$utility = new utility();
		$array = $utility->getConfig();

		$replace = array(
			'%idvisita%' => $idvisita,
			'%nomeform%' => $nomeForm,
			'%idnomecampo%' => $nomeCampo
		);
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryVoceVisitaPaziente;
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
	
	public function creaVisita($db) {
		
		$utility = new utility();
		$array = $utility->getConfig();

		$replace = array('%idpaziente%' => $this->getIdPaziente());
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryCreaVisita;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);

		return $result;
	}
	
	public function aggiornaVisita($db, $idVisitaUsato) {
		
		$utility = new utility();
		$array = $utility->getConfig();
			
		$replace = array(
			'%idvisita%' => $idVisitaUsato
		);
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryAggiornaVisita;
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
		
	public function aggiornaVoceVisita($db, $idvocevisita, $codiceVoceListino) {
		
		$utility = new utility();
		$array = $utility->getConfig();
			
		$replace = array(
			'%codicevocelistino%' => trim($codiceVoceListino),
			'%idvocevisita%' => $idvocevisita
		);
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryAggiornaVoceVisita;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);

		return $result;	
	}
	
	public function cancellaVoceVisita($db, $idvocevisita) {
		
		$utility = new utility();
		$array = $utility->getConfig();
			
		$replace = array(
			'%idvocevisita%' => $idvocevisita
		);
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryCancellaVoceVisita;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);

		return $result;		
	}

	public function inizializzaPagina() {

		$dentiSingoli = array();

		// arcata superiore destra (SD) ---------------------------------------------------------------------------------------------------------
		
		array_push($dentiSingoli, array('SD_18_1', ''), array('SD_17_1', ''), array('SD_16_1', ''));
		array_push($dentiSingoli, array('SD_15_1', ''), array('SD_14_1', ''), array('SD_13_1', ''));
		array_push($dentiSingoli, array('SD_12_1', ''), array('SD_11_1', ''));

		array_push($dentiSingoli, array('SD_18_2', ''), array('SD_17_2', ''), array('SD_16_2', ''));
		array_push($dentiSingoli, array('SD_15_2', ''), array('SD_14_2', ''), array('SD_13_2', ''));
		array_push($dentiSingoli, array('SD_12_2', ''), array('SD_11_2', ''));

		array_push($dentiSingoli, array('SD_18_3', ''), array('SD_17_3', ''), array('SD_16_3', ''));
		array_push($dentiSingoli, array('SD_15_3', ''), array('SD_14_3', ''), array('SD_13_3', ''));
		array_push($dentiSingoli, array('SD_12_3', ''), array('SD_11_3', ''));

		array_push($dentiSingoli, array('SD_18_4', ''), array('SD_17_4', ''), array('SD_16_4', ''));
		array_push($dentiSingoli, array('SD_15_4', ''), array('SD_14_4', ''), array('SD_13_4', ''));
		array_push($dentiSingoli, array('SD_12_4', ''), array('SD_11_4', ''));

		array_push($dentiSingoli, array('SD_18_5', ''), array('SD_17_5', ''), array('SD_16_5', ''));
		array_push($dentiSingoli, array('SD_15_5', ''), array('SD_14_5', ''), array('SD_13_5', ''));
		array_push($dentiSingoli, array('SD_12_5', ''), array('SD_11_5', ''));

		// arcata superiore sinistra (SS) -------------------------------------------------------------------------------------------------------
		
		array_push($dentiSingoli, array('SS_21_1', ''), array('SS_22_1', ''), array('SS_23_1', ''));
		array_push($dentiSingoli, array('SS_24_1', ''), array('SS_25_1', ''), array('SS_26_1', ''));
		array_push($dentiSingoli, array('SS_27_1', ''), array('SS_28_1', ''));
		
		array_push($dentiSingoli, array('SS_21_2', ''), array('SS_22_2', ''), array('SS_23_2', ''));
		array_push($dentiSingoli, array('SS_24_2', ''), array('SS_25_2', ''), array('SS_26_2', ''));
		array_push($dentiSingoli, array('SS_27_2', ''), array('SS_28_2', ''));
		
		array_push($dentiSingoli, array('SS_21_3', ''), array('SS_22_3', ''), array('SS_23_3', ''));
		array_push($dentiSingoli, array('SS_24_3', ''), array('SS_25_3', ''), array('SS_26_3', ''));
		array_push($dentiSingoli, array('SS_27_3', ''), array('SS_28_3', ''));
		
		array_push($dentiSingoli, array('SS_21_4', ''), array('SS_22_4', ''), array('SS_23_4', ''));
		array_push($dentiSingoli, array('SS_24_4', ''), array('SS_25_4', ''), array('SS_26_4', ''));
		array_push($dentiSingoli, array('SS_27_4', ''), array('SS_28_4', ''));
		
		array_push($dentiSingoli, array('SS_21_5', ''), array('SS_22_5', ''), array('SS_23_5', ''));
		array_push($dentiSingoli, array('SS_24_5', ''), array('SS_25_5', ''), array('SS_26_5', ''));
		array_push($dentiSingoli, array('SS_27_5', ''), array('SS_28_5', ''));

		// arcata inferiore destra (ID) -------------------------------------------------------------------------------------------------------
		
		array_push($dentiSingoli, array('ID_48_1', ''), array('ID_47_1', ''), array('ID_46_1', ''));
		array_push($dentiSingoli, array('ID_45_1', ''), array('ID_44_1', ''), array('ID_43_1', ''));
		array_push($dentiSingoli, array('ID_42_1', ''), array('ID_41_1', ''));
		
		array_push($dentiSingoli, array('ID_48_2', ''), array('ID_47_2', ''), array('ID_46_2', ''));
		array_push($dentiSingoli, array('ID_45_2', ''), array('ID_44_2', ''), array('ID_43_2', ''));
		array_push($dentiSingoli, array('ID_42_2', ''), array('ID_41_2', ''));
		
		array_push($dentiSingoli, array('ID_48_3', ''), array('ID_47_3', ''), array('ID_46_3', ''));
		array_push($dentiSingoli, array('ID_45_3', ''), array('ID_44_3', ''), array('ID_43_3', ''));
		array_push($dentiSingoli, array('ID_42_3', ''), array('ID_41_3', ''));
		
		array_push($dentiSingoli, array('ID_48_4', ''), array('ID_47_4', ''), array('ID_46_4', ''));
		array_push($dentiSingoli, array('ID_45_4', ''), array('ID_44_4', ''), array('ID_43_4', ''));
		array_push($dentiSingoli, array('ID_42_4', ''), array('ID_41_4', ''));
		
		array_push($dentiSingoli, array('ID_48_5', ''), array('ID_47_5', ''), array('ID_46_5', ''));
		array_push($dentiSingoli, array('ID_45_5', ''), array('ID_44_5', ''), array('ID_43_5', ''));
		array_push($dentiSingoli, array('ID_42_5', ''), array('ID_41_5', ''));

		// arcata inferiore sinistra (IS) -------------------------------------------------------------------------------------------------------
		
		array_push($dentiSingoli, array('IS_31_1', ''), array('IS_32_1', ''), array('IS_33_1', ''));
		array_push($dentiSingoli, array('IS_34_1', ''), array('IS_35_1', ''), array('IS_36_1', ''));
		array_push($dentiSingoli, array('IS_37_1', ''), array('IS_38_1', ''));
		
		array_push($dentiSingoli, array('IS_31_2', ''), array('IS_32_2', ''), array('IS_33_2', ''));
		array_push($dentiSingoli, array('IS_34_2', ''), array('IS_35_2', ''), array('IS_36_2', ''));
		array_push($dentiSingoli, array('IS_37_2', ''), array('IS_38_2', ''));
		
		array_push($dentiSingoli, array('IS_31_3', ''), array('IS_32_3', ''), array('IS_33_3', ''));
		array_push($dentiSingoli, array('IS_34_3', ''), array('IS_35_3', ''), array('IS_36_3', ''));
		array_push($dentiSingoli, array('IS_37_3', ''), array('IS_38_3', ''));
		
		array_push($dentiSingoli, array('IS_31_4', ''), array('IS_32_4', ''), array('IS_33_4', ''));
		array_push($dentiSingoli, array('IS_34_4', ''), array('IS_35_4', ''), array('IS_36_4', ''));
		array_push($dentiSingoli, array('IS_37_4', ''), array('IS_38_4', ''));
		
		array_push($dentiSingoli, array('IS_31_5', ''), array('IS_32_5', ''), array('IS_33_5', ''));
		array_push($dentiSingoli, array('IS_34_5', ''), array('IS_35_5', ''), array('IS_36_5', ''));
		array_push($dentiSingoli, array('IS_37_5', ''), array('IS_38_5', ''));

		$this->setDentiSingoli($dentiSingoli);
	}
	
	public function prelevaCampiFormSingoli() {
		
		$dentiSingoli = array();

		// arcata superiore destra (SD) ---------------------------------------------------------------------------------------------------------
		
		array_push($dentiSingoli, array('SD_18_1', $_POST['SD_18_1']), array('SD_17_1', $_POST['SD_17_1']), array('SD_16_1', $_POST['SD_16_1']));
		array_push($dentiSingoli, array('SD_15_1', $_POST['SD_15_1']), array('SD_14_1', $_POST['SD_14_1']), array('SD_13_1', $_POST['SD_13_1']));
		array_push($dentiSingoli, array('SD_12_1', $_POST['SD_12_1']), array('SD_11_1', $_POST['SD_11_1']));

		array_push($dentiSingoli, array('SD_18_2', $_POST['SD_18_2']), array('SD_17_2', $_POST['SD_17_2']), array('SD_16_2', $_POST['SD_16_2']));
		array_push($dentiSingoli, array('SD_15_2', $_POST['SD_15_2']), array('SD_14_2', $_POST['SD_14_2']), array('SD_13_2', $_POST['SD_13_2']));
		array_push($dentiSingoli, array('SD_12_2', $_POST['SD_12_2']), array('SD_11_2', $_POST['SD_11_2']));

		array_push($dentiSingoli, array('SD_18_3', $_POST['SD_18_3']), array('SD_17_3', $_POST['SD_17_3']), array('SD_16_3', $_POST['SD_16_3']));
		array_push($dentiSingoli, array('SD_15_3', $_POST['SD_15_3']), array('SD_14_3', $_POST['SD_14_3']), array('SD_13_3', $_POST['SD_13_3']));
		array_push($dentiSingoli, array('SD_12_3', $_POST['SD_12_3']), array('SD_11_3', $_POST['SD_11_3']));

		array_push($dentiSingoli, array('SD_18_4', $_POST['SD_18_4']), array('SD_17_4', $_POST['SD_17_4']), array('SD_16_4', $_POST['SD_16_4']));
		array_push($dentiSingoli, array('SD_15_4', $_POST['SD_15_4']), array('SD_14_4', $_POST['SD_14_4']), array('SD_13_4', $_POST['SD_13_4']));
		array_push($dentiSingoli, array('SD_12_4', $_POST['SD_12_4']), array('SD_11_4', $_POST['SD_11_4']));

		array_push($dentiSingoli, array('SD_18_5', $_POST['SD_18_5']), array('SD_17_5', $_POST['SD_17_5']), array('SD_16_5', $_POST['SD_16_5']));
		array_push($dentiSingoli, array('SD_15_5', $_POST['SD_15_5']), array('SD_14_5', $_POST['SD_14_5']), array('SD_13_5', $_POST['SD_13_5']));
		array_push($dentiSingoli, array('SD_12_5', $_POST['SD_12_5']), array('SD_11_5', $_POST['SD_11_5']));

		// arcata superiore sinistra (SS) -------------------------------------------------------------------------------------------------------
		
		array_push($dentiSingoli, array('SS_21_1', $_POST['SS_21_1']), array('SS_22_1', $_POST['SS_22_1']), array('SS_23_1', $_POST['SS_23_1']));
		array_push($dentiSingoli, array('SS_24_1', $_POST['SS_24_1']), array('SS_25_1', $_POST['SS_25_1']), array('SS_26_1', $_POST['SS_26_1']));
		array_push($dentiSingoli, array('SS_27_1', $_POST['SS_27_1']), array('SS_28_1', $_POST['SS_28_1']));
		
		array_push($dentiSingoli, array('SS_21_2', $_POST['SS_21_2']), array('SS_22_2', $_POST['SS_22_2']), array('SS_23_2', $_POST['SS_23_2']));
		array_push($dentiSingoli, array('SS_24_2', $_POST['SS_24_2']), array('SS_25_2', $_POST['SS_25_2']), array('SS_26_2', $_POST['SS_26_2']));
		array_push($dentiSingoli, array('SS_27_2', $_POST['SS_27_2']), array('SS_28_2', $_POST['SS_28_2']));
		
		array_push($dentiSingoli, array('SS_21_3', $_POST['SS_21_3']), array('SS_22_3', $_POST['SS_22_3']), array('SS_23_3', $_POST['SS_23_3']));
		array_push($dentiSingoli, array('SS_24_3', $_POST['SS_24_3']), array('SS_25_3', $_POST['SS_25_3']), array('SS_26_3', $_POST['SS_26_3']));
		array_push($dentiSingoli, array('SS_27_3', $_POST['SS_27_3']), array('SS_28_3', $_POST['SS_28_3']));
		
		array_push($dentiSingoli, array('SS_21_4', $_POST['SS_21_4']), array('SS_22_4', $_POST['SS_22_4']), array('SS_23_4', $_POST['SS_23_4']));
		array_push($dentiSingoli, array('SS_24_4', $_POST['SS_24_4']), array('SS_25_4', $_POST['SS_25_4']), array('SS_26_4', $_POST['SS_26_4']));
		array_push($dentiSingoli, array('SS_27_4', $_POST['SS_27_4']), array('SS_28_4', $_POST['SS_28_4']));
		
		array_push($dentiSingoli, array('SS_21_5', $_POST['SS_21_5']), array('SS_22_5', $_POST['SS_22_5']), array('SS_23_5', $_POST['SS_23_5']));
		array_push($dentiSingoli, array('SS_24_5', $_POST['SS_24_5']), array('SS_25_5', $_POST['SS_25_5']), array('SS_26_5', $_POST['SS_26_5']));
		array_push($dentiSingoli, array('SS_27_5', $_POST['SS_27_5']), array('SS_28_5', $_POST['SS_28_5']));

		// arcata inferiore destra (ID) -------------------------------------------------------------------------------------------------------
		
		array_push($dentiSingoli, array('ID_48_1', $_POST['ID_48_1']), array('ID_47_1', $_POST['ID_47_1']), array('ID_46_1', $_POST['ID_46_1']));
		array_push($dentiSingoli, array('ID_45_1', $_POST['ID_45_1']), array('ID_44_1', $_POST['ID_44_1']), array('ID_43_1', $_POST['ID_43_1']));
		array_push($dentiSingoli, array('ID_42_1', $_POST['ID_42_1']), array('ID_41_1', $_POST['ID_41_1']));
		
		array_push($dentiSingoli, array('ID_48_2', $_POST['ID_48_2']), array('ID_47_2', $_POST['ID_47_2']), array('ID_46_2', $_POST['ID_46_2']));
		array_push($dentiSingoli, array('ID_45_2', $_POST['ID_45_2']), array('ID_44_2', $_POST['ID_44_2']), array('ID_43_2', $_POST['ID_43_2']));
		array_push($dentiSingoli, array('ID_42_2', $_POST['ID_42_2']), array('ID_41_2', $_POST['ID_41_2']));
		
		array_push($dentiSingoli, array('ID_48_3', $_POST['ID_48_3']), array('ID_47_3', $_POST['ID_47_3']), array('ID_46_3', $_POST['ID_46_3']));
		array_push($dentiSingoli, array('ID_45_3', $_POST['ID_45_3']), array('ID_44_3', $_POST['ID_44_3']), array('ID_43_3', $_POST['ID_43_3']));
		array_push($dentiSingoli, array('ID_42_3', $_POST['ID_42_3']), array('ID_41_3', $_POST['ID_41_3']));
		
		array_push($dentiSingoli, array('ID_48_4', $_POST['ID_48_4']), array('ID_47_4', $_POST['ID_47_4']), array('ID_46_4', $_POST['ID_46_4']));
		array_push($dentiSingoli, array('ID_45_4', $_POST['ID_45_4']), array('ID_44_4', $_POST['ID_44_4']), array('ID_43_4', $_POST['ID_43_4']));
		array_push($dentiSingoli, array('ID_42_4', $_POST['ID_42_4']), array('ID_41_4', $_POST['ID_41_4']));
		
		array_push($dentiSingoli, array('ID_48_5', $_POST['ID_48_5']), array('ID_47_5', $_POST['ID_47_5']), array('ID_46_5', $_POST['ID_46_5']));
		array_push($dentiSingoli, array('ID_45_5', $_POST['ID_45_5']), array('ID_44_5', $_POST['ID_44_5']), array('ID_43_5', $_POST['ID_43_5']));
		array_push($dentiSingoli, array('ID_42_5', $_POST['ID_42_5']), array('ID_41_5', $_POST['ID_41_5']));

		// arcata inferiore sinistra (IS) -------------------------------------------------------------------------------------------------------
		
		array_push($dentiSingoli, array('IS_31_1', $_POST['IS_31_1']), array('IS_32_1', $_POST['IS_32_1']), array('IS_33_1', $_POST['IS_33_1']));
		array_push($dentiSingoli, array('IS_34_1', $_POST['IS_34_1']), array('IS_35_1', $_POST['IS_35_1']), array('IS_36_1', $_POST['IS_36_1']));
		array_push($dentiSingoli, array('IS_37_1', $_POST['IS_37_1']), array('IS_38_1', $_POST['IS_38_1']));
		
		array_push($dentiSingoli, array('IS_31_2', $_POST['IS_31_2']), array('IS_32_2', $_POST['IS_32_2']), array('IS_33_2', $_POST['IS_33_2']));
		array_push($dentiSingoli, array('IS_34_2', $_POST['IS_34_2']), array('IS_35_2', $_POST['IS_35_2']), array('IS_36_2', $_POST['IS_36_2']));
		array_push($dentiSingoli, array('IS_37_2', $_POST['IS_37_2']), array('IS_38_2', $_POST['IS_38_2']));
		
		array_push($dentiSingoli, array('IS_31_3', $_POST['IS_31_3']), array('IS_32_3', $_POST['IS_32_3']), array('IS_33_3', $_POST['IS_33_3']));
		array_push($dentiSingoli, array('IS_34_3', $_POST['IS_34_3']), array('IS_35_3', $_POST['IS_35_3']), array('IS_36_3', $_POST['IS_36_3']));
		array_push($dentiSingoli, array('IS_37_3', $_POST['IS_37_3']), array('IS_38_3', $_POST['IS_38_3']));
		
		array_push($dentiSingoli, array('IS_31_4', $_POST['IS_31_4']), array('IS_32_4', $_POST['IS_32_4']), array('IS_33_4', $_POST['IS_33_4']));
		array_push($dentiSingoli, array('IS_34_4', $_POST['IS_34_4']), array('IS_35_4', $_POST['IS_35_4']), array('IS_36_4', $_POST['IS_36_4']));
		array_push($dentiSingoli, array('IS_37_4', $_POST['IS_37_4']), array('IS_38_4', $_POST['IS_38_4']));
		
		array_push($dentiSingoli, array('IS_31_5', $_POST['IS_31_5']), array('IS_32_5', $_POST['IS_32_5']), array('IS_33_5', $_POST['IS_33_5']));
		array_push($dentiSingoli, array('IS_34_5', $_POST['IS_34_5']), array('IS_35_5', $_POST['IS_35_5']), array('IS_36_5', $_POST['IS_36_5']));
		array_push($dentiSingoli, array('IS_37_5', $_POST['IS_37_5']), array('IS_38_5', $_POST['IS_38_5']));

		// restituisce l'array
		
		return $dentiSingoli;
	}	

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
}

?>

