<?php

require_once 'preventivo.abstract.class.php';

class ricercaNotaVocePreventivo extends preventivoAbstract {

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

		require_once 'ricercaNotaVoce.template.php';
		require_once 'utility.class.php';
		
		// Template
		$utility = new utility();
		$array = $utility->getConfig();
		
		$ricercaNotaVoceTemplate = new ricercaNotaVoceTemplate();
		
		// Il messaggio
		$ricercaNotaVoceTemplate->setMessaggio($this->getMessaggio());
		
		include(self::$testata);
		$ricercaNotaVoceTemplate->displayFiltri();
		
		if ($this->ricerca($ricercaNotaVoceTemplate)) {
			$ricercaNotaVoceTemplate->displayRisultati();
		}
		else {
			$replace = array('%messaggio%' => $text0 . '%ml.ricercaNotaKo%');
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
			echo $utility->tailTemplate($template);
		}
		include(self::$piede);
	}
	
	public function go() {}

	private function ricerca($ricercaNotaVoceTemplate) {

		if ($_SESSION['idPreventivo'] != '') {
			return $this->leggiNotaVocePreventivo($_SESSION['idVocePreventivo'], self::$queryRicercaNotaVocePreventivoPrincipale);
		}
		elseif ($_SESSION['idSottoPreventivo'] != '') {
			return $this->leggiNotaVocePreventivo($_SESSION['idVoceSottoPreventivo'], self::$queryRicercaNotaVocePreventivoSecondario);
		}
	}
}

?>