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
		
		$replace = array(
				'%titoloPagina%' => $this->getTitoloPagina(),
				'%azione%' => $this->getAzione(),
				'%cognome%' => $this->getCognome(),
				'%nome%' => $this->getNome(),
				'%datanascita%' => $this->getDataNascita(),
				'%datainserimento%' => $this->getDataInserimento(),
				'%stato%' => $this->getStato(),
				'%dente%' => $this->getDente(),
				'%tabella%' => $this->getTabella(),
				'%testoAzione%' => $this->getTestoAzione(),
				'%idvocepreventivo%' => $this->getIdvocePreventivo(),
				'%idvocesottopreventivo%' => $this->getIdvoceSottoPreventivo(),
				'%cognomeRicerca%' => $this->getCognomeRicerca(),
				'%idPaziente%' => $this->getIdPaziente(),
				'%idListino%' => $this->getIdListino(),
				'%idPreventivo%' => $this->getIdPreventivo(),
				'%idPreventivoPrincipale%' => $this->getIdPreventivoPrincipale(),
				'%idSottoPreventivo%' => $this->getIdSottoPreventivo(),
				'%codicevoce%' => $this->getCodiceVoce(),
				'%descrizionevoce%' => $this->getDescrizioneVoce(),
				'%descrizionevocelistino%' => $this->getDescrizioneVoceListino(),
				'%descrizionevoceTip%' => $this->getTipDescrizioneVoce(),
				'%descrizionevoceStyle%' => $this->getStyleDescrizioneVoce(),
				'%prezzo%' => $this->getPrezzo(),
				'%prezzoTip%' => $this->getTipPrezzo(),
				'%prezzoStyle%' => $this->getStylePrezzo()
		);

		if ($this->getStato() == '00') $replace['%stato%'] = '%ml.proposto%';
		if ($this->getStato() == '01') $replace['%stato%'] = '%ml.accettato%';
		if ($this->getStato() == '02') $replace['%stato%'] = '%ml.parzialmenteaccettato%';
		if ($this->getStato() == '03') $replace['%stato%'] = '%ml.splittato%';
		
		$utility = new utility();
		
		$template = $utility->tailFile($utility->getTemplate($form), $replace);
		echo $utility->tailTemplate($template);
	}
}
		
?>