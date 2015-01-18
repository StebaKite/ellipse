<?php

require_once 'impostazioni.abstract.class.php';

class voceTemplate extends impostazioniAbstract {

	public static $pagina = "/impostazioni/voce.form.html";

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

		$this->setCodiceVoce("");
		$this->setDescrizioneVoce("");
		$this->setPrezzo("");
		$this->setTipoVoce("");
		$this->setTipoVoceStandard("checked");		
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
				'%idcategoria%' => $this->getIdcategoria(),
				'%codicecategoria%' => $this->getCodiceCategoria(),
				'%descrizionecategoria%' => $this->getDescrizioneCategoria(),
				'%idvoce%' => $this->getIdvoce(),
				'%codicevoce%' => $this->getCodiceVoce(),
				'%codicevoceTip%' => $this->getCodiceVoceTip(),
				'%codicevoceDisable%' => $this->getCodiceVoceDisable(),
				'%codicevoceStyle%' => $this->getCodiceVoceStyle(),
				'%descrizionevoce%' => $this->getDescrizioneVoce(),
				'%descrizionevoceTip%' => $this->getDescrizioneVoceTip(),
				'%descrizionevoceDisable%' => $this->getDescrizioneVoceDisable(),
				'%descrizionevoceStyle%' => $this->getDescrizioneVoceStyle(),
				'%prezzo%' => $this->getPrezzo(),
				'%prezzoTip%' => $this->getPrezzoTip(),
				'%prezzoDisable%' => $this->getPrezzoDisable(),
				'%prezzoStyle%' => $this->getPrezzoStyle(),
				'%tipovoceStandardChecked%' => $this->getTipoVoceStandard(),
				'%tipovoceGenericaChecked%' => $this->getTipoVoceGenerica()
		);
	
		$utility = new utility();
	
		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);
	}
}
	
?>