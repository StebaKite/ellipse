<?php

require_once 'gestionePaziente.abstract.class.php';

class ricercaPazienteTemplate extends gestionePazienteAbstract  {
	
	public static $filtri = "/paziente/ricercaPaziente.filtri.html";
	public static $risultatiTesta = "/paziente/ricercaPaziente.risultati.testata.html";
	public static $risultatiCorpo = "/paziente/ricercaPaziente.risultati.corpo.html";
	public static $risultatiPiede = "/paziente/ricercaPaziente.risultati.piede.html";
	public static $messaggioInfo = "/messaggioInfo.html";
	public static $messaggioErrore = "/messaggioErrore.html";
	

	private static $cognome;
	private static $cognomeStyle;	
	private static $cognomeTip;	
	private static $cognomeDisable;

	private static $numeroPazientiTrovati;
	private static $pazientiTrovati;
	private static $messaggio;

	//-----------------------------------------------------------------------------

	function __construct() {
		
		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/paziente:" . self::$root . "/ellipse/src/utility";  
		set_include_path($pathToInclude);		
	}
		
	// Setters ---------------------------------
	
	public function setCognome($cognome) {
		self::$cognome = $cognome;	
	}
	public function setCognomeStyle($style) {
		self::$cognomeStyle = $style;
	}
	public function setCognomeTip($tip) {
		self::$cognomeTip = $tip;
	}
	public function setCognomeDisable($disable) {
		self::$cognomeDisable = $disable;
	}
	public function setNumeroPazientiTrovati($numEle) {
		self::$numeroPazientiTrovati = $numEle;
	}
	public function setPazientiTrovati($pazientiTrovati) {
		self::$pazientiTrovati = $pazientiTrovati;
	}
	public function setMessaggio($messaggio) {
		self::$messaggio = $messaggio;
	}
		
	// Getters --------------------------------

	public function getCognome() {
		return self::$cognome;
	}
	public function getCognomeStyle() {
		return self::$cognomeStyle;
	}
	public function getCognomeTip() {
		return self::$cognomeTip;
	}
	public function getCognomeDisable() {
		return self::$cognomeDisable;
	}
	public function getNumeroPazientiTrovati() {
		return self::$numeroPazientiTrovati;
	}
	public function getPazientiTrovati() {
		return self::$pazientiTrovati;
	}
	public function getMessaggio() {
		return self::$messaggio;
	}
	
	// template ------------------------------------------------

	public function inizializzaPagina() {

		$this->setCognome("");
	}

