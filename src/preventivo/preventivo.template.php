<?php

require_once 'preventivo.abstract.class.php';

class preventivoTemplate extends preventivoAbstract {

	private static $pagina = "/preventivo/preventivo.form.html";


	//-----------------------------------------------------------------------------

	function __construct() {
		self::$root = $_SERVER['DOCUMENT_ROOT'];
	}

	// template ------------------------------------------------
	
	public function controlliLogici() {
	
		require_once 'database.class.php';
		require_once 'utility.class.php';

		$esito = TRUE;
		
		// Template --------------------------------------------------------------
		
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
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryVociPreventivoDentiSingoliPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
	
		$vociInserite = pg_fetch_all($result);
	
		$impostazioniVoci = "";
	
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
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		$form = self::$root . $array['template'] . self::$pagina;
	
		$db = new database();
		$db->beginTransaction();
		//-------------------------------------------------------------
	
		$vociListinoEsteso = "";
		$replace = array('%idlistino%' => $this->getIdListino());
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryVociListinoPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		$rows = pg_fetch_all($result);
	
		$x = 0;
	
		foreach ($rows as $cod) {
	
			if ($x == 0) {
				$vociListinoEsteso .= "<tr>";
			}
			$vociListinoEsteso .= "<td><input type='checkbox' value='" . trim($cod['codicevocelistino']) . "' onchange='addEle(this)'/></td><td width='30' class='tooltip' title='" . trim($cod['descrizionevoce']) . "'>" . trim($cod['codicevocelistino']) . "</td>";
			$x++;
				
			if ($x == 5) {
				$vociListinoEsteso .= "</tr>";
				$x = 0;
			}
		}
	
		//-------------------------------------------------------------
	
		$tabsCategorie = "";
		$divCategorie = "";
	
		$replace = array('%idlistino%' => $this->getIdListino());
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryCategorieVociListinoPaziente;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
		$rows = pg_fetch_all($result);
	
		foreach ($rows as $cat) {
				
			$tabsCategorie .= "<li class='tooltip'><a title='" . trim($cat['descrizionecategoria']) . "' href='#" . trim($cat['codicecategoria']) . "'>" . trim($cat['codicecategoria']) . "</a></li>";
	
			$replace = array(
					'%codicecategoria%' => trim($cat['codicecategoria']),
					'%idlistino%' => $this->getIdListino()
			);
				
			$sqlTemplate = self::$root . $array['query'] . self::$queryVociListinoCategoriaPaziente;
			$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
			$resultVoci = $db->execSql($sql);
			$rowsvoci = pg_fetch_all($resultVoci);
	
			$x = 0;
			$vociListinoCategoria = "";
				
			$divCategorie .= "<div id='" . trim($cat['codicecategoria']) . "'><table class='result-alt' id='resultTable'><tbody>";
				
			foreach ($rowsvoci as $voci) {
	
				if ($x == 0) {
					$vociListinoCategoria .= "<tr>";
				}
				$vociListinoCategoria .= "<td><input type='checkbox' value='" . trim($voci['codicevocelistino']) . "' onchange='addEle(this)'/></td><td width='30' class='tooltip' title='" . trim($voci['descrizionevoce']) . "'>" . trim($voci['codicevocelistino']) . "</td>";
				$x++;
					
				if ($x == 4) {
					$vociListinoCategoria .= "</tr>";
					$x = 0;
				}
	
			}
				
			$divCategorie .= $vociListinoCategoria . "</tbody></table></div>";
		}
	
		$db->commitTransaction();
	
		$replace = array(
				'%titoloPagina%' => $this->getTitoloPagina(),
				'%preventivo%' => $this->getPreventivoLabel(),
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
				'%idPreventivo%' => $this->getIdPreventivo(),
				'%vociListinoEsteso%' => $vociListinoEsteso,
				'%tabsCategorie%' => $tabsCategorie,
				'%divCategorie%' =>	$divCategorie,
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