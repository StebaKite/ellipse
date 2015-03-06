<?php

class firewall {
	
	public static $root;
	
	function __construct() {
		self::$root = $_SERVER['DOCUMENT_ROOT'];
	}
	

	public function controlloCampiRichiesta($data) {
	
		require_once 'utility.class.php';
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		if ($array['firewall'] != "") {
			$firewallFile = self::$root . $array['firewall'];
	
			if (file_exists($firewallFile)) {
				// viene ritornata una mappa
				error_log("Firewall application file " . $firewallFile . " loaded...");
				$firewallMap = parse_ini_file($firewallFile);
			}
			else {
				error_log("Firewall application file " . $firewallFile . " not found!");
				$firewallMap = "";
			}
		}
		else return FALSE;
				
		/**		
		 * Applico il firewall sui campi della request
		 */
	
		foreach ($data as $elemento) {
				
			$tag = explode(';',$elemento);
			$nomeCampo = $tag[0];
			$valoreCampo = $tag[1];				
			
			$patternCampo = '/' . $firewallMap[$nomeCampo] . '$/';

 			if (preg_match_all($patternCampo, $valoreCampo) == 0) {
 				error_log("ATTENZIONE, parametro in ingresso non corretto : parm=" . $nomeCampo . " - valore=" . $valoreCampo . " - pattern=" . $patternCampo);
 				return FALSE;
 			}
		}
		return TRUE;
	}
}

?>