<?php

class config {
	
	private static $root;
	private static $pagina = "/preferenze/config.form.html";
	
	private static $azione;
	private static $titoloPagina;
	private static $messaggio;	
	private static $modificaConfig;

	private static $hostname;
	private static $portnum;



	//-----------------------------------------------------------------------------

	function __construct() {
		
		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/paziente:" . self::$root . "/ellipse/src/utility";  
		set_include_path($pathToInclude);		
	}

	//-----------------------------------------------------------------------------
	// Setters --------------------------------------------------------------------
	
	public function setAzione($azione) {
		self::$azione = $azione;
	}
	public function setTitoloPagina($titoloPagina) {
		self::$titoloPagina = $titoloPagina;
	}
	public function setMessaggio($messaggio) {
		self::$messaggio = $messaggio;
	}
	public function setModificaConfig($modificaConfig) {
		self::$modificaConfig = $modificaConfig;
	}
	




	
	// ----------------------------------------------------------------------------
	// Getters --------------------------------------------------------------------

	public function getAzione() {
		return self::$azione;
	}
	public function getTitoloPagina() {
		return self::$titoloPagina;
	}
	public function getMessaggio() {
		return self::$messaggio;
	}
	public function getModificaConfig() {
		return self::$modificaConfig;
	}





	// template ------------------------------------------------

	public function inizializzaPagina() {

	}	


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
			'%azione%' => $this->getAzione()
		);

		$utility = new utility();

		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);		
	}	
}

?>
