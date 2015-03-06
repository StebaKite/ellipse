<?php

require_once 'preventivo.abstract.class.php';

class preventivoCureTemplate extends preventivoAbstract {

	private static $pagina = "/preventivo/preventivo.cure.form.html";

	//-----------------------------------------------------------------------------

	function __construct() {

		self::$root = $_SERVER['DOCUMENT_ROOT'];

		require_once 'utility.class.php';

		$utility = new utility();
		$array = $utility->getConfig();

		self::$testata = self::$root . $array['testataPagina'];
		self::$piede = self::$root . $array['piedePagina'];
		self::$messaggioErrore = self::$root . $array['messaggioErrore'];
		self::$messaggioInfo = self::$root . $array['messaggioInfo'];
	}

	// template ------------------------------------------------

	public function displayPagina() {

		require_once 'database.class.php';
		require_once 'utility.class.php';

		error_log("<<<<<<< Display >>>>>>> " . $_SERVER['PHP_SELF']);
		
		// Template --------------------------------------------------------------
		
		$utility = new utility();		
		$db = new database();
		
		//-------------------------------------------------------------
		
		$vociListinoEsteso = "";	// per la tab di aiuto consultazione voci disponibili
		
		$replace = array('%idlistino%' => $_SESSION['idListino']);
		
		$array = $utility->getConfig();
		$form = self::$root . $array['template'] . self::$pagina;
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryVociGenericheListinoPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
		
		$rows = pg_fetch_all($result);

		if ($_SESSION['totalepreventivocure'] != "") {
			$totaleCure = "&euro;" . number_format($_SESSION['totalepreventivocure'], 2, ',', '.');
		}
		else {
			$totaleCure = "";
		}
		
		$replace = array(
				'%titoloPagina%' => $this->getTitoloPagina(),
				'%preventivo%' => $this->getPreventivoLabel(),
				'%totale%' => $this->getTotalePreventivoLabel(),
				'%totcure%' => $totaleCure,
				'%cognome%' => $_SESSION['cognome'],
				'%nome%' => $_SESSION['nome'],
				'%datanascita%' => $_SESSION['datanascita'],
				'%azioneDentiSingoli%' => $this->getAzioneDentiSingoli(),
				'%azioneGruppi%' => $this->getAzioneGruppi(),
				'%azioneCure%' => $this->getAzioneCure(),
				'%confermaTip%' => $this->getConfermaTip(),
				'%singoliTip%' => $this->getSingoliTip(),
				'%gruppiTip%' => $this->getGruppiTip(),
				'%idPreventivo%' => $_SESSION['idPreventivo'],
				'%idSottoPreventivo%' => $_SESSION['idSottoPreventivo'],
				'%stato%' => $_SESSION['stato']
		);
		
		if ($rows) {
			$replace['%vociListinoEsteso%'] = $this->preparaListinoEsteso($rows);
			foreach($this->getCureGeneriche() as $row) {
				$replace['%' . $row['0'] . '%'] = $this->preparaComboGruppo($rows, $row['1']);
			}
		}
		else {
			$replaceMsg = array('%messaggio%' => '%ml.noVociGen%');
			$template = $utility->tailFile($utility->getTemplate(self::messaggioErrore), $replaceMsg);
			echo $utility->tailTemplate($template);
		}
		
		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);
	}

	private function preparaComboGruppo($rows, $voceGruppo) {
	
		foreach ($rows as $cod) {
	
			if (trim($cod['codicevocelistino']) === trim($voceGruppo))
				$vociCombo .= "<option value='" . $cod['codicevocelistino'] . "' selected >" . $cod['descrizionevoce'] . "</option>";
			else
				$vociCombo .= "<option value='" . $cod['codicevocelistino'] . "' >" . $cod['descrizionevoce'] . "</option>";
		}
		return $vociCombo;
	}
	
	private function preparaListinoEsteso($rows) {
	
		foreach ($rows as $cod) {
			$vociListino .= "<tr><td>" . $cod['codicevocelistino'] . "</td><td>" . $cod['descrizionevoce'] . "</td></tr>";
		}
		return $vociListino;
	}
}
		
?>