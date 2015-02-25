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
		require_once 'database.class.php';
		
		$db = new database();

		$db->beginTransaction();
		
		$preventivoTemplate = new preventivoTemplate();
		$this->preparaPagina($db, $preventivoTemplate);

		$db->commitTransaction();
		
		// Compone la pagina
		include(self::$testata);
		$preventivoTemplate->impostaVoci();
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
	
		$preventivoTemplate = new preventivoTemplate();
		$this->preparaPagina($db, $preventivoTemplate);
		$this->setDentiSingoli($this->prelevaCampiFormSingoli());
	
		include(self::$testata);
	
		if ($preventivoTemplate->controlliLogici()) {
			
			if ($this->modificaSingoli($db, $preventivoTemplate)) {
	
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

	private function modificaSingoli($db, $preventivoTemplate) {
		
		if ($preventivoTemplate->getIdPreventivo() != "") {
			return $this->modificaSingoliPreventivoPrincipale($db, $preventivoTemplate);
		}
		elseif ($preventivoTemplate->getIdSottoPreventivo() != "") {
			return $this->modificaSingoliPreventivoSecondario($db, $preventivoTemplate);			
		}
	}
		
	private function modificaSingoliPreventivoPrincipale($db, $preventivoTemplate) {

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
				
				// Se il preventivo è in stato "Proposto" la voce può essere cancellata 
				
				if ($preventivoTemplate->getStato() == "00") {
					
					if (!$this->cancellaVocePreventivo($db, $idVoce)) {
						error_log("Fallita cancellazione idvoce : " . $idVoce);
						$db->rollbackTransaction();
						return FALSE;
					}						
				}
				elseif ($preventivoTemplate->getStato() == "01") {
				
					if (!$this->aggiornaStatoVocePreventivoPrincipale($db, $idVoce, '01')) {	// voce sospesa
						error_log("Fallito cambio stato voce  : " . $idVoce);
						$db->rollbackTransaction();
						return FALSE;
					}						
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

	public function modificaSingoliPreventivoSecondario($db, $preventivoTemplate) {

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
	
	public function preparaPagina($db, $preventivoTemplate) {
				
		$preventivoTemplate->setAzioneDentiSingoli(self::$azioneDentiSingoli);
		$preventivoTemplate->setAzioneGruppi(self::$azioneGruppi);
		$preventivoTemplate->setAzioneCure(self::$azioneCure);
		$preventivoTemplate->setAzionePagamento(self::$azionePagamento);
		
		$preventivoTemplate->setConfermaTip("%ml.confermaModificaPreventivo%");
		$preventivoTemplate->setGruppiTip("%ml.creaGruppi%");
		$preventivoTemplate->setCureTip("%ml.creaCure%");

		if ($this->getIdPreventivo() != "") {
			
			$preventivoTemplate->setTitoloPagina("%ml.modificaPreventivoPrincipaleDentiSingoli%");			
			
			/**
			 * Calcolo il totale dei Gruppi del preventivo principale
			 */
			$totalePreventivoGruppi = 0;
			foreach ($this->leggiVociPreventivoPrincipale($db, $this->getIdPreventivo(), "gruppi") as $row) {
				$totalePreventivoGruppi += $row['prezzo'];
			}
			$this->setTotalePreventivoGruppi("EUR" . number_format($totalePreventivoGruppi, 2, ',', '.'));

			/**
			 * Calcolo il totale delle Cure del preventivo principale
			 */
			$totalePreventivoCure = 0;
			foreach ($this->leggiVociPreventivoPrincipale($db, $this->getIdPreventivo(), "cure") as $row) {
				$totalePreventivoCure += $row['prezzo'];
			}
			$this->setTotalePreventivoCure("EUR" . number_format($totalePreventivoCure, 2, ',', '.'));				
		}
		elseif ($this->getIdSottoPreventivo() != "") {
			
			$preventivoTemplate->setTitoloPagina("%ml.modificaPreventivoSecondarioDentiSingoli%");

			/**
			 * Calcolo il totale dei Gruppi del preventivo secondario
			 */
			$totalePreventivoGruppi = 0;
			foreach ($this->leggiVociPreventivoSecondario($db, $this->getIdSottoPreventivo(), "gruppi") as $row) {
				$totalePreventivoGruppi += $row['prezzo'];
			}
			$this->setTotalePreventivoGruppi("EUR" . number_format($totalePreventivoGruppi, 2, ',', '.'));
			
			/**
			 * Calcolo il totale delle Cure del preventivo secondario
			*/
			$totalePreventivoCure = 0;
			foreach ($this->leggiVociPreventivoSecondario($db, $this->getIdSottoPreventivo(), "cure") as $row) {
				$totalePreventivoCure += $row['prezzo'];
			}
			$this->setTotalePreventivoCure("EUR" . number_format($totalePreventivoCure, 2, ',', '.'));
		}
		
		$preventivoTemplate->setPreventivoLabel("Preventivo:");
		$preventivoTemplate->setTotalePreventivoLabel("Totale Singoli:");		
	}
}

?>