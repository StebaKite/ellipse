SELECT
	listino.idlistino,
	listino.codice,
	listino.descrizionelistino,
	listino.datainserimento,
	listino.datamodifica,
	COALESCE(lispaz.numpazienti, 0) as numpazienti
	
FROM paziente.listino as listino

	LEFT OUTER JOIN
		(SELECT idlistino, count(*) as numpazienti
		   FROM paziente.paziente
		  GROUP BY idlistino
		) as lispaz
		ON lispaz.idlistino = listino.idlistino

ORDER BY listino.codice