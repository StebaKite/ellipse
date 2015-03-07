UPDATE paziente.notasottopreventivo
	SET
		nota = '%notapreventivo%' ,
		datamodifica = current_date
		
WHERE idsottopreventivo = %idsottopreventivo%
  AND idnotasottopreventivo = %idnotasottopreventivo%