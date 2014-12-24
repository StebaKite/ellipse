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
		$riepilogoVociVisita->setDettaglioVisita($riepilogoVociVisita);		

		$db = new database();

		//-------------------------------------------------------------
		
		$replace = array(
			'%idpaziente%' => $this->getIdPaziente(),
			'%idvisita%' => $this->getIdVisita()
		);
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryRiepilogoVociVisitaPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
		
		$riepilogoVociVisita->setVociVisita(pg_fetch_all($result));

		// Compone la pagina
		include($testata);
		$riepilogoVociVisita->displayPagina();
		include($piede);		
	}
		
	public function go() {


	}
}

?>
