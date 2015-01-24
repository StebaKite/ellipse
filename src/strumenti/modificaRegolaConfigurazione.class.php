<?php

require_once 'strumenti.abstract.class.php';

class modificaRegolaConfigurazione extends strumentiAbstract {

	public static $azioneModificaRegolaConfigurazione = "../strumenti/modificaRegolaConfigurazioneFacade.class.php?modo=go";

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

		require_once 'regolaConfigurazione.template.php';
		require_once 'utility.class.php';
		
		$regolaConfigurazioneTemplate = new regolaConfigurazioneTemplate();
		$this->preparaPagina($regolaConfigurazioneTemplate);
		
		// Compone la pagina
		include(self::$testata);
		$regolaConfigurazioneTemplate->displayPagina();
		include(self::$piede);
	}
	
	public function go() {
	
		error_log("<<<<<<< Go >>>>>>> " . $_SERVER['PHP_SELF']);

		require_once 'regolaConfigurazione.template.php';
		require_once 'utility.class.php';
		
		$regolaConfigurazioneTemplate = new regolaConfigurazioneTemplate();
		$this->preparaPagina($regolaConfigurazioneTemplate);
		
		if ($regolaConfigurazioneTemplate->controlliLogici()) {
			$utility = new utility();
		
			if ($this->modifica()) {
				include(self::$testata);
		
				$regolaConfigurazioneTemplate->displayPagina();
				$replace = array('%messaggio%' => '%ml.modificaRegolaConfigurazioneOk%');
				$template = $utility->tailFile($utility->getTemplate(self::$messaggioInfo), $replace);
				echo $utility->tailTemplate($template);
		
				include(self::$piede);
			}
			else {
				include(self::$testata);
		
				$regolaConfigurazioneTemplate->displayPagina();
				$replace = array('%messaggio%' => '%ml.modificaRegolaConfigurazioneKo%');
				$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
				echo $utility->tailTemplate($template);
		
				include(self::$piede);
			}
		}
		else {
			include(self::$testata);
			$regolaConfigurazioneTemplate->displayPagina();
			include(self::$piede);
		}
	}
		
	public function preparaPagina($regolaConfigurazioneTemplate) {
	
		$regolaConfigurazioneTemplate->setAzione(self::$azioneModificaRegolaConfigurazione);
		$regolaConfigurazioneTemplate->setTestoAzione("%ml.modificaRegolaConfigTip%");
		$regolaConfigurazioneTemplate->setTitoloPagina("%ml.modificaRegolaConfigurazione%");
		$regolaConfigurazioneTemplate->setColonnaTip("%ml.colonnaTip%");
		$regolaConfigurazioneTemplate->setPosizioneValoreTip("%ml.posizioneValoreTip%");		
	}
	
	private function modifica() {
	
		require_once 'database.class.php';
	
		$db = new database();
		$db->beginTransaction();
	
		if ($this->modificaRegolaConfigurazione($db)) {
			$db->commitTransaction();
			return TRUE;
		}
		return FALSE;
	}
}		

?>