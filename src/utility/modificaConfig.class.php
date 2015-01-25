<?php

class modificaConfig {

	private static $root;
	private static $cognomeRicerca;
	private static $messaggio;

	private static $azione = "../utility/modificaConfigFacade.class.php?modo=go";
	private static $configFile = "/ellipse/config/ellipse.config.ini";
	private static $messaggioInfo = "/messaggioInfo.html";
	private static $messaggioErrore = "/messaggioErrore.html";

	function __construct() {
		
		self::$root = $_SERVER['DOCUMENT_ROOT'];
	}

	public function setMessaggio($messaggio) {
		self::$messaggio = $messaggio;
	}

	public function getMessaggio() {
		return self::$messaggio;
	}

	public function getAzione() {
		return self::$azione;
	}

	public function start() {

		require_once 'utility.class.php';
		require_once 'modificaConfig.template.php';

		// Template
		$utility = new utility();
		$array = $utility->getConfig();

		$testata = self::$root . $array['testataPagina'];
		$piede = self::$root . $array['piedePagina'];
		$messaggioErrore = self::$root . $array['messaggioErrore'];
		$messaggioInfo = self::$root . $array['messaggioInfo'];

		$config = new config();
		$config->setAzione($this->getAzione());
		
		$config->setTitoloPagina("%ml.modificaConfig%");
		$config->setModificaConfig($config);		
		
		$file = self::$root . self::$configFile;
		$cnf = parse_ini_file($file);
		$config->setHostname($cnf['hostname']);
		$config->setPortnum($cnf['portnum']);
		$config->setUser($cnf['username']);
		$config->setPassword($cnf['password']);
		
		if ($cnf['dbname'] == "ellipse.prod") $config->setDatabaseProd("checked");
		if ($cnf['dbname'] == "ellipse.test") $config->setDatabaseTest("checked");
			
		$config->setTemplate($cnf['template']);
		$config->setTestataPagina($cnf['testataPagina']);
		$config->setPiedePagina($cnf['piedePagina']);
		$config->setMessaggioInfo($cnf['messaggioInfo']);
		$config->setMessaggioErrore($cnf['messaggioErrore']);
	
		// setta il bottone della lingua e disabilita quelli che non hanno il file delle traduzioni
		if ($cnf['language'] == "it") $config->setLanguageIt("checked");
		if ($cnf['language'] == "en") $config->setLanguageEn("checked");
		if ($cnf['language'] == "fr") $config->setLanguageFr("checked");
		if ($cnf['language'] == "de") $config->setLanguageDe("checked");

		if ($cnf['languageFile_it'] == "") $config->setLanguageItDisabled("disabled");
		if ($cnf['languageFile_en'] == "") $config->setLanguageEnDisabled("disabled");
		if ($cnf['languageFile_fr'] == "") $config->setLanguageFrDisabled("disabled");
		if ($cnf['languageFile_de'] == "") $config->setLanguageDeDisabled("disabled");
			
		$config->setLanguageFileIt($cnf['languageFile_it']);
		$config->setLanguageFileEn($cnf['languageFile_en']);
		$config->setLanguageFileFr($cnf['languageFile_fr']);
		$config->setLanguageFileDe($cnf['languageFile_de']);
			
		// Compone la pagina
		include($testata);
		$config->inizializzaPagina();
		$config->displayPagina();
		include($piede);
	}

