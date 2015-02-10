UPDATE paziente.preventivo
	SET datamodifica = current_date,
	    stato = '%stato%'
WHERE idpreventivo = %idpreventivo%
