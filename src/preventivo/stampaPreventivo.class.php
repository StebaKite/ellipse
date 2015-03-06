<?php

require_once 'pdf.class.php';
require_once 'preventivo.abstract.class.php';

class stampaPreventivo extends preventivoAbstract {

	public static $root;
	public static $logo;
	public static $studio;
	public static $sedelegale;
	public static $sedesecondaria;
	public static $piva;
	public static $rea;
	public static $capitale;
	public static $importoCapitale;
	public static $versato;
	public static $nota1Validita;
	public static $nota2Validita;
	public static $validitaGiorniPreventivo;
	public static $stampaPreventivoRiassuntivo;
	public static $stampaPreventivoDettagliato;
	public static $stampaSezioneNota;
	public static $stampaSezioneFirma;
	public static $stampaSezioneDatiAnagraficiPaziente;
	public static $stampaSezioneIntestazione;
	public static $stampaSezionePianoPagamento;
	public static $stampaSezioneAnnotazioni;
	public static $stampaSezioneAnnotazioniVoci;
	
	function __construct() {
	
		self::$root = $_SERVER['DOCUMENT_ROOT'];
	
		require_once 'utility.class.php';
	
		$utility = new utility();
		$array = $utility->getConfig();
	
		self::$logo = self::$root . $array['logo'];
		self::$studio = $array['studio'];
		self::$sedelegale = $array['sedelegale'];
		self::$sedesecondaria = $array['sedesecondaria'];
		self::$piva = $array['piva'];
		self::$rea = $array['rea'];
		self::$capitale = $array['capitale'];
		self::$importoCapitale = $array['importoCapitale'];
		self::$versato = $array['versato'];
		self::$nota1Validita = $array['nota1Validita'];
		self::$nota2Validita = $array['nota2Validita'];
		self::$validitaGiorniPreventivo = $array['validitaGiorniPreventivo'];
		self::$stampaPreventivoRiassuntivo = ($array['stampaPreventivoRiassuntivo'] == 'si') ? true : false;
		self::$stampaSezioneNota = ($array['stampaSezioneNota'] == 'si') ? true : false;
		self::$stampaSezioneFirma = ($array['stampaSezioneFirma'] == 'si') ? true : false;
		self::$stampaSezioneDatiAnagraficiPaziente = ($array['stampaSezioneDatiAnagraficiPaziente'] == 'si') ? true : false;
		self::$stampaSezioneIntestazione = ($array['stampaSezioneIntestazione'] == 'si') ? true : false;
		self::$stampaSezionePianoPagamento = ($array['stampaSezionePianoPagamento'] == 'si') ? true : false;
		self::$stampaSezioneAnnotazioni = ($array['stampaSezioneAnnotazioni'] == 'si') ? true : false;
		self::$stampaSezioneAnnotazioniVoci = ($array['stampaSezioneAnnotazioniVoci'] == 'si') ? true : false;
	}
	
	public function start() {

		error_log("<<<<<<< Start >>>>>>> " . $_SERVER['PHP_SELF']);

		require_once 'utility.class.php';
		require_once 'database.class.php';
		
		$pdf = new PDF();		
		$db = new database();
		$utility = new utility();
		
		$pdf->SetTitle('Stampa Preventivo');
		$pdf->SetCreator('Ellipse');
		$pdf->AliasNbPages();
		
		$db->beginTransaction();

		$pdf->setLogo(self::$logo);
		
		if (self::$stampaSezioneIntestazione) $pdf = $this->generaSezioneIntestazione($pdf);
		if (self::$stampaSezioneDatiAnagraficiPaziente) $pdf = $this->generaSezioneDatiAnagraficiPaziente($pdf, $db, $utility);
		
		/**
		 * SB 27/02/2015 : per ora fa solo il riepilogo riassuntivo
		 */
		if (self::$stampaPreventivoRiassuntivo) $pdf = $this->generaSezioneTabellaRiassuntiva($pdf, $db);
		else $pdf = $this->generaSezioneTabellaRiassuntiva($pdf, $db);
		
		if (self::$stampaSezioneNota) $pdf = $this->generaSezioneNota($pdf);
		if (self::$stampaSezioneFirma) $pdf = $this->generaSezioneFirma($pdf);
		
		if (self::$stampaSezionePianoPagamento) $pdf = $this->generaSezionePianoPagamento($pdf, $db, $utility);				
		if (self::$stampaSezioneNota) $pdf = $this->generaSezioneNota($pdf);
		if (self::$stampaSezioneFirma) $pdf = $this->generaSezioneFirma($pdf);
		
		if (self::$stampaSezioneAnnotazioni) $pdf = $this->generaSezioneAnnotazioni($pdf, $db, $utility);
		if (self::$stampaSezioneAnnotazioniVoci) $pdf = $this->generaSezioneAnnotazioniVoci($pdf, $db, $utility);
		
		$db->commitTransaction();
		
		$pdf->Output();
	}

