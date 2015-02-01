<?php

require_once 'preventivo.abstract.class.php';

class modificaPreventivoCure extends preventivoAbstract {

	private static $cureForm = "cure";
	public static $azioneDentiSingoli = "../paziente/modificaPreventivoFacade.class.php?modo=start";
	public static $azioneGruppi = "../paziente/modificaPreventivoGruppiFacade.class.php?modo=start";
	public static $azioneCure = "../paziente/modificaPreventivoCureFacade.class.php?modo=go";

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
		
		if ($preventivoCureTemplate->getIdPreventivo() != "") {
			return $this->modificaCurePreventivoPrincipale($preventivoCureTemplate);
		}
		elseif ($preventivoCureTemplate->getIdSottoPreventivo() != "") {
			return $this->modificaCurePreventivoSecondario($preventivoCureTemplate);
		}
	}
	
	public function modificaCurePreventivoPrincipale($preventivoCureTemplate) {
	
		require_once 'database.class.php';
	
		$db = new database();
		$db->beginTransaction();
	
		if ($this->modificaVociCurePreventivoPrincipale($db, $preventivoCureTemplate->getCureGeneriche(), $preventivoCureTemplate->getIdPreventivo(), self::$cureForm)) {
	
			// aggiorno la datamodifica della "visita"
			if (!$this->aggiornaPreventivo($db, $preventivoCureTemplate->getIdPreventivo())) {
				error_log("Fallito aggiornamento preventivo : " . $preventivoCureTemplate->getIdPreventivo());
				$db->rollbackTransaction();
				return FALSE;
			}
	
			// aggiorno la datamodifica del "paziente"
			if (!$this->aggiornaPaziente($db, $preventivoCureTemplate->getIdPaziente())) {
				error_log("Fallito aggiornamento paziente : " . $preventivoCureTemplate->getIdPaziente());
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
	
		if ($this->modificaVociCurePreventivoSecondario($db, $preventivoCureTemplate->getCureGeneriche(), $preventivoCureTemplate->getIdSottoPreventivo(), self::$cureForm)) {
	
			// aggiorno la datamodifica della "visita"
			if (!$this->aggiornaSottoPreventivo($db, $preventivoCureTemplate->getIdSottoPreventivo())) {
				error_log("Fallito aggiornamento preventivo secondario : " . $preventivoCureTemplate->getIdSottoPreventivo());
				$db->rollbackTransaction();
				return FALSE;
			}
	
			// aggiorno la datamodifica del "paziente"
			if (!$this->aggiornaPaziente($db, $preventivoCureTemplate->getIdPaziente())) {
				error_log("Fallito aggiornamento paziente : " . $preventivoCureTemplate->getIdPaziente());
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
				
				if ($preventivoTemplate->getStato() == "Proposto") {
						
					if (!$this->cancellaVocePreventivo($db, $idVoce)) {
						error_log("Fallita cancellazione idvoce : " . $idVoce);
						$db->rollbackTransaction();
						return FALSE;
					}
				}
				elseif ($preventivoTemplate->getStato() == "Accettato") {
				
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
				
				if ($preventivoTemplate->getStato() == "Proposto") {
						
					if (!$this->cancellaVoceSottoPreventivo($db, $idVoce)) {
						error_log("Fallita cancellazione idvoce : " . $idVoce);
						$db->rollbackTransaction();
						return FALSE;
					}
				}
				elseif ($preventivoTemplate->getStato() == "Accettato") {
				
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
			
		$preventivoCureTemplate->setIdPaziente($this->getIdPaziente());
		$preventivoCureTemplate->setIdListino($this->getIdListino());
		$preventivoCureTemplate->setIdPreventivo($this->getIdPreventivo());
		$preventivoCureTemplate->setCognomeRicerca($this->getCognomeRicerca());
			
		$preventivoCureTemplate->setAzioneDentiSingoli(self::$azioneDentiSingoli);
		$preventivoCureTemplate->setAzioneGruppi(self::$azioneGruppi);
		$preventivoCureTemplate->setAzioneCure(self::$azioneCure);
	
		$preventivoCureTemplate->setConfermaTip("%ml.confermaModificaPreventivo%");
		$preventivoCureTemplate->setSingoliTip("%ml.modificaSingoli%");
		$preventivoCureTemplate->setGruppiTip("%ml.modificaGruppi%");

		$preventivoCureTemplate->setCureGeneriche($this->prelevaCampiFormCure());
		
		if ($this->getIdPreventivo() != "") {
			$preventivoCureTemplate->setTitoloPagina("%ml.modificaPreventivoPrincipaleCure%");
		}
		elseif ($this->getIdSottoPreventivo() != "") {
			$preventivoCureTemplate->setTitoloPagina("%ml.modificaPreventivoSecondarioCure%");
		}		
		$preventivoCureTemplate->setPreventivoLabel("Preventivo");
	}
}	

?>