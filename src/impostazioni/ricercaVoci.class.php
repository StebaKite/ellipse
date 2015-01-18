<?php

require_once 'impostazioni.abstract.class.php';

class ricercaVoci  extends impostazioniAbstract {

	public static $messaggio;
	public static $queryRicercaVoci = "/impostazioni/ricercaVoci.sql";

	// Setters ---------------------------------

	public function setMessaggio($messaggio) {
		self::$messaggio = $messaggio;
	}

	// Getters --------------------------------

	public function getMessaggio() {
		return self::$messaggio;
	}

	function __construct() {

		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/impostazioni:" . self::$root . "/ellipse/src/utility";
		set_include_path($pathToInclude);

		require_once 'utility.class.php';

		$utility = new utility();
		$array = $utility->getConfig();

		self::$testata = self::$root . $array['testataPagina'];
		self::$piede = self::$root . $array['piedePagina'];
		self::$messaggioErrore = self::$root . $array['messaggioErrore'];
		self::$messaggioInfo = self::$root . $array['messaggioInfo'];
	}

	public function start() {

		error_log("<<<<<<< Start >>>>>>> " . $_SERVER['PHP_SELF']);

		require_once 'ricercaVoci.template.php';
		
		$ricercaVociTemplate = new ricercaVociTemplate();
		$ricercaVociTemplate->setMessaggio($this->getMessaggio());
		
		if ($this->ricerca($ricercaVociTemplate)) {
		
			// compone la pagina
			include(self::$testata);
			$ricercaVociTemplate->displayFiltri();
			$ricercaVociTemplate->displayRisultati();
			include(self::$piede);
		}

	}
	
	public function go() {}
	
	public function ricerca($ricercaVociTemplate) {
	
		require_once 'database.class.php';
	
		$esito = TRUE;
	
		// carica il comando sql da lanciare
	
		$utility = new utility();
		$array = $utility->getConfig();
		$sqlTemplate = self::$root . $array['query'] . self::$queryRicercaVoci;

		$replace = array('%idcategoria%' => $this->getIdcategoria());
		
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$db = new database();
		$result = $db->getData($sql);
	
		$ricercaVociTemplate->setNumeroVociTrovate(pg_num_rows($result));
		$ricercaVociTemplate->setVociTrovate($result);
		return $esito;
	}
}
		
?>