<?php

class config {
	
	private static $root;
	private static $pagina = "/preferenze/config.form.html";
	
	private static $azione;
	private static $titoloPagina;
	private static $messaggio;	
	private static $modificaConfig;
	private static $config;

	private static $hostname;
	private static $portnum;
	private static $user;
	private static $password;
	private static $databaseProd;
	private static $databaseTest;

	private static $template;
	private static $templateStyle;
	
	private static $testataPagina;
	private static $testataPaginaStyle;

	private static $piedePagina;
	private static $piedePaginaStyle;
	
	private static $messaggioInfo;
	private static $messaggioInfoStyle;
	
	private static $messaggioErrore;
	private static $messaggioErroreStyle;

	private static $languageFileIt;
	private static $languageFileEn;
	private static $languageFileFr;
	private static $languageFileDe;
	private static $languageFileItStyle;
	private static $languageFileEnStyle;
	private static $languageFileFrStyle;
	private static $languageFileDeStyle;
	private static $languageIt;
	private static $languageEn;
	private static $languageFr;
	private static $languageDe;
	private static $languageItDisabled;
	private static $languageEnDisabled;
	private static $languageFrDisabled;
	private static $languageDeDisabled;


	//-----------------------------------------------------------------------------

	function __construct() {
		
		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/paziente:" . self::$root . "/ellipse/src/utility";  
		set_include_path($pathToInclude);		
	}

	//-----------------------------------------------------------------------------
	// Setters --------------------------------------------------------------------
	
	public function setAzione($azione) {
		self::$azione = $azione;
	}
	public function setTitoloPagina($titoloPagina) {
		self::$titoloPagina = $titoloPagina;
	}
	public function setMessaggio($messaggio) {
		self::$messaggio = $messaggio;
	}
	public function setModificaConfig($modificaConfig) {
		self::$modificaConfig = $modificaConfig;
	}
	public function setConfig($config) {
		self::$config = $config;
	}
	public function setHostname($hostname) {
		self::$hostname = $hostname;
	}
	public function setPortnum($portnum) {
		self::$portnum = $portnum;
	}
	public function setUser($user) {
		self::$user = $user;
	}
	public function setPassword($password) {
		self::$password = $password;
	}
	public function setDatabaseProd($databaseProd) {
		self::$databaseProd = $databaseProd;
	}
	public function setDatabaseTest($databaseTest) {
		self::$databaseTest = $databaseTest;
	}
	public function setTemplate($template) {
		self::$template = $template;
	}
	public function setTemplateStyle($templateStyle) {
		self::$templateStyle = $templateStyle;
	}
	public function setTestataPagina($testataPagina) {
		self::$testataPagina = $testataPagina;
	}
	public function setTestataPaginaStyle($testataPaginaStyle) {
		self::$testataPaginaStyle = $testataPaginaStyle;
	}
	public function setPiedePagina($piedePagina) {
		self::$piedePagina = $piedePagina;		
	}
	public function setPiedePaginaStyle($piedePaginaStyle) {
		self::$piedePaginaStyle = $piedePaginaStyle;		
	}
	public function setMessaggioInfo($messaggioInfo) {
		self::$messaggioInfo = $messaggioInfo;		
	}
	public function setMessaggioInfoStyle($messaggioInfoStyle) {
		self::$messaggioInfoStyle = $messaggioInfoStyle;		
	}
	public function setMessaggioErrore($messaggioErrore) {
		self::$messaggioErrore = $messaggioErrore;		
	}
	public function setMessaggioErroreStyle($messaggioErroreStyle) {
		self::$messaggioErroreStyle = $messaggioErroreStyle;		
	}
	public function setLanguageFileIt($languageFileIt) {
		self::$languageFileIt = $languageFileIt;		
	}
	public function setLanguageFileEn($languageFileEn) {
		self::$languageFileEn = $languageFileEn;		
	}
	public function setLanguageFileFr($languageFileFr) {
		self::$languageFileFr = $languageFileFr;		
	}
	public function setLanguageFileDe($languageFileDe) {
		self::$languageFileDe = $languageFileDe;		
	}
	
	public function setLanguageFileItStyle($languageFileItStyle) {
		self::$languageFileItStyle = $languageFileItStyle;		
	}
	public function setLanguageFileEnStyle($languageFileEnStyle) {
		self::$languageFileEnStyle = $languageFileEnStyle;		
	}
	public function setLanguageFileFrStyle($languageFileFrStyle) {
		self::$languageFileFrStyle = $languageFileFrStyle;		
	}
	public function setLanguageFileDeStyle($languageFileDeStyle) {
		self::$languageFileDeStyle = $languageFileDeStyle;		
	}
	
