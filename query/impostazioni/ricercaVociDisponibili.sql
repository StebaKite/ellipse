SELECT 
	voce.idvoce,
	voce.codice,
	voce.descrizione,
	voce.prezzo
	
  FROM paziente.voce as voce
  
 WHERE NOT EXISTS
 
 	( SELECT idvoce
 	    FROM paziente.vocelistino as vocelistino
 	   WHERE vocelistino.idlistino = %idlistino%
 	     AND vocelistino.idvocelistino = voce.idvoce ) 
 	     
ORDER BY voce.codice