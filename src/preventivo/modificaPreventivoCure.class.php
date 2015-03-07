<?php

require_once 'preventivo.abstract.class.php';

class modificaPreventivoCure extends preventivoAbstract {

	private static $cureForm = "cure";
	public static $azioneDentiSingoli = "../preventivo/modificaPreventivoFacade.class.php?modo=start";
	public static $azioneGruppi = "../preventivo/modificaPreventivoGruppiFacade.class.php?modo=start";
	public static $azioneCure = "../preventivo/modificaPreventivoCureFacade.class.php?modo=go";
	public static $azionePagamento = "../preventivo/modificaPagamentoFacade.class.php?modo=start";
	
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

	public function getSingoliForm() {
		return self::$singoliForm;
	}

	// ------------------------------------------------
	
	public function start() {
	
		require_once 'modificaPreventivoCure.template.php';
		require_once 'utility.class.php';
	
		error_log("<<<<<<< Start >>>>>>> " . $_SERVER['PHP_SELF']);
	
		$preventivoCureTemplate = new preventivoCureTemplate();
		$this->preparaPagina($preventivoCureTemplate);
	
		// Compone la pagina
		include(self::$testata);
		$preventivoCureTemplate->displayPagina();
		include(self::$piede);
	}

	public function go() {
	
		require_once 'modificaPreventivoCure.template.php';
		require_once 'utility.class.php';
	
		error_log("<<<<<<< Go >>>>>>> " . $_SERVER['PHP_SELF']);
	
		$preventivoCureTemplate = new preventivoCureTemplate();
		$this->preparaPagina($preventivoCureTemplate);
	
		include(self::$testata);
	
		$utility = new utility();
			
		if ($this->modificaCure($preventivoCureTemplate)) {
	
			$preventivoCureTemplate->displayPagina();
			$replace = array('%messaggio%' => '%ml.modificaCureOk%');
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioInfo), $replace);
			echo $utility->tailTemplate($template);
		}
		else {
			$preventivoCureTemplate->displayPagina();
			$replace = array('%messaggio%' => '%ml.modificaCureKo%');
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
			echo $utility->tailTemplate($template);
		}
		include(self::$piede);
	}

	public function modificaCure($preventivoCureTemplate) {
		
		if ($_SESSION['idPreventivo'] != "") {
			return $this->modificaCurePreventivoPrincipale($preventivoCureTemplate);
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {
			return $this->modificaCurePreventivoSecondario($preventivoCureTemplate);
		}
	}
	
	public function modificaCurePreventivoPrincipale($preventivoCureTemplate) {
	
		require_once 'database.class.php';
	
		$db = new database();
		$db->beginTransaction();
	
		if ($this->modificaVociCurePreventivoPrincipale($db, $_SESSION['curegeneriche'], $_SESSION['idPreventivo'], self::$cureForm)) {
	
			// aggiorno la datamodifica della "visita"
			if (!$this->aggiornaPreventivo($db, $_SESSION['idPreventivo'])) {
				error_log("Fallito aggiornamento preventivo : " . $_SESSION['idPreventivo']);
				$db->rollbackTransaction();
				return FALSE;
			}
	
			// aggiorno la datamodifica del "paziente"
			if (!$this->aggiornaPaziente($db, $_SESSION['idPaziente'], self::$root)) {
				error_log("Fallito aggiornamento paziente : " . $_SESSION['idPaziente']);
				$db->rollbackTransaction();
				return FALSE;
			}
							
			$db->commitTransaction();
			return TRUE;
		}
		return FALSE;
	}


	public function modificaCurePreventivoSecondario($preventivoCureTemplate) {
	
		require_once 'database.class.php';
	
		$db = new database();
		$db->beginTransaction();
	
		if ($this->modificaVociCurePreventivoSecondario($db, $_SESSION['curegeneriche'], $_SESSION['idSottoPreventivo'], self::$cureForm)) {
	
			// aggiorno la datamodifica della "visita"
			if (!$this->aggiornaSottoPreventivo($db, $_SESSION['idSottoPreventivo'])) {
				error_log("Fallito aggiornamento preventivo secondario : " . $_SESSION['idSottoPreventivo']);
				$db->rollbackTransaction();
				return FALSE;
			}
	
			// aggiorno la datamodifica del "paziente"
			if (!$this->aggiornaPaziente($db, $_SESSION['idPaziente'], self::$root)) {
				error_log("Fallito aggiornamento paziente : " . $_SESSION['idPaziente']);
				$db->rollbackTransaction();
				return FALSE;
			}
							
			$db->commitTransaction();
			return TRUE;
		}
		return FALSE;
	}	
	
	public function modificaVociCurePreventivoPrincipale($db, $cureGeneriche, $idPreventivo, $nomeForm) {
	
		foreach($cureGeneriche as $row) {
	
			// cerco il nomecampo sulla tabella vocepreventivo
			$idVoce = $this->leggiVocePreventivo($db, $idPreventivo, trim($row[0]), $nomeForm);
	
			// se il nomecampo esiste in tabella "vocevisita" e il combo è selezionato in pagina
			if ($idVoce != "" and $row[1] != "") {
				if (!$this->aggiornaVocePreventivo($db, $idVoce, $row[1])) {
					error_log("Fallito aggiornamento idvoce : " . $idVoce);
					$db->rollbackTransaction();
					return FALSE;
				}
			}
			// se il nomecampo esiste in tabella "vocevisita" e il campo non è selezionato in pagina
			elseif ($idVoce != "" and $row[1] == "") {

				// Se il preventivo è in stato "Proposto" la voce può essere cancellata
				
				if ($_SESSION['stato'] == "00") {
						
					if (!$this->cancellaVocePreventivo($db, $idVoce)) {
						error_log("Fallita cancellazione idvoce : " . $idVoce);
						$db->rollbackTransaction();
						return FALSE;
					}
				}
				elseif ($_SESSION['stato'] == "01") {
				
					if (!$this->aggiornaStatoVocePreventivoPrincipale($db, $idVoce, '01')) {	// voce sospesa
						error_log("Fallito cambio stato voce  : " . $idVoce);
						$db->rollbackTransaction();
						return FALSE;
					}
				}
			}
			// se il nomecampo non esiste in tabella "vocevisita" e il campo è selezionato in pagina
			elseif ($idVoce == "" and $row[1] != "") {
				if (!$this->creaVocePreventivo($db, $idPreventivo, self::$cureForm, $row[0], $row[1])) {
					error_log("Fallita creazione voce per il preventivo : " . $idPreventivo);
					$db->rollbackTransaction();
					return FALSE;
				}
			}
		}
		return TRUE;
	}
	
	public function modificaVociCurePreventivoSecondario($db, $cureGeneriche, $idSottoPreventivo, $nomeForm) {
	
		foreach($cureGeneriche as $row) {
	
			// cerco il nomecampo sulla tabella vocepreventivo
			$idVoce = $this->leggiVoceSottoPreventivo($db, $idSottoPreventivo, trim($row[0]), $nomeForm);
	
			// se il nomecampo esiste in tabella "vocevisita" e il combo è selezionato in pagina
			if ($idVoce != "" and $row[1] != "") {
				if (!$this->aggiornaVoceSottoPreventivo($db, $idVoce, $row[1])) {
					error_log("Fallito aggiornamento idvoce : " . $idVoce);
					$db->rollbackTransaction();
					return FALSE;
				}
			}
			// se il nomecampo esiste in tabella "vocevisita" e il campo non è selezionato in pagina
			elseif ($idVoce != "" and $row[1] == "") {

				// Se il preventivo è in stato "Proposto" la voce può essere cancellata
				
				if ($_SESSION['stato'] == "00") {
						
					if (!$this->cancellaVoceSottoPreventivo($db, $idVoce)) {
						error_log("Fallita cancellazione idvoce : " . $idVoce);
						$db->rollbackTransaction();
						return FALSE;
					}
				}
				elseif ($_SESSION['stato'] == "01") {
				
					if (!$this->aggiornaStatoVocePreventivoSecondario($db, $idVoce, '01')) {	// voce sospesa
						error_log("Fallito cambio stato voce  : " . $idVoce);
						$db->rollbackTransaction();
						return FALSE;
					}
				}
			}
			// se il nomecampo non esiste in tabella "vocevisita" e il campo è selezionato in pagina
			elseif ($idVoce == "" and $row[1] != "") {
				if (!$this->creaVoceSottoPreventivo($db, $idSottoPreventivo, self::$cureForm, $row[0], $row[1])) {
					error_log("Fallita creazione voce per il preventivo secondario : " . $idSottoPreventivo);
					$db->rollbackTransaction();
					return FALSE;
				}
			}
		}
		return TRUE;
	}	

	public function preparaPagina($preventivoCureTemplate) {
			
		$preventivoCureTemplate->setAzioneDentiSingoli(self::$azioneDentiSingoli);
		$preventivoCureTemplate->setAzioneGruppi(self::$azioneGruppi);
		$preventivoCureTemplate->setAzioneCure(self::$azioneCure);
		$preventivoCureTemplate->setAzionePagamento(self::$azionePagamento);
		
		$preventivoCureTemplate->setConfermaTip("%ml.confermaModificaPreventivo%");
		$preventivoCureTemplate->setSingoliTip("%ml.modificaSingoli%");
		$preventivoCureTemplate->setGruppiTip("%ml.modificaGruppi%");

 		$_SESSION['curegeneriche'] = $this->prelevaCampiFormCure();
		
		if ($_SESSION['idPreventivo'] != "") {
			$preventivoCureTemplate->setTitoloPagina("%ml.modificaPreventivoPrincipaleCure%");
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {
			$preventivoCureTemplate->setTitoloPagina("%ml.modificaPreventivoSecondarioCure%");
		}		
		$preventivoCureTemplate->setPreventivoLabel("Preventivo:");
		$preventivoCureTemplate->setTotalePreventivoLabel("Totale cure:");
	}
}	

?>