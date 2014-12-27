<?php

require_once 'visitaPaziente.abstract.class.php';

class creaVisitaCure extends visitaPazienteAbstract {

	public static $cureForm = "cure";
	public static $azioneDentiSingoli = "../paziente/creaVisitaFacade.class.php?modo=start";
	public static $azioneGruppi = "../paziente/creaVisitaGruppiFacade.class.php?modo=start";
	public static $azioneCure = "../paziente/creaVisitaCureFacade.class.php?modo=go";

	function __construct() {
		
		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/paziente:" . self::$root . "/ellipse/src/utility";  
		set_include_path($pathToInclude);		
	}

	// -------------------------------------------------
	
	public function getCureForm() {
		return self::$cureForm;
	}

	// ------------------------------------------------

	public function start() {

		require_once 'visitaCure.template.php';
		require_once 'utility.class.php';

		// Template
		$utility = new utility();
		$array = $utility->getConfig();

		$testata = self::$root . $array['testataPagina'];
		$piede = self::$root . $array['piedePagina'];
		$messaggioErrore = self::$root . $array['messaggioErrore'];
		$messaggioInfo = self::$root . $array['messaggioInfo'];

		$visitaCure = new visitaCure();		
		$visitaCure->setIdPaziente($this->getIdPaziente());
		$visitaCure->setIdListino($this->getIdListino());
		$visitaCure->setTitoloPagina('%ml.creaNuovaVisita%');

		$visitaCure->setAzioneDentiSingoli(self::$azioneDentiSingoli);
		$visitaCure->setAzioneGruppi(self::$azioneGruppi);
		$visitaCure->setAzioneCure(self::$azioneCure);
		
		$visitaCure->setConfermaTip("%ml.confermaCreazioneVisita%");		
		$visitaCure->setGruppiTip("%ml.creaGruppi%");		
		$visitaCure->setCureTip("%ml.creaCure%");		
				
		$visitaCure->setAzione(self::$azione);
		$visitaCure->setConfermaTip("%ml.confermaCreazioneVisita%");		
				
		$visitaCure->setTitoloPagina("%ml.creaNuovaVisitaCure%");
		$visitaCure->setVisitaCure($visitaCure);		

		// Compone la pagina
		include($testata);
		$visitaCure->inizializzaPagina();
		$visitaCure->displayPagina();
		include($piede);		
	}
		
	public function go() {
		
		require_once 'ricercaVisita.class.php';
		require_once 'visitaCure.template.php';
		require_once 'utility.class.php';

		// Template
		$utility = new utility();
		$array = $utility->getConfig();

		$this->setTestata(self::$root . $array['testataPagina']);
		$this->setPiede(self::$root . $array['piedePagina']);
		$this->setMessaggioErrore(self::$root . $array['messaggioErrore']);
		$this->setMessaggioInfo(self::$root . $array['messaggioInfo']);

		$visitaCure = new visitaCure();

		$visitaCure->setIdListino($this->getIdListino());	
		$visitaCure->setTitoloPagina('%ml.creaNuovaVisita%');

		$visitaCure->setCureGeneriche($this->prelevaCampiForm());
		$visitaCure->setAzione(self::$azione);
		$visitaCure->setConfermaTip("%ml.confermaCreazioneVisita%");		
		
		include($this->getTestata());

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
				$template = $utility->tailFile($utility->getTemplate($this->getMessaggioErrore()), $replace);			
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

		include($this->getPiede());		
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

	private function prelevaCampiForm() {
		
		$vociGeneriche = array();
		
		// primo gruppo --------------------------------------------------------------------------------------------------------------
		
		array_push($vociGeneriche, array('voceGenerica_1', $_POST['voceGenerica_1']));
		array_push($vociGeneriche, array('voceGenerica_2', $_POST['voceGenerica_2']));
		array_push($vociGeneriche, array('voceGenerica_3', $_POST['voceGenerica_3']));
		array_push($vociGeneriche, array('voceGenerica_4', $_POST['voceGenerica_4']));
		array_push($vociGeneriche, array('voceGenerica_5', $_POST['voceGenerica_5']));
		array_push($vociGeneriche, array('voceGenerica_6', $_POST['voceGenerica_6']));

		// restituisce l'array
		
		return $vociGeneriche;
	}	
}

?>
