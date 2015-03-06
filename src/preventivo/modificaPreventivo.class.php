<?php

require_once 'preventivo.abstract.class.php';

class modificaPreventivo extends preventivoAbstract {

	private static $singoliForm = "singoli";
	public static $azioneDentiSingoli = "../preventivo/modificaPreventivoFacade.class.php?modo=go";
	public static $azioneGruppi = "../preventivo/modificaPreventivoGruppiFacade.class.php?modo=start";
	public static $azioneCure = "../preventivo/modificaPreventivoCureFacade.class.php?modo=start";
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

		error_log("<<<<<<< Start >>>>>>> " . $_SERVER['PHP_SELF']);
		
		require_once 'preventivo.template.php';
		require_once 'utility.class.php';
		require_once 'database.class.php';
		
		$db = new database();
		$utility = new utility();
		
		$db->beginTransaction();
		
		$preventivoTemplate = new preventivoTemplate();
		$this->preparaPagina($db, $utility, $preventivoTemplate);

		$db->commitTransaction();
		
		// Compone la pagina
		include(self::$testata);
		$preventivoTemplate->displayPagina();
		include(self::$piede);		
	}

	public function go() {

		error_log("<<<<<<< Go >>>>>>> " . $_SERVER['PHP_SELF']);
		
		require_once 'ricercaPreventivo.class.php';
		require_once 'preventivo.template.php';
		require_once 'utility.class.php';
		require_once 'database.class.php';
		
		$db = new database();
		$utility = new utility();

		$db->beginTransaction();
		
		$preventivoTemplate = new preventivoTemplate();
		$this->preparaPagina($db, $utility, $preventivoTemplate);
		$_SESSION['dentisingoli'] = $this->prelevaCampiFormSingoli();

		$db->commitTransaction();
		
		include(self::$testata);
	
		if ($preventivoTemplate->controlliLogici()) {

			$db->beginTransaction();
				
			if ($this->modificaSingoli($db, $preventivoTemplate)) {
	
				$preventivoTemplate->impostaVoci($db, $utility);
				$preventivoTemplate->calcolaTotalePreventivo($db);
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
			
			$db->commitTransaction();				
		}
		else {
			$preventivoTemplate->displayPagina();
			$replace = array('%messaggio%' => '%ml.modificaPreventivoKo%');
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
			echo $utility->tailTemplate($template);
		}
		
		include(self::$piede);
	}

	private function modificaSingoli($db, $preventivoTemplate) {
		
		if ($_SESSION['idPreventivo'] != "") {
			return $this->modificaSingoliPreventivoPrincipale($db, $preventivoTemplate);
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {
			return $this->modificaSingoliPreventivoSecondario($db, $preventivoTemplate);
		}
	}
		
	private function modificaSingoliPreventivoPrincipale($db, $preventivoTemplate) {
		
		foreach($_SESSION['dentisingoli'] as $row) {
		
			// cerco il nomecampo sulla tabella vocepreventivo
			$idVoce = $this->leggiVocePreventivo($db, $_SESSION['idPreventivo'], trim($row[0]), self::$singoliForm);
				
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
			// se il nomecampo non esiste e la voce in pagina è != ""
			elseif ($idVoce == "" and $row[1] != "") {
		
				if (!$this->creaVocePreventivo($db, $_SESSION['idPreventivo'], self::$singoliForm, $row[0], $row[1])) {
					error_log("Fallita creazione voce per il preventivo : " . $_SESSION['idPreventivo']);
					$db->rollbackTransaction();
					return FALSE;
				}
			}
		}
		// aggiorno la datamodifica del "preventivo"
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
		return TRUE;
	}

	public function modificaSingoliPreventivoSecondario($db, $preventivoTemplate) {
		
		foreach($_SESSION['dentisingoli'] as $row) {
		
			// cerco il nomecampo sulla tabella vocepreventivo
			$idVoce = $this->leggiVoceSottoPreventivo($db, $_SESSION['idSottoPreventivo'], trim($row[0]), self::$singoliForm);
		
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
			// se il nomecampo non esiste e la voce in pagina è != ""
			elseif ($idVoce == "" and $row[1] != "") {
		
				if (!$this->creaVoceSottoPreventivo($db, $_SESSION['idSottoPreventivo'], self::$singoliForm, $row[0], $row[1])) {
					error_log("Fallita creazione voce per il sottoPreventivo : " . $_SESSION['idSottoPreventivo']);
					$db->rollbackTransaction();
					return FALSE;
				}
			}
		}
		// aggiorno la datamodifica del "preventivo"
		if (!$this->aggiornaSottoPreventivo($db, $_SESSION['idSottoPreventivo'])) {
			error_log("Fallito aggiornamento sottoPreventivo : " . $_SESSION['idSottoPreventivo']);
			$db->rollbackTransaction();
			return FALSE;
		}
		
		// aggiorno la datamodifica del "paziente"
		if (!$this->aggiornaPaziente($db, $_SESSION['idPaziente'], self::$root)) {
			error_log("Fallito aggiornamento paziente : " . $_SESSION['idPaziente']);
			$db->rollbackTransaction();
			return FALSE;
		}
		return TRUE;
	}
	
	public function preparaPagina($db, $utility, $preventivoTemplate) {
				
		$preventivoTemplate->setAzioneDentiSingoli(self::$azioneDentiSingoli);
		$preventivoTemplate->setAzioneGruppi(self::$azioneGruppi);
		$preventivoTemplate->setAzioneCure(self::$azioneCure);
		$preventivoTemplate->setAzionePagamento(self::$azionePagamento);
		
		$preventivoTemplate->setConfermaTip("%ml.confermaModificaPreventivo%");
		$preventivoTemplate->setGruppiTip("%ml.creaGruppi%");
		$preventivoTemplate->setCureTip("%ml.creaCure%");

		if ($_SESSION['idPreventivo'] != "") {			
			$preventivoTemplate->setTitoloPagina("%ml.modificaPreventivoPrincipaleDentiSingoli%");			
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {			
			$preventivoTemplate->setTitoloPagina("%ml.modificaPreventivoSecondarioDentiSingoli%");
		}

		$preventivoTemplate->impostaVoci($db, $utility);
		$preventivoTemplate->calcolaTotalePreventivo($db);
		
		$preventivoTemplate->setPreventivoLabel("Preventivo:");
		$preventivoTemplate->setTotalePreventivoLabel("Totale Singoli:");		
	}
}

?>