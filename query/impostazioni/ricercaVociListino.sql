SELECT
	vocelistino.idvocelistino,
	vocelistino.prezzo,
	vocelistino.datainserimento,
	vocelistino.datamodifica,
	vocelistino.qtaapplicazioni,
	voce.codice as codicevoce,
	voce.descrizione as descrizionevoce
	
FROM paziente.vocelistino as vocelistino

	INNER JOIN paziente.voce as voce
		ON voce.idvoce = vocelistino.idvocelistino
		
WHERE vocelistino.idlistino = %idlistino%
ORDER BY voce.codice