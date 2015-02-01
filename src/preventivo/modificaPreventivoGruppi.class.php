<?php

require_once 'preventivo.abstract.class.php';

class modificaPreventivoGruppi extends preventivoAbstract {

	private static $gruppiForm = "gruppi";
	public static $azioneGruppi = "../paziente/modificaPreventivoGruppiFacade.class.php?modo=go";
	public static $azioneDentiSingoli = "../paziente/modificaPreventivoFacade.class.php?modo=start";
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

	// ------------------------------------------------

	public function start() {

		require_once 'modificaPreventivoGruppi.template.php';
		require_once 'utility.class.php';

		error_log("<<<<<<< Start >>>>>>> " . $_SERVER['PHP_SELF']);

		$modificaPreventivoGruppiTemplate = new modificaPreventivoGruppiTemplate();
		$this->preparaPagina($modificaPreventivoGruppiTemplate);
		
		// Compone la pagina
		include(self::$testata);
		$modificaPreventivoGruppiTemplate->displayPagina();
		include(self::$piede);
	}

	public function go() {
	
		require_once 'modificaPreventivoGruppi.template.php';
		require_once 'utility.class.php';
	
		error_log("<<<<<<< Go >>>>>>> " . $_SERVER['PHP_SELF']);

		$utility = new utility();
		
		$modificaPreventivoGruppiTemplate = new modificaPreventivoGruppiTemplate();
		$this->preparaPagina($modificaPreventivoGruppiTemplate);
		
		$modificaPreventivoGruppiTemplate->setVoceGruppo_1($_POST['voceGruppo_1']);
		$modificaPreventivoGruppiTemplate->setDentiGruppo_1($this->prelevaCampiFormGruppo_1());
		
		$modificaPreventivoGruppiTemplate->setVoceGruppo_2($_POST['voceGruppo_2']);
		$modificaPreventivoGruppiTemplate->setDentiGruppo_2($this->prelevaCampiFormGruppo_2());
		
		$modificaPreventivoGruppiTemplate->setVoceGruppo_3($_POST['voceGruppo_3']);
		$modificaPreventivoGruppiTemplate->setDentiGruppo_3($this->prelevaCampiFormGruppo_3());
		
		$modificaPreventivoGruppiTemplate->setVoceGruppo_4($_POST['voceGruppo_4']);
		$modificaPreventivoGruppiTemplate->setDentiGruppo_4($this->prelevaCampiFormGruppo_4());

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
	
		if ($modificaPreventivoGruppiTemplate->getIdPreventivo() != "") {
			return $this->modificaGruppiPreventivoPrincipale($modificaPreventivoGruppiTemplate);
		}
		elseif ($modificaPreventivoGruppiTemplate->getIdSottoPreventivo() != "") {
			return $this->modificaGruppiPreventivoSecondario($modificaPreventivoGruppiTemplate);
		}
	}
	
