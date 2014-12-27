<?php

require_once 'visitaPaziente.abstract.class.php';

class modificaVisitaGruppi extends visitaPazienteAbstract {
	
	private static $gruppiForm = "gruppi";
	public static $azioneGruppi = "../paziente/modificaVisitaGruppiFacade.class.php?modo=go";
	public static $azioneDentiSingoli = "../paziente/modificaVisitaFacade.class.php?modo=start";
	public static $azioneCure = "../paziente/modificaVisitaCureFacade.class.php?modo=start";

	function __construct() {
		
		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/paziente:" . self::$root . "/ellipse/src/utility";  
		set_include_path($pathToInclude);		
	}

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
		$visitaGruppi->setCognomeRicerca($this->getCognomeRicerca());
					
		$visitaGruppi->setAzioneDentiSingoli(self::$azioneDentiSingoli);
		$visitaGruppi->setAzioneGruppi(self::$azioneGruppi);
		$visitaGruppi->setAzioneCure(self::$azioneCure);
		
		$visitaGruppi->setConfermaTip("%ml.confermaModificaVisita%");		
		$visitaGruppi->setGruppiTip("%ml.gruppiVisita%");		
		$visitaGruppi->setCureTip("%ml.cureVisita%");		
				
		$visitaGruppi->setTitoloPagina("%ml.modificaVisitaDentiSingoli%");
		$visitaGruppi->setVisitaLabel("- %ml.visita% : ");
		$visitaGruppi->setVisita($visitaGruppi);		

		// Compone la pagina
		include($testata);
		$visitaGruppi->inizializzaGruppiPagina();
		$visitaGruppi->displayPagina();
		include($piede);		
	}
		
	public function go() {
/*		
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

		$visita->setDentiSingoli($this->prelevaCampiFormSingoli());
		$visita->setAzioneDentiSingoli(self::$azione);
		$visita->setConfermaTip("%ml.confermaCreazioneVisita%");		

		$visita->setIdListino($this->getIdListino());	
		$visita->setTitoloPagina("%ml.modificaVisitaDentiSingoli%");
		$visita->setVisitaLabel("- %ml.visita% : ");
		$visita->setDentiSingoli($this->prelevaCampiFormSingoli());
		
		include($this->getTestata());

		if ($visita->controlliLogici()) {
			
			if ($this->modificaSingoli($visita)) {

				$visita->displayPagina();
				$replace = array('%messaggio%' => '%ml.modificaVisitaOk%');				
				$template = $utility->tailFile($utility->getTemplate($this->getMessaggioInfo()), $replace);			
				echo $utility->tailTemplate($template);
			}
			else {
				$visita->displayPagina();
				$replace = array('%messaggio%' => '%ml.modificaVisitaKo%');				
				$template = $utility->tailFile($utility->getTemplate($this->getMessaggioErrore()), $replace);			
				echo $utility->tailTemplate($template);
			}
		}
		else {
			$visita->displayPagina();
			$replace = array('%messaggio%' => '%ml.modificaVisitaKo%');				
			$template = $utility->tailFile($utility->getTemplate($this->getMessaggioErrore()), $replace);			
			echo $utility->tailTemplate($template);
		} 

		include($this->getPiede());		
*/ 
	}

	private function modificaSingoli($visita) {
	
		require_once 'database.class.php';

		$db = new database();
		$db->beginTransaction();

		$dentiSingoli = $visita->getDentiSingoli();
		$idVisitaUsato = $this->getIdVisita(); 
		$visita->setIdVisita($idVisitaUsato);
		$visita->setIdPaziente($this->getIdPaziente());

		foreach($dentiSingoli as $row) {

			// cerco il nomecampo sulla tabella vocevisita			
			$idVoce = $this->leggiVoceVisita($db, $this->getIdVisita(), trim($row[0]));
			
			// se il nomecampo esiste in tabella "vocevisita" e la voce in pagina è != ""						
			if ($idVoce != "" and $row[1] != "") {
				if (!$this->aggiornaVoceVisita($db, $idVoce, $row[1])) {
					error_log("Fallito aggiornamento idvoce : " . $idVoce);
					$db->rollbackTransaction();
					return FALSE;
				}
			}
			// se il nomecampo esiste e la voce in pagina è == "" cancello la voce
			elseif ($idVoce != "" and $row[1] == "") {
				if (!$this->cancellaVoceVisita($db, $idVoce)) {
					error_log("Fallita cancellazione idvoce : " . $idVoce);
					$db->rollbackTransaction();
					return FALSE;
				}
			}
			// se il nomecampo non esiste e la voce in pagina è != ""
			elseif ($idVoce == "" and $row[1] != "") {

				if (!$this->creaVoceVisita($db, $idVisitaUsato, self::$singoliForm, $row[0], $row[1])) {
					error_log("Fallita creazione voce per la visita : " . $idVisitaUsato);
					$db->rollbackTransaction();
					return FALSE;
				}
			}
		}
		// aggiorno la datamodifica della "visita"
		if (!$this->aggiornaVisita($db, $idVisitaUsato)) {
			error_log("Fallito aggiornamento visita : " . $idVisitaUsato);
			$db->rollbackTransaction();
			return FALSE;
		}
		
		$db->commitTransaction();
		return TRUE;				
	}
}
?>
