<?php

require_once 'preventivo.abstract.class.php';

class creaPreventivoCure extends preventivoAbstract {

	public static $cureForm = "cure";
	public static $azioneCure = "../preventivo/creaPreventivoCureFacade.class.php?modo=go";
	public static $azioneDentiSingoli = "../preventivo/creaPreventivoFacade.class.php?modo=start";
	public static $azioneGruppi = "../preventivo/creaPreventivoGruppiFacade.class.php?modo=start";

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

	// -------------------------------------------------

	public function getCureForm() {
		return self::$cureForm;
	}

	// ------------------------------------------------
	
	public function start() {
	
		require_once 'preventivoCure.template.php';
	
		error_log("<<<<<<< Start >>>>>>> " . $_SERVER['PHP_SELF']);
	
		$preventivoCureTemplate = new preventivoCureTemplate();
		$this->preparaPagina($preventivoCureTemplate);
	
		// Compone la pagina
		include(self::$testata);
		$preventivoCureTemplate->inizializzaCurePagina();
		$preventivoCureTemplate->displayPagina();
		include(self::$piede);
	}
	
	public function go() {
	
		require_once 'ricercaPreventivo.class.php';
		require_once 'preventivoCure.template.php';
		require_once 'utility.class.php';
	
		error_log("<<<<<<< Go >>>>>>> " . $_SERVER['PHP_SELF']);

		$preventivoCureTemplate = new preventivoCureTemplate();
		$this->preparaPagina($preventivoCureTemplate);
		$preventivoCureTemplate->setCureGeneriche($this->prelevaCampiFormCure());
	
		include(self::$testata);
	
		$utility = new utility();
	
		$voceSelezionata = FALSE;
		foreach ($preventivoCureTemplate->getCureGeneriche() as $row) {
			if ($row['1'] != "") {
				$voceSelezionata = TRUE;
				break;
			}
		}
	
		if ($voceSelezionata) {
				
			if ($this->inserisciCure($preventivoCureTemplate)) {
	
				$ricercaPreventivo = new ricercaPreventivo();
				$ricercaPreventivo->setMessaggio("%ml.creaPreventivoOk%");
				$ricercaPreventivo->start();
			}
			else {
				$preventivoCureTemplate->displayPagina();
				$replace = array('%messaggio%' => '%ml.creaPreventivoKo%');
				$template = $utility->tailFile($utility->getTemplate(self::messaggioErrore), $replace);
				echo $utility->tailTemplate($template);
			}
		}
		else {
			$ricercaPreventivo = new ricercaPreventivo();
			$ricercaPreventivo->start();
		}
		include(self::$piede);
	}

	private function inserisciCure($preventivoCureTemplate) {
	
		require_once 'database.class.php';
	
		$db = new database();
		$db->beginTransaction();
	
		/*
		 * Una riga in "preventivo" e tutte le voci in tabella "vocepreventivo"
		*/
	
		if ($this->creaPreventivo($db, self::$root)) {
	
			$vociGeneriche = $preventivoCureTemplate->getCureGeneriche();
			$idPreventivoUsato = $db->getLastIdUsed();
	
			foreach($vociGeneriche as $row) {
	
				if ($row[1] != "") {
					if (!$this->creaVocePreventivo($db, $idPreventivoUsato, $this->getCureForm(), trim($row[0]), trim($row[1]))) {
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

	public function preparaPagina($preventivoCureTemplate) {
	
		$preventivoCureTemplate->setAzioneDentiSingoli(self::$azioneDentiSingoli);
		$preventivoCureTemplate->setAzioneGruppi(self::$azioneGruppi);
		$preventivoCureTemplate->setAzioneCure(self::$azioneCure);
	
		$preventivoCureTemplate->setConfermaTip('%ml.confermaCreazionePreventivo%');
		$preventivoCureTemplate->setGruppiTip('%ml.creaGruppi%');
		$preventivoCureTemplate->setSingoliTip('%ml.creaSingoli%');
		
		$preventivoCureTemplate->setTitoloPagina("%ml.creaNuovoPreventivoCure%");
		$preventivoCureTemplate->setPreventivoLabel("");
		$preventivoCureTemplate->setIdPreventivo("");

		unset($_SESSION['idPreventivo']);
		unset($_SESSION['idSottoPreventivo']);
		unset($_SESSION['totalepreventivocure']);
		
	}
}
	
?>