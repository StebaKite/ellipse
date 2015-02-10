<?php

require_once 'visita.abstract.class.php';

class preventivaVisita extends visitaAbstract {

	function __construct() {

		self::$root = $_SERVER['DOCUMENT_ROOT'];
	}

	// ------------------------------------------------

	public function start() {

		error_log("<<<<<<< Start >>>>>>> " . $_SERVER['PHP_SELF']);
				
		require_once 'ricercaVisita.class.php';
		require_once 'ricercaPreventivo.class.php';
		require_once 'database.class.php';
		require_once 'utility.class.php';
		
		$db = new database();
		$utility = new utility();
		
		$db->beginTransaction();
		
		if ($this->creaPreventivo($db)) {

			$db->commitTransaction();
				
			$idPreventivoUsato = $db->getLastIdUsed();				
			$vociVisita = $this->prelevaVociVisita($db, $utility, $this->getIdPaziente(), $this->getIdVisita());
			$esito = TRUE;

			$db->beginTransaction();
				
			foreach ($vociVisita as $row) {
				
				if (!$this->creaVocePreventivo($db, $idPreventivoUsato, trim($row['nomeform']), trim($row['nomecampoform']), trim($row['codicevocelistino']), trim($row['prezzo']))) {
					$esito = FALSE;
					break;
				}
			}
			if (!$esito) {
				$db->rollbackTransaction();
				$ricercaVisita = new ricercaVisita();
				$ricercaVisita->setMessaggio('%ml.creaPreventivoKo%');
				$ricercaVisita->start();				
			}
			else {
				
				// metto la visita in stato "Preventivata"
				if ($this->aggiornaStatoVisita($db, $this->getIdVisita(), '01')) {
					
					$db->commitTransaction();
					$ricercaPreventivo = new ricercaPreventivo();
					$ricercaPreventivo->setIdPaziente($this->getIdPaziente());
					$ricercaPreventivo->setCognome($this->getCognome());
					$ricercaPreventivo->setNome($this->getNome());
					$ricercaPreventivo->setDataNascita($this->getDataNascita());
					$ricercaPreventivo->setMessaggio('%ml.creaPreventivoOk%');
					$ricercaPreventivo->start();
				}
				else {
					$db->rollbackTransaction();
					$ricercaVisita = new ricercaVisita();
					$ricercaVisita->setMessaggio('%ml.creaPreventivoKo%');
					$ricercaVisita->start();
				}
			}
		}
		else {
			$db->rollbackTransaction();
			$ricercaVisita = new ricercaVisita();
			$ricercaVisita->setMessaggio('%ml.creaPreventivoKo%');
			$ricercaVisita->start();				
		}				
	}

	public function prelevaVociVisita($db, $utility, $idPaziente, $idVisita) {
		
		$replace = array(
				'%idpaziente%' => $idPaziente,
				'%idvisita%' => $idVisita 
		);
		
		$utility = new utility();
		$array = $utility->getConfig();
		$sqlTemplate = self::$root . $array['query'] . self::$queryRicercaVociVisitaPaziente;
		
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
		
		if ($result) return pg_fetch_all($result);
		else return "";
	}
}

?>