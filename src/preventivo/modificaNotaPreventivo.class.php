<?php

require_once 'preventivo.abstract.class.php';

class modificaNotaPreventivo extends preventivoAbstract {

	public static $azioneModificaNota = "../preventivo/modificaNotaPreventivoFacade.class.php?modo=go";

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
		require_once 'database.class.php';
		
		$utility = new utility();
		$db = new database();
	
		$db->beginTransaction();
		
		$notaPreventivoTemplate = new notaPreventivoTemplate();
		$this->preparaPagina($notaPreventivoTemplate, $db, $utility);
		$this->leggiNotaPreventivo($notaPreventivoTemplate, $db, $utility);
	
		$db->commitTransaction();
		
		// Compone la pagina
		include(self::$testata);
		$notaPreventivoTemplate->displayPagina();
		include(self::$piede);
	}
	
	public function go() {

		error_log("<<<<<<< Start >>>>>>> " . $_SERVER['PHP_SELF']);
		
		require_once 'notaPreventivo.template.php';
		require_once 'utility.class.php';
		require_once 'database.class.php';
		
		$utility = new utility();
		$db = new database();
		
		$db->beginTransaction();
		
		$notaPreventivoTemplate = new notaPreventivoTemplate();
		$this->preparaPagina($notaPreventivoTemplate, $db, $utility);

		include(self::$testata);
		
		if ($notaPreventivoTemplate->controlliLogici()) {
						
			if ($this->modifica($db, $utility)) {
				
				$notaPreventivoTemplate->displayPagina();
				$replace = array('%messaggio%' => '%ml.modificaNotaOk%');
				$template = $utility->tailFile($utility->getTemplate(self::$messaggioInfo), $replace);
				echo $utility->tailTemplate($template);
				$db->commitTransaction();				
			}
			else {				
				$notaPreventivoTemplate->displayPagina();
				$replace = array('%messaggio%' => '%ml.modificaNotaKo%');
				$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
				echo $utility->tailTemplate($template);
				$db->rollbackTransaction();				
			}
		}		
		else {
			$notaPreventivoTemplate->displayPagina();				
		}		
		include(self::$piede);
	}

	public function preparaPagina($notaPreventivoTemplate, $db, $utility) {
	
		$notaPreventivoTemplate->setAzione(self::$azioneModificaNota);
		$notaPreventivoTemplate->setTestoAzione("%ml.modificaNotaTip%");

		$titoloPagina = ($_SESSION['idPreventivo'] != "") ? '%ml.modificaNotaPreventivoPrincipale%' : '%ml.modificaNotaPreventivoSecondario%'; 
		$notaPreventivoTemplate->setTitoloPagina($titoloPagina);
		$_SESSION['readonly'] = '';
		
	}

	public function leggiNotaPreventivo($notaPreventivoTemplate, $db, $utility) {

		if ($_SESSION['idPreventivo'] != "") {
			$_SESSION['notapreventivo'] = $this->leggiNotaPreventivoPrincipale($db, $utility, $_SESSION['idNotaPreventivo']);
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {
			$_SESSION['notapreventivo'] = $this->leggiNotaPreventivoSecondario($db, $utility, $_SESSION['idNotaPreventivo']);
		}		
	}
	
	public function modifica($db, $utility) {

		if ($_SESSION['idPreventivo'] != "") {
			if ($this->modificaNotaPreventivoPrincipale($db, $utility)) return TRUE;
			else return FALSE;
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {
			if ($this->modificaNotaPreventivoSecondario($db, $utility)) return TRUE;
			else return FALSE;
		}
	}			
}
	
?>