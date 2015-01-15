SELECT

	iddettaglioguida,
	colonna,
	posizionevalore

FROM strumenti.dettaglioguida
WHERE idguida = %idguida%

ORDER BY posizionevalore