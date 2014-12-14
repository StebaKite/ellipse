<?php

class ricercaPazienteTemplate {
	
	private static $root;
	private static $filtri = "/paziente/ricercaPaziente.filtri.html";
	private static $risultatiTesta = "/paziente/ricercaPaziente.risultati.testata.html";
	private static $risultatiCorpo = "/paziente/ricercaPaziente.risultati.corpo.html";
	private static $risultatiPiede = "/paziente/ricercaPaziente.risultati.piede.html";
	private static $messaggioInfo = "/messaggioInfo.html";
	private static $messaggioErrore = "/messaggioErrore.html";
	
	private static $azione;
	private static $testoAzione;

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
	public function setAzione($azione) {
		self::$azione = $azione;
	}
	public function setTestoAzione($testoAzione) {
		self::$testoAzione = $testoAzione;
	}	
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
	public function getAzione() {
		return self::$azione;
	}
	public function getTestoAzione() {
		return self::$testoAzione;
	}
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

				// nasconde il bottone cancella paziente se ha figli legati
			
				if (($row['numvisite'] > 0) or
					($row['numpreventivi'] > 0) or
					($row['numcartellecliniche'] > 0))
					$bottoneCancella = "";
				else
					$bottoneCancella = "<a class='tooltip' href='cancellaPazienteFacade.class.php?modo=start&idPaziente=%idPaziente%'><li class='ui-state-default ui-corner-all' title='Cancella'><span class='ui-icon ui-icon-trash'></span></li></a>";

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
					'%bottoneCancella%' => $bottoneCancella
				);

				$riga = $templateRiga;
				echo $utility->tailFile($riga, $replace);	
			}
		}
		else {

			$replace = array('%messaggio%' => '%ml.norisultati%');
			$template = $utility->tailFile($utility->getTemplate($messaggioErrore), $replace);
			
			echo $utility->tailTemplate($template);
		}
		echo $utility->getTemplate($risultatiPiede);
	}	
}
?>
