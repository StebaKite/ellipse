<?php

require_once 'impostazioni.abstract.class.php';

class voceListinoTemplate extends impostazioniAbstract {

	public static $pagina = "/impostazioni/vocelistino.form.html";

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
	
		$this->setPrezzo("");
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
				'%descrizionelistino%' => $this->getDescrizioneListino(),
				'%idvocelistino%' => $this->getIdvoceListino(),			
				'%codicevoce%' => $this->getCodiceVoce(),
				'%codicevoceTip%' => '',
				'%codicevoceDisable%' => 'disabled',
				'%descrizionevoce%' => $this->getDescrizioneVoce(),
				'%descrizionevoceTip%' => '',
				'%descrizionevoceDisable%' => 'disabled',
				'%prezzo%' => $this->getPrezzo(),
				'%prezzoTip%' => $this->getPrezzoTip(),
				'%prezzoDisable%' => $this->getPrezzoDisable(),
				'%prezzoStyle%' => $this->getPrezzoStyle()
		);
	
		$utility = new utility();
	
		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);
	}
}	
	
?>