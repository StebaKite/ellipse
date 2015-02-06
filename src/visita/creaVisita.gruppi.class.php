<?php

require_once 'visitaPaziente.abstract.class.php';

class creaVisitaGruppi extends visitaPazienteAbstract {

	public static $gruppiForm = "gruppi";
	public static $azioneGruppi = "../visita/creaVisitaGruppiFacade.class.php?modo=go";
	public static $azioneDentiSingoli = "../visita/creaVisitaFacade.class.php?modo=start";
	public static $azioneCure = "../visita/creaVisitaCureFacade.class.php?modo=start";

	function __construct() {
		self::$root = $_SERVER['DOCUMENT_ROOT'];
	}

	// ------------------------------------------------
	
	public function getGruppiForm() {
		return self::$gruppiForm;
	}

	// ------------------------------------------------

	public function start() {

		require_once 'visitaGruppi.template.php';
		require_once 'utility.class.php';

		// Template
		$utility = new utility();
		$array = $utility->getConfig();

		$testata = self::$root . $array['testataPagina'];
		$piede = self::$root . $array['piedePagina'];
		$messaggioErrore = self::$root . $array['messaggioErrore'];
		$messaggioInfo = self::$root . $array['messaggioInfo'];

		$visitaGruppi = new visitaGruppi();		
		$visitaGruppi->setIdPaziente($this->getIdPaziente());
		$visitaGruppi->setIdListino($this->getIdListino());
		$visitaGruppi->setTitoloPagina('%ml.creaNuovaVisita%');

		$visitaGruppi->setAzioneGruppi(self::$azioneGruppi);
		$visitaGruppi->setAzioneDentiSingoli(self::$azioneDentiSingoli);
		$visitaGruppi->setAzioneCure(self::$azioneCure);
		
		$visitaGruppi->setConfermaTip("%ml.confermaCreazioneVisita%");		
		$visitaGruppi->setSingoliTip("%ml.creaSingoli%");		
		$visitaGruppi->setCureTip("%ml.creaCure%");		
				
		$visitaGruppi->setTitoloPagina("%ml.creaNuovaVisitaDentiGruppi%");
		$visitaGruppi->setVisita($visitaGruppi);		

		// Compone la pagina
		include($testata);
		$visitaGruppi->inizializzaGruppiPagina();
		$visitaGruppi->displayPagina();
		include($piede);		
	}
		
	public function go() {
		
		require_once 'ricercaVisita.class.php';
		require_once 'visitaGruppi.template.php';
		require_once 'utility.class.php';

		// Template
		$utility = new utility();
		$array = $utility->getConfig();

		$this->setTestata(self::$root . $array['testataPagina']);
		$this->setPiede(self::$root . $array['piedePagina']);
		$this->setMessaggioErrore(self::$root . $array['messaggioErrore']);
		$this->setMessaggioInfo(self::$root . $array['messaggioInfo']);

		$visitaGruppi = new visitaGruppi();

		$visitaGruppi->setIdListino($this->getIdListino());	
		$visitaGruppi->setTitoloPagina('%ml.creaNuovaVisita%');
		
		$visitaGruppi->setVoceGruppo_1($_POST['voceGruppo_1']);
		$visitaGruppi->setDentiGruppo_1($this->prelevaCampiFormGruppo_1());
		
		$visitaGruppi->setVoceGruppo_2($_POST['voceGruppo_2']);
		$visitaGruppi->setDentiGruppo_2($this->prelevaCampiFormGruppo_2());
		
		$visitaGruppi->setVoceGruppo_3($_POST['voceGruppo_3']);
		$visitaGruppi->setDentiGruppo_3($this->prelevaCampiFormGruppo_3());
		
		$visitaGruppi->setVoceGruppo_4($_POST['voceGruppo_4']);
		$visitaGruppi->setDentiGruppo_4($this->prelevaCampiFormGruppo_4());
	
		$visitaGruppi->setAzioneDentiSingoli(self::$azioneDentiSingoli);
		$visitaGruppi->setAzioneGruppi(self::$azioneGruppi);
		$visitaGruppi->setAzioneCure(self::$azioneCure);
		
		$visitaGruppi->setConfermaTip("%ml.confermaCreazioneVisita%");		
		$visitaGruppi->setGruppiTip("%ml.creaGruppi%");		
		$visitaGruppi->setCureTip("%ml.creaCure%");		
		
		include($this->getTestata());
			
		if ($this->inserisciGruppi($visitaGruppi)) {

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

		include($this->getPiede());		
	}
				
	private function inserisciGruppi($visitaGruppi) {

		require_once 'database.class.php';

		$db = new database();
		$db->beginTransaction();

		$visitaGruppi->setIdPaziente($this->getIdPaziente());

		/*
		 * Una riga in "visita" e tutte le voci in tabella "voceVisita"
		 */ 

		if ($this->creaVisita($db)) {

			if ($this->inserisciVociGruppo($db, 'voceGruppo_1', $visitaGruppi->getVoceGruppo_1(), $visitaGruppi->getDentiGruppo_1(), $db->getLastIdUsed())) {
				if ($this->inserisciVociGruppo($db, 'voceGruppo_2', $visitaGruppi->getVoceGruppo_2(), $visitaGruppi->getDentiGruppo_2(), $db->getLastIdUsed())) {
					if ($this->inserisciVociGruppo($db, 'voceGruppo_3', $visitaGruppi->getVoceGruppo_3(), $visitaGruppi->getDentiGruppo_3(), $db->getLastIdUsed())) {
						if ($this->inserisciVociGruppo($db, 'voceGruppo_4', $visitaGruppi->getVoceGruppo_4(), $visitaGruppi->getDentiGruppo_4(), $db->getLastIdUsed())) {
							$db->commitTransaction();
							return TRUE;				
						}
					}	
				}
			}
		}		
		return FALSE;
	}
	
	public function inserisciVociGruppo($db, $nomeCampoForm, $voceGruppo, $dentiGruppo, $idVisitaUsato) {
	
		foreach($dentiGruppo as $row) {

			if ($row[1] != "") {
				if (!$this->creaVoceVisita($db, $idVisitaUsato, $this->getGruppiForm(), $nomeCampoForm . ";" . trim($row[0]), $voceGruppo)) {
					$db->rollbackTransaction();
					error_log("Errore inserimento voce, eseguito Rollback");
					return FALSE;	
				}
			}			
		}
		return TRUE;	
	}
}

?>
