<?php

require_once 'config.abstract.class.php';

class modificaConfigPreventivo extends configAbstract {

	public static $azione = "../utility/modificaConfigPreventivoFacade.class.php?modo=go";
	public static $configFile = "/ellipse/config/ellipse.config.ini";

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
	
	public function start() {
	
		require_once 'modificaConfigPreventivo.template.php';
	
		$configPreventivoTemplate = new configPreventivoTemplate();
		$this->preparaPaginaStart($configPreventivoTemplate);

		include(self::$testata);
		$configPreventivoTemplate->inizializzaPagina();
		$configPreventivoTemplate->displayPagina();
		include(self::$piede);
	}


	public function go() {
	
		require_once 'utility.class.php';
		require_once 'modificaConfigPreventivo.template.php';
		
		$utility = new utility();
		
		$configPreventivoTemplate = new configPreventivoTemplate();
		$this->preparaPaginaGo($configPreventivoTemplate);

		include(self::$testata);
		$configPreventivoTemplate->inizializzaPagina();
		
		// Fa il controllo dei dati immessi e modifica il file
		
		if ($configPreventivoTemplate->controlliLogici()) {
		
			if ($this->modifica($configPreventivoTemplate)) {
				$configPreventivoTemplate->displayPagina();
				$replace = array('%messaggio%' => '%ml.modConfigOk%');
				$template = $utility->tailFile($utility->getTemplate(self::$messaggioInfo), $replace);
				echo $utility->tailTemplate($template);
			} else {
				$configPreventivoTemplate->displayPagina();
				$replace = array('%messaggio%' => '%ml.modConfigKo%');
				$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
				echo $utility->tailTemplate($template);
			}
		} else {
			$configPreventivoTemplate->displayPagina();
			$replace = array('%messaggio%' => '%ml.modConfigKo%');
			$template = $utility->tailFile($utility->getTemplate(self::$messaggioErrore), $replace);
			echo $utility->tailTemplate($template);
		}
		
		include(self::$piede);
	}
		
	public function preparaPaginaStart($configPreventivoTemplate) {

		$configPreventivoTemplate->setAzione(self::$azione);
		$configPreventivoTemplate->setTitoloPagina("%ml.modificaConfigPreventivo%");
		
		$file = self::$root . self::$configFile;
		$cnf = parse_ini_file($file);
		
		$configPreventivoTemplate->setValiditaGiorniPreventivo($cnf['validitaGiorniPreventivo']);
		$configPreventivoTemplate->setNota1Validita($cnf['nota1Validita']);
		$configPreventivoTemplate->setNota2Validita($cnf['nota2Validita']);
		
		if ($cnf['stampaPreventivoRiassuntivo'] == 'si') {
			$configPreventivoTemplate->setPreventivoRiassuntivoSi('checked');
			$configPreventivoTemplate->setPreventivoRiassuntivoNo('');
		}
		else {
			$configPreventivoTemplate->setPreventivoRiassuntivoSi('');
			$configPreventivoTemplate->setPreventivoRiassuntivoNo('checked');
		}
		
		if ($cnf['stampaSezioneIntestazione'] == 'si') {
			$configPreventivoTemplate->setSezioneIntestazioneSi('checked');
			$configPreventivoTemplate->setSezioneIntestazioneNo('');
		}
		else {
			$configPreventivoTemplate->setSezioneIntestazioneSi('');
			$configPreventivoTemplate->setSezioneIntestazioneNo('checked');
		}

		if ($cnf['stampaSezioneDatiAnagraficiPaziente'] == 'si') {
			$configPreventivoTemplate->setSezioneDatiAnagraficiPazienteSi('checked');
			$configPreventivoTemplate->setSezioneDatiAnagraficiPazienteNo('');
		}
		else {
			$configPreventivoTemplate->setSezioneDatiAnagraficiPazienteSi('');
			$configPreventivoTemplate->setSezioneDatiAnagraficiPazienteNo('checked');
		}

		if ($cnf['stampaSezioneNota'] == 'si') {
			$configPreventivoTemplate->setSezioneNotaValiditaSi('checked');
			$configPreventivoTemplate->setSezioneNotaValiditaNo('');
		}
		else {
			$configPreventivoTemplate->setSezioneNotaValiditaSi('');
			$configPreventivoTemplate->setSezioneNotaValiditaNo('checked');
		}

		if ($cnf['stampaSezioneFirma'] == 'si') {
			$configPreventivoTemplate->setSezioneFirmaAccettazioneSi('checked');
			$configPreventivoTemplate->setSezioneFirmaAccettazioneNo('');
		}
		else {
			$configPreventivoTemplate->setSezioneFirmaAccettazioneSi('');
			$configPreventivoTemplate->setSezioneFirmaAccettazioneNo('checked');
		}

		if ($cnf['stampaSezionePianoPagamento'] == 'si') {
			$configPreventivoTemplate->setSezionePianoPagamentoSi('checked');
			$configPreventivoTemplate->setSezionePianoPagamentoNo('');
		}
		else {
			$configPreventivoTemplate->setSezionePianoPagamentoSi('');
			$configPreventivoTemplate->setSezionePianoPagamentoNo('checked');
		}

		if ($cnf['stampaSezioneAnnotazioni'] == 'si') {
			$configPreventivoTemplate->setSezioneAnnotazioniSi('checked');
			$configPreventivoTemplate->setSezioneAnnotazioniNo('');
		}
		else {
			$configPreventivoTemplate->setSezioneAnnotazioniSi('');
			$configPreventivoTemplate->setSezioneAnnotazioniNo('checked');
		}

		if ($cnf['stampaSezioneAnnotazioniVoci'] == 'si') {
			$configPreventivoTemplate->setSezioneAnnotazioniVociSi('checked');
			$configPreventivoTemplate->setSezioneAnnotazioniVociNo('');
		}
		else {
			$configPreventivoTemplate->setSezioneAnnotazioniVociSi('');
			$configPreventivoTemplate->setSezioneAnnotazioniVociNo('checked');
		}
	}