	public function setLanguageIt($languageIt) {
		self::$languageIt = $languageIt;		
	}
	public function setLanguageEn($languageEn) {
		self::$languageEn = $languageEn;		
	}
	public function setLanguageFr($languageFr) {
		self::$languageFr = $languageFr;		
	}
	public function setLanguageDe($languageDe) {
		self::$languageDe = $languageDe;		
	}
	public function setLanguageItDisabled($languageItDisabled) {
		self::$languageItDisabled = $languageItDisabled;		
	}
	public function setLanguageEnDisabled($languageEnDisabled) {
		self::$languageEnDisabled = $languageEnDisabled;		
	}
	public function setLanguageFrDisabled($languageFrDisabled) {
		self::$languageFrDisabled = $languageFrDisabled;		
	}
	public function setLanguageDeDisabled($languageDeDisabled) {
		self::$languageDeDisabled = $languageDeDisabled;		
	}
	
	// ----------------------------------------------------------------------------
	// Getters --------------------------------------------------------------------

	public function getAzione() {
		return self::$azione;
	}
	public function getTitoloPagina() {
		return self::$titoloPagina;
	}
	public function getMessaggio() {
		return self::$messaggio;
	}
	public function getModificaConfig() {
		return self::$modificaConfig;
	}
	public function getConfig() {
		return self::$config;
	}
	public function getHostname() {
		return self::$hostname;
	}
	public function getPortnum() {
		return self::$portnum;
	}
	public function getUser() {
		return self::$user;
	}
	public function getPassword() {
		return self::$password;
	}
	public function getDatabaseProd() {
		return self::$databaseProd;
	}
	public function getDatabaseTest() {
		return self::$databaseTest;
	}
	public function getTemplate() {
		return self::$template;
	}
	public function getTemplateStyle() {
		return self::$templateStyle;
	}
	public function getTestataPagina() {
		return self::$testataPagina;
	}
	public function getTestataPaginaStyle() {
		return self::$testataPaginaStyle;
	}
	public function getPiedePagina() {
		return self::$piedePagina;
	}
	public function getPiedePaginaStyle() {
		return self::$piedePaginaStyle;
	}
	public function getMessaggioInfo() {
		return self::$messaggioInfo;
	}
	public function getMessaggioInfoStyle() {
		return self::$messaggioInfoStyle;
	}
	public function getMessaggioErrore() {
		return self::$messaggioErrore;
	}
	public function getMessaggioErroreStyle() {
		return self::$messaggioErroreStyle;
	}
	public function getLanguageFileIt() {
		return self::$languageFileIt;
	}
	public function getLanguageFileEn() {
		return self::$languageFileEn;
	}
	public function getLanguageFileFr() {
		return self::$languageFileFr;
	}
	public function getLanguageFileDe() {
		return self::$languageFileDe;
	}
	
	public function getLanguageFileItStyle() {
		return self::$languageFileItStyle;
	}
	public function getLanguageFileEnStyle() {
		return self::$languageFileEnStyle;
	}
	public function getLanguageFileFrStyle() {
		return self::$languageFileFrStyle;
	}
	public function getLanguageFileDeStyle() {
		return self::$languageFileDeStyle;
	}

	
	public function getLanguageIt() {
		return self::$languageIt;
	}
	public function getLanguageEn() {
		return self::$languageEn;
	}
	public function getLanguageFr() {
		return self::$languageFr;
	}
	public function getLanguageDe() {
		return self::$languageDe;
	}
	public function getLanguageItDisabled() {
		return self::$languageItDisabled;
	}
	public function getLanguageEnDisabled() {
		return self::$languageEnDisabled;
	}
	public function getLanguageFrDisabled() {
		return self::$languageFrDisabled;
	}
	public function getLanguageDeDisabled() {
		return self::$languageDeDisabled;
	}

	// template ------------------------------------------------

	public function inizializzaPagina() {

	}	


