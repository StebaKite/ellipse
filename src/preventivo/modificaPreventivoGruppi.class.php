<?php

require_once 'preventivo.abstract.class.php';

class modificaPreventivoGruppi extends preventivoAbstract {

	private static $gruppiForm = "gruppi";
	public static $azioneGruppi = "../preventivo/modificaPreventivoGruppiFacade.class.php?modo=go";
	public static $azioneDentiSingoli = "../preventivo/modificaPreventivoFacade.class.php?modo=start";
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

	// ------------------------------------------------

	public function start() {

		require_once 'modificaPreventivoGruppi.template.php';
		require_once 'database.class.php';
		
		error_log("<<<<<<< Start >>>>>>> " . $_SERVER['PHP_SELF']);

		$db = new database();
		
		$db->beginTransaction();
		
		$modificaPreventivoGruppiTemplate = new modificaPreventivoGruppiTemplate();
		$this->preparaPagina($db, $modificaPreventivoGruppiTemplate);
		
		$db->commitTransaction();
		
		// Compone la pagina
		include(self::$testata);
		$modificaPreventivoGruppiTemplate->displayPagina();
		include(self::$piede);
	}

	public function go() {
	
		require_once 'modificaPreventivoGruppi.template.php';
		require_once 'utility.class.php';
		require_once 'database.class.php';
		
		error_log("<<<<<<< Go >>>>>>> " . $_SERVER['PHP_SELF']);

		$utility = new utility();
		$db = new database();
		
		$db->beginTransaction();
		
		$modificaPreventivoGruppiTemplate = new modificaPreventivoGruppiTemplate();
		$this->preparaPagina($db, $modificaPreventivoGruppiTemplate);
		
		$db->commitTransaction();

		$_SESSION['vocegruppo_1'] = $_POST['voceGruppo_1'];
		$_SESSION['dentigruppo_1'] = $this->prelevaCampiFormGruppo_1();
		
		$_SESSION['vocegruppo_2'] = $_POST['voceGruppo_2'];
		$_SESSION['dentigruppo_2'] = $this->prelevaCampiFormGruppo_2();
		
		$_SESSION['vocegruppo_3'] = $_POST['voceGruppo_3'];
		$_SESSION['dentigruppo_3'] = $this->prelevaCampiFormGruppo_3();
		
		$_SESSION['vocegruppo_4'] = $_POST['voceGruppo_4'];
		$_SESSION['dentigruppo_4'] = $this->prelevaCampiFormGruppo_4();

		include(self::$testata);
		
		if ($this->modificaGruppi($modificaPreventivoGruppiTemplate)) {
		
			$modificaPreventivoGruppiTemplate->displayPagina();
			$replace = array('%messaggio%' => '%ml.modificaPreventivoOk%');
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioInfo), $replace);
			echo $utility->tailTemplate($template);
		}
		else {
			$modificaPreventivoGruppiTemplate->displayPagina();
			$replace = array('%messaggio%' => '%ml.modificaPreventivoKo%');
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
			echo $utility->tailTemplate($template);
		}		
		include(self::$piede);
	}

	private function modificaGruppi($modificaPreventivoGruppiTemplate) {
	
		if ($_SESSION['idPreventivo'] != "") {
			return $this->modificaGruppiPreventivoPrincipale($modificaPreventivoGruppiTemplate);
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {
			return $this->modificaGruppiPreventivoSecondario($modificaPreventivoGruppiTemplate);
		}
	}
	
	private function modificaGruppiPreventivoPrincipale($modificaPreventivoGruppiTemplate) {
	
		require_once 'database.class.php';
	
		$db = new database();
		$db->beginTransaction();
	
		if ($this->modificaVociGruppoPreventivoPrincipale($db, 'voceGruppo_1', $_SESSION['vocegruppo_1'], $_SESSION['dentigruppo_1'], $_SESSION['idPreventivo'], self::$gruppiForm, $_SESSION['stato'])) {
			if ($this->modificaVociGruppoPreventivoPrincipale($db, 'voceGruppo_2', $_SESSION['vocegruppo_2'], $_SESSION['dentigruppo_2'], $_SESSION['idPreventivo'], self::$gruppiForm, $_SESSION['stato'])) {
				if ($this->modificaVociGruppoPreventivoPrincipale($db, 'voceGruppo_3', $_SESSION['vocegruppo_3'], $_SESSION['dentigruppo_3'], $_SESSION['idPreventivo'], self::$gruppiForm, $_SESSION['stato'])) {
					if ($this->modificaVociGruppoPreventivoPrincipale($db, 'voceGruppo_4', $_SESSION['vocegruppo_4'], $_SESSION['dentigruppo_4'], $_SESSION['idPreventivo'], self::$gruppiForm, $_SESSION['stato'])) {
	
						// aggiorno la datamodifica del "preventivo" prima di consolidare gli aggiornamenti
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
				}
			}
		}
		return FALSE;
	}

	private function modificaGruppiPreventivoSecondario($modificaPreventivoGruppiTemplate) {
	
		require_once 'database.class.php';
	
		$db = new database();
		$db->beginTransaction();
	
		if ($this->modificaVociGruppoPreventivoSecondario($db, 'voceGruppo_1', $_SESSION['vocegruppo_1'], $_SESSION['dentigruppo_1'], $_SESSION['idPreventivo'], $_SESSION['idSottoPreventivo'], self::$gruppiForm, $_SESSION['stato'])) {
			if ($this->modificaVociGruppoPreventivoSecondario($db, 'voceGruppo_2', $_SESSION['vocegruppo_2'], $_SESSION['dentigruppo_2'], $_SESSION['idPreventivo'], $_SESSION['idSottoPreventivo'], self::$gruppiForm, $_SESSION['stato'])) {
				if ($this->modificaVociGruppoPreventivoSecondario($db, 'voceGruppo_3', $_SESSION['vocegruppo_3'], $_SESSION['dentigruppo_3'], $_SESSION['idPreventivo'], $_SESSION['idSottoPreventivo'], self::$gruppiForm, $_SESSION['stato'])) {
					if ($this->modificaVociGruppoPreventivoSecondario($db, 'voceGruppo_4', $_SESSION['vocegruppo_4'], $_SESSION['dentigruppo_4'], $_SESSION['idPreventivo'], $_SESSION['idSottoPreventivo'], self::$gruppiForm, $_SESSION['stato'])) {
	
						// aggiorno la datamodifica del "sottopreventivo" prima di consolidare gli aggiornamenti
						if (!$this->aggiornaSottoPreventivo($db, $_SESSION['idSottoPreventivo'])) {
							error_log("Fallito aggiornamento preventivo : " . $_SESSION['idSottoPreventivo']);
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
				}
			}
		}
		return FALSE;
	}
	
	public function modificaVociGruppoPreventivoPrincipale($db, $nomeCampoForm, $voceGruppo, $dentiGruppo, $idPreventivo, $nomeForm, $stato) {
	
		foreach($dentiGruppo as $row) {
	
			// cerco il nomecampo sulla tabella vocepreventivo
			$idVoce = $this->leggiVocePreventivo($db, $idPreventivo, $nomeCampoForm . ";" . trim($row[0]), $nomeForm);
	
			// se il nomecampo esiste in tabella "vocepreventivo" e il campo è ON in pagina
			if ($idVoce != "" and $row[1] == "on") {
				if (!$this->aggiornaVocePreventivo($db, $idVoce, $voceGruppo)) {
					error_log("Fallito aggiornamento idvoce : " . $idVoce);
					$db->rollbackTransaction();
					return FALSE;
				}
			}
		// se il nomecampo esiste in tabella "vocepreventivo" e il campo non è ON in pagina
			elseif ($idVoce != "" and $row[1] != "on") {

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
			// se il nomecampo non esiste in tabella "vocepreventivo" e il campo è ON in pagina
			elseif ($idVoce == "" and $row[1] == "on") {
				if (!$this->creaVocePreventivo($db, $idPreventivo, self::$gruppiForm, $nomeCampoForm . ";" . trim($row[0]), $voceGruppo)) {
					error_log("Fallita creazione voce per la visita : " . $idPreventivoUsato);
					$db->rollbackTransaction();
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	public function modificaVociGruppoPreventivoSecondario($db, $nomeCampoForm, $voceGruppo, $dentiGruppo, $idPreventivo, $idSottoPreventivo, $nomeForm, $stato) {
	
		foreach($dentiGruppo as $row) {
	
			// cerco il nomecampo sulla tabella vocesottopreventivo
			$idVoce = $this->leggiVoceSottoPreventivo($db, $idSottoPreventivo, $nomeCampoForm . ";" . trim($row[0]), $nomeForm);
	
			// se il nomecampo esiste in tabella "vocesottopreventivo" e il campo è ON in pagina
			if ($idVoce != "" and $row[1] == "on") {
				if (!$this->aggiornaVoceSottoPreventivo($db, $idVoce, $voceGruppo)) {
					error_log("Fallito aggiornamento idvoce : " . $idVoce);
					$db->rollbackTransaction();
					return FALSE;
				}
			}
			// se il nomecampo esiste in tabella "vocesottopreventivo" e il campo non è ON in pagina
			elseif ($idVoce != "" and $row[1] != "on") {

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
			// se il nomecampo non esiste in tabella "vocepreventivo" e il campo è ON in pagina
			elseif ($idVoce == "" and $row[1] == "on") {
				if (!$this->creaVoceSottoPreventivo($db, $idSottoPreventivo, self::$gruppiForm, $nomeCampoForm . ";" . $row[0], $voceGruppo)) {
					error_log("Fallita creazione voce per la visita : " . $idPreventivoUsato);
					$db->rollbackTransaction();
					return FALSE;
				}
			}
		}
		return TRUE;
	}
	
	public function preparaPagina($db, $modificaPreventivoGruppiTemplate) {

		require_once 'database.class.php';
		require_once 'utility.class.php';
		
		$modificaPreventivoGruppiTemplate->setAzioneDentiSingoli(self::$azioneDentiSingoli);
		$modificaPreventivoGruppiTemplate->setAzioneGruppi(self::$azioneGruppi);
		$modificaPreventivoGruppiTemplate->setAzioneCure(self::$azioneCure);
		$modificaPreventivoGruppiTemplate->setAzionePagamento(self::$azionePagamento);
		
		$modificaPreventivoGruppiTemplate->setConfermaTip("%ml.confermaModificaPreventivo%");
		$modificaPreventivoGruppiTemplate->setSingoliTip("%ml.modificaSingoli%");
		$modificaPreventivoGruppiTemplate->setCureTip("%ml.modificaCure%");

		$modificaPreventivoGruppiTemplate->setPreventivoLabel("Preventivo");
		$modificaPreventivoGruppiTemplate->setTotalePreventivoLabel("Totale Gruppi:");
		
		// Prelevo i nomi dei combo che hanno voci valorizzate ----------------------------		

		if ($_SESSION['idPreventivo'] != "") {
			$modificaPreventivoGruppiTemplate->setTitoloPagina("%ml.modificaPreventivoPrincipaleGruppi%");
			$rows = $this->preparaVociSelezionateGruppiPreventivoPrincipale($modificaPreventivoGruppiTemplate);
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {
			$modificaPreventivoGruppiTemplate->setTitoloPagina("%ml.modificaPreventivoSecondarioGruppi%");
			$rows = $this->preparaVociSelezionateGruppiPreventivoSecondario($modificaPreventivoGruppiTemplate);
		}
		
		// imposto le voci selezionate per i quattro gruppi
		
		unset($_SESSION['vocegruppo_1']);
		unset($_SESSION['vocegruppo_2']);
		unset($_SESSION['vocegruppo_3']);
		unset($_SESSION['vocegruppo_4']);
		
		foreach ($rows as $row) {
		
			if (trim($row['nomecomboform']) == 'voceGruppo_1') {
				$_SESSION['vocegruppo_1'] = $row['codicevocelistino'];
			}
			elseif (trim($row['nomecomboform']) == 'voceGruppo_2') {
				$_SESSION['vocegruppo_2'] = $row['codicevocelistino'];
			}
			elseif (trim($row['nomecomboform']) == 'voceGruppo_3') {
				$_SESSION['vocegruppo_3'] = $row['codicevocelistino'];
			}
			elseif (trim($row['nomecomboform']) == 'voceGruppo_4') {
				$_SESSION['vocegruppo_4'] = $row['codicevocelistino'];
			}
		}
	}
	
	public function preparaVociSelezionateGruppiPreventivoPrincipale($modificaPreventivoGruppiTemplate) {
		
		$utility = new utility();
		$array = $utility->getConfig();
		
		$db = new database();
		
		$replace = array(
				'%idpaziente%' => $_SESSION['idPaziente'],
				'%idpreventivo%' => $_SESSION['idPreventivo']
		);
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryComboPreventivoPrincipaleGruppiPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
		
		return pg_fetch_all($result);		
	}
	
	public function preparaVociSelezionateGruppiPreventivoSecondario($modificaPreventivoGruppiTemplate) {
		
		$utility = new utility();
		$array = $utility->getConfig();
		
		$db = new database();
		
		$replace = array(
				'%idpaziente%' => $_SESSION['idPaziente'],
				'%idsottopreventivo%' => $_SESSION['idSottoPreventivo']
		);
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryComboPreventivoSecondarioGruppiPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
		
		return pg_fetch_all($result);		
	}
}

?>