<?php

require_once 'strumenti.abstract.class.php';

class creaConfigurazione extends strumentiAbstract {

	public static $azioneCreaConfigurazione = "../strumenti/creaConfigurazioneFacade.class.php?modo=go";

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
		
		require_once 'configurazione.template.php';
		require_once 'utility.class.php';
		
		$configurazioneTemplate = new configurazioneTemplate();
		$this->preparaPagina($configurazioneTemplate);
				
		// Compone la pagina
		include(self::$testata);
		$configurazioneTemplate->inizializzaPagina();
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
		
		if ($configurazioneTemplate->controlliLogici()) {
			$utility = new utility();

			if ($this->inserisci()) {
				$ricercaConfigurazioni = new ricercaConfigurazioni();
				$ricercaConfigurazioni->setMessaggio('%ml.creaConfigurazioneOk%');
				$ricercaConfigurazioni->start();
			}
			else {
				include(self::$testata);
				
				$configurazioneTemplate->setStatoDaeseguire("checked");
				$configurazioneTemplate->displayPagina();
				$replace = array('%messaggio%' => '%ml.creaConfigurazioneKo%');
				
				$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
				echo $utility->tailTemplate($template);
				
				include(self::$piede);				
			}		
		}
		else {
			include(self::$testata);
			$configurazioneTemplate->setStatoDaeseguire("checked");
			$configurazioneTemplate->displayPagina();
			include(self::$piede);
		}		
	}

	public function preparaPagina($configurazioneTemplate) {
		
		$configurazioneTemplate->setAzione(self::$azioneCreaConfigurazione);
		$configurazioneTemplate->setTestoAzione("%ml.creaConfigTip%");
		$configurazioneTemplate->setTitoloPagina("%ml.creaConfigurazione%");
		$configurazioneTemplate->setProgressivoTip("%ml.progressivoTip%");
		$configurazioneTemplate->setClasseTip("%ml.classeTip%");
		$configurazioneTemplate->setFilepathTip('%ml.filepathTip%');
	}
	
	private function inserisci() {
	
		require_once 'database.class.php';

		$db = new database();
		$db->beginTransaction();

		if ($this->creaConfigurazione($db)) {
			$db->commitTransaction();
			return TRUE;
		}
		return FALSE;		
	}
}

?>