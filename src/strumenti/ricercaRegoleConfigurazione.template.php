<?php

require_once 'strumenti.abstract.class.php';

class ricercaRegoleConfigurazioneTemplate  extends strumentiAbstract {

	public static $filtri = "/strumenti/ricercaRegoleConfigurazioni.filtri.html";
	public static $risultatiTesta = "/strumenti/ricercaRegoleConfigurazioni.risultati.testata.html";
	public static $risultatiCorpo = "/strumenti/ricercaRegoleConfigurazioni.risultati.corpo.html";
	public static $risultatiPiede = "/strumenti/ricercaRegoleConfigurazioni.risultati.piede.html";

	public static $regoleConfigurazioniTrovate;
	public static $numeroRegoleConfigurazioniTrovate;
	public static $messaggio;

	// Setters -------------------------------------------------------------------
	
	public function setRegoleConfigurazioniTrovate($regoleConfigurazioniTrovate) {
		self::$regoleConfigurazioniTrovate = $regoleConfigurazioniTrovate;
	}
	public function setNumeroRegoleConfigurazioniTrovate($numEle) {
		self::$numeroRegoleConfigurazioniTrovate = $numEle;
	}
	public function setMessaggio($messaggio) {
		self::$messaggio = $messaggio;
	}
	
	// Getters -------------------------------------------------------------------
	
	public function getRegoleConfigurazioniTrovate() {
		return self::$regoleConfigurazioniTrovate;
	}
	public function getNumeroRegoleConfigurazioniTrovate() {
		return self::$numeroRegoleConfigurazioniTrovate;
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

		if ($this->getStato() == '00') $stato = "Da eseguire";
		else $stato = "Eseguito";
		
		$replace = array(
				'%idguida%' => $this->getIdguida(),
				'%progressivo%' => $this->getProgressivo(),
				'%classe%' => $this->getClasse(),
				'%filepath%' => $this->getFilepath(),
				'%stato%' => $stato
		);
		
		$utility = new utility();
		
		echo $utility->tailFile($utility->getTemplate($filtri), $replace);
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
	
		$numRegoleConfigurazioni = $this->getNumeroRegoleConfigurazioniTrovate();
	
		if ($numRegoleConfigurazioni > 0) {
				
			if ($numRegoleConfigurazioni > 1) {
				$text1 = "%ml.trovate% "; $text2 = " %ml.regoleconfigurazioni%";
			} else {
				$text1 = "%ml.trovata% "; $text2 = " %ml.regolaconfigurazione%";
			}
	
			$text0 = $this->getMessaggio();
			if ($text0 != "") {$text0 = $text0 . " - ";};
	
			$replace = array('%messaggio%' => $text0 . $text1 . $numRegoleConfigurazioni . $text2);
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioInfo), $replace);
	
			echo $utility->tailTemplate($template);
				
			// Prepara la tabella dei risultati della ricerca
			echo $utility->getTemplate($risultatiTesta);
				
			$templateRiga = $utility->getTemplate($risultatiCorpo);
			$regoleConfigurazioniTrovate = $this->getRegoleConfigurazioniTrovate();
				
			$rowcounter = 0;
	
			while ($row = pg_fetch_array($regoleConfigurazioniTrovate)) {
					
				// evidenzia in bold la riga se è stata inserita o modificata oggi
					
				if ($rowcounter % 2 == 0) $class = "class='on'";
				else $class = "class=''";
	
				++$rowcounter;
		
				$replace = array(
						'%class%' => $class,
						'%iddettaglioguida%' => trim(stripslashes($row['iddettaglioguida'])),
						'%colonna%' => trim(stripslashes($row['colonna'])),
						'%posizionevalore%' => trim(stripslashes($row['posizionevalore']))
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