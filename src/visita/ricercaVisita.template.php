<?php

require_once 'visita.abstract.class.php';

class ricercaVisitaTemplate  extends visitaAbstract {
	
	private static $filtri = "/visita/ricercaVisita.filtri.html";
	private static $risultatiTesta = "/visita/ricercaVisita.risultati.testata.html";
	private static $risultatiCorpo = "/visita/ricercaVisita.risultati.corpo.html";
	private static $risultatiPiede = "/visita/ricercaVisita.risultati.piede.html";

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
	
	// template ------------------------------------------------

	public function inizializzaPagina() {
	}

	public function displayFiltri() {
		
		require_once 'utility.class.php';

		// Template ----------------------------------
	
		$utility = new utility();
		$array = $utility->getConfig();
		$filtri = self::$root . $array['template'] . self::$filtri;
			
		$replace = array(
			'%idPaziente%' => $_SESSION['idPaziente'],
			'%idListino%' => $_SESSION['idListino'],
			'%cognomeRicerca%' => $_SESSION['cognRic'],
			'%cognome%' => $_SESSION['cognome'],
			'%nome%' => $_SESSION['nome'],
			'%datanascita%' => $_SESSION['datanascita']
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
		
		$numVisite = $_SESSION['numerovisitetrovate'];

		if ($numVisite > 0) {
			if ($numVisite > 1) { 
				$text1 = "%ml.trovate% "; $text2 = " %ml.visite%";
			} else {
				$text1 = "%ml.trovata% "; $text2 = " %ml.visita%";
			}
			
			$text0 = $this->getMessaggio();
			if ($text0 != "") {$text0 = $text0 . " - ";};

			$replace = array('%messaggio%' => $text0 . $text1 . $numVisite . $text2);
			
			if (strpos($text0,'Ko')) $template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
			else $template = $utility->tailFile($utility->getTemplate(self::$messaggioInfo), $replace);
			
			echo $utility->tailTemplate($template);

			// Prepara la tabella dei risultati della ricerca
			echo $utility->getTemplate($risultatiTesta);

			$templateRiga = $utility->getTemplate($risultatiCorpo);

			$rowcounter = 0;
			$oggi = date('d/m/Y');
			
			foreach($_SESSION['visitetrovate'] as $row) {

				// evidenzia in bold la riga se è stata inserita o modificata oggi
				
				if ($rowcounter % 2 == 0) {
					
					if ($row['stato'] == "01") {
						$class = "class='preventivataOn'";
					}
					else {
						if (($row['datainserimento'] == $oggi) or ($row['datamodifica'] == $oggi)) {
							$class = "class='modifiedOn'";
						}
						else {
							$class = "class='on'";
						}
					}					
				}
				else {

					if ($row['stato'] == "01") {
						$class = "class='preventivataOff'";
					}
					else {
						if (($row['datainserimento'] == $oggi) or ($row['datamodifica'] == $oggi)) {
							$class = "class='modifiedOff'";
						}
						else {
							$class = "class=''";
						}
					}
				}

				// BOTTONE MODIFICA -----------------------------------------------
				// nasconde il bottone modifica visita se ha generato un preventivo
				
				$bottoneModifica = "<a class='tooltip' href='../visita/modificaVisitaFacade.class.php?modo=start&idVisita=" . $row['idvisita'] . "&datainserimento=" . $row['datainserimento'] . "&stato=" . trim($row['stato']) . "'><li class='ui-state-default ui-corner-all' title='Modifica'><span class='ui-icon ui-icon-pencil'></span></li></a>";
				
				if ($row['stato'] == "Preventivata") {
					$bottoneModifica = "";
				}
				
				// BOTTONE CANCELLA -----------------------------------------------
				// nasconde il bottone cancella visita se ha generato un preventivo

				$bottoneCancella = "<a class='tooltip' href='cancellaVisitaFacade.class.php?modo=start&idVisita=" . $row['idvisita'] . "&datainserimento=" . $row['datainserimento'] . "&stato=" . $row['stato'] . "'><li class='ui-state-default ui-corner-all' title='Cancella'><span class='ui-icon ui-icon-trash'></span></li></a>";

				if ($row['stato'] == "Preventivata") {
					$bottoneCancella = "";
				}

				++$rowcounter;			

				$replace = array(
					'%class%' => $class,
					'%idvisita%' => stripslashes($row['idvisita']),
					'%idpaziente%' => stripslashes($row['idpaziente']),
					'%idlistino%' => stripslashes($row['idlistino']),
					'%datainserimento%' => stripslashes($row['datainserimento']),
					'%bottoneCancella%' => $bottoneCancella,
					'%bottoneModifica%' => $bottoneModifica,
					'%stato%' => trim($row['stato']),
					'%statovisita%' => '%ml.stato' . trim($row['stato']) . 'visita%'
				);

				$template = $utility->tailFile($templateRiga, $replace);
				echo $utility->tailTemplate($template);
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
