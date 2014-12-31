SELECT

	t1.entita,
	t1.totale

  FROM
  
	(
		SELECT
			1 as ordine,
			'Pazienti definitivi' as entita,
			count(*) as totale
		  FROM paziente.paziente
		  WHERE paziente.tipo = 'D'

		UNION
		
		SELECT
			1 as ordine,
			'Pazienti provvisori' as entita,
			count(*) as totale
		  FROM paziente.paziente
		  WHERE paziente.tipo = 'P'

		UNION
		
		SELECT
			2 as ordine,
			'Visite in corso' as entita,
			count(*) as totale	 
		  FROM paziente.visita		
		 WHERE visita.stato = '00'

		UNION
		
		SELECT
			3 as ordine,
			'Visite in preventivate' as entita,
			count(*) as totale	 
		  FROM paziente.visita		
		 WHERE visita.stato = '01'
	  
	) as t1

ORDER BY t1.ordine
	
