<?php

class utility {

	private static $root;
	private static $languageReplace;
	private static $configuration;

	private static $configFile = "/ellipse/config/ellipse.config.ini";

	// Setters -----------------------
	public function setLanguageReplace($languageReplace) {
		self::$languageReplace = $languageReplace;
	}
	public function setConfiguration($configuration) {
		self::$configuration = $configuration;
	}
	
	// Getters -----------------------
	public function getConfiguration() {
		return self::$configuration;
	}
	public function getLanguageReplace() {
		return self::$languageReplace;
	}

	// Costruttore --------------------
	function __construct() {		
		self::$root = $_SERVER['DOCUMENT_ROOT'];
	}

	public function tailFile($template, $replacement) {
		return str_replace(array_keys($replacement), array_values($replacement), $template);
	}
	
	public function tailTemplate($template) {
		
		$array = $this->getConfig();

		$lingua = $array['language'];
		$lanFile = "languageFile_" . $lingua; 

		$fileLingua = self::$root . $array[$lanFile];

		/*
		 * Se non trova il file corrispondente alla lingua impostata, il metodo
		 * restituisce il template così com'è senza traduzioni
		 */ 
		if (file_exists($fileLingua)) {
			return $this->tailFile($template, $this->getMultilanguageFile($fileLingua));
		}
		else {
			error_log("Multilanguage file " . $fileLingua . " not found, template use");
			return $template;
		}
		
	}

	public function getTemplate($fileName) {

		if (file_exists($fileName)) {
			error_log("Template file " . $fileName . " loaded...");
			
			$temp = fopen($fileName,"r");
			$template = fread($temp,filesize($fileName));
			fclose($temp);
			
			return $this->tailTemplate($template);		
		}
		else {
			error_log("Template file " . $fileName . " not found!");
		}		
	}
	
	/*
	 * Prende in input il file della lingua e restituisce una array associativa
	 */	
	public function getMultilanguageFile($multiLanguageFile) {
	
		if (self::$languageReplace == "") {

			$languageReplace = array();
			
			$lan = fopen($multiLanguageFile,"r");
			$line = "";
			
			while(!feof($lan)){
				$line = explode(" = ", fgets($lan));
				if ($line[0] != "") {
					if (substr($line[0],0,1) != ";") {
						$key = "%ml." . $line[0] . "%";
						$value = $line[1];
						$languageReplace[$key] = $value;
					}
				}
				$line = "";
			}
			fclose($lan);
			$this->setLanguageReplace($languageReplace);
			error_log("Multilanguage file " . $multiLanguageFile . " loaded...");
		}
		return $this->getLanguageReplace();
	}	
	
	public function getConfig() {

		if (self::$configuration == "") {

			$configFile = self::$root . self::$configFile;
			
			if (file_exists($configFile)) {

				// viene ritornata una mappa
				error_log("Config file " . $configFile . " loaded...");
				$this->setConfiguration(parse_ini_file($configFile));
			}
			else {
				error_log("Config file " . $configFile . " not found!");
				$this->setConfiguration(null);	
			}
		}
		return $this->getConfiguration();
	}
}

?>
