select
	vocesottopreventivo.idvocesottopreventivo ,
	vocesottopreventivo.codicevocelistino ,
	case
		when vocesottopreventivo.descrizione is null then voce.descrizione
		when vocesottopreventivo.descrizione is not null then vocesottopreventivo.descrizione
	end as descrizione ,
	voce.descrizione as descrizionevocelistino ,
	vocesottopreventivo.prezzo ,
	vocesottopreventivo.stato
	
	FROM paziente.vocesottopreventivo AS vocesottopreventivo
	
		inner join paziente.voce as voce
			on voce.codice = vocesottopreventivo.codicevocelistino

where vocesottopreventivo.idvocesottopreventivo = %idvocesottopreventivo%
