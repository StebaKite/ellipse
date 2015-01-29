UPDATE paziente.preventivo
	SET datamodifica = current_date
WHERE idpreventivo = %idpreventivo%
