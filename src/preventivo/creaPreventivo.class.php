<?php

require_once 'preventivo.abstract.class.php';

class creaPreventivo extends preventivoAbstract {

	public static $singoliForm = "singoli";
	public static $azioneDentiSingoli = "../preventivo/creaPreventivoFacade.class.php?modo=go";
	public static $azioneGruppi = "../preventivo/creaPreventivoGruppiFacade.class.php?modo=start";
	public static $azioneCure = "../preventivo/creaPreventivoCureFacade.class.php?modo=start";
	
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

	// ------------------------------------------------

	public function start() {

		require_once 'preventivo.template.php';
		
		$preventivoTemplate = new preventivoTemplate();
		$this->preparaPagina($preventivoTemplate);
		
		// Compone la pagina
		include(self::$testata);
		$preventivoTemplate->displayPagina();
		include(self::$piede);
	}

	public function go() {

		require_once 'ricercaPreventivo.class.php';
		require_once 'preventivo.template.php';
		require_once 'utility.class.php';
		
		// Template
		$utility = new utility();
		
		$preventivoTemplate = new preventivoTemplate();
		$this->preparaPagina($preventivoTemplate);
		$_SESSION['dentisingoli'] = $this->prelevaCampiFormSingoli();
		
		include(self::$testata);
		
		if ($preventivoTemplate->controlliLogici()) {
				
			if ($this->inserisciSingoli($preventivoTemplate)) {
		
				$ricercaPreventivo = new ricercaPreventivo();
				$ricercaPreventivo->setMessaggio("%ml.creaPreventivoOk%");
				$ricercaPreventivo->start();
			}
			else {
				$preventivoTemplate->displayPagina();
				$replace = array('%messaggio%' => '%ml.creaPreventivoKo%');
				$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
				echo $utility->tailTemplate($template);
			}
		}
		else {
			$preventivoTemplate->displayPagina();
			$replace = array('%messaggio%' => '%ml.creaPreventivoKo%');
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
			echo $utility->tailTemplate($template);
		}
		
		include(self::$piede);
	}

	private function inserisciSingoli($preventivoTemplate) {
	
		require_once 'database.class.php';
	
		$db = new database();
		$db->beginTransaction();
	
		/*
		 * Una riga in "preventivo" e tutte le voci in tabella "vocepreventivo"
		*/
	
		if ($this->creaPreventivo($db, self::$root)) {
	
			$dentiSingoli = $_SESSION['dentisingoli'];
			$_SESSION['idPreventivo'] = $db->getLastIdUsed();
	
			for ($i = 0; $i < sizeof($dentiSingoli); $i++) {
	
				if ($dentiSingoli[$i][1] != "") {
					if (!$this->creaVocePreventivo($db, $_SESSION['idPreventivo'], self::$singoliForm, trim($dentiSingoli[$i][0]), trim($dentiSingoli[$i][1]))) {
						$db->rollbackTransaction();
						error_log("Errore inserimento voce, eseguito Rollback");
						return FALSE;
					}
				}
			}
			$db->commitTransaction();
			return TRUE;
		}
		return FALSE;
	}
	
	public function preparaPagina($preventivoTemplate) {

		$preventivoTemplate->setAzioneDentiSingoli(self::$azioneDentiSingoli);
		$preventivoTemplate->setAzioneGruppi(self::$azioneGruppi);
		$preventivoTemplate->setAzioneCure(self::$azioneCure);

		unset($_SESSION['bottonePianoPagamento']);
		
		$preventivoTemplate->setConfermaTip("%ml.confermaCreazionePreventivo%");
		$preventivoTemplate->setGruppiTip("%ml.creaGruppi%");
		$preventivoTemplate->setCureTip("%ml.creaCure%");
		
		$preventivoTemplate->setTitoloPagina("%ml.creaNuovoPreventivoDentiSingoli%");
		$preventivoTemplate->setPreventivoLabel("");
		$preventivoTemplate->setTotalePreventivoLabel("");
		
		unset($_SESSION['impostazionivoci']);
		unset($_SESSION['idPreventivo']);
		unset($_SESSION['idSottoPreventivo']);
		unset($_SESSION['totalepreventivodentisingoli']);
	}
}

?>