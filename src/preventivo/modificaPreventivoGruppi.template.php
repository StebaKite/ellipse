<?php

require_once 'preventivo.abstract.class.php';

class modificaPreventivoGruppiTemplate extends preventivoAbstract {

	private static $pagina = "/preventivo/preventivo.gruppi.form.html";

	//-----------------------------------------------------------------------------

	function __construct() {
		self::$root = $_SERVER['DOCUMENT_ROOT'];
	}

	public function displayPagina() {
	
		require_once 'database.class.php';
		require_once 'utility.class.php';

		error_log("<<<<<<< Display >>>>>>> " . $_SERVER['PHP_SELF']);
		
		// Template --------------------------------------------------------------
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$form = self::$root . $array['template'] . self::$pagina;
	
		$db = new database();
	
		//-------------------------------------------------------------
	
		$vociListinoEsteso = "";	// per la tab di aiuto consultazione voci disponibili
	
		$replace = array('%idlistino%' => $_SESSION['idListino']);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryVociListinoPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
	
		$rows = pg_fetch_all($result);

 		if ($_SESSION['totalepreventivogruppi'] > 0) {
			$totaleGruppi = "&euro;" . number_format($_SESSION['totalepreventivogruppi'], 2, ',', '.');
		}
		else {
			$totaleGruppi = $_SESSION['totalepreventivogruppi'];
		}
		
		$replace = array(
				'%bottonePianoPagamento%' => $_SESSION['bottonePianoPagamento'],
				'%titoloPagina%' => $this->getTitoloPagina(),
				'%preventivo%' => $this->getPreventivoLabel(),
				'%totale%' => $this->getTotalePreventivoLabel(),
				'%totgruppi%' => $totaleGruppi,
				'%cognome%' => $_SESSION['cognome'],
				'%nome%' => $_SESSION['nome'],
				'%datanascita%' => $_SESSION['datanascita'],
				'%azioneDentiSingoli%' => $this->getAzioneDentiSingoli(),
				'%azioneGruppi%' => $this->getAzioneGruppi(),
				'%azioneCure%' => $this->getAzioneCure(),
				'%azionePagamento%' => $this->getAzionePagamento(),
				'%singoliTip%' => $this->getSingoliTip(),
				'%cureTip%' => $this->getCureTip(),
				'%confermaTip%' => $this->getConfermaTip(),
				'%idPreventivo%' => $_SESSION['idPreventivo'],
				'%idPreventivoPrincipale%' => $_SESSION['idPreventivoPrincipale'],
				'%idSottoPreventivo%' => $_SESSION['idSottoPreventivo'],
				'%stato%' => $_SESSION['stato'],
				'%vociListinoEsteso%' => $this->preparaListinoEsteso($rows),
				'%vociListinoGruppo_1%' => $this->preparaComboGruppo($rows, $_SESSION['vocegruppo_1']),
				'%vociListinoGruppo_2%' => $this->preparaComboGruppo($rows, $_SESSION['vocegruppo_2']),
				'%vociListinoGruppo_3%' => $this->preparaComboGruppo($rows, $_SESSION['vocegruppo_3']),
				'%vociListinoGruppo_4%' => $this->preparaComboGruppo($rows, $_SESSION['vocegruppo_4'])
		);

		$replaceArray = array();
		
		if ($_SESSION['idPreventivo'] != "") {
			$replaceArray = $this->preparaCheckbox($this->prelevaVociGruppiPreventivoPrincipale($db), $replace);
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {
			$replaceArray = $this->preparaCheckbox($this->prelevaVociGruppiPreventivoSecondario($db), $replace);
		}		
		
		$template = $utility->tailFile($utility->getTemplate($form), $replaceArray);
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

	private function preparaCheckbox($dentiGruppo, $replaceArray) {
		
		foreach ($dentiGruppo as $dente) {
			$chiave = '%' . trim($dente['nomecampoform']) . '_checked%';
			$valore = 'checked';
			$replaceArray[$chiave] = $valore;
		}
		return $replaceArray;
	}
}
	
?>