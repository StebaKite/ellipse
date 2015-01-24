<?php

require_once 'visitaPaziente.abstract.class.php';

class visitaGruppi extends visitaPazienteAbstract {
	
	private static $pagina = "/paziente/visita.gruppi.form.html";
	
	//-----------------------------------------------------------------------------

	function __construct() {
		self::$root = $_SERVER['DOCUMENT_ROOT'];
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
			'%visita%' => $this->getVisitaLabel(),
			'%cognome%' => $this->getCognome(),
			'%nome%' => $this->getNome(),
			'%datanascita%' => $this->getDataNascita(),
			'%azioneDentiSingoli%' => $this->getAzioneDentiSingoli(),
			'%azioneGruppi%' => $this->getAzioneGruppi(),
			'%azioneCure%' => $this->getAzioneCure(),
			'%singoliTip%' => $this->getSingoliTip(),
			'%cureTip%' => $this->getCureTip(),
			'%confermaTip%' => $this->getConfermaTip(),
			'%cognomeRicerca%' => $this->getCognomeRicerca(),
			'%idPaziente%' => $this->getIdPaziente(),
			'%idListino%' => $this->getIdListino(),
			'%idVisita%' => $this->getIdVisita(),
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
