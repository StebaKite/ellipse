UPDATE paziente.voce
SET
	codice = '%codice%',
	descrizione = '%descrizione%',
	prezzo = %prezzo%,
	tipo = '%tipo%',
	datamodifica = current_date
		
WHERE idvoce = %idvoce%