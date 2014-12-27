update paziente.vocevisita
	
	set codicevocelistino = '%codicevocelistino%',
		datamodifica = current_date
		
where idvocevisita = %idvocevisita%
