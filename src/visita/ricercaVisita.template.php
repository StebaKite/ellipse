<?php

require_once 'visita.abstract.class.php';

class ricercaVisitaTemplate  extends visitaAbstract {
	
	private static $filtri = "/visita/ricercaVisita.filtri.html";
	private static $risultatiTesta = "/visita/ricercaVisita.risultati.testata.html";
	private static $risultatiCorpo = "/visita/ricercaVisita.risultati.corpo.html";
	private static $risultatiPiede = "/visita/ricercaVisita.risultati.piede.html";

	private static $numeroVisiteTrovate;
	private static $visiteTrovate;
	private static $visite;

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
		
	// Setters ---------------------------------

	public function setNumeroVisiteTrovate($numEle) {
		self::$numeroVisiteTrovate = $numEle;
	}
	public function setVisiteTrovate($visiteTrovate) {
		self::$visiteTrovate = $visiteTrovate;
	}
	public function setVisite($visite) {
		self::$visite = $visite;
	}
		
	// Getters --------------------------------
	
	public function getNumeroVisiteTrovate() {
		return self::$numeroVisiteTrovate;
	}
	public function getVisiteTrovate() {
		return self::$visiteTrovate;
	}
	public function getVisite() {
		return self::$visite;
	}
	
	// template ------------------------------------------------

	public function inizializzaPagina() {
	}

	public function displayFiltri() {
		
		require_once 'utility.class.php';

		// Template ----------------------------------
		
		// SB - Sta roba va sistemata un attimo... (il foreach non serve per far vedere i dati del paziente nei filtri)
		//      meglio passarli nella GET
	
		$utility = new utility();
		$array = $utility->getConfig();

		$filtri = self::$root . $array['template'] . self::$filtri;
		$visiteTrovate = $this->getVisiteTrovate();

		$this->setVisite(pg_fetch_all($visiteTrovate));

		foreach($this->getVisite() as $row) {
			
			$this->setCognome($row['cognome']);
			$this->setNome($row['nome']);
			$this->setDataNascita($row['datanascita']);
			
			$replace = array(
				'%idPaziente%' => $row['idpaziente'],
				'%idListino%' => $row['idlistino'],
				'%cognomeRicerca%' => $this->getCognomeRicerca(),
				'%cognome%' => $row['cognome'],
				'%nome%' => $row['nome'],
				'%datanascita%' => $row['datanascita']
			);
		}
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
		
		$numVisite = $this->getNumeroVisiteTrovate();

		if ($numVisite > 0) {
			if ($numVisite > 1) { 
				$text1 = "%ml.trovate% "; $text2 = " %ml.visite%";
			} else {
				$text1 = "%ml.trovata% "; $text2 = " %ml.visita%";
			}
			
			$text0 = $this->getMessaggio();
			if ($text0 != "") {$text0 = $text0 . " - ";};

			$replace = array('%messaggio%' => $text0 . $text1 . $numVisite . $text2);
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioInfo), $replace);
			
			echo $utility->tailTemplate($template);

			// Prepara la tabella dei risultati della ricerca
			echo $utility->getTemplate($risultatiTesta);

			$templateRiga = $utility->getTemplate($risultatiCorpo);
			$visiteTrovate = $this->getVisiteTrovate();

			$rowcounter = 0;
			$oggi = date('d/m/Y');
			
			foreach($this->getVisite() as $row) {

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
				// nasconde il bottone cancella paziente se ha figli legati
				// solo nel caso di paziente provvisorio compare il bottone anche se ha figli  (delete cascade su db)

				$bottoneCancella = "<a class='tooltip' href='cancellaVisitaFacade.class.php?modo=start&idPaziente=" . stripslashes($row['idpaziente']) . "&idListino=" . stripslashes($row['idlistino']) . "&idVisita=" . stripslashes($row['idvisita']) . "&datainserimento=" . stripslashes($row['datainserimento']) . "&stato=" . stripslashes($row['stato']) . "&cognRic=" . $this->getCognomeRicerca() . "&cognome=" . $this->getCognome() . "&nome=" . $this->getNome() . "&datanascita=" . $this->getDataNascita() . "'><li class='ui-state-default ui-corner-all' title='Cancella'><span class='ui-icon ui-icon-trash'></span></li></a>";

				if ($row['stato'] == "Preventivata") {
					$bottoneCancella = "";
				}

				++$rowcounter;			

				$replace = array(
					'%class%' => $class,
					'%idvisita%' => stripslashes($row['idvisita']),
					'%idpaziente%' => stripslashes($row['idpaziente']),
					'%idlistino%' => stripslashes($row['idlistino']),
					'%cognome%' => $this->getCognome(),
					'%nome%' => $this->getNome(),
					'%datanascita%' => $this->getDataNascita(),
					'%cognomeRicerca%' => $this->getCognomeRicerca(),
					'%datainserimento%' => stripslashes($row['datainserimento']),
					'%bottoneCancella%' => $bottoneCancella,
					'%stato%' => stripslashes($row['stato'])
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
