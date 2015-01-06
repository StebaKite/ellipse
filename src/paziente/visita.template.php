<?php

require_once 'visitaPaziente.abstract.class.php';

class visita extends visitaPazienteAbstract {
	
	private static $pagina = "/paziente/visita.form.html";
	
	private static $dentiSingoli;	
	private static $impostazioniVoci;
	
	//-----------------------------------------------------------------------------

	function __construct() {
		
		self::$root = $_SERVER['DOCUMENT_ROOT'];
		$pathToInclude = self::$root . "/ellipse/src/paziente:" . self::$root . "/ellipse/src/utility";  
		set_include_path($pathToInclude);		
	}

	// Setters --------------------------------------------------------------------
	
	public function setDentiSingoli($dentiSingoli) {
		self::$dentiSingoli = $dentiSingoli;
	}
	public function setImpostazioniVoci($impostazioniVoci) {
		self::$impostazioniVoci = $impostazioniVoci;
	}
	
	// Getters --------------------------------------------------------------------

	public function getDentiSingoli() {
		return self::$dentiSingoli;
	}
	public function getImpostazioniVoci() {
		return self::$impostazioniVoci;
	}

	// template ------------------------------------------------

	public function controlliLogici() {
		
		require_once 'database.class.php';
		require_once 'utility.class.php';

		$esito = TRUE;
		
		// Template --------------------------------------------------------------

		$visita = $this->getVisita();

		$utility = new utility();
		$db = new database();

		//-------------------------------------------------------------
		$array = $utility->getConfig();

		$replace = array('%idlistino%' => $this->getIdListino());
		error_log("Carica le voci del listino : " . $this->getIdListino());
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryVociListinoPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
		
		$vociValide[] = "";
		
		while ($row = pg_fetch_row($result)) {			
			$vociValide[trim($row[0])] = trim($row[0]);
		}

		// controllo esistenza delle voci immesse in pagina
		// alla prima voce non esistente termina il controllo con un errore

		$dentiSingoli = $this->getDentiSingoli();
		$numElePagina = sizeof($dentiSingoli);
		error_log("Elementi in pagina : " . $numElePagina);
		
		for ($i = 0; $i < $numElePagina; $i++) {
		
			if ($dentiSingoli[$i][1] != "") {

				error_log("Cerco voce immessa : " . trim($dentiSingoli[$i][1]));
				
				if (array_key_exists(trim($dentiSingoli[$i][1]), $vociValide)) {
					error_log("Voce " . trim($dentiSingoli[$i][1]) . " ok");
				}
				else {
					$esito = FALSE;
					error_log("Voce " . trim($dentiSingoli[$i][1]) . " non valida");
					break;
				}			
			}
		}		
		return $esito;
	}
	
	public function impostaVoci() {

		require_once 'database.class.php';
		require_once 'utility.class.php';

		$utility = new utility();
		$array = $utility->getConfig();

		$db = new database();
		$replace = array(
			'%idpaziente%' => $this->getIdPaziente(),
			'%idvisita%' => $this->getIdVisita()
		);
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryVociVisitaDentiSingoliPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
		
		$vociInserite = pg_fetch_all($result);
	
		$impostazioniVoci = "";


		//  document.getElementById(cella).innerHTML = inp;
		//  str2 = "<input style='border-color: #ffffff; color: #";
		//  str2 = str2.concat(color, "; text-align: center;' type='text' maxlength='3' size='2' name='");

		//	str3 = "<input type='hidden' name='campiValorizzati' id='campiValorizzati' value='";
		//	var inpHidden = str3.concat(campiImpostati,"'/>");
		//	document.getElementById("campimpostati").innerHTML = inpHidden;


		$dentiDecidui = array("51","52","53","54","55","61","62","63","64","65","71","72","73","74","75","81","82","83","84","85");
		$campiImpostati = "";

		foreach ($vociInserite as $voce) {

			$name = trim($voce['nomecampoform']);
			$value = trim($voce['codicevocelistino']);
			$campiImpostati .= $name . ",";
	
			$dente = split("_", $name);

			if (in_array($dente[1], $dentiDecidui)) 
				$color = "f6a828";
			else
				$color = "3399ff";

			$taginput = "<input style='border-color: #ffffff; color: #" . $color . "; text-align: center;' type='text' maxlength='3' size='2' name='" . $name . "' value='" . $value . "'/>";
			$impostazioniVoci .= '$("#' . $name . '").html("' . $taginput . '"); ';
		}

		$inpHidden = "<input type='hidden' name='campiValorizzati' size='150' id='campiValorizzati' value='" . $campiImpostati . "'/>";	
		$impostazioniVoci .= '$("#campimpostati").html("' . $inpHidden . '");';


		$this->setImpostazioniVoci($impostazioniVoci);
		error_log("Voci inserite caricate in pagina");
		error_log("Listino: " . $this->getIdListino());
	}
	
	public function displayPagina() {

		require_once 'database.class.php';
		require_once 'utility.class.php';
		
		// Template --------------------------------------------------------------

		$visita = $this->getVisita();

		$utility = new utility();
		$array = $utility->getConfig();

		$form = self::$root . $array['template'] . self::$pagina;

		$db = new database();

		//-------------------------------------------------------------

		$vociListino = "";
		$vociListinoEsteso = "";	// per la tab di aiuto consultazione voci disponibili
		
		$replace = array('%idlistino%' => $this->getIdListino());
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryVociListinoPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
		
		$rows = pg_fetch_all($result);

		$x = 0;
		
		foreach ($rows as $cod) {
			$vociListino .= '"' . $cod['codicevocelistino'] . '",';

			if ($x == 0) {
				$vociListinoEsteso .= "<tr>";
			}
			$vociListinoEsteso .= "<td><input type='checkbox' value='" . $cod['codicevocelistino'] . "' onchange='addEle(this)'/></td><td width='30' class='tooltip' title='" . $cod['descrizionevoce'] . "'>" . $cod['codicevocelistino'] . "</td>";
			$x++;
			
			if ($x == 5) {
				$vociListinoEsteso .= "</tr>";
				$x = 0;
			}
		}	

		$replace = array(
			'%titoloPagina%' => $this->getTitoloPagina(),
			'%visita%' => $this->getVisitaLabel(),
			'%cognome%' => $this->getCognome(),
			'%nome%' => $this->getNome(),
			'%datanascita%' => $this->getDataNascita(),
			'%azioneDentiSingoli%' => $this->getAzioneDentiSingoli(),
			'%azioneGruppi%' => $this->getAzioneGruppi(),
			'%azioneCure%' => $this->getAzioneCure(),
			'%confermaTip%' => $this->getConfermaTip(),
			'%gruppiTip%' => $this->getGruppiTip(),
			'%cureTip%' => $this->getCureTip(),
			'%cognomeRicerca%' => $this->getCognomeRicerca(),
			'%idPaziente%' => $this->getIdPaziente(),
			'%idListino%' => $this->getIdListino(),
			'%idVisita%' => $this->getIdVisita(),
			'%vociListino%' => $vociListino,
			'%vociListinoEsteso%' => $vociListinoEsteso,
			'%impostazioniVoci%' => $this->getImpostazioniVoci()
		);

		// prepara form denti singoli -----------------------------
	
		$dentiSingoli = $this->getDentiSingoli();

		foreach ($dentiSingoli as $singoli) {
			$chiave = '%' . $singoli[0] . '%';
			$valore = $singoli[1];
			$replace[$chiave] = $valore;
		}

		$utility = new utility();

		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);
	}		
}	

?>
