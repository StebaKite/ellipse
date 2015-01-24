<?php

require_once 'impostazioni.abstract.class.php';

class cancellaListino extends impostazioniAbstract {

	public static $azioneCancellaListino = "../impostazioni/cancellaListinoFacade.class.php?modo=go";

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

		require_once 'listino.template.php';
		require_once 'utility.class.php';

		$listinoTemplate = new listinoTemplate();
		$this->preparaPagina($listinoTemplate);

		// Compone la pagina
		include(self::$testata);
		$listinoTemplate->displayPagina();
		include(self::$piede);
	}

	public function go() {
	
		error_log("<<<<<<< Go >>>>>>> " . $_SERVER['PHP_SELF']);
	
		require_once 'listino.template.php';
		require_once 'ricercaListino.class.php';
		require_once 'utility.class.php';
	
		$listinoTemplate = new listinoTemplate();
		$this->preparaPagina($listinoTemplate);
	
		$utility = new utility();
	
		if ($this->cancella()) {
			$ricercaListino = new ricercaListino();
			$ricercaListino->setMessaggio('%ml.cancellaListinoOk%');
			$ricercaListino->start();
		}
		else {
			include(self::$testata);
	
			$listinoTemplate->displayPagina();
			$replace = array('%messaggio%' => '%ml.cancellaListinoKo%');
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
			echo $utility->tailTemplate($template);
	
			include(self::$piede);
		}
	}
	
	public function preparaPagina($listinoTemplate) {
	
		$listinoTemplate->setAzione(self::$azioneCancellaListino);
		$listinoTemplate->setTestoAzione("%ml.cancellaListinoTip%");
		$listinoTemplate->setTitoloPagina("%ml.cancellaListino%");
		$listinoTemplate->setCodiceListinoTip("");
		$listinoTemplate->setCodiceListinoDisable("disabled");
		$listinoTemplate->setDescrizioneListinoTip("");
		$listinoTemplate->setDescrizioneListinoDisable("disabled");
	}
	
	private function cancella() {
	
		require_once 'database.class.php';
	
		$db = new database();
		$db->beginTransaction();
	
		if ($this->cancellaListino($db)) {
			$db->commitTransaction();
			return TRUE;
		}
		return FALSE;
	}
}
	
?>