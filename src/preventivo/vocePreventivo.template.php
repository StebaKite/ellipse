<?php

require_once 'preventivo.abstract.class.php';

class vocePreventivoTemplate extends preventivoAbstract {

	public static $pagina = "/preventivo/vocePreventivo.form.html";

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

		$this->setCodiceVoce("");
		$this->setDescrizioneVoce("");
		$this->setPrezzo("");
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

		if ($_SESSION['idPreventivo'] != "") $idPreventivo = $_SESSION['idPreventivo'];
		elseif ($_SESSION['idSottoPreventivo'] != "") $idPreventivo = $_SESSION['idSottoPreventivo'];
		
		$replace = array(
				'%titoloPagina%' => $this->getTitoloPagina(),
				'%azione%' => $this->getAzione(),
				'%cognome%' => $_SESSION['cognome'],
				'%nome%' => $_SESSION['nome'],
				'%datanascita%' => $_SESSION['datanascita'],
				'%datainserimento%' => $_SESSION['dataInserimento'],
				'%stato%' => $_SESSION['stato'],
				'%dente%' => $_SESSION['dente'],
				'%tabella%' => $_SESSION['tabella'],
				'%testoAzione%' => $this->getTestoAzione(),				
				'%idvocepreventivo%' => $_SESSION['idvocePreventivo'],
				'%idvocesottopreventivo%' => $_SESSION['IdvoceSottoPreventivo'],
				'%idPreventivo%' => $idPreventivo,				
				'%codicevoce%' => $this->getCodiceVoce(),
				'%descrizionevoce%' => $this->getDescrizioneVoce(),
				'%descrizionevocelistino%' => $this->getDescrizioneVoceListino(),
				'%descrizionevoceTip%' => $this->getTipDescrizioneVoce(),
				'%descrizionevoceStyle%' => $this->getStyleDescrizioneVoce(),
				'%prezzo%' => $this->getPrezzo(),
				'%prezzoTip%' => $this->getTipPrezzo(),
				'%prezzoStyle%' => $this->getStylePrezzo()
		);

		if ($_SESSION['stato'] == '00') $replace['%stato%'] = '%ml.proposto%';
		if ($_SESSION['stato'] == '01') $replace['%stato%'] = '%ml.accettato%';
		if ($_SESSION['stato'] == '02') $replace['%stato%'] = '%ml.parzialmenteaccettato%';
		if ($_SESSION['stato'] == '03') $replace['%stato%'] = '%ml.splittato%';
		
		$utility = new utility();
		
		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);
	}
}
		
?>