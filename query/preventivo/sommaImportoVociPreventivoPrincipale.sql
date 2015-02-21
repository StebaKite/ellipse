select coalesce(sum(rata.importo), 0) as totale
  from paziente.rata as rata
  
  		inner join paziente.preventivo as preventivo
  			on preventivo.idpreventivo = rata.idpreventivo
  			
  where preventivo.idpreventivo = %idpreventivo%
    and rata.stato = '%stato%'
    
union

select coalesce(sum(acconto.importo), 0) as totale
  from paziente.acconto as acconto
  
  		inner join paziente.preventivo as preventivo
  			on preventivo.idpreventivo = acconto.idpreventivo
  			
  where preventivo.idpreventivo = %idpreventivo%
    and acconto.stato = '%stato%'

