<?php
require('fpdf.php');

class PDF extends FPDF {

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

	public static $prezzoTotale;
	
	// --------------------------------------------------------------------
	
	public function setLogo($logo) {
		SELF::$logo = $logo;
	}
	public function setStudio($studio) {
		SELF::$studio = $studio;
	}
	public function setSedeLegale($sedelegale) {
		SELF::$sedelegale = $sedelegale;
	}
	public function setSedeSecondaria($sedesecondaria) {
		SELF::$sedesecondaria = $sedesecondaria;
	}
	public function setPiva($piva) {
		SELF::$piva = $piva;
	}
	public function setRea($rea) {
		SELF::$rea = $rea;
	}
	public function setCapitale($capitale) {
		SELF::$capitale = $capitale;
	}
	public function setImportoCapitale($importocapitale) {
		SELF::$importoCapitale = $importocapitale;
	}
	public function setVersato($versato) {
		SELF::$versato = $versato;
	}
	public function setNotaValidita($notaValidita) {
		SELF::$notaValidita = $notaValidita;
	}
	public function setPrezzoTotale($prezzoTotale) {
		SELF::$prezzoTotale = $prezzoTotale;
	}
	
	// --------------------------------------------------------------------
	
	public function getLogo() {
		return SELF::$logo;
	}
	public function getStudio() {
		return SELF::$studio;
	}
	public function getSedeLegale() {
		return SELF::$sedelegale;
	}
	public function getSedeSecondaria() {
		return SELF::$sedesecondaria;
	}
	public function getPiva() {
		return SELF::$piva;
	}
	public function getRea() {
		return SELF::$rea;
	}
	public function getCapitale() {
		return SELF::$capitale;
	}
	public function getImportoCapitale() {
		return SELF::$importoCapitale;
	}
	public function getVersato() {
		return SELF::$versato;
	}
	public function getNotaValidita() {
		return SELF::$notaValidita;
	}
	public function getPrezzoTotale() {
		return SELF::$prezzoTotale;
	}
	
	
	public function Header() {

		define('EURO', chr(128));
		
		$this->Image($this->getLogo(),5,5,30);
		
		$this->SetFont('Arial','B',15);
		$this->Cell(55);
		$this->Cell(30, 10, utf8_decode($this->getStudio()), 0, 1);
		
		$this->Cell(30);	
		$this->SetFont('Times','',10);
		$this->Cell(0,5, utf8_decode($this->getSedeLegale()), 0, 1);

		$this->Cell(50);
		$this->SetFont('Times','',10);
		$this->Cell(0,5, utf8_decode($this->getSedeSecondaria()), 0, 1);

		$this->Cell(40);
		$this->SetFont('Times','',10);
		$this->Cell(0,5, $this->getPiva() . ' - ' . $this->getRea() . ' - ' . $this->getCapitale() . ' ' . EURO . number_format($this->getImportoCapitale(), 2, ',', '.') . ' ' . $this->getVersato(), 0, 1);
		
		$this->Ln(20);
	}

	public function Footer() {
		
		$this->SetY(-15);												// Position at 1.5 cm from bottom		
		$this->SetFont('Arial','I',8);									// Arial italic 8		
		$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');	// Page number
	}
		
	// Simple table
	public function BasicTable($header, $data)
	{
	    // Header
	    foreach($header as $col)
	        $this->Cell(40,7,$col,1);
	    $this->Ln();
	    // Data
	    foreach($data as $row)
	    {
	        foreach($row as $col)
	            $this->Cell(40,6,$col,1);
	        $this->Ln();
	    }
	}
	
	// Better table
	public function ImprovedTable($header, $data)
	{
	    // Column widths
	    $w = array(40, 35, 40, 45);
	    // Header
	    for($i=0;$i<count($header);$i++)
	        $this->Cell($w[$i],7,$header[$i],1,0,'C');
	    $this->Ln();
	    // Data
	    foreach($data as $row)
	    {
	        $this->Cell($w[0],6,$row[0],'LR');
	        $this->Cell($w[1],6,$row[1],'LR');
	        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
	        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
	        $this->Ln();
	    }
	    // Closing line
	    $this->Cell(array_sum($w),0,'','T');
	}

	/**
	 * Tabella per stampa preventivo in formato riassuntivo
	 */
	public function PreventivoTable($header, $data)
	{
	    // Colors, line width and bold font
	    $this->SetFillColor(28,148,196);
	    $this->SetTextColor(255);
	    $this->SetDrawColor(128,0,0);
	    $this->SetLineWidth(.3);
	    $this->SetFont('','B',10);
	    
	    // Header
	    $w = array(150, 20, 20);
	    for($i=0;$i<count($header);$i++)
	        $this->Cell($w[$i],10,$header[$i],1,0,'C',true);
	    $this->Ln();
	    
	    // Color and font restoration
	    $this->SetFillColor(224,235,255);
	    $this->SetTextColor(0);
	    $this->SetFont('');
	    
	    // Data
	    $prezzoTotale = 0;
	    $fill = false;
	    foreach($data as $row)
	    {
	        $this->Cell($w[0],6,utf8_decode($row['descrizionevoce']),'LR',0,'L',$fill);
	    	$this->Cell($w[1],6,utf8_decode($row['codicevoce']),'LR',0,'L',$fill);
	        $this->Cell($w[2],6,number_format($row['quantitavoce']),'LR',0,'R',$fill);
	        $this->Ln();
	        $fill = !$fill;
	        $prezzoTotale += $row['totalevoce'];
	    }

	    $this->setPrezzoTotale($prezzoTotale);
	    
	    // linea finale del prezzo totale
	    $this->SetFillColor(249,253,172);
	    $this->SetTextColor(28,148,196);
	    $this->SetFont('','B',10);
	    $fill = true;
	     
	    $this->Cell($w[0],10,'Totale Operazioni Preventivate','LR',0,'R',$fill);
	    $this->Cell($w[1],10,'','LR',0,'L',$fill);
	    $this->Cell($w[2],10, EURO . number_format($prezzoTotale, 2, ',', '.'),'LR',0,'R',$fill);
	    $this->Ln();
	    
   	    $this->Cell(array_sum($w),0,'','T');	  
	}

