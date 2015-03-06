<?php

require_once 'visita.abstract.class.php';

class creaVisitaCure extends visitaAbstract {

	public static $cureForm = "cure";
	public static $azioneCure = "../visita/creaVisitaCureFacade.class.php?modo=go";
	public static $azioneDentiSingoli = "../visita/creaVisitaFacade.class.php?modo=start";
	public static $azioneGruppi = "../visita/creaVisitaGruppiFacade.class.php?modo=start";

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

		require_once 'visitaCure.template.php';
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
		
		require_once 'ricercaVisita.class.php';
		require_once 'visitaCure.template.php';
		require_once 'utility.class.php';

		error_log("<<<<<<< Go >>>>>>> " . $_SERVER['PHP_SELF']);

		$visitaCure = new visitaCure();
		$this->preparaPagina($visitaCure);		
		$_SESSION['curegeneriche'] = $this->prelevaCampiFormCure();
		
		include(self::$testata);

		$utility = new utility();

		$voceSelezionata = FALSE;
		foreach ($_SESSION['curegeneriche'] as $row) {
			if ($row['1'] != "") {
				$voceSelezionata = TRUE;
				break;
			}
		}

		if ($voceSelezionata) {
			
			if ($this->inserisciCure($visitaCure)) {

				$ricercaVisita = new ricercaVisita();
				$ricercaVisita->setMessaggio("%ml.creaVisitaOk%");
				$ricercaVisita->start();
			}
			else {
				$visitaGruppi->displayPagina();
				$replace = array('%messaggio%' => '%ml.creaVisitaKo%');				
				$template = $utility->tailFile($utility->getTemplate(self::messaggioErrore), $replace);			
				echo $utility->tailTemplate($template);
			}
		}
		else {
			$ricercaVisita = new ricercaVisita();
			$ricercaVisita->start();
		}

		include(self::$piede);		
	}

	public function preparaPagina($visitaCure) {
	
		$visitaCure->setAzioneDentiSingoli(self::$azioneDentiSingoli);
		$visitaCure->setAzioneGruppi(self::$azioneGruppi);
		$visitaCure->setAzioneCure(self::$azioneCure);
		$visitaCure->setConfermaTip('%ml.confermaCreazioneVisita%');
		$visitaCure->setGruppiTip('%ml.creaGruppi%');
		$visitaCure->setSingoliTip('%ml.creaSingoli%');
		$visitaCure->setTitoloPagina('%ml.creaNuovaVisitaCure%');
	}
	
	private function inserisciCure($visitaCure) {

		require_once 'database.class.php';

		$db = new database();
		$db->beginTransaction();

		/*
		 * Una riga in "visita" e tutte le voci in tabella "voceVisita"
		 */ 

		if ($this->creaVisita($db)) {

			$_SESSION['idVisita'] = $db->getLastIdUsed(); 
				
			foreach($_SESSION['curegeneriche'] as $row) {

				if ($row[1] != "") {
					if (!$this->creaVoceVisita($db, $_SESSION['idVisita'], self::$cureForm, trim($row[0]), trim($row[1]))) {
						$db->rollbackTransaction();
						return FALSE;	
					}
				}			
			}
			$db->commitTransaction();
			return TRUE;				
		}		
		return FALSE;
	}
}

?>
