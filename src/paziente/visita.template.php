<?php

require_once 'visitaPaziente.abstract.class.php';

class visita extends visitaPazienteAbstract {
	
	private static $pagina = "/paziente/visita.form.html";
	private static $azioneDentiSingoli;
	private static $dentiSingoli;	
	
	//-----------------------------------------------------------------------------

	function __construct() {
		
		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/paziente:" . self::$root . "/ellipse/src/utility";  
		set_include_path($pathToInclude);		
	}

	// Setters --------------------------------------------------------------------
	
	public function setAzioneDentiSingoli($azioneDentiSingoli) {
		self::$azioneDentiSingoli = $azioneDentiSingoli;
	}
	public function setDentiSingoli($dentiSingoli) {
		self::$dentiSingoli = $dentiSingoli;
	}
	
	// Getters --------------------------------------------------------------------

	public function getAzioneDentiSingoli() {
		return self::$azioneDentiSingoli;
	}
	public function getDentiSingoli() {
		return self::$dentiSingoli;
	}

	// template ------------------------------------------------

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
		$vociListinoEsteso = "";	// per la tab di aiuto consultazione voci disponibili
		
		$replace = array('%idlistino%' => $this->getIdListino());
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryVociListinoPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
		
		$rows = pg_fetch_all($result);
		
		foreach ($rows as $cod) {
			$vociListino .= '"' . $cod['codicevocelistino'] . '",';			
			$vociListinoEsteso .= "<tr><td>" . $cod['codicevocelistino'] . "</td><td>" . $cod['descrizionevoce'] . "</td></tr>";
		}	

		$replace = array(
			'%titoloPagina%' => $this->getTitoloPagina(),
			'%cognome%' => $this->getCognome(),
			'%nome%' => $this->getNome(),
			'%datanascita%' => $this->getDataNascita(),
			'%azioneDentiSingoli%' => $this->getAzioneDentiSingoli(),
			'%confermaTip%' => $this->getConfermaTip(),
			'%cognomeRicerca%' => $this->getCognomeRicerca(),
			'%idPaziente%' => $this->getIdPaziente(),
			'%idListino%' => $this->getIdListino(),
			'%vociListino%' => $vociListino,
			'%vociListinoEsteso%' => $vociListinoEsteso
		);

		// prepara form denti singoli -----------------------------
	
		$dentiSingoli = $this->getDentiSingoli();

		foreach ($dentiSingoli as $singoli) {
			$chiave = '%' . $singoli[0] . '%';
			$valore = $singoli[1];
			$replace[$chiave] = $valore;
		}

		$utility = new utility();

		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);
	}		
}	

?>
