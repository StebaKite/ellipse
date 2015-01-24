<?php

require_once 'impostazioni.abstract.class.php';

class creaVoce extends impostazioniAbstract {

	public static $azioneCreaVoce = "../impostazioni/creaVoceFacade.class.php?modo=go";

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

		require_once 'voce.template.php';
		require_once 'utility.class.php';
		
		$voceTemplate = new voceTemplate();
		$this->preparaPagina($voceTemplate);
		
		// Compone la pagina
		include(self::$testata);
		$voceTemplate->inizializzaPagina();
		$voceTemplate->displayPagina();
		include(self::$piede);
	}
		
	public function go() {

		error_log("<<<<<<< Go >>>>>>> " . $_SERVER['PHP_SELF']);
		
		require_once 'voce.template.php';
		require_once 'ricercaVoci.class.php';
		require_once 'utility.class.php';
		
		$voceTemplate = new voceTemplate();
		$this->preparaPagina($voceTemplate);
		
		if ($voceTemplate->controlliLogici()) {
			$utility = new utility();
		
			if ($this->inserisci()) {
				$voceTemplate = new ricercaVoci();
				$voceTemplate->setMessaggio('%ml.creaVoceOk%');
				$voceTemplate->start();
			}
			else {
				include(self::$testata);
		
				$voceTemplate->displayPagina();
				$replace = array('%messaggio%' => '%ml.creaVoceKo%');
		
				$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
				echo $utility->tailTemplate($template);
		
				include(self::$piede);
			}
		}
		else {
			include(self::$testata);
			$voceTemplate->setTipoVoceStandard("checked");
			$voceTemplate->displayPagina();
			include(self::$piede);
		}		
	}

	public function preparaPagina($voceTemplate) {
	
		$voceTemplate->setAzione(self::$azioneCreaVoce);
		$voceTemplate->setTestoAzione("%ml.nuovaVoceTip%");
		$voceTemplate->setTitoloPagina("%ml.creaVoce%");
		$voceTemplate->setCodiceVoceTip("%ml.codiceVoceTip%");
		$voceTemplate->setDescrizioneVoceTip("%ml.descrizioneVoceTip%");
		$voceTemplate->setPrezzoTip("%ml.prezzoTip%");
		$voceTemplate->setTipoVoceStandard("checked");
		$voceTemplate->setTipoVoceGenerica("");
	}
	
	private function inserisci() {
	
		require_once 'database.class.php';
	
		$db = new database();
		$db->beginTransaction();
	
		if ($this->creaVoce($db)) {
			$db->commitTransaction();
			return TRUE;
		}
		return FALSE;
	}
}		
		
?>