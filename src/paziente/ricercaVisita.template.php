<?php

class ricercaVisitaTemplate {
	
	private static $root;
	private static $filtri = "/paziente/ricercaVisita.filtri.html";
	private static $risultatiTesta = "/paziente/ricercaVisita.risultati.testata.html";
	private static $risultatiCorpo = "/paziente/ricercaVisita.risultati.corpo.html";
	private static $risultatiPiede = "/paziente/ricercaVisita.risultati.piede.html";
	private static $messaggioInfo = "/messaggioInfo.html";
	private static $messaggioErrore = "/messaggioErrore.html";

	private static $cognomeRicerca;
	
	private static $azione;
	private static $testoAzione;
	private static $cognome;
	private static $nome;
	private static $dataNascita;

	private static $numeroVisiteTrovate;
	private static $visiteTrovate;
	private static $visite;
	private static $messaggio;
	private static $idPaziente;
	private static $idListino;

	//-----------------------------------------------------------------------------

	function __construct() {
		
		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/paziente:" . self::$root . "/ellipse/src/utility";  
		set_include_path($pathToInclude);		
	}
		
	// Setters ---------------------------------
	
	public function setCognomeRicerca($cognomeRicerca) {
		self::$cognomeRicerca = $cognomeRicerca;
	}
	public function setIdPaziente($idPaziente) {
		self::$idPaziente = $idPaziente;
	}
	public function setIdListino($idListino) {
		self::$idListino = $idListino;
	}
	public function setAzione($azione) {
		self::$azione = $azione;
	}
	public function setTestoAzione($testoAzione) {
		self::$testoAzione = $testoAzione;
	}	
	public function setNumeroVisiteTrovate($numEle) {
		self::$numeroVisiteTrovate = $numEle;
	}
	public function setVisiteTrovate($visiteTrovate) {
		self::$visiteTrovate = $visiteTrovate;
	}
	public function setMessaggio($messaggio) {
		self::$messaggio = $messaggio;
	}
	public function setCognome($cognome) {
		self::$cognome = $cognome;
	}
	public function setNome($nome) {
		self::$nome = $nome;
	}
	public function setDataNascita($dataNascita) {
		self::$dataNascita = $dataNascita;
	}
	public function setVisite($visite) {
		self::$visite = $visite;
	}
		
	// Getters --------------------------------
	
	public function getCognomeRicerca() {
		return self::$cognomeRicerca;
	}
	public function getIdPaziente() {
		return self::$idPaziente;
	}
	public function getIdListino() {
		return self::$idListino;
	}
	public function getAzione() {
		return self::$azione;
	}
	public function getTestoAzione() {
		return self::$testoAzione;
	}
	public function getNumeroVisiteTrovate() {
		return self::$numeroVisiteTrovate;
	}
	public function getVisiteTrovate() {
		return self::$visiteTrovate;
	}
	public function getMessaggio() {
		return self::$messaggio;
	}
	public function getCognome() {
		return self::$cognome;
	}
	public function getNome() {
		return self::$nome;
	}
	public function getDataNascita() {
		return self::$dataNascita;
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
			$template = $utility->tailFile($utility->getTemplate($messaggioInfo), $replace);
			
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

				++$rowcounter;			

				$replace = array(
					'%class%' => $class,
					'%idvisita%' => stripslashes($row['idvisita']),
					'%idpaziente%' => stripslashes($row['idpaziente']),
					'%cognome%' => $this->getCognome(),
					'%nome%' => $this->getNome(),
					'%datanascita%' => $this->getDataNascita(),
					'%cognomeRicerca%' => $this->getCognomeRicerca(),
					'%datainserimento%' => stripslashes($row['datainserimento']),
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
			$template = $utility->tailFile($utility->getTemplate($messaggioErrore), $replace);
			
			echo $utility->tailTemplate($template);

		}
		echo $utility->getTemplate($risultatiPiede);
	}	
}
?>