	/**
	 * Tabella per stampa degli acconti
	 */
	public function AccontiTable($header, $data)
	{
		// Colors, line width and bold font
		$this->SetFillColor(28,148,196);
		$this->SetTextColor(255);
		$this->SetDrawColor(128,0,0);
		$this->SetLineWidth(.3);
		$this->SetFont('','B',10);
		 
		// Header
		$w = array(20, 150, 20);
		for($i=0;$i<count($header);$i++)
			$this->Cell($w[$i],10,$header[$i],1,0,'C',true);
			$this->Ln();
		  
			// Color and font restoration
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('');
		 
		// Data
	    $prezzoTotale = 0;
		$fill = false;
		foreach($data as $row)
		{
			$this->Cell($w[0],6,utf8_decode($row['datascadenza']),'LR',0,'L',$fill);
			$this->Cell($w[1],6,utf8_decode($row['descrizione']),'LR',0,'L',$fill);
			$this->Cell($w[2],6, EURO . number_format($row['importo'], 2, ',', '.'),'LR',0,'R',$fill);
			$this->Ln();
			$fill = !$fill;
	        $prezzoTotale += $row['importo'];
		}

		// linea finale del prezzo totale
		$this->SetFillColor(249,253,172);
		$this->SetTextColor(28,148,196);
		$this->SetFont('','B',10);
		$fill = true;
		
		$this->Cell($w[0],10,'','LR',0,'L',$fill);
		$this->Cell($w[1],10,'Totale Acconti','LR',0,'R',$fill);
		$this->Cell($w[2],10, EURO . number_format($prezzoTotale, 2, ',', '.'),'LR',0,'R',$fill);
		$this->Ln();

		// Color and font restoration
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('');
		
		$this->Cell(array_sum($w),0,'','T');
	}

	/**
	 * Tabella per stampa delle rate
	 */
	public function RateTable($header, $data)
	{
		// Colors, line width and bold font
		$this->SetFillColor(28,148,196);
		$this->SetTextColor(255);
		$this->SetDrawColor(128,0,0);
		$this->SetLineWidth(.3);
		$this->SetFont('','B',10);
		 
		// Header
		$w = array(20, 150, 20);
		for($i=0;$i<count($header);$i++)
			$this->Cell($w[$i],10,$header[$i],1,0,'C',true);
			$this->Ln();
		  
			// Color and font restoration
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('');
		 
		// Data
	    $prezzoTotale = 0;
		$fill = false;
		$i = 1;
		foreach($data as $row)
		{
			$this->Cell($w[0],6,utf8_decode($row['datascadenza']),'LR',0,'L',$fill);
			$this->Cell($w[1],6,utf8_decode('Rata numero ' . $i),'LR',0,'L',$fill);
			$this->Cell($w[2],6, EURO . number_format($row['importo'], 2, ',', '.'),'LR',0,'R',$fill);
			$this->Ln();
			$fill = !$fill;
	        $prezzoTotale += $row['importo'];
			$i++;
		}

		// linea finale del prezzo totale
		$this->SetFillColor(249,253,172);
		$this->SetTextColor(28,148,196);
		$this->SetFont('','B',10);
		$fill = true;
		
		$this->Cell($w[0],10,'','LR',0,'L',$fill);
		$this->Cell($w[1],10,'Totale Rateizzazione','LR',0,'R',$fill);
		$this->Cell($w[2],10, EURO . number_format($prezzoTotale, 2, ',', '.'),'LR',0,'R',$fill);
		$this->Ln();

		// Color and font restoration
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('');
		
		$this->Cell(array_sum($w),0,'','T');
	}

	/**
	 * Tabella per stampa degli sconti
	 */
	public function ScontiTable($header, $data)
	{
		// Colors, line width and bold font
		$this->SetFillColor(28,148,196);
		$this->SetTextColor(255);
		$this->SetDrawColor(128,0,0);
		$this->SetLineWidth(.3);
		$this->SetFont('','B',10);
		 
		// Header
		$w = array(150, 20, 20);
		for($i=0;$i<count($header);$i++)
			$this->Cell($w[$i],10,$header[$i],1,0,'C',true);
			$this->Ln();
		  
			// Color and font restoration
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('');
		 
		// Data
		$fill = false;
		foreach($data as $row)
		{
			$scontoPercentuale = $row['scontopercentuale'];
			$scontoContante = $row['scontocontante'];
			  
			if ($scontoPercentuale =! null) {
				$this->Cell($w[0],6,'Sconto in percentuale sul totale','LR',0,'L',$fill);
				$this->Cell($w[1],6, number_format($row['scontopercentuale']) . '%','LR',0,'C',$fill);
				$this->Cell($w[1],6, EURO . number_format(($this->getPrezzoTotale() / 100) * $row['scontopercentuale'], 2, ',', '.'),'LR',0,'R',$fill);
				$this->Ln();
				$fill = !$fill;
			}
		}
		
		$this->Cell(array_sum($w),0,'','T');
	}
}

?>