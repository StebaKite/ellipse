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
	public static $notaValidita;
	
	public static $queryRicercaIdPaziente = "/paziente/ricercaIdPaziente.sql";
	
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
		self::$notaValidita = $array['notaValidita'];
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

		/**
		 * Dati per l'header di pagina
		 */
		$pdf->setLogo(self::$logo);
		$pdf->setStudio(self::$studio);
		$pdf->setSedeLegale(self::$sedelegale);
		$pdf->setSedeSecondaria(self::$sedesecondaria);
		$pdf->setPiva(self::$piva);
		$pdf->setRea(self::$rea);
		$pdf->setCapitale(self::$capitale);
		$pdf->setImportoCapitale(self::$importoCapitale);
		$pdf->setVersato(self::$versato);
		$pdf->setNotaValidita(self::$notaValidita);
		
		/**
		 * Dati anagrafici del paziente
		 */
		
		$pdf->AddPage();

		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(40,10,"Preventivo:  " . $this->getIdPreventivo() . "  del  " . $this->getDataInserimento());
		$pdf->Ln(10);
		
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(30,10,"Paziente");
		
		$pdf->SetFont('Arial','',10);
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

		/**
		 * Intestazioni colonne tabella voci
		 */
		$header = array("Descrizione", "Voce", "Quantita'");
		
		/**
		 * Genera una tabella riassuntiva delle voci
		 */
		$pdf->SetFont('Arial','',9);
		$pdf->PreventivoTable($header,$this->caricaRiassuntoVoci($db, self::$root));
		
		/**
		 * Inserisce la nota per la validità del preventivo
		 */
		$pdf->SetY(-50);												// Position at 2.5 cm from bottom		
	    $pdf->SetFillColor(224,235,255);
	    $pdf->SetTextColor(0);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(10,10, utf8_decode(self::$notaValidita));
		
		/**
		 * Inserisco la data e lo spazio per la firma
		 */
		$pdf->SetY(-35);												// Position at 2.5 cm from bottom		
		$pdf->Cell(10,10, "Data: ____________________");
		$pdf->Cell(50);
		$pdf->Cell(10,10, "Firma per accettazione: _____________________________________");
		
		
		
		$pdf->Output();
	}
	
	public function caricaRiassuntoVoci($db, $root) {
		
		if ($this->getIdpreventivo() != "") {
			return $this->prelevaRiassuntoVociStampaPreventivoPrincipale($db, $root, $this->getIdPaziente(), $this->getIdPreventivo());
		}
	}
	
	public function caricaDatiAnagraficiPaziente($db, $utility) {

		$array = $utility->getConfig();
		
		$replace = array('%idpaziente%' => $this->getIdPaziente());
		
		$sqlTemplate = self::$root . $array['query'] . self::$queryRicercaIdPaziente;		
		$sql = $utility->tailFile($utility->getTemplate($sqlTemplate), $replace);
		$result = $db->getData($sql);
		
		return pg_fetch_all($result);		
	}
}

?>