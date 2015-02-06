<?php

require_once 'visitaPaziente.abstract.class.php';

class modificaVisitaGruppi extends visitaPazienteAbstract {
	
	private static $gruppiForm = "gruppi";
	public static $azioneGruppi = "../paziente/modificaVisitaGruppiFacade.class.php?modo=go";
	public static $azioneDentiSingoli = "../paziente/modificaVisitaFacade.class.php?modo=start";
	public static $azioneCure = "../paziente/modificaVisitaCureFacade.class.php?modo=start";

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

		require_once 'modificaVisitaGruppi.template.php';
		require_once 'utility.class.php';

		error_log("<<<<<<< Start >>>>>>> " . $_SERVER['PHP_SELF']);
		
		// Template
		$utility = new utility();

		$visitaGruppi = new visitaGruppi();		
		$this->preparaPagina($visitaGruppi);

		// Compone la pagina
		include(self::$testata);
		$visitaGruppi->inizializzaGruppiPagina();
		$visitaGruppi->displayPagina();
		include(self::$piede);		
	}
		
	public function go() {
		
		require_once 'modificaVisitaGruppi.template.php';
		require_once 'utility.class.php';

		error_log("<<<<<<< Go >>>>>>> " . $_SERVER['PHP_SELF']);

		$utility = new utility();
		$visitaGruppi = new visitaGruppi();
		$this->preparaPagina($visitaGruppi);
		
		$visitaGruppi->setVoceGruppo_1($_POST['voceGruppo_1']);
		$visitaGruppi->setDentiGruppo_1($this->prelevaCampiFormGruppo_1());
		
		$visitaGruppi->setVoceGruppo_2($_POST['voceGruppo_2']);
		$visitaGruppi->setDentiGruppo_2($this->prelevaCampiFormGruppo_2());
		
		$visitaGruppi->setVoceGruppo_3($_POST['voceGruppo_3']);
		$visitaGruppi->setDentiGruppo_3($this->prelevaCampiFormGruppo_3());
		
		$visitaGruppi->setVoceGruppo_4($_POST['voceGruppo_4']);
		$visitaGruppi->setDentiGruppo_4($this->prelevaCampiFormGruppo_4());
		
		include(self::$testata);

		if ($this->modificaGruppi($visitaGruppi)) {

			$visitaGruppi->displayPagina();
			$replace = array('%messaggio%' => '%ml.modificaVisitaOk%');				
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioInfo), $replace);			
			echo $utility->tailTemplate($template);
		}
		else {
			$visitaGruppi->displayPagina();
			$replace = array('%messaggio%' => '%ml.modificaVisitaKo%');				
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);			
			echo $utility->tailTemplate($template);
		}

		include(self::$piede);		
 
	}

	private function modificaGruppi($visitaGruppi) {
	
		require_once 'database.class.php';

		$db = new database();
		$db->beginTransaction();

		$visitaGruppi->setIdPaziente($this->getIdPaziente());

		if ($this->modificaVociGruppo($db, 'voceGruppo_1', $visitaGruppi->getVoceGruppo_1(), $visitaGruppi->getDentiGruppo_1(), $visitaGruppi->getIdVisita(), self::$gruppiForm)) {		
			if ($this->modificaVociGruppo($db, 'voceGruppo_2', $visitaGruppi->getVoceGruppo_2(), $visitaGruppi->getDentiGruppo_2(), $visitaGruppi->getIdVisita(), self::$gruppiForm)) {
				if ($this->modificaVociGruppo($db, 'voceGruppo_3', $visitaGruppi->getVoceGruppo_3(), $visitaGruppi->getDentiGruppo_3(), $visitaGruppi->getIdVisita(), self::$gruppiForm)) {
					if ($this->modificaVociGruppo($db, 'voceGruppo_4', $visitaGruppi->getVoceGruppo_4(), $visitaGruppi->getDentiGruppo_4(), $visitaGruppi->getIdVisita(), self::$gruppiForm)) {

						// aggiorno la datamodifica della "visita" prima di consolidare gli aggiornamenti
						if (!$this->aggiornaVisita($db, $visitaGruppi->getIdVisita())) {
							error_log("Fallito aggiornamento visita : " . $idVisitaUsato);
							$db->rollbackTransaction();
							return FALSE;
						}

						// aggiorno la datamodifica del "paziente"
						if (!$this->aggiornaPaziente($db, $visitaGruppi->getIdPaziente())) {
							error_log("Fallito aggiornamento paziente : " . $visitaGruppi->getIdPaziente());
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
	
	public function modificaVociGruppo($db, $nomeCampoForm, $voceGruppo, $dentiGruppo, $idVisitaUsato, $nomeForm) {

		foreach($dentiGruppo as $row) {

			// cerco il nomecampo sulla tabella vocevisita			
			$idVoce = $this->leggiVoceVisita($db, $idVisitaUsato, $nomeCampoForm . ";" . trim($row[0]), $nomeForm);

			// se il nomecampo esiste in tabella "vocevisita" e il campo è ON in pagina
			if ($idVoce != "" and $row[1] == "on") {
				if (!$this->aggiornaVoceVisita($db, $idVoce, $voceGruppo)) {
					error_log("Fallito aggiornamento idvoce : " . $idVoce);
					$db->rollbackTransaction();
					return FALSE;
				}
			}
			// se il nomecampo esiste in tabella "vocevisita" e il campo non è ON in pagina
			elseif ($idVoce != "" and $row[1] != "on") {
				if (!$this->cancellaVoceVisita($db, $idVoce)) {
					error_log("Fallita cancellazione idvoce : " . $idVoce);
					$db->rollbackTransaction();
					return FALSE;
				}
			}
			// se il nomecampo non esiste in tabella "vocevisita" e il campo è ON in pagina
			elseif ($idVoce == "" and $row[1] == "on") {
				if (!$this->creaVoceVisita($db, $idVisitaUsato, self::$gruppiForm, $nomeCampoForm . ";" . trim($row[0]), $voceGruppo)) {
					error_log("Fallita creazione voce per la visita : " . $idVisitaUsato);
					$db->rollbackTransaction();
					return FALSE;
				}
			}
		}
		return TRUE;
	}	
	

	public function preparaPagina($visitaGruppi) {
	
		require_once 'database.class.php';
		require_once 'utility.class.php';
	
		$visitaGruppi->setAzioneDentiSingoli(self::$azioneDentiSingoli);
		$visitaGruppi->setAzioneGruppi(self::$azioneGruppi);
		$visitaGruppi->setAzioneCure(self::$azioneCure);
		
		$visitaGruppi->setConfermaTip("%ml.confermaModificaVisita%");
		$visitaGruppi->setSingoliTip("%ml.modificaSingoli%");
		$visitaGruppi->setCureTip("%ml.modificaCure%");
		
		$visitaGruppi->setTitoloPagina("%ml.modificaVisitaGruppi%");
		$visitaGruppi->setVisitaLabel("- %ml.visita% : ");

		// Prelevo i nomi dei combo che hanno voci valorizzate ----------------------------

		$rows = $this->preparaVociSelezionateGruppiVisita($visitaGruppi);
		
		// imposto le voci selezionate per i quattro gruppi
		
		foreach ($rows as $row) {
		
			if (trim($row['nomecomboform']) == 'voceGruppo_1') {
				$visitaGruppi->setVoceGruppo_1($row['codicevocelistino']);
			}
			elseif (trim($row['nomecomboform']) == 'voceGruppo_2') {
				$visitaGruppi->setVoceGruppo_2($row['codicevocelistino']);
			}
			elseif (trim($row['nomecomboform']) == 'voceGruppo_3') {
				$visitaGruppi->setVoceGruppo_3($row['codicevocelistino']);
			}
			elseif (trim($row['nomecomboform']) == 'voceGruppo_4') {
				$visitaGruppi->setVoceGruppo_4($row['codicevocelistino']);
			}
		}
	}

	public function preparaVociSelezionateGruppiVisita($visitaGruppi) {
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$db = new database();
	
		$replace = array(
				'%idpaziente%' => $visitaGruppi->getIdPaziente(),
				'%idvisita%' => $visitaGruppi->getIdVisita()
		);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryComboVisitaGruppiPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
	
		return pg_fetch_all($result);
	}
}

?>
