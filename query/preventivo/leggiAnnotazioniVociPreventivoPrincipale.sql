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
		
			vocepreventivo.codicevocelistino,
			substring(vocepreventivo.nomecampoform, position(';' in vocepreventivo.nomecampoform) + 1) as nomecampoform,
			vocepreventivo.descrizione,
			notavocepreventivo.nota			
			
		  from paziente.vocepreventivo as vocepreventivo
		  
		  		inner join paziente.notavocepreventivo as notavocepreventivo
		  			on notavocepreventivo.idvocepreventivo = vocepreventivo.idvocepreventivo
		  		
		  where vocepreventivo.idpreventivo = %idpreventivo%
		    and nomeform in ('singoli', 'gruppi')
		) as T1
		
		left outer join paziente.voce as voce
			on voce.codice = T1.codicevocelistino
			
order by dente		