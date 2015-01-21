UPDATE paziente.listino
SET
	codice = '%codicelistino%',
	descrizionelistino = '%descrizionelistino%',
	datamodifica = current_date
		
WHERE idlistino = %idlistino%