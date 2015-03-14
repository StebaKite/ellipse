<?php

require_once 'preventivo.abstract.class.php';

class ricercaNotaPreventivo extends preventivoAbstract {
	
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

		require_once 'ricercaNota.template.php';
		require_once 'utility.class.php';
		
		// Template
		$utility = new utility();
		$array = $utility->getConfig();
		
		$ricercaNotaTemplate = new ricercaNotaTemplate();
		
		// Il messaggio
		$ricercaNotaTemplate->setMessaggio($this->getMessaggio());
		
		include(self::$testata);
		$ricercaNotaTemplate->displayFiltri();
		
		if ($this->ricerca($ricercaNotaTemplate)) {
			$ricercaNotaTemplate->displayRisultati();
		}
		else {
			$replace = array('%messaggio%' => $text0 . '%ml.ricercaNotaKo%');
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
			echo $utility->tailTemplate($template);
		}
		include(self::$piede);		
	}

	public function go() {
		
	}

	private function ricerca($ricercaNotaTemplate) {

		if ($_SESSION['idPreventivo'] != '') {
			return $this->leggiNotaPreventivo($_SESSION['idPreventivo'], self::$queryRicercaNotaPreventivoPrincipale);
		}
		elseif ($_SESSION['idSottoPreventivo'] != '') {
			return $this->leggiNotaPreventivo($_SESSION['idSottoPreventivo'], self::$queryRicercaNotaPreventivoSecondario);
		}
	}
}

?>