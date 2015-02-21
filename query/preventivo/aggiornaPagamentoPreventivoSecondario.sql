UPDATE paziente.sottopreventivo
	SET
		scontopercentuale = %scontopercentuale% ,
		scontocontante = %scontocontante% ,
		numerogiornirata = %numerogiornirata% ,
		importorata = %importorata% ,
		importodarateizzare = %importodarateizzare% ,
		dataprimarata = %dataprimarata% ,
		datamodifica = current_date
		
WHERE idsottopreventivo = %idsottopreventivo%