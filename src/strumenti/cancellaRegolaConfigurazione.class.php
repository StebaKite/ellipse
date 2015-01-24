<?php

require_once 'strumenti.abstract.class.php';

class cancellaRegolaConfigurazione extends strumentiAbstract {

	public static $azioneCancellaRegolaConfigurazione = "../strumenti/cancellaRegolaConfigurazioneFacade.class.php?modo=go";

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
		require_once 'ricercaRegoleConfigurazione.class.php';
		require_once 'utility.class.php';
		
		$utility = new utility();
	
		if ($this->cancella()) {
			$ricercaRegoleConfigurazione = new ricercaRegoleConfigurazione();
			$ricercaRegoleConfigurazione->setMessaggio('%ml.cancellaRegolaConfigurazioneOk%');
			$ricercaRegoleConfigurazione->start();
		}
		else {
			include(self::$testata);
	
			$regolaConfigurazioneTemplate->displayPagina();
			$replace = array('%messaggio%' => '%ml.cancellaRegolaConfigurazioneKo%');
	
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
			echo $utility->tailTemplate($template);
	
			include(self::$piede);
		}
	}
	
	public function preparaPagina($regolaConfigurazioneTemplate) {
	
		$regolaConfigurazioneTemplate->setAzione(self::$azioneCancellaRegolaConfigurazione);
		$regolaConfigurazioneTemplate->setTestoAzione("%ml.cancellaRegolaConfigTip%");
		$regolaConfigurazioneTemplate->setTitoloPagina("%ml.cancellaRegolaConfigurazione%");
		$regolaConfigurazioneTemplate->setColonnaTip("%ml.colonnaTip%");
		$regolaConfigurazioneTemplate->setColonnaDisable("disabled");
		$regolaConfigurazioneTemplate->setPosizioneValoreTip("%ml.posizioneValoreTip%");
		$regolaConfigurazioneTemplate->setPosizioneValoreDisable("disabled");
	}
	
	private function cancella() {
	
		require_once 'database.class.php';
	
		$db = new database();
		$db->beginTransaction();
	
		if ($this->cancellaRegolaConfigurazione($db)) {
			$db->commitTransaction();
			return TRUE;
		}
		return FALSE;
	}
}

?>