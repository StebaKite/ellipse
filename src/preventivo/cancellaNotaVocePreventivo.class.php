<?php

require_once 'preventivo.abstract.class.php';

class cancellaNotaVocePreventivo extends preventivoAbstract {

	public static $azioneCancellaNota = "../preventivo/cancellaNotaVocePreventivoFacade.class.php?modo=go";

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

		require_once 'notaVocePreventivo.template.php';
		require_once 'utility.class.php';
		require_once 'database.class.php';

		$utility = new utility();
		$db = new database();

		$db->beginTransaction();

		$notaVocePreventivoTemplate = new notaVocePreventivoTemplate();
		$this->preparaPagina($notaVocePreventivoTemplate, $db, $utility);
		$this->leggiNotaPreventivo($notaVocePreventivoTemplate, $db, $utility);

		$db->commitTransaction();

		// Compone la pagina
		include(self::$testata);
		$notaVocePreventivoTemplate->displayPagina();
		include(self::$piede);
	}

	public function go() {

		error_log("<<<<<<< Start >>>>>>> " . $_SERVER['PHP_SELF']);

		require_once 'notaVocePreventivo.template.php';
		require_once 'ricercaNotaVocePreventivo.class.php';
		require_once 'utility.class.php';
		require_once 'database.class.php';

		$utility = new utility();
		$db = new database();

		$db->beginTransaction();

		$notaVocePreventivoTemplate = new notaVocePreventivoTemplate();
		$this->preparaPagina($notaVocePreventivoTemplate, $db, $utility);

		include(self::$testata);

		if ($this->cancella($db, $utility)) {

			$db->commitTransaction();
			$ricercaNotaVocePreventivo = new ricercaNotaVocePreventivo();
			$ricercaNotaVocePreventivo->setMessaggio('%ml.cancellaNotaOk%');
			$ricercaNotaVocePreventivo->start();
		}
		else {
			$notaVocePreventivoTemplate->displayPagina();
			$replace = array('%messaggio%' => '%ml.cancellaNotaKo%');
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
			echo $utility->tailTemplate($template);
			$db->rollbackTransaction();
		}
		include(self::$piede);
	}

	public function preparaPagina($notaVocePreventivoTemplate, $db, $utility) {

		$notaVocePreventivoTemplate->setAzione(self::$azioneCancellaNota);
		$notaVocePreventivoTemplate->setTestoAzione("%ml.cancellaNotaTip%");

		$titoloPagina = ($_SESSION['idPreventivo'] != "") ? '%ml.cancellaNotaVocePreventivoPrincipale%' : '%ml.cancellaNotaVocePreventivoSecondario%';
		$notaVocePreventivoTemplate->setTitoloPagina($titoloPagina);
		$_SESSION['readonly'] = 'readonly';
	}

	public function leggiNotaPreventivo($notaVocePreventivoTemplate, $db, $utility) {

		if ($_SESSION['idPreventivo'] != "") {
			$_SESSION['notapreventivo'] = $this->leggiNotaVocePreventivoPrincipale($db, $utility, $_SESSION['idNotaVocePreventivo']);
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {
			$_SESSION['notapreventivo'] = $this->leggiNotaVocePreventivoSecondario($db, $utility, $_SESSION['idNotaVocePreventivo']);
		}
	}

	public function cancella($db, $utility) {

		if ($_SESSION['idPreventivo'] != "") {
			if ($this->cancellaNotaVocePreventivoPrincipale($db, $utility)) return TRUE;
			else return FALSE;
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {
			if ($this->cancellaNotaVocePreventivoSecondario($db, $utility)) return TRUE;
			else return FALSE;
		}
	}
}

?>