	public function generaSezioneNota($pdf) {

		$pdf->SetY(-50);				// Posizione 5 cm dal fondo pagina
		$pdf->SetFillColor(224,235,255);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(10,10, utf8_decode(self::$nota1Validita) . ' ' . self::$validitaGiorniPreventivo . ' ' . utf8_decode(self::$nota2Validita));

		return $pdf;
	}
	
	public function generaSezioneFirma($pdf) {

		$pdf->SetY(-35);				// Posizione 3.5 cm dal fondo pagina
		$pdf->Cell(10,10, "Data: ____________________");
		$pdf->Cell(50);
		$pdf->Cell(10,10, "Firma per accettazione: _____________________________________");

		return $pdf;
	} 
	
	public function generaSezioneIntestazione($pdf) {

		$pdf->setStudio(self::$studio);
		$pdf->setSedeLegale(self::$sedelegale);
		$pdf->setSedeSecondaria(self::$sedesecondaria);
		$pdf->setPiva(self::$piva);
		$pdf->setRea(self::$rea);
		$pdf->setCapitale(self::$capitale);
		$pdf->setImportoCapitale(self::$importoCapitale);
		$pdf->setVersato(self::$versato);
		
		return $pdf;
	}
	
	public function generaSezioneDatiAnagraficiPaziente($pdf, $db, $utility) {
		
		$pdf->AddPage();
		
		$pdf->SetFont('Arial','B',12);
		
		if ($_SESSION['idPreventivo'] != "") $idPreventivo = $_SESSION['idPreventivo'];
		elseif ($_SESSION['idSottoPreventivo'] != "") $idPreventivo = $_SESSION['idSottoPreventivo'];
		
		$pdf->Cell(40,10,"Preventivo:  " . $idPreventivo . "  del  " . $_SESSION['dataInserimento']);
		$pdf->Ln(10);
		
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(30,10,"Paziente");
		
		$pdf->SetFont('Arial','',10);
		$this->setRoot(self::$root);
		foreach ($this->caricaDatiAnagraficiPaziente($db, $utility) as $row) {
			$pdf->Cell(40,10, utf8_decode(trim($row['cognome'])) . utf8_decode(trim($row['nome'])));
			$pdf->Ln(5);
			$pdf->Cell(30);
			$pdf->Cell(40,10, utf8_decode(trim($row['indirizzo'])));
			$pdf->Ln(5);
			$pdf->Cell(30);
			$pdf->Cell(40,10, trim($row['cap']) . ' ' . utf8_decode(trim($row['citta'])) . '  (' . trim($row['provincia']) . ')');
			$pdf->Ln(5);
		}
		$pdf->Ln(20);
		
		return $pdf;
	}
	
	public function generaSezioneTabellaRiassuntiva($pdf, $db) {

		$header = array("Descrizione", "Voce", "Quantita'");
		$pdf->SetFont('Arial','',9);
		$pdf->PreventivoTable($header,$this->caricaRiassuntoVoci($db, self::$root));
	
		return $pdf;
	}

