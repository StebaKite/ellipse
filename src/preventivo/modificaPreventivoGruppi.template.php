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
	
		$replace = array('%idlistino%' => $this->getIdListino());
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryVociListinoPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
	
		$rows = pg_fetch_all($result);
	
		$replace = array(
				'%titoloPagina%' => $this->getTitoloPagina(),
				'%preventivo%' => $this->getPreventivoLabel(),
				'%totale%' => $this->getTotalePreventivoLabel(),
				'%totsingoli%' => $this->getTotalePreventivoDentiSingoli(),
				'%totcure%' => $this->getTotalePreventivoCure(),
				'%cognome%' => $this->getCognome(),
				'%nome%' => $this->getNome(),
				'%datanascita%' => $this->getDataNascita(),
				'%azioneDentiSingoli%' => $this->getAzioneDentiSingoli(),
				'%azioneGruppi%' => $this->getAzioneGruppi(),
				'%azioneCure%' => $this->getAzioneCure(),
				'%azionePagamento%' => $this->getAzionePagamento(),
				'%singoliTip%' => $this->getSingoliTip(),
				'%cureTip%' => $this->getCureTip(),
				'%confermaTip%' => $this->getConfermaTip(),
				'%cognomeRicerca%' => $this->getCognomeRicerca(),
				'%idPaziente%' => $this->getIdPaziente(),
				'%idListino%' => $this->getIdListino(),
				'%idPreventivo%' => $this->getIdPreventivo(),
				'%idPreventivoPrincipale%' => $this->getIdPreventivoPrincipale(),
				'%idSottoPreventivo%' => $this->getIdSottoPreventivo(),
				'%stato%' => $this->getStato(),
				'%vociListinoEsteso%' => $this->preparaListinoEsteso($rows),
				'%vociListinoGruppo_1%' => $this->preparaComboGruppo($rows, $this->getVoceGruppo_1()),
				'%vociListinoGruppo_2%' => $this->preparaComboGruppo($rows, $this->getVoceGruppo_2()),
				'%vociListinoGruppo_3%' => $this->preparaComboGruppo($rows, $this->getVoceGruppo_3()),
				'%vociListinoGruppo_4%' => $this->preparaComboGruppo($rows, $this->getVoceGruppo_4())
		);

		$replaceArray = array();
		
		if ($this->getIdPreventivo() != "") {
			$replaceArray = $this->preparaCheckbox($this->prelevaVociGruppiPreventivoPrincipale($db), $replace);
		}
		elseif ($this->getIdSottoPreventivo() != "") {
			$replaceArray = $this->preparaCheckbox($this->prelevaVociGruppiPreventivoSecondario($db), $replace);
		}		
		
		$template = $utility->tailFile($utility->getTemplate($form), $replaceArray);
		echo $utility->tailTemplate($template);
	}

	public function prelevaVociGruppiPreventivoPrincipale($db) {
	
		require_once 'database.class.php';
		require_once 'utility.class.php';
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$form = self::$root . $array['template'] . self::$pagina;
	
		// preleva tutte le voci inserite in gruppi per la visita in modifica
	
		$replace = array(
				'%idpaziente%' => $this->getIdPaziente(),
				'%idpreventivo%' => $this->getIdPreventivo()
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryVociPreventivoGruppiPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
	
		$dentiGruppo = pg_fetch_all($result);
		return $dentiGruppo;
	}

	public function prelevaVociGruppiPreventivoSecondario($db) {
	
		require_once 'database.class.php';
		require_once 'utility.class.php';
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$form = self::$root . $array['template'] . self::$pagina;
	
		// preleva tutte le voci inserite in gruppi per la visita in modifica
	
		$replace = array(
				'%idpaziente%' => $this->getIdPaziente(),
				'%idpreventivo%' => $this->getIdPreventivoPrincipale(),
				'%idsottopreventivo%' => $this->getIdSottoPreventivo()
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryVociSottoPreventivoGruppiPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
	
		$dentiGruppo = pg_fetch_all($result);
		return $dentiGruppo;
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
	
		$totalePreventivoGruppi = 0;
		
		foreach ($dentiGruppo as $dente) {
			$chiave = '%' . trim($dente['nomecampoform']) . '_checked%';
			$valore = 'checked';
			$replaceArray[$chiave] = $valore;
			$totalePreventivoGruppi += $dente['prezzo']; 
		}
		$chiave = '%totgruppi%';
		$valore = '&euro;' . number_format($totalePreventivoGruppi, 2, ',', '.');
		$replaceArray[$chiave] = $valore;
		$this->setTotalePreventivoGruppi($totalePreventivoGruppi);
		return $replaceArray;
	}
}
	
?>