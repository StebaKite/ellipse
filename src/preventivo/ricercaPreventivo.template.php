<?php

require_once 'preventivo.abstract.class.php';

class ricercaPreventivoTemplate extends preventivoAbstract {

	private static $filtri = "/preventivo/ricercaPreventivo.filtri.html";
	private static $risultatiTesta = "/preventivo/ricercaPreventivo.risultati.testata.html";
	private static $risultatiCorpo = "/preventivo/ricercaPreventivo.risultati.corpo.html";
	private static $risultatiPiede = "/preventivo/ricercaPreventivo.risultati.piede.html";

	function __construct() {
		
		self::$root = $_SERVER['DOCUMENT_ROOT'];

		require_once 'utility.class.php';
		
		$utility = new utility();
		$array = $utility->getConfig();
		
		self::$messaggioErrore = self::$root . $array['messaggioErrore'];
		self::$messaggioInfo = self::$root . $array['messaggioInfo'];
	}

	// template ------------------------------------------------
	
	public function inizializzaPagina() {}
	
	public function displayFiltri() {

		require_once 'utility.class.php';
		
		// Template ----------------------------------
		
		$utility = new utility();
		$array = $utility->getConfig();
		
		$filtri = self::$root . $array['template'] . self::$filtri;
				
		$replace = array(
				'%idPaziente%' => $this->getIdpaziente(),
				'%idListino%' => $this->getIdlistino(),
				'%cognomeRicerca%' => $this->getCognomeRicerca(),
				'%cognome%' => $this->getCognome(),
				'%nome%' => $this->getNome(),
				'%datanascita%' => $this->getDataNascita()
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
		
		$numPreventivi = $this->getNumeroPreventiviTrovati();
		
		if ($numPreventivi > 0) {
			if ($numPreventivi > 1) {
				$text1 = "%ml.trovati% "; $text2 = " %ml.preventivi%";
			} else {
				$text1 = "%ml.trovato% "; $text2 = " %ml.preventivo%";
			}
				
			$text0 = $this->getMessaggio();
			if ($text0 != "") {$text0 = $text0 . " - ";};
		
			$replace = array('%messaggio%' => $text0 . $text1 . $numPreventivi . $text2);

			if (strpos($text0,'Ko')) $template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
			else $template = $utility->tailFile($utility->getTemplate(self::$messaggioInfo), $replace);
				
			echo $utility->tailTemplate($template);
		
			// Prepara la tabella dei risultati della ricerca
			echo $utility->getTemplate($risultatiTesta);
		
			$templateRiga = $utility->getTemplate($risultatiCorpo);
			$preventiviTrovati = $this->getPreventiviTrovati();
						
			$rowcounter = 0;
			$oggi = date('d/m/Y');
				
			foreach(pg_fetch_all($preventiviTrovati) as $row) {
		
				if (trim($row['tipopreventivo']) == 'P') {
					
					if ($row['stato'] == "01") $class = "class='parentAccettato'";
					else $class = "class='parent'";
					
					$id = "id='" . trim($row['idpreventivo']) . "'";
					$idpreventivo = trim($row['idpreventivo']);
					$idsottopreventivo = "";
				}
				elseif (trim($row['tipopreventivo']) == 'S') {
					$class = "class='child-" . trim($row['idpreventivo']) . "'";

					if ($row['stato'] == "01") $id = "id='childAccettato'";
					else $id = "id='child'";
					
					$idpreventivo = "";
					$idsottopreventivo = trim($row['idsottopreventivo']);
					$idpreventivoprincipale = trim($row['idpreventivo']);
				}

				// BOTTONE DETTAGLIO -----------------------------------------------
				// nasconde il bottone dettaglio preventivo se è vuoto
				
				$bottoneDettaglio = "<a class='tooltip' href='../preventivo/dettaglioPreventivoFacade.class.php?modo=start&idPaziente=" . $this->getIdpaziente() . "&idListino=" . $this->getIdlistino() . "&idPreventivo=" . $idpreventivo . "&idPreventivoPrincipale=" . $idpreventivoprincipale . "&idSottoPreventivo=" . $idsottopreventivo . "&datainserimento=" . stripslashes($row['datainserimento']) . "&stato=" . stripslashes($row['stato']) . "&cognRic=" . $this->getCognomeRicerca() . "&cognome=" . $this->getCognome() . "&nome=" . $this->getNome() . "&datanascita=" . $this->getDataNascita() . "'><li class='ui-state-default ui-corner-all' title='Dettaglio'><span class='ui-icon ui-icon-search'></span></li></a>";
				if ($row['totalepreventivo'] == 0) {
					$bottoneDettaglio = "";
				}

				// BOTTONE MODIFICA -----------------------------------------------
				
				$bottoneModifica = "<a class='tooltip' href='../preventivo/modificaPreventivoFacade.class.php?modo=start&idPaziente=" . $this->getIdpaziente() . "&idListino=" . $this->getIdlistino() . "&idPreventivo=" . $idpreventivo . "&idPreventivoPrincipale=" . $idpreventivoprincipale . "&idSottoPreventivo=" . $idsottopreventivo . "&datainserimento=" . stripslashes($row['datainserimento']) . "&stato=" . stripslashes($row['stato']) . "&cognRic=" . $this->getCognomeRicerca() . "&cognome=" . $this->getCognome() . "&nome=" . $this->getNome() . "&datanascita=" . $this->getDataNascita() . "'><li class='ui-state-default ui-corner-all' title='Modifica'><span class='ui-icon ui-icon-pencil'></span></li></a>";
				
// 				if ($row['stato'] == "01") {
// 					$bottoneModifica = "";
// 				}
				
				// BOTTONE CANCELLA -----------------------------------------------
				// nasconde il bottone cancella paziente se ha figli legati
				// solo nel caso di paziente provvisorio compare il bottone anche se ha figli  (delete cascade su db)
		
				$bottoneCancella = "<a class='tooltip' href='../preventivo/cancellaPreventivoFacade.class.php?modo=start&idPaziente=" . $this->getIdpaziente() . "&idListino=" . $this->getIdlistino() . "&idPreventivo=" . $idpreventivo . "&idPreventivoPrincipale=" . $idpreventivoprincipale . "&idSottoPreventivo=" . $idsottopreventivo . "&datainserimento=" . stripslashes($row['datainserimento']) . "&stato=" . stripslashes($row['stato']) . "&cognRic=" . $this->getCognomeRicerca() . "&cognome=" . $this->getCognome() . "&nome=" . $this->getNome() . "&datanascita=" . $this->getDataNascita() . "'><li class='ui-state-default ui-corner-all' title='Cancella'><span class='ui-icon ui-icon-trash'></span></li></a>";
		
				if ($row['stato'] != "00") {
					$bottoneCancella = "";
				}
		
				// BOTTONE SPLIT -----------------------------------------------
				// nasconde il bottone split :
				//   - per i preventivi secondari
				//   - per i preventivi in stato "Accettato"
				//   - per i preventivi vuoti
				
				$bottoneSplit = "<a class='tooltip' href='../preventivo/splitPreventivoFacade.class.php?modo=start&idPaziente=" . $this->getIdpaziente() . "&idListino=" . $this->getIdlistino() . "&idPreventivo=" . $idpreventivo . "&datainserimento=" . stripslashes($row['datainserimento']) . "&stato=" . stripslashes($row['stato']) . "&cognRic=" . $this->getCognomeRicerca() . "&cognome=" . $this->getCognome() . "&nome=" . $this->getNome() . "&datanascita=" . $this->getDataNascita() . "'><li class='ui-state-default ui-corner-all' title='Crea un preventivo secondario'><span class='ui-icon ui-icon-newwin'></span></li></a>";

				if ((trim($row['tipopreventivo']) == 'S')
				or ($row['stato'] == "01")
				or ($row['totalepreventivo'] == 0))
				{
					$bottoneSplit = "";
				}				

				// BOTTONE STAMPA -----------------------------------------------
				// nasconde il bottone stampa preventivo se è vuoto
				
				$bottoneStampa = "<a class='tooltip' href='../preventivo/dettaglioPreventivoFacade.class.php?modo=start&idPaziente=" . $this->getIdpaziente() . "&idListino=" . $this->getIdlistino() . "&idPreventivo=" . $idpreventivo . "&idPreventivoPrincipale=" . $idpreventivoprincipale . "&idSottoPreventivo=" . $idsottopreventivo . "&datainserimento=" . stripslashes($row['datainserimento']) . "&stato=" . stripslashes($row['stato']) . "&cognRic=" . $this->getCognomeRicerca() . "&cognome=" . $this->getCognome() . "&nome=" . $this->getNome() . "&datanascita=" . $this->getDataNascita() . "'><li class='ui-state-default ui-corner-all' title='Stampa'><span class='ui-icon ui-icon-print'></span></li></a>";
				if ($row['totalepreventivo'] == 0) {
					$bottoneStampa = "";
				}
				
				// Stati ---------------------------------------------------------
				if (trim($row['stato']) == '00') $stato = '%ml.proposto%';
				if (trim($row['stato']) == '01') $stato = '%ml.accettato%';
				if (trim($row['stato']) == '02') $stato = '%ml.parzialmenteaccettato%';
				if (trim($row['stato']) == '03') $stato = '%ml.splittato%';
				
				++$rowcounter;
		
				$replace = array(
						'%class%' => $class,
						'%id%' => $id,
						'%idpreventivo%' => $idpreventivo,
						'%idpreventivoprincipale%' => $idpreventivoprincipale,
						'%idsottopreventivo%' => $idsottopreventivo,
						'%idpaziente%' => $this->getIdpaziente(),
						'%idlistino%' => $this->getIdlistino(),
						'%cognome%' => $this->getCognome(),
						'%nome%' => $this->getNome(),
						'%datanascita%' => $this->getDataNascita(),
						'%cognomeRicerca%' => $this->getCognomeRicerca(),
						'%datainserimento%' => stripslashes($row['datainserimento']),
						'%datamodifica%' => stripslashes($row['datamodifica']),
						'%bottoneDettaglio%' => $bottoneDettaglio,
						'%bottoneModifica%' => $bottoneModifica,
						'%bottoneCancella%' => $bottoneCancella,
						'%bottoneStampa%' => $bottoneStampa,
						'%bottoneSplit%' => $bottoneSplit,
						'%stato%' => $stato,
						'%totalepreventivo%' => number_format(trim(stripslashes($row['totalepreventivo'])), 2, ',', '.'),
				);
		
				$riga = $templateRiga;				
				echo $utility->tailTemplate($utility->tailFile($riga, $replace));
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