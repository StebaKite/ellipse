<?php

require_once 'strumenti.abstract.class.php';

class creaRegolaConfigurazione extends strumentiAbstract {

	public static $azioneCreaRegolaConfigurazione = "../strumenti/creaRegolaConfigurazioneFacade.class.php?modo=go";

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

		require_once 'regolaConfigurazione.template.php';
		require_once 'utility.class.php';
		
		$regolaconfigurazioneTemplate = new regolaconfigurazioneTemplate();
		$this->preparaPagina($regolaconfigurazioneTemplate);
		
		// Compone la pagina
		include(self::$testata);
		$regolaconfigurazioneTemplate->inizializzaPagina();
		$regolaconfigurazioneTemplate->displayPagina();
		include(self::$piede);
	}
		
	public function go() {
	
		error_log("<<<<<<< Go >>>>>>> " . $_SERVER['PHP_SELF']);

		require_once 'regolaConfigurazione.template.php';
		require_once 'ricercaRegoleConfigurazione.class.php';
		require_once 'utility.class.php';
		
		$regolaConfigurazioneTemplate = new regolaConfigurazioneTemplate();
		$this->preparaPagina($regolaConfigurazioneTemplate);
		
		if ($regolaConfigurazioneTemplate->controlliLogici()) {
			$utility = new utility();
		
			if ($this->inserisci()) {
				$ricercaRegoleConfigurazione = new ricercaRegoleConfigurazione();
				$ricercaRegoleConfigurazione->setMessaggio('%ml.creaRegolaConfigurazioneOk%');
				$ricercaRegoleConfigurazione->start();
			}
			else {
				include(self::$testata);
		
				$regolaConfigurazioneTemplate->displayPagina();
				$replace = array('%messaggio%' => '%ml.creaRegolaConfigurazioneKo%');
		
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

	public function preparaPagina($regolaconfigurazioneTemplate) {
	
		$regolaconfigurazioneTemplate->setAzione(self::$azioneCreaRegolaConfigurazione);
		$regolaconfigurazioneTemplate->setTestoAzione("%ml.creaRegolaConfigTip%");
		$regolaconfigurazioneTemplate->setTitoloPagina("%ml.creaRegolaConfigurazione%");
		$regolaconfigurazioneTemplate->setColonnaTip("%ml.colonnaTip%");
		$regolaconfigurazioneTemplate->setPosizioneValoreTip("%ml.posizioneValoreTip%");
	}
	
	private function inserisci() {
	
		require_once 'database.class.php';
	
		$db = new database();
		$db->beginTransaction();
	
		if ($this->creaRegolaConfigurazione($db)) {
			$db->commitTransaction();
			return TRUE;
		}
		return FALSE;
	}
	
		
		
}		
		
?>