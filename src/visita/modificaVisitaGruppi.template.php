<?php

require_once 'visita.abstract.class.php';

class visitaGruppi extends visitaAbstract {
	
	private static $pagina = "/visita/visita.gruppi.form.html";
	
	//-----------------------------------------------------------------------------

	function __construct() {
		self::$root = $_SERVER['DOCUMENT_ROOT'];
	}

	// template ------------------------------------------------------------------
	
	public function displayPagina() {

		require_once 'database.class.php';
		require_once 'utility.class.php';

		error_log("<<<<<<< Display >>>>>>> " . $_SERVER['PHP_SELF']);

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

		$replace = array(
			'%titoloPagina%' => $this->getTitoloPagina(),
			'%visita%' => $this->getVisitaLabel(),
			'%cognome%' => $_SESSION['cognome'],
			'%nome%' => $_SESSION['nome'],
			'%datanascita%' => $_SESSION['datanascita'],
			'%azioneDentiSingoli%' => $this->getAzioneDentiSingoli(),
			'%azioneGruppi%' => $this->getAzioneGruppi(),
			'%azioneCure%' => $this->getAzioneCure(),
			'%confermaTip%' => $this->getConfermaTip(),
			'%singoliTip%' => $this->getSingoliTip(),
			'%cureTip%' => $this->getCureTip(),
			'%idVisita%' => $_SESSION['idVisita'],
			'%vociListinoEsteso%' => $this->preparaListinoEsteso($rows),
			'%vociListinoGruppo_1%' => $this->preparaComboGruppo($rows, $_SESSION['vocegruppo_1']),
			'%vociListinoGruppo_2%' => $this->preparaComboGruppo($rows, $_SESSION['vocegruppo_2']),
			'%vociListinoGruppo_3%' => $this->preparaComboGruppo($rows, $_SESSION['vocegruppo_3']),
			'%vociListinoGruppo_4%' => $this->preparaComboGruppo($rows, $_SESSION['vocegruppo_4'])
		);

		$replaceArray = array();
		$replaceArray = $this->preparaCheckbox($this->prelevaVociGruppi($db), $replace);

		$template = $utility->tailFile($utility->getTemplate($form), $replaceArray);
		echo $utility->tailTemplate($template);
	}	

	public function prelevaVociGruppi($db) {

		require_once 'database.class.php';
		require_once 'utility.class.php';
		
		$utility = new utility();
		$array = $utility->getConfig();

		$form = self::$root . $array['template'] . self::$pagina;

		// preleva tutte le voci inserite in gruppi per la visita in modifica
		
		$replace = array(
			'%idpaziente%' => $_SESSION['idPaziente'],
			'%idvisita%' => $_SESSION['idVisita']
		);
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryVociVisitaGruppiPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
		
		$dentiGruppo = pg_fetch_all($result);		
		return $dentiGruppo;	
	}
	
	private function preparaComboGruppo($rows, $voceGruppo) {
		
		$vociCombo = "";
		
		foreach ($rows as $cod) {
			 
			if (trim($cod['codicevocelistino']) == trim($voceGruppo))
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
