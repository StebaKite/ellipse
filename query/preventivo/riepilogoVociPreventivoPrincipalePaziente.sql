SELECT

	vocepreventivo.idvocepreventivo,
	vocepreventivo.codicevocelistino,
	vocepreventivo.nomecampoform,
	vocepreventivo.nomeform,
	vocepreventivo.prezzo,
    COALESCE(notavocepreventivo.numeronotevocepreventivo, 0) AS numeronotevocepreventivo,
	case
		when vocepreventivo.descrizione is null then voce.descrizione
		when vocepreventivo.descrizione is not null then vocepreventivo.descrizione
	end as descrizionevoce

FROM paziente.preventivo as preventivo

	INNER JOIN paziente.paziente as paziente
		ON paziente.idpaziente = preventivo.idpaziente
	
	LEFT OUTER JOIN paziente.vocepreventivo as vocepreventivo
		ON vocepreventivo.idpreventivo = preventivo.idpreventivo

	LEFT OUTER JOIN (
        SELECT
            vocepreventivo.idvocepreventivo ,
            COUNT(*) AS numeronotevocepreventivo    
            
          FROM paziente.vocepreventivo AS vocepreventivo  
          
            INNER JOIN paziente.notavocepreventivo AS notavocepreventivo 
            	ON notavocepreventivo.idvocepreventivo = vocepreventivo.idvocepreventivo             
            	
         WHERE vocepreventivo.idpreventivo = %idpreventivo%
         GROUP BY vocepreventivo.idvocepreventivo
       
     ) AS notavocepreventivo	    
     ON notavocepreventivo.idvocepreventivo = vocepreventivo.idvocepreventivo		
	
	INNER JOIN paziente.vocelistino as vocelistino
		ON  vocelistino.idlistino = paziente.idlistino
		
	INNER JOIN paziente.voce as voce
		ON  voce.idvoce = vocelistino.idvocelistino
		AND voce.codice = vocepreventivo.codicevocelistino
		
WHERE paziente.idpaziente = %idpaziente%
  AND preventivo.idpreventivo = %idpreventivo%
  AND vocepreventivo.nomeform = '%nomeform%'
  AND vocepreventivo.stato = '00'
  
ORDER BY vocepreventivo.nomeform, vocepreventivo.nomecampoform  
