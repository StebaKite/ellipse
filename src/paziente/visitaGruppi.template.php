<?php

require_once 'visitaPaziente.abstract.class.php';

class visitaGruppi extends visitaPazienteAbstract {
	
	private static $pagina = "/paziente/visita.gruppi.form.html";
	private static $voceGruppo_1;
	private static $dentiGruppo_1;	
	private static $voceGruppo_2;
	private static $dentiGruppo_2;
	private static $voceGruppo_3;
	private static $dentiGruppo_3;
	private static $voceGruppo_4;
	private static $dentiGruppo_4;
	
	//-----------------------------------------------------------------------------

	function __construct() {
		
		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/paziente:" . self::$root . "/ellipse/src/utility";  
		set_include_path($pathToInclude);		
	}

	// Setters --------------------------------------------------------------------
	
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
	
	// Getters --------------------------------------------------------------------

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

		$vociListinoEsteso = "";	// per la tab di aiuto consultazione voci disponibili
		
		$replace = array('%idlistino%' => $this->getIdListino());
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryVociListinoPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
		
		$rows = pg_fetch_all($result);

		$replace = array(
			'%titoloPagina%' => $this->getTitoloPagina(),
			'%cognome%' => $this->getCognome(),
			'%nome%' => $this->getNome(),
			'%datanascita%' => $this->getDataNascita(),
			'%azione%' => $this->getAzione(),
			'%confermaTip%' => $this->getConfermaTip(),
			'%cognomeRicerca%' => $this->getCognomeRicerca(),
			'%idPaziente%' => $this->getIdPaziente(),
			'%idListino%' => $this->getIdListino(),
			'%vociListinoEsteso%' => $this->preparaListinoEsteso($rows),
			'%vociListinoGruppo_1%' => $this->preparaComboGruppo($rows, $this->getVoceGruppo_1()),
			'%vociListinoGruppo_2%' => $this->preparaComboGruppo($rows, $this->getVoceGruppo_2()),
			'%vociListinoGruppo_3%' => $this->preparaComboGruppo($rows, $this->getVoceGruppo_3()),
			'%vociListinoGruppo_4%' => $this->preparaComboGruppo($rows, $this->getVoceGruppo_4())
		);

		$utility = new utility();

		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);
	}	
	
	private function preparaComboGruppo($rows, $voceGruppo) {
		
		$vociCombo = "";
		
		foreach ($rows as $cod) {
			 
			if (trim($cod['codicevocelistino']) === trim($voceGruppo))
				$vociCombo .= "<option value='" . $cod['codicevocelistino'] . "' selected >" . $cod['descrizionevoce'] . "</option>";
			else
				$vociCombo .= "<option value='" . $cod['codicevocelistino'] . "' >" . $cod['descrizionevoce'] . "</option>";
		}
		return $vociCombo;
	}
	
	private function preparaListinoEsteso($rows) {
		
		$vociListino = "";
		
		foreach ($rows as $cod) {
			$vociListino .= "<tr><td>" . $cod['codicevocelistino'] . "</td><td>" . $cod['descrizionevoce'] . "</td></tr>";			
		}		
		return $vociListino;
	}
}
?>
