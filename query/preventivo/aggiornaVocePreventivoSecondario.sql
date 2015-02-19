update paziente.vocesottopreventivo
	set
		descrizione = %descrizione%,
		prezzo = %prezzo%,
		datamodifica = current_date
		
where idvocesottopreventivo = %idvocesottopreventivo%