	public function generaSezionePianoPagamento($pdf, $db, $utility) {

		$acconti = $this->caricaAcconti($db, $utility);
		$rate = $this->caricaRate($db, $utility);
		$sconti = $this->caricaSconti($db, $utility);
		
		if($acconti) {
			$pdf->AddPage();
			
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(30,10,"Piano di Pagamento");
			$pdf->Ln(10);

			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(30,10,"Acconti");
			$pdf->Ln(10);
			
			$header = array("Scadenza", "Descrizione", "Importo");
			$pdf->SetFont('Arial','',9);
			$pdf->AccontiTable($header,$acconti);				
		}
		
		if ($rate) {
			$pdf->Ln(10);			
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(30,10,"Rateizzazione");
			$pdf->Ln(10);
				
			$header = array("Scadenza", "Descrizione", "Importo");
			$pdf->SetFont('Arial','',9);
			$pdf->RateTable($header,$rate);				
		}
		
		if (($sconti[0]['scontopercentuale'] != null) or ($sconti[0]['scontocontante'] != null)) {
			$pdf->Ln(10);
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(30,10,"Sconti");
			$pdf->Ln(10);
			
			$header = array("Sconto", "Valore", "Importo");
			$pdf->SetFont('Arial','',9);
			$pdf->ScontiTable($header,$sconti);
		}
		
		return $pdf;		
	}
	
	public function generaSezioneAnnotazioni($pdf, $db, $utility) {

		$annotazioni = $this->caricaAnnotazioni($db, $utility);

		if ($annotazioni) {
			
			$pdf->AddPage();
			
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(40,10,"Osservazioni Generali");
			$pdf->Ln(10);
			$pdf->SetFont('Arial','',9);
			
			$column_width = $pdf->w - 30;
			
			$noteArray = array();
			$noteArray['bullet'] = chr(149);
			$noteArray['margin'] = ' ';
			$noteArray['indent'] = 0;
			$noteArray['spacer'] = 0;
			$noteArray['text'] = array();
			
			$i = 0;
			foreach ($annotazioni as $row) {
				$noteArray['text'][$i] = utf8_decode(trim($row['nota']));
				$i++;
			}
			
			$pdf->SetX(10);
			$pdf->MultiCellBulletList($column_width - $pdf->x, 6, $noteArray);				
		}
				
		return $pdf;
	}
	
	public function generaSezioneAnnotazioniVoci($pdf, $db, $utility) {

		$annotazioniVoci = $this->caricaAnnotazioniVoci($db, $utility);
		
		if ($annotazioniVoci) {
			
			$pdf->Ln(10);
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(40,10,"Annotazioni Operazioni");
			$pdf->Ln(10);
			$pdf->SetFont('Arial','',9);
			
			$column_width = $pdf->w - 30;
			
			$i = 0;
			$denteBreak = "";
			
			foreach ($annotazioniVoci as $row) {
					
				if (trim($row['dente']) != $denteBreak) {
			
					/**
					 * Se cambia dente e non è la prima tabella emetto le note del dente
					 */
					if ($denteBreak != "") {
						$pdf->SetFont('Arial','B',10);
						$pdf->Cell(40,10, utf8_decode("Dente N° ") . $denteBreak . " - " . utf8_decode($descrizioneBreak));
						$pdf->Ln(10);
						$pdf->SetFont('Arial','',9);
						$pdf->SetX(10);
						$pdf->MultiCellBulletList($column_width - $pdf->x, 6, $noteArray);
					}
			
					$noteArray = array();
					$noteArray['bullet'] = chr(149);
					$noteArray['margin'] = ' ';
					$noteArray['indent'] = 0;
					$noteArray['spacer'] = 0;
					$noteArray['text'] = array();
			
					$denteBreak = trim($row['dente']);
					$descrizioneBreak = trim($row['descrizionevoce']);
					$i = 0;
				}
				$noteArray['text'][$i] = utf8_decode(trim($row['nota']));
				$i++;
			}
			
			/**
			 * Butto fuori l'ultima lista
			 */
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(40,10, utf8_decode("Dente N° ") . $denteBreak . " - " . utf8_decode($descrizioneBreak));
			$pdf->Ln(10);
			$pdf->SetFont('Arial','',9);
			$pdf->SetX(10);
			$pdf->MultiCellBulletList($column_width - $pdf->x, 6, $noteArray);		
		}		
		return $pdf;		
	}
	
