<?php

require_once 'strumenti.abstract.class.php';

class modificaConfigurazione extends strumentiAbstract {

	public static $azioneModificaConfigurazione = "../strumenti/modificaConfigurazioneFacade.class.php?modo=go";

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
		require_once 'utility.class.php';
		
		$configurazioneTemplate = new configurazioneTemplate();
		$this->preparaPagina($configurazioneTemplate);

		if ($configurazioneTemplate->controlliLogici()) {
			$utility = new utility();
				
			if ($this->modifica()) {
				include(self::$testata);
				
				$configurazioneTemplate->displayPagina();
				$replace = array('%messaggio%' => '%ml.modificaConfigurazioneOk%');				
				$template = $utility->tailFile($utility->getTemplate(self::$messaggioInfo), $replace);
				echo $utility->tailTemplate($template);
				
				include(self::$piede);				
			}
			else {
				include(self::$testata);
				
				$configurazioneTemplate->displayPagina();
				$replace = array('%messaggio%' => '%ml.modificaConfigurazioneKo%');
				$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
				echo $utility->tailTemplate($template);
				
				include(self::$piede);
			}
		}
		else {
			include(self::$testata);
			$configurazioneTemplate->displayPagina();
			include(self::$piede);
		}
	}	

	public function preparaPagina($configurazioneTemplate) {
	
		$configurazioneTemplate->setAzione(self::$azioneModificaConfigurazione);
		$configurazioneTemplate->setTestoAzione("%ml.modificaConfigTip%");
		$configurazioneTemplate->setTitoloPagina("%ml.modificaConfigurazione%");		
		$configurazioneTemplate->setProgressivoTip("%ml.progressivoTip%");
		$configurazioneTemplate->setClasseTip("%ml.classeTip%");
		$configurazioneTemplate->setFilepathTip('%ml.filepathTip%');
		
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
	
	private function modifica() {
	
		require_once 'database.class.php';
	
		$db = new database();
		$db->beginTransaction();
	
		if ($this->modificaConfigurazione($db)) {
			$db->commitTransaction();
			return TRUE;
		}
		return FALSE;
	}
}

?>