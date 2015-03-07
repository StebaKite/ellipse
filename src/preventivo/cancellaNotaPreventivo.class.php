<?php

require_once 'preventivo.abstract.class.php';

class cancellaNotaPreventivo extends preventivoAbstract {

	public static $azioneCancellaNota = "../preventivo/cancellaNotaPreventivoFacade.class.php?modo=go";

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
		require_once 'ricercaNotaPreventivo.class.php';
		require_once 'utility.class.php';
		require_once 'database.class.php';

		$utility = new utility();
		$db = new database();

		$db->beginTransaction();

		$notaPreventivoTemplate = new notaPreventivoTemplate();
		$this->preparaPagina($notaPreventivoTemplate, $db, $utility);

		include(self::$testata);

		if ($this->cancella($db, $utility)) {

			$db->commitTransaction();				
			$ricercaNotaPreventivo = new ricercaNotaPreventivo();
			$ricercaNotaPreventivo->setMessaggio('%ml.cancellaNotaOk%');				
			$ricercaNotaPreventivo->start();
		}
		else {
			$notaPreventivoTemplate->displayPagina();
			$replace = array('%messaggio%' => '%ml.cancellaNotaKo%');
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
			echo $utility->tailTemplate($template);
			$db->rollbackTransaction();
		}
		include(self::$piede);
	}

	public function preparaPagina($notaPreventivoTemplate, $db, $utility) {

		$notaPreventivoTemplate->setAzione(self::$azioneCancellaNota);
		$notaPreventivoTemplate->setTestoAzione("%ml.cancellaNotaTip%");

		$titoloPagina = ($_SESSION['idPreventivo'] != "") ? '%ml.cancellaNotaPreventivoPrincipale%' : '%ml.cancellaNotaPreventivoSecondario%';
		$notaPreventivoTemplate->setTitoloPagina($titoloPagina);
		$_SESSION['readonly'] = 'readonly';
	}

	public function leggiNotaPreventivo($notaPreventivoTemplate, $db, $utility) {

		if ($_SESSION['idPreventivo'] != "") {
			$_SESSION['notapreventivo'] = $this->leggiNotaPreventivoPrincipale($db, $utility, $_SESSION['idNotaPreventivo']);
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {
			$_SESSION['notapreventivo'] = $this->leggiNotaPreventivoSecondario($db, $utility, $_SESSION['idNotaPreventivo']);
		}
	}

	public function cancella($db, $utility) {

		if ($_SESSION['idPreventivo'] != "") {
			if ($this->cancellaNotaPreventivoPrincipale($db, $utility)) return TRUE;
			else return FALSE;
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {
			if ($this->cancellaNotaPreventivoSecondario($db, $utility)) return TRUE;
			else return FALSE;
		}
	}
}

?>