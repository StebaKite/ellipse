<?php

require_once 'impostazioni.abstract.class.php';

class modificaVoce extends impostazioniAbstract {

	public static $azioneModificaVoce = "../impostazioni/modificaVoceFacade.class.php?modo=go";

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
		
		// Preleva i dati della voce selezionata

		require_once 'database.class.php';
		
		$db = new database();
		$db->beginTransaction();
		$voceTrovata = $this->leggiVoce($db);
		
		$row = pg_fetch_all($voceTrovata);
		$voceTemplate->setDescrizioneVoce(trim($row[0]['descrizione']));
		$voceTemplate->setPrezzo($row[0]['prezzo']);
		
		if($row[0]['tipo'] == "STD") {
			$voceTemplate->setTipoVoceStandard("checked");
			$voceTemplate->setTipoVoceGenerica("");
		}
		else {
			$voceTemplate->setTipoVoceGenerica("checked");
			$voceTemplate->setTipoVoceStandard("");
		}
		
		$db->commitTransaction();
		
		// Compone la pagina
		include(self::$testata);
		$voceTemplate->displayPagina();
		include(self::$piede);		
	}

	public function go() {
	
		error_log("<<<<<<< Go >>>>>>> " . $_SERVER['PHP_SELF']);
	
		require_once 'voce.template.php';
		require_once 'utility.class.php';
	
		$voceTemplate = new voceTemplate();
		$this->preparaPagina($voceTemplate);
	
		if ($voceTemplate->controlliLogici()) {
			$utility = new utility();
	
			if ($this->modifica()) {
				include(self::$testata);
				
				$voceTemplate->displayPagina();
				$replace = array('%messaggio%' => '%ml.modificaVoceOk%');
				
				$template = $utility->tailFile($utility->getTemplate(self::$messaggioInfo), $replace);
				echo $utility->tailTemplate($template);
				
				include(self::$piede);
							}
			else {
				include(self::$testata);
	
				$voceTemplate->displayPagina();
				$replace = array('%messaggio%' => '%ml.modificaVoceKo%');
	
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
	
		$voceTemplate->setAzione(self::$azioneModificaVoce);
		$voceTemplate->setTestoAzione("%ml.modificaVoceTip%");
		$voceTemplate->setTitoloPagina("%ml.modificaVoce%");
		$voceTemplate->setCodiceVoceTip("%ml.codiceVoceTip%");
		$voceTemplate->setDescrizioneVoceTip("%ml.descrizioneVoceTip%");
		$voceTemplate->setPrezzoTip("%ml.prezzoTip%");

		if($this->getTipoVoce() == "STD") {
			$voceTemplate->setTipoVoceStandard("checked");
			$voceTemplate->setTipoVoceGenerica("");
		}
		else {
			$voceTemplate->setTipoVoceGenerica("checked");
			$voceTemplate->setTipoVoceStandard("");
		}
	}
	
	private function modifica() {
	
		require_once 'database.class.php';
	
		$db = new database();
		$db->beginTransaction();
	
		if ($this->modificaVoce($db)) {
			$db->commitTransaction();
			return TRUE;
		}
		return FALSE;
	}
	
	
}		
		
?>