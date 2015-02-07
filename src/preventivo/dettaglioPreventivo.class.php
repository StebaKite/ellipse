<?php

require_once 'preventivo.abstract.class.php';

class dettaglioPreventivo extends preventivoAbstract {

	public static $azioneAccettaPreventivo = "../preventivo/accettaPreventivoFacade.class.php?modo=go";
	public static $azioneRinunciaPreventivo = "../preventivo/rinunciaPreventivoFacade.class.php?modo=go";
	
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

		error_log("<<<<<<< Start >>>>>>> " . $_SERVER['PHP_SELF']);

		require_once 'dettaglioPreventivo.template.php';
		require_once 'utility.class.php';
		require_once 'database.class.php';
		
		$dettaglioPreventivoTemplate = new dettaglioPreventivoTemplate();
		$this->preparaPagina($dettaglioPreventivoTemplate);

		$db = new database();

		if ($this->getIdpreventivo() != "") {
			$this->prelevaVociPreventivoPrincipale($db, $dettaglioPreventivoTemplate);
		}
		elseif ($this->getIdSottoPreventivo() != "") {
			$this->prelevaVociPreventivoSecondario($db, $dettaglioPreventivoTemplate);
		}
		
		// Compone la pagina
		include(self::$testata);
		$dettaglioPreventivoTemplate->displayPagina();
		include(self::$piede);
	}
	
	public function preparaPagina($dettaglioPreventivoTemplate) {

		$dettaglioPreventivoTemplate->setIntestazioneColonnaAzioni("<th colspan='2'>&nbsp;</th>");
		
		if ($this->getStato() == '01') {
			$dettaglioPreventivoTemplate->setAzionePreventivoLabelBottone('%ml.rinuncia%');
			$dettaglioPreventivoTemplate->setAzionePreventivo(self::$azioneRinunciaPreventivo);
			$dettaglioPreventivoTemplate->setAzionePreventivoTip('%ml.rinunciaPreventivoTip%');
		}
		else {
			$dettaglioPreventivoTemplate->setAzionePreventivoLabelBottone('%ml.accetta%');
			$dettaglioPreventivoTemplate->setAzionePreventivo(self::$azioneAccettaPreventivo);
			$dettaglioPreventivoTemplate->setAzionePreventivoTip('%ml.accettaPreventivoTip%');
		}
		
		if ($this->getIdpreventivo() != "") {
			$dettaglioPreventivoTemplate->setTitoloPagina("%ml.dettaglioPreventivoPrincipale%");
		}
		elseif ($this->getIdSottoPreventivo() != "") {
			$dettaglioPreventivoTemplate->setTitoloPagina("%ml.dettaglioPreventivoSecondario%");
		}
	}
}

?>