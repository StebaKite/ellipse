<?php

require_once 'preventivo.abstract.class.php';

class notaPreventivoTemplate extends preventivoAbstract {

	public static $pagina = "/preventivo/notaPreventivo.form.html";

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
	
		unset($_SESSION['notapreventivo']);
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
		$idPreventivo = ($_SESSION['idPreventivo'] != '') ? $_SESSION['idPreventivo'] : $_SESSION['idSottoPreventivo']; 
		
		$replace = array(
				'%titoloPagina%' => $this->getTitoloPagina(),
				'%azione%' => $this->getAzione(),
				'%testoAzione%' => $this->getTestoAzione(),
				'%cognome%' => $_SESSION['cognome'],
				'%nome%' => $_SESSION['nome'],
				'%datanascita%' => $_SESSION['datanascita'],
				'%idPreventivo%' => $idPreventivo,	
				'%notapreventivo%' => $_SESSION['notapreventivo'],
				'%notareadonly%' => $_SESSION['readonly']
		);
	
		$utility = new utility();	
		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);
	}
}

?>