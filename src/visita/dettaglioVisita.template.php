<?php

require_once 'visita.abstract.class.php';

class riepilogoVociVisita extends visitaAbstract {

	private static $pagina = "/visita/visita.dettaglio.form.html";
	private static $paginaSingoli = "/visita/visita.dettagliosingoli.form.html";
	private static $paginaGruppi = "/visita/visita.dettagliogruppi.form.html";
	private static $paginaCure = "/visita/visita.dettagliocure.form.html";

	public static $azione;
	public static $azioneTip;
	public static $labelBottone;
	
	//-----------------------------------------------------------------------------

	function __construct() {
		self::$root = $_SERVER['DOCUMENT_ROOT'];
	}

	public function setAzione($azione) {
		self::$azione = $azione;
	}
	public function setAzioneTip($azioneTip) {
		self::$azione = $azioneTip;
	}
	public function setLabelBottone($labelBottone) {
		self::$labelBottone = $labelBottone;
	}
	
	// Getters --------------------------------------------------------------------

	public function getAzione() {
		return self::$azione;
	}
	public function getAzioneTip() {
		return self::$azioneTip;
	}
	public function getLabelBottone() {
		return self::$labelBottone;
	}
	
	// ----------------------------------------------------------------------------
	
	public function displayPagina() {

		require_once 'database.class.php';
		require_once 'utility.class.php';
		
		// Template --------------------------------------------------------------

		$utility = new utility();
		$array = $utility->getConfig();

		$form = self::$root . $array['template'] . self::$pagina;
		$formSingoli = self::$root . $array['template'] . self::$paginaSingoli;
		$formGruppi = self::$root . $array['template'] . self::$paginaGruppi;
		$formCure = self::$root . $array['template'] . self::$paginaCure;
				
		$replace = array(
			'%titoloPagina%' => $this->getTitoloPagina(),
			'%bottonePreventivo%' => $this->preparaBottonePreventivo($_SESSION['statovisita']),
			'%cognome%' => $_SESSION['cognome'],
			'%nome%' => $_SESSION['nome'],
			'%datanascita%' => $_SESSION['datanascita'],
			'%idVisita%' => $_SESSION['idVisita'],
			'%datainserimento%' => $_SESSION['datainserimentovisita'],
			'%stato%' => '%ml.stato' . $_SESSION['statovisita'] . 'visita%'
		);

		// Preparo la tab per le voci riferite ai denti singoli -----------------------------------------------------
		
		if ($_SESSION['vocivisitadentisingoli']) {	

			$riepilogoVociVisitaDentiSingoli = "";
			$replace['%riepilogoDentiSingoliTab%'] = "<li><a href='#tabs-1'>%ml.dentiSingoli%</a></li>"; 
			
			$denteBreak = "";
			foreach ($_SESSION['vocivisitadentisingoli'] as $row) {
				
				$dente = split("_", $row['nomecampoform']);
				if ($dente[1] != $denteBreak) {
					$riepilogoVociVisitaDentiSingoli .= "<tr><td>" . $dente[1] . "</td><td>" . $row['codicevocelistino'] . "</td><td>" . $row['descrizionevoce'] . "</td></tr>";
					$denteBreak = $dente[1];
				}
				else {
					$riepilogoVociVisitaDentiSingoli .= "<tr><td></td><td>" . $row['codicevocelistino'] . "</td><td>" . $row['descrizionevoce'] . "</td></tr>";
				}
			}
			
			$replace['%riepilogoDentiSingoli%'] = $riepilogoVociVisitaDentiSingoli;			
			$template = $utility->tailFile($utility->getTemplate($formSingoli), $replace);
			$replace['%riepilogoDentiSingoliDiv%'] = $template;
	
		}
		else {
			$replace['%riepilogoDentiSingoliTab%'] = ""; 
			$replace['%riepilogoDentiSingoliDiv%'] = ""; 
			$replace['%riepilogoDentiSingoli%'] = "";
		}

		// Preparo la tab per le voci riferite ai gruppi di denti --------------------------------------------------
		
		if ($_SESSION['vocivisitagruppi']) {	

			$riepilogoVociVisitaGruppi = "";
			$replace['%riepilogoGruppiTab%'] = "<li><a href='#tabs-2'>%ml.gruppi%</a></li>"; 

			$voceListinoBreak = "";
			
			foreach ($_SESSION['vocivisitagruppi'] as $row) {

				$dente = split("_", $row['nomecampoform']);

				if (trim($row['codicevocelistino']) != trim($voceListinoBreak)) {
					$riepilogoVociVisitaGruppi .= "<tr><td>" . $row['codicevocelistino'] . "</td><td>" . $row['descrizionevoce'] . "</td><td>" . $dente[1] . "</td></tr>";
					$voceListinoBreak = $row['codicevocelistino'];
				}
				else {
					$riepilogoVociVisitaGruppi .= "<tr><td></td><td></td><td>" . $dente[1] . "</td></tr>";
				}
			}
			
			$replace['%riepilogoGruppi%'] = $riepilogoVociVisitaGruppi;			
			$template = $utility->tailFile($utility->getTemplate($formGruppi), $replace);
			$replace['%riepilogoGruppiDiv%'] = $template;
		}
		else {
			$replace['%riepilogoGruppiTab%'] = "";
			$replace['%riepilogoGruppiDiv%'] = "";
			$replace['%riepilogoGruppi%'] = "";
		}

		// Preparo la tab per le voci riferite alle cure generiche  --------------------------------------------------
		
		if ($_SESSION['vocivisitacure']) {	

			$riepilogoVociVisitaCure = "";
			$replace['%riepilogoCureTab%'] = "<li><a href='#tabs-3'>%ml.cure%</a></li>"; 
			
			foreach ($_SESSION['vocivisitacure'] as $row) {
				$riepilogoVociVisitaCure .= "<tr><td>" . $row['codicevocelistino'] . "</td><td>" . $row['descrizionevoce'] . "</td></tr>";
			}
			
			$replace['%riepilogoCure%'] = $riepilogoVociVisitaCure;
			$template = $utility->tailFile($utility->getTemplate($formCure), $replace);
			$replace['%riepilogoCureDiv%'] = $template;
		}
		else {
			$replace['%riepilogoCureTab%'] = "";
			$replace['%riepilogoCureDiv%'] = "";
			$replace['%riepilogoCure%'] = "";
		}
		
		// display della pagina completata ------------------------------------------------------------------------
		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);
	}
	
	public function preparaBottonePreventivo($statoVisita) {

		$bottonePreventivo = "";

		/**
		 * SB 9/2/2015 : lascio la possibilità di preventivare la visita più volte
		 */
//		if ($statoVisita == 'In corso') {

			$bottonePreventivo = "<td>";
			$bottonePreventivo .= "<form class='tooltip' method='post' action='" . $this->getAzione() . "'>";
			$bottonePreventivo .= "<button class='button' title='" . $this->getAzioneTip() . "'>" . $this->getLabelBottone() . "</button>";
			$bottonePreventivo .= "<input type='hidden' name='usa-sessione' value='true'/>";
			$bottonePreventivo .= "</form></td>";
//		}		
		return $bottonePreventivo;
	}
}

?>