	public function generaSezioneTabellaDettaliata($pdf, $db) {

		// da implementare
		
		return $pdf;
	}
	
	public function caricaAnnotazioni($db, $utility) {

		if ($_SESSION['idPreventivo'] != "") {
			return $this->leggiAnnotazioniPreventivoPrincipale($db, $utility, $_SESSION['idPreventivo']);
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {
			return $this->leggiAnnotazioniPreventivoSecondario($db, $utility, $_SESSION['idSottoPreventivo']);
		}
	}

	public function caricaAnnotazioniVoci($db, $utility) {
	
		if ($_SESSION['idPreventivo'] != "") {
			return $this->leggiAnnotazioniVociPreventivoPrincipale($db, $utility, $_SESSION['idPreventivo']);
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {
			return $this->leggiAnnotazioniVociPreventivoSecondario($db, $utility, $_SESSION['idSottoPreventivo']);
		}
	}
	
	public function caricaRiassuntoVoci($db, $root) {
		
		if ($_SESSION['idPreventivo'] != "") {
			return $this->prelevaRiassuntoVociStampaPreventivoPrincipale($db, $root, $_SESSION['idPaziente'], $_SESSION['idPreventivo']);
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {
			return $this->prelevaRiassuntoVociStampaPreventivoSecondario($db, $root, $_SESSION['idPaziente'], $_SESSION['idSottoPreventivo']);
		}
	}

	public function caricaSconti($db, $utility) {
	
		if ($_SESSION['idPreventivo'] != "") {
			$this->setRoot(self::$root);
			return $this->leggiCondizioniPagamentoPreventivoPrincipale($db, $utility, $_SESSION['idPreventivo']);
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {
			return $this->leggiCondizioniPagamentoPreventivoSecondario($db, $utility, $_SESSION['idSottoPreventivo']);
		}
	}
	
	public function caricaAcconti($db, $utility) {
		
		if ($_SESSION['idPreventivo'] != "") {
			$this->setRoot(self::$root);
			return $this->leggiAccontiPreventivoPrincipale($db, $utility, $_SESSION['idPreventivo']);
		}		
		elseif ($_SESSION['idSottoPreventivo'] != "") {
			$this->setRoot(self::$root);
			return $this->leggiAccontiPreventivoSecondario($db, $utility, $_SESSION['idSottoPreventivo']);
		}
	}

	public function caricaRate($db, $utility) {
	
		if ($_SESSION['idPreventivo'] != "") {
			$this->setRoot(self::$root);
			return $this->leggiRatePagamentoPreventivoPrincipale($db, $utility, $_SESSION['idPreventivo']);
		}
		elseif ($_SESSION['idSottoPreventivo'] != "") {
			$this->setRoot(self::$root);
			return $this->leggiRatePagamentoPreventivoSecondario($db, $utility, $_SESSION['idSottoPreventivo']);
		}
	}

	/**
	 *
	 * @param unknown $db
	 * @param unknown $utility
	 * @param unknown $idPreventivo
	 * 
	 * @override
	 */
	public function leggiCondizioniPagamentoPreventivoPrincipale($db, $utility, $idPreventivo) {
	
		$array = $utility->getConfig();
		$replace = array('%idpreventivo%' => $idPreventivo);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryLeggiCondizioniPagamentoPreventivoPrincipale;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return pg_fetch_all($result);
	}
	
	/**
	 *
	 * @param unknown $db
	 * @param unknown $utility
	 * @param unknown $idSottoPreventivo
	 * 
	 * @override
	 */
	public function leggiCondizioniPagamentoPreventivoSecondario($db, $utility, $idSottoPreventivo) {
	
		$array = $utility->getConfig();
		$replace = array('%idsottopreventivo%' => $idSottoPreventivo);
	
		$sqlTemplate = self::$root . $array['query'] . self::$queryLeggiCondizioniPagamentoPreventivoSecondario;
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->execSql($sql);
	
		return pg_fetch_all($result);
	}
}

?>