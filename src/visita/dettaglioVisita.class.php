<?php

require_once 'visita.abstract.class.php';

class dettaglioVisita extends visitaAbstract {

	public static $azione = "../visita/preventivaVisitaFacade.class.php?modo=start";

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
		$array = $utility->getConfig();

		$riepilogoVociVisita = new riepilogoVociVisita();
		$riepilogoVociVisita->setTitoloPagina('%ml.creaNuovaVisita%');
					
		$riepilogoVociVisita->setAzione(self::$azione);
		$riepilogoVociVisita->setLabelBottone("%ml.preventiva%");
		$riepilogoVociVisita->setConfermaTip("%ml.preventivaVisita%");						
		$riepilogoVociVisita->setTitoloPagina("%ml.dettaglioVisita%");

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

		if ($tipiVoci) {
			
			unset($_SESSION['vocivisitadentisingoli']);
			unset($_SESSION['vocivisitagruppi']);
			unset($_SESSION['vocivisitacure']);
			
			foreach ($tipiVoci as $row) {
				if (trim($row['tipovoce']) == 'singoli') $this->prelevaVociDentiSingoli($db, $utility, $array, $riepilogoVociVisita); 
				if (trim($row['tipovoce']) == 'gruppi') $this->prelevaVociGruppi($db, $utility, $array, $riepilogoVociVisita); 
				if (trim($row['tipovoce']) == 'cure') $this->prelevaVociCure($db, $utility, $array, $riepilogoVociVisita); 
			}
		}

		// Compone la pagina
		include(self::$testata);
		$riepilogoVociVisita->displayPagina();
		include(self::$piede);		
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
		
	public function go() {}
}

?>
