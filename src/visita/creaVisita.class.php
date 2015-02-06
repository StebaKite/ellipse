<?php

require_once 'visitaPaziente.abstract.class.php';

class creaVisita extends visitaPazienteAbstract {
	
	public static $singoliForm = "singoli";
	public static $azioneDentiSingoli = "../visita/creaVisitaFacade.class.php?modo=go";
	public static $azioneGruppi = "../visita/creaVisitaGruppiFacade.class.php?modo=start";
	public static $azioneCure = "../visita/creaVisitaCureFacade.class.php?modo=start";

	function __construct() {
		self::$root = $_SERVER['DOCUMENT_ROOT'];
	}

	// ------------------------------------------------
	
	public function getAzioneDentiSingoli() {
		return self::$azioneDentiSingoli;
	}
	public function getSingoliForm() {
		return self::$singoliForm;
	}

	// ------------------------------------------------

	public function start() {

		require_once 'visita.template.php';
		require_once 'utility.class.php';

		// Template
		$utility = new utility();
		$array = $utility->getConfig();

		$testata = self::$root . $array['testataPagina'];
		$piede = self::$root . $array['piedePagina'];
		$messaggioErrore = self::$root . $array['messaggioErrore'];
		$messaggioInfo = self::$root . $array['messaggioInfo'];

		$visita = new visita();		
		$visita->setIdPaziente($this->getIdPaziente());
		$visita->setIdListino($this->getIdListino());
		$visita->setCognomeRicerca($this->getCognomeRicerca());

		$visita->setAzioneDentiSingoli(self::$azioneDentiSingoli);
		$visita->setAzioneGruppi(self::$azioneGruppi);
		$visita->setAzioneCure(self::$azioneCure);
		
		$visita->setConfermaTip("%ml.confermaCreazioneVisita%");		
		$visita->setGruppiTip("%ml.creaGruppi%");		
		$visita->setCureTip("%ml.creaCure%");		
				
		$visita->setTitoloPagina("%ml.creaNuovaVisitaDentiSingoli%");
		$visita->setVisitaLabel("");
		$visita->setVisita($visita);		

		// Compone la pagina
		include($testata);
		$visita->displayPagina();
		include($piede);		
	}
		
	public function go() {
		
		require_once 'ricercaVisita.class.php';
		require_once 'visita.template.php';
		require_once 'utility.class.php';

		// Template
		$utility = new utility();
		$array = $utility->getConfig();

		$this->setTestata(self::$root . $array['testataPagina']);
		$this->setPiede(self::$root . $array['piedePagina']);
		$this->setMessaggioErrore(self::$root . $array['messaggioErrore']);
		$this->setMessaggioInfo(self::$root . $array['messaggioInfo']);

		$visita = new visita();
		
		$visita->setAzioneDentiSingoli(self::$azioneDentiSingoli);
		$visita->setAzioneGruppi(self::$azioneGruppi);
		$visita->setAzioneCure(self::$azioneCure);
		
		$visita->setConfermaTip("%ml.confermaCreazioneVisita%");		
		$visita->setGruppiTip("%ml.creaGruppi%");		
		$visita->setCureTip("%ml.creaCure%");		

		$visita->setIdListino($this->getIdListino());	
		$visita->setTitoloPagina('%ml.creaNuovaVisita%');
		$visita->setDentiSingoli($this->prelevaCampiFormSingoli());
		
		include($this->getTestata());

		if ($visita->controlliLogici()) {
			
			if ($this->inserisciSingoli($visita)) {
				
				$ricercaVisita = new ricercaVisita();
				$ricercaVisita->setIdPaziente($this->getIdPaziente());
				$ricercaVisita->setIdListino($this->getIdListino());
				$ricercaVisita->setMessaggio("%ml.creaVisitaOk%");
				$ricercaVisita->setCognomeRicerca($this->getCognomeRicerca());
				$ricercaVisita->start();
			}
			else {
				$visita->displayPagina();
				$replace = array('%messaggio%' => '%ml.creaVisitaKo%');				
				$template = $utility->tailFile($utility->getTemplate($this->getMessaggioErrore()), $replace);			
				echo $utility->tailTemplate($template);
			}
		}
		else {
			$visita->displayPagina();
			$replace = array('%messaggio%' => '%ml.creaVisitaKo%');				
			$template = $utility->tailFile($utility->getTemplate($this->getMessaggioErrore()), $replace);			
			echo $utility->tailTemplate($template);
		} 

		include($this->getPiede());		
	}
		
	private function inserisciSingoli($visita) {

		require_once 'database.class.php';

		$db = new database();
		$db->beginTransaction();

		/*
		 * Una riga in "visita" e tutte le voci in tabella "voceVisita"
		 */ 

		if ($this->creaVisita($db)) {

			$dentiSingoli = $visita->getDentiSingoli();
			$idVisitaUsato = $db->getLastIdUsed(); 
			$visita->setIdVisita($idVisitaUsato);
			$this->setIdVisita($idVisitaUsato);
			$visita->setIdPaziente($this->getIdPaziente());
				
			for ($i = 0; $i < sizeof($dentiSingoli); $i++) {

				if ($dentiSingoli[$i][1] != "") {
					if (!$this->creaVoceVisita($db, $idVisitaUsato, $this->getSingoliForm(), trim($dentiSingoli[$i][0]), trim($dentiSingoli[$i][1]))) {
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
}

?>
