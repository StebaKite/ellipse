<?php

class visita {
	
	private static $root;
	private static $pagina = "/paziente/visita.form.html";
	private static $queryVociListinoPaziente = "/paziente/ricercaVociListinoPaziente.sql";
	
	private static $azioneDentiSingoli;
	private static $azioneGruppi;
	private static $confermaTip;
	private static $titoloPagina;
	private static $messaggio;	

	private static $cognomeRicerca;

	private static $idPaziente;
	private static $idListino;
	private static $idVisita;
	private static $visita;
	private static $esitoControlliLogici;
	
	private static $dentiSingoli;
	
	private static $voceGruppo_1;
	private static $dentiGruppo_1;
	
	private static $voceGruppo_2;
	private static $dentiGruppo_2;
	
	private static $voceGruppo_3;
	private static $dentiGruppo_3;
	
	private static $voceGruppo_4;
	private static $dentiGruppo_4;
	
	private static $riepilogoDentiSingoli;

	
	//-----------------------------------------------------------------------------

	function __construct() {
		
		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/paziente:" . self::$root . "/ellipse/src/utility";  
		set_include_path($pathToInclude);		
	}

	//-----------------------------------------------------------------------------
	// Setters --------------------------------------------------------------------
	
	public function setAzioneDentiSingoli($azioneDentiSingoli) {
		self::$azioneDentiSingoli = $azioneDentiSingoli;
	}
	public function setAzioneGruppi($azioneGruppi) {
		self::$azioneGruppi = $azioneGruppi;
	}
	public function setConfermaTip($tip) {
		self::$confermaTip = $tip;
	}
	public function setTitoloPagina($titoloPagina) {
		self::$titoloPagina = $titoloPagina;
	}
	public function setMessaggio($messaggio) {
		self::$messaggio = $messaggio;
	}
	public function setIdPaziente($idPaziente) {
		self::$idPaziente = $idPaziente;
	}
	public function setIdVisita($idVisita) {
		self::$idVisita = $idVisita;
	}
	public function setIdListino($idListino) {
		self::$idListino = $idListino;
	}
	public function setCognomeRicerca($cognomeRicerca) {
		self::$cognomeRicerca = $cognomeRicerca;
	}
	public function setVisita($visita) {
		self::$visita = $visita;
	}
	public function setEsitoControlloLogici($esito) {
		self::$esitoControlliLogici = $esito;
	}
	public function setRiepilogoDentiSingoli($riepilogoDentiSingoli) {
		self::$riepilogoDentiSingoli = $riepilogoDentiSingoli;
	}
	public function setDentiSingoli($dentiSingoli) {
		self::$dentiSingoli = $dentiSingoli;
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


	
	// ----------------------------------------------------------------------------
	// Getters --------------------------------------------------------------------

	public function getAzioneDentiSingoli() {
		return self::$azioneDentiSingoli;
	}
	public function getAzioneGruppi() {
		return self::$azioneGruppi;
	}
	public function getConfermaTip() {
		return self::$confermaTip;
	}
	public function getTitoloPagina() {
		return self::$titoloPagina;
	}
	public function getMessaggio() {
		return self::$messaggio;
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
	public function getEsitoControlliLogici() {
		return self::$esitoControlliLogici;
	}
	public function getRiepilogoDentiSingoli() {
		return self::$riepilogoDentiSingoli;
	}
	public function getDentiSingoli() {
		return self::$dentiSingoli;
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

	// template ------------------------------------------------

	public function inizializzaPagina() {
	
		$this->setRiepilogoDentiSingoli("");

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

	public function controlliLogici() {
		
		require_once 'database.class.php';
		require_once 'utility.class.php';

		$esito = TRUE;
		
		// Template --------------------------------------------------------------

		$visita = $this->getVisita();

		$utility = new utility();
		$db = new database();

		//-------------------------------------------------------------
		$array = $utility->getConfig();

		$replace = array('%idlistino%' => $this->getIdListino());
		error_log("Carica le voci del listino : " . $this->getIdListino());
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryVociListinoPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
		
		$vociValide[] = "";
		
		while ($row = pg_fetch_row($result)) {			
			$vociValide[trim($row[0])] = trim($row[0]);
		}

		// controllo esistenza delle voci immesse in pagina
		// alla prima voce non esistente termina il controllo con un errore

		$dentiSingoli = $this->getDentiSingoli();
		$numElePagina = sizeof($dentiSingoli);
		error_log("Elementi in pagina : " . $numElePagina);
		
		for ($i = 0; $i < $numElePagina; $i++) {
		
			if ($dentiSingoli[$i][1] != "") {

				error_log("Cerco voce immessa : " . trim($dentiSingoli[$i][1]));
				
				if (array_key_exists(trim($dentiSingoli[$i][1]), $vociValide)) {
					error_log("Voce " . trim($dentiSingoli[$i][1]) . " ok");
				}
				else {
					$esito = FALSE;
					error_log("Voce " . trim($dentiSingoli[$i][1]) . " non valida");
					break;
				}			
			}
		}		
		return $esito;
	}
	
	public function displayPagina() {

		require_once 'database.class.php';
		require_once 'utility.class.php';
		
		// Template --------------------------------------------------------------

		$visita = $this->getVisita();

		$utility = new utility();
		$array = $utility->getConfig();

		$form = self::$root . $array['template'] . self::$pagina;

		$db = new database();

		//-------------------------------------------------------------

		$vociListino = "";			// per la form dei singoli
		$vociListinoGruppo_1 = "";	// per la form dei gruppi
		$vociListinoGruppo_2 = "";	// per la form dei gruppi
		$vociListinoGruppo_3 = "";	// per la form dei gruppi
		$vociListinoGruppo_4 = "";	// per la form dei gruppi
		
		$replace = array('%idlistino%' => $this->getIdListino());
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryVociListinoPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
		
		$rows = pg_fetch_all($result);
		
		foreach ($rows as $cod) {
			$vociListino .= '"' . $cod['codicevocelistino'] . '",';
		}	

		$replace = array(
			'%titoloPagina%' => $this->getTitoloPagina(),
			'%azioneDentiSingoli%' => $this->getAzioneDentiSingoli(),
			'%azioneGruppi%' => $this->getAzioneGruppi(),
			'%confermaTip%' => $this->getConfermaTip(),
			'%cognomeRicerca%' => $this->getCognomeRicerca(),
			'%idPaziente%' => $this->getIdPaziente(),
			'%idListino%' => $this->getIdListino(),
			'%vociListino%' => $vociListino,
			'%riepilogoDentiSingoli%' => $this->getRiepilogoDentiSingoli()
		);

		// prepara form denti singoli -----------------------------
	
		$dentiSingoli = $this->getDentiSingoli();

		foreach ($dentiSingoli as $singoli) {
			$chiave = '%' . $singoli[0] . '%';
			$valore = $singoli[1];
			$replace[$chiave] = $valore;
		}
		
		// prepara form denti in gruppo 1 ---------------------------

		foreach ($rows as $cod) {

			error_log(trim($cod['codicevocelistino']) . " - " . trim($this->getVoceGruppo_1()));
			 
			if (trim($cod['codicevocelistino']) === trim($this->getVoceGruppo_1())) {
				$vociListinoGruppo_1 .= "<option name='voceGruppo_1' value='" . $cod['codicevocelistino'] . "' selected >" . $cod['descrizionevoce'] . "</option>";
			}
			else {
				$vociListinoGruppo_1 .= "<option name='voceGruppo_1' value='" . $cod['codicevocelistino'] . "' >" . $cod['descrizionevoce'] . "</option>";
			}	
		}

		$dentiGruppo_1 = $this->getDentiGruppo_1();
		
		foreach ($dentiGruppo_1 as $dente) {
			$chiave = '%' . $dente[0] . '_checked%';
			if ($dente[1] == 'on') $valore = 'checked';
			else $valore = '';
			$replace[$chiave] = $valore;		
		}		
				


		$utility = new utility();

		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);
	}		
}	

?>
