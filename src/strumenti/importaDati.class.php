<?php

require_once 'strumenti.abstract.class.php';

class importaDati extends strumentiAbstract {

	public static $azione = "../strumenti/importaDatiFacade.class.php?modo=go";	
	private static $queryConfigurazioni = "/strumenti/ricercaConfigurazioni.sql";

	function __construct() {

		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/strumenti:" . self::$root . "/ellipse/src/utility";
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
		
		require_once 'importaDati.template.php';
		require_once 'utility.class.php';
		
		// Template
		$utility = new utility();
		$array = $utility->getConfig();
		
		$importaTemplate = new importaTemplate();
		$importaTemplate->setImportaTemplate($this->preparaPagina($importaTemplate));
				
		// compone la pagina
		include(self::$testata);
		$importaTemplate->displayPagina();
		include(self::$piede);
	}
	
	public function go() {

		error_log("<<<<<<< Go >>>>>>> " . $_SERVER['PHP_SELF']);
		
		require_once 'database.class.php';
		require_once 'importaDati.template.php';
		require_once 'utility.class.php';
		
		// Template
		$utility = new utility();
		$array = $utility->getConfig();
		
		$importaTemplate = new importaTemplate();
		$importaTemplate->setImportaTemplate($this->preparaPagina($importaTemplate));
		
		include(self::$testata);
		
		$db = new database();
		$mess = array();
		
		$configs = $this->leggiConfigurazioni($db,$utility);
		if ($configs) {
			
			$rows = pg_fetch_all($configs);
			array_push($mess, "Configurazioni caricate, inizio a importare ..." . "<br>");
			$esito = TRUE;
			
			foreach($rows as $row) {				
				if (!$this->importa($db, $utility, $importaTemplate, $mess, $row)) {
					$esito = FALSE;			
				}
			}
			
			if ($esito) {					
				$importaTemplate->displayPagina();
				$replace = array('%messaggio%' => '%ml.importaDatiOk%');
				$template = $utility->tailFile($utility->getTemplate(self::$messaggioInfo), $replace);
				echo $utility->tailTemplate($template);
			}
			else {
				$importaTemplate->displayPagina();
				$replace = array('%messaggio%' => '%ml.importaDatiKo%');
				$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
				echo $utility->tailTemplate($template);
			}				
		}
		else {
			$importaTemplate->displayPagina();
			$replace = array('%messaggio%' => '%ml.configurazioniKo%');
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
			echo $utility->tailTemplate($template);
						}
		
		include(self::$piede);
	}
	
	public function leggiConfigurazioni($db, $utility) {
		
		$array = $utility->getConfig();
		$sqlTemplate = self::$root . $array['query'] . self::$queryConfigurazioni;
		
		$sql = $utility->getTemplate($sqlTemplate);
		$result = $db->getData($sql);
		
		return $result;
	}

	public function importa($db, $utility, $importaTemplate, $mess, $row) {
		
		array_push($mess, "Instanzio la classe '" . $row['classe'] . "' per importare il file '" . self::$root . $row['filepath'] . "'<br>");
				
		$className = trim($row['classe']);
		require_once $className . '.class.php';
		
		$instance = new $className();
		$mess = $instance->start($db, $utility, $mess, $row);		
		
		
		
		
		
		
		
		
		$importaTemplate->setMessaggi($mess);		
		
		return TRUE;
	}
	
	public function preparaPagina($importaTemplate) {
		
		$importaTemplate->setAzione(self::$azione);		
		$importaTemplate->setTestoAzione("%ml.importaTip%");		
		$importaTemplate->setTitoloPagina("%ml.importaDati%");
		
		return $importaTemplate;		
	}
}

?>