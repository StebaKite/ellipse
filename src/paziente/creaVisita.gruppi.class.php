<?php

class creaVisitaGruppi {

	private static $root;
	private static $tipo;
	private static $testata;
	private static $piede;
	private static $messaggioInfo;
	private static $messaggioErrore;
	private static $gruppiForm = "gruppi";
	private static $azione = "../paziente/creaVisitaGruppiFacade.class.php?modo=go";
	private static $cognomeRicerca;
	private static $idPaziente;
	private static $idListino;
	private static $idVisita;
	private static $queryCreaVisita = "/paziente/creaVisita.sql";
	private static $queryCreaVoceVisita = "/paziente/creaVoceVisita.sql";
	private static $queryRicercaVisitaInCorso = "/paziente/ricercaVisitaIncorsoPaziente.sql";
	private static $queryRicercaVoceVisitaInCorso = "/paziente/ricercaVoceVisitaIncorsoPaziente.sql";

	function __construct() {
		
		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/paziente:" . self::$root . "/ellipse/src/utility";  
		set_include_path($pathToInclude);		
	}

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

	// ------------------------------------------------
	
	public function getAzione() {
		return self::$azione;
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
	public function getGruppiForm() {
		return self::$gruppiForm;
	}
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

	// ------------------------------------------------

	public function start() {

		require_once 'visitaGruppi.template.php';
		require_once 'utility.class.php';

		// Template
		$utility = new utility();
		$array = $utility->getConfig();

		$testata = self::$root . $array['testataPagina'];
		$piede = self::$root . $array['piedePagina'];
		$messaggioErrore = self::$root . $array['messaggioErrore'];
		$messaggioInfo = self::$root . $array['messaggioInfo'];

		$visitaGruppi = new visita();		
		$visitaGruppi->setIdPaziente($this->getIdPaziente());
		$visitaGruppi->setIdListino($this->getIdListino());
		$visitaGruppi->setTitoloPagina('%ml.creaNuovaVisita%');
				
		$visitaGruppi->setAzioneGruppi($this->getAzione());
		$visitaGruppi->setConfermaTip("%ml.confermaCreazioneVisita%");		
				
		$visitaGruppi->setTitoloPagina("%ml.creaNuovaVisita%");
		$visitaGruppi->setVisita($visita);		

		// Compone la pagina
		include($testata);
		$visitaGruppi->inizializzaPagina();
		$visitaGruppi->displayPagina();
		include($piede);		
	}
		
	public function go() {
		
		require_once 'ricercaPaziente.class.php';
		require_once 'visita.template.php';
		require_once 'utility.class.php';

		// Template
		$utility = new utility();
		$array = $utility->getConfig();

		$this->setTestata(self::$root . $array['testataPagina']);
		$this->setPiede(self::$root . $array['piedePagina']);
		$this->setMessaggioErrore(self::$root . $array['messaggioErrore']);
		$this->setMessaggioInfo(self::$root . $array['messaggioInfo']);

		$visita = new visita();

		$visita->setIdListino($this->getIdListino());	
		$visita->setTitoloPagina('%ml.creaNuovaVisita%');
		
		$visita->setVoceGruppo_1($_POST['voceGruppo_1']);
		$visita->setDentiGruppo_1($this->prelevaCampiFormGruppo_1());
		
		$visita->setVoceGruppo_2($_POST['voceGruppo_2']);
		$visita->setDentiGruppo_2($this->prelevaCampiFormGruppo_2());
		
		$visita->setVoceGruppo_3($_POST['voceGruppo_3']);
		$visita->setDentiGruppo_3($this->prelevaCampiFormGruppo_3());
		
		$visita->setVoceGruppo_4($_POST['voceGruppo_4']);
		$visita->setDentiGruppo_4($this->prelevaCampiFormGruppo_4());
		$visita->setDentiSingoli($this->prelevaCampiFormSingoli());

		$visita->setAzioneGruppi($this->getAzione());
		$visita->setConfermaTip("%ml.confermaCreazioneVisita%");		

		
		include($this->getTestata());
			
		if ($this->inserisciGruppi($visita)) {

			$ricercaVisita = new ricercaVisita();
			$ricercaVisita->setIdPaziente($this->getIdPaziente());
			$ricercaVisita->setIdListino($this->getIdListino());
			$ricercaVisita->setMessaggio("%ml.creaVisitaOk%");
			$ricercaVisita->setCognomeRicerca($this->getCognomeRicerca());
			$ricercaVisita->start();
		}
		else {
			$visita->displayPagina();
			$replace = array('%messaggio%' => '%ml.creaVisitaKo%');				
			$template = $utility->tailFile($utility->getTemplate($this->getMessaggioErrore()), $replace);			
			echo $utility->tailTemplate($template);
		}

		include($this->getPiede());		
	}
				
	private function inserisciGruppi($visita) {

		require_once 'database.class.php';

		$db = new database();
		$db->beginTransaction();

		/*
		 * Una riga in "visita" e tutte le voci in tabella "voceVisita"
		 */ 

		if ($this->creaVisita($db)) {

			$dentiSingoli = $visita->getDentiSingoli();
			$idVisitaUsato = $db->getLastIdUsed(); 
			$visita->setIdVisita($idVisitaUsato);
			$this->setIdVisita($idVisitaUsato);
			$visita->setIdPaziente($this->getIdPaziente());
				
			for ($i = 0; $i < sizeof($dentiSingoli); $i++) {

				if ($dentiSingoli[$i][1] != "") {
					if (!$this->creaVoceVisita($db, $idVisitaUsato, $this->getSingoliForm(), trim($dentiSingoli[$i][0]), trim($dentiSingoli[$i][1]))) {
						$db->rollbackTransaction();
						error_log("Errore inserimento voce, eseguito Rollback");
						return FALSE;	
					}
				}			
			}
			$db->commitTransaction();
			return TRUE;				
		}		
		return FALSE;
	}
	
	private function creaVisita($db) {
		
		$utility = new utility();
		$array = $utility->getConfig();

		// Verifica esistenza visita in corso  (stato 00)

		$replace = array(
			'%idpaziente%' => $this->getIdPaziente(),
			'%stato%' => '00'
		);
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryRicercaVisitaInCorso;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
		
		if ($db->getNumrows() == 0) {

			$replace = array('%idpaziente%' => $this->getIdPaziente());
			
			$sqlTemplate = self::$root . $array['query'] . self::$queryCreaVisita;
			$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
			$result = $db->execSql($sql);
			
			$this->setInseritiDati(TRUE);
		} 	
		return $result;
	}
	
	private function creaVoceVisita($db, $idVisitaUsato, $nomeForm, $nomeCampoForm, $codiceVoceListino) {
		
		$utility = new utility();
		$array = $utility->getConfig();

		// Ricerca esistenza voce per la visita in corso

		$replace = array(
			'%idvisita%' => $idVisitaUsato,
			'%nomecampoform%' => trim($nomeCampoForm), 
			'%codicevocelistino%' => trim($codiceVoceListino)
		);

		$sqlTemplate = self::$root . $array['query'] . self::$queryRicercaVoceVisitaInCorso;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
		
		if ($db->getNumrows() == 0) {
			
			$replace = array(
				'%nomeForm%' => trim($nomeForm), 
				'%nomecampoform%' => trim($nomeCampoForm),
				'%codicevocelistino%' => trim($codiceVoceListino),
				'%idvisita%' => $idVisitaUsato
			);
			
			$sqlTemplate = self::$root . $array['query'] . self::$queryCreaVoceVisita;
			$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
			$result = $db->execSql($sql);
			
			$this->setInseritiDati(TRUE);
		}
		return $result;	
	} 
	
	private function prelevaCampiFormGruppo_1() {
		
		$dentiGruppo_1 = array();
		
		// primo gruppo --------------------------------------------------------------------------------------------------------------
		
		array_push($dentiGruppo_1, array('G-SD_18_1', $_POST['G-SD_18_1']), array('G-SD_17_1', $_POST['G-SD_17_1']), array('G-SD_16_1', $_POST['G-SD_16_1']));
		array_push($dentiGruppo_1, array('G-SD_15_1', $_POST['G-SD_15_1']), array('G-SD_14_1', $_POST['G-SD_14_1']), array('G-SD_13_1', $_POST['G-SD_13_1']));
		array_push($dentiGruppo_1, array('G-SD_12_1', $_POST['G-SD_12_1']), array('G-SD_11_1', $_POST['G-SD_11_1']));
		
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
	
	private function prelevaCampiFormGruppo_2() {
		
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
	
	private function prelevaCampiFormGruppo_3() {
		
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
	
	private function prelevaCampiFormGruppo_4() {
		
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
