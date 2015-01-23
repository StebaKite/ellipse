UPDATE paziente.vocelistino
SET
	prezzo = %prezzo%,
	datamodifica = current_date
		
WHERE idvocelistino = %idvocelistino%
  AND idlistino = %idlistino%