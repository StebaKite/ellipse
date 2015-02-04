<?php

require_once 'preventivo.abstract.class.php';

class escludiVocePreventivo extends preventivoAbstract {

	function __construct() {

		self::$root = $_SERVER['DOCUMENT_ROOT'];
	}

	public function start() {

		error_log("<<<<<<< Start >>>>>>> " . $_SERVER['PHP_SELF']);

		require_once 'splitPreventivo.class.php';

		if ($this->escludiVoce()) {
			$splitPreventivo = new splitPreventivo();
			$splitPreventivo->setMessaggio('%ml.escludiVocePreventivoOk%');
			$splitPreventivo->go();
		}
		else {
			$splitPreventivo = new splitPreventivo();
			$splitPreventivo->setMessaggio('%ml.escludiVocePreventivoKo%');
			$splitPreventivo->go();
		}
	}

	private function escludiVoce() {

		require_once 'database.class.php';

		$db = new database();
		$db->beginTransaction();

		if ($this->creaVocePreventivo($db, $this->getIdPreventivo(), $this->getNomeForm(), $this->getNomeCampoForm(), $this->getCodiceVoceListino())) {
				
			if ($this->cancellaVoceSottoPreventivo($db, $this->getIdVoceSottoPreventivo())) {
				$db->commitTransaction();
				return TRUE;
			}
		}
		return FALSE;
	}
}

?>