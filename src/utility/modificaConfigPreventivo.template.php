<?php

class configPreventivoTemplate extends configAbstract {

	private static $pagina = "/preferenze/configPreventivo.form.html";

	//-----------------------------------------------------------------------------

	function __construct() {

		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/paziente:" . self::$root . "/ellipse/src/utility";
		set_include_path($pathToInclude);
	}
	
	public function inizializzaPagina() {}
	
	
	public function controlliLogici() {
	
		$esito = TRUE;
	
		
		
		
		

		return $esito;
	}
		
	public function displayPagina() {
	
		require_once 'utility.class.php';
	
		// Template --------------------------------------------------------------
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$form = self::$root . $array['template'] . self::$pagina;
	
		//-------------------------------------------------------------
	
		$replace = array(
			'%titoloPagina%' => $this->getTitoloPagina(),
			'%azione%' => $this->getAzione(),
			'%validitagiornipreventivo%' => $this->getValiditaGiorniPreventivo(),
			'%validitagiornipreventivoTip%' => $this->getTipValiditaGiorniPreventivo(),
			'%preventivoRiassuntivoSi%' => $this->getPreventivoRiassuntivoSi(),
			'%preventivoRiassuntivoNo%' => $this->getPreventivoRiassuntivoNo(),
			'%sezioneIntestazioneSi%' => $this->getSezioneIntestazioneSi(),
			'%sezioneIntestazioneNo%' => $this->getSezioneIntestazioneNo(),
			'%sezioneDatiAnagraficiPazienteSi%' => $this->getSezioneDatiAnagraficiPazienteSi(),
			'%sezioneDatiAnagraficiPazienteNo%' => $this->getSezioneDatiAnagraficiPazienteNo(),
			'%sezioneNotaValiditaSi%' => $this->getSezioneNotaValiditaSi(),
			'%sezioneNotaValiditaNo%' => $this->getSezioneNotaValiditaNo(),
			'%sezioneFirmaAccettazioneSi%' => $this->getSezioneFirmaAccettazioneSi(),
			'%sezioneFirmaAccettazioneNo%' => $this->getSezioneFirmaAccettazioneNo(),
			'%sezionePianoPagamentoSi%' => $this->getSezionePianoPagamentoSi(),
			'%sezionePianoPagamentoNo%' => $this->getSezionePianoPagamentoNo(),
			'%sezioneAnnotazioniSi%' => $this->getSezioneAnnotazioniSi(),
			'%sezioneAnnotazioniNo%' => $this->getSezioneAnnotazioniNo(),
			'%sezioneAnnotazioniVociSi%' => $this->getSezioneAnnotazioniVociSi(),
			'%sezioneAnnotazioniVociNo%' => $this->getSezioneAnnotazioniVociNo(),
			'%nota1validita%' => $this->getNota1Validita(),
			'%nota2validita%' => $this->getNota2Validita(),
		);
		
		$utility = new utility();
		
		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);
	}
}
	
?>