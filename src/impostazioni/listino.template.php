<?php

require_once 'impostazioni.abstract.class.php';

class listinoTemplate extends impostazioniAbstract {

	public static $pagina = "/impostazioni/listino.form.html";

	//-----------------------------------------------------------------------------

	function __construct() {

		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/impostazioni:" . self::$root . "/ellipse/src/utility";
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

		$this->setCodiceListino("");
		$this->setDescrizioneListino("");
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
				'%idlistino%' => $this->getIdlistino(),
				'%codicelistino%' => $this->getCodiceListino(),
				'%codicelistinoTip%' => $this->getCodiceListinoTip(),
				'%codicelistinoDisable%' => $this->getCodiceListinoDisable(),
				'%codicelistinoStyle%' => $this->getCodiceListinoStyle(),
				'%descrizionelistino%' => $this->getDescrizioneListino(),
				'%descrizionelistinoTip%' => $this->getDescrizioneListinoTip(),
				'%descrizionelistinoDisable%' => $this->getDescrizioneListinoDisable(),
				'%descrizionelistinoStyle%' => $this->getDescrizioneListinoStyle()
		);
	
		$utility = new utility();
	
		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);
	}	
}

?>