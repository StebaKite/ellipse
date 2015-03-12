<?php

require_once 'preventivo.abstract.class.php';

class ricercaNotaVoceTemplate extends preventivoAbstract {

	private static $filtri = "/preventivo/ricercaNotaVoce.filtri.html";
	private static $risultatiTesta = "/preventivo/ricercaNotaVoce.risultati.testata.html";
	private static $risultatiCorpo = "/preventivo/ricercaNotaVoce.risultati.corpo.html";
	private static $risultatiPiede = "/preventivo/ricercaNotaVoce.risultati.piede.html";

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
	
		$titoloPagina = ($_SESSION['idPreventivo'] != "") ? '%ml.ricercaNotaVocePreventivoPrincipale%' : '%ml.ricercaNotaVocePreventivoSecondario%';
		$idpreventivo = ($_SESSION['idPreventivo'] != '') ? $_SESSION['idPreventivo'] : $_SESSION['idSottoPreventivo'];
	
		$replace = array(
				'%idPaziente%' => $_SESSION['idPaziente'],
				'%idPreventivo%' => $idpreventivo,
				'%cognome%' => $_SESSION['cognome'],
				'%nome%' => $_SESSION['nome'],
				'%datanascita%' => $_SESSION['datanascita'],
				'%titoloPagina%' => $titoloPagina
		);
		$template = $utility->tailFile($utility->getTemplate($filtri), $replace);
		echo $utility->tailTemplate($template);
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
	
		$numNote = $_SESSION['numeronotetrovate'];
	
		if ($numNote > 0) {
				
			$text1 = ($numNote > 1) ? "%ml.trovate% " : "%ml.trovata% ";
			$text2 = ($numNote > 1) ? " %ml.note%" : " %ml.nota%";
	
			$text0 = $this->getMessaggio();
			if ($text0 != "") {$text0 = $text0 . " - ";};
	
			$replace = array('%messaggio%' => $text0 . $text1 . $numNote . $text2);
	
			if (strpos($text0,'Ko')) $template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
			else $template = $utility->tailFile($utility->getTemplate(self::$messaggioInfo), $replace);
	
			echo $utility->tailTemplate($template);
	
			// Prepara la tabella dei risultati della ricerca
			echo $utility->getTemplate($risultatiTesta);
	
			$templateRiga = $utility->getTemplate($risultatiCorpo);
	
			$rowcounter = 0;
			$oggi = date('d/m/Y');
	
			foreach(pg_fetch_all($_SESSION['notetrovate']) as $row) {
	
				/**
				 * evidenzia in bold la riga se è stata inserita o modificata oggi
				 */
	
				if ($rowcounter % 2 == 0) {
					if (($row['datainserimento'] == $oggi) or ($row['datamodifica'] == $oggi))
						$class = "class='modifiedOn'";
					else $class = "class='on'";
				}
				else {
					if (($row['datainserimento'] == $oggi) or ($row['datamodifica'] == $oggi))
						$class = "class='modifiedOff'";
					else $class = "class=''";
				}
					
				/**
				 * Bottone modifica e cancella
				 */
				$bottoneModifica = "<a class='tooltip' href='../preventivo/modificaNotaVocePreventivoFacade.class.php?modo=start&idNotaVocePreventivo=" . $row['idnotavocepreventivo'] . "'><li class='ui-state-default ui-corner-all' title='Modifica'><span class='ui-icon ui-icon-pencil'></span></li></a>";
				$bottoneCancella = "<a class='tooltip' href='../preventivo/cancellaNotaVocePreventivoFacade.class.php?modo=start&idNotaVocePreventivo=" . $row['idnotavocepreventivo'] . "'><li class='ui-state-default ui-corner-all' title='Cancella'><span class='ui-icon ui-icon-trash'></span></li></a>";
	
				/**
				 * Compongo la riga dell'elenco
				 */
				++$rowcounter;
				
				$replace = array(
						'%class%' => $class,
						'%idnotavocepreventivo%' => $row['idnotavocepreventivo'],
						'%nota%' => $row['nota'],
						'%bottoneModifica%' => $bottoneModifica,
						'%bottoneCancella%' => $bottoneCancella
				);
	
				$riga = $templateRiga;
				echo $utility->tailTemplate($utility->tailFile($riga, $replace));
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