<?php

require_once 'preventivo.abstract.class.php';

class creaNotaPreventivo extends preventivoAbstract {

	public static $azioneCreaNotaPreventivo = "../preventivo/creaNotaPreventivoFacade.class.php?modo=go";
	
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
	
		require_once 'notaPreventivo.template.php';
		require_once 'utility.class.php';
	
		$notaPreventivoTemplate = new notaPreventivoTemplate();
		$this->preparaPagina($notaPreventivoTemplate);
	
		// Compone la pagina
		include(self::$testata);
		$notaPreventivoTemplate->inizializzaPagina();
		$notaPreventivoTemplate->displayPagina();
		include(self::$piede);
	}

	public function go() {
	
		error_log("<<<<<<< Go >>>>>>> " . $_SERVER['PHP_SELF']);

		require_once 'notaPreventivo.template.php';
		require_once 'ricercaNotaPreventivo.class.php';
		require_once 'utility.class.php';
		
		$notaPreventivoTemplate = new notaPreventivoTemplate();
		$this->preparaPagina($notaPreventivoTemplate);

		if ($notaPreventivoTemplate->controlliLogici()) {
			
			$utility = new utility();
		
			if ($this->inserisci($utility)) {
				$ricercaNotaPreventivo = new ricercaNotaPreventivo();
				$ricercaNotaPreventivo->setMessaggio('%ml.creaNotaOk%');
				$ricercaNotaPreventivo->start();
			}
			else {
				include(self::$testata);
		
				$notaPreventivoTemplate->displayPagina();
				$replace = array('%messaggio%' => '%ml.creaVoceKo%');
		
				$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
				echo $utility->tailTemplate($template);
		
				include(self::$piede);
			}
		}
		else {
			include(self::$testata);
			$notaPreventivoTemplate->displayPagina();
			include(self::$piede);
		}
	}

	public function preparaPagina($notaPreventivoTemplate) {

		$notaPreventivoTemplate->setAzione(self::$azioneCreaNotaPreventivo);
		$notaPreventivoTemplate->setTestoAzione("%ml.nuovaNotaTip%");
		$_SESSION['readonly'] = '';
		
		if ($_SESSION['idPreventivo'] != "") {
			$notaPreventivoTemplate->setTitoloPagina("%ml.creaNotaPreventivoPrincipale%");
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {
			$notaPreventivoTemplate->setTitoloPagina("%ml.creaNotaPreventivoSecondario%");
		}
	}

	private function inserisci($utility) {
	
		require_once 'database.class.php';
	
		$db = new database();
		$db->beginTransaction();
	
		$idPreventivo = ($_SESSION['idPreventivo'] != '') ? $_SESSION['idPreventivo'] : $_SESSION['idSottoPreventivo'];
		$query = ($_SESSION['idPreventivo'] != '') ? self::$queryCreaNotaPreventivoPrincipale : self::$queryCreaNotaPreventivoSecondario;
		
		if ($this->creaNotaPreventivo($db, $utility, $idPreventivo, $query)) {
			$db->commitTransaction();
			return TRUE;
		}
		return FALSE;
	}
}

?>