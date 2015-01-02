UPDATE paziente.visita
	
	SET datamodifica = current_date
		
WHERE idvisita = %idvisita%
