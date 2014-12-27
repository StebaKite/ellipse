<?php

require_once 'visitaPaziente.abstract.class.php';

class riepilogoVociVisita extends visitaPazienteAbstract {

	private static $pagina = "/paziente/visita.dettaglio.form.html";
	private static $vociVisita;	
	private static $dettaglioVisita;
	
	//-----------------------------------------------------------------------------

	function __construct() {
		
		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/paziente:" . self::$root . "/ellipse/src/utility";  
		set_include_path($pathToInclude);		
	}

	// Setters --------------------------------------------------------------------

	public function setVociVisita($vociVisita) {
		self::$vociVisita = $vociVisita;
	}
	public function setDettaglioVisita($dettaglioVisita) {
		self::$dettaglioVisita = $dettaglioVisita;
	}
	
	// Getters --------------------------------------------------------------------

	public function getVociVisita() {
		return self::$vociVisita;
	}
	public function getDettaglioVisita() {
		return self::$dettaglioVisita;
	}
	
	// ----------------------------------------------------------------------------
	
	public function displayPagina() {

		require_once 'database.class.php';
		require_once 'utility.class.php';
		
		// Template --------------------------------------------------------------

		$dettaglioVisita = $this->getDettaglioVisita();

		$utility = new utility();
		$array = $utility->getConfig();

		$form = self::$root . $array['template'] . self::$pagina;

		$rowcounter = 0;
		$riepilogoVociVisita = "";
		
		foreach ($this->getVociVisita() as $row) {

			if ($rowcounter % 2 == 0) $class = "class='on'";
			else $class = "class=''";

			$riepilogoVociVisita .= "<tr " . $class . "><td>" . $row['nomeform'] . "</td><td>" . $row['nomecampoform'] . "</td><td>" . $row['codicevocelistino'] . "</td><td>" . $row['descrizionevoce'] . "</td></tr>";
			++$rowcounter;			
		}	

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
			'%idListino%' => $this->getIdListino(),
			'%riepilogoVociVisita%' => $riepilogoVociVisita
		);

		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);
	}
}

?>
