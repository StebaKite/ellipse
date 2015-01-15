<?php

require_once 'strumenti.abstract.class.php';

class regolaConfigurazioneTemplate extends strumentiAbstract {

	public static $pagina = "/strumenti/regolaConfigurazione.form.html";

	//-----------------------------------------------------------------------------

	function __construct() {

		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/paziente:" . self::$root . "/ellipse/src/utility";
		set_include_path($pathToInclude);

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
	
		$this->setColonna("");
		$this->setPosizioneValore("");
	}

	public function controlliLogici() {
	
		return TRUE;
	}

	public function displayPagina() {
	
		// Template --------------------------------------------------------------
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$form = self::$root . $array['template'] . self::$pagina;
	
		$replace = array(
				'%titoloPagina%' => $this->getTitoloPagina(),
				'%azione%' => $this->getAzione(),
				'%testoAzione%' => $this->getTestoAzione(),
				'%idguida%' => $this->getIdguida(),
				'%iddettaglioguida%' => $this->getIddettaglioguida(),
				'%colonna%' => $this->getColonna(),
				'%colonnaTip%' => $this->getColonnaTip(),
				'%colonnaDisable%' => $this->getColonnaDisable(),
				'%posizionevalore%' => $this->getPosizioneValore(),
				'%posizionevaloreTip%' => $this->getPosizioneValoreTip(),
				'%idguida%' => $this->getIdguida(),
				'%progressivo%' => $this->getProgressivo(),
				'%classe%' => $this->getClasse(),
				'%filepath%' => $this->getFilepath(),
				'%stato%' => $this->getStato()
		);
	
		$utility = new utility();
	
		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);	
	}
}	
	
?>