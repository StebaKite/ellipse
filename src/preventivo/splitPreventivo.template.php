<?php

require_once 'preventivo.abstract.class.php';

class splitPreventivoTemplate  extends preventivoAbstract {

	public static $filtri = "/preventivo/splitPreventivo.filtri.html";
	public static $risultati = "/preventivo/splitPreventivo.risultati.html";

	public static $vociPreventivoPrincipaleTrovate;
	public static $numeroVociPreventivoPrincipaleTrovate;
	public static $vociPreventivoSecondarioTrovate;
	public static $numeroVociPreventivoSecondarioTrovate;

	// Setters -------------------------------------------------------------------
	
	public function setVociPreventivoPrincipaleTrovate($vociPreventivoPrincipaleTrovate) {
		self::$vociPreventivoPrincipaleTrovate = $vociPreventivoPrincipaleTrovate;
	}
	public function setNumeroVociPreventivoPrincipaleTrovate($numEle) {
		self::$numeroVociPreventivoPrincipaleTrovate = $numEle;
	}
	public function setVociPreventivoSecondarioTrovate($vociPreventivoSecondarioTrovate) {
		self::$vociPreventivoSecondarioTrovate = $vociPreventivoSecondarioTrovate;
	}
	public function setNumeroVociPreventivoSecondarioTrovate($numEle) {
		self::$numeroVociPreventivoSecondarioTrovate = $numEle;
	}
	
	// Getters -------------------------------------------------------------------
	
	public function getVociPreventivoPrincipaleTrovate() {
		return self::$vociPreventivoPrincipaleTrovate;
	}
	public function getNumeroVociPreventivoPrincipaleTrovate() {
		return self::$numeroVociPreventivoPrincipaleTrovate;
	}
	public function getVociPreventivoSecondarioTrovate() {
		return self::$vociPreventivoSecondarioTrovate;
	}
	public function getNumeroVociPreventivoSecondarioTrovate() {
		return self::$numeroVociPreventivoSecondarioTrovate;
	}
	
	//-----------------------------------------------------------------------------
	
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
				'%idpaziente%' => $this->getIdPaziente(),
				'%idlistino%' => $this->getIdListino(),
				'%cognomericerca%' => $this->getCognomeRicerca(),
				'%cognome%' => $this->getCognome(),
				'%nome%' => $this->getNome(),
				'%datanascita%' => $this->getDataNascita(),
				'%idpreventivo%' => $this->getIdPreventivo(),
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
		
		$numVociPreventivo = $this->getNumeroVociPreventivoPrincipaleTrovate();
		
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
		
		$vociPreventivoPrincipaleTrovate = $this->getVociPreventivoPrincipaleTrovate();
		$vociPreventivoSecondarioTrovate = $this->getVociPreventivoSecondarioTrovate();
		
		$replace = array(
				'%idpaziente%' => $this->getIdPaziente(),
				'%idlistino%' => $this->getIdListino(),
				'%cognomericerca%' => $this->getCognomeRicerca(),
				'%cognome%' => $this->getCognome(),
				'%nome%' => $this->getNome(),
				'%datanascita%' => $this->getDataNascita(),
				'%idpreventivo%' => $this->getIdPreventivo(),
				'%idsottopreventivo%' => $this->getIdSottoPreventivo(),
				'%elencovocipreventivosecondario%' => $this->preparaTabellaVociPreventivoSecondario($vociPreventivoSecondarioTrovate),
				'%elencovocipreventivoprincipale%' => $this->preparaTabellaVociPreventivoPrincipale($vociPreventivoPrincipaleTrovate)
		);
			
		$utility = new utility();
		
		$template = $utility->tailFile($utility->getTemplate($risultati), $replace);
		echo $utility->tailTemplate($template);
		
	}

	public function preparaTabellaVociPreventivoPrincipale($voci) {

		$elencoVoci = "";
		$rowcounter = 0;
			
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
			
			$elencoVoci .= "<tr " . $class . "><td id='icons'><a class='tooltip' href='../preventivo/includiVocePreventivoFacade.class.php?modo=start&idpreventivo=" . $this->getIdPreventivo() . "&idsottopreventivo=" . $this->getIdSottoPreventivo() . "&idvocepreventivo=" . trim($row['idvocepreventivo']) . "&codicevocelistino=" . trim($row['codicevocelistino']) . "&prezzo=" . $row['prezzo'] . "&nomeform=" . trim($row['nomeform']) . "&nomecampoform=" . trim($row['nomecampoform']) . "&idlistino=" . $this->getIdlistino() . "&idpaziente=" . $this->getIdpaziente() . "&cognome=" . $this->getCognome() . "&nome=" . $this->getNome() . "&datanascita=" . $this->getDataNascita() . "'><li class='ui-state-default ui-corner-all' title='%ml.includiVoceTip%'><span class='ui-icon ui-icon-plus'></span></li></a></td>";
			$elencoVoci .= "<td align='center'>" . trim($campo) . "</td><td align='center'>" . $indSingolo . "</td><td align='center'>" . $indGruppo . "</td><td align='center'>" . $indCure . "</td><td align='center'>" . trim($row['codicevocelistino']) . "</td><td align='right'>" . $row['prezzo'] . "</td>";
			$elencoVoci .= "</tr>";
					
			++$rowcounter;
		}			
		return $elencoVoci;		
	}

	public function preparaTabellaVociPreventivoSecondario($voci) {

		$elencoVoci = "";
		$rowcounter = 0;
			
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
			$elencoVoci .= "<td align='center'>" . $campo . "</td><td align='center'>" . $indSingolo . "</td><td align='center'>" . $indGruppo . "</td><td align='center'>" . $indCure . "</td><td align='center'>" . $row['codicevocelistino'] . "</td><td align='right'>" . $row['prezzo'] . "</td>";
			$elencoVoci .= "<td id='icons'><a class='tooltip' href='../preventivo/escludiVocePreventivoFacade.class.php?modo=start&idpreventivo=" . $this->getIdPreventivo() . "&idsottopreventivo=" . $this->getIdSottoPreventivo() . "&idvocesottopreventivo=" . trim($row['idvocesottopreventivo']) . "&codicevocelistino=" . trim($row['codicevocelistino']) . "&prezzo=" . $row['prezzo'] . "&nomeform=" . trim($row['nomeform']) . "&nomecampoform=" . trim($row['nomecampoform']) . "&idlistino=" . $this->getIdlistino() . "&idpaziente=" . $this->getIdpaziente() . "&cognome=" . $this->getCognome() . "&nome=" . $this->getNome() . "&datanascita=" . $this->getDataNascita() . "'><li class='ui-state-default ui-corner-all' title='%ml.includiVoceTip%'><span class='ui-icon ui-icon-minus'></span></li></a></td>";
			$elencoVoci .= "</tr>";
		
			++$rowcounter;
		}
		return $elencoVoci;		
	}
}

?>