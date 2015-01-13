<?php

require_once 'strumenti.abstract.class.php';

class creaConfigurazione extends strumentiAbstract {

	public static $azioneCreaConfigurazione = "../strumenti/creaConfigurazioneFacade.class.php?modo=go";

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
		
		require_once 'creaConfigurazione.template.php';
		require_once 'utility.class.php';
		
		$creaConfigurazioneTemplate = new creaConfigurazioneTemplate();
		$this->preparaPagina($creaConfigurazioneTemplate);
				
		// Compone la pagina
		include(self::$testata);
		$creaConfigurazioneTemplate->inizializzaPagina();
		$creaConfigurazioneTemplate->displayPagina();
		include(self::$piede);		
	}	
	

	public function go() {

		error_log("<<<<<<< Go >>>>>>> " . $_SERVER['PHP_SELF']);
		
		require_once 'creaConfigurazione.template.php';
		require_once 'ricercaConfigurazioni.class.php';
		require_once 'utility.class.php';
		
		$creaConfigurazioneTemplate = new creaConfigurazioneTemplate();
		$this->preparaPagina($creaConfigurazioneTemplate);
		
		if ($creaConfigurazioneTemplate->controlliLogici()) {
			
			if ($this->inserisci()) {
				$ricercaConfigurazioni = new ricercaConfigurazioni();
				$ricercaConfigurazioni->setMessaggio('%ml.creaConfigurazioneOk%');
				$ricercaConfigurazioni->start();
			}
			else {
				include(self::$testata);
				
				$paziente->displayPagina();
				$replace = array('%messaggio%' => '%ml.creaConfigurazioneKo%');
				
				$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
				echo $utility->tailTemplate($template);
				
				include(self::$piede);				
			}		
		}
		else {
			include(self::$testata);
			$creaConfigurazioneTemplate->displayPagina();
			include(self::$piede);
		}		
	}

	public function preparaPagina($creaConfigurazioneTemplate) {
		
		$creaConfigurazioneTemplate->setAzione(self::$azioneCreaConfigurazione);
		$creaConfigurazioneTemplate->setTestoAzione("%ml.creaConfigTip%");
		$creaConfigurazioneTemplate->setTitoloPagina("%ml.creaConfigurazione%");
		$creaConfigurazioneTemplate->setProgressivoTip("%ml.progressivoTip%");
		$creaConfigurazioneTemplate->setClasseTip("%ml.classeTip%");
		$creaConfigurazioneTemplate->setFilepathTip('%ml.filepathTip%');
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