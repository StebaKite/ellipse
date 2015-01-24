<?php

require_once 'impostazioni.abstract.class.php';

class cancellaVoce extends impostazioniAbstract {

	public static $azioneCancellaVoce = "../impostazioni/cancellaVoceFacade.class.php?modo=go";

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
		require_once 'ricercaVoci.class.php';
		require_once 'utility.class.php';
	
		$voceTemplate = new voceTemplate();
		$this->preparaPagina($voceTemplate);
	
		$utility = new utility();

		if ($this->cancella()) {
			$voceTemplate = new ricercaVoci();
			$voceTemplate->setMessaggio('%ml.cancellaVoceOk%');
			$voceTemplate->start();
		}
		else {
			include(self::$testata);

			$voceTemplate->displayPagina();
			$replace = array('%messaggio%' => '%ml.cancellaVoceKo%');

			$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
			echo $utility->tailTemplate($template);

			include(self::$piede);
		}
	}
	
	public function preparaPagina($voceTemplate) {
	
		$voceTemplate->setAzione(self::$azioneCancellaVoce);
		$voceTemplate->setTestoAzione("%ml.cancellaVoceTip%");
		$voceTemplate->setTitoloPagina("%ml.cancellaVoce%");
		$voceTemplate->setCodiceVoceTip("%ml.codiceVoceTip%");
		$voceTemplate->setCodiceVoceDisable("disabled");
		$voceTemplate->setDescrizioneVoceTip("%ml.descrizioneVoceTip%");
		$voceTemplate->setDescrizioneVoceDisable("disabled");
		$voceTemplate->setPrezzoTip("%ml.prezzoTip%");
		$voceTemplate->setPrezzoDisable("disabled");
		
		if($this->getTipoVoce() == "STD") {
			$voceTemplate->setTipoVoceStandard("checked");
			$voceTemplate->setTipoVoceGenerica("");
		}
		else {
			$voceTemplate->setTipoVoceGenerica("checked");
			$voceTemplate->setTipoVoceStandard("");
		}
	}
	
	private function cancella() {
	
		require_once 'database.class.php';
	
		$db = new database();
		$db->beginTransaction();
	
		if ($this->cancellaVoce($db)) {
			$db->commitTransaction();
			return TRUE;
		}
		return FALSE;
	}
	
}	
	
?>