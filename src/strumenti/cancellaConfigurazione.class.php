<?php

require_once 'strumenti.abstract.class.php';

class cancellaConfigurazione extends strumentiAbstract {

	public static $azioneCancellaConfigurazione = "../strumenti/cancellaConfigurazioneFacade.class.php?modo=go";

	function __construct() {

		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/strumenti:" . self::$root . "/ellipse/src/utility";
		set_include_path($pathToInclude);

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

		require_once 'configurazione.template.php';
		require_once 'utility.class.php';
		
		$configurazioneTemplate = new configurazioneTemplate();
		$this->preparaPagina($configurazioneTemplate);
		
		// Compone la pagina
		include(self::$testata);
		$configurazioneTemplate->displayPagina();
		include(self::$piede);
	}
	
	public function go() {
	
		error_log("<<<<<<< Go >>>>>>> " . $_SERVER['PHP_SELF']);

		require_once 'configurazione.template.php';
		require_once 'ricercaConfigurazioni.class.php';
		require_once 'utility.class.php';
		
		$configurazioneTemplate = new configurazioneTemplate();
		$this->preparaPagina($configurazioneTemplate);
		
		$utility = new utility();
		
		if ($this->cancella()) {
			$ricercaConfigurazioni = new ricercaConfigurazioni();
			$ricercaConfigurazioni->setMessaggio('%ml.cancellaConfigurazioneOk%');
			$ricercaConfigurazioni->start();
		}
		else {
			include(self::$testata);
		
			$configurazioneTemplate->displayPagina();
			$replace = array('%messaggio%' => '%ml.cancellaConfigurazioneKo%');
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
			echo $utility->tailTemplate($template);
		
			include(self::$piede);
		}
	}	
	
	public function preparaPagina($configurazioneTemplate) {
	
		$configurazioneTemplate->setAzione(self::$azioneCancellaConfigurazione);
		$configurazioneTemplate->setTestoAzione("%ml.cancellaConfigurazione%");
		$configurazioneTemplate->setTitoloPagina("%ml.cancellaConfig%");
		$configurazioneTemplate->setProgressivoTip("%ml.progressivoTip%");
		$configurazioneTemplate->setProgressivoDisable("disabled");
		$configurazioneTemplate->setClasseTip("%ml.classeTip%");
		$configurazioneTemplate->setClasseDisable("disabled");
		$configurazioneTemplate->setFilepathTip("%ml.filepathTip%");
		$configurazioneTemplate->setFilepathDisable("disabled");
		$configurazioneTemplate->setStatoDisable("disabled");
		
		if ($this->getStato() == "01") {
			$configurazioneTemplate->setStatoEseguito("checked");
			$configurazioneTemplate->setStatoDaeseguire("");
		}
		else if ($this->getStato() == "00") {
			$configurazioneTemplate->setStatoDaeseguire("checked");
			$configurazioneTemplate->setStatoEseguito("");
		}
		else if ($this->getStato() != "") {
			$configurazioneTemplate->setStatoEseguito("checked");
			$configurazioneTemplate->setStatoDaeseguire("");
		}
		else if ($this->getStato() == "") {
			$configurazioneTemplate->setStatoDaeseguire("checked");
			$configurazioneTemplate->setStatoEseguito("");
		}
	}
	
	private function cancella() {
	
		require_once 'database.class.php';
	
		$db = new database();
		$db->beginTransaction();
	
		if ($this->cancellaConfigurazione($db)) {
			$db->commitTransaction();
			return TRUE;
		}
		return FALSE;
	}
}	
	
?>