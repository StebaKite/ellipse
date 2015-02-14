UPDATE paziente.preventivo
	SET
		scontopercentuale = %scontopercentuale% ,
		scontocontante = %scontocontante% ,
		accontoiniziocura = %accontoiniziocura% ,
		accontometacura = %accontometacura% ,
		saldofinecura = %saldofinecura% ,
		numerogiornirata = %numerogiornirata% ,
		importorata = %importorata% ,
		importodarateizzare = %importodarateizzare% ,
		dataprimarata = %dataprimarata% ,
		datamodifica = current_date
		
WHERE idpreventivo = %idpreventivo%