SELECT
	vocepreventivo.idvocepreventivo ,
	vocepreventivo.codicevocelistino ,
	case
		when vocepreventivo.descrizione is null then voce.descrizione
		when vocepreventivo.descrizione is not null then vocepreventivo.descrizione
	end as descrizione ,
	voce.descrizione as descrizionevocelistino ,
	vocepreventivo.prezzo ,
	vocepreventivo.stato
	
	FROM paziente.vocepreventivo AS vocepreventivo
	
		inner join paziente.voce as voce
			on voce.codice = vocepreventivo.codicevocelistino

WHERE vocepreventivo.idvocepreventivo = %idvocepreventivo%