	private function modificaGruppiPreventivoPrincipale($modificaPreventivoGruppiTemplate) {
	
		require_once 'database.class.php';
	
		$db = new database();
		$db->beginTransaction();
	
		if ($this->modificaVociGruppoPreventivoPrincipale($db, 'voceGruppo_1', $modificaPreventivoGruppiTemplate->getVoceGruppo_1(), $modificaPreventivoGruppiTemplate->getDentiGruppo_1(), $modificaPreventivoGruppiTemplate->getIdPreventivo(), self::$gruppiForm)) {
			if ($this->modificaVociGruppoPreventivoPrincipale($db, 'voceGruppo_2', $modificaPreventivoGruppiTemplate->getVoceGruppo_2(), $modificaPreventivoGruppiTemplate->getDentiGruppo_2(), $modificaPreventivoGruppiTemplate->getIdPreventivo(), self::$gruppiForm)) {
				if ($this->modificaVociGruppoPreventivoPrincipale($db, 'voceGruppo_3', $modificaPreventivoGruppiTemplate->getVoceGruppo_3(), $modificaPreventivoGruppiTemplate->getDentiGruppo_3(), $modificaPreventivoGruppiTemplate->getIdPreventivo(), self::$gruppiForm)) {
					if ($this->modificaVociGruppoPreventivoPrincipale($db, 'voceGruppo_4', $modificaPreventivoGruppiTemplate->getVoceGruppo_4(), $modificaPreventivoGruppiTemplate->getDentiGruppo_4(), $modificaPreventivoGruppiTemplate->getIdPreventivo(), self::$gruppiForm)) {
	
						// aggiorno la datamodifica del "preventivo" prima di consolidare gli aggiornamenti
						if (!$this->aggiornaPreventivo($db, $modificaPreventivoGruppiTemplate->getIdPreventivo())) {
							error_log("Fallito aggiornamento preventivo : " . $modificaPreventivoGruppiTemplate->getIdPreventivo());
							$db->rollbackTransaction();
							return FALSE;
						}
	
						// aggiorno la datamodifica del "paziente"
						if (!$this->aggiornaPaziente($db, $modificaPreventivoGruppiTemplate->getIdPaziente())) {
							error_log("Fallito aggiornamento paziente : " . $modificaPreventivoGruppiTemplate->getIdPaziente());
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
	
		if ($this->modificaVociGruppoPreventivoSecondario($db, 'voceGruppo_1', $modificaPreventivoGruppiTemplate->getVoceGruppo_1(), $modificaPreventivoGruppiTemplate->getDentiGruppo_1(), $modificaPreventivoGruppiTemplate->getIdPreventivo(), $modificaPreventivoGruppiTemplate->getIdSottoPreventivo(), self::$gruppiForm)) {
			if ($this->modificaVociGruppoPreventivoSecondario($db, 'voceGruppo_2', $modificaPreventivoGruppiTemplate->getVoceGruppo_2(), $modificaPreventivoGruppiTemplate->getDentiGruppo_2(), $modificaPreventivoGruppiTemplate->getIdPreventivo(), $modificaPreventivoGruppiTemplate->getIdSottoPreventivo(), self::$gruppiForm)) {
				if ($this->modificaVociGruppoPreventivoSecondario($db, 'voceGruppo_3', $modificaPreventivoGruppiTemplate->getVoceGruppo_3(), $modificaPreventivoGruppiTemplate->getDentiGruppo_3(), $modificaPreventivoGruppiTemplate->getIdPreventivo(), $modificaPreventivoGruppiTemplate->getIdSottoPreventivo(), self::$gruppiForm)) {
					if ($this->modificaVociGruppoPreventivoSecondario($db, 'voceGruppo_4', $modificaPreventivoGruppiTemplate->getVoceGruppo_4(), $modificaPreventivoGruppiTemplate->getDentiGruppo_4(), $modificaPreventivoGruppiTemplate->getIdPreventivo(), $modificaPreventivoGruppiTemplate->getIdSottoPreventivo(), self::$gruppiForm)) {
	
						// aggiorno la datamodifica del "sottopreventivo" prima di consolidare gli aggiornamenti
						if (!$this->aggiornaSottoPreventivo($db, $modificaPreventivoGruppiTemplate->getIdSottoPreventivo())) {
							error_log("Fallito aggiornamento preventivo : " . $modificaPreventivoGruppiTemplate->getIdSottoPreventivo());
							$db->rollbackTransaction();
							return FALSE;
						}
	
						// aggiorno la datamodifica del "paziente"
						if (!$this->aggiornaPaziente($db, $modificaPreventivoGruppiTemplate->getIdPaziente())) {
							error_log("Fallito aggiornamento paziente : " . $modificaPreventivoGruppiTemplate->getIdPaziente());
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
	
	public function modificaVociGruppoPreventivoPrincipale($db, $nomeCampoForm, $voceGruppo, $dentiGruppo, $idPreventivo, $nomeForm) {
	
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
				if (!$this->cancellaVocePreventivo($db, $idVoce)) {
					error_log("Fallita cancellazione idvoce : " . $idVoce);
					$db->rollbackTransaction();
					return FALSE;
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

	public function modificaVociGruppoPreventivoSecondario($db, $nomeCampoForm, $voceGruppo, $dentiGruppo, $idPreventivo, $idSottoPreventivo, $nomeForm) {
	
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
				if ($this->cancellaVoceSottoPreventivo($db, $idVoce)) {
					error_log("Fallita cancellazione idvoce : " . $idVoce);
					$db->rollbackTransaction();
					return FALSE;
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
	
	public function preparaPagina($modificaPreventivoGruppiTemplate) {

		require_once 'database.class.php';
		require_once 'utility.class.php';
		
		$modificaPreventivoGruppiTemplate->setAzioneDentiSingoli(self::$azioneDentiSingoli);
		$modificaPreventivoGruppiTemplate->setAzioneGruppi(self::$azioneGruppi);
		$modificaPreventivoGruppiTemplate->setAzioneCure(self::$azioneCure);
	
		$modificaPreventivoGruppiTemplate->setConfermaTip("%ml.confermaModificaPreventivo%");
		$modificaPreventivoGruppiTemplate->setSingoliTip("%ml.modificaSingoli%");
		$modificaPreventivoGruppiTemplate->setCureTip("%ml.modificaCure%");

		if ($this->getIdPreventivo() != "") {
			$modificaPreventivoGruppiTemplate->setTitoloPagina("%ml.modificaPreventivoPrincipaleGruppi%");
		}
		elseif ($this->getIdSottoPreventivo() != "") {
			$modificaPreventivoGruppiTemplate->setTitoloPagina("%ml.modificaPreventivoSecondarioGruppi%");
		}
		$modificaPreventivoGruppiTemplate->setPreventivoLabel("Preventivo");
		
		// Prelevo i nomi dei combo che hanno voci valorizzate ----------------------------		

		if ($modificaPreventivoGruppiTemplate->getIdPreventivo() != "") {
			$rows = $this->preparaVociSelezionateGruppiPreventivoPrincipale($modificaPreventivoGruppiTemplate);
		}
		elseif ($modificaPreventivoGruppiTemplate->getIdSottoPreventivo() != "") {
			$rows = $this->preparaVociSelezionateGruppiPreventivoSecondario($modificaPreventivoGruppiTemplate);
		}
		
		// imposto le voci selezionate per i quattro gruppi
		
		foreach ($rows as $row) {
		
			if (trim($row['nomecomboform']) == 'voceGruppo_1') {
				$modificaPreventivoGruppiTemplate->setVoceGruppo_1($row['codicevocelistino']);
			}
			elseif (trim($row['nomecomboform']) == 'voceGruppo_2') {
				$modificaPreventivoGruppiTemplate->setVoceGruppo_2($row['codicevocelistino']);
			}
			elseif (trim($row['nomecomboform']) == 'voceGruppo_3') {
				$modificaPreventivoGruppiTemplate->setVoceGruppo_3($row['codicevocelistino']);
			}
			elseif (trim($row['nomecomboform']) == 'voceGruppo_4') {
				$modificaPreventivoGruppiTemplate->setVoceGruppo_4($row['codicevocelistino']);
			}
		}
	}
	
	public function preparaVociSelezionateGruppiPreventivoPrincipale($modificaPreventivoGruppiTemplate) {
		
		$utility = new utility();
		$array = $utility->getConfig();
		
		$db = new database();
		
		$replace = array(
				'%idpaziente%' => $modificaPreventivoGruppiTemplate->getIdPaziente(),
				'%idpreventivo%' => $modificaPreventivoGruppiTemplate->getIdPreventivo()
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
				'%idpaziente%' => $modificaPreventivoGruppiTemplate->getIdPaziente(),
				'%idsottopreventivo%' => $modificaPreventivoGruppiTemplate->getIdSottoPreventivo()
		);
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryComboPreventivoSecondarioGruppiPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
		
		return pg_fetch_all($result);		
	}
}

?>