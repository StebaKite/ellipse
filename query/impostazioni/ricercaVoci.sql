SELECT
	idvoce,
	codice,
	descrizione,
	prezzo,
	tipo,
	datainserimento,
	datamodifica,
	COALESCE(vocelis.numlistini, 0) as numlistini
	
FROM paziente.voce

	LEFT OUTER JOIN
		(SELECT idvocelistino, count(*) as numlistini
		   FROM paziente.vocelistino
		  GROUP BY idvocelistino
		) as vocelis
		ON vocelis.idvocelistino = voce.idvoce

WHERE idcategoria = %idcategoria%
ORDER BY codice