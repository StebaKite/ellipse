<?php

require_once 'visita.abstract.class.php';

class modificaVisitaCure extends visitaAbstract {
	
	private static $cureForm = "cure";
	public static $azioneCure = "../visita/modificaVisitaCureFacade.class.php?modo=go";
	public static $azioneGruppi = "../visita/modificaVisitaGruppiFacade.class.php?modo=start";
	public static $azioneDentiSingoli = "../visita/modificaVisitaFacade.class.php?modo=start";

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

		require_once 'modificaVisitaCure.template.php';
		require_once 'utility.class.php';

		error_log("<<<<<<< Start >>>>>>> " . $_SERVER['PHP_SELF']);

		$visitaCure = new visitaCure();
		$this->preparaPagina($visitaCure);		
		
		// Compone la pagina
		include(self::$testata);
		$visitaCure->inizializzaCurePagina();		
		$visitaCure->displayPagina();
		include(self::$piede);		
	}

	public function go() {
				
		require_once 'modificaVisitaCure.template.php';
		require_once 'utility.class.php';

		error_log("<<<<<<< Go >>>>>>> " . $_SERVER['PHP_SELF']);

		$visitaCure = new visitaCure();
		$this->preparaPagina($visitaCure);		
		$_SESSION['curegeneriche'] = $this->prelevaCampiFormCure();

		include(self::$testata);
		
		$utility = new utility();
			
		if ($this->modificaCure($visitaCure)) {

			$visitaCure->displayPagina();
			$replace = array('%messaggio%' => '%ml.modificaVisitaOk%');				
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioInfo), $replace);			
			echo $utility->tailTemplate($template);
		}
		else {
			$visitaCure->displayPagina();
			$replace = array('%messaggio%' => '%ml.modificaVisitaKo%');				
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);			
			echo $utility->tailTemplate($template);
		}
		include(self::$piede);		
	}

	public function modificaCure($visitaCure) {
	
		require_once 'database.class.php';

		$db = new database();
		$db->beginTransaction();

		if ($this->modificaVociCure($db, $_SESSION['curegeneriche'], $_SESSION['idVisita'], self::$cureForm)) {

			// aggiorno la datamodifica della "visita"
			if (!$this->aggiornaVisita($db, $_SESSION['idVisita'])) {
				error_log("Fallito aggiornamento visita : " . $_SESSION['idVisita']);
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
		
	public function modificaVociCure($db, $cureGeneriche, $idVisitaUsato, $nomeForm) {
		
		foreach($cureGeneriche as $row) {

			// cerco il nomecampo sulla tabella vocevisita			
			$idVoce = $this->leggiVoceVisita($db, $idVisitaUsato, trim($row[0]), $nomeForm);

			// se il nomecampo esiste in tabella "vocevisita" e il combo è selezionato in pagina
			if ($idVoce != "" and $row[1] != "") {
				if (!$this->aggiornaVoceVisita($db, $idVoce, $row[1])) {
					error_log("Fallito aggiornamento idvoce : " . $idVoce);
					$db->rollbackTransaction();
					return FALSE;
				}
			}
			// se il nomecampo esiste in tabella "vocevisita" e il campo non è selezionato in pagina
			elseif ($idVoce != "" and $row[1] == "") {
				if (!$this->cancellaVoceVisita($db, $idVoce)) {
					error_log("Fallita cancellazione idvoce : " . $idVoce);
					$db->rollbackTransaction();
					return FALSE;
				}
			}
			// se il nomecampo non esiste in tabella "vocevisita" e il campo è selezionato in pagina
			elseif ($idVoce == "" and $row[1] != "") {
				if (!$this->creaVoceVisita($db, $idVisitaUsato, self::$cureForm, $row[0], $row[1])) {
					error_log("Fallita creazione voce per la visita : " . $idVisitaUsato);
					$db->rollbackTransaction();
					return FALSE;
				}
			}
		}
		return TRUE;	
	}

	public function preparaPagina($visitaCure) {
								
		$visitaCure->setAzioneDentiSingoli(self::$azioneDentiSingoli);
		$visitaCure->setAzioneGruppi(self::$azioneGruppi);
		$visitaCure->setAzioneCure(self::$azioneCure);
		
		$visitaCure->setConfermaTip("%ml.confermaModificaVisita%");		
		$visitaCure->setSingoliTip("%ml.modificaSingoli%");		
		$visitaCure->setCureTip("%ml.modificaGruppi%");		
				
		$visitaCure->setTitoloPagina("%ml.modificaVisitaCure%");
		$visitaCure->setVisitaLabel("- %ml.visita% : ");
	}
}

?>
