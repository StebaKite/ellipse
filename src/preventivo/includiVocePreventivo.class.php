<?php

require_once 'preventivo.abstract.class.php';

class includiVocePreventivo extends preventivoAbstract {

	function __construct() {

		self::$root = $_SERVER['DOCUMENT_ROOT'];
	}

	public function start() {

		error_log("<<<<<<< Start >>>>>>> " . $_SERVER['PHP_SELF']);

		require_once 'splitPreventivo.class.php';

		if ($this->includiVoce()) {
			$splitPreventivo = new splitPreventivo();
			$splitPreventivo->setMessaggio('%ml.includiVocePreventivoOk%');
			$splitPreventivo->go();				
		}
		else {
			$splitPreventivo = new splitPreventivo();
			$splitPreventivo->setMessaggio('%ml.includiVocePreventivoKo%');
			$splitPreventivo->go();
		}
	}

	private function includiVoce() {

		require_once 'database.class.php';

		$db = new database();
		$db->beginTransaction();

		if ($this->creaVoceSottoPreventivo($db, $_SESSION['idSottoPreventivo'], $_SESSION['nomeform'], $_SESSION['nomecampoform'], $_SESSION['codicevocelistino'])) {
			
			if ($this->cancellaVocePreventivo($db, $_SESSION['idVocePreventivo'])) {
				$db->commitTransaction();
				return TRUE;				
			}
		}
		return FALSE;
	}
}

?>