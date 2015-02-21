select coalesce(sum(ratasottopreventivo.importo), 0) as totale
  from paziente.ratasottopreventivo as ratasottopreventivo
  
  		inner join paziente.sottopreventivo as sottopreventivo
  			on sottopreventivo.idsottopreventivo = ratasottopreventivo.idsottopreventivo
  			
  where sottopreventivo.idsottopreventivo = %idsottopreventivo%
    and ratasottopreventivo.stato = '%stato%'
    
union

select coalesce(sum(accontosottopreventivo.importo), 0) as totale
  from paziente.accontosottopreventivo as accontosottopreventivo
  
  		inner join paziente.sottopreventivo as sottopreventivo
  			on sottopreventivo.idsottopreventivo = accontosottopreventivo.idsottopreventivo
  			
  where sottopreventivo.idsottopreventivo = %idsottopreventivo%
    and accontosottopreventivo.stato = '%stato%'

