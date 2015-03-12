<?php

require_once 'preventivo.abstract.class.php';

class creaNotaVocePreventivo extends preventivoAbstract {

	public static $azioneCreaNotaVocePreventivo = "../preventivo/creaNotaVocePreventivoFacade.class.php?modo=go";

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

		$notaVocePreventivoTemplate = new notaVocePreventivoTemplate();
		$this->preparaPagina($notaVocePreventivoTemplate);

		// Compone la pagina
		include(self::$testata);
		$notaVocePreventivoTemplate->inizializzaPagina();
		$notaVocePreventivoTemplate->displayPagina();
		include(self::$piede);
	}

	public function go() {

		error_log("<<<<<<< Go >>>>>>> " . $_SERVER['PHP_SELF']);

		require_once 'notaVocePreventivo.template.php';
		require_once 'ricercaNotaVocePreventivo.class.php';
		require_once 'utility.class.php';

		$notaVocePreventivoTemplate = new notaVocePreventivoTemplate();
		$this->preparaPagina($notaVocePreventivoTemplate);

		if ($notaVocePreventivoTemplate->controlliLogici()) {
				
			$utility = new utility();

			if ($this->inserisci($utility)) {
				$ricercaNotaVocePreventivo = new ricercaNotaVocePreventivo();
				$ricercaNotaVocePreventivo->setMessaggio('%ml.creaNotaOk%');
				$ricercaNotaVocePreventivo->start();
			}
			else {
				include(self::$testata);

				$notaVocePreventivoTemplate->displayPagina();
				$replace = array('%messaggio%' => '%ml.creaVoceKo%');

				$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
				echo $utility->tailTemplate($template);

				include(self::$piede);
			}
		}
		else {
			include(self::$testata);
			$notaVocePreventivoTemplate->displayPagina();
			include(self::$piede);
		}
	}

	public function preparaPagina($notaVocePreventivoTemplate) {

		$notaVocePreventivoTemplate->setAzione(self::$azioneCreaNotaVocePreventivo);
		$notaVocePreventivoTemplate->setTestoAzione("%ml.nuovaNotaTip%");
		$_SESSION['readonly'] = '';

		if ($_SESSION['idPreventivo'] != "") {
			$notaVocePreventivoTemplate->setTitoloPagina("%ml.creaNotaVocePreventivoPrincipale%");
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {
			$notaVocePreventivoTemplate->setTitoloPagina("%ml.creaNotaVocePreventivoSecondario%");
		}
	}

	private function inserisci($utility) {

		require_once 'database.class.php';

		$db = new database();
		$db->beginTransaction();

		$idVocePreventivo = ($_SESSION['idPreventivo'] != '') ? $_SESSION['idVocePreventivo'] : $_SESSION['idVoceSottoPreventivo'];
		$query = ($_SESSION['idPreventivo'] != '') ? self::$queryCreaNotaVocePreventivoPrincipale : self::$queryCreaNotaVocePreventivoSecondario;

		if ($this->creaNotaVocePreventivo($db, $utility, $idVocePreventivo, $query)) {
			$db->commitTransaction();
			return TRUE;
		}
		return FALSE;
	}
}

?>