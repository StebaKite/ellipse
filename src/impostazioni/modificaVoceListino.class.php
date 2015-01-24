<?php

require_once 'impostazioni.abstract.class.php';

class modificaVoceListino  extends impostazioniAbstract {

	public static $azioneModificaVoceListino = "../impostazioni/modificaVoceListinoFacade.class.php?modo=go";
	
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

	public function start() {

		error_log("<<<<<<< Start >>>>>>> " . $_SERVER['PHP_SELF']);
		
		require_once 'voceListino.template.php';
		require_once 'utility.class.php';
		
		$voceListinoTemplate = new voceListinoTemplate();
		$this->preparaPagina($voceListinoTemplate);
		
		// Compone la pagina
		include(self::$testata);
		$voceListinoTemplate->displayPagina();
		include(self::$piede);
	}

	public function go() {
	
		error_log("<<<<<<< Go >>>>>>> " . $_SERVER['PHP_SELF']);
	
		require_once 'voceListino.template.php';
		require_once 'utility.class.php';
	
		$voceListinoTemplate = new voceListinoTemplate();
		$this->preparaPagina($voceListinoTemplate);
	
		if ($voceListinoTemplate->controlliLogici()) {
			$utility = new utility();
	
			if ($this->modifica()) {
				include(self::$testata);
	
				$voceListinoTemplate->displayPagina();
				$replace = array('%messaggio%' => '%ml.modificaVoceListinoOk%');
				$template = $utility->tailFile($utility->getTemplate(self::$messaggioInfo), $replace);
				echo $utility->tailTemplate($template);
	
				include(self::$piede);
			}
			else {
				include(self::$testata);
	
				$voceListinoTemplate->displayPagina();
				$replace = array('%messaggio%' => '%ml.modificaVoceListinoKo%');
				$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
				echo $utility->tailTemplate($template);
	
				include(self::$piede);
			}
		}
		else {
			include(self::$testata);
			$voceListinoTemplate->displayPagina();
			include(self::$piede);
		}
	}
	
	public function preparaPagina($voceListinoTemplate) {
	
		$voceListinoTemplate->setAzione(self::$azioneModificaVoceListino);
		$voceListinoTemplate->setTestoAzione("%ml.modificaVoceListinoTip%");
		$voceListinoTemplate->setTitoloPagina("%ml.modificaVoceListino%");
		$voceListinoTemplate->setPrezzoTip("%ml.prezzoTip%");
	}
	
	private function modifica() {
	
		require_once 'database.class.php';
	
		$db = new database();
		$db->beginTransaction();
	
		if ($this->modificaVoceListino($db)) {
			$db->commitTransaction();
			return TRUE;
		}
		return FALSE;
	}
}	
		
?>