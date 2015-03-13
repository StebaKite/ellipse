<?php

require_once 'gestionePaziente.abstract.class.php';

class ricercaPaziente extends gestionePazienteAbstract {

	private static $queryRicercaPaziente = "/paziente/ricercaPaziente.sql";

	function __construct() {
		self::$root = $_SERVER['DOCUMENT_ROOT'];
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
		$_SESSION['modificatiOggiChecked'] = '';
		$_SESSION['tuttiChecked'] = 'checked'; 
		$_SESSION['conProposteChecked'] = '';
		$_SESSION['conSenzaProposteChecked'] = 'checked';
		
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
		$this->preparaPagina($ricercaPazienteTemplate);
		
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

		/**
		 * Set condizione modificati oggi
		 */
		
		if ($_SESSION['modificatioggi'] != "") {
			$oggi = date("Y-m-d");
			$dataModifica = " and datamodifica = '" . date("Y-m-d") . "'";
		}
		else {
			$dataModifica = "";
		}
		
		/**
		 * Set condizione pazienti con visite o preventivi proposti
		 */
		
		if ($_SESSION['proposte'] != "") {
			$conProposte = " and ((numvisiteproposte > 0) or (numpreventiviproposti > 0) or (numsottopreventiviproposti > 0))";
		}
		else {
			$conProposte = "";
		}
		
		$replace = array(
				'%cognome%' => str_replace("'","''",$_SESSION['cognome']),
				'%datamodifica%' => $dataModifica,
				'%proposte%' => $conProposte
		);
		
		$utility = new utility();
		$array = $utility->getConfig();
		$sqlTemplate = self::$root . $array['query'] . self::$queryRicercaPaziente;

		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);

		// esegue la query
		
		$db = new database();
		$result = $db->getData($sql);
		
		$_SESSION['numeroPazientiTrovati'] = pg_num_rows($result);	
		$_SESSION['pazientiTrovati'] = $result;
		
		return $result;	
	}
	
	private function preparaPagina($ricercaPazienteTemplate) {

		if ($_SESSION['modificatioggi'] != "") {
			$_SESSION['modificatiOggiChecked'] = 'checked';
			$_SESSION['tuttiChecked'] = '';
		}
		else {
			$_SESSION['modificatiOggiChecked'] = '';
			$_SESSION['tuttiChecked'] = 'checked';
		}
		

		if ($_SESSION['proposte'] != "") {
			$_SESSION['conProposteChecked'] = 'checked';
			$_SESSION['conSenzaProposteChecked'] = '';
		}
		else {
			$_SESSION['conProposteChecked'] = '';
			$_SESSION['conSenzaProposteChecked'] = 'checked';
		}
		
	}
}
?>

	
