<?php

require_once 'preventivo.abstract.class.php';

class modificaNotaVocePreventivo extends preventivoAbstract {

	public static $azioneModificaNota = "../preventivo/modificaNotaVocePreventivoFacade.class.php?modo=go";

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
		$this->leggiNotaVocePreventivo($notaVocePreventivoTemplate, $db, $utility);

		$db->commitTransaction();

		// Compone la pagina
		include(self::$testata);
		$notaVocePreventivoTemplate->displayPagina();
		include(self::$piede);
	}

	public function go() {

		error_log("<<<<<<< Start >>>>>>> " . $_SERVER['PHP_SELF']);

		require_once 'notaVocePreventivo.template.php';
		require_once 'utility.class.php';
		require_once 'database.class.php';

		$utility = new utility();
		$db = new database();

		$db->beginTransaction();
		
		$notaVocePreventivoTemplate = new notaVocePreventivoTemplate();
		$this->preparaPagina($notaVocePreventivoTemplate, $db, $utility);

		include(self::$testata);

		if ($notaVocePreventivoTemplate->controlliLogici()) {

			if ($this->modifica($db, $utility)) {

				$notaVocePreventivoTemplate->displayPagina();
				$replace = array('%messaggio%' => '%ml.modificaNotaOk%');
				$template = $utility->tailFile($utility->getTemplate(self::$messaggioInfo), $replace);
				echo $utility->tailTemplate($template);
				$db->commitTransaction();
			}
			else {
				$notaVocePreventivoTemplate->displayPagina();
				$replace = array('%messaggio%' => '%ml.modificaNotaKo%');
				$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
				echo $utility->tailTemplate($template);
				$db->rollbackTransaction();
			}
		}
		else {
			$notaVocePreventivoTemplate->displayPagina();
		}
		include(self::$piede);
	}

	public function preparaPagina($notaVocePreventivoTemplate, $db, $utility) {

		$notaVocePreventivoTemplate->setAzione(self::$azioneModificaNota);
		$notaVocePreventivoTemplate->setTestoAzione("%ml.modificaNotaTip%");

		$titoloPagina = ($_SESSION['idPreventivo'] != "") ? '%ml.modificaNotaVocePreventivoPrincipale%' : '%ml.modificaNotaVocePreventivoSecondario%';
		$notaVocePreventivoTemplate->setTitoloPagina($titoloPagina);
		$_SESSION['readonly'] = '';
	}

	public function leggiNotaVocePreventivo($notaVocePreventivoTemplate, $db, $utility) {

		if ($_SESSION['idPreventivo'] != "") {
			$_SESSION['notapreventivo'] = $this->leggiNotaVocePreventivoPrincipale($db, $utility, $_SESSION['idNotaVocePreventivo']);
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {
			$_SESSION['notapreventivo'] = $this->leggiNotaVocePreventivoSecondario($db, $utility, $_SESSION['idNotaVocePreventivo']);
		}
	}

	public function modifica($db, $utility) {

		if ($_SESSION['idPreventivo'] != "") {
			if ($this->modificaNotaVocePreventivoPrincipale($db, $utility)) return TRUE;
			else return FALSE;
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {
			if ($this->modificaNotaVocePreventivoSecondario($db, $utility)) return TRUE;
			else return FALSE;
		}
	}
}

?>