	public function go() {
		
		require_once 'utility.class.php';
		require_once 'modificaConfig.template.php';

		// Template
		$utility = new utility();
		$array = $utility->getConfig();

		$testata = self::$root . $array['testataPagina'];
		$piede = self::$root . $array['piedePagina'];
		$messaggioErrore = self::$root . $array['messaggioErrore'];
		$messaggioInfo = self::$root . $array['messaggioInfo'];

		$config = new config();
		$config->setAzione($this->getAzione());

		$config->setHostname($_POST['server']);
		$config->setPortnum($_POST['porta']);
		$config->setUser($_POST['user']);
		$config->setPassword($_POST['password']);
		
		if ($_POST['database'] == 'ellipse.prod') $config->setDatabaseProd('checked');
		if ($_POST['database'] == 'ellipse.test') $config->setDatabaseTest('checked');
		
		$config->setTemplate($_POST['template']);
		$config->setTestataPagina($_POST['testataPagina']);
		$config->setPiedePagina($_POST['piedePagina']);
		$config->setMessaggioInfo($_POST['messaggioInfo']);
		$config->setMessaggioErrore($_POST['messaggioErrore']);
		
		if ($_POST['language'] == 'it') $config->setLanguageIt('checked');
		if ($_POST['language'] == 'en') $config->setLanguageEn('checked');
		if ($_POST['language'] == 'fr') $config->setLanguageFr('checked');
		if ($_POST['language'] == 'de') $config->setLanguageDe('checked');

		$config->setLanguageFileIt($_POST['languageFileIt']);
		$config->setLanguageFileEn($_POST['languageFileEn']);
		$config->setLanguageFileFr($_POST['languageFileFr']);
		$config->setLanguageFileDe($_POST['languageFileDe']);

		// Compone la pagina
		include($testata);
		$config->inizializzaPagina();

		// Fa il controllo dei dati immessi e modifica il file
		$config->setConfig($config);

		if ($config->controlliLogici()) {
						
			if ($this->modifica($config)) {
				$config->displayPagina();			
				$replace = array('%messaggio%' => '%ml.modConfigOk%');
				$template = $utility->tailFile($utility->getTemplate($messaggioInfo), $replace);		
				echo $utility->tailTemplate($template);
			} else {
				$config->displayPagina();			
				$replace = array('%messaggio%' => '%ml.modConfigKo%');
				$template = $utility->tailFile($utility->getTemplate($messaggioErrore), $replace);		
				echo $utility->tailTemplate($template);
			}
		} else {
			$config->displayPagina();			
			$replace = array('%messaggio%' => '%ml.modConfigKo%');
			$template = $utility->tailFile($utility->getTemplate($messaggioErrore), $replace);		
			echo $utility->tailTemplate($template);
		}

		include($piede);
	}
	
	public function modifica($config) {
		
		// riparso il file di configurazione per prendere le impostazioni attuali
		// e preparo una array di replace da applicare
		$file = self::$root . self::$configFile;
		$cnf = parse_ini_file($file);
		
		$replace = array(
			'hostname = ' . $cnf['hostname'] => 'hostname = ' . $config->getHostname(),
			'portnum = ' . $cnf['portnum'] => 'portnum = ' . $config->getPortnum(),
			'username = ' . $cnf['username'] => 'username = ' . $config->getUser(),
			'password = ' . $cnf['password'] => 'password = ' . $config->getPassword(),
			'dbname = ' . $cnf['dbname'] => 'dbname = ' . $_POST['database'],
			'template = ' . $cnf['template'] => 'template = ' . $config->getTemplate(),
			'testataPagina = ' . $cnf['testataPagina'] => 'testataPagina = ' . $config->getTestataPagina(),
			'piedePagina = ' . $cnf['piedePagina'] => 'piedePagina = ' . $config->getPiedePagina(),
			'messaggioInfo = ' . $cnf['messaggioInfo'] => 'messaggioInfo = ' . $config->getMessaggioInfo(),
			'messaggioErrore = ' . $cnf['messaggioErrore'] => 'messaggioErrore = ' . $config->getMessaggioErrore(),
			'language = ' . $cnf['language'] => 'language = '. $_POST['language'],
			'languageFile_it = ' . $cnf['languageFile_it'] => 'languageFile_it = ' . $config->getLanguageFileIt(),
			'languageFile_en = ' . $cnf['languageFile_en'] => 'languageFile_en = ' . $config->getLanguageFileEn(),
			'languageFile_fr = ' . $cnf['languageFile_fr'] => 'languageFile_fr = ' . $config->getLanguageFileFr(),
			'languageFile_de = ' . $cnf['languageFile_de'] => 'languageFile_de = ' . $config->getLanguageFileDe()
		);

		// poi prendo il contenuto del file e applico i replacement e riscrivo il risultato sul file
		$temp = file_get_contents($file);
		$temp = str_replace(array_keys($replace), array_values($replace), $temp);
		$result = file_put_contents($file,$temp);

		return $result;
	}
}

?>
