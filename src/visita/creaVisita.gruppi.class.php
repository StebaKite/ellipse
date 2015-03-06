<?php

require_once 'visita.abstract.class.php';

class creaVisitaGruppi extends visitaAbstract {

	public static $gruppiForm = "gruppi";
	public static $azioneGruppi = "../visita/creaVisitaGruppiFacade.class.php?modo=go";
	public static $azioneDentiSingoli = "../visita/creaVisitaFacade.class.php?modo=start";
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

	public function start() {

		require_once 'visitaGruppi.template.php';

		$visitaGruppi = new visitaGruppi();		
		$this->preparaPagina($visitaGruppi);

		// Compone la pagina
		include(self::$testata);
		$visitaGruppi->inizializzaGruppiPagina();
		$visitaGruppi->displayPagina();
		include(self::$piede);		
	}
		
	public function go() {
		
		require_once 'ricercaVisita.class.php';
		require_once 'visitaGruppi.template.php';
		require_once 'utility.class.php';

		// Template
		$utility = new utility();
		$array = $utility->getConfig();

		$visitaGruppi = new visitaGruppi();
		$this->preparaPagina($visitaGruppi);
		
		$_SESSION['vocegruppo_1'] = $_POST['voceGruppo_1'];
		$_SESSION['dentigruppo_1'] = $this->prelevaCampiFormGruppo_1();
		
		$_SESSION['vocegruppo_2'] = $_POST['voceGruppo_2'];
		$_SESSION['dentigruppo_2'] = $this->prelevaCampiFormGruppo_2();
		
		$_SESSION['vocegruppo_3'] = $_POST['voceGruppo_3'];
		$_SESSION['dentigruppo_3'] = $this->prelevaCampiFormGruppo_3();
		
		$_SESSION['vocegruppo_4'] = $_POST['voceGruppo_4'];
		$_SESSION['dentigruppo_4'] = $this->prelevaCampiFormGruppo_4();
		
		include(self::$testata);
			
		if ($this->inserisciGruppi($visitaGruppi)) {

			$ricercaVisita = new ricercaVisita();
			$ricercaVisita->setMessaggio("%ml.creaVisitaOk%");
			$ricercaVisita->start();
		}
		else {
			$visitaGruppi->displayPagina();
			$replace = array('%messaggio%' => '%ml.creaVisitaKo%');				
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);			
			echo $utility->tailTemplate($template);
		}
		include(self::$piede);
	}

	private function preparaPagina($visitaGruppi) {

		$visitaGruppi->setAzioneGruppi(self::$azioneGruppi);
		$visitaGruppi->setAzioneDentiSingoli(self::$azioneDentiSingoli);
		$visitaGruppi->setAzioneCure(self::$azioneCure);		
		$visitaGruppi->setConfermaTip("%ml.confermaCreazioneVisita%");
		$visitaGruppi->setSingoliTip("%ml.creaSingoli%");
		$visitaGruppi->setCureTip("%ml.creaCure%");
		$visitaGruppi->setTitoloPagina("%ml.creaNuovaVisitaDentiGruppi%");
				
		unset($_SESSION['vocegruppo_1']);
		unset($_SESSION['vocegruppo_2']);
		unset($_SESSION['vocegruppo_3']);
		unset($_SESSION['vocegruppo_4']);
	}
	
	private function inserisciGruppi($visitaGruppi) {

		require_once 'database.class.php';

		$db = new database();
		$db->beginTransaction();

		/*
		 * Una riga in "visita" e tutte le voci in tabella "voceVisita"
		 */ 
		if ($this->creaVisita($db)) {

			if ($this->inserisciVociGruppo($db, 'voceGruppo_1', $_SESSION['vocegruppo_1'], $_SESSION['dentigruppo_1'], $db->getLastIdUsed())) {
				if ($this->inserisciVociGruppo($db, 'voceGruppo_2', $_SESSION['vocegruppo_2'], $_SESSION['dentigruppo_2'], $db->getLastIdUsed())) {
					if ($this->inserisciVociGruppo($db, 'voceGruppo_3', $_SESSION['vocegruppo_3'], $_SESSION['dentigruppo_3'], $db->getLastIdUsed())) {
						if ($this->inserisciVociGruppo($db, 'voceGruppo_4', $_SESSION['vocegruppo_4'], $_SESSION['dentigruppo_4'], $db->getLastIdUsed())) {
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
				if (!$this->creaVoceVisita($db, $idVisitaUsato, self::$gruppiForm, $nomeCampoForm . ";" . trim($row[0]), $voceGruppo)) {
					$db->rollbackTransaction();
					return FALSE;	
				}
			}			
		}
		return TRUE;	
	}
}

?>
