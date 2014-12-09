<?php

class ricercaPaziente {

	private static $root;

	private static $messaggio;
	private static $cognomeRicerca;

	function __construct() {
		
		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/paziente:" . self::$root . "/ellipse/src/utility";  
		set_include_path($pathToInclude);
	}

	// Setters ---------------------------------
	public function setMessaggio($messaggio) {
		self::$messaggio = $messaggio;
	}
	public function setCognomeRicerca($cognomeRicerca) {
		self::$cognomeRicerca = $cognomeRicerca;
	}
	// Getters --------------------------------
	public function getMessaggio() {
		return self::$messaggio;
	}
	public function getCognomeRicerca() {
		return self::$cognomeRicerca;
	}

	public function start() {

		require_once 'ricercaPaziente.template.php';
		require_once 'utility.class.php';

		// Template
		$utility = new utility();
		$array = $utility->getConfig();

		$testata = self::$root . $array['testataPagina'];
		$piede = self::$root . $array['piedePagina'];		

		$ricercaPazienteTemplate = new ricercaPazienteTemplate();
		
		// compone la pagina
		include($testata);
		$ricercaPazienteTemplate->displayFiltri();
		include($piede);
	}
	
	public function go() {

		require_once 'ricercaPaziente.template.php';
		require_once 'utility.class.php';

		// Template
		$utility = new utility();
		$array = $utility->getConfig();

		$testata = self::$root . $array['testataPagina'];
		$piede = self::$root . $array['piedePagina'];		
		
		$ricercaPazienteTemplate = new ricercaPazienteTemplate();
	
		// cognome dalla POST
		if ($this->getCognomeRicerca() != "")
			$ricercaPazienteTemplate->setCognome($this->getCognomeRicerca());
		else
			$ricercaPazienteTemplate->setCognome(ucwords($_POST["cognome"]));

		// Il messaggio		
		$ricercaPazienteTemplate->setMessaggio($this->getMessaggio());
		
		if ($this->ricerca($ricercaPazienteTemplate)) {

			// compone la pagina
			include($testata);
			$ricercaPazienteTemplate->displayFiltri();
			$ricercaPazienteTemplate->displayRisultati();		
			include($piede);
		}	
	}

		
	private function controlli() {
	
		$esito = True;
		
		return $esito; 	
	}
	
	private function ricerca($ricercaPazienteTemplate) {

		require_once 'database.class.php';

		$cognome = $ricercaPazienteTemplate->getCognome();
		$esito = TRUE;

		$db = new database();

		$sql = "select idpaziente, cognome, nome, to_char(datanascita, 'DD/MM/YYYY'), codicefiscale from paziente.paziente where cognome like '" . $cognome . "%'";
		$result = $db->getData($sql);
		error_log($sql);
		
		$ricercaPazienteTemplate->setNumeroPazientiTrovati(pg_num_rows($result));	
		$ricercaPazienteTemplate->setPazientiTrovati($result);
		
		return $esito;	
	}
}
?>

	
