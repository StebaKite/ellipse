<?php

require_once 'visitaPaziente.abstract.class.php';

class modificaVisita extends visitaPazienteAbstract {
	
	private static $singoliForm = "singoli";
	public static $azioneDentiSingoli = "../paziente/modificaVisitaFacade.class.php?modo=go";
	public static $azioneGruppi = "../paziente/modificaVisitaGruppiFacade.class.php?modo=start";
	public static $azioneCure = "../paziente/modificaVisitaCureFacade.class.php?modo=start";

	function __construct() {
		
		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/paziente:" . self::$root . "/ellipse/src/utility";  
		set_include_path($pathToInclude);		

		require_once 'utility.class.php';

		$utility = new utility();
		$array = $utility->getConfig();

		self::$testata = self::$root . $array['testataPagina'];
		self::$piede = self::$root . $array['piedePagina'];
		self::$messaggioErrore = self::$root . $array['messaggioErrore'];
		self::$messaggioInfo = self::$root . $array['messaggioInfo'];				
	}

	public function getSingoliForm() {
		return self::$singoliForm;
	}

	// ------------------------------------------------

	public function start() {

		require_once 'visita.template.php';
		require_once 'utility.class.php';

		error_log("<<<<<<< Start >>>>>>> " . $_SERVER['PHP_SELF']);

		// Template
		$utility = new utility();

		$visita = new visita();		
		$visita->setIdPaziente($this->getIdPaziente());
		$visita->setIdListino($this->getIdListino());
		$visita->setIdVisita($this->getIdVisita());		
		$visita->setCognomeRicerca($this->getCognomeRicerca());
					
		$visita->setAzioneDentiSingoli(self::$azioneDentiSingoli);
		$visita->setAzioneGruppi(self::$azioneGruppi);
		$visita->setAzioneCure(self::$azioneCure);
		
		$visita->setConfermaTip("%ml.confermaModificaVisita%");		
		$visita->setGruppiTip("%ml.modificaGruppi%");		
		$visita->setCureTip("%ml.modificaCure%");		
				
		$visita->setTitoloPagina("%ml.modificaVisitaDentiSingoli%");
		$visita->setVisitaLabel("- %ml.visita% : ");
		$visita->setVisita($visita);		

		// Compone la pagina
		include(self::$testata);
//		$visita->inizializzaPagina();
		$visita->impostaVoci();
		$visita->displayPagina();
		include(self::$piede);		
	}
		
	public function go() {
		
		require_once 'ricercaVisita.class.php';
		require_once 'visita.template.php';
		require_once 'utility.class.php';

		error_log("<<<<<<< Go >>>>>>> " . $_SERVER['PHP_SELF']);

		$utility = new utility();
		$visita = new visita();
		$visita->setIdPaziente($this->getIdPaziente());
		$visita->setIdListino($this->getIdListino());
		$visita->setIdVisita($this->getIdVisita());		
		$visita->setCognomeRicerca($this->getCognomeRicerca());

		$visita->setDentiSingoli($this->prelevaCampiFormSingoli());
					
		$visita->setAzioneDentiSingoli(self::$azioneDentiSingoli);
		$visita->setAzioneGruppi(self::$azioneGruppi);
		$visita->setAzioneCure(self::$azioneCure);
		
		$visita->setConfermaTip("%ml.confermaModificaVisita%");		
		$visita->setGruppiTip("%ml.modificaGruppi%");		
		$visita->setCureTip("%ml.modificaCure%");		

		$visita->setTitoloPagina("%ml.modificaVisitaDentiSingoli%");
		$visita->setVisitaLabel("- %ml.visita% : ");
		$visita->setVisita($visita);		

		// carica in pagina le voci inserite sul DB
		$visita->impostaVoci();
		
		include(self::$testata);

		if ($visita->controlliLogici()) {
			
			if ($this->modificaSingoli($visita)) {

				// ricarica in pagina le voci inserite sul DB
				$visita->impostaVoci();
				$visita->displayPagina();
				$replace = array('%messaggio%' => '%ml.modificaVisitaOk%');				
				$template = $utility->tailFile($utility->getTemplate(self::$messaggioInfo), $replace);			
				echo $utility->tailTemplate($template);
			}
			else {
				// ricarica in pagina le voci inserite sul DB
				$visita->impostaVoci();
				$visita->displayPagina();
				$replace = array('%messaggio%' => '%ml.modificaVisitaKo%');				
				$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);			
				echo $utility->tailTemplate($template);
			}
		}
		else {
			// ricarica in pagina le voci inserite sul DB
			$visita->impostaVoci();
			$visita->displayPagina();
			$replace = array('%messaggio%' => '%ml.modificaVisitaKo%');				
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);			
			echo $utility->tailTemplate($template);
		} 

		include(self::$piede);		
	}

	private function modificaSingoli($visita) {
	
		require_once 'database.class.php';

		$db = new database();
		$db->beginTransaction();

		$dentiSingoli = $visita->getDentiSingoli();
		$idVisitaUsato = $visita->getIdVisita(); 
		$visita->setIdVisita($idVisitaUsato);
		$visita->setIdPaziente($this->getIdPaziente());

		foreach($dentiSingoli as $row) {

			// cerco il nomecampo sulla tabella vocevisita			
			$idVoce = $this->leggiVoceVisita($db, $idVisitaUsato, trim($row[0]), self::$singoliForm);
			
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

		// aggiorno la datamodifica del "paziente"
		if (!$this->aggiornaPaziente($db, $this->getIdPaziente())) {
			error_log("Fallito aggiornamento paziente : " . $this->getIdPaziente());
			$db->rollbackTransaction();
			return FALSE;
		}
		
		$db->commitTransaction();
		return TRUE;				
	}
}
?>
