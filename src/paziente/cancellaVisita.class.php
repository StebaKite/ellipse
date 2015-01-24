<?php

require_once 'visitaPaziente.abstract.class.php';

class cancellaVisita extends visitaPazienteAbstract {
	
	public static $queryCancellaVisita = "/paziente/cancellaVisita.sql";	
	public static $azione = "../paziente/cancellaVisitaFacade.class.php?modo=go";

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
		$visita = $this->preparaPagina($db, $utility, $array, $riepilogoVociVisita);

		if ($this->cancella($this->getIdPaziente(), $this->getIdVisita())) {
			$ricercaVisita = new ricercaVisita();
			$ricercaVisita->setMessaggio('%ml.canVisitaOk%');
			$ricercaVisita->setIdPaziente($this->getIdPaziente());
			$ricercaVisita->setCognomeRicerca($this->getCognomeRicerca());
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

		$riepilogoVociVisita->setIdPaziente($this->getIdPaziente());
		$riepilogoVociVisita->setIdListino($this->getIdListino());
		$riepilogoVociVisita->setTitoloPagina('%ml.creaNuovaVisita%');
		$riepilogoVociVisita->setCognomeRicerca($this->getCognomeRicerca());
					
		$riepilogoVociVisita->setAzione(self::$azione);
		$riepilogoVociVisita->setLabelBottone("%ml.conferma%");
		$riepilogoVociVisita->setConfermaTip("%ml.confermaCancellazioneVisita%");						
		$riepilogoVociVisita->setTitoloPagina("%ml.cancellaVisita%");

		$db = new database();

		//-- Prelevo i tipi voci caricati -----------------------------------------------------------
		
		$replace = array(
			'%idpaziente%' => $this->getIdPaziente(),
			'%idvisita%' => $this->getIdVisita()
		);
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryRiepilogoTipiVociVisitaPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);

		$tipiVoci = pg_fetch_all($result);

		if ($tipiVoci) {
			foreach ($tipiVoci as $row) {
				if (trim($row['tipovoce']) == 'singoli') $this->prelevaVociDentiSingoli($db, $utility, $array, $riepilogoVociVisita); 
				if (trim($row['tipovoce']) == 'gruppi') $this->prelevaVociGruppi($db, $utility, $array, $riepilogoVociVisita); 
				if (trim($row['tipovoce']) == 'cure') $this->prelevaVociCure($db, $utility, $array, $riepilogoVociVisita); 
			}
		}
		return $riepilogoVociVisita;
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

		$esito = TRUE;

		$db = new database();						
		$result = $db->getData($sql);
		error_log($sql);
			
		if (!$result) {
			$esito = FALSE;
		}
		return $esito;
	}



	public function prelevaVociDentiSingoli($db, $utility, $array, $riepilogoVociVisita) {
	
		$replace = array(
			'%idpaziente%' => $this->getIdPaziente(),
			'%idvisita%' => $this->getIdVisita(),
			'%nomeform%' => 'singoli'
		);

		$sqlTemplate = self::$root . $array['query'] . self::$queryRiepilogoVociVisitaPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
		
		$riepilogoVociVisita->setVociVisitaDentiSingoli(pg_fetch_all($result));
	}

	public function prelevaVociGruppi($db, $utility, $array, $riepilogoVociVisita) {
	
		$replace = array(
			'%idpaziente%' => $this->getIdPaziente(),
			'%idvisita%' => $this->getIdVisita(),
			'%nomeform%' => 'gruppi'
		);

		$sqlTemplate = self::$root . $array['query'] . self::$queryRiepilogoVociVisitaGruppiPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
		
		$riepilogoVociVisita->setVociVisitaGruppi(pg_fetch_all($result));	
	}

	public function prelevaVociCure($db, $utility, $array, $riepilogoVociVisita) {
	
		$replace = array(
			'%idpaziente%' => $this->getIdPaziente(),
			'%idvisita%' => $this->getIdVisita(),
			'%nomeform%' => 'cure'
		);

		$sqlTemplate = self::$root . $array['query'] . self::$queryRiepilogoVociVisitaPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
		
		$riepilogoVociVisita->setVociVisitaCure(pg_fetch_all($result));	
	}









}

?>
