UPDATE paziente.vocevisita
	
	SET codicevocelistino = '%codicevocelistino%',
		datamodifica = current_date
		
WHERE idvocevisita = %idvocevisita%
