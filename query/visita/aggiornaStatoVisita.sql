UPDATE paziente.visita
	
	SET datamodifica = current_date,
	    stato = '%stato%'
		
WHERE idvisita = %idvisita%