	public function preparaPaginaGo($configPreventivoTemplate) {
	
		$configPreventivoTemplate->setAzione($this->getAzione());
	
		$configPreventivoTemplate->setValiditaGiorniPreventivo($_POST['validitagiornipreventivo']);
		$configPreventivoTemplate->setNota1Validita($_POST['nota1validita']);
		$configPreventivoTemplate->setNota2Validita($_POST['nota2validita']);
		
		if ($_POST['stampaPreventivoRiassuntivo'] == 'si') {
			$configPreventivoTemplate->setPreventivoRiassuntivoSi('checked');
			$configPreventivoTemplate->setPreventivoRiassuntivoNo('');
		}
		else {
			$configPreventivoTemplate->setPreventivoRiassuntivoSi('');
			$configPreventivoTemplate->setPreventivoRiassuntivoNo('checked');
		}
			
		if ($_POST['sezioneIntestazione'] == 'si') {
			$configPreventivoTemplate->setSezioneIntestazioneSi('checked');
			$configPreventivoTemplate->setSezioneIntestazioneNo('');
		}
		else {
			$configPreventivoTemplate->setSezioneIntestazioneSi('');
			$configPreventivoTemplate->setSezioneIntestazioneNo('checked');
		}
	
		if ($_POST['sezioneDatiAnagraficiPaziente'] == 'si') {
			$configPreventivoTemplate->setSezioneDatiAnagraficiPazienteSi('checked');
			$configPreventivoTemplate->setSezioneDatiAnagraficiPazienteNo('');
		}
		else {
			$configPreventivoTemplate->setSezioneDatiAnagraficiPazienteSi('');
			$configPreventivoTemplate->setSezioneDatiAnagraficiPazienteNo('checked');
		}

		if ($_POST['sezioneNotaValidita'] == 'si') {
			$configPreventivoTemplate->setSezioneNotaValiditaSi('checked');
			$configPreventivoTemplate->setSezioneNotaValiditaNo('');
		}
		else {
			$configPreventivoTemplate->setSezioneNotaValiditaSi('');
			$configPreventivoTemplate->setSezioneNotaValiditaNo('checked');
		}

		if ($_POST['sezioneFirmaAccettazione'] == 'si') {
			$configPreventivoTemplate->setSezioneFirmaAccettazioneSi('checked');
			$configPreventivoTemplate->setSezioneFirmaAccettazioneNo('');
		}
		else {
			$configPreventivoTemplate->setSezioneFirmaAccettazioneSi('');
			$configPreventivoTemplate->setSezioneFirmaAccettazioneNo('checked');
		}
		
		if ($_POST['sezionePianoPagamento'] == 'si') {
			$configPreventivoTemplate->setSezionePianoPagamentoSi('checked');
			$configPreventivoTemplate->setSezionePianoPagamentoNo('');
		}
		else {
			$configPreventivoTemplate->setSezionePianoPagamentoSi('');
			$configPreventivoTemplate->setSezionePianoPagamentoNo('checked');
		}

		if ($_POST['sezioneAnnotazioni'] == 'si') {
			$configPreventivoTemplate->setSezioneAnnotazioniSi('checked');
			$configPreventivoTemplate->setSezioneAnnotazioniNo('');
		}
		else {
			$configPreventivoTemplate->setSezioneAnnotazioniSi('');
			$configPreventivoTemplate->setSezioneAnnotazioniNo('checked');
		}

		if ($_POST['sezioneAnnotazioniVoci'] == 'si') {
			$configPreventivoTemplate->setSezioneAnnotazioniVociSi('checked');
			$configPreventivoTemplate->setSezioneAnnotazioniVociNo('');
		}
		else {
			$configPreventivoTemplate->setSezioneAnnotazioniVociSi('');
			$configPreventivoTemplate->setSezioneAnnotazioniVociNo('checked');
		}
	}
	
