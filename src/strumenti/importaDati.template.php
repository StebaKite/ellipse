<?php

require_once 'strumenti.abstract.class.php';

class importaTemplate extends strumentiAbstract {

	private static $pagina = "/strumenti/importaDati.form.html";
	public static $messaggi;
	
	public function setMessaggi($messaggi) {
		self::$messaggi = $messaggi;
	}
	
	public function getMessaggi() {
		return self::$messaggi;
	}
	
	
	//-----------------------------------------------------------------------------
	
	function __construct() {
	
		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/strumenti:" . self::$root . "/ellipse/src/utility";
		set_include_path($pathToInclude);
	}
	
	public function displayPagina() {

		error_log("<<<<<<< Display >>>>>>> " . $_SERVER['PHP_SELF']);
		
		require_once 'utility.class.php';
		
		// Template --------------------------------------------------------------
		
		$utility = new utility();
		$array = $utility->getConfig();
		
		$form = self::$root . $array['template'] . self::$pagina;
		
		$messaggi = "<i>" . implode(" ", $this->getMessaggi()) . "</i>";
				
		$replace = array(
			'%titoloPagina%' => $this->getTitoloPagina(),
			'%azione%' => $this->getAzione(),
			'%azioneTip%' => $this->getTestoAzione(),
			'%messaggi%' => $messaggi	
		);
		
		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);		
	}	
}

?>