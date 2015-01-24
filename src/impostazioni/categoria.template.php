<?php

require_once 'impostazioni.abstract.class.php';

class categoriaTemplate extends impostazioniAbstract {

	public static $pagina = "/impostazioni/categoria.form.html";

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

		$this->setCodiceCategoria("");
		$this->setDescrizioneCategoria("");
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
				'%codicecategoriaTip%' => $this->getCodiceCategoriaTip(),
				'%codicecategoriaDisable%' => $this->getCodiceCategoriaDisable(),
				'%codicecategoriaStyle%' => $this->getCodiceCategoriaStyle(),
				'%descrizionecategoria%' => $this->getDescrizioneCategoria(),
				'%descrizionecategoriaTip%' => $this->getDescrizioneCategoriaTip(),
				'%descrizionecategoriaDisable%' => $this->getDescrizioneCategoriaDisable(),
				'%descrizionecategoriaStyle%' => $this->getDescrizioneCategoriaStyle()
		);
	
		$utility = new utility();
	
		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);	
	}	
}	
	
?>