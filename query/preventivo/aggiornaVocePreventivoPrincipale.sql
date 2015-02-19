update paziente.vocepreventivo
	set
		descrizione = %descrizione%,
		prezzo = %prezzo%,
		datamodifica = current_date
		
where idvocepreventivo = %idvocepreventivo%
