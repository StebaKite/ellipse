<?php

require_once 'strumenti.abstract.class.php';

class creaConfigurazioneTemplate extends strumentiAbstract {

	public static $pagina = "/strumenti/configurazione.form.html";
	
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
		
		$this->setProgressivo("");
		$this->setClasse("");
		$this->setFilepath("");
		$this->setStatoDaeseguire("checked");
		
		
		
		
	}
	
	public function controlliLogici() {

		$esito = TRUE;
		
		return $esito;
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
			'%statoDaeseguireChecked%' => $this->getStatoDaeseguire(),
			'%progressivo%' => $this->getProgressivo(),		
			'%classe%' => $this->getClasse(),
			'%filepath%' => $this->getFilepath(),
			'%progressivoTip%' => $this->getProgressivoTip(),
			'%classeTip%' => $this->getClasseTip(),
			'%filepathTip%' => $this->getFilepathTip()	
		);

		$utility = new utility();
		
		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);
		
	}	
}	
	
?>