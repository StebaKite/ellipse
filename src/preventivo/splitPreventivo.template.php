<?php

require_once 'preventivo.abstract.class.php';

class splitPreventivoTemplate  extends preventivoAbstract {

	public static $filtri = "/preventivo/splitPreventivo.filtri.html";
	public static $risultati = "/preventivo/splitPreventivo.risultati.html";
	
	function __construct() {
	
		self::$root = $_SERVER['DOCUMENT_ROOT'];
	
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
				'%cognome%' => $_SESSION['cognome'],
				'%nome%' => $_SESSION['nome'],
				'%datanascita%' => $_SESSION['datanascita'],
				'%idpreventivo%' => $_SESSION['idPreventivo'],
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
		
		$numVociPreventivo = $_SESSION['numerovocipreventivoprincipaletrovate'];
		
		if ($numVociPreventivo == 0) {
			$text1 = "%ml.preventivoVuoto%"; $text2 = ""; $numVociPreventivo = "";
		}
		else {
			if ($numVociPreventivo > 1) {
				$text1 = "%ml.trovate% "; $text2 = " %ml.voci%";
			}
			else {
				$text1 = "%ml.trovata% "; $text2 = " %ml.voce%";
			}
		}
		
		$text0 = $this->getMessaggio();
		if ($text0 != "") {$text0 = $text0 . " - ";};
		
		$replace = array('%messaggio%' => $text0 . $text1 . $numVociPreventivo . $text2);
		
		if ($numVociPreventivo == "")
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
		else
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioInfo), $replace);
		
		echo $utility->tailTemplate($template);
		
		// Prepara la tabella dei risultati della ricerca
		
		$replace = array(
				'%idpaziente%' => $_SESSION['idPaziente'],
				'%idlistino%' => $_SESSION['idListino'],
				'%cognome%' => $_SESSION['cognome'],
				'%nome%' => $_SESSION['nome'],
				'%datanascita%' => $_SESSION['datanascita'],
				'%idpreventivo%' => $_SESSION['idPreventivo'],
				'%idsottopreventivo%' => $_SESSION['idSottoPreventivo'],
				'%elencovocipreventivosecondario%' => $this->preparaTabellaVociPreventivoSecondario($_SESSION['vocipreventivosecondariotrovate']),
				'%elencovocipreventivoprincipale%' => $this->preparaTabellaVociPreventivoPrincipale($_SESSION['vocipreventivoprincipaletrovate']),
				'%totalePreventivoPrincipale%' => number_format($_SESSION['totalepreventivoprincipale'], 2, ',', '.'),
				'%totalePreventivoSecondario%' => number_format($_SESSION['totalepreventivosecondario'], 2, ',', '.') 
		);
		
		$utility = new utility();
		
		$template = $utility->tailFile($utility->getTemplate($risultati), $replace);
		echo $utility->tailTemplate($template);
		
	}

	public function preparaTabellaVociPreventivoPrincipale($voci) {

		$elencoVoci = "";
		$rowcounter = 0;
		$totale = 0;
			
		while ($row = pg_fetch_array($voci)) {
		
			if ($rowcounter % 2 == 0) $class = "class='on'";
			else $class = "class=''";

			if (trim($row['nomeform']) == 'singoli')  {
				$dente = split('_',$row['dente']); 
				$campo = $dente[1];
				$indSingolo = "Si";
				$indCure = "&ndash;&ndash;";
				$indGruppo = "&ndash;&ndash;";
			}
			if (trim($row['nomeform']) == 'cure')  {
				$campo = "&ndash;&ndash;";
				$indSingolo = "&ndash;&ndash;";
				$indCure = "Si";
				$indGruppo = "&ndash;&ndash;";
			}
			if (trim($row['nomeform']) == 'gruppi')  {
				$dente = split('_',$row['dente']); 
				$campo = $dente[1];
				$indSingolo = "&ndash;&ndash;";
				$indCure = "&ndash;&ndash;";
				$indGruppo = "Si";
			}
			
			$elencoVoci .= "<tr " . $class . "><td id='icons' width='30'><a class='tooltip' href='../preventivo/includiVocePreventivoFacade.class.php?modo=start&idvocepreventivo=" . trim($row['idvocepreventivo']) . "&codicevocelistino=" . trim($row['codicevocelistino']) . "&prezzo=" . $row['prezzo'] . "&nomeform=" . trim($row['nomeform']) . "&nomecampoform=" . trim($row['nomecampoform']) . "'><li class='ui-state-default ui-corner-all' title='%ml.includiVoceTip%'><span class='ui-icon ui-icon-plus'></span></li></a></td>";
			$elencoVoci .= "<td align='center' width='48'>" . trim($campo) . "</td><td align='center' width='50'>" . $indSingolo . "</td><td align='center' width='50'>" . $indGruppo . "</td><td align='center' width='48'>" . $indCure . "</td><td align='center' width='107'>" . trim($row['codicevocelistino']) . "</td><td align='right' width='59'>&euro;" . $row['prezzo'] . "</td>";
			$elencoVoci .= "</tr>";
					
			$totale += $row['prezzo'];
			
			++$rowcounter;
		}			
		$_SESSION['totalepreventivoprincipale'] = $totale;
		
		if ($elencoVoci == "") return "";
		else return "<table class='result' id='resultTable'><tbody>" . $elencoVoci . "</tbody></table>";
	}

	public function preparaTabellaVociPreventivoSecondario($voci) {

		$elencoVoci = "";
		$rowcounter = 0;
		$totale = 0;
		
		while ($row = pg_fetch_array($voci)) {
		
			if ($rowcounter % 2 == 0) $class = "class='on'";
			else $class = "class=''";
		
			if (trim($row['nomeform']) == 'singoli')  {
				$dente = split('_',$row['dente']);
				$campo = $dente[1];
				$indSingolo = "Si";
				$indCure = "&ndash;&ndash;";
				$indGruppo = "&ndash;&ndash;";
			}
			if (trim($row['nomeform']) == 'cure')  {
				$campo = "&ndash;&ndash;";
				$indSingolo = "&ndash;&ndash;";
				$indCure = "Si";
				$indGruppo = "&ndash;&ndash;";
			}
			if (trim($row['nomeform']) == 'gruppi')  {
				$dente = split('_',$row['dente']);
				$campo = $dente[1];
				$indSingolo = "&ndash;&ndash;";
				$indCure = "&ndash;&ndash;";
				$indGruppo = "Si";
			}
				
			$elencoVoci .= "<tr " . $class . ">";
			$elencoVoci .= "<td align='right' width='59'>&euro;" . $row['prezzo'] . "</td><td align='center' width='107'>" . $row['codicevocelistino'] . "</td><td align='center' width='48'>" . $indCure . "</td><td align='center' width='50'>" . $indGruppo . "</td><td align='center' width='50'>" . $indSingolo . "</td><td align='center' width='48'>" . $campo . "</td>";
			$elencoVoci .= "<td id='icons' width='29'><a class='tooltip' href='../preventivo/escludiVocePreventivoFacade.class.php?modo=start&idvocesottopreventivo=" . trim($row['idvocesottopreventivo']) . "&codicevocelistino=" . trim($row['codicevocelistino']) . "&prezzo=" . $row['prezzo'] . "&nomeform=" . trim($row['nomeform']) . "&nomecampoform=" . trim($row['nomecampoform']) . "'><li class='ui-state-default ui-corner-all' title='%ml.includiVoceTip%'><span class='ui-icon ui-icon-minus'></span></li></a></td>";
			$elencoVoci .= "</tr>";
		
			$totale += $row['prezzo'];
						
			++$rowcounter;
		}
		$_SESSION['totalepreventivosecondario'] = $totale;		

		if ($elencoVoci == "") return ""; 
		else return "<table class='result' id='resultTable'><tbody>" . $elencoVoci . "</tbody></table>";
	}
}

?>