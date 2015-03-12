UPDATE paziente.notavocesottopreventivo
	SET
		nota = '%notapreventivo%' ,
		datamodifica = current_date
		
WHERE idnotavocesottopreventivo = %idnotavocesottopreventivo%