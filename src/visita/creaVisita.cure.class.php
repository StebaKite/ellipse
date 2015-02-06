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

	// -------------------------------------------------
	
	public function getCureForm() {
		return self::$cureForm;
	}

	// ------------------------------------------------

	public function start() {

		require_once 'visitaCure.template.php';
		require_once 'utility.class.php';

		error_log("<<<<<<< Start >>>>>>> " . $_SERVER['PHP_SELF']);

		$visitaCure = new visitaCure();
		$visitaCure->setVisitaCure($this->preparaPagina($visitaCure));		

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
		$visitaCure->setVisitaCure($this->preparaPagina($visitaCure));		
		$visitaCure->setCureGeneriche($this->prelevaCampiFormCure());
		
		include(self::$testata);

		$utility = new utility();

		$voceSelezionata = FALSE;
		foreach ($visitaCure->getCureGeneriche() as $row) {
			if ($row['1'] != "") {
				$voceSelezionata = TRUE;
				break;
			}
		}

		if ($voceSelezionata) {
			
			if ($this->inserisciCure($visitaCure)) {

				$ricercaVisita = new ricercaVisita();
				$ricercaVisita->setIdPaziente($this->getIdPaziente());
				$ricercaVisita->setIdListino($this->getIdListino());
				$ricercaVisita->setMessaggio("%ml.creaVisitaOk%");
				$ricercaVisita->setCognomeRicerca($this->getCognomeRicerca());
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
			$ricercaVisita->setIdPaziente($this->getIdPaziente());
			$ricercaVisita->setIdListino($this->getIdListino());
			$ricercaVisita->setCognomeRicerca($this->getCognomeRicerca());
			$ricercaVisita->start();
		}

		include(self::$piede);		
	}
				
	private function inserisciCure($visitaCure) {

		require_once 'database.class.php';

		$db = new database();
		$db->beginTransaction();

		/*
		 * Una riga in "visita" e tutte le voci in tabella "voceVisita"
		 */ 

		if ($this->creaVisita($db)) {

			$vociGeneriche = $visitaCure->getCureGeneriche();
			$idVisitaUsato = $db->getLastIdUsed(); 
			$visitaCure->setIdVisita($idVisitaUsato);
			$this->setIdVisita($idVisitaUsato);
			$visitaCure->setIdPaziente($this->getIdPaziente());
				
			foreach($vociGeneriche as $row) {

				if ($row[1] != "") {
					if (!$this->creaVoceVisita($db, $idVisitaUsato, $this->getCureForm(), trim($row[0]), trim($row[1]))) {
						$db->rollbackTransaction();
						error_log("Errore inserimento voce, eseguito Rollback");
						return FALSE;	
					}
				}			
			}
			$db->commitTransaction();
			return TRUE;				
		}		
		return FALSE;
	}

	public function preparaPagina($visitaCure) {

		$visitaCure->setIdPaziente($this->getIdPaziente());
		$visitaCure->setIdListino($this->getIdListino());
		$visitaCure->setIdVisita($this->getIdVisita());

		$visitaCure->setAzioneDentiSingoli(self::$azioneDentiSingoli);
		$visitaCure->setAzioneGruppi(self::$azioneGruppi);
		$visitaCure->setAzioneCure(self::$azioneCure);
		
		$visitaCure->setConfermaTip('%ml.confermaCreazioneVisita%');		
		$visitaCure->setGruppiTip('%ml.creaGruppi%');		
		$visitaCure->setSingoliTip('%ml.creaSingoli%');		
				
		$visitaCure->setTitoloPagina('%ml.creaNuovaVisitaCure%');
		$visitaCure->setVisitaCure($visitaCure);		

		return $visitaCure;
	}	
}

?>
