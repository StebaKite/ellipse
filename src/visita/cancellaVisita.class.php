<?php

require_once 'visita.abstract.class.php';

class cancellaVisita extends visitaAbstract {
	
	public static $azione = "../visita/cancellaVisitaFacade.class.php?modo=go";

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

		require_once 'dettaglioVisita.template.php';
		require_once 'utility.class.php';
		require_once 'database.class.php';

		error_log("<<<<<<< Start >>>>>>> " . $_SERVER['PHP_SELF']);

		// Template
		$utility = new utility();
		$db = new database();
		$array = $utility->getConfig();

		$riepilogoVociVisita = new riepilogoVociVisita();
		$this->preparaPagina($db, $utility, $array, $riepilogoVociVisita);

		// Compone la pagina
		include(self::$testata);
		$riepilogoVociVisita->displayPagina();
		include(self::$piede);		
	}
		
	public function go() {

		require_once 'dettaglioVisita.template.php';
		require_once 'ricercaVisita.class.php';
		require_once 'utility.class.php';
		require_once 'database.class.php';

		error_log("<<<<<<< Go >>>>>>> " . $_SERVER['PHP_SELF']);

		// Template
		$utility = new utility();
		$db = new database();
		$array = $utility->getConfig();

		$riepilogoVociVisita = new riepilogoVociVisita();
		$this->preparaPagina($db, $utility, $array, $riepilogoVociVisita);

		if ($this->cancella($_SESSION['idPaziente'], $_SESSION['idVisita'])) {
			$ricercaVisita = new ricercaVisita();
			$ricercaVisita->setMessaggio('%ml.canVisitaOk%');
			$ricercaVisita->start();
		}
		else {
			include(self::$testata);			
			$riepilogoVociVisita->displayPagina();
			$replace = array('%messaggio%' => '%ml.canVisitaKo%');				
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);			
			echo $utility->tailTemplate($template);
			include(self::$piede);		
		}
	}

	public function preparaPagina($db, $utility, $array, $riepilogoVociVisita) {

		$riepilogoVociVisita->setAzione(self::$azione);
		$riepilogoVociVisita->setLabelBottone("%ml.conferma%");
		$riepilogoVociVisita->setConfermaTip("%ml.confermaCancellazioneVisita%");						
		$riepilogoVociVisita->setTitoloPagina("%ml.cancellaVisita%");

		$db = new database();

		//-- Prelevo i tipi voci caricati -----------------------------------------------------------
		
		$replace = array(
			'%idpaziente%' => $_SESSION['idPaziente'],
			'%idvisita%' => $_SESSION['idVisita']
		);
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryRiepilogoTipiVociVisitaPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);

		$tipiVoci = pg_fetch_all($result);

		unset($_SESSION['vocivisitadentisingoli']);
		unset($_SESSION['vocivisitagruppi']);
		unset($_SESSION['vocivisitacure']);
		
		if ($tipiVoci) {
			foreach ($tipiVoci as $row) {
				if (trim($row['tipovoce']) == 'singoli') $this->prelevaVociDentiSingoli($db, $utility, $array, $riepilogoVociVisita); 
				if (trim($row['tipovoce']) == 'gruppi') $this->prelevaVociGruppi($db, $utility, $array, $riepilogoVociVisita); 
				if (trim($row['tipovoce']) == 'cure') $this->prelevaVociCure($db, $utility, $array, $riepilogoVociVisita); 
			}
		}
	}

	public function cancella($idPaziente, $idVisita) {

		require_once 'database.class.php';
		require_once 'utility.class.php';

		// Template
		$utility = new utility();
		$array = $utility->getConfig();

		// carica e ritaglia il comando sql da lanciare
		$replace = array(
			'%idpaziente%' => $idPaziente,
			'%idvisita%' => $idVisita
		);

		$sqlTemplate = self::$root . $array['query'] . self::$queryCancellaVisita;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);

		$db = new database();						
		$result = $db->getData($sql);

		return $result;
	}



	public function prelevaVociDentiSingoli($db, $utility, $array, $riepilogoVociVisita) {
	
		$replace = array(
			'%idpaziente%' => $_SESSION['idPaziente'],
			'%idvisita%' => $_SESSION['idVisita'],
			'%nomeform%' => 'singoli'
		);

		$sqlTemplate = self::$root . $array['query'] . self::$queryRiepilogoVociVisitaPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
		
		$_SESSION['vocivisitadentisingoli'] = pg_fetch_all($result);
	}

	public function prelevaVociGruppi($db, $utility, $array, $riepilogoVociVisita) {
	
		$replace = array(
			'%idpaziente%' => $_SESSION['idPaziente'],
			'%idvisita%' => $_SESSION['idVisita'],
			'%nomeform%' => 'gruppi'
		);

		$sqlTemplate = self::$root . $array['query'] . self::$queryRiepilogoVociVisitaGruppiPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
		
		$_SESSION['vocivisitagruppi'] = pg_fetch_all($result);	
	}

	public function prelevaVociCure($db, $utility, $array, $riepilogoVociVisita) {
	
		$replace = array(
			'%idpaziente%' => $_SESSION['idPaziente'],
			'%idvisita%' => $_SESSION['idVisita'],
			'%nomeform%' => 'cure'
		);

		$sqlTemplate = self::$root . $array['query'] . self::$queryRiepilogoVociVisitaPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
		
		$_SESSION['vocivisitacure'] = pg_fetch_all($result);	
	}
}

?>
