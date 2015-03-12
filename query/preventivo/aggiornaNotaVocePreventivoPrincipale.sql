UPDATE paziente.notavocepreventivo
	SET
		nota = '%notapreventivo%' ,
		datamodifica = current_date
		
WHERE idnotavocepreventivo = %idnotavocepreventivo%