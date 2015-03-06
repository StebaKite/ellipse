<?php

require_once 'visita.abstract.class.php';

class visitaCure extends visitaAbstract {
	
	private static $cureForm = "cure";
	private static $pagina = "/visita/visita.cure.form.html";
	private static $voceCura;
	
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
		$db->beginTransaction();

		//-------------------------------------------------------------

		$vociListinoEsteso = "";	// per la tab di aiuto consultazione voci disponibili
		
		$replace = array('%idlistino%' => $_SESSION['idListino']);
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryVociGenericheListinoPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
		
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
			'%gruppiTip%' => $this->getGruppiTip(),
			'%idVisita%' => $_SESSION['idVisita']
		);
		
		if ($rows) {
			$replace['%vociListinoEsteso%'] = $this->preparaListinoEsteso($rows);

			foreach($_SESSION['curegeneriche'] as $comboCure) {

				$voceCura = $this->leggiVoceCuraVisita($db, $_SESSION['idVisita'], $comboCure[0], self::$cureForm);
				$replace['%' . $comboCure[0] . '%'] = $this->preparaComboGruppo($rows, $voceCura);
				$voceCura = "";				
			}
			$db->commitTransaction();
		}
		else {
			$replaceMsg = array('%messaggio%' => '%ml.noVociGen%');				
			$template = $utility->tailFile($utility->getTemplate($this->getMessaggioErrore()), $replaceMsg);			
			echo $utility->tailTemplate($template);
		}

		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);
	}

	private function preparaComboGruppo($rows, $voceCura) {

		foreach ($rows as $cod) {
			
			if (trim($cod['codicevocelistino']) == trim($voceCura)) {
				$vociCombo .= "<option selected='selected' value='" . trim($cod['codicevocelistino']) . "'>" . trim($cod['descrizionevoce']) . "</option>";
			}
			else
				$vociCombo .= "<option value='" . trim($cod['codicevocelistino']) . "' >" . trim($cod['descrizionevoce']) . "</option>";
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