	public function displayFiltri() {

		require_once 'utility.class.php';

		// Template ----------------------------------
		
		$utility = new utility();
		$array = $utility->getConfig();

		$filtri = self::$root . $array['template'] . self::$filtri;

		$replace = array(
			'%cognomeStyle%' => $this->getCognomeStyle(),
			'%cognomeTip%' => $this->getCognomeTip(),
			'%cognome%' => $this->getCognome(),
			'%cognomeDisable%' => $this->getCognomeDisable(),
			'%azione%' => $this->getAzione(),
			'%testoAzione%' => $this->getTestoAzione()
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
		$messaggioInfo = self::$root . $array['template'] . self::$messaggioInfo;
		$messaggioErrore = self::$root . $array['template'] . self::$messaggioErrore;
		
		// Gestione del messaggio -------------------
		
		$numPazienti = $this->getNumeroPazientiTrovati();

		if ($numPazienti > 0) {
			if ($numPazienti > 1) { 
				$text1 = "%ml.trovati% "; $text2 = " %ml.pazienti%";
			} else {
				$text1 = "%ml.trovato% "; $text2 = " %ml.paziente%";
			}
			
			$text0 = $this->getMessaggio();
			if ($text0 != "") {$text0 = $text0 . " - ";};

			$replace = array('%messaggio%' => $text0 . $text1 . $numPazienti . $text2);
			$template = $utility->tailFile($utility->getTemplate($messaggioInfo), $replace);
			
			echo $utility->tailTemplate($template);

			// Prepara la tabella dei risultati della ricerca
			echo $utility->getTemplate($risultatiTesta);

			$templateRiga = $utility->getTemplate($risultatiCorpo);
			$pazientiTrovati = $this->getPazientiTrovati();

			$rowcounter = 0;
			$oggi = date('d/m/Y');
			
			while ($row = pg_fetch_array($pazientiTrovati)) {

				// evidenzia in bold la riga se è stata inserita o modificata oggi
				
				if ($rowcounter % 2 == 0) {
					if (($row['datainserimento'] == $oggi) or ($row['datamodifica'] == $oggi)) {
						if ($row['tipo'] == "D") $class = "class='modifiedOn'";
						if ($row['tipo'] == "P") $class = "class='provModifiedOn'";
					}
					else {
						if ($row['tipo'] == "D") $class = "class='on'";
						if ($row['tipo'] == "P") $class = "class='provModifiedOn'";
					}
				}
				else {
					if (($row['datainserimento'] == $oggi) or ($row['datamodifica'] == $oggi)) {
						if ($row['tipo'] == "D") $class = "class='modifiedOff'";
						if ($row['tipo'] == "P") $class = "class='provModifiedOff'";
					}
					else {
						if ($row['tipo'] == "D") $class = "class=''";
						if ($row['tipo'] == "P") $class = "class='provModifiedOff'";
					}
				}

				// BOTTONE CANCELLA -----------------------------------------------
				// nasconde il bottone cancella paziente se ha figli legati
				// solo nel caso di paziente provvisorio compare il bottone anche se ha figli  (delete cascade su db)

				$bottoneCancella = "<a class='tooltip' href='cancellaPazienteFacade.class.php?modo=start&idPaziente=" . stripslashes($row['idpaziente']) . "&cognRic=" . $this->getCognome() . "'><li class='ui-state-default ui-corner-all' title='Cancella'><span class='ui-icon ui-icon-trash'></span></li></a>";

				if ($row['tipo'] == "D") {
					if (($row['numvisite'] > 0) or
						($row['numpreventivi'] > 0) or
						($row['numcartellecliniche'] > 0))  $bottoneCancella = "";
				}

				// BOTTONE VISITE -----------------------------------------------
				// Se il paziente non ha visite il bottone fa atterrare sulla pagina di creazione nuova visita
				// altrimenti atterra sull'elenco delle visite

				$bottoneVisite = "<a class='tooltip' href='ricercaVisitaFacade.class.php?modo=start&idPaziente=" . stripslashes($row['idpaziente']) . "&idListino=" . stripslashes($row['idlistino']) . "&cognRic=" . $this->getCognome() . "&cognome=" . stripslashes($row['cognome']) . "&nome=" . stripslashes($row['nome']) . "&datanascita=" . stripslashes($row['datanascita']) . "'><li class='ui-state-default ui-corner-all' title='Ricerca visita'><span class='ui-icon ui-icon-person'></span></li></a>";

				if ($row['numvisite'] == 0) {
					$bottoneVisite = "<a class='tooltip' href='creaVisitaFacade.class.php?modo=start&idPaziente=" . stripslashes($row['idpaziente']) . "&idListino=" . stripslashes($row['idlistino']) . "&cognRic=" . $this->getCognome() . "&cognome=" . stripslashes($row['cognome']) . "&nome=" . stripslashes($row['nome']) . "&datanascita=" . stripslashes($row['datanascita']) . "'><li class='ui-state-default ui-corner-all' title='Crea una nuova visita'><span class='ui-icon ui-icon-person'></span></li></a>";
				}

				++$rowcounter;			

				$replace = array(
					'%class%' => $class,
					'%cognomeRicerca%' => $this->getCognome(),
					'%idPaziente%' => stripslashes($row['idpaziente']),
					'%cognome%' => stripslashes($row['cognome']),
					'%nome%' => stripslashes($row['nome']),
					'%dataNascita%' => stripslashes($row['datanascita']),
					'%numvisite%' => stripslashes($row['numvisite']),
					'%numpreventivi%' => stripslashes($row['numpreventivi']),
					'%numcartellecliniche%' => stripslashes($row['numcartellecliniche']),
					'%bottoneCancella%' => $bottoneCancella,
					'%bottoneVisite%' => $bottoneVisite
				);

				$riga = $templateRiga;
				echo $utility->tailFile($riga, $replace);	
			}
		}
		else {

			$text0 = $this->getMessaggio();
			if ($text0 != "") {$text0 = $text0 . " - ";};

			$replace = array('%messaggio%' => $text0 . '%ml.norisultati%');
			$template = $utility->tailFile($utility->getTemplate($messaggioErrore), $replace);
			
			echo $utility->tailTemplate($template);

		}
		echo $utility->getTemplate($risultatiPiede);
	}	
}
?>
