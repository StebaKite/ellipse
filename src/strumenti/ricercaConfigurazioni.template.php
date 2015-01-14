<?php

require_once 'strumenti.abstract.class.php';

class ricercaConfigurazioniTemplate  extends strumentiAbstract {

	public static $filtri = "/strumenti/ricercaConfigurazioni.filtri.html";
	public static $risultatiTesta = "/strumenti/ricercaConfigurazioni.risultati.testata.html";
	public static $risultatiCorpo = "/strumenti/ricercaConfigurazioni.risultati.corpo.html";
	public static $risultatiPiede = "/strumenti/ricercaConfigurazioni.risultati.piede.html";

	public static $configurazioniTrovate;
	public static $numeroConfigurazioniTrovate;
	private static $messaggio;
	
	// Setters -------------------------------------------------------------------
	
	public function setConfigurazioniTrovate($configurazioniTrovate) {
		self::$configurazioniTrovate = $configurazioniTrovate;
	}
	public function setNumeroConfigurazioniTrovate($numEle) {
		self::$numeroConfigurazioniTrovate = $numEle;
	}
	public function setMessaggio($messaggio) {
		self::$messaggio = $messaggio;
	}
	
	// Getters -------------------------------------------------------------------
	
	public function getConfigurazioniTrovate() {
		return self::$configurazioniTrovate;
	}
	public function getNumeroConfigurazioniTrovate() {
		return self::$numeroConfigurazioniTrovate;
	}
	public function getMessaggio() {
		return self::$messaggio;
	}
	
	//-----------------------------------------------------------------------------
	
	function __construct() {
	
		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/paziente:" . self::$root . "/ellipse/src/utility";
		set_include_path($pathToInclude);

		require_once 'utility.class.php';
		
		$utility = new utility();
		$array = $utility->getConfig();
		
		self::$testata = self::$root . $array['testataPagina'];
		self::$piede = self::$root . $array['piedePagina'];
		self::$messaggioErrore = self::$root . $array['messaggioErrore'];
		self::$messaggioInfo = self::$root . $array['messaggioInfo'];
		
	}

	public function displayFiltri() {

		require_once 'utility.class.php';
		
		// Template ----------------------------------
		
		$utility = new utility();
		$array = $utility->getConfig();		
		$filtri = self::$root . $array['template'] . self::$filtri;
				
		echo $utility->getTemplate($filtri);		
	}
	
	public function displayRisultati() {
	
		require_once 'database.class.php';
		require_once 'utility.class.php';
	
		// Template ----------------------------------
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$risultatiTesta = self::$root . $array['template'] . self::$risultatiTesta;
		$risultatiCorpo = self::$root . $array['template'] . self::$risultatiCorpo;
		$risultatiPiede = self::$root . $array['template'] . self::$risultatiPiede;
	
		// Gestione del messaggio -------------------
		
		$numConfigurazioni = $this->getNumeroConfigurazioniTrovate();
		
		if ($numConfigurazioni > 0) {
			
			if ($numConfigurazioni > 1) {
				$text1 = "%ml.trovate% "; $text2 = " %ml.configurazioni%";
			} else {
				$text1 = "%ml.trovata% "; $text2 = " %ml.configurazione%";
			}
				
			$text0 = $this->getMessaggio();
			if ($text0 != "") {$text0 = $text0 . " - ";};
		
			$replace = array('%messaggio%' => $text0 . $text1 . $numConfigurazioni . $text2);
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioInfo), $replace);
				
			echo $utility->tailTemplate($template);
			
			// Prepara la tabella dei risultati della ricerca
			echo $utility->getTemplate($risultatiTesta);
			
			$templateRiga = $utility->getTemplate($risultatiCorpo);
			$configurazioniTrovate = $this->getConfigurazioniTrovate();
			
			$rowcounter = 0;
				
			while ($row = pg_fetch_array($configurazioniTrovate)) {
			
				// evidenzia in bold la riga se è stata inserita o modificata oggi
			
				if ($rowcounter % 2 == 0) $class = "class='on'";
				else $class = "class=''";

				++$rowcounter;
				
				if ($row['stato'] == '01') {
					$statoIcon = "<span class='ui-icon ui-icon-check'></span>";
				}
				else {
					$statoIcon = "";
				}
				
				
				$replace = array(
					'%class%' => $class,
					'%idguida%' => trim(stripslashes($row['idguida'])),
					'%progressivo%' => trim(stripslashes($row['progressivo'])),
					'%classe%' => trim(stripslashes($row['classe'])),
					'%filepath%' => trim(stripslashes($row['filepath'])),
					'%stato%' => $statoIcon
				);
				
				$riga = $templateRiga;
				echo $utility->tailFile($riga, $replace);				
			}
		}	
		else {
		
			$text0 = $this->getMessaggio();
			if ($text0 != "") {$text0 = $text0 . " - ";};
		
			$replace = array('%messaggio%' => $text0 . '%ml.norisultati%');
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
				
			echo $utility->tailTemplate($template);
		
		}
		echo $utility->getTemplate($risultatiPiede);				
	}
}	
	
?>