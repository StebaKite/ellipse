<?php

require_once 'visitaPaziente.abstract.class.php';

class riepilogoVociVisita extends visitaPazienteAbstract {

	private static $pagina = "/paziente/visita.dettaglio.form.html";
	private static $paginaSingoli = "/paziente/visita.dettagliosingoli.form.html";
	private static $paginaGruppi = "/paziente/visita.dettagliogruppi.form.html";
	private static $paginaCure = "/paziente/visita.dettagliocure.form.html";
	public static $vociVisitaDentiSingoli;	
	public static $vociVisitaGruppi;	
	public static $vociVisitaCureTab;	
	public static $vociVisitaCure;	
	public static $dettaglioVisita;
	
	//-----------------------------------------------------------------------------

	function __construct() {
		
		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/paziente:" . self::$root . "/ellipse/src/utility";  
		set_include_path($pathToInclude);		
	}

	// Setters --------------------------------------------------------------------

	public function setVociVisitaDentiSingoli($vociVisitaDentiSingoli) {
		self::$vociVisitaDentiSingoli = $vociVisitaDentiSingoli;
	}
	public function setVociVisitaGruppi($vociVisitaGruppi) {
		self::$vociVisitaGruppi = $vociVisitaGruppi;
	}
	public function setVociVisitaCure($vociVisitaCure) {
		self::$vociVisitaCure = $vociVisitaCure;
	}
	public function setDettaglioVisita($dettaglioVisita) {
		self::$dettaglioVisita = $dettaglioVisita;
	}
	
	// Getters --------------------------------------------------------------------

	public function getVociVisitaDentiSingoli() {
		return self::$vociVisitaDentiSingoli;
	}
	public function getVociVisitaGruppi() {
		return self::$vociVisitaGruppi;
	}
	public function getVociVisitaCure() {
		return self::$vociVisitaCure;
	}
	public function getDettaglioVisita() {
		return self::$dettaglioVisita;
	}
	
	// ----------------------------------------------------------------------------
	
	public function displayPagina() {

		require_once 'database.class.php';
		require_once 'utility.class.php';
		
		// Template --------------------------------------------------------------

//		$dettaglioVisita = $this->getDettaglioVisita();

		$utility = new utility();
		$array = $utility->getConfig();

		$form = self::$root . $array['template'] . self::$pagina;
		$formSingoli = self::$root . $array['template'] . self::$paginaSingoli;
		$formGruppi = self::$root . $array['template'] . self::$paginaGruppi;
		$formCure = self::$root . $array['template'] . self::$paginaCure;

		$rowcounter = 0;

		$replace = array(
			'%titoloPagina%' => $this->getTitoloPagina(),
			'%azione%' => $this->getAzione(),
			'%confermaTip%' => $this->getConfermaTip(),
			'%cognomeRicerca%' => $this->getCognomeRicerca(),
			'%cognome%' => $this->getCognome(),
			'%nome%' => $this->getNome(),
			'%datanascita%' => $this->getDataNascita(),
			'%idvisita%' => $this->getIdVisita(),
			'%datainserimento%' => $this->getDataInserimento(),
			'%stato%' => $this->getStato(),
			'%idPaziente%' => $this->getIdPaziente(),
			'%idListino%' => $this->getIdListino()
		);

		// Preparo la tab per le voci riferite ai denti singoli -----------------------------------------------------
		
		if ($this->getVociVisitaDentiSingoli()) {	

			$riepilogoVociVisitaDentiSingoli = "";
			$replace['%riepilogoDentiSingoliTab%'] = "<li><a href='#tabs-1'>%ml.dentiSingoli%</a></li>"; 
			
			foreach ($this->getVociVisitaDentiSingoli() as $row) {

				if ($rowcounter % 2 == 0) $class = "class='on'";
				else $class = "class=''";

				$riepilogoVociVisitaDentiSingoli .= "<tr " . $class . "><td>" . $row['nomeform'] . "</td><td>" . $row['nomecampoform'] . "</td><td>" . $row['codicevocelistino'] . "</td><td>" . $row['descrizionevoce'] . "</td></tr>";
				++$rowcounter;			
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
		
		if ($this->getVociVisitaGruppi()) {	

			$riepilogoVociVisitaGruppi = "";
			$replace['%riepilogoGruppiTab%'] = "<li><a href='#tabs-2'>%ml.gruppi%</a></li>"; 
			
			foreach ($this->getVociVisitaGruppi() as $row) {

				if ($rowcounter % 2 == 0) $class = "class='on'";
				else $class = "class=''";

				$riepilogoVociVisitaGruppi .= "<tr " . $class . "><td>" . $row['nomeform'] . "</td><td>" . $row['nomecampoform'] . "</td><td>" . $row['codicevocelistino'] . "</td><td>" . $row['descrizionevoce'] . "</td></tr>";
				++$rowcounter;			
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

		// Preparo la tab per le voci riferite ai gruppi di denti --------------------------------------------------
		
		if ($this->getVociVisitaCure()) {	

			$riepilogoVociVisitaCure = "";
			$replace['%riepilogoCureTab%'] = "<li><a href='#tabs-3'>%ml.cure%</a></li>"; 
			
			foreach ($this->getVociVisitaCure() as $row) {

				if ($rowcounter % 2 == 0) $class = "class='on'";
				else $class = "class=''";

				$riepilogoVociVisitaCure .= "<tr " . $class . "><td>" . $row['nomeform'] . "</td><td>" . $row['nomecampoform'] . "</td><td>" . $row['codicevocelistino'] . "</td><td>" . $row['descrizionevoce'] . "</td></tr>";
				++$rowcounter;			
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
}

?>
