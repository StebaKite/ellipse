<?php

require_once 'preventivo.abstract.class.php';

class modificaPreventivo extends preventivoAbstract {

	private static $singoliForm = "singoli";
	public static $azioneDentiSingoli = "../paziente/modificaPreventivoFacade.class.php?modo=go";
	public static $azioneGruppi = "../paziente/modificaPreventivoGruppiFacade.class.php?modo=start";
	public static $azioneCure = "../paziente/modificaPreventivoCureFacade.class.php?modo=start";

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

		require_once 'preventivo.template.php';
		
		$preventivoTemplate = new preventivoTemplate();
		$this->preparaPagina($preventivoTemplate);
		
		// Compone la pagina
		include(self::$testata);
		$preventivoTemplate->impostaVoci();
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
		$this->setDentiSingoli($this->prelevaCampiFormSingoli());
	
		include(self::$testata);
	
		if ($preventivoTemplate->controlliLogici()) {
			
			if ($this->modificaSingoli($preventivoTemplate)) {
	
				$preventivoTemplate->impostaVoci();
				$preventivoTemplate->displayPagina();
				$replace = array('%messaggio%' => '%ml.modificaPreventivoOk%');
				$template = $utility->tailFile($utility->getTemplate(self::$messaggioInfo), $replace);
				echo $utility->tailTemplate($template);
							}
			else {
				$preventivoTemplate->displayPagina();
				$replace = array('%messaggio%' => '%ml.modificaPreventivoKo%');
				$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
				echo $utility->tailTemplate($template);
			}
		}
		else {
			$preventivoTemplate->displayPagina();
			$replace = array('%messaggio%' => '%ml.modificaPreventivoKo%');
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
			echo $utility->tailTemplate($template);
		}
	
