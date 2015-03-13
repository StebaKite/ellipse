<?php

require_once 'visita.abstract.class.php';

class creaVisita extends visitaAbstract {
	
	public static $singoliForm = "singoli";
	public static $azioneDentiSingoli = "../visita/creaVisitaFacade.class.php?modo=go";
	public static $azioneGruppi = "../visita/creaVisitaGruppiFacade.class.php?modo=start";
	public static $azioneCure = "../visita/creaVisitaCureFacade.class.php?modo=start";

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
	
	public function getAzioneDentiSingoli() {
		return self::$azioneDentiSingoli;
	}

	// ------------------------------------------------

	public function start() {

		require_once 'visita.template.php';
		require_once 'utility.class.php';

		$visita = new visita();		
		$this->preparaPagina($visita);

		// Compone la pagina
		include(self::$testata);
		$visita->displayPagina();
		include(self::$piede);		
	}
		
	public function go() {
		
		require_once 'ricercaVisita.class.php';
		require_once 'visita.template.php';
		require_once 'utility.class.php';

		$visita = new visita();
		$this->preparaPagina($visita);		
		$_SESSION['dentisingoli'] = $this->prelevaCampiFormSingoli();
		
		include(self::$testata);

		if ($visita->controlliLogici()) {
			
			if ($this->inserisciSingoli($visita)) {
				
				$ricercaVisita = new ricercaVisita();
				$ricercaVisita->setMessaggio("%ml.creaVisitaOk%");
				$ricercaVisita->start();
			}
			else {
				$visita->displayPagina();
				$replace = array('%messaggio%' => '%ml.creaVisitaKo%');
				$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);			
				echo $utility->tailTemplate($template);
			}
		}
		else {
			$visita->displayPagina();
			$replace = array('%messaggio%' => '%ml.creaVisitaKo%');				
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);			
			echo $utility->tailTemplate($template);
		} 

		include(self::$piede);		
	}
	
	public function preparaPagina($visita) {

		$visita->setAzioneDentiSingoli(self::$azioneDentiSingoli);
		$visita->setAzioneGruppi(self::$azioneGruppi);
		$visita->setAzioneCure(self::$azioneCure);
		
		$visita->setConfermaTip("%ml.confermaCreazioneVisita%");
		$visita->setGruppiTip("%ml.creaGruppi%");
		$visita->setCureTip("%ml.creaCure%");
		
		$visita->setTitoloPagina("%ml.creaNuovaVisitaDentiSingoli%");
		$visita->setVisitaLabel("");
		
		unset($_SESSION['impostazionivoci']);		
	}
		
	private function inserisciSingoli($visita) {

		require_once 'database.class.php';

		$db = new database();
		$db->beginTransaction();

		/*
		 * Una riga in "visita" e tutte le voci in tabella "voceVisita"
		 */ 

		if ($this->creaVisita($db)) {

			$dentiSingoli = $_SESSION['dentisingoli'];
			$_SESSION['idVisita'] = $db->getLastIdUsed(); 
				
			for ($i = 0; $i < sizeof($dentiSingoli); $i++) {

				if ($dentiSingoli[$i][1] != "") {
					if (!$this->creaVoceVisita($db, $_SESSION['idVisita'], self::$singoliForm, trim($dentiSingoli[$i][0]), trim($dentiSingoli[$i][1]))) {
						$db->rollbackTransaction();
						error_log("Errore inserimento voce, eseguito Rollback");
						return FALSE;	
					}
				}			
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
}

?>