	public function modifica($configPreventivoTemplate) {
		
		// riparso il file di configurazione per prendere le impostazioni attuali
		// e preparo una array di replace da applicare
		$file = self::$root . self::$configFile;
		$cnf = parse_ini_file($file);
		
		$cnf['stampaPreventivoRiassuntivo'] = ($cnf['stampaPreventivoRiassuntivo'] == '') ? 'no' : 'si';
		$cnf['stampaSezioneIntestazione'] = ($cnf['stampaSezioneIntestazione'] == '') ? 'no' : 'si';
		$cnf['stampaSezioneDatiAnagraficiPaziente'] = ($cnf['stampaSezioneDatiAnagraficiPaziente'] == '') ? 'no' : 'si';
		$cnf['stampaSezioneNota'] = ($cnf['stampaSezioneNota'] == '') ? 'no' : 'si';
		$cnf['stampaSezioneFirma'] = ($cnf['stampaSezioneFirma'] == '') ? 'no' : 'si';
		$cnf['stampaSezionePianoPagamento'] = ($cnf['stampaSezionePianoPagamento'] == '') ? 'no' : 'si';
		$cnf['stampaSezioneAnnotazioni'] = ($cnf['stampaSezioneAnnotazioni'] == '') ? 'no' : 'si';
		$cnf['stampaSezioneAnnotazioniVoci'] = ($cnf['stampaSezioneAnnotazioniVoci'] == '') ? 'no' : 'si';
		
		$replace = array(
			'validitaGiorniPreventivo = ' . $cnf['validitaGiorniPreventivo'] => 'validitaGiorniPreventivo = ' . $configPreventivoTemplate->getValiditaGiorniPreventivo(),
			'nota1Validita = ' . $cnf['nota1Validita'] => 'nota1Validita = ' . $configPreventivoTemplate->getNota1Validita(),
			'nota2Validita = ' . $cnf['nota2Validita'] => 'nota2Validita = ' . $configPreventivoTemplate->getNota2Validita(),
			'stampaPreventivoRiassuntivo = ' . $cnf['stampaPreventivoRiassuntivo'] => 'stampaPreventivoRiassuntivo = ' . $_POST['stampaPreventivoRiassuntivo'],
			'stampaSezioneIntestazione = ' . $cnf['stampaSezioneIntestazione'] => 'stampaSezioneIntestazione = ' . $_POST['sezioneIntestazione'],
			'stampaSezioneDatiAnagraficiPaziente = ' . $cnf['stampaSezioneDatiAnagraficiPaziente'] => 'stampaSezioneDatiAnagraficiPaziente = ' . $_POST['sezioneDatiAnagraficiPaziente'],
			'stampaSezioneNota = ' . $cnf['stampaSezioneNota'] => 'stampaSezioneNota = ' . $_POST['sezioneNotaValidita'],
			'stampaSezioneFirma = ' . $cnf['stampaSezioneFirma'] => 'stampaSezioneFirma = ' . $_POST['sezioneFirmaAccettazione'],
			'stampaSezionePianoPagamento = ' . $cnf['stampaSezionePianoPagamento'] => 'stampaSezionePianoPagamento = ' . $_POST['sezionePianoPagamento'],
			'stampaSezioneAnnotazioni = ' . $cnf['stampaSezioneAnnotazioni'] => 'stampaSezioneAnnotazioni = ' . $_POST['sezioneAnnotazioni'],
			'stampaSezioneAnnotazioniVoci = ' . $cnf['stampaSezioneAnnotazioniVoci'] => 'stampaSezioneAnnotazioniVoci = ' . $_POST['sezioneAnnotazioniVoci'],
		);
		
		// poi prendo il contenuto del file e applico i replacement e riscrivo il risultato sul file
		$temp = file_get_contents($file);
		$temp = str_replace(array_keys($replace), array_values($replace), $temp);
		$result = file_put_contents($file,$temp);
		
		return $result;
	}
}	
	
?>