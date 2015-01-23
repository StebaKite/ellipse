<?php

require_once 'impostazioni.abstract.class.php';

class ricercaVociListinoTemplate  extends impostazioniAbstract {

	public static $filtri = "/impostazioni/ricercaVociListino.filtri.html";
	public static $risultati = "/impostazioni/ricercaVociListino.risultati.html";

	public static $vociDispomibiliTrovate;
	public static $vociListinoTrovate;
	public static $numeroVociListinoTrovate;
	public static $messaggio;

	// Setters -------------------------------------------------------------------

	public function setVociDisponibiliTrovate($vociDisponibiliTrovate) {
		self::$vociDispomibiliTrovate = $vociDisponibiliTrovate;
	}
	public function setVociListinoTrovate($vociListinoTrovate) {
		self::$vociListinoTrovate = $vociListinoTrovate;
	}
	public function setNumeroVociListinoTrovate($numEle) {
		self::$numeroVociListinoTrovate = $numEle;
	}
	public function setMessaggio($messaggio) {
		self::$messaggio = $messaggio;
	}

	// Getters -------------------------------------------------------------------

	public function getVociDisponibiliTrovate() {
		return self::$vociDispomibiliTrovate;
	}
	public function getVociListinoTrovate() {
		return self::$vociListinoTrovate;
	}
	public function getNumeroVociListinoTrovate() {
		return self::$numeroVociListinoTrovate;
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
				'%idlistino%' => $this->getIdlistino(),
				'%idvocelistino%' => $this->getIdvocelistino(),
				'%codicelistino%' => $this->getCodiceListino(),
				'%descrizionelistino%' => $this->getDescrizioneListino()
		);
	
		echo $utility->tailFile($utility->getTemplate($filtri), $replace);
	}

	public function displayRisultati() {
	
		require_once 'database.class.php';
		require_once 'utility.class.php';
	
		// Template ----------------------------------
	
		$utility = new utility();
		$array = $utility->getConfig();
		$risultati = self::$root . $array['template'] . self::$risultati;
		
		// Gestione del messaggio -------------------
	
		$numVociListino = $this->getNumeroVociListinoTrovate();
	
		if ($numVociListino > 0) {
	
			if ($numVociListino > 1) {
				$text1 = "%ml.trovate% "; $text2 = " %ml.voci%";
			} else {
				$text1 = "%ml.trovata% "; $text2 = " %ml.voce%";
			}
	
			$text0 = $this->getMessaggio();
			if ($text0 != "") {$text0 = $text0 . " - ";};
	
			$replace = array('%messaggio%' => $text0 . $text1 . $numVociListino . $text2);
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioInfo), $replace);
	
			echo $utility->tailTemplate($template);

			// Prepara la tabella dei risultati della ricerca

			$vociListinoTrovate = $this->getVociListinoTrovate();
			$vociDisponibiliTrovate = $this->getVociDisponibiliTrovate();

			$replace = array(
					'%idlistino%' => $this->getIdlistino(),
					'%idvocelistino%' => $this->getIdvocelistino(),
					'%codicelistino%' => $this->getCodiceListino(),
					'%descrizionelistino%' => $this->getDescrizioneListino(),
					'%elencoVociListino%' => $this->preparaTabellaVociIncluse($vociListinoTrovate),
					'%elencoVociDisponibili%' => $this->preparaTabellaVociDisponibili($vociDisponibiliTrovate)
			);
				
			$utility = new utility();
			
			$template = $utility->tailFile($utility->getTemplate($risultati), $replace);
			echo $utility->tailTemplate($template);
			
		}
		else {
			$elencoVociListino = "<h3>Listino privo di voci</h3>";
		}
	}	
	
	public function preparaTabellaVociIncluse($vociListinoTrovate) {

		$elencoVociListino = "";
		
		$rowcounter = 0;
		$oggi = date('d/m/Y');
			
		while ($row = pg_fetch_array($vociListinoTrovate)) {
				
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
				
			// BOTTONE ESCLUDI -----------------------------------------------
			// nasconde il bottone escludi voce se lo stato della voce è == '01' (voce utilizzata)
				
			$bottoneEscludi = "<a class='tooltip' href='escludiVoceListinoFacade.class.php?modo=start&idlistino=" . $this->getIdlistino() . "&idvoce=" . stripslashes($row['idvocelistino']) . "&codicelistino=" . $this->getCodiceListino() . "&descrizionelistino=" . $this->getDescrizioneListino() . "'><li class='ui-state-default ui-corner-all' title='%ml.escludiVoceTip%'><span class='ui-icon ui-icon-minus'></span></li></a>";
				
			if ($row['qtaapplicazioni'] > 0)  $bottoneEscludi = "";
		
			$elencoVociListino .= "<tr " . $class . "><td align='center'>" . $row['codicevoce'] . "</td><td align='left'>" . $row['descrizionevoce'] . "</td><td align='right'>" . $row['prezzo'] . "</td><td align='right'>" . $row['qtaapplicazioni'] . "</td>";
			$elencoVociListino .= "<td id='icons'><a class='tooltip' href='modificaVoceListinoFacade.class.php?modo=start&idlistino=" . $this->getIdlistino() . "&idvocelistino=" . $row['idvocelistino'] . "&codicevoce=" . $row['codicevoce'] . "&descrizionevoce=" . $this->getDescrizioneVoce() . "&codicelistino=" . $this->getCodiceListino() . "&descrizionelistino=" . $this->getDescrizioneListino() . "'><li class='ui-state-default ui-corner-all' title='%ml.modificaVoceTip%'><span class='ui-icon ui-icon-pencil'></span></li></a></td>";
			$elencoVociListino .= "<td id='icons'>" . $bottoneEscludi . "</td></tr>";
		
			++$rowcounter;
		}
		
		return $elencoVociListino;		
	}
	
	public function preparaTabellaVociDisponibili($vociDisponibiliTrovate) {

		$elencoVociDisponibili = "";
				
		$rowcounter = 0;
			
		while ($row = pg_fetch_array($vociDisponibiliTrovate)) {
		
			if ($rowcounter % 2 == 0) $class = "class='on'";
			else $class = "class=''";
		
			$elencoVociDisponibili .= "<tr " . $class . "><td id='icons'><a class='tooltip' href='includiVoceListinoFacade.class.php?modo=start&idlistino=" . $this->getIdlistino() . "&idvoce=" . $row['idvoce'] . "&prezzo=" . $row['prezzo'] . "&codicelistino=" . $this->getCodiceListino() . "&descrizionelistino=" . $this->getDescrizioneListino() . "'><li class='ui-state-default ui-corner-all' title='%ml.includiVoceTip%'><span class='ui-icon ui-icon-plus'></span></li></a></td>";
			$elencoVociDisponibili .= "<td align='center'>" . $row['codice'] . "</td><td align='left'>" . $row['descrizione'] . "</td><td align='right'>" . $row['prezzo'] . "</td>";
			$elencoVociDisponibili .= "</tr>";
		
			++$rowcounter;
		}
			
		return $elencoVociDisponibili;
	}
}
	
?>