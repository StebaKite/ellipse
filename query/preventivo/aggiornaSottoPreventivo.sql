UPDATE paziente.sottopreventivo
	SET datamodifica = current_date
WHERE idsottopreventivo = %idsottopreventivo%
