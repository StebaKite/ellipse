UPDATE paziente.vocesottopreventivo
	SET codicevocelistino = '%codicevocelistino%',
		datamodifica = current_date
WHERE idvocesottopreventivo = %idvocesottopreventivo%