	public function controlliLogici() {
		
		$esito = TRUE;

		$config = $this->getConfig();

		// controllo l'esistenza dei file multilingua configurati
		
		if ($this->getLanguageFileIt() != "") {
			if (!file_exists(self::$root . $this->getLanguageFileIt())) {
				$esito = FALSE;
				$config->setLanguageFileItStyle("border-color:#ff0000; border-width:2px;");
				$config->setLanguageItDisabled("disabled");
			}
		}
		else {
			$config->setLanguageItDisabled("disabled");
		}
		
		if ($this->getLanguageFileEn() != "") {
			if (!file_exists(self::$root . $this->getLanguageFileEn())) {
				$esito = FALSE;
				$config->setLanguageFileEnStyle("border-color:#ff0000; border-width:2px;");
				$config->setLanguageEnDisabled("disabled");
			}
		}
		else {
			$config->setLanguageEnDisabled("disabled");
		}
		
		if ($this->getLanguageFileFr() != "") {
			if (!file_exists(self::$root . $this->getLanguageFileFr())) {
				$esito = FALSE;
				$config->setLanguageFileFrStyle("border-color:#ff0000; border-width:2px;");
				$config->setLanguageFrDisabled("disabled");
			}
		}
		else {
			$config->setLanguageFrDisabled("disabled");
		}
		
		if ($this->getLanguageFileDe() != "") {
			if (!file_exists(self::$root . $this->getLanguageFileDe())) {
				$esito = FALSE;
				$config->setLanguageFileDeStyle("border-color:#ff0000; border-width:2px;");
				$config->setLanguageDeDisabled("disabled");
			}
		}
		else {
			$config->setLanguageDeDisabled("disabled");
		}
		
		// controllo l'esistenza dei template
		
		if ($this->getTemplate() != "") {
			if (!file_exists(self::$root . $this->getTemplate())) {
				$esito = FALSE;
				$config->setTemplateStyle("border-color:#ff0000; border-width:2px;");
			}
		}
		
		if ($this->getTestataPagina() != "") {
			if (!file_exists(self::$root . $this->getTestataPagina())) {
				$esito = FALSE;
				$config->setTestataPaginaStyle("border-color:#ff0000; border-width:2px;");
			}
		}
		
		if ($this->getPiedePagina() != "") {
			if (!file_exists(self::$root . $this->getPiedePagina())) { 
				$esito = FALSE;
				$config->setPiedePaginaStyle("border-color:#ff0000; border-width:2px;");
			}
		}
		
		if ($this->getMessaggioInfo() != "") {
			if (!file_exists(self::$root . $this->getMessaggioInfo())) { 
				$esito = FALSE;
				$config->setMessaggioInfoStyle("border-color:#ff0000; border-width:2px;");
			}
		}
		
		if ($this->getMessaggioErrore() != "") {
			if (!file_exists(self::$root . $this->getMessaggioErrore())) { 
				$esito = FALSE;
				$config->setMessaggioErroreStyle("border-color:#ff0000; border-width:2px;");
			}
		}
		
		return $esito;
	}
	
	public function displayPagina() {

		require_once 'utility.class.php';
		
		// Template --------------------------------------------------------------

		$utility = new utility();
		$array = $utility->getConfig();

		$form = self::$root . $array['template'] . self::$pagina;

		//-------------------------------------------------------------										

		$replace = array(
			'%titoloPagina%' => $this->getTitoloPagina(),
			'%azione%' => $this->getAzione(),
			'%server%' => $this->getHostname(),
			'%porta%' => $this->getPortnum(),
			'%user%' => $this->getUser(),
			'%password%' => $this->getPassword(),
			'%dbProdChecked%' => $this->getDatabaseProd(),
			'%dbTestChecked%' => $this->getDatabaseTest(),
			'%template%' => $this->getTemplate(),
			'%testataPagina%' => $this->getTestataPagina(),
			'%piedePagina%' => $this->getPiedePagina(),
			'%messaggioInfo%' => $this->getMessaggioInfo(),
			'%messaggioErrore%' => $this->getMessaggioErrore(),
			'%templateStyle%' => $this->getTemplateStyle(),
			'%testataPaginaStyle%' => $this->getTestataPaginaStyle(),
			'%piedePaginaStyle%' => $this->getPiedePaginaStyle(),
			'%messaggioInfoStyle%' => $this->getMessaggioInfoStyle(),
			'%messaggioErroreStyle%' => $this->getMessaggioErroreStyle(),
			'%languageFileIt%' => $this->getLanguageFileIt(),
			'%languageFileEn%' => $this->getLanguageFileEn(),
			'%languageFileFr%' => $this->getLanguageFileFr(),
			'%languageFileDe%' => $this->getLanguageFileDe(),
			'%languageFileItStyle%' => $this->getLanguageFileItStyle(),
			'%languageFileEnStyle%' => $this->getLanguageFileEnStyle(),
			'%languageFileFrStyle%' => $this->getLanguageFileFrStyle(),
			'%languageFileDeStyle%' => $this->getLanguageFileDeStyle(),
			'%languageIt%' => $this->getLanguageIt(),
			'%languageEn%' => $this->getLanguageEn(),
			'%languageFr%' => $this->getLanguageFr(),
			'%languageDe%' => $this->getLanguageDe(),
			'%languageItDisabled%' => $this->getLanguageItDisabled(),
			'%languageEnDisabled%' => $this->getLanguageEnDisabled(),
			'%languageFrDisabled%' => $this->getLanguageFrDisabled(),
			'%languageDeDisabled%' => $this->getLanguageDeDisabled()
		);

		$utility = new utility();

		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);		
	}	
}

?>
