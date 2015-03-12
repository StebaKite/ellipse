SELECT

	vocesottopreventivo.idvocesottopreventivo,
	vocesottopreventivo.codicevocelistino,
	vocesottopreventivo.nomecampoform,
	vocesottopreventivo.nomeform,
	vocesottopreventivo.prezzo,
    COALESCE(notavocesottopreventivo.numeronotevocesottopreventivo, 0) AS numeronotevocepreventivo,	
	case
		when vocesottopreventivo.descrizione is null then voce.descrizione
		when vocesottopreventivo.descrizione is not null then vocesottopreventivo.descrizione
	end as descrizionevoce

FROM paziente.preventivo as preventivo

	INNER JOIN paziente.paziente as paziente
		ON paziente.idpaziente = preventivo.idpaziente
	
	LEFT OUTER JOIN paziente.sottopreventivo as sottopreventivo
		ON sottopreventivo.idpreventivo = preventivo.idpreventivo
	
	LEFT OUTER JOIN paziente.vocesottopreventivo as vocesottopreventivo
		ON vocesottopreventivo.idsottopreventivo = sottopreventivo.idsottopreventivo

	LEFT OUTER JOIN (
        SELECT
            vocesottopreventivo.idvocesottopreventivo ,
            COUNT(*) AS numeronotevocesottopreventivo    
            
          FROM paziente.vocesottopreventivo AS vocesottopreventivo  
          
            INNER JOIN paziente.notavocesottopreventivo AS notavocesottopreventivo 
            	ON notavocesottopreventivo.idvocesottopreventivo = vocesottopreventivo.idvocesottopreventivo             
            	
         WHERE vocesottopreventivo.idsottopreventivo = %idsottopreventivo%
         GROUP BY vocesottopreventivo.idvocesottopreventivo
       
     ) AS notavocesottopreventivo	    
     ON notavocesottopreventivo.idvocesottopreventivo = vocesottopreventivo.idvocesottopreventivo		
	
	INNER JOIN paziente.vocelistino as vocelistino
		ON  vocelistino.idlistino = paziente.idlistino
		
	INNER JOIN paziente.voce as voce
		ON  voce.idvoce = vocelistino.idvocelistino
		AND voce.codice = vocesottopreventivo.codicevocelistino
	
WHERE paziente.idpaziente = %idpaziente%
  AND preventivo.idpreventivo = %idpreventivo%
  AND sottopreventivo.idsottopreventivo = %idsottopreventivo%
  AND vocesottopreventivo.nomeform = '%nomeform%'
  AND vocesottopreventivo.stato = '00'
  
ORDER BY vocesottopreventivo.nomeform, vocesottopreventivo.nomecampoform  
