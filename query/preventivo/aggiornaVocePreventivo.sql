UPDATE paziente.vocepreventivo
	SET codicevocelistino = '%codicevocelistino%',
		datamodifica = current_date
WHERE idvocepreventivo = %idvocepreventivo%