		include(self::$piede);
	}

	private function modificaSingoli($preventivoTemplate) {
		
		if ($preventivoTemplate->getIdPreventivo() != "") {
			return $this->modificaSingoliPreventivoPrincipale($preventivoTemplate);
		}
		elseif ($preventivoTemplate->getIdSottoPreventivo() != "") {
			return $this->modificaSingoliPreventivoSecondario($preventivoTemplate);			
		}
	}
		
	private function modificaSingoliPreventivoPrincipale($preventivoTemplate) {

		require_once 'database.class.php';
		
		$db = new database();
		$db->beginTransaction();
		
		$dentiSingoli = $preventivoTemplate->getDentiSingoli();
		
		foreach($dentiSingoli as $row) {
		
			// cerco il nomecampo sulla tabella vocepreventivo
			$idVoce = $this->leggiVocePreventivo($db, $preventivoTemplate->getIdpreventivo(), trim($row[0]), self::$singoliForm);
				
			// se il nomecampo esiste in tabella "vocepreventivo" e la voce in pagina è != ""
			if ($idVoce != "" and $row[1] != "") {
				if (!$this->aggiornaVocePreventivo($db, $idVoce, $row[1])) {
					error_log("Fallito aggiornamento idvoce : " . $idVoce);
					$db->rollbackTransaction();
					return FALSE;
				}
			}
			// se il nomecampo esiste e la voce in pagina è == "" cancello la voce
			elseif ($idVoce != "" and $row[1] == "") {
				if (!$this->cancellaVocePreventivo($db, $idVoce)) {
					error_log("Fallita cancellazione idvoce : " . $idVoce);
					$db->rollbackTransaction();
					return FALSE;
				}
			}
			// se il nomecampo non esiste e la voce in pagina è != ""
			elseif ($idVoce == "" and $row[1] != "") {
		
				if (!$this->creaVocePreventivo($db, $preventivoTemplate->getIdpreventivo(), self::$singoliForm, $row[0], $row[1])) {
					error_log("Fallita creazione voce per il preventivo : " . $preventivoTemplate->getIdpreventivo());
					$db->rollbackTransaction();
					return FALSE;
				}
			}
		}
		// aggiorno la datamodifica del "preventivo"
		if (!$this->aggiornaPreventivo($db, $preventivoTemplate->getIdpreventivo())) {
			error_log("Fallito aggiornamento preventivo : " . $preventivoTemplate->getIdpreventivo());
			$db->rollbackTransaction();
			return FALSE;
		}
		
		// aggiorno la datamodifica del "paziente"
		if (!$this->aggiornaPaziente($db, $this->getIdPaziente())) {
			error_log("Fallito aggiornamento paziente : " . $this->getIdPaziente());
			$db->rollbackTransaction();
			return FALSE;
		}
		
		$db->commitTransaction();
		return TRUE;
	}

	public function modificaSingoliPreventivoSecondario($preventivoTemplate) {

		require_once 'database.class.php';
		
		$db = new database();
		$db->beginTransaction();
		
		$dentiSingoli = $preventivoTemplate->getDentiSingoli();
		
		foreach($dentiSingoli as $row) {
		
			// cerco il nomecampo sulla tabella vocepreventivo
			$idVoce = $this->leggiVoceSottoPreventivo($db, $preventivoTemplate->getIdSottoPreventivo(), trim($row[0]), self::$singoliForm);
		
			// se il nomecampo esiste in tabella "vocepreventivo" e la voce in pagina è != ""
			if ($idVoce != "" and $row[1] != "") {
				if (!$this->aggiornaVoceSottoPreventivo($db, $idVoce, $row[1])) {
					error_log("Fallito aggiornamento idvoce : " . $idVoce);
					$db->rollbackTransaction();
					return FALSE;
				}
			}
			// se il nomecampo esiste e la voce in pagina è == "" cancello la voce
			elseif ($idVoce != "" and $row[1] == "") {
				if (!$this->cancellaVoceSottoPreventivo($db, $idVoce)) {
					error_log("Fallita cancellazione idvoce : " . $idVoce);
					$db->rollbackTransaction();
					return FALSE;
				}
			}
			// se il nomecampo non esiste e la voce in pagina è != ""
			elseif ($idVoce == "" and $row[1] != "") {
		
				if (!$this->creaVoceSottoPreventivo($db, $preventivoTemplate->getIdSottoPreventivo(), self::$singoliForm, $row[0], $row[1])) {
					error_log("Fallita creazione voce per il sottoPreventivo : " . $preventivoTemplate->getIdSottoPreventivo());
					$db->rollbackTransaction();
					return FALSE;
				}
			}
		}
		// aggiorno la datamodifica del "preventivo"
		if (!$this->aggiornaSottoPreventivo($db, $preventivoTemplate->getIdSottoPreventivo())) {
			error_log("Fallito aggiornamento sottoPreventivo : " . $preventivoTemplate->getIdSottoPreventivo());
			$db->rollbackTransaction();
			return FALSE;
		}
		
		// aggiorno la datamodifica del "paziente"
		if (!$this->aggiornaPaziente($db, $this->getIdPaziente())) {
			error_log("Fallito aggiornamento paziente : " . $this->getIdPaziente());
			$db->rollbackTransaction();
			return FALSE;
		}
		
		$db->commitTransaction();
		return TRUE;
	}
	
	public function preparaPagina($preventivoTemplate) {
	
		$preventivoTemplate->setAzioneDentiSingoli(self::$azioneDentiSingoli);
		$preventivoTemplate->setAzioneGruppi(self::$azioneGruppi);
		$preventivoTemplate->setAzioneCure(self::$azioneCure);
	
		$preventivoTemplate->setConfermaTip("%ml.confermaModificaPreventivo%");
		$preventivoTemplate->setGruppiTip("%ml.creaGruppi%");
		$preventivoTemplate->setCureTip("%ml.creaCure%");
	
		$preventivoTemplate->setTitoloPagina("%ml.modificaPreventivoDentiSingoli%");
	}
}

?>