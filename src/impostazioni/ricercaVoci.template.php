<?php

require_once 'impostazioni.abstract.class.php';

class ricercaVociTemplate  extends impostazioniAbstract {

	public static $filtri = "/impostazioni/ricercaVoci.filtri.html";
	public static $risultatiTesta = "/impostazioni/ricercaVoci.risultati.testata.html";
	public static $risultatiCorpo = "/impostazioni/ricercaVoci.risultati.corpo.html";
	public static $risultatiPiede = "/impostazioni/ricercaVoci.risultati.piede.html";

	public static $vociTrovate;
	public static $numeroVociTrovate;
	public static $messaggio;

	// Setters -------------------------------------------------------------------

	public function setVociTrovate($vociTrovate) {
		self::$vociTrovate = $vociTrovate;
	}
	public function setNumeroVociTrovate($numEle) {
		self::$numeroVociTrovate = $numEle;
	}
	public function setMessaggio($messaggio) {
		self::$messaggio = $messaggio;
	}

	// Getters -------------------------------------------------------------------

	public function getVociTrovate() {
		return self::$vociTrovate;
	}
	public function getNumeroVociTrovate() {
		return self::$numeroVociTrovate;
	}
	public function getMessaggio() {
		return self::$messaggio;
	}

	//-----------------------------------------------------------------------------

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

	public function displayFiltri() {
	
		require_once 'utility.class.php';
	
		// Template ----------------------------------
	
		$utility = new utility();
		$array = $utility->getConfig();
		$filtri = self::$root . $array['template'] . self::$filtri;

		$replace = array(
				'%idcategoria%' => $this->getIdcategoria(),
				'%codicecategoria%' => $this->getCodiceCategoria(),
				'%descrizionecategoria%' => $this->getDescrizioneCategoria()
		);
				
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
	
		$numVoci = $this->getNumeroVociTrovate();
	
		if ($numVoci > 0) {
	
			if ($numVoci> 1) {
				$text1 = "%ml.trovate% "; $text2 = " %ml.voci%";
			} else {
				$text1 = "%ml.trovata% "; $text2 = " %ml.voce%";
			}
	
			$text0 = $this->getMessaggio();
			if ($text0 != "") {$text0 = $text0 . " - ";};
	
			$replace = array('%messaggio%' => $text0 . $text1 . $numVoci . $text2);
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioInfo), $replace);
	
			echo $utility->tailTemplate($template);
	
			// Prepara la tabella dei risultati della ricerca
			echo $utility->getTemplate($risultatiTesta);
	
			$templateRiga = $utility->getTemplate($risultatiCorpo);
			$vociTrovate = $this->getVociTrovate();
	
			$rowcounter = 0;
			$oggi = date('d/m/Y');
	
			while ($row = pg_fetch_array($vociTrovate)) {
					
				// evidenzia in bold la riga se è stata inserita o modificata oggi
	
				if ($rowcounter % 2 == 0) {
					if (($row['datainserimento'] == $oggi) or ($row['datamodifica'] == $oggi)) {
						$class = "class='modifiedOn'";
					}
					else {
						$class = "class='on'";
					}
				}
				else {
					if (($row['datainserimento'] == $oggi) or ($row['datamodifica'] == $oggi)) {
						$class = "class='modifiedOff'";
					}
					else {
						$class = "class=''";
					}
				}
	
				// BOTTONE CANCELLA -----------------------------------------------
				// nasconde il bottone cancella voce se è contenuta in qualche listino
	
				$bottoneCancella = "<a class='tooltip' href='cancellaVociFacade.class.php?modo=start&idvoce=" . stripslashes($row['idvoce']) . "&idcategoria=" . stripslashes($row['idcategoria']) . "&codicecategoria=" . stripslashes($row['codicecategoria']) . "&descrizionecategoria=" . stripslashes($row['descrizionecategoria']) . "'><li class='ui-state-default ui-corner-all' title='Cancella'><span class='ui-icon ui-icon-trash'></span></li></a>";
	
				if ($row['numlistini'] > 0)  $bottoneCancella = "";
	
				$replace = array(
						'%class%' => $class,
						'%idvoce%' => trim(stripslashes($row['idvoce'])),
						'%codicevoce%' => trim(stripslashes($row['codice'])),
						'%descrizionevoce%' => trim(stripslashes($row['descrizione'])),
						'%prezzo%' => number_format(trim(stripslashes($row['prezzo'])), 2, ',', '.'),
						'%tipovoce%' => trim(stripslashes($row['tipo'])),
						'%bottoneCancella%' => $bottoneCancella
				);
	
				++$rowcounter;
	
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