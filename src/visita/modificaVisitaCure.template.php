<?php

require_once 'visitaPaziente.abstract.class.php';

class visitaCure extends visitaPazienteAbstract {
	
	private static $cureForm = "cure";
	private static $pagina = "/visita/visita.cure.form.html";
	private static $voceCura;

	public function setVoceCura($voceCura) {
		self::$voceCura = $voceCura;
	}

	public function getVoceCura() {
		return self::$voceCura;
	}
	
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
		
		$replace = array('%idlistino%' => $this->getIdListino());
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryVociGenericheListinoPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
		
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
			'%confermaTip%' => $this->getConfermaTip(),
			'%singoliTip%' => $this->getSingoliTip(),
			'%gruppiTip%' => $this->getGruppiTip(),
			'%cognomeRicerca%' => $this->getCognomeRicerca(),
			'%idPaziente%' => $this->getIdPaziente(),
			'%idListino%' => $this->getIdListino(),
			'%idVisita%' => $this->getIdVisita()
		);
		
		if ($rows) {
			$replace['%vociListinoEsteso%'] = $this->preparaListinoEsteso($rows);

			foreach($this->getCureGeneriche() as $comboCure) {

				$this->setVoceCura($this->leggiVoceCuraVisita($db, $this->getIdVisita(), $comboCure[0], self::$cureForm));
				$replace['%' . $comboCure[0] . '%'] = $this->preparaComboGruppo($rows, $this->getVoceCura());
				
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
				$voceCura = "";
				$this->setVoceCura($voceCura);
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
