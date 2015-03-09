<?php

require_once 'preventivo.abstract.class.php';

class creaPreventivoGruppi extends preventivoAbstract {

	public static $gruppiForm = "gruppi";
	public static $azioneGruppi = "../preventivo/creaPreventivoGruppiFacade.class.php?modo=go";
	public static $azioneDentiSingoli = "../preventivo/creaPreventivoFacade.class.php?modo=start";
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
	
	public function getGruppiForm() {
		return self::$gruppiForm;
	}
	
	// ------------------------------------------------
	
	public function start() {
	
		require_once 'preventivoGruppi.template.php';
	
		$preventivoGruppiTemplate = new preventivoGruppiTemplate();
		$this->preparaPagina($preventivoGruppiTemplate);
	
		// Compone la pagina
		include(self::$testata);
		$preventivoGruppiTemplate->displayPagina();
		include(self::$piede);
	}


	public function go() {
	
		require_once 'ricercaPreventivo.class.php';
		require_once 'preventivoGruppi.template.php';
		require_once 'utility.class.php';

		// Template
		
		$preventivoGruppiTemplate = new preventivoGruppiTemplate();
		$this->preparaPagina($preventivoGruppiTemplate);
		
		$_SESSION['vocegruppo_1'] = $_POST['voceGruppo_1'];
		$_SESSION['dentigruppo_1'] = $this->prelevaCampiFormGruppo_1();
		
		$_SESSION['vocegruppo_2'] = $_POST['voceGruppo_2'];
		$_SESSION['dentigruppo_2'] = $this->prelevaCampiFormGruppo_2();
		
		$_SESSION['vocegruppo_3'] = $_POST['voceGruppo_3'];
		$_SESSION['dentigruppo_3'] = $this->prelevaCampiFormGruppo_3();
		
		$_SESSION['vocegruppo_4'] = $_POST['voceGruppo_4'];
		$_SESSION['dentigruppo_4'] = $this->prelevaCampiFormGruppo_4();

		include($this->getTestata());
			
		if ($this->inserisciGruppi($preventivoGruppiTemplate)) {
		
			$ricercaPreventivo = new ricercaPreventivo();
			$ricercaPreventivo->setMessaggio("%ml.creaPreventivoOk%");
			$ricercaPreventivo->start();
		}
		else {
			$preventivoGruppiTemplate->displayPagina();
			$replace = array('%messaggio%' => '%ml.creaPreventivoKo%');
			$template = $utility->tailFile($utility->getTemplate(self::messaggioErrore), $replace);
			echo $utility->tailTemplate($template);
		}		
		include($this->getPiede());	
	}
	

	private function inserisciGruppi($preventivoGruppiTemplate) {

		require_once 'database.class.php';

		$db = new database();
		$db->beginTransaction();

		/*
		 * Una riga in "preventivo" e tutte le voci in tabella "vocePreventivo"
		 */ 

		if ($this->creaPreventivo($db, self::$root)) {

			if ($this->inserisciVociGruppo($db, 'voceGruppo_1', $_SESSION['vocegruppo_1'], $_SESSION['dentigruppo_1'], $db->getLastIdUsed())) {
				if ($this->inserisciVociGruppo($db, 'voceGruppo_2', $_SESSION['vocegruppo_2'], $_SESSION['dentigruppo_2'], $db->getLastIdUsed())) {
					if ($this->inserisciVociGruppo($db, 'voceGruppo_3', $_SESSION['vocegruppo_3'], $_SESSION['dentigruppo_3'], $db->getLastIdUsed())) {
						if ($this->inserisciVociGruppo($db, 'voceGruppo_4', $_SESSION['vocegruppo_4'], $_SESSION['dentigruppo_4'], $db->getLastIdUsed())) {
							$db->commitTransaction();
							return TRUE;				
						}
					}	
				}
			}
		}		
		return FALSE;
	}

	public function inserisciVociGruppo($db, $nomeCampoForm, $voceGruppo, $dentiGruppo, $idPreventivoUsato) {
	
		foreach($dentiGruppo as $row) {

			if ($row[1] != "") {
				if (!$this->creaVocePreventivo($db, $idPreventivoUsato, $this->getGruppiForm(), $nomeCampoForm . ";" . trim($row[0]), $voceGruppo)) {
					$db->rollbackTransaction();
					error_log("Errore inserimento voce, eseguito Rollback");
					return FALSE;	
				}
			}			
		}
		return TRUE;	
	}

	public function preparaPagina($preventivoGruppiTemplate) {
	
		$preventivoGruppiTemplate->setAzioneDentiSingoli(self::$azioneDentiSingoli);
		$preventivoGruppiTemplate->setAzioneGruppi(self::$azioneGruppi);
		$preventivoGruppiTemplate->setAzioneCure(self::$azioneCure);

		unset($_SESSION['bottonePianoPagamento']);
		
		$preventivoGruppiTemplate->setConfermaTip("%ml.confermaCreazionePreventivo%");
		$preventivoGruppiTemplate->setGruppiTip("%ml.creaSingoli%");
		$preventivoGruppiTemplate->setCureTip("%ml.creaCure%");
	
		$preventivoGruppiTemplate->setTitoloPagina("%ml.creaNuovoPreventivoGruppi%");
		$preventivoGruppiTemplate->setPreventivoLabel("");
		
		unset($_SESSION['idPreventivo']);
		unset($_SESSION['idSottoPreventivo']);
		unset($_SESSION['totalepreventivogruppi']);

		unset($_SESSION['vocegruppo_1']);
		unset($_SESSION['vocegruppo_2']);
		unset($_SESSION['vocegruppo_3']);
		unset($_SESSION['vocegruppo_4']);
		unset($_SESSION['dentigruppo_1']);
		unset($_SESSION['dentigruppo_2']);
		unset($_SESSION['dentigruppo_3']);
		unset($_SESSION['dentigruppo_4']);
		
	}
}

?>