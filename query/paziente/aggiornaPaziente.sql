UPDATE paziente.paziente
	
	SET datamodifica = current_date
		
WHERE idpaziente = %idpaziente%

