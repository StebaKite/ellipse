select

	T1.codicevocelistino,
	case
		when T1.descrizione is null then voce.descrizione
		when T1.descrizione is not null then T1.descrizione
	end as descrizionevoce,
	substring(T1.nomecampoform, position('_' in T1.nomecampoform) + 1, 2) as dente,
	T1.nota
	
  from (
		select 
		
			vocesottopreventivo.codicevocelistino,
			substring(vocesottopreventivo.nomecampoform, position(';' in vocesottopreventivo.nomecampoform) + 1) as nomecampoform,
			vocesottopreventivo.descrizione,
			notavocesottopreventivo.nota			
			
		  from paziente.vocesottopreventivo as vocesottopreventivo
		  
		  		inner join paziente.notavocesottopreventivo as notavocesottopreventivo
		  			on notavocesottopreventivo.idvocesottopreventivo = vocesottopreventivo.idvocesottopreventivo
		  		
		  where vocesottopreventivo.idsottopreventivo = %idsottopreventivo%
		    and nomeform in ('singoli', 'gruppi')
		) as T1
		
		left outer join paziente.voce as voce
			on voce.codice = T1.codicevocelistino
			
order by dente		