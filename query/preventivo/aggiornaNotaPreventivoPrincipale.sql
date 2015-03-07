UPDATE paziente.notapreventivo
	SET
		nota = '%notapreventivo%' ,
		datamodifica = current_date
		
WHERE idpreventivo = %idpreventivo%
  AND idnotapreventivo = %idnotapreventivo%