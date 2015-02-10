UPDATE paziente.sottopreventivo
	SET datamodifica = current_date,
	    stato = '%stato%'
WHERE idsottopreventivo = %idsottopreventivo%
