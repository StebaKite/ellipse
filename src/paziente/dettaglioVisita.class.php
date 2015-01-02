<?php

require_once 'visitaPaziente.abstract.class.php';

class dettaglioVisita extends visitaPazienteAbstract {

	public static $azione = "../paziente/preventivaVisitaFacade.class.php?modo=go";

	function __construct() {
		
		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/paziente:" . self::$root . "/ellipse/src/utility";  
		set_include_path($pathToInclude);		
	}

	// ------------------------------------------------

	public function start() {

		require_once 'dettaglioVisita.template.php';
		require_once 'utility.class.php';
		require_once 'database.class.php';

		// Template
		$utility = new utility();
		$array = $utility->getConfig();

		$testata = self::$root . $array['testataPagina'];
		$piede = self::$root . $array['piedePagina'];
		$messaggioErrore = self::$root . $array['messaggioErrore'];
		$messaggioInfo = self::$root . $array['messaggioInfo'];

		$riepilogoVociVisita = new riepilogoVociVisita();		
		$riepilogoVociVisita->setIdPaziente($this->getIdPaziente());
		$riepilogoVociVisita->setIdListino($this->getIdListino());
		$riepilogoVociVisita->setTitoloPagina('%ml.creaNuovaVisita%');
		$riepilogoVociVisita->setCognomeRicerca($this->getCognomeRicerca());
					
		$riepilogoVociVisita->setAzione(self::$azione);
		$riepilogoVociVisita->setConfermaTip("%ml.confermaPreventivaVisita%");						
		$riepilogoVociVisita->setTitoloPagina("%ml.dettaglioVisita%");
		
//		$riepilogoVociVisita->setDettaglioVisita($riepilogoVociVisita);		

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

		// Compone la pagina
		include($testata);
		$riepilogoVociVisita->displayPagina();
		include($piede);		
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
		
	public function go() {
	}
}

?>
