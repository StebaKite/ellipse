<?php

require_once 'gestionePaziente.abstract.class.php';

class ricercaPazienteTemplate extends gestionePazienteAbstract  {
	
	public static $filtri = "/paziente/ricercaPaziente.filtri.html";
	public static $risultatiTesta = "/paziente/ricercaPaziente.risultati.testata.html";
	public static $risultatiCorpo = "/paziente/ricercaPaziente.risultati.corpo.html";
	public static $risultatiPiede = "/paziente/ricercaPaziente.risultati.piede.html";
	public static $messaggioInfo = "/messaggioInfo.html";
	public static $messaggioErrore = "/messaggioErrore.html";
	
	private static $cognomeStyle;	
	private static $cognomeTip;	
	private static $cognomeDisable;

	//-----------------------------------------------------------------------------

	function __construct() {
		self::$root = $_SERVER['DOCUMENT_ROOT'];
	}
		
	// Setters ---------------------------------
	
	public function setCognomeStyle($style) {
		self::$cognomeStyle = $style;
	}
	public function setCognomeTip($tip) {
		self::$cognomeTip = $tip;
	}
	public function setCognomeDisable($disable) {
		self::$cognomeDisable = $disable;
	}
		
	// Getters --------------------------------

	public function getCognomeStyle() {
		return self::$cognomeStyle;
	}
	public function getCognomeTip() {
		return self::$cognomeTip;
	}
	public function getCognomeDisable() {
		return self::$cognomeDisable;
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
				'%cognome%' => $_SESSION['cognome'],
				'%cognomeDisable%' => $this->getCognomeDisable(),
				'%azione%' => $this->getAzione(),
				'%testoAzione%' => $this->getTestoAzione(),
				'%tuttiChecked%' => $_SESSION['tuttiChecked'],
				'%modificatiOggiChecked%' => $_SESSION['modificatiOggiChecked'],
				'%conSenzaProposteChecked%' => $_SESSION['conSenzaProposteChecked'],
				'%conProposteChecked%' => $_SESSION['conProposteChecked'],
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
		
		$numPazienti = $_SESSION['numeroPazientiTrovati'];

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
			$pazientiTrovati = $_SESSION['pazientiTrovati'];

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

				$bottoneCancella = "<a class='tooltip' href='../paziente/cancellaPazienteFacade.class.php?modo=start&idPaziente=" . $row['idpaziente'] . "'><li class='ui-state-default ui-corner-all' title='Cancella'><span class='ui-icon ui-icon-trash'></span></li></a>";

				if ($row['tipo'] == "D") {
					if (($row['numvisite'] > 0) or
						($row['numpreventivi'] > 0) or
						($row['numcartellecliniche'] > 0))  $bottoneCancella = "";
				}

				// BOTTONE VISITE -----------------------------------------------
				// Se il paziente non ha visite il bottone fa atterrare sulla pagina di creazione nuova visita
				// altrimenti atterra sull'elenco delle visite

				$bottoneVisite = "<a class='tooltip' href='../visita/ricercaVisitaFacade.class.php?modo=start&idPaziente=" . $row['idpaziente'] . "&idListino=" . $row['idlistino'] . "&cognome=" . str_replace("'","&apos;",$row['cognome']) . "&nome=" . str_replace("'","&apos;",$row['nome']) . "&datanascita=" . $row['datanascita'] . "'><li class='ui-state-default ui-corner-all' title='Ricerca visita'><span class='ui-icon ui-icon-person'></span></li></a>";

				if ($row['numvisite'] == 0) {
					$bottoneVisite = "<a class='tooltip' href='../visita/creaVisitaFacade.class.php?modo=start&idPaziente=" . $row['idpaziente'] . "&idListino=" . $row['idlistino'] . "&cognome=" . str_replace("'","&apos;",$row['cognome']) . "&nome=" . str_replace("'","&apos;",$row['nome']) . "&datanascita=" . $row['datanascita'] . "'><li class='ui-state-default ui-corner-all' title='Crea una nuova visita'><span class='ui-icon ui-icon-person'></span></li></a>";
				}

				// BOTTONE PREVENTIVI -----------------------------------------------
				// Se il paziente non ha preventivi il bottone fa atterrare sulla pagina di creazione nuovo preventivo
				// altrimenti atterra sull'elenco dei preventivi
				
				$bottonePreventivi = "<a class='tooltip' href='../preventivo/ricercaPreventivoFacade.class.php?modo=start&idPaziente=" . $row['idpaziente'] . "&idListino=" . $row['idlistino'] . "&cognome=" . str_replace("'","&apos;",$row['cognome']) . "&nome=" . str_replace("'","&apos;",$row['nome']) . "&datanascita=" . $row['datanascita'] . "'><li class='ui-state-default ui-corner-all' title='Ricerca preventivo'><span class='ui-icon ui-icon-note'></span></li></a>";
				
				if ($row['numpreventivi'] == 0) {
					$bottonePreventivi = "<a class='tooltip' href='../preventivo/creaPreventivoFacade.class.php?modo=start&idPaziente=" . $row['idpaziente'] . "&idListino=" . $row['idlistino'] . "&cognome=" . str_replace("'","&apos;",$row['cognome']) . "&nome=" . str_replace("'","&apos;",$row['nome']) . "&datanascita=" . $row['datanascita'] . "'><li class='ui-state-default ui-corner-all' title='Crea una nuovo preventivo'><span class='ui-icon ui-icon-note'></span></li></a>";
				}

				//  qui gli altri bottoni condizionati
				
				++$rowcounter;			

				$replace = array(
					'%class%' => $class,
					'%cognomeRicerca%' => $_SESSION['cognome'],
					'%idPaziente%' => $row['idpaziente'],
					'%cognome%' => $row['cognome'],
					'%nome%' => $row['nome'],
					'%dataNascita%' => $row['datanascita'],
					'%numvisite%' => $row['numvisite'],
					'%numpreventivi%' => $row['numpreventivi'] + $row['numsottopreventivi'],
					'%numcartellecliniche%' => $row['numcartellecliniche'],
					'%bottoneCancella%' => $bottoneCancella,
					'%bottoneVisite%' => $bottoneVisite,
					'%bottonePreventivi%' => $bottonePreventivi
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
