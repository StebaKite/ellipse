<?php

require_once 'impostazioni.abstract.class.php';

class modificaListino extends impostazioniAbstract {

	public static $azioneModificaListino = "../impostazioni/modificaListinoFacade.class.php?modo=go";

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
		require_once 'utility.class.php';
	
		$listinoTemplate = new listinoTemplate();
		$this->preparaPagina($listinoTemplate);
	
		if ($listinoTemplate->controlliLogici()) {
			$utility = new utility();
	
			if ($this->modifica()) {
				include(self::$testata);
	
				$listinoTemplate->displayPagina();
				$replace = array('%messaggio%' => '%ml.modificaListinoOk%');
				$template = $utility->tailFile($utility->getTemplate(self::$messaggioInfo), $replace);
				echo $utility->tailTemplate($template);
	
				include(self::$piede);
			}
			else {
				include(self::$testata);
	
				$listinoTemplate->displayPagina();
				$replace = array('%messaggio%' => '%ml.modificaListinoKo%');
				$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
				echo $utility->tailTemplate($template);
	
				include(self::$piede);
			}
		}
		else {
			include(self::$testata);
			$listinoTemplate->displayPagina();
			include(self::$piede);
		}
	}
	
	public function preparaPagina($listinoTemplate) {
	
		$listinoTemplate->setAzione(self::$azioneModificaListino);
		$listinoTemplate->setTestoAzione("%ml.modificaListinoTip%");
		$listinoTemplate->setTitoloPagina("%ml.modificaListino%");
		$listinoTemplate->setCodiceListinoTip("%ml.codiceListinoTip%");
		$listinoTemplate->setDescrizioneListinoTip("%ml.descrizioneListinoTip%");
	}
	
	private function modifica() {
	
		require_once 'database.class.php';
	
		$db = new database();
		$db->beginTransaction();
	
		if ($this->modificaListino($db)) {
			$db->commitTransaction();
			return TRUE;
		}
		return FALSE;
	}
}
		
?>