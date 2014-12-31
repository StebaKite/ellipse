<?php

class menubannerTemplate {

	private static $root;
	private static $pagina = "/main/menubanner.form.html";
	public static $totaliProgressivi;
		
	// Setters --------------------------------------------------------------------
	
	public function setTotaliProgressivi($totaliProgressivi) {
		self::$totaliProgressivi = $totaliProgressivi;
	}
	
	// Getters --------------------------------------------------------------------

	public function getTotaliProgressivi() {
		return self::$totaliProgressivi;
	}
	
	function __construct() {
		
		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/paziente:" . self::$root . "/ellipse/src/utility";  
		set_include_path($pathToInclude);		
	}

	public function displayPagina() {

		require_once 'database.class.php';
		require_once 'utility.class.php';

		$tabellaTotali = "";
		
		// Template --------------------------------------------------------------

		$utility = new utility();
		$array = $utility->getConfig();

		$form = self::$root . $array['template'] . self::$pagina;

		$utility = new utility();
		
		if ($this->getTotaliProgressivi() != "") {
			
			$tabellaTotali .= "<table class='result' id='resultTable'>";
			$tabellaTotali .= "<thead><th>%ml.oggetto%</th><th>%ml.totale%</th></thead><tbody>";
			
			foreach($this->getTotaliProgressivi() as $row) {
				$tabellaTotali .= "<tr class='on'> <td width='150'>" . $row['entita'] . "</td><td width='50' align='right'>" . $row['totale'] . "</td></tr>";
			}
			
			$tabellaTotali .= "</tbody></table>";			
		}

		$replace = array('%tabellaTotali%' => $tabellaTotali);

		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);
	}	
}

?>
