<?php

require_once 'visitaPaziente.abstract.class.php';

class visitaCure extends visitaPazienteAbstract {
	
	private static $pagina = "/paziente/visita.cure.form.html";
	public static $cureGeneriche;
	
	//-----------------------------------------------------------------------------

	function __construct() {
		
		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/paziente:" . self::$root . "/ellipse/src/utility";  
		set_include_path($pathToInclude);		
	}

	// Setters --------------------------------------------------------------------
	
	public function setCureGeneriche($cureGeneriche) {
		self::$cureGeneriche = $cureGeneriche;
	}
	
	// Getters --------------------------------------------------------------------

	public function getCureGeneriche() {
		return self::$cureGeneriche;
	}

	// template ------------------------------------------------

	public function inizializzaPagina() {

		$vociGeneriche = array();
		
		// primo gruppo --------------------------------------------------------------------------------------------------------------
		
		array_push($vociGeneriche, array('voceGenerica_1', ''));
		array_push($vociGeneriche, array('voceGenerica_2', ''));
		array_push($vociGeneriche, array('voceGenerica_3', ''));
		array_push($vociGeneriche, array('voceGenerica_4', ''));
		array_push($vociGeneriche, array('voceGenerica_5', ''));
		array_push($vociGeneriche, array('voceGenerica_6', ''));

		// restituisce l'array
		
		$this->setCureGeneriche($vociGeneriche);		
	}
	
	public function displayPagina() {

		require_once 'database.class.php';
		require_once 'utility.class.php';
		
		// Template --------------------------------------------------------------

		$visita = $this->getVisitaCure();

		$utility = new utility();
		$array = $utility->getConfig();

		$form = self::$root . $array['template'] . self::$pagina;
		
		$this->setTestata(self::$root . $array['testataPagina']);
		$this->setPiede(self::$root . $array['piedePagina']);
		$this->setMessaggioErrore(self::$root . $array['messaggioErrore']);
		$this->setMessaggioInfo(self::$root . $array['messaggioInfo']);

		$db = new database();

		//-------------------------------------------------------------

		$vociListinoEsteso = "";	// per la tab di aiuto consultazione voci disponibili
		
		$replace = array('%idlistino%' => $this->getIdListino());
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryVociGenericheListinoPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
		
		$rows = pg_fetch_all($result);

		$replace = array(
			'%titoloPagina%' => $this->getTitoloPagina(),
			'%azione%' => $this->getAzione(),
			'%confermaTip%' => $this->getConfermaTip(),
			'%cognomeRicerca%' => $this->getCognomeRicerca(),
			'%idPaziente%' => $this->getIdPaziente(),
			'%idListino%' => $this->getIdListino()
		);

		if ($rows) {
			
			$replace['%vociListinoEsteso%'] = $this->preparaListinoEsteso($rows);

			$vociGeneriche = $this->getCureGeneriche();
			foreach($this->getCureGeneriche() as $row) {
				$replace['%' . $row['0'] . '%'] = $this->preparaComboGruppo($rows, $row['1']);
			}
		}
		else {
			$replaceMsg = array('%messaggio%' => '%ml.noVociGen%');				
			$template = $utility->tailFile($utility->getTemplate($this->getMessaggioErrore()), $replaceMsg);			
			echo $utility->tailTemplate($template);
		}

		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);
	}	
	
	private function preparaComboGruppo($rows, $voceGruppo) {
		
		foreach ($rows as $cod) {
			 
			if (trim($cod['codicevocelistino']) === trim($voceGruppo))
				$vociCombo .= "<option value='" . $cod['codicevocelistino'] . "' selected >" . $cod['descrizionevoce'] . "</option>";
			else
				$vociCombo .= "<option value='" . $cod['codicevocelistino'] . "' >" . $cod['descrizionevoce'] . "</option>";
		}
		return $vociCombo;
	}
	
	private function preparaListinoEsteso($rows) {
		
		foreach ($rows as $cod) {
			$vociListino .= "<tr><td>" . $cod['codicevocelistino'] . "</td><td>" . $cod['descrizionevoce'] . "</td></tr>";			
		}		
		return $vociListino;
	}
}
?